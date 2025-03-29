<?php 
require_once('funcs.php');
session_start();

$pdo = localdb_conn(); // DB接続

// POSTデータ取得
$message = $_POST['message'] ?? '';
$member_id = $_POST['member_id'] ?? '';
$throw_switch = $_POST['throw_switch'] ?? 'off';
$amount = intval($_POST['amount'] ?? 0);
$status = $_POST['status'] ?? '';
$event_id = $_POST['event_id'] ?? '';

$_SESSION['amount'] = $amount;
$_SESSION['member_id'] = $member_id;
$_SESSION['message'] = $message;
$_SESSION['event_id'] = $event_id;
$user_id = $_SESSION['id'] ?? null;

if (!$message || !$status || !$member_id || !$event_id ) {
  exit('入力が不足しています');
}

// 投げ銭なし or 金額0 の場合
if ($throw_switch !== 'on' || $amount === 0) {

  $stmt = $pdo->prepare("
    INSERT INTO letter_list (
      id, user_id, member_id, event_id, message, amount, status, release_status, created_at
    ) VALUES (
      NULL, :user_id, :member_id, :event_id, :message, 0, :status, 'completed', NOW()
    )
  ");

  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
  $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
  $stmt->bindValue(':message', $message, PDO::PARAM_STR);
  $stmt->bindValue(':status', $status, PDO::PARAM_STR);

    // user_id が null なら PARAM_NULL を使うようにする
if ($user_id === null) {
  $stmt->bindValue(':user_id', null, PDO::PARAM_NULL);
} else {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
}

  $res = $stmt->execute();

  if ($res) {
    $letter_id = $pdo->lastInsertId();
    $_SESSION['letter_id'] = $letter_id;
    header("Location: success.php");
    exit();
  } else {
    $error = $stmt->errorInfo();
    exit('DBエラー（投げ銭なし）: ' . $error[2]);
  }

} else {

  // Stripe 決済あり
  $stmt = $pdo->prepare("
    INSERT INTO letter_list (
      id, user_id, member_id, event_id, message, amount, status, release_status, created_at
    ) VALUES (
      NULL, :user_id, :member_id, :event_id, :message, :amount, :status, 'pending', NOW()
    )
  ");

  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
  $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
  $stmt->bindValue(':message', $message, PDO::PARAM_STR);
  $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
  $stmt->bindValue(':status', $status, PDO::PARAM_STR);

  // user_id が null なら PARAM_NULL を使うようにする
  if ($user_id === null) {
    $stmt->bindValue(':user_id', null, PDO::PARAM_NULL);
  } else {
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  } 

  $res = $stmt->execute();

  if ($res) {
    $letter_id = $pdo->lastInsertId();
    $_SESSION['letter_id'] = $letter_id;
    header("Location: checkout.php?amount=" . urlencode($amount));
    exit();
  } else {
    $error = $stmt->errorInfo();
    exit('DBエラー（投げ銭あり）: ' . $error[2]);
  }
}
?>
