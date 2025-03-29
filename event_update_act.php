<?php
session_start();
require_once('funcs.php');
loginCheck();

$pdo = localdb_conn();

// 受け取り
$id = $_POST['id'];
$event_name = $_POST['event_name'];
$event_day = $_POST['event_day'];
$hashtag = $_POST['hashtag'];
$twitter_post = isset($_POST['twitter_post']) ? 1 : 0;

$stmt = $pdo->prepare("
  UPDATE event_list 
  SET event_name = :event_name,
      event_day = :event_day,
      hashtag = :hashtag,
      twitter_post = :twitter_post
  WHERE id = :id
");

$stmt->bindValue(':event_name', $event_name, PDO::PARAM_STR);
$stmt->bindValue(':event_day', $event_day, PDO::PARAM_STR);
$stmt->bindValue(':hashtag', $hashtag, PDO::PARAM_STR);
$stmt->bindValue(':twitter_post', $twitter_post, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location: event_list.php');
exit();
