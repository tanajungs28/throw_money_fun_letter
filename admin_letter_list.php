<?php
session_start();
require_once('funcs.php');
loginCheck();

if ($_SESSION['kanri_flg'] != 99) {
    exit('このページにはアクセスできません。');
}

$pdo = localdb_conn();

// フィルターの取得
$group_id = $_GET['group_id'] ?? '';
$event_id = $_GET['event_id'] ?? '';
$member_id = $_GET['member_id'] ?? '';

// グループ一覧の取得
$groups_stmt = $pdo->prepare("SELECT id, group_name FROM idol_list_table ORDER BY group_name ASC");
$groups_stmt->execute();
$groups = $groups_stmt->fetchAll(PDO::FETCH_ASSOC);

// イベント一覧の取得
$events_stmt = $pdo->prepare("SELECT id, event_name FROM event_list ORDER BY event_day DESC");
$events_stmt->execute();
$events = $events_stmt->fetchAll(PDO::FETCH_ASSOC);

// メンバー一覧の取得
$members_stmt = $pdo->prepare("SELECT id, member_name FROM member_list ORDER BY member_name ASC");
$members_stmt->execute();
$members = $members_stmt->fetchAll(PDO::FETCH_ASSOC);

// メッセージの取得
$sql = "
SELECT 
    l.id, l.message, l.amount, l.status, l.created_at,
    m.member_name,
    e.event_name,
    g.group_name
FROM 
    letter_list l
LEFT JOIN 
    member_list m ON l.member_id = m.id
LEFT JOIN 
    event_list e ON l.event_id = e.id
LEFT JOIN 
    idol_list_table g ON m.group_id = g.id
WHERE 
    1 = 1
";

$params = [];
if ($group_id !== '') {
    $sql .= " AND g.id = :group_id";
    $params[':group_id'] = $group_id;
}
if ($event_id !== '') {
    $sql .= " AND (e.id = :event_id OR (l.event_id = 0 AND :event_id = 0))";
    $params[':event_id'] = $event_id;
}
if ($member_id !== '') {
    $sql .= " AND m.id = :member_id";
    $params[':member_id'] = $member_id;
}
$sql .= " ORDER BY l.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$letters = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ファンレター一覧 - 管理者</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_admin.css">
  <!-- <link rel="stylesheet" href="css/style_admin_header_footer.css"> -->
  <link rel="stylesheet" href="css/style_admin_letter_list.css">
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
  <h1>ファンレター一覧</h1>

  <form method="get" class="filter-form">
    <div class="filter-group">
      <label>グループ</label>
      <select name="group_id">
        <option value="">すべて</option>
        <?php foreach ($groups as $g): ?>
          <option value="<?= h($g['id']) ?>" <?= $group_id == $g['id'] ? 'selected' : '' ?>><?= h($g['group_name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="filter-group">
      <label>イベント</label>
      <select name="event_id">
        <option value="">すべて</option>
        <option value="0" <?= $event_id === "0" ? 'selected' : '' ?>>イベント未設定</option>
        <?php foreach ($events as $e): ?>
          <option value="<?= h($e['id']) ?>" <?= $event_id == $e['id'] ? 'selected' : '' ?>><?= h($e['event_name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="filter-group">
      <label>メンバー</label>
      <select name="member_id">
        <option value="">すべて</option>
        <?php foreach ($members as $m): ?>
          <option value="<?= h($m['id']) ?>" <?= $member_id == $m['id'] ? 'selected' : '' ?>><?= h($m['member_name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="filter-submit">
      <button type="submit" class="btn-primary">絞り込む</button>
    </div>
  </form>

  <?php if (empty($letters)): ?>
    <p>該当するファンレターはありません。</p>
  <?php else: ?>
    <table class="letter-table">
      <thead>
        <tr>
          <th>日時</th>
          <th>グループ</th>
          <th>イベント</th>
          <th>メンバー</th>
          <th>メッセージ</th>
          <th>投げ銭</th>
          <th>公開設定</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($letters as $l): ?>
          <tr>
            <td><?= h($l['created_at']) ?></td>
            <td><?= h($l['group_name']) ?: '-' ?></td>
            <td><?= h($l['event_name']) ?: '（未設定）' ?></td>
            <td><?= h($l['member_name']) ?: '（不明）' ?></td>
            <td><?= nl2br(h($l['message'])) ?></td>
            <td><?= h($l['amount']) ?> 円</td>
            <td><?= h($l['status'] === 'open' ? '公開' : '非公開') ?></td>
            <td>
              <form action="admin_letter_delete.php" method="post" onsubmit="return confirm('このファンレターを削除しますか？');">
                <input type="hidden" name="letter_id" value="<?= h($l['id']) ?>">
                <button type="submit" class="btn-delete">削除</button>
              </form>
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
    <a class="footerlink" href="admin_dashboard.php">管理TOP</a>
    <a class="footerlink" href="admin_user_list.php">ユーザー管理</a>
    <a class="footerlink" href="admin_letter_list.php">ファンレター管理</a>
    <a class="footerlink" href="logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
