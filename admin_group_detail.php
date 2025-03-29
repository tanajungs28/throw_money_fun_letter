<?php
session_start();
require_once('funcs.php');
loginCheck();

if ($_SESSION['kanri_flg'] != 99) {
    exit('権限がありません');
}

$group_id = $_GET['group_id'] ?? null;
if (!$group_id) {
    exit('グループIDが指定されていません');
}

$pdo = localdb_conn();

// グループ情報取得
$stmt = $pdo->prepare("SELECT * FROM idol_list_table WHERE id = :group_id");
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
$stmt->execute();
$group = $stmt->fetch(PDO::FETCH_ASSOC);

// メンバー一覧取得
$member_stmt = $pdo->prepare("SELECT * FROM member_list WHERE group_id = :group_id");
$member_stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
$member_stmt->execute();
$members = $member_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>グループ詳細管理</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
  <link rel="stylesheet" href="css/style_admin_group_detail.css">
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
  <h1><?= h($group['group_name']) ?> の管理</h1>

  <div class="group-info">
    <p>グループID: <?= h($group['id']) ?></p>
    <p>グループ名: <?= h($group['group_name']) ?></p>
    <a href="admin_group_edit.php?id=<?= h($group['id']) ?>" class="btn-secondary">グループ名を編集</a>
  </div>

  <h2>所属メンバー</h2>

  <?php if (empty($members)): ?>
    <p>このグループに登録されたメンバーはいません。</p>
  <?php else: ?>
    <table class="member-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>メンバー名</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($members as $member): ?>
          <tr>
            <td><?= h($member['id']) ?></td>
            <td><?= h($member['member_name']) ?></td>
            <td>
              <a href="admin_member_edit.php?group_id=<?= h($group['id']) ?>&id=<?= h($member['id']) ?>" class="btn-edit">編集</a>
              <a href="admin_member_delete.php?group_id=<?= h($group['id']) ?>&id=<?= h($member['id']) ?>" class="btn-delete" onclick="return confirm('本当に削除してよろしいですか？');">削除</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <a href="admin_member_add.php?group_id=<?= h($group['id']) ?>" class="btn-add">＋ メンバーを追加</a>
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
