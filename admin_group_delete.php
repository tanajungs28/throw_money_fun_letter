<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者以外アクセス禁止
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

// GETで受け取るグループID
$group_id = $_GET['id'] ?? '';

if (!$group_id) {
    exit('グループIDが指定されていません。');
}

// DB接続
$pdo = localdb_conn();

// グループ削除（外部キー制約がある場合は要注意）
$stmt = $pdo->prepare("DELETE FROM idol_list_table WHERE id = :id");
$stmt->bindValue(':id', $group_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    header('Location: admin_group_list.php');
    exit();
} else {
    $error = $stmt->errorInfo();
    exit('削除エラー: ' . $error[2]);
}
