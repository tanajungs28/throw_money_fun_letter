<?php 
        // 0. SESSION開始！！
        session_start();
        //データベース接続
        require_once('funcs.php');
        $pdo = localdb_conn(); //ローカル環境
        
        // GET パラメータからメンバーIDを取得
        $member_id = $_GET['member_id'] ?? null;
        $event_id = $_GET['event_id'] ?? null;

        if ($member_id === null) {
            exit('Error: group_id is missing.');
        }
        if (!$member_id || !$event_id) {
            echo "[event_id=", $event_id,"]";
            echo "[member_id=", $member_id,"]";
            exit('メンバーIDまたはイベントIDが不足しています');
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
                    'SELECT letter_list.message,letter_list.id,letter_list.amount,letter_list.status,letter_list.event_id, letter_list.release_status,letter_list.created_at
                    FROM letter_list
                    WHERE member_id = :member_id');
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $status = $stmt->execute();

        $release_status = $status['release_status'] ?? '';
        
        // --- イベント情報と意気込みコメントを取得 ---
        $event_stmt = $pdo->prepare("
        SELECT e.event_name, e.event_day, e.hashtag, em.message AS message
        FROM event_list e
        JOIN event_members em ON e.id = em.event_id
        WHERE e.id = :event_id AND em.member_id = :member_id
        ");
        $event_stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $event_stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $event_stmt->execute();
        $event_data = $event_stmt->fetch(PDO::FETCH_ASSOC);

        $event_name = $event_data['event_name'] ?? '';
        $event_day = $event_data['event_day'] ?? '';
        $hashtag = $event_data['hashtag'] ?? '';
        $message = $event_data['message'] ?? '';
        
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
                    $statuss[] = $result['status'];
                    $release_statuss[] = $result['release_status'];
                    $timestamps[] = $result['created_at'];
            }
            // 順番を新しい順に表示させるためひっくり返す
            $ids = array_reverse($ids);
            // データが空になっていると逆転できないので空の場合の処理を記載しておく
            if (!empty($messages) && is_array($messages)) {
                $messages = array_reverse($messages);
            } else {
                $messages = [];
            }
            if (!empty($amounts) && is_array($amounts)) {
                $amounts = array_reverse($amounts);
            } else {
                $amounts = [];
            }
            if (!empty($statuss) && is_array($statuss)) {
                $statuss = array_reverse($statuss);
            } else {
                $statuss = [];
            }
            if (!empty($timestamps) && is_array($timestamps)) {
                $timestamps = array_reverse($timestamps);
            } else {
                $imestamps = [];
            }
            if (!empty($release_statuss) && is_array($release_statuss)) {
                $release_statuss = array_reverse($release_statuss);
            } else {
                $release_statuss = [];
            }

        }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveEcho</title>
    <link rel="stylesheet" href="css/reset.css">
    <!-- <link rel="stylesheet" href="css/style_index.css"> -->
    <link rel="stylesheet" href="css/style_timeline.css">
    <link rel="stylesheet" href="css/style_comment_list.css">
    <link rel="stylesheet" href="css/style_letter_send.css">
    <link rel="stylesheet" href="css/style_common_header_footer.css">

    <!-- jquery指定 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jsファイル指定、importを使用するためにはscript指定時に「type="module"」を入れないと動かない -->
    <script type="module" src="js/registration.js"></script>
    <script type="module" src="js/throw_money.js"></script>

</head>

<body>
    <!-- ヘッダー -->
<?php
    //  権限に応じてヘッダーを読み込み
    if (isset($_SESSION['kanri_flg'])) {
        if ($_SESSION['kanri_flg'] == 99) {
            include 'header_admin.php';  // システム管理者
        } elseif ($_SESSION['kanri_flg'] == 1) {
            include 'header_owner.php';  // アイドル運営者
        } else {
            include 'header_general.php'; // 一般ユーザー
        }
    } else {
        include 'header_nologin.php'; // 未ログインも一般扱い
    }
?>


    <main>
    <!-- <div class=sidemenue>side_menue</div> -->
    <div class=content>
    <!--アイドルグループの基本ページ（グループ名・写真）  -->
        <div class = "image_name_block">
            <?php if ($member_image): ?>
                <img id="member_img" src="<?= htmlspecialchars($member_image, ENT_QUOTES, 'UTF-8') ?>" alt="グループ画像">
            <?php else: ?>
                <p>画像は登録されていません。</p>
            <?php endif; ?>
            <div class = "member_name"><?= htmlspecialchars($member_name, ENT_QUOTES, 'UTF-8') ?></div>
        </div>

        <div class="event-info">
    <h2>イベント情報</h2>
    <p><strong>イベント名：</strong><?= h($event_name) ?></p>
    <p><strong>開催日：</strong><?= h($event_day) ?></p>
    <p><strong>ハッシュタグ：</strong>#<?= h($hashtag) ?></p>
    <p><strong>意気込み：</strong><?= nl2br(h($message)) ?></p>
</div>

<!-- メッセージ投稿セクション -->
<div class="form-section">
    <h1>ファンレターを送る</h1>
    <form action="letter_insert.php" method="post" id="tweet_area">
        <label>メッセージ内容</label>
        <input type="text" name="message" placeholder="応援メッセージを入力してください">
        <!-- 投げ銭スイッチ -->
        <div class="switch-container">
            <label class="switch-label">投げ銭する？</label>
            <label class="switch">
                <input type="checkbox" id="toggle-throw" name="throw_switch"  checked>
                <span class="slider"></span>
            </label>
        </div>
        <!-- 金額スライダー -->
        <div id="throw-money-area">
            <label>投げ銭金額（0〜10,000円）</label>
            <p><span id="current-value"></span> 円</p>
            <input type="range" name="amount" min="0" max="10000" step="100" id="example">
        </div>
        <!-- メッセージの公開・非公開の設定 -->
        <label>公開・非公開設定</label>
        <select name="status" required>
            <option value="">選択してください</option>
            <option value="open">ファンレターを公開する</option>
            <option value="close">ファンレターを公開しない</option>
        </select>
        <!-- Hidden：メンバーIDとイベントIDをPOSTする -->
        <input type="hidden" name="member_id" value="<?= h($member_id) ?>">
        <input type="hidden" name="event_id" value="<?= h($event_id) ?>">

        <button type="submit" class="send_btn">送信</button>
    </form>
</div>


<h1 class="sub_title">みんなからのファンレター</h1>
<div id="timeline">
    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $key => $message): ?>
            <!-- 決済完了or投げ銭なしの投稿のステータスになっているかチェック -->
            <?php if ($release_statuss[$key] === "completed"): ?>
            <div class="tweet-card">
                    <!-- 公開・非公開の設定に応じてファンレターの公開範囲を変更 -->
                    <?php if ($statuss[$key] === "open"): ?>
                        <p class="tweet-content"><?= h($message) ?></p>
                        <p class="tweet-content">投げ銭: <?= h($amounts[$key]) ?>円</p>
                    <?php else: ?>
                        <p class="tweet-content">非公開のファンレター</p>
                    <?php endif; ?>
                    <span class="tweet-time"><?= h(date('Y-m-d H:i', strtotime($timestamps[$key]))) ?></span>
                </div>
            <?php else: ?>
                <!-- ステータスがcompletedになってなければメッセージを公開しない -->
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>まだファンレターがありません。</p>
    <?php endif; ?>

</div>



    </main>


    <!-- フッター情報 -->
    <?php
// ページ末尾でフッター切り替え
if (isset($_SESSION['kanri_flg'])) {
    if ($_SESSION['kanri_flg'] == 99) {
        include 'footer_admin.php';
    } elseif ($_SESSION['kanri_flg'] == 1) {
        include 'footer_owner.php';
    } else {
        include 'footer_general.php';
    }
} else {
    include 'footer_general.php';
}
?>

    
    <script>
        $(function () {
            $('#toggle-throw').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#throw-money-area').slideDown();
                } else {
                    $('#throw-money-area').slideUp();
                    $('#example').val(0); // 0円にリセットするなど
                    $('#current-value').text(0); // 0円にリセットするなど
                }
            });

            // 初期化
            $('#throw-money-area').toggle($('#toggle-throw').is(':checked'));

            // スライダーの値表示
            $('#example').on('input', function () {
                $('#current-value').text($(this).val());
            });
        });
    </script>


</body>
</html>