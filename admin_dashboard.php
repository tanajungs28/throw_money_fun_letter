<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者以外はリダイレクト
if ($_SESSION['kanri_flg'] != 99) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>システム管理ダッシュボード</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin_dashboard.css">
</head>
<body>

<header class="admin-header">
  <div class="header-inner">
    <h1 class="logo">LiveEcho 管理ダッシュボード</h1>
    <div class="admin-actions">
      <span class="admin-name"><?= h($_SESSION['name']) ?>（管理者）</span>
      <a href="logout.php" class="logout-btn">ログアウト</a>
    </div>
  </div>
</header>

<main class="admin-main">
  <div class="dashboard-container">

    <h2>管理メニュー</h2>

    <div class="dashboard-grid">
      <a href="admin_user_list.php" class="dashboard-card">
        <h3>ユーザー管理</h3>
        <p>登録されているすべてのユーザーを確認・削除できます。</p>
      </a>

      <a href="admin_group_list.php" class="dashboard-card">
        <h3>アイドルグループ管理</h3>
        <p>全グループの情報を管理者として確認・編集できます。</p>
      </a>

      <a href="admin_event_list.php" class="dashboard-card">
        <h3>イベント管理</h3>
        <p>全てのイベントの状況を横断的にチェックできます。</p>
      </a>

      <a href="admin_letter_list.php" class="dashboard-card">
        <h3>ファンレター一覧</h3>
        <p>投げ銭付きファンレターを全件管理・削除できます。</p>
      </a>

      <!-- <a href="admin_setting.php" class="dashboard-card">
        <h3>管理者設定</h3>
        <p>権限の管理やパスワード変更などを行えます。</p>
      </a> -->
    </div>

  </div>
</main>

<footer class="admin-footer">
  <p>&copy; 2025 LiveEcho. All rights reserved.</p>
</footer>

</body>
</html>
