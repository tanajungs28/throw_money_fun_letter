<?php
session_start();
require_once('funcs.php');
loginCheck();

$pdo = localdb_conn();

$id = $_GET['id'] ?? null;
if (!$id) exit("イベントIDが指定されていません");

$stmt = $pdo->prepare("DELETE FROM event_list WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    header("Location: event_list.php");
    exit();
} else {
    echo "削除に失敗しました";
    exit();
}
