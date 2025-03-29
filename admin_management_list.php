<?php
//funcs.phpに記載している共通関数を呼び出し
require_once('funcs.php');
//2.  DB接続します
$pdo = localdb_conn(); //ローカル環境

$sql = "SELECT user_list_table.name AS admin_name, idol_list_table.group_name, admin_groups.id
        FROM admin_groups 
        JOIN user_list_table ON admin_groups.user_id = user_list_table.id
        JOIN idol_list_table ON admin_groups.group_id = idol_list_table.id";
$stmt = $pdo->query($sql);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
$status = $stmt->execute();


//３．データ表示
$view = '';
if ($assignments == false) {
    sql_error($stmt);
} else {
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<p>';
        $view .= '<a href="admin_groups_detail.php?id=' . $r["id"] . '">';
        $view .= h($r['admin_name']) . " " . h($r['group_name']);
        $view .= '</a>';
        $view .= "　";

        //管理フラグを持っていたら削除ボタンをひょじさせる
        // if($_SESSION['kanri_flg'] === 1){
            $view .= '<a class="btn btn-danger" href="admin_groups_delete.php?id=' . $r['id'] . '">';
            $view .= '[<i class="glyphicon glyphicon-remove"></i>削除]';
            $view .= '</a>';    
        // }
        $view .= '</p>';
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アイドル運営者の管理リスト</title>
    <!-- <link rel="stylesheet" href="css/reset.css"> -->
    <link rel="stylesheet" href="css/style_login.css">
    <link rel="stylesheet" href="css/style_profile.css">
    <link rel="stylesheet" href="css/style_management.css">
</head>

<body>
    <!-- ヘッダー情報 -->
    <header>
     <button id = "back_btn">
        <img src="pic/back.png" alt="" id = "btn_pic">
     </button>
     <div class="title_area">
            <div class="title">アイドル運営者登録</div>
        </div>
     </header>


    <table class="styled-table">
  <thead>
    <tr>
      <th>運営者名</th>
      <th>グループ名</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($assignments as $assignment): ?>
      <tr>
        <td><?= h($assignment['admin_name']) ?></td>
        <td><?= h($assignment['group_name']) ?></td>
        <td>
          <a class="edit-link" href="admin_groups_detail.php?id=<?= h($assignment['id']) ?>">編集</a>
          |
          <a class="delete-link" href="admin_groups_delete.php?id=<?= h($assignment['id']) ?>" onclick="return confirm('本当に削除しますか？');">削除</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<footer>

</footer>

    <!-- jquery指定 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jsファイル指定、importを使用するためにはscript指定時に「type="module"」を入れないと動かない -->
    <script type="module" src="js/registration.js"></script>


</body>
</html>
