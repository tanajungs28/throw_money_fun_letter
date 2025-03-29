<?php
session_start();
require_once('funcs.php');
loginCheck(); // ログインチェック

// システム管理者以外アクセス不可
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>グループ追加 - 管理者専用</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
  <link rel="stylesheet" href="css/style_admin_group_list.css">
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
  <h1>アイドルグループの新規登録</h1>
  
  <form action="admin_group_insert.php" method="post" class="form">
    <div class="form-item">
      <label>グループ名</label>
      <input type="text" name="group_name" required placeholder="例）〇〇アイドル">
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">登録</button>
      <a href="admin_group_list.php" class="btn-secondary">戻る</a>
    </div>
  </form>
</div>

<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="admin_dashboard.php">管理者TOP</a>
    <a class="footerlink" href="admin_user_list.php">ユーザー管理</a>
    <a class="footerlink" href="admin_group_list.php">グループ管理</a>
    <a class="footerlink" href="logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
