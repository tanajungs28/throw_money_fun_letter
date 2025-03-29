<?php
session_start();
require_once('funcs.php');
loginCheck();

// システム管理者チェック
if ($_SESSION['kanri_flg'] != 99) {
    exit('アクセス権限がありません');
}

$pdo = localdb_conn();

$event_member_id = $_GET['id'] ?? null;

if (!$event_member_id) {
    exit('メンバー情報が指定されていません');
}

// メンバー情報を取得
$stmt = $pdo->prepare("
    SELECT em.id AS event_member_id, em.event_id, em.member_id, em.message, m.member_name 
    FROM event_members em
    JOIN member_list m ON em.member_id = m.id
    WHERE em.id = :id
");
$stmt->bindValue(':id', $event_member_id, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    exit('対象のメンバーが見つかりません');
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>イベントメンバー編集</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_admin.css">
    <link rel="stylesheet" href="css/style_admin_event_member_edit.css">
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
    <h1>イベント参加メンバーの編集</h1>

    <form action="admin_event_member_update.php" method="post" class="form">

        <div class="form-item">
            <label>メンバー名</label>
            <p><?= h($data['member_name']) ?></p>
        </div>

        <div class="form-item">
            <label for="message">意気込みメッセージ</label>
            <textarea name="message" rows="4" required><?= h($data['message']) ?></textarea>
        </div>

        <input type="hidden" name="id" value="<?= h($data['event_member_id']) ?>">
        <input type="hidden" name="event_id" value="<?= h($data['event_id']) ?>">

        <button type="submit" class="btn-primary">更新する</button>
        <a href="admin_event_member_list.php?event_id=<?= h($data['event_id']) ?>" class="btn-secondary">戻る</a>
    </form>
</div>

<footer>
  <div class="footer_title">LiveEcho</div>
  <div class="footer_menu">
    <a class="footerlink" href="admin_dashboard.php">管理者TOP</a>
    <a class="footerlink" href="admin_event_list.php">イベント管理</a>
    <a class="footerlink" href="logout.php">ログアウト</a>
  </div>
</footer>

</body>
</html>
