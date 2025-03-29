<?php
session_start();
require_once('funcs.php');
loginCheck();

$pdo = localdb_conn();

// ログイン中のユーザーIDを取得
$admin_id = $_SESSION['id']; // ログイン時に user_id をセットしている前提

// 運営者が管理しているアイドルグループを取得
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベント登録</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_event_register.css">
    <link rel="stylesheet" href="css/style_management.css">
</head>
<body>
    <!-- ヘッダー情報 -->
    <header>
    <div class="title_area">
    <div class="title">LiveEcho イベント登録画面</div>
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
    <!--登録のウィンドウ  -->
    <div class="form-wrapper">
    <h1 class="form-title">イベント登録フォーム</h1>
    <form name="form1" action="event_insert.php" method="post" class="event-form">
      
      <div class="form-item">
        <label for="group_id">アイドルグループ</label>
        <select name="group_id" required>
          <option value="">-- グループを選択してください --</option>
          <?php foreach ($groups as $group): ?>
            <option value="<?= h($group['id']) ?>"><?= h($group['group_name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-item">
        <label for="event_name">イベント名</label>
        <input type="text" name="event_name" required placeholder="イベント名を入力してください">
      </div>

      <div class="form-item">
        <label for="event_day">開催日</label>
        <input type="date" name="event_day" required>
      </div>

      <div class="form-item">
        <label>
          <input type="checkbox" name="twitter_post" value="1" checked>
          X（旧Twitter）へ自動投稿を許可する
        </label>
      </div>

      <div class="form-item">
        <label for="hashtag">ハッシュタグ</label>
        <input type="text" name="hashtag" required placeholder="#イベント名 など">
      </div>

      <div class="button-panel">
        <button type="submit" class="button">登録</button>
      </div>

    </form>
  </div>

     <!-- </main> -->

     <footer>
     <div class="footer_title">LiveEcho</div>
    <div class="footer_menu">
      <a class="footerlink" href="./dashboard.php">ダッシュボード</a>
      <a class="footerlink" href="./event_list.php">イベント管理</a>
      <a class="footerlink" href="./member_list.php">メンバー管理</a>
      <a class="footerlink" href="./logout.php">ログアウト</a>
    </div>
    </footer>




    <!-- jquery指定 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jsファイル指定、importを使用するためにはscript指定時に「type="module"」を入れないと動かない -->
    <script type="module" src="js/registration.js"></script>
    
</body>
</html>