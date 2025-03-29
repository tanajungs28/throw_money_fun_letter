<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();

$event_id = $_GET['event_id'] ?? null;
if (!$event_id) {
    exit('イベントIDが指定されていません');
}

// イベントのグループID取得
$stmt = $pdo->prepare("SELECT group_id FROM event_list WHERE id = :event_id");
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$group_id = $stmt->fetchColumn();

// 未登録メンバーの取得
$sql = "
    SELECT *
    FROM member_list
    WHERE group_id = :group_id
    AND id NOT IN (
        SELECT member_id FROM event_members WHERE event_id = :event_id
    )
";
$member_stmt = $pdo->prepare($sql);
$member_stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
$member_stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$member_stmt->execute();
$members = $member_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>イベントメンバー追加</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_member_update.css">
</head>
<body>

<header>
    <div class="title_area">
    <div class="title">LiveEcho 意気込みコメント編集</div>
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
  <div class="member-select-wrapper">
    <h1>イベント参加メンバーの追加</h1>

    <?php if (empty($members)): ?>
      <p class="no-members">追加可能なメンバーは存在しません。</p>
    <?php else: ?>
      <form action="event_member_insert.php" method="post">
        <?php foreach ($members as $member): ?>
          <div class="member-option">
            <label>
              <input type="checkbox" name="members[<?= h($member['id']) ?>][join]" value="1">
              <?= h($member['member_name']) ?>
            </label>
            <textarea name="members[<?= h($member['id']) ?>][message]" placeholder="意気込みコメントを入力" rows="3"></textarea>
          </div>
        <?php endforeach; ?>
        <input type="hidden" name="event_id" value="<?= h($event_id) ?>">
        <button type="submit" class="btn-submit">選択したメンバーを追加する</button>
      </form>
      <a href="event_member_list.php?event_id=<?= h($event_id) ?>" class="btn-back">← イベントメンバー一覧に戻る</a>
    <?php endif; ?>
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
