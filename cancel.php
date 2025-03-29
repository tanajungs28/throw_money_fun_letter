<?php
session_start();
require_once('funcs.php');
$pdo = localdb_conn(); // ローカル環境

// 必要なIDをセッションから取得
$member_id = $_SESSION['member_id'] ?? null;
$event_id = $_SESSION['event_id'] ?? null;

// 不正アクセス対策：どちらかがない場合はトップページなどに逃がす
if (!$member_id || !$event_id) {
    header("Location: index.php");
    exit("メンバーIDまたはイベントIDが不足しています");
}

// letter_id が存在すれば削除
if (isset($_SESSION['letter_id'])) {
    $letter_id = $_SESSION['letter_id'];

    // 一時保存されたファンレター（未決済のもの）を削除
    $stmt = $pdo->prepare("DELETE FROM letter_list WHERE id = ? AND release_status = 'pending'");
    $status = $stmt->execute([$letter_id]);

    unset($_SESSION['letter_id']);
}

// エラーハンドリング
if (isset($status) && $status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
}

// letter_send.php に安全に戻す
header("Location: letter_send.php?member_id={$member_id}&event_id={$event_id}");
exit();
?>
