<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者のみ許可
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません');
}

$pdo = localdb_conn();

// POSTデータ取得
$user_id = $_POST['user_id'] ?? null;
$group_ids = $_POST['group_ids'] ?? [];

if (!$user_id || !is_array($group_ids)) {
    exit('不正なアクセスです');
}

// 既存の紐づけを全削除（リセット）
$delete_stmt = $pdo->prepare("DELETE FROM admin_groups WHERE user_id = :user_id");
$delete_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$delete_stmt->execute();

// 新しい紐づけを追加
$insert_stmt = $pdo->prepare("INSERT INTO admin_groups (user_id, group_id) VALUES (:user_id, :group_id)");
foreach ($group_ids as $group_id) {
    $insert_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $insert_stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $insert_stmt->execute();
}

// 完了後にユーザーリストへ戻す
header("Location: admin_user_list.php");
exit();
?>
