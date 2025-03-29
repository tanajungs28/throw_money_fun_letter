<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者以外はアクセス不可
if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

// 対象グループID取得
$id = $_GET['id'] ?? '';
if (!$id) {
    exit('グループIDが指定されていません。');
}

// DB接続
$pdo = localdb_conn();

// グループ情報取得
$stmt = $pdo->prepare("SELECT * FROM idol_list_table WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$group = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$group) {
    exit('指定されたグループが見つかりません。');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>グループ名編集 - 管理者専用</title>
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
  <h1>グループ名の編集</h1>
  <form action="admin_group_update.php" method="post" class="form">
    <input type="hidden" name="id" value="<?= h($group['id']) ?>">

    <div class="form-item">
      <label>グループ名</label>
      <input type="text" name="group_name" value="<?= h($group['group_name']) ?>" required>
    </div>

    <button type="submit" class="btn-primary">更新</button>
    <a href="admin_group_list.php" class="btn-secondary">戻る</a>
  </form>
</div>

<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="admin_dashboard.php">管理者TOP</a>
    <a class="footerlink" href="./admin_user_list.php">ユーザー管理</a>
    <a class="footerlink" href="admin_group_list.php">グループ管理</a>
    <a class="footerlink" href="logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
