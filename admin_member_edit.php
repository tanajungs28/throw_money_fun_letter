<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();

// メンバーID取得
$member_id = $_GET['id'] ?? null;
if (!$member_id) {
    exit('IDが指定されていません');
}
$group_id = $_GET['group_id'] ?? null;

// メンバー情報取得
$stmt = $pdo->prepare("SELECT * FROM member_list WHERE id = :id");
$stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
$stmt->execute();
$member = $stmt->fetch(PDO::FETCH_ASSOC);

// 運営者が管理するグループ一覧取得
$admin_id = $_SESSION['id'];
$group_stmt = $pdo->prepare("
    SELECT idol_list_table.id, idol_list_table.group_name
    FROM admin_groups
    JOIN idol_list_table ON admin_groups.group_id = idol_list_table.id
    WHERE admin_groups.user_id = :admin_id
");
$group_stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
$group_stmt->execute();
$groups = $group_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メンバー編集 | LiveEcho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_admin.css">
    <link rel="stylesheet" href="css/style_admin_member_edit.css">

</head>
<body>

<!-- ヘッダー -->
<header>
  <div class="title_area">
    <div class="title">LiveEcho 管理者ダッシュボード</div>
    <div class="user_reg_area">
      <?= h($_SESSION['name']) ?> さん
      <a class="logout_btn" href="logout.php">ログアウト</a>
    </div>
  </div>
</header>

<main>
  <div class="wrapper">
    <h1>メンバー情報を編集</h1>

    <form action="admin_member_update.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="group_id" value="<?= h($group_id) ?>">
      <input type="hidden" name="id" value="<?= h($member['id']) ?>">

      <div class="form-group">
        <label for="member_name">メンバー名</label>
        <input type="text" name="member_name" value="<?= h($member['member_name']) ?>" required>
      </div>

      <!-- <div class="form-group">
        <label for="member_image">プロフィール画像</label>
        <input type="file" name="member_image" accept="image/*">
      </div> -->

      <div class="form-item">
      <label>現在の画像</label><br>
      <?php if ($member['member_image']): ?>
        <img src="<?= h($member['member_image']) ?>" alt="現在の画像" style="width:100px;height:auto;">
        <input type="hidden" name="existing_image" value="<?= h($member['member_image']) ?>">
      <?php else: ?>
        <p>画像なし</p>
      <?php endif; ?>
    </div>

    <div class="form-item">
      <label>画像を変更する</label>
      <input type="file" name="member_image_file" accept="image/*">
    </div>

      <div class="form-group">
        <label for="profile">プロフィール文</label>
        <textarea name="content" rows="5"><?= h($member['content']) ?></textarea>
      </div>

      <input type="submit" value="更新する">
      <a href="admin_group_detail.php?group_id=<?= h($group_id) ?>" class="back-link">← メンバー一覧へ戻る</a>
    </form>
  </div>
</main>

<!-- フッター -->
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
