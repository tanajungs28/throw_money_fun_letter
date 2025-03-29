<?php
session_start();
require_once('funcs.php');
loginCheck();

// 1. GETでadmin_groupsのIDを受け取る
$id = $_GET['id'];
$pdo = localdb_conn(); // DB接続

// 2. admin_groupsの対象データを取得（編集対象）
$stmt = $pdo->prepare("SELECT * FROM admin_groups WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status === false) {
    sql_error($stmt);
}
$assignment = $stmt->fetch(PDO::FETCH_ASSOC); // 今の運営者とアイドルグループのID

// 3. 運営者一覧を取得（role = admin）
$admin_stmt = $pdo->prepare("SELECT id, name FROM user_list_table WHERE role = 'admin'");
$admin_stmt->execute();
$admins = $admin_stmt->fetchAll(PDO::FETCH_ASSOC);

// 4. アイドルグループ一覧を取得
$idol_stmt = $pdo->prepare("SELECT id, group_name FROM idol_list_table");
$idol_stmt->execute();
$idol_groups = $idol_stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アイドル運営者編集</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_login.css">
    <link rel="stylesheet" href="css/style_profile.css">
    <link rel="stylesheet" href="css/style_management.css">
</head>

<body>

    <!-- ヘッダー情報 -->
    <header>
     <button id = "back_btn">
        <img src="pic/back.png" alt="" id = "btn_pic">
     </button>
     <div class="title_area">
            <div class="title">アイドル運営者登録</div>
        </div>
     </header>


<div class="admin-edit-wrapper">
    <h1>アイドル運営者編集</h1>
    <form action="admin_groups_update.php" method="post" class="admin-edit-form">
        <div class="form-group">
            <label for="admin_id">運営者を選択</label>
            <select name="admin_id" id="admin_id" required>
                <option value="">-- 運営者を選択 --</option>
                <?php foreach ($admins as $admin): ?>
                    <option value="<?= h($admin['id']) ?>" <?= ($admin['id'] == $assignment['user_id']) ? 'selected' : '' ?>>
                        <?= h($admin['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="idol_group_id">アイドルグループを選択</label>
            <select name="idol_group_id" id="idol_group_id" required>
                <option value="">-- アイドルグループを選択 --</option>
                <?php foreach ($idol_groups as $group): ?>
                    <option value="<?= h($group['id']) ?>" <?= ($group['id'] == $assignment['group_id']) ? 'selected' : '' ?>>
                        <?= h($group['group_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- hiddenでIDを送る -->
        <input type="hidden" name="id" value="<?= h($assignment['id']) ?>">

        <div class="form-actions">
            <button type="submit" class="btn-submit">更新する</button>
        </div>
    </form>
</div>



     <footer>

    </footer>

    <!-- jquery指定 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jsファイル指定、importを使用するためにはscript指定時に「type="module"」を入れないと動かない -->
    <script type="module" src="js/registration.js"></script>



</body>

</html>
