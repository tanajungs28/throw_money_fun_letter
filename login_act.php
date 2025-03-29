<?php
session_start();

// POSTデータ取得
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];
$member_id = $_POST['member_id'] ?? "";
$event_id = $_POST['event_id'] ?? "";

// DB接続
require_once('funcs.php');
$pdo = localdb_conn();

// SQL作成・実行
$stmt = $pdo->prepare('SELECT * FROM user_list_table WHERE lid = :lid AND lpw = :lpw;');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$status = $stmt->execute();

// 実行結果の取得
$val = $stmt->fetch();

if ($status === false) {
    sql_error($stmt);
}

// ログイン認証
if ($val && $val['id'] != '') {
    // セッションに値を保存
    $_SESSION['id'] = $val['id'];
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['name'] = $val['lid'];
    $_SESSION['kanri_flg'] = $val['kanri_flg'];

    // システム管理者の場合：システム管理者のダッシュボードへ
    if ($val['kanri_flg'] == 99) {
        header('Location: admin_dashboard.php');
        exit();
    
    // アイドル運営者の場合：アイドル運営のダッシュボードへ
    }elseif($val['kanri_flg'] == 1) {
        header('Location: dashboard.php');
        exit();
    }
    // 一般の方
    elseif($val['kanri_flg'] == 0){
    // ファンレター投稿からのログイン遷移
    if (!empty($member_id)) {
        header('Location: letter_send.php?member_id=' . $member_id. '&event_id=' . $event_id);
        exit();
    }else{
    // ファンレターからでなけれトップページへ（いずれ送信履歴やユーザ情報編集ページへ）
        header('Location: index.php');
    }
    }
} else {
    // 認証失敗
    header('Location: login.php');
    exit();
}
