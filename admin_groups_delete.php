<?php
session_start();
require_once('funcs.php');
loginCheck();

// 1. GETでidを受け取る
$id = $_GET['id'] ?? null;

if (!$id) {
    exit('IDが指定されていません。');
}

// 2. DB接続
$pdo = localdb_conn();

// 3. DELETE文を準備
$sql = 'DELETE FROM admin_groups WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

// 4. 実行
$status = $stmt->execute();

// 5. 処理結果に応じて遷移
if ($status === false) {
    sql_error($stmt); // funcs.php にあるエラーハンドラ
} else {
    // 削除成功後に一覧ページへリダイレクト
    header("Location: admin_management_list.php"); // 一覧ページのファイル名に合わせてください
    exit();
}
