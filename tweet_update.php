<?php 
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);


//1. POSTデータ取得
if (empty($_POST['id']) || empty($_POST['tweet'])) {
  exit('Missing POST data: ID or Tweet is empty');
}
$id    = $_POST['id'];
$tweet = $_POST['tweet'];

//2.  DB接続します
require_once('funcs.php');
$pdo = localdb_conn(); //ローカル環境

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare('UPDATE 
                            timeline_table
                        SET
                            uname   = :uname,
                            tweet   = :tweet,
                            time    =  now()
                        WHERE
                            id      = :id;
                      ');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':uname', "", PDO::PARAM_STR);
$stmt->bindValue(':tweet', $tweet, PDO::PARAM_STR);
// $stmt->bindValue(':time', "", PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    echo 'Error details: ' . print_r($error, true);
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    // header('Location: https://tanajun.sakura.ne.jp/SNS_app/index.php');
    header('Location: index.php');
    exit();
}

?>