<?php
session_start();
require_once('funcs.php');
loginCheck();

if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません');
}

$pdo = localdb_conn();

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    exit('ユーザーIDが指定されていません');
}

// ユーザー情報取得
$stmt = $pdo->prepare("SELECT * FROM user_list_table WHERE id = :id");
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// グループ一覧取得
$group_stmt = $pdo->query("SELECT * FROM idol_list_table ORDER BY group_name ASC");
$groups = $group_stmt->fetchAll(PDO::FETCH_ASSOC);

// ユーザーが管理しているグループIDを取得
$link_stmt = $pdo->prepare("SELECT group_id FROM admin_groups WHERE user_id = :user_id");
$link_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$link_stmt->execute();
$linked_groups = array_column($link_stmt->fetchAll(PDO::FETCH_ASSOC), 'group_id');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>グループ紐づけ管理</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
  <link rel="stylesheet" href="css/style_admin_group_manage.css">
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
  <h1>【<?= h($user['name']) ?>】さんのグループ紐づけ管理</h1>

  <form action="admin_user_group_update.php" method="post" class="group-form">
    <input type="hidden" name="user_id" value="<?= h($user_id) ?>">

    <div class="group-checkboxes">
      <?php foreach ($groups as $group): ?>
        <label class="group-label">
          <input type="checkbox" name="group_ids[]" value="<?= h($group['id']) ?>"
            <?= in_array($group['id'], $linked_groups) ? 'checked' : '' ?>>
          <?= h($group['group_name']) ?>
        </label>
      <?php endforeach; ?>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">保存する</button>
      <a href="admin_user_list.php" class="btn-secondary">戻る</a>
    </div>
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
