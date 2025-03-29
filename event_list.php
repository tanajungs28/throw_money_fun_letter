<?php
session_start();
require_once('funcs.php');
loginCheck();

$pdo = localdb_conn();
$admin_id = $_SESSION['id'];

$stmt = $pdo->prepare("
    SELECT 
        event_list.id, event_list.event_name, event_list.event_day, event_list.twitter_post, event_list.hashtag, idol_list_table.group_name
    FROM 
        event_list
    JOIN 
        idol_list_table ON event_list.group_id = idol_list_table.id
    JOIN 
        admin_groups ON idol_list_table.id = admin_groups.group_id
    WHERE 
        admin_groups.user_id = :admin_id
    ORDER BY 
        event_list.event_day DESC
");
$stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>イベント一覧</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_event.css">
</head>
<body>

<header>
    <div class="title_area">
      <div class="title">LiveEcho</div>
      <nav class="nav">
        <a href="dashboard.php" class = "header_link">ダッシュボード</a>
        <a href="event_list.php" class = "active">イベント管理</a>
        <a href="member_list.php" class="header_link">メンバー管理</a>
        <div class="user_reg_area">
          <?php if (isset($_SESSION['name'])): ?>
            <span class="username"><?= h($_SESSION['name']) ?> さん</span>
            <a class="logout_btn" href="./logout.php">ログアウト</a>
          <?php endif; ?>
        </div>
      </nav>
    </div>
  </header>

<div class="container">
  <h1>登録済みイベント</h1>

  <?php if (empty($events)): ?>
    <p>現在、登録されているイベントはありません。</p>
  <?php else: ?>
    <?php foreach ($events as $event): ?>
      <?php
        $event_id = $event['id'];
        $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM event_members WHERE event_id = :event_id");
        $check_stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $check_stmt->execute();
        $member_count = $check_stmt->fetchColumn();
      ?>
      <div class="event-card">
        <div class="event-title"><?= h($event['event_name']) ?></div>
        <div class="event-meta">
          [<?= h($event['group_name']) ?>] / <?= h($event['event_day']) ?> / 
          <?php if ($event['twitter_post'] == 1): ?>
            <span class="x-status on">X連携あり / #<?= h($event['hashtag']) ?></span>
          <?php else: ?>
            <span class="x-status off">X連携なし</span>
          <?php endif; ?>
        </div>
        <div class="event-actions">
          <a href="event_update.php?id=<?= h($event['id']) ?>" class="btn-edit">編集</a>
          <a href="event_delete.php?id=<?= h($event['id']) ?>" class="btn-delete" onclick="return confirm('本当に削除してよろしいですか？');">削除</a>

          <?php if ($member_count > 0): ?>
            <a href="event_member_list.php?event_id=<?= h($event['id']) ?>" class="btn-primary">参加メンバー一覧</a>
          <?php else: ?>
            <a href="event_member_select.php?event_id=<?= h($event['id']) ?>" class="btn-primary">メンバー登録</a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <a href="event_register.php" class="btn-add">＋ イベントを登録する</a>
</div>

<footer>
    <div class="footer_title">LiveEcho</div>
    <div class="footer_menu">
        <a class="footerlink" href="./dashboard.php">ダッシュボード</a>
        <a class="footerlink" href="./event_list.php">イベント管理</a>
        <a class="footerlink" href="./member_list.php">メンバー管理</a>
        <a class="footerlink" href="./message_list.php">メッセージ管理</a>
        <a class="footerlink" href="./logout.php">ログアウト</a>
    </div>
</footer>

</body>
</html>
