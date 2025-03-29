<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();
$admin_id = $_SESSION['id'];

// 管理しているグループのメンバー取得
$sql = "
SELECT m.*, g.group_name
FROM member_list m
JOIN idol_list_table g ON m.group_id = g.id
JOIN admin_groups ag ON ag.group_id = g.id
WHERE ag.user_id = :admin_id
";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
$stmt->execute();
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

// グループごとにメンバーをまとめる処理（事前に行っておく）
$grouped_members = [];

foreach ($members as $member) {
    $group_name = $member['group_name'];
    $grouped_members[$group_name][] = $member;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>メンバー管理 - LiveEcho</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_member_list.css">

</head>
<body>

<header class="dashboard-header">
  <div class="container">
    <h1 class="logo">LiveEcho</h1>
    <nav class="nav">
      <a href="dashboard.php" class = "header_link">ダッシュボード</a>
      <a href="event_list.php" class = "header_link">イベント管理</a>
      <a href="member_list.php" class="active">メンバー管理</a>
          <?php if (isset($_SESSION['name'])): ?>
            <span class="username"><?= h($_SESSION['name']) ?> さん</span>
          <?php endif; ?>
      <a href="logout.php" class="logout-btn">ログアウト</a>
    </nav>
  </div>
</header>

<main class="member-list-container">
  <h2 class="page-title">メンバー管理</h2>

  <!-- グループ単位でループ表示 -->
<?php foreach ($grouped_members as $group_name => $group_members): ?>
  <section class="group-section">
    <h2 class="group-title"><?= h($group_name) ?></h2>

    <div class="member-list">
      <?php foreach ($group_members as $member): ?>
        <div class="member-card">
          <div class="image-wrapper">
            <img src="<?= h($member['member_image']) ?>" alt="アイドル画像">
          </div>
          <div class="info-wrapper">
            <h3><?= h($member['member_name']) ?></h3>
            <!-- <p class="profile-text"><?= nl2br(h($member['profile'])) ?></p> -->
          </div>
          <div class="action-wrapper">
            <a href="member_edit.php?id=<?= h($member['id']) ?>?group_id=<?= h($group_members[0]['group_id'])?>" class="btn edit">編集</a>
            <a href="member_delete.php?id=<?= h($member['id']) ?>" class="btn delete" onclick="return confirm('このメンバーを削除しますか？')">削除</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="add-member">
      <a href="member_add.php?group_id=<?= h($group_members[0]['group_id']) ?>" class="btn add">＋ <?= h($group_name) ?> にメンバーを追加</a>
    </div>
  </section>
<?php endforeach; ?>




</main>

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
