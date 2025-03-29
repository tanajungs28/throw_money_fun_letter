<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once('funcs.php');
loginCheck();

// システム管理者チェック
if ($_SESSION['kanri_flg'] != 99) {
    exit('アクセス権限がありません');
}

$pdo = localdb_conn();

// POSTデータ受け取り
$event_id = $_POST['event_id'] ?? null;
$members = $_POST['members'] ?? [];

if (!$event_id || empty($members)) {
    exit('イベントIDまたはメンバー情報が不足しています');
}

foreach ($members as $member_id => $data) {
    if (isset($data['join']) && $data['join'] == 1) {
        $message = $data['message'] ?? '';

        // DBへINSERT
        $stmt = $pdo->prepare("
            INSERT INTO event_members (
                event_id, member_id, message, created_at, updated_at
            ) VALUES (
                :event_id, :member_id, :message, NOW(), NOW()
            )
        ");
        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt->execute();
    }
}

// 完了後、イベントメンバー一覧画面にリダイレクト
header("Location: admin_event_member_list.php?event_id=" . $event_id);
exit();
