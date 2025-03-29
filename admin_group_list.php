<?php
session_start();
require_once('funcs.php');
loginCheck();

// 管理者チェック
if ($_SESSION['kanri_flg'] != 99) {
    exit('権限がありません。');
}

$pdo = localdb_conn();

// グループ一覧を取得
$stmt = $pdo->prepare("SELECT id, group_name, created_at FROM idol_list_table ORDER BY created_at DESC");
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アイドルグループ管理</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
  <link rel="stylesheet" href="css/style_admin_group_list.css">
</head>
<body>

<header>
  <div class="title_area">
    <div class="title">LiveEcho システム管理</div>
    <div class="user_reg_area">
      <span class="username"><?= h($_SESSION['name']) ?> さん</span>
      <a class="logout_btn" href="logout.php">ログアウト</a>
    </div>
  </div>
</header>

<div class="container">
  <h1>アイドルグループ一覧</h1>

  <a href="admin_group_add.php" class="add-btn">＋ 新規グループを追加</a>

  <?php if (empty($groups)): ?>
    <p>登録されたグループはありません。</p>
  <?php else: ?>
    <table class="group-list-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>グループ名</th>
          <th>作成日</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($groups as $group): ?>
          <tr>
            <td><?= h($group['id']) ?></td>
            <td><?= h($group['group_name']) ?></td>
            <td><?= h($group['created_at']) ?></td>
            <td class="action-btns">
              <!-- <a href="admin_group_detail.php?group_id=<?= h($group['id']) ?>" class="detail">詳細</a> -->
              <a href="admin_group_detail.php?group_id=<?= h($group['id']) ?>" class="edit">編集</a>
              <a href="admin_group_delete.php?id=<?= h($group['id']) ?>" class="delete" onclick="return confirm('本当に削除しますか？');">削除</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
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
