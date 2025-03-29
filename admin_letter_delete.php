<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者のみ許可
if ($_SESSION['kanri_flg'] != 99) {
    exit('アクセス権限がありません');
}

$pdo = localdb_conn();
$letter_id = $_POST['letter_id'] ?? null;

if (!$letter_id) {
    exit('ファンレターIDが指定されていません。');
}

$stmt = $pdo->prepare("DELETE FROM letter_list WHERE id = :id");
$stmt->bindValue(':id', $letter_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    header("Location: admin_letter_list.php");
    exit();
} else {
    $error = $stmt->errorInfo();
    exit('削除エラー: ' . $error[2]);
}
