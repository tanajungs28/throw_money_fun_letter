<?php 
//funcs.phpに記載している共通関数を呼び出し
require_once('funcs.php');
session_start();

//1. POSTデータ取得
$group_id = $_POST['group_id'];
$event_name = $_POST['event_name'];
$event_day = $_POST['event_day'];
$hashtag = $_POST['hashtag'];
$twitter_post = isset($_POST['twitter_post']) ? 1 : 0;

//2.  DB接続します
$pdo = localdb_conn(); //ローカル環境


//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare(
                    "INSERT INTO 
                      event_list(
                      id, group_id,event_name, event_day, hashtag, created_at, twitter_post
                      ) 
                      VALUES(
                      NULL, :group_id, :event_name, :event_day, :hashtag, NOW(), :twitter_post
                      );"
                      );

//  2. バインド変数を用意(セキュリティ対策で変数を1個かませる)
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$stmt->bindValue(':event_name', $event_name, PDO::PARAM_STR);
$stmt->bindValue(':event_day', $event_day, PDO::PARAM_STR);
$stmt->bindValue(':hashtag', $hashtag, PDO::PARAM_STR);
$stmt->bindValue(':twitter_post', $twitter_post, PDO::PARAM_INT);

//  3. 実行
$status = $stmt->execute();


// 4. 処理結果をJSON形式で返す
if ($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:'.$error[2]);
} else {
    header('Location: event_list.php');
}
?>