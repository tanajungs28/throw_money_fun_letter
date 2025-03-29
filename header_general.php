<?php
    // GET パラメータからメンバーIDを取得
    $member_id = $_GET['member_id'] ?? null;
    $event_id = $_GET['event_id'] ?? null;
?>

<header>
  <div class="title_area">
    <div class="title">LiveEcho</div>
    <div class="user_reg_area">
      <a href="logout.php" class="logout_btn">ログアウト</a>
      <!-- <a href='login.php?member_id=<?=h($member_id)?>&event_id=<?=h($event_id)?>' class="login_btn">ログイン</a> -->
      <!-- <a href="index.php" class="userreg_btn">トップへ</a> -->
    </div>
  </div>
</header>
