<?php 
        // 0. SESSION開始！！
        session_start();
        //データベース接続
        require_once('funcs.php');
        $pdo = localdb_conn(); //ローカル環境
        
        // GET パラメータからメンバーIDを取得
        $member_id = $_GET['member_id'] ?? null;

        if ($member_id === null) {
            exit('Error: group_id is missing.');
        }

        // 1. メンバー名を取得
        $member_name_stmt = $pdo->prepare(
            'SELECT member_name,member_image 
            FROM member_list 
            WHERE id = :member_id'
        );
        $member_name_stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $member_name_status = $member_name_stmt->execute();

        if ($member_name_status === false) {
            $error = $member_name_stmt->errorInfo();
            exit('SQLError(member_name fetch):' . print_r($error, true));
        } else {
            $member_data = $member_name_stmt->fetch(PDO::FETCH_ASSOC);
            $member_name = $member_data['member_name'] ?? '不明なグループ';
            $member_image = $member_data['member_image'] ?? null; // 画像がない場合はnull
        }

        //２．データ登録SQL作成
        $stmt = $pdo->prepare
                    (
                    'SELECT letter_list.message,letter_list.id,letter_list.amount
                    FROM letter_list
                    WHERE member_id = :member_id');
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $status = $stmt->execute();
        

        //３．データ表示
        $view = '';
        $tweets = [];
        $ids = [];
        if ($status === false) {
            $error = $stmt->errorInfo();
            exit('SQLError:' . print_r($error, true));
        } else {
            //1行ずつデータベースから結果を取り出して配列に格納($resultは連想配列)
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $messages[] = $result['message'];
                $amounts[] = $result['amount'];
                $ids[] = $result['id'];
            }
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投げ銭ファンレター</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_index.css">
    <link rel="stylesheet" href="css/style_timeline.css">
    <link rel="stylesheet" href="css/style_comment_list.css">
    <link rel="stylesheet" href="css/style_letter_send.css">
    <!-- jquery指定 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jsファイル指定、importを使用するためにはscript指定時に「type="module"」を入れないと動かない -->
    <script type="module" src="js/registration.js"></script>
    <script type="module" src="js/throw_money.js"></script>

</head>


<body>
    <!-- ヘッダー -->
    <header>
        <div class="title_area">
            <div class="title"><?= htmlspecialchars($member_name, ENT_QUOTES, 'UTF-8') ?>へファンレターを送る</div>
            <div class="user_reg_area">
              <?php if (isset($_SESSION['name'])): ?>
                <span class="username"><?= htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8'); ?> さん</span>
                <a class="logout_btn" href="./logout.php">ログアウト</a>
              <?php else: ?>
                <a class="login_btn" href="./login.php">ログイン</a>
                <a class="userreg_btn" href="./user_reg.php">新規登録</a>
              <?php endif; ?>
            </div>

        </div>
        <!-- ハンバーガーメニュー -->
        <input type="checkbox" class="menu-btn" id="menu-btn">
        <label for="menu-btn" class="menu-icon">
            <span class="navicon"></span>
        </label>
            <ul class="menu">
                <li class="top"><a href="./user_reg.php">ユーザー登録</a></li>
                <li><a href="./user_list.php">ユーザー一覧</a></li>
                <li><a href="./login.php">ログイン</a></li>
                <li><a href="./logout.php">ログアウト</a></li>
                <li><a href="./index.php">アイドルグループ一覧</a></li>
                <li><a href="./idol_reg.php">アイドルグループ登録</a></li>
                <li><a href="./member_reg.php">メンバー登録</a></li>
            </ul>
    </header>
    
    <main>
    <!-- <div class=sidemenue>side_menue</div> -->
    <div class=content>
    <!--アイドルグループの基本ページ（グループ名・写真）  -->
    <div id="member_image_area">
        <div class = "image_name_block">
            <?php if ($member_image): ?>
                <img id="member_img" src="<?= htmlspecialchars($member_image, ENT_QUOTES, 'UTF-8') ?>" alt="グループ画像">
            <?php else: ?>
                <p>画像は登録されていません。</p>
            <?php endif; ?>
            <div class = "member_name"><?= htmlspecialchars($member_name, ENT_QUOTES, 'UTF-8') ?></div>
        </div>
    </div>




     <!-- メッセージ入力部 -->
      <h1 class = "messeage_title">メッセージ</h1>
     <form action="letter_insert.php" method="post" id = "tweet_area">
        <input type="text" id = "comment" name = "message" placeholder="メッセージを入力">

        <!-- 投げ銭金額入力部 -->
        <div class = "throw_money_area">
            <div>投げ銭金額</div>
            <p><span id="current-value"></span>円</p>
            <input type="range" id="example" name = "amount" min="100" max="10000" step="100">
        </div>
        <!-- 公開/非公開の選択 -->
        <label class="selectbox-5">
            <select name="status" required>
                <option value="">公開・非公開を選択してください</option>
                <option value="open">ファンレターを公開する</option>
                <option value="close">ファンレターを公開しない</option>
            </select>
        </label>

        <div id = send_btn_area>
            <!-- <input class = "send_btn" type="submit" value= "送信"> -->
            <button type="submit" class="send_btn" id="submitBtn">送信</button>
            <input type="hidden" id = "member_id" name = "member_id" value = "<?= htmlspecialchars($member_id, ENT_QUOTES, 'UTF-8') ?>">
            <!-- <input type="hidden" id = "group_name_id" name = "group_name_id" value = "<?= htmlspecialchars($group_id, ENT_QUOTES, 'UTF-8') ?>"> -->
        </div>
    </form>



    <!-- タイムラインを表示 -->
    <h1 class = "sub_title">みんなからのファンレター</h1>
    <div id="timeline">
   <!-- $tweetsが空でないときに実行 -->
       <?php if (!empty($messages)): ?>
        <!-- 配列の要素を1個ずつ取り出し、要素（$tweet）に代入して処理を繰り返す -->
        <!-- array_revers関数を使用して新しい順に表示させる -->
        <?php $messages = array_reverse($messages); ?>
        <?php $amounts = array_reverse($amounts); ?>
        <?php $ids = array_reverse($ids); ?>
        
        <?php foreach (array_reverse($messages) as $key => $message): ?>
            <div class="tweet-card">
            <!-- ミートボールの表示 -->
           <?php if(isset($_SESSION['kanri_flg']) && ($_SESSION['kanri_flg'] === 1)): ?>

            <button class="meatball">
                    <span class="meatball-ball"></span>
                    <span class="meatball-ball"></span>
                    <span class="meatball-ball"></span>
            </button>
                <!-- ミートボール押したときの表示メニュー -->
                <div class="menu-container">
                    <div class="submenu">
                <?php var_dump($ids[$key]);?>
                        <ul>
                            <li><a href="tweet_delete.php?id=<?php echo $ids[$key] ?>">削除</a></li>
                            <li><a href="tweet_edit.php?id=<?php echo $ids[$key] ?>">編集</a></li>
                            <li><a href="#">未実装</a></li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
            <?php endif; ?>
                <!-- 入力したテキストと時間を表示 -->
                <!-- <p class="tweet-content"><?php echo $message; ?></p> -->
                <!-- <p class="tweet-content"><?php echo $amount; ?></p> -->
                <p class="tweet-content"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="tweet-content">投げ銭: <?php echo htmlspecialchars($amounts[$key], ENT_QUOTES, 'UTF-8'); ?> 円</p>
                <span class="tweet-time"><?php echo date('Y-m-d H:i:s'); ?></span>
                
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>まだファンレターがありません。</p>
    <?php endif; ?>

    </div>
    </div>
    </main>


    <!-- フッター情報 -->
    <footer>
      <div class="footer_title">アイドル口コミプラットフォーム</div>
      <div class="footer_menu">
        <a class=footerlink href="./user_reg.php">ユーザー登録</a>
        <a class=footerlink href="./user_list.php">ユーザー一覧</a>
        <a class=footerlink href="./login.php">ログイン</a>
        <a class=footerlink href="./logout.php">ログアウト</a>
        <a class=footerlink href="./idol_list.php">アイドルグループ一覧</a>
        <a class=footerlink href="./idol_reg.php">アイドルグループ登録</a>
      </div>

     </footer>
    


</body>
</html>