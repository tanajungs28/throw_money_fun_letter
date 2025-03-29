<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();

$event_id = $_GET['event_id'] ?? null;
if (!$event_id) {
    exit('イベントIDが指定されていません');
}

// 参加メンバー一覧を取得
$sql = "SELECT em.id AS event_member_id, m.id AS member_id, m.member_name, em.message
        FROM event_members em
        JOIN member_list m ON em.member_id = m.id
        WHERE em.event_id = :event_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

// イベント名の取得
$event_stmt = $pdo->prepare("SELECT event_name FROM event_list WHERE id = :event_id");
$event_stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$event_stmt->execute();
$event_name = $event_stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title><?= h($event_name) ?> - メンバー管理</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_member_update.css">
  <link rel="stylesheet" href="css/style_event_member_list.css">
</head>

<body>

<header>
    <div class="title_area">
    <div class="title">LiveEcho</div>
      <nav class="nav">
        <a href="dashboard.php" class = "header_link">ダッシュボード</a>
        <a href="event_list.php" class = "active">イベント管理</a>
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
    <div class="member-list-wrapper">
      <h1>「<?= h($event_name) ?>」イベント参加メンバー一覧</h1>

      <?php if (empty($members)): ?>
        <p>このイベントにはまだメンバーが登録されていません。</p>
      <?php else: ?>
        <?php foreach ($members as $member): ?>
          <div class="member-card">
            <div class="member-name">
              <a href="letter_send.php?member_id=<?= h($member['member_id']) ?>&event_id=<?= h($event_id) ?>">
                <?= h($member['member_name']) ?>
              </a>
            </div>
            <div class="enthusiasm"><?= nl2br(h($member['message'])) ?></div>
            <div class="action-buttons">
              <a href="event_member_edit.php?id=<?= h($member['event_member_id']) ?>">編集</a>
              <a class="delete" href="event_member_delete.php?id=<?= h($member['event_member_id']) ?>&event_id=<?= h($event_id) ?>" onclick="return confirm('このメンバーをイベントから削除しますか？');">削除</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <a href="event_member_add.php?event_id=<?= h($event_id) ?>" class="btn-add">＋ メンバーを追加する</a><br>
      <a href="event_list.php" class="back-link">← イベント一覧へ戻る</a>
    </div>
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
