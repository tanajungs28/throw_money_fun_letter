<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();

$id = $_POST['id'];
$message = $_POST['message'];
$event_id = $_POST['event_id'];

$stmt = $pdo->prepare("UPDATE event_members SET message = :message WHERE id = :id");
$stmt->bindValue(':message', $message, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header("Location: event_member_list.php?event_id=" . $event_id);
exit();
