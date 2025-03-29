<?php
session_start();
require_once('funcs.php');
loginCheck();

// 1. POSTでデータを受け取る
$id = $_POST['id'];
$admin_id = $_POST['admin_id'];
$idol_group_id = $_POST['idol_group_id'];

// 入力チェック（念のため）
if (!$id || !$admin_id || !$idol_group_id) {
    exit('パラメータが不正です。');
}

// 2. DB接続
$pdo = localdb_conn();

// 3. UPDATE文の作成
$sql = 'UPDATE admin_groups SET user_id = :admin_id, group_id = :idol_group_id WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
$stmt->bindValue(':idol_group_id', $idol_group_id, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

// 4. 実行
$status = $stmt->execute();

// 5. 処理結果に応じて遷移
if ($status === false) {
    sql_error($stmt);
} else {
    // 編集が完了したら一覧ページに戻る（リダイレクト）
    header("Location: admin_management_list.php"); // 一覧ページのファイル名に合わせてください
    exit();
}
?>
