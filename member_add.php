<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();

// 運営者が管理しているグループ一覧を取得
$admin_id = $_SESSION['id'];
$group_id = $_GET['group_id'];
$stmt = $pdo->prepare("
    SELECT idol_list_table.id, idol_list_table.group_name 
    FROM admin_groups
    JOIN idol_list_table ON admin_groups.group_id = idol_list_table.id
    WHERE admin_groups.user_id = :admin_id
");
$stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メンバー追加 | LiveEcho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_member_update.css">
</head>
<body>

<!-- ヘッダー -->
<!-- ヘッダー -->
<header>
    <div class="title_area">
    <div class="title">LiveEcho メンバー情報追加</div>
      <nav class="nav">
        <a href="dashboard.php" class = "header_link">ダッシュボード</a>
        <a href="event_list.php" class = "header_link">イベント管理</a>
        <a href="member_list.php" class="header_link">メンバー管理</a>
        <div class="user_reg_area">
          <?php if (isset($_SESSION['name'])): ?>
            <span class="username"><?= h($_SESSION['name']) ?> さん</span>
            <a class="logout_btn" href="./logout.php">ログアウト</a>
          <?php endif; ?>
        </div>
      </nav>
    </div>
  </header>
<main>
  <div class="wrapper">
    <h1>新しいメンバーの追加</h1>

    <form action="member_insert.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="group_id" value="<?= h($group_id) ?>">
      <div class="form-group">
        <label for="member_name">メンバー名</label>
        <input type="text" name="member_name" required>
      </div>

      <div class="form-group">
        <!-- <label for="member_image">画像URL</label>
        <input type="text" name="member_image" placeholder="https://example.com/image.jpg"> -->
        <label>プロフィール画像（任意）</label>
        <input type="file" name="member_image" accept="image/*">
      </div>

      <div class="form-group">
        <label for="profile">プロフィール文</label>
        <textarea name="content" rows="5" placeholder="簡単な紹介文など"></textarea>
      </div>

      <!-- <div class="form-group">
        <label for="group_id">所属グループ</label>
        <select name="group_id" required>
          <option value="">-- グループを選択 --</option>
          <?php foreach ($groups as $group): ?>
            <option value="<?= h($group['id']) ?>"><?= h($group['group_name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div> -->

      <input type="submit" value="追加する">
      <a href="member_list.php" class="back-link">← メンバー一覧へ戻る</a>
    </form>
  </div>
</main>

<!-- フッター -->
<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="./dashboard.php">ダッシュボード</a>
    <a class="footerlink" href="./event_list.php">イベント管理</a>
    <a class="footerlink" href="./member_list.php">メンバー管理</a>
    <a class="footerlink" href="./logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
