<?php 
//funcs.phpに記載している共通関数を呼び出し
require_once('funcs.php');

//1. POSTデータ取得
$message = $_POST['message'];
$member_id = $_POST['member_id'];
$amount = $_POST['amount'];
$status = $_POST['status'];

session_start();
  $_SESSION['amount'] = $amount; // スライダーの値を更新
  $user_id = $_SESSION['id'];

if (!$message || !$amount || !$status || !$member_id) {
  echo json_encode(['success' => false, 'message' => '入力が不足しています']);
  exit;
}


//2.  DB接続します
$pdo = localdb_conn(); //ローカル環境


//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare(
                    "INSERT INTO 
                      letter_list(
                      id, user_id, member_id, message, amount, status, created_at
                      ) 
                      VALUES(
                      NULL, :user_id, :member_id, :message, :amount, :status, NOW()
                      );"
                      );

//  2. バインド変数を用意(セキュリティ対策で変数を1個かませる)
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':member_id', $member_id, PDO::PARAM_STR);
$stmt->bindValue(':message', $message, PDO::PARAM_STR);
$stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
$stmt->bindValue(':status', $status, PDO::PARAM_STR);


//  3. 実行
$status = $stmt->execute();


//４．データ登録処理後
// if($status === false){
//     //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
//     $error = $stmt->errorInfo();
//     exit('ErrorMessage:'.$error[2]);
//   }else{
//     //５．comment_list.phpへリダイレクト
//     header('Location: letter_send.php?member_id=' . urlencode($member_id));
//   exit;
//   }

// 5. 処理結果をJSON形式で返す
if ($status === false) {
  // SQL実行時にエラーがある場合
  $error = $stmt->errorInfo();
  echo json_encode(['success' => false, 'message' => 'データベースエラー: ' . $error[2]]);
  exit;
} else {
  // データ登録が成功した場合、決済ページに遷移するための情報を返す
  echo json_encode([
      'success' => true,
      'message' => 'ファンレターが送信されました',
      'redirect_url' => 'checkout.php?amount=' . urlencode($amount) // 決済ページのURL
  ]);
  header('Location: checkout.php?amount=' . $amount);
  exit;
}
?>