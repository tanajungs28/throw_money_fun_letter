<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();

$event_member_id = $_GET['id'] ?? null;
$event_id = $_GET['event_id'] ?? null;

if (!$event_member_id || !$event_id) {
    exit("不正なアクセスです");
}

$stmt = $pdo->prepare("DELETE FROM event_members WHERE id = :id");
$stmt->bindValue(':id', $event_member_id, PDO::PARAM_INT);
$stmt->execute();

header("Location: event_member_list.php?event_id=" . $event_id);
exit();
