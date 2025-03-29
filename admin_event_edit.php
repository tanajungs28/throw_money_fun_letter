<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者チェック
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

$pdo = localdb_conn();

$event_id = $_GET['id'] ?? '';
if (!$event_id) {
    exit('イベントIDが指定されていません');
}

// イベント情報を取得
$stmt = $pdo->prepare("SELECT * FROM event_list WHERE id = :id");
$stmt->bindValue(':id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    exit('イベントが見つかりません');
}

// グループ名取得（表示用）
$group_stmt = $pdo->prepare("SELECT group_name FROM idol_list_table WHERE id = :group_id");
$group_stmt->bindValue(':group_id', $event['group_id'], PDO::PARAM_INT);
$group_stmt->execute();
$group_name = $group_stmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>イベント編集</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_admin.css">
    <link rel="stylesheet" href="css/style_admin_event_edit.css">
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
  <h1>イベント情報の編集</h1>

  <form action="admin_event_update.php" method="post" class="form">
    <input type="hidden" name="id" value="<?= h($event_id) ?>">

    <div class="form-item">
      <label>グループ名</label>
      <p><?= h($group_name) ?></p>
    </div>

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

    <button type="submit" class="btn-primary">更新する</button>
    <a href="admin_event_list.php" class="btn-secondary">戻る</a>
  </form>
</div>

<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="admin_dashboard.php">管理TOP</a>
    <a class="footerlink" href="admin_event_list.php">イベント一覧</a>
    <a class="footerlink" href="logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
