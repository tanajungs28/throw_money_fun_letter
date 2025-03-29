<?php
session_start();
require_once('funcs.php');
loginCheck();

// 管理者権限チェック
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

$pdo = localdb_conn();

// ユーザーID取得
$id = $_GET['id'] ?? null;
if (!$id) {
    exit('ユーザーIDが指定されていません。');
}

// 対象ユーザー情報取得
$stmt = $pdo->prepare("SELECT * FROM user_list_table WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();

if (!$user) {
    exit('指定されたユーザーが存在しません。');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー編集 - 管理者専用</title>
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
  <h1>ユーザー情報編集</h1>
  <form action="admin_user_update.php" method="post" class="form">
    <input type="hidden" name="id" value="<?= h($user['id']) ?>">

    <div class="form-item">
      <label>ログインID</label>
      <input type="text" name="lid" value="<?= h($user['lid']) ?>" required>
    </div>

    <div class="form-item">
      <label>パスワード（変更する場合のみ入力）</label>
      <input type="password" name="lpw">
    </div>

    <div class="form-item">
      <label>ユーザー名</label>
      <input type="text" name="name" value="<?= h($user['name']) ?>" required>
    </div>

    <div class="form-item">
      <label>権限</label>
      <select name="kanri_flg">
        <option value="0" <?= $user['kanri_flg'] == 0 ? 'selected' : '' ?>>一般ユーザー</option>
        <option value="1" <?= $user['kanri_flg'] == 1 ? 'selected' : '' ?>>アイドル運営者</option>
        <option value="99" <?= $user['kanri_flg'] == 99 ? 'selected' : '' ?>>システム管理者</option>
      </select>
    </div>

    <button type="submit" class="btn-primary">更新</button>
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
