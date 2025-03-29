<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者以外はアクセス不可
if ($_SESSION['kanri_flg'] != 99) {
    exit('アクセス権限がありません');
}

$pdo = localdb_conn();

// POSTデータの受け取りとバリデーション
$id = $_POST['id'] ?? null;
$event_id = $_POST['event_id'] ?? null;
$message = $_POST['message'] ?? '';

if (!$id || !$event_id || !$message) {
    exit('必要な情報が不足しています');
}

// メッセージ更新処理
$stmt = $pdo->prepare("UPDATE event_members SET message = :message WHERE id = :id");
$stmt->bindValue(':message', $message, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

if ($status === false) {
    $error = $stmt->errorInfo();
    exit("DB更新エラー: " . $error[2]);
} else {
    // 編集後のリストに戻る
    header("Location: admin_event_member_list.php?event_id=" . urlencode($event_id));
    exit();
}
