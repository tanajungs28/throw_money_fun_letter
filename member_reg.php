<?php
session_start();
//funcs.phpに記載している共通関数を呼び出し
require_once('funcs.php');
loginCheck();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メンバー登録</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_profile.css">
</head>

<body>
        <!-- ヘッダー情報 -->
        <header>
     <button id = "back_btn">
        <img src="pic/back.png" alt="" id = "btn_pic">
     </button>
     <div class="title_area">
            <div class="title">管理者メニュー　メンバー登録</div>
        </div>
     </header>

     <main>
     <!-- 登録情報入力部 -->
     <form action="member_insert.php" method="post" id = "profile_area" enctype="multipart/form-data">
        <input type="text" id = "group_id" name = "group_id" placeholder="グループID">
        <input type="text" id = "member_name" name = "member_name" placeholder="メンバー名">
        <input type="text" id = "content" name = "content" placeholder="メンバーの紹介コメント">
        <div>
            <label for="member_image">画像：</label>
            <input type="file" name="member_image" id="member_image">
        </div>
        <div id = send_btn_area>
            <input type="submit" value= "送信">
        </div>
    </form>

     </main>

    <!-- フッター情報 -->
    <footer>
      <div class="footer_title">アイドル口コミプラットフォーム</div>
      <div class="footer_menu">
        <a class=footerlink href="./user_reg.php">ユーザー登録</a>
        <a class=footerlink href="./user_list.php">ユーザー一覧</a>
        <a class=footerlink href="./login.php">ログイン</a>
        <a class=footerlink href="./logout.php">ログアウト</a>
        <a class=footerlink href="./index.php">アイドルグループ一覧</a>
        <a class=footerlink href="./idol_reg.php">アイドルグループ登録</a>
        <a class=footerlink href="./member_reg.php">メンバー登録</a>
      </div>
     </footer>


    <!-- jquery指定 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jsファイル指定、importを使用するためにはscript指定時に「type="module"」を入れないと動かない -->
    <script type="module" src="js/registration.js"></script>

</body>
</html>