<?php
session_start();
require_once('funcs.php');
loginCheck();
$pdo = localdb_conn();

// POSTデータ取得
$id = $_POST['id'];
$member_name = $_POST['member_name'];
// $profile = $_POST['profile'];
$group_id = $_POST['group_id'];
$member_image = $_POST['existing_image']; // 初期値は既存画像のまま
$existing_image = $_POST['existing_image'] ?? '';


// ファイルがアップロードされたか確認
if (isset($_FILES['member_image_file']) && $_FILES['member_image_file']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $tmp_name = $_FILES['member_image_file']['tmp_name'];
    $file_name = basename($_FILES['member_image_file']['name']);
    $upload_path = $upload_dir . uniqid() . '_' . $file_name;

    if (move_uploaded_file($tmp_name, $upload_path)) {
        $member_image = $upload_path;
    } else {
        exit('画像のアップロードに失敗しました。');
    }
}

// SQL更新
$sql = "UPDATE member_list 
        SET member_name = :member_name, member_image = :member_image 
        WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':member_name', $member_name, PDO::PARAM_STR);
// $stmt->bindValue(':profile', $profile, PDO::PARAM_STR);
$stmt->bindValue(':member_image', $member_image, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

if ($status === false) {
    $error = $stmt->errorInfo();
    exit('DB更新エラー:' . print_r($error, true));
} else {
    header("Location: member_list.php");
    exit();
}
?>
