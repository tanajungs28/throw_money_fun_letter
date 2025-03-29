<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者以外アクセス不可
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

// GETでユーザーIDを受け取る
$id = $_GET['id'] ?? null;

if (!$id) {
    exit('ユーザーIDが指定されていません。');
}

$pdo = localdb_conn();

try {
    // ユーザー削除処理
    $stmt = $pdo->prepare("DELETE FROM user_list_table WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status) {
        header("Location: admin_user_list.php");
        exit();
    } else {
        $error = $stmt->errorInfo();
        exit("削除失敗: " . $error[2]);
    }
} catch (PDOException $e) {
    exit('DBエラー: ' . $e->getMessage());
}
?>
