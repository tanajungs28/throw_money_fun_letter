<?php

// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once('funcs.php');
loginCheck();

$pdo = localdb_conn();

// 入力チェック
if (!isset($_POST['event_id']) || !is_numeric($_POST['event_id'])) {
    exit('不正なアクセスです（event_id）');
}
if (!isset($_POST['members']) || !is_array($_POST['members'])) {
    exit('メンバー情報が不正です');
}

$event_id = (int)$_POST['event_id'];
$members = $_POST['members'];

// 既存メンバー削除（編集にも対応させる場合）
// $delete_stmt = $pdo->prepare("DELETE FROM event_members WHERE event_id = :event_id");
// $delete_stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
// $delete_stmt->execute();


// すでに登録されているメンバーID一覧を取得
$stmt = $pdo->prepare("SELECT member_id FROM event_members WHERE event_id = :event_id");
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$existing_members = $stmt->fetchAll(PDO::FETCH_COLUMN); // member_idだけ配列に

// foreach ($members as $member_id => $data) {
//     if (!isset($data['join'])) continue;

//     $message = $data['message'] ?? '';
//     $stmt = $pdo->prepare("INSERT INTO event_members (event_id, member_id, message) VALUES (:event_id, :member_id, :message)");
//     $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
//     $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
//     $stmt->bindValue(':message', $message, PDO::PARAM_STR);
//     $stmt->execute();
// }

foreach ($members as $member_id => $data) {
    if (!isset($data['join'])) continue; // チェックされていない場合スキップ

    // すでに登録されていたらスキップ
    if (in_array($member_id, $existing_members)) {
        continue;
    }

    // 新しいメンバーだけを追加
    $message = $data['message'] ?? '';
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO event_members (event_id, member_id, message, created_at, updated_at) VALUES (:event_id, :member_id, :message, :created_at, :updated_at)");
    $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);
    $stmt->bindValue(':created_at', $created_at, PDO::PARAM_STR);
    $stmt->bindValue(':updated_at', $created_at, PDO::PARAM_STR);
    $stmt->execute();
}

// header("Location: event_list.php");
// 完了後に一覧へ戻る
header("Location: event_member_list.php?event_id=" . $event_id);
exit();
