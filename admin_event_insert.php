<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者のみアクセス可能
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

$group_id     = $_POST['group_id'] ?? '';
$event_name   = $_POST['event_name'] ?? '';
$event_day    = $_POST['event_day'] ?? '';
$hashtag      = $_POST['hashtag'] ?? '';
$twitter_post = isset($_POST['twitter_post']) ? 1 : 0;

if (!$group_id || !$event_name || !$event_day || !$hashtag) {
    exit('入力項目が不足しています');
}

$pdo = localdb_conn();

// イベント登録SQL
$sql = "INSERT INTO event_list (
            group_id, event_name, event_day, hashtag, twitter_post, created_at
        ) VALUES (
            :group_id, :event_name, :event_day, :hashtag, :twitter_post, NOW()
        )";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
$stmt->bindValue(':event_name', $event_name, PDO::PARAM_STR);
$stmt->bindValue(':event_day', $event_day, PDO::PARAM_STR);
$stmt->bindValue(':hashtag', $hashtag, PDO::PARAM_STR);
$stmt->bindValue(':twitter_post', $twitter_post, PDO::PARAM_INT);

$status = $stmt->execute();

if ($status === false) {
    $error = $stmt->errorInfo();
    exit("SQLエラー: " . $error[2]);
} else {
    header("Location: admin_event_list.php");
    exit();
}
