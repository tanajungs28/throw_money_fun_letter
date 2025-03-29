<?php
session_start();
require_once('funcs.php');
loginCheck();

// 管理者以外はアクセス禁止
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

// GETでイベントIDを取得
$event_id = $_GET['id'] ?? null;

if (!$event_id) {
    exit('イベントIDが指定されていません');
}

// DB接続
$pdo = localdb_conn();

// イベント削除（関連するevent_membersも削除しておく）
try {
    $pdo->beginTransaction();

    // 参加メンバーの紐づけを先に削除
    $stmt1 = $pdo->prepare("DELETE FROM event_members WHERE event_id = :event_id");
    $stmt1->bindValue(':event_id', $event_id, PDO::PARAM_INT);
    $stmt1->execute();

    // イベント自体を削除
    $stmt2 = $pdo->prepare("DELETE FROM event_list WHERE id = :event_id");
    $stmt2->bindValue(':event_id', $event_id, PDO::PARAM_INT);
    $stmt2->execute();

    $pdo->commit();

    // 完了後リダイレクト
    header("Location: admin_event_list.php");
    exit();

} catch (PDOException $e) {
    $pdo->rollBack();
    exit("削除エラー: " . $e->getMessage());
}
