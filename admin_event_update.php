<?php
session_start();
require_once('funcs.php');
loginCheck();

// 管理者権限チェック
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

$pdo = localdb_conn();

// POSTで送られてきたデータを取得
$event_id = $_POST['id'] ?? '';
$event_name = $_POST['event_name'] ?? '';
$event_day = $_POST['event_day'] ?? '';
$hashtag = $_POST['hashtag'] ?? '';
$twitter_post = isset($_POST['twitter_post']) ? 1 : 0;

if (!$event_id || !$event_name || !$event_day || !$hashtag) {
    exit('必要な情報が不足しています');
}

// 更新SQLの準備
$stmt = $pdo->prepare("
    UPDATE event_list 
    SET event_name = :event_name,
        event_day = :event_day,
        hashtag = :hashtag,
        twitter_post = :twitter_post
    WHERE id = :id
");

// バインド
$stmt->bindValue(':id', $event_id, PDO::PARAM_INT);
$stmt->bindValue(':event_name', $event_name, PDO::PARAM_STR);
$stmt->bindValue(':event_day', $event_day, PDO::PARAM_STR);
$stmt->bindValue(':hashtag', $hashtag, PDO::PARAM_STR);
$stmt->bindValue(':twitter_post', $twitter_post, PDO::PARAM_INT);

// 実行
$status = $stmt->execute();

if ($status) {
    header("Location: admin_event_list.php");
    exit();
} else {
    $error = $stmt->errorInfo();
    exit("イベント更新エラー: " . print_r($error, true));
}
