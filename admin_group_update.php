<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者以外アクセス不可
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

// POSTデータ受け取り
$id = $_POST['id'] ?? '';
$group_name = $_POST['group_name'] ?? '';

if (!$id || !$group_name) {
    exit('グループIDまたはグループ名が入力されていません。');
}

// DB接続
$pdo = localdb_conn();

// UPDATE処理
$stmt = $pdo->prepare("UPDATE idol_list_table SET group_name = :group_name WHERE id = :id");
$stmt->bindValue(':group_name', $group_name, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 実行後の処理
if ($status) {
    header("Location: admin_group_list.php");
    exit();
} else {
    $error = $stmt->errorInfo();
    exit("更新エラー: " . $error[2]);
}
