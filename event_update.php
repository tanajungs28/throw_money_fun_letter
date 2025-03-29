<?php
session_start();
require_once('funcs.php');
loginCheck();

$pdo = localdb_conn();
$event_id = $_GET['id'] ?? null;

if (!$event_id) exit('IDが指定されていません');

// 該当イベント取得
$stmt = $pdo->prepare("SELECT * FROM event_list WHERE id = :id");
$stmt->bindValue(':id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) exit('該当イベントが見つかりません');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>イベント編集</title>
  <link rel="stylesheet" href="css/reset.css">
  <!-- <link rel="stylesheet" href="css/style_profile.css"> -->
  <link rel="stylesheet" href="css/style_event_update.css">
</head>
<body>

  <header>
    <div class="title_area">
    <div class="title">LiveEcho イベント情報編集</div>
      <nav class="nav">
        <a href="dashboard.php" class = "header_link">ダッシュボード</a>
        <a href="event_list.php" class = "header_link">イベント管理</a>
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


  <div class="form-wrapper">
    <form action="event_update_act.php" method="post">
      <input type="hidden" name="id" value="<?= h($event['id']) ?>">

      <div class="form-item">
        <label>イベント名</label>
        <input type="text" name="event_name" value="<?= h($event['event_name']) ?>" required>
      </div>

      <div class="form-item">
        <label>開催日</label>
        <input type="date" name="event_day" value="<?= h($event['event_day']) ?>" required>
      </div>

      <div class="form-item">
        <label>ハッシュタグ</label>
        <input type="text" name="hashtag" value="<?= h($event['hashtag']) ?>" required>
      </div>

      <div class="form-item">
        <label>
          <input type="checkbox" name="twitter_post" value="1" <?= $event['twitter_post'] ? 'checked' : '' ?>>
          X（旧Twitter）へ自動投稿を許可する
        </label>
      </div>

      <div class="button-panel">
        <button type="submit" class="button">更新</button>
      </div>
    </form>
  </div>

  <footer>
  <div class="footer_title">LiveEcho</div>
    <div class="footer_menu">
      <a class="footerlink" href="./dashboard.php">ダッシュボード</a>
      <a class="footerlink" href="./event_list.php">イベント管理</a>
      <a class="footerlink" href="./member_list.php">メンバー管理</a>
      <a class="footerlink" href="./logout.php">ログアウト</a>
    </div>  </footer>
</body>
</html>
