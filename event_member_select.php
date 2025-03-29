<?php
session_start();
require_once('funcs.php');
loginCheck();

$pdo = localdb_conn();
$event_id = $_GET['event_id'] ?? null;
$admin_id = $_SESSION['id'];

if (!$event_id) {
    exit('イベントIDが指定されていません');
}

// イベントに紐づくグループID取得
$stmt = $pdo->prepare("SELECT group_id, event_name FROM event_list WHERE id = :event_id");
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event_info = $stmt->fetch(PDO::FETCH_ASSOC);
$group_id = $event_info['group_id'];
$event_name = $event_info['event_name'];

// グループのメンバー一覧取得
$member_stmt = $pdo->prepare("SELECT * FROM member_list WHERE group_id = :group_id");
$member_stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
$member_stmt->execute();
$members = $member_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>イベントメンバー選択 | LiveEcho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_member_update.css">
</head>
<body>

<!-- ヘッダー -->
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

<main>
  <div class="wrapper">
    <h1>「<?= h($event_name) ?>」<br>参加メンバーの選択と意気込みコメント</h1>

    <form action="event_member_insert.php" method="post">
      <input type="hidden" name="event_id" value="<?= h($event_id) ?>">

      <?php foreach ($members as $member): ?>
        <div class="form-block">
          <label class="checkbox-label">
            <input type="checkbox" name="members[<?= h($member['id']) ?>][join]" value="1">
            <?= h($member['member_name']) ?>
          </label>
          <textarea name="members[<?= h($member['id']) ?>][message]" rows="2" placeholder="意気込みコメントを入力"></textarea>
        </div>
      <?php endforeach; ?>

      <input type="submit" value="登録する">
      <a href="event_list.php" class="back-link">← イベント一覧へ戻る</a>
    </form>
  </div>
</main>

<!-- フッター -->
<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="./dashboard.php">ダッシュボード</a>
    <a class="footerlink" href="./event_list.php">イベント管理</a>
    <a class="footerlink" href="./member_list.php">メンバー管理</a>
    <a class="footerlink" href="./logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
