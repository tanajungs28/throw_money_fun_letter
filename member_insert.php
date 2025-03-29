<?php
//funcs.phpに記載している共通関数を呼び出し
require_once('funcs.php');

//1. POSTデータ取得
$group_id = $_POST['group_id'];
$member_name = $_POST['member_name'];
$content = $_POST['content'];
$image_path = '';

// 画像アップロードの処理
$member_image = '';
if(isset($_FILES['member_image'])){
    //アップロードする画像をリネームする準備
    $upload_file = $_FILES['member_image']['tmp_name'];
    $extension = pathinfo($_FILES['member_image']['name'], PATHINFO_EXTENSION);
    $new_name = uniqid() . '.' . $extension; //余裕があれば拡張子が画像ファイル向けの拡張子になっているかの確認を入れたほうが〇

    //image_pathを確認
    $image_path = 'img/' . $new_name;

      // move_uploaded_file()で、一時的に保管されているファイルをimage_pathに移動させる。
    if (move_uploaded_file($upload_file, $image_path)) {
        $member_image = $image_path;
    }
}else{
    echo "画像が入ってません";
    exit;
}




//2.  DB接続します
$pdo = localdb_conn(); //ローカル環境


//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO 
                        member_list(id, group_id , member_name, member_image, content) 
                        VALUES(NULL, :group_id , :member_name, :member_image, :content)"
                      );

//  2. バインド変数を用意(セキュリティ対策で変数を1個かませる)
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$stmt->bindValue(':member_name', $member_name, PDO::PARAM_STR);
$stmt->bindValue(':member_image', $member_image, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();


//４．データ登録処理後
if($status === false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:'.$error[2]);
  }else{
    //５．profile_edit.phpへリダイレクト
    header('Location: member_list.php');
  
  }



