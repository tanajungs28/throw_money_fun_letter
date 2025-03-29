<?php
session_start();
require_once('funcs.php');
loginCheck();

// 管理者以外はアクセス不可
if ($_SESSION['kanri_flg'] != 99) {
    exit('アクセス権限がありません。');
}

$pdo = localdb_conn();

$event_id = $_GET['event_id'] ?? null;
if (!$event_id) {
    exit('イベントIDが指定されていません');
}

// イベントに紐づくグループIDを取得
$stmt = $pdo->prepare("SELECT group_id, event_name FROM event_list WHERE id = :event_id");
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event_info = $stmt->fetch(PDO::FETCH_ASSOC);
$group_id = $event_info['group_id'];
$event_name = $event_info['event_name'];

// イベントに未参加のメンバー取得
$sql = "
    SELECT *
    FROM member_list
    WHERE group_id = :group_id
    AND id NOT IN (
        SELECT member_id FROM event_members WHERE event_id = :event_id
    )
";
$member_stmt = $pdo->prepare($sql);
$member_stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
$member_stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$member_stmt->execute();
$members = $member_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>メンバー追加 - <?= h($event_name) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
  <link rel="stylesheet" href="css/style_admin_event_member_list.css">
</head>
<body>

<header>
  <div class="title_area">
    <div class="title">LiveEcho 管理者ダッシュボード</div>
    <div class="user_reg_area">
      <?= h($_SESSION['name']) ?> さん
      <a class="logout_btn" href="logout.php">ログアウト</a>
    </div>
  </div>
</header>

<div class="container">
  <h1><?= h($event_name) ?> - メンバー追加</h1>

  <?php if (empty($members)): ?>
    <p>追加可能なメンバーは存在しません。</p>
  <?php else: ?>
    <form action="admin_event_member_insert.php" method="post">
      <?php foreach ($members as $member): ?>
        <div class="member-card">
          <label>
            <input type="checkbox" name="members[<?= h($member['id']) ?>][join]" value="1">
            <?= h($member['member_name']) ?>
          </label>
          <br>
          <textarea name="members[<?= h($member['id']) ?>][message]" placeholder="意気込みコメント" rows="2" cols="40"></textarea>
        </div>
      <?php endforeach; ?>

      <input type="hidden" name="event_id" value="<?= h($event_id) ?>">
      <button type="submit" class="btn-add">追加する</button>
      <a href="admin_event_member_list.php?event_id=<?= h($event_id) ?>" class="btn-secondary">戻る</a>
    </form>
  <?php endif; ?>
</div>

<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="admin_dashboard.php">管理者TOP</a>
    <a class="footerlink" href="admin_event_list.php">イベント管理</a>
    <a class="footerlink" href="logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
