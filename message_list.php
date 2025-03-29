<?php
session_start();
require_once('funcs.php');
loginCheck();

$pdo = localdb_conn();
$admin_id = $_SESSION['id'];

// グループ一覧取得
$group_stmt = $pdo->prepare("
    SELECT idol_list_table.id, idol_list_table.group_name
    FROM admin_groups
    JOIN idol_list_table ON admin_groups.group_id = idol_list_table.id
    WHERE admin_groups.user_id = :admin_id
");
$group_stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
$group_stmt->execute();
$groups = $group_stmt->fetchAll(PDO::FETCH_ASSOC);

// GETパラメータでフィルタ取得
$selected_group = $_GET['group_id'] ?? '';
$selected_event = $_GET['event_id'] ?? '';
$selected_member = $_GET['member_id'] ?? '';

// 絞り込み用のイベント・メンバーを取得
$events = [];
$members = [];

if ($selected_group) {
    $event_stmt = $pdo->prepare("SELECT id, event_name FROM event_list WHERE group_id = :group_id");
    $event_stmt->bindValue(':group_id', $selected_group, PDO::PARAM_INT);
    $event_stmt->execute();
    $events = $event_stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($selected_event) {
        $member_stmt = $pdo->prepare("
            SELECT m.id, m.member_name 
            FROM event_members em
            JOIN member_list m ON em.member_id = m.id
            WHERE em.event_id = :event_id
        ");
        $member_stmt->bindValue(':event_id', $selected_event, PDO::PARAM_INT);
        $member_stmt->execute();
        $members = $member_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// メッセージ取得クエリ
$sql = "
    SELECT l.*, m.member_name, e.event_name, g.group_name 
    FROM letter_list l
    JOIN member_list m ON l.member_id = m.id
    JOIN event_members em ON l.member_id = em.member_id AND l.event_id = em.event_id
    JOIN event_list e ON l.event_id = e.id
    JOIN idol_list_table g ON e.group_id = g.id
    JOIN admin_groups ag ON g.id = ag.group_id
    WHERE ag.user_id = :admin_id
";

if ($selected_group) $sql .= " AND g.id = :group_id";
if ($selected_event) $sql .= " AND e.id = :event_id";
if ($selected_member) $sql .= " AND m.id = :member_id";
$sql .= " ORDER BY l.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
if ($selected_group) $stmt->bindValue(':group_id', $selected_group, PDO::PARAM_INT);
if ($selected_event) $stmt->bindValue(':event_id', $selected_event, PDO::PARAM_INT);
if ($selected_member) $stmt->bindValue(':member_id', $selected_member, PDO::PARAM_INT);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ファンメッセージ一覧</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_message_list.css">
</head>
<body>

<header>
    <div class="title_area">
    <div class="title">LiveEcho 管理メッセージ一覧</div>
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

<div class="message-container">
    <aside class="sidebar">
        <form method="get" class="filter-form">
            <label>グループ
                <select name="group_id" onchange="this.form.submit()">
                    <option value="">すべてのグループ</option>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= h($group['id']) ?>" <?= $selected_group == $group['id'] ? 'selected' : '' ?>>
                            <?= h($group['group_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>イベント
                <select name="event_id" onchange="this.form.submit()">
                    <option value="">すべてのイベント</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?= h($event['id']) ?>" <?= $selected_event == $event['id'] ? 'selected' : '' ?>>
                            <?= h($event['event_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>メンバー
                <select name="member_id" onchange="this.form.submit()">
                    <option value="">すべてのメンバー</option>
                    <?php foreach ($members as $member): ?>
                        <option value="<?= h($member['id']) ?>" <?= $selected_member == $member['id'] ? 'selected' : '' ?>>
                            <?= h($member['member_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </form>
    </aside>

    <main class="message-main">
        <h2>ファンメッセージ一覧</h2>
        <?php if (empty($messages)): ?>
            <p>該当するメッセージはありません。</p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message-card">
                    <div class="meta">
                        <span class="group"><?= h($msg['group_name']) ?></span> /
                        <span class="event"><?= h($msg['event_name']) ?></span> /
                        <span class="member"><?= h($msg['member_name']) ?></span>
                    </div>
                    <p class="message"><?= h($msg['message']) ?></p>
                    <div class="footer">
                        <span class="amount">投げ銭：<?= h($msg['amount']) ?>円</span>
                        <span class="status"><?= h($msg['status'] === 'open' ? '公開' : '非公開') ?></span>
                        <span class="time"><?= h($msg['created_at']) ?></span>
                        <!-- 削除ボタン -->
                        <form action="message_delete.php" method="post" onsubmit="return confirm('このメッセージを削除しますか？');" style="display:inline;">
                            <input type="hidden" name="letter_id" value="<?= h($msg['id']) ?>">
                            <button type="submit" class="delete-btn">削除</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</div>

<footer>
    <div class="footer_title">LiveEcho</div>
    <div class="footer_menu">
        <a class="footerlink" href="./dashboard.php">ダッシュボード</a>
        <a class="footerlink" href="./event_list.php">イベント管理</a>
        <a class="footerlink" href="./member_list.php">メンバー管理</a>
        <a class="footerlink" href="./message_list.php">メッセージ管理</a>
        <a class="footerlink" href="./logout.php">ログアウト</a>
    </div>
</footer>

</body>
</html>
