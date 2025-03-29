<?php
if (!isset($_GET['member_id'])) {
    $member_id = "";
}else{
    $member_id = $_GET['member_id'];
}
if (!isset($_GET['event_id'])) {
    $event_id = "";
}else{
    $event_id = $_GET['event_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_login.css">
    <!-- <link rel="stylesheet" href="css/style_profile.css"> -->
</head>
<body>

        <!-- ヘッダー情報 -->
    <header class="lp-header">
        <div class="container header-container">
            <h1 class="logo">LiveEcho</h1>
        </div>
    </header>

    <!-- ログイン部分 -->
    <div class="form-wrapper">
        <h1>Sign In</h1>
        <form name="form1" action="login_act.php" method="post">
            <div class="form-item">
                <label for="email"></label>
                <input type="text" name="lid" required="required" placeholder="メールアドレス"></input>
            </div>
            <div class="form-item">
                <label for="password"></label>
                <input type="password" name="lpw" required="required" placeholder="パスワード"></input>
            </div>
            <div class="button-panel">
                <input type="submit" class="button" title="Sign In" value="LOGIN"></input>
            </div>
            <div class="form-footer">
                <p><a href="user_reg.php">Create an account</a></p>
                <!-- <p><a href="#">Forgot password?</a></p> -->
            </div>
            <input type="hidden" id = "member_id" name = "member_id" value = "<?= htmlspecialchars($member_id, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" id = "event_id" name = "event_id" value = "<?= htmlspecialchars($event_id, ENT_QUOTES, 'UTF-8') ?>">
        </form>
    </div>


<!-- Footer -->
<footer class="footer">
  <div class="container">
    <p>&copy; 2025 LiveEcho. All rights reserved.</p>
  </div>
</footer>


<!-- jquery指定 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- jsファイル指定、importを使用するためにはscript指定時に「type="module"」を入れないと動かない -->
<script type="module" src="js/registration.js"></script>


</body>
</html>