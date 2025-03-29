<?php 
    // 0. SESSION開始！！
    session_start();
    //データベース接続
    require_once('funcs.php');
    $pdo = localdb_conn(); //ローカル環境

    // アイドル管理者（role = 'admin' のユーザー）を取得
    $stmt = $pdo->prepare("SELECT id, name FROM user_list_table WHERE role = 'admin'");
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // アイドルグループを取得
    $stmt = $pdo->prepare("SELECT id, group_name FROM idol_list_table");
    $stmt->execute();
    $idol_groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アイドル運営者登録</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_login.css">
    <link rel="stylesheet" href="css/style_profile.css">
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

    <!--登録のウィンドウ  -->
     <div class="form-wrapper">
        <h1>アイドル運営者登録</h1>
        <form name="form1" action="admin_groups_insert.php" method="post">
            <div class="form-item">
                <label for="admin_id" class="selectbox-5">
                    <select name="admin_id" required>
                    <option value="">アイドル運営者</option>
                    <?php foreach ($admins as $admin): ?>
                        <option value="<?= htmlspecialchars($admin['id']) ?>">
                            <?= htmlspecialchars($admin['name']) ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <div class="form-item">
                <label for="idol_group_id" class="selectbox-5">
                    <select name="idol_group_id" required>
                        <option value="">アイドルグループ</option>
                        <?php foreach ($idol_groups as $group): ?>
                            <option value="<?= htmlspecialchars($group['id']) ?>">
                                <?= htmlspecialchars($group['group_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <div class="button-panel">
                <input type="submit" class="button" title="Sign In" value="登録"></input>
            </div>
            <div class="form-footer">
                <!-- <p><a href="user_reg.php">Create an account</a></p> -->
                <!-- <p><a href="#">Forgot password?</a></p> -->
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