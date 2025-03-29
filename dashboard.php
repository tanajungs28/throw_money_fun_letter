<?php
session_start();
require_once('funcs.php');
loginCheck(); // ログイン確認
$pdo = localdb_conn();
$admin_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ダッシュボード - LiveEcho</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_dashboard.css">
</head>
<body>

<header class="dashboard-header">
  <div class="container">
    <div class="logo">LiveEcho</div>
    <nav class="nav">
      <a href="dashboard.php" class = "header_link">ダッシュボード</a>
      <a href="event_list.php" class = "header_link">イベント管理</a>
      <a href="member_list.php" class = "header_link">メンバー管理</a>
        <?php if (isset($_SESSION['name'])): ?>
          <span class="username"><?= h($_SESSION['name']) ?> さん</span>
        <?php endif; ?>
      <a href="logout.php" class="logout-btn">ログアウト</a>
    </nav>
  </div>
</header>

<main class="dashboard-main">
  <div class="container">

    <h1>ようこそ <?= h($_SESSION['name']) ?> さん</h1>

    <div class="dashboard-grid">

      <div class="dashboard-card">
        <h3>📅 近日のイベント</h3>
        <p>直近のイベントを確認し、参加メンバーを設定しましょう。</p>
        <a href="event_list.php" class="card-btn">イベント一覧へ</a>
      </div>

      <div class="dashboard-card">
        <h3>👤 所属グループ情報</h3>
        <p>担当しているグループの情報確認・メンバー編集が可能です。</p>
        <a href="member_list.php" class="card-btn">メンバー管理</a>
      </div>

      <div class="dashboard-card">
        <h3>💌 最近のファンレター</h3>
        <p>ファンから届いた公開メッセージを確認しましょう。</p>
        <a href="message_list.php" class="card-btn">ファンレターを見る</a>
      </div>

      <div class="dashboard-card">
        <h3>⚙ 管理メニュー</h3>
        <p>イベント作成やグループ追加など、すぐに行いたい操作はこちら。</p>
        <a href="event_register.php" class="card-btn">イベント作成</a>
      </div>

    </div>

  </div>
</main>

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
