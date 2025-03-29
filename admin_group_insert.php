<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once('funcs.php');
loginCheck();

// システム管理者以外アクセス不可
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

// POSTで受け取る
$group_name = $_POST['group_name'] ?? '';

// 未入力チェック
if (trim($group_name) === '') {
    exit('グループ名を入力してください。');
}

// DB接続
$pdo = localdb_conn();

// グループ追加処理
$stmt = $pdo->prepare("INSERT INTO idol_list_table (group_name, created_at) VALUES (:group_name, NOW())");
$stmt->bindValue(':group_name', $group_name, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status === false) {
    $error = $stmt->errorInfo();
    exit('グループ登録エラー: ' . $error[2]);
} else {
    header('Location: admin_group_list.php');
    exit();
}
