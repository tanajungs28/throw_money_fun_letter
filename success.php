<?php
session_start();
//2. DB接続します
require_once('funcs.php');
$pdo = localdb_conn(); //ローカル環境

if (!isset($_SESSION['letter_id'])) {
    die("エラー: 登録されたファンレターがありません");
}

$letter_id = $_SESSION['letter_id'];
$member_id = $_SESSION['member_id'];
$event_id = $_SESSION['event_id'];
$userMessage = $_SESSION['message'];

// ステータスを「completed」に更新
$stmt = $pdo->prepare("UPDATE letter_list SET release_status = 'completed' WHERE id = ?");
$stmt->execute([$letter_id]);

// セッションから削除（不要になったため）
unset($_SESSION['letter_id']);


// イベントのハッシュタグを取得
$tag_stmt = $pdo->prepare("SELECT hashtag FROM event_list WHERE id = :event_id");
$tag_stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$tag_stmt->execute();
$event_data = $tag_stmt->fetch(PDO::FETCH_ASSOC);

// デフォルトハッシュタグ（登録されていない場合用）
$hashtag = $event_data['hashtag'] ?? 'ファンレター';

// ハッシュタグが「#」で始まっていない場合は付け足す
if (strpos($hashtag, '#') !== 0) {
    $hashtag = '#' . $hashtag;
}

require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

// 認証情報
$consumerKey = 'dkVa10eW1pVxYgpG21cdcbV7x'; //API_KEY
$consumerSecret = 'BucqQCwsMSRMKjcxVr3Y5vRyC5L5vNSVDggETMNC9edCGZSGyV'; //API_SECRET
$accessToken = '1756945997601832961-ebm87tWqmVMSoiKzdL0PVNTcRgCpXs'; //ACCESS_TOKEN
$accessTokenSecret = '5sMCGPDK0iMJKYLQsrw0eo54QQ7cMIy52gV8IdNpoO25g'; //ACCESS_TOKEN_SECRET


// ユーザーからのメッセージ（例）
$userMessage = $_SESSION['message'];
// 投稿する文面（例：「#タグ #タグ 応援ありがとう！」）
// $userMessage = $userMessage . ' ' . $tagText;
$postText = $userMessage . ' ' . $hashtag;

// 不適切な投稿を防ぐためのフィルタなどは実装必須です

// 接続
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

// 投稿
// イベント情報からX連携フラグとハッシュタグを取得
$event_stmt = $pdo->prepare("
  SELECT twitter_post, hashtag FROM event_list
  WHERE id = :event_id
");
$event_stmt->bindValue(':event_id', $_SESSION['event_id'], PDO::PARAM_INT);
$event_stmt->execute();
$event_data = $event_stmt->fetch(PDO::FETCH_ASSOC);

if ($event_data && $event_data['twitter_post'] == 1) {
  $hashtag = '#' . $event_data['hashtag'];
  $userMessage = $_SESSION['message'] . ' ' . $hashtag;

  // Twitter連携（TwitterOAuth）
  $twitterResponse = $connection->post("tweets", [
    "text" => $userMessage
  ]);

// エラーハンドリング
if (empty($userMessage) || strlen($userMessage) > 280) {
    die("エラー: メッセージが空か、280文字を超えています");
}

}

if ($connection->getLastHttpCode() == 200 ||$connection->getLastHttpCode() == 201 ||$connection->getLastHttpCode() == 204) {
    echo "投稿成功！";
} else {
    echo "投稿失敗...";
    echo "メッセージ内容：", $userMessage;
    $httpCode = $connection->getLastHttpCode();
    $errorDetails = $connection->getLastBody();    
    echo "HTTP ステータスコード: " . $httpCode . "<br>";
    echo "エラーレスポンス: <pre>" . print_r($errorDetails, true) . "</pre>";
    echo "エラーメッセージ：",$twitterResponse; // Twitter APIのエラーメッセージを表示
    print_r($twitterResponse); // Twitter APIのエラーメッセージを表示
    // 詳細なエラー情報を取得
    //    echo "<pre>";
    //    print_r($connection->getLastBody()); // Twitter API の詳細なレスポンスを取得
    //    echo "</pre>";
}


// メンバーのメッセージ一覧ページへリダイレクト
header("Location: letter_send.php?member_id={$member_id}&event_id={$event_id}");
exit();
?>
