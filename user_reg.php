<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規ユーザー登録</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_login.css">
    <!-- <link rel="stylesheet" href="css/style_reg.css"> -->
    <!-- <link rel="stylesheet" href="css/style_profile.css"> -->
</head>
<body>
    <!-- ヘッダー情報 -->

    <header class="lp-header">
        <div class="container header-container">
            <h1 class="logo">LiveEcho</h1>
        <!-- <div class="title_area"> -->
            <div class="title">新規ユーザー登録</div>
        <!-- </div> -->
    </header>

    
    <!--登録のウィンドウ  -->
     <div class="form-wrapper">
        <h1>Sign Up</h1>
        <form name="form1" action="user_reg_post.php" method="post">
            <div class="form-item">
                <label for="user_name"></label>
                <input type="text" name="uname" required="required" placeholder="名前を入力してください"></input>
            </div>
            <div class="form-item">
                <label for="email"></label>
                <input type="email" name="lid" required="required" placeholder="ユーザーID（メールアドレス）"></input>
            </div>
            <div class="form-item">
                <label for="password"></label>
                <input type="password" name="lpw" required="required" placeholder="パスワード"></input>
            </div>
            <div class="form-item">
                <label for="birthday"></label>
                <input type="date" name="birthday" required="required" placeholder="生年月日"></input>
            </div>
            <div class="form-item">
                <label for="gender" class="selectbox-5">
                <select name="gender">
                    <option value="">性別</option>
                    <option value="男性">男性</option>
                    <option value="女性">女性</option>
                </select>
                </label>
            </div>
            <div class="form-item">
                <label for="prefectures" class="selectbox-5">
                <select name="prefectures">
                    <option value="">お住いの地域</option>
                    <option value="北海道">北海道</option>
                    <option value="青森県">青森県</option>
                    <option value="岩手県">岩手県</option>
                    <option value="宮城県">宮城県</option>
                    <option value="秋田県">秋田県</option>
                    <option value="山形県">山形県</option>
                    <option value="福島県">福島県</option>
                    <option value="茨城県">茨城県</option>
                    <option value="栃木県">栃木県</option>
                    <option value="群馬県">群馬県</option>
                    <option value="埼玉県">埼玉県</option>
                    <option value="千葉県">千葉県</option>
                    <option value="東京都">東京都</option>
                    <option value="神奈川県">神奈川県</option>
                    <option value="新潟県">新潟県</option>
                    <option value="富山県">富山県</option>
                    <option value="石川県">石川県</option>
                    <option value="福井県">福井県</option>
                    <option value="山梨県">山梨県</option>
                    <option value="長野県">長野県</option>
                    <option value="岐阜県">岐阜県</option>
                    <option value="静岡県">静岡県</option>
                    <option value="愛知県">愛知県</option>
                    <option value="三重県">三重県</option>
                    <option value="滋賀県">滋賀県</option>
                    <option value="京都府">京都府</option>
                    <option value="大阪府">大阪府</option>
                    <option value="兵庫県">兵庫県</option>
                    <option value="奈良県">奈良県</option>
                    <option value="和歌山県">和歌山県</option>
                    <option value="鳥取県">鳥取県</option>
                    <option value="島根県">島根県</option>
                    <option value="岡山県">岡山県</option>
                    <option value="広島県">広島県</option>
                    <option value="山口県">山口県</option>
                    <option value="徳島県">徳島県</option>
                    <option value="香川県">香川県</option>
                    <option value="愛媛県">愛媛県</option>
                    <option value="高知県">高知県</option>
                    <option value="福岡県">福岡県</option>
                    <option value="佐賀県">佐賀県</option>
                    <option value="長崎県">長崎県</option>
                    <option value="熊本県">熊本県</option>
                    <option value="大分県">大分県</option>
                    <option value="宮崎県">宮崎県</option>
                    <option value="鹿児島県">鹿児島県</option>
                    <option value="沖縄県">沖縄県</option>
                </select>
                </label>
            </div>
            <div class="button-panel">
                <input type="submit" class="button" title="Sign In" value="SIGN UP"></input>
            </div>
            <div class="form-footer">
                <!-- <p><a href="user_reg.php">Create an account</a></p> -->
                <!-- <p><a href="#">Forgot password?</a></p> -->
            </div>
        </form>
    </div>

     <!-- </main> -->

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