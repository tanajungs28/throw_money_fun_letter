<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();

$member_id = $_GET['id'] ?? null;
if (!$member_id) {
    exit('メンバーIDが指定されていません。');
}

// 削除処理
$stmt = $pdo->prepare("DELETE FROM member_list WHERE id = :id");
$stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    header("Location: member_list.php");
    exit();
} else {
    exit('削除に失敗しました。');
}
