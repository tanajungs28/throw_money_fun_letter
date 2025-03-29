<?php
session_start();
require_once('funcs.php');
loginCheck();

if ($_SESSION['kanri_flg'] != 99) {
    exit('権限がありません');
}

$pdo = localdb_conn();

// 全ユーザー取得
$stmt = $pdo->prepare("SELECT id, name, lid, kanri_flg, created_at FROM user_list_table ORDER BY created_at DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// グループ取得（user_idごとにまとめて取得）
$group_stmt = $pdo->prepare("
    SELECT ag.user_id, ilt.id as group_id, ilt.group_name 
    FROM admin_groups ag 
    JOIN idol_list_table ilt ON ag.group_id = ilt.id
");
$group_stmt->execute();
$group_data = $group_stmt->fetchAll(PDO::FETCH_ASSOC);

$group_map = [];
foreach ($group_data as $g) {
    $group_map[$g['user_id']][] = $g;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー一覧 - システム管理者</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
  <link rel="stylesheet" href="css/style_admin_user_list.css">
</head>
<body>

<header>
  <div class="title_area">
    <div class="title">LiveEcho システム管理</div>
    <div class="user_reg_area">
      <span class="username"><?= h($_SESSION['name']) ?> さん</span>
      <a class="logout_btn" href="./logout.php">ログアウト</a>
    </div>
  </div>
</header>

<div class="container">
  <h1>登録ユーザー一覧</h1>

  <a href="admin_user_add.php" class="add-btn">＋ ユーザーを新規追加</a>

  <table class="user-list-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>ユーザー名</th>
        <th>ログインID</th>
        <th>権限</th>
        <th>管理グループ</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= h($user['id']) ?></td>
          <td><?= h($user['name']) ?></td>
          <td><?= h($user['lid']) ?></td>
          <td>
            <?php
              if ($user['kanri_flg'] == 99) echo 'システム管理者';
              elseif ($user['kanri_flg'] == 1) echo 'アイドル運営者';
              else echo '一般ユーザー';
            ?>
          </td>
          <td>
            <?php if ($user['kanri_flg'] == 1): ?>
              <?php if (!empty($group_map[$user['id']])): ?>
                <?php foreach ($group_map[$user['id']] as $group): ?>
                  <a href="admin_group_detail.php?group_id=<?= h($group['group_id']) ?>" class="group-link">
                    <?= h($group['group_name']) ?>
                  </a><br>
                <?php endforeach; ?>
              <?php else: ?>
                （未設定）
              <?php endif; ?>
              <div><a class="small-link" href="admin_user_group_manage.php?user_id=<?= h($user['id']) ?>">＋グループを紐づけ</a></div>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <td class="action-btns">
            <a href="admin_user_edit.php?id=<?= h($user['id']) ?>" class="edit">編集</a>
            <a href="admin_user_delete.php?id=<?= h($user['id']) ?>" class="delete" onclick="return confirm('このユーザーを削除しますか？');">削除</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="./admin_dashboard.php">ダッシュボード</a>
    <a class="footerlink" href="./admin_user_list.php">ユーザー管理</a>
    <a class="footerlink" href="admin_group_list.php">グループ管理</a>
    <a class="footerlink" href="./logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
