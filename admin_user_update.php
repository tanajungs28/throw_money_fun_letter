<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者以外はアクセス不可
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

$pdo = localdb_conn();

// POSTデータ受け取り
$id = $_POST['id'] ?? null;
$lid = $_POST['lid'] ?? '';
$lpw = $_POST['lpw'] ?? '';
$name = $_POST['name'] ?? '';
$kanri_flg = $_POST['kanri_flg'] ?? 0;

if (!$id || !$lid || !$name) {
    exit('必須項目が不足しています。');
}

try {
    if ($lpw !== '') {
        // パスワード更新あり
        $stmt = $pdo->prepare("
            UPDATE user_list_table
            SET lid = :lid, lpw = :lpw, name = :name, kanri_flg = :kanri_flg
            WHERE id = :id
        ");
        $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
    } else {
        // パスワード更新なし
        $stmt = $pdo->prepare("
            UPDATE user_list_table
            SET lid = :lid, name = :name, kanri_flg = :kanri_flg
            WHERE id = :id
        ");
    }

    // 共通バインド
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $status = $stmt->execute();

    if ($status) {
        header('Location: admin_user_list.php');
        exit();
    } else {
        $error = $stmt->errorInfo();
        exit('更新エラー: ' . $error[2]);
    }
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>
