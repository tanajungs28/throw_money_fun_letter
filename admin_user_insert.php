<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once('funcs.php');
loginCheck(); // ログインチェック

// 管理者以外はアクセス禁止
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

// POSTデータ受け取り
$lid  = $_POST['lid'] ?? '';
$lpw  = $_POST['lpw'] ?? '';
$name = $_POST['name'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$gender = $_POST['gender'] ?? '';
$kanri_flg = $_POST['kanri_flg'] ?? 0;
$role = $_POST['role'] ?? 0;

if ($lid === '' || $lpw === '' || $name === '') {
    exit('未入力の項目があります');
}

// DB接続
$pdo = localdb_conn();

// SQL作成
$stmt = $pdo->prepare("
    INSERT INTO user_list_table (lid, lpw, name, birthday, gender,kanri_flg, role,created_at)
    VALUES (:lid, :lpw, :name, :birthday, :gender,:kanri_flg, :role, NOW())
");

$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); // パスワードをそのまま保存していますが、後ほどハッシュ化推奨
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
$stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT);
$stmt->bindValue(':role', $role, PDO::PARAM_INT);

// 実行
$status = $stmt->execute();

// 処理結果によってリダイレクト or エラー表示
if ($status === false) {
    $error = $stmt->errorInfo();
    exit("登録失敗: " . $error[2]);
} else {
    header('Location: admin_user_list.php');
    exit();
}
