<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者のみアクセス許可
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

$pdo = localdb_conn();

// アイドルグループ一覧を取得
$stmt = $pdo->prepare("SELECT id, group_name FROM idol_list_table ORDER BY created_at DESC");
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>イベント追加 - システム管理者</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
  <link rel="stylesheet" href="css/style_admin_event_list.css">
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
  <h1>新規イベント追加</h1>
  <form action="admin_event_insert.php" method="post" class="form">

    <div class="form-item">
      <label>アイドルグループ</label>
      <select name="group_id" required>
        <option value="">-- グループを選択 --</option>
        <?php foreach ($groups as $group): ?>
          <option value="<?= h($group['id']) ?>"><?= h($group['group_name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-item">
      <label>イベント名</label>
      <input type="text" name="event_name" required>
    </div>

    <div class="form-item">
      <label>開催日</label>
      <input type="date" name="event_day" required>
    </div>

    <div class="form-item">
      <label>ハッシュタグ</label>
      <input type="text" name="hashtag" placeholder="#イベント名など" required>
    </div>

    <div class="form-item">
      <label>
        <input type="checkbox" name="twitter_post" value="1" checked>
        X（旧Twitter）へ自動投稿を許可する
      </label>
    </div>

    <button type="submit" class="btn-primary">登録</button>
    <a href="admin_event_list.php" class="btn-secondary">キャンセル</a>
  </form>
</div>

<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="admin_dashboard.php">ダッシュボード</a>
    <a class="footerlink" href="admin_event_list.php">イベント管理</a>
    <a class="footerlink" href="logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
