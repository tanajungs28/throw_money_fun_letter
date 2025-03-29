<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();

// event_members.id で指定
$event_member_id = $_GET['id'] ?? null;
if (!$event_member_id) {
    exit('IDが指定されていません');
}

// 該当データ取得
$stmt = $pdo->prepare("
    SELECT em.id AS event_member_id, em.event_id, em.message, m.member_name
    FROM event_members em
    JOIN member_list m ON em.member_id = m.id
    WHERE em.id = :id
");
$stmt->bindValue(':id', $event_member_id, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) exit('該当データが存在しません');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>意気込みコメント編集</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_event.css">
    <style>
        .form-wrapper {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: #fff0f5;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            font-size: 1.4em;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-item {
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            height: 120px;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .button-panel {
            text-align: center;
        }
        .button {
            background-color: #d18fd1;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }
        .button:hover {
            background-color: #c06fc0;
        }
    </style>
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
    <div class="form-wrapper">
        <div class="form-title"><?= h($data['member_name']) ?> さんの意気込み</div>

        <form action="event_member_update.php" method="post">
            <input type="hidden" name="id" value="<?= h($data['event_member_id']) ?>">
            <input type="hidden" name="event_id" value="<?= h($data['event_id']) ?>">

            <div class="form-item">
                <label for="message">意気込みコメント</label><br>
                <textarea name="message" required><?= h($data['message']) ?></textarea>
            </div>

            <div class="button-panel">
                <button type="submit" class="button">更新する</button>
            </div>
        </form>
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
