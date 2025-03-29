<?php
session_start();
require_once('funcs.php');
loginCheck();

// 管理者権限チェック
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

// パラメータ取得
$id = $_GET['id'] ?? null;
$event_id = $_GET['event_id'] ?? null;

if (!$id || !$event_id) {
    exit('パラメータが不足しています');
}

$pdo = localdb_conn();

// 削除処理
$stmt = $pdo->prepare("DELETE FROM event_members WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status === false) {
    $error = $stmt->errorInfo();
    exit("削除エラー: " . $error[2]);
} else {
    // 削除完了後、イベントメンバー一覧に戻る
    header("Location: admin_event_member_list.php?event_id=" . urlencode($event_id));
    exit();
}
