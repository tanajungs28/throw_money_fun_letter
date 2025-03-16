<?php 
        // 0. SESSION開始！！
        session_start();
        //データベース接続
        require_once('funcs.php');
        $pdo = localdb_conn(); //ローカル環境
        
        // GET パラメータからグループIDを取得
        $group_id = $_GET['group_id'] ?? null;

        if ($group_id === null) {
            exit('Error: group_id is missing.');
        }

        // 1. アイドルグループ名を取得
        $group_name_stmt = $pdo->prepare(
            'SELECT group_name,group_image 
            FROM idol_list_table 
            WHERE id = :group_id'
        );
        $group_name_stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
        $group_name_status = $group_name_stmt->execute();

        if ($group_name_status === false) {
            $error = $group_name_stmt->errorInfo();
            exit('SQLError(group_name fetch):' . print_r($error, true));
        } else {
            $group_data = $group_name_stmt->fetch(PDO::FETCH_ASSOC);
            $group_name = $group_data['group_name'] ?? '不明なグループ';
            $group_image = $group_data['group_image'] ?? null; // 画像がない場合はnull
        }

        //２．データ登録SQL作成
        $stmt = $pdo->prepare
                    (
                    // 'SELECT comment_list_table.comment,comment_list_table.id,comment_list_table.group_name_id,idol_list_table.group_name
                    'SELECT comment_list_table.comment,comment_list_table.id,comment_list_table.group_name_id
                    FROM comment_list_table 
                    JOIN user_list_table ON comment_list_table.user_id = user_list_table.id
                    -- JOIN idol_list_table ON comment_list_table.group_name_id = idol_list_table.group_name 
                    WHERE comment_list_table.group_id = :group_id');
        $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT); // :group_id をバインド            
        $status = $stmt->execute();
        

        //３．データ表示
        $view = '';
        $tweets = [];
        $ids = [];
        // $group_name = '';
        if ($status === false) {
            $error = $stmt->errorInfo();
            exit('SQLError:' . print_r($error, true));
        } else {
            //1行ずつデータベースから結果を取り出して配列に格納($resultは連想配列)
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $comments[] = $result['comment'];
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
</head>


<body>
    <!-- ヘッダー -->
    <header>
        <div class="title_area">
            <div class="title"><?= htmlspecialchars($group_name, ENT_QUOTES, 'UTF-8') ?></div>
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
    <div class=sidemenue>side_menue</div>
    <div class=content>
    <!--アイドルグループの基本ページ（グループ名・写真）  -->
    <div id="group_image_area">
        <?php if ($group_image): ?>
            <img id="group_img" src="<?= htmlspecialchars($group_image, ENT_QUOTES, 'UTF-8') ?>" alt="グループ画像">
        <?php else: ?>
            <p>画像は登録されていません。</p>
        <?php endif; ?>
    </div>

    <!-- メンバー情報の表示 -->
        <h3 class = "sub_title">＜メンバーにファンレターを送る＞</h3>
            <ul class="member_info_area">
                <?php
                // グループに所属するメンバーを取得
                $stmt = $pdo->prepare("SELECT * FROM member_list WHERE group_id = ?");
                $stmt->execute([$group_id]);
                $members = $stmt->fetchAll();

                if ($members):
                    foreach ($members as $member):
                ?>
                        <li class = "member_list_area">
                            <!-- <a href="./letter_send.php?member_id=' . h($result['id']) . '"> -->
                            <a href="./letter_send.php?member_id=<?= htmlspecialchars($member['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <strong><?php echo htmlspecialchars($member['member_name']); ?></strong><br>
                            <img src="<?php echo htmlspecialchars($member['member_image']); ?>" alt="メンバー画像" width="100"><br>
                            <!-- <p><?php echo nl2br(htmlspecialchars($member['content'])); ?></p> -->
                        </li>
                <?php
                    endforeach;
                else:
                    echo "<p>メンバーが登録されていません。</p>";
                endif;
                ?>
            </ul>



    <!-- タイムライン -->
     <!-- ツイート入力部 -->
     <!-- <form action="comment_insert.php" method="post" id = "tweet_area">
        <input type="text" id = "comment" name = "comment" placeholder="アイドルに対する口コミを入力">
        <div id = send_btn_area>
            <input type="submit" value= "送信">
            <input type="hidden" id = "group_id" name = "group_id" value = "<?= htmlspecialchars($group_id, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" id = "group_name_id" name = "group_name_id" value = "<?= htmlspecialchars($group_id, ENT_QUOTES, 'UTF-8') ?>">
        </div>
    </form> -->

    <!-- タイムラインを表示 -->
    <!-- <div id="timeline"> -->
   <!-- $tweetsが空でないときに実行 -->
   <!-- <?php if (!empty($comments)): ?> -->
        <!-- 配列の要素を1個ずつ取り出し、要素（$tweet）に代入して処理を繰り返す -->
         <!-- array_revers関数を使用して新しい順に表示させる -->
       <!-- <?php $ids = array_reverse($ids); ?>
        <?php foreach (array_reverse($comments) as $key => $comment): ?>
            <div class="tweet-card"> -->
            <!-- ミートボールの表示 -->
           <!-- <?php if(isset($_SESSION['kanri_flg']) && ($_SESSION['kanri_flg'] === 1)): ?>

            <button class="meatball">
                    <span class="meatball-ball"></span>
                    <span class="meatball-ball"></span>
                    <span class="meatball-ball"></span>
            </button> -->
                <!-- ミートボール押したときの表示メニュー -->
                <!-- <div class="menu-container">
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
            <?php endif; ?> -->
                <!-- 入力したテキストと時間を表示 -->
                <!-- <p class="tweet-content"><?php echo $comment; ?></p>
                <span class="tweet-time"><?php echo date('Y-m-d H:i:s'); ?></span>
                
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>まだツイートがありません。</p>
    <?php endif; ?> -->

    </div>
    </div>
    </main>


    <!-- フッター情報 -->
    <footer>
      <div class="footer_title">投げ銭ファンレター</div>
      <div class="footer_menu">
        <a class=footerlink href="./user_reg.php">ユーザー登録</a>
        <a class=footerlink href="./user_list.php">ユーザー一覧</a>
        <a class=footerlink href="./login.php">ログイン</a>
        <a class=footerlink href="./logout.php">ログアウト</a>
        <a class=footerlink href="./idol_list.php">アイドルグループ一覧</a>
        <a class=footerlink href="./idol_reg.php">アイドルグループ登録</a>
      </div>

     </footer>
    
    <!-- jquery指定 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jsファイル指定、importを使用するためにはscript指定時に「type="module"」を入れないと動かない -->
    <script type="module" src="js/registration.js"></script>


</body>
</html>