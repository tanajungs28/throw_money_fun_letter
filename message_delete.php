<?php
session_start();
require_once('funcs.php');
loginCheck();

if ($_SESSION['kanri_flg'] != 1) {
    exit('アクセス権限がありません');
}

$pdo = localdb_conn();

// POSTされたIDを取得
$letter_id = $_POST['letter_id'] ?? null;

if (!$letter_id) {
    exit('メッセージIDが指定されていません。');
}

// 安全に削除処理を行う
$stmt = $pdo->prepare("DELETE FROM letter_list WHERE id = :id");
$stmt->bindValue(':id', $letter_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    header("Location: message_list.php");
    exit();
} else {
    $error = $stmt->errorInfo();
    exit('削除エラー: ' . $error[2]);
}
