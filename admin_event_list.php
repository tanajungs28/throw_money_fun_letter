<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者かチェック
if ($_SESSION['kanri_flg'] != 99) {
    exit('アクセス権限がありません');
}

$pdo = localdb_conn();

// イベント一覧取得（グループ情報も含めて）
$stmt = $pdo->prepare("
    SELECT e.id, e.event_name, e.event_day, e.hashtag, e.twitter_post, g.group_name
    FROM event_list e
    JOIN idol_list_table g ON e.group_id = g.id
    ORDER BY e.event_day DESC
");
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset='UTF-8'>
    <title>イベント一覧（管理者）</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='css/reset.css'>
    <link rel='stylesheet' href='css/style_admin.css'>
    <link rel='stylesheet' href='css/style_admin_event_list.css'>
</head>
<body>
<header>
  <div class='title_area'>
    <div class='title'>LiveEcho 管理者ダッシュボード</div>
    <div class='user_reg_area'>
      <?= h($_SESSION['name']) ?> さん
      <a class='logout_btn' href='logout.php'>ログアウト</a>
    </div>
  </div>
</header>

<div class='container'>
  <h1>イベント管理</h1>
  <a href='admin_event_add.php' class='btn-add'>＋ 新しいイベントを登録</a>

  <?php if (empty($events)): ?>
    <p>登録されたイベントはまだありません。</p>
  <?php else: ?>
    <table class='event-table'>
      <thead>
        <tr>
          <th>グループ名</th>
          <th>イベント名</th>
          <th>開催日</th>
          <th>ハッシュタグ</th>
          <th>X連携</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($events as $event): ?>
          <tr>
            <td><?= h($event['group_name']) ?></td>
            <td><?= h($event['event_name']) ?></td>
            <td><?= h($event['event_day']) ?></td>
            <td>#<?= h($event['hashtag']) ?></td>
            <td><?= $event['twitter_post'] ? 'ON' : 'OFF' ?></td>
            <td class='action-btns'>
              <a href='admin_event_edit.php?id=<?= h($event['id']) ?>' class='edit'>編集</a>
              <a href='admin_event_delete.php?id=<?= h($event['id']) ?>' class='delete' onclick='return confirm("削除しますか？")'>削除</a>
              <a href='admin_event_member_list.php?event_id=<?= h($event['id']) ?>' class='member'>メンバー管理</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<footer>
  <div class='footer_title'>LiveEcho</div>
  <div class='footer_menu'>
    <a class='footerlink' href='admin_dashboard.php'>ダッシュボード</a>
    <a class='footerlink' href='admin_user_list.php'>ユーザー管理</a>
    <a class='footerlink' href='admin_group_list.php'>グループ管理</a>
    <a class='footerlink' href='admin_event_list.php'>イベント管理</a>
    <a class='footerlink' href='../logout.php'>ログアウト</a>
  </div>
</footer>
</body>
</html>
