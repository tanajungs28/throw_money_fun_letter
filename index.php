<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>LiveEcho - アイドル活動を応援するファンレターサービス</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style_lp.css">
</head>
<body>

<!--ヘッダー  -->
<header class="lp-header">
  <div class="container header-container">
    <h1 class="logo">LiveEcho</h1>
    <div class="menu-icon" id="menu-icon">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <nav class="nav" id="nav-menu">
      <a href="#about" class="header_link">サービス概要</a>
      <a href="#features" class="header_link">機能</a>
      <a href="#cta" class="header_link">無料登録</a>
      <a href="./login.php" class="login-btn">ログイン</a>
    </nav>
  </div>
</header>

<!--ヒーロー画像 -->
<section class="hero">
  <div class="hero-image">
    <img src="img/hero_img.png" alt="ライブのヒーロービジュアル">
    <div class="hero-text">
      <h1>ライブの余韻を、ありがとうに。</h1>
      <p>ファンの「今日最高だった」をカタチにして届ける。</p>
      <a href="#cta" class="cta-btn">無料で始める</a>
    </div>
  </div>
</section>

<!-- About -->
<section id="about" class="about">
  <div class="container">
    <h2>LiveEchoとは？</h2>
    <p>
      ライブ後の感動を「投げ銭付きファンレター」に。<br>
      地下アイドルや小規模グループがパフォーマンスで<br>
      収益化できる、新しい応援のカタチを提供します。
    </p>
  </div>
</section>

<!-- Features -->
<section id="features" class="features">
  <div class="container">
    <h2 class="section-title">主な機能</h2>
    <div class="feature-grid">

      <div class="feature-box">
        <img src="img/feature_message.png" alt="ファンレター投稿">
        <h3>ライブ後の感謝メッセージ投稿</h3>
        <p>高まる気持ちをそのまま言葉で届ける。タイムライン形式で共感も広がります。</p>
      </div>

      <div class="feature-box">
        <img src="img/feature_manage.png" alt="イベント管理">
        <h3>イベント・メンバー管理</h3>
        <p>運営者が簡単にイベントやメンバー情報を管理可能。コメント入力や編集もスムーズに。</p>
      </div>

      <div class="feature-box">
        <img src="img/feature_payment.png" alt="投げ銭決済">
        <h3>投げ銭付きファンレター</h3>
        <p>Stripe連携で投げ銭機能を実現。ライブの感動がそのまま収益に。</p>
      </div>

      <div class="feature-box">
        <img src="img/feature_sns.png" alt="X連携">
        <h3>SNS連携</h3>
        <p>X（旧Twitter）へ自動投稿。感謝の言葉がハッシュタグ付きで広がります。</p>
      </div>

    </div>
  </div>
</section>

<!-- Call to Action -->
<section id="cta" class="cta">
  <div class="container">
    <h2>今すぐ無料で始めよう</h2>
    <p class="end_message">アイドル活動を“感謝”と“収益”で支える新しい仕組み、<br>まずはあなたのグループから。</p>
    <a href="https://docs.google.com/forms/d/e/1FAIpQLSe5eqdKArgdu7S9PcDEw49qnIhDm1aXi3uq35YuZ2pc9_RJ2A/viewform?usp=dialog" class="cta-btn">無料で始める</a>
</div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <p>&copy; 2025 LiveEcho. All rights reserved.</p>
  </div>
</footer>

<script>
  document.getElementById('menu-icon').addEventListener('click', function () {
    this.classList.toggle('active');
    document.getElementById('nav-menu').classList.toggle('open');
  });
</script>


</body>
</html>
