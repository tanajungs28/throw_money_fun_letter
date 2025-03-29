<?php 
//funcs.phpに記載している共通関数を呼び出し
require_once('funcs.php');
session_start();

//1. POSTデータ取得
$user_id = $_POST['admin_id'];
$group_id = $_POST['idol_group_id'];

//2.  DB接続します
$pdo = localdb_conn(); //ローカル環境


//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare(
                    "INSERT INTO 
                      admin_groups(
                      id, user_id, group_id
                      ) 
                      VALUES(
                      NULL, :user_id, :group_id
                      );"
                      );

//  2. バインド変数を用意(セキュリティ対策で変数を1個かませる)
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();


// 4. 処理結果をJSON形式で返す
if ($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:'.$error[2]);
} else {
    header('Location: index.php');
}
?>