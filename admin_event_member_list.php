<?php
session_start();
require_once('funcs.php');
loginCheck();

if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

$pdo = localdb_conn();
$event_id = $_GET['event_id'] ?? null;

if (!$event_id) {
    exit('イベントIDが指定されていません。');
}

// イベント名取得
$event_stmt = $pdo->prepare("SELECT event_name FROM event_list WHERE id = :event_id");
$event_stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$event_stmt->execute();
$event_name = $event_stmt->fetchColumn();

// イベント参加メンバー取得
$sql = "SELECT em.id AS event_member_id, m.id AS member_id, m.member_name, em.message
        FROM event_members em
        JOIN member_list m ON em.member_id = m.id
        WHERE em.event_id = :event_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>イベントメンバー管理</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
  <link rel="stylesheet" href="css/style_admin_event_member_list.css">

</head>
<body>

<header>
  <div class="title_area">
    <div class="title">LiveEcho システム管理</div>
    <div class="user_reg_area">
      <?= h($_SESSION['name']) ?> さん
      <a class="logout_btn" href="logout.php">ログアウト</a>
    </div>
  </div>
</header>

<div class="container">
  <h1><?= h($event_name) ?> の参加メンバー</h1>

  <?php if (empty($members)): ?>
    <p>このイベントにはまだメンバーが登録されていません。</p>
  <?php else: ?>
    <?php foreach ($members as $member): ?>
      <div class="member-card">
        <div class="member-name"><?= h($member['member_name']) ?></div>
        <div class="enthusiasm"><?= nl2br(h($member['message'])) ?></div>
        <div class="action-buttons">
          <a href="admin_event_member_edit.php?id=<?= h($member['event_member_id']) ?>" class="btn-edit">編集</a>
          <a href="admin_event_member_delete.php?id=<?= h($member['event_member_id']) ?>&event_id=<?= h($event_id) ?>"
             class="btn-delete" onclick="return confirm('このメンバーを削除してもよろしいですか？');">削除</a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <a href="admin_event_member_add.php?event_id=<?= h($event_id) ?>" class="btn-add">＋ メンバー追加</a>
  <a href="admin_event_list.php" class="btn-secondary">＜ イベント一覧に戻る</a>
</div>

<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="admin_dashboard.php">ダッシュボード</a>
    <a class="footerlink" href="admin_event_list.php">イベント管理</a>
    <a class="footerlink" href="logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
