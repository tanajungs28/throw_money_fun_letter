<?php

// echo "ログイン処理画面";


//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値を受け取る
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

//1.  DB接続します
require_once('funcs.php');
$pdo = localdb_conn();

//2. データ登録SQL作成
// gs_user_tableに、IDとWPがあるか確認する。
$stmt = $pdo->prepare('SELECT * FROM user_list_table where lid = :lid AND lpw = :lpw;');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
//trueならその下が実行される
if($status === false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();

//if(password_verify($lpw, $val['lpw'])){ //* PasswordがHash化の場合はこっちのIFを使う
if( $val['id'] != ''){
    //Login成功時 該当レコードがあればSESSIONに値を代入
    $_SESSION['id'] = $val['id'];
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['name'] = $val['lid'];
    $_SESSION['kanri_flg'] = $val['kanri_flg'];

    header('Location: index.php');
}else{
    //Login失敗時(Logout経由)

    header('Location: login.php');
}

exit();


?>