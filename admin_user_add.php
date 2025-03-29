<?php
session_start();
require_once('funcs.php');
loginCheck(); // ログインチェック

// 管理者以外はアクセス禁止
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー追加 - 管理者専用</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
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
  <h1>新規ユーザー登録</h1>
  <form action="admin_user_insert.php" method="post" class="form">
    <div class="form-item">
      <label>ログインID(メールアドレス)</label>
      <input type="email" name="lid" required>
    </div>
    <div class="form-item">
      <label>パスワード</label>
      <input type="password" name="lpw" required>
    </div>
    <div class="form-item">
      <label>ユーザー名</label>
      <input type="text" name="name" required>
    </div>
    <div class="form-item">
      <label>権限</label>
      <select name="kanri_flg">
        <option value="0">一般ユーザー</option>
        <option value="1">アイドル運営者</option>
        <option value="99">システム管理者</option>
      </select>
    </div>
    <button type="submit" class="btn-primary">登録</button>
    <a href="admin_user_list.php" class="btn-secondary">戻る</a>
  </form>
</div>

<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="admin_dashboard.php">管理者TOP</a>
    <a class="footerlink" href="admin_user_list.php">ユーザー管理</a>
    <a class="footerlink" href="logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
