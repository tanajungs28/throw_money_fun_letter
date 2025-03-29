<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require 'vendor/autoload.php'; // Stripeライブラリを読み込む

// セッションで金額を受け取る
$amount = isset($_SESSION['amount']) ? intval($_SESSION['amount']) : 0;
// 処理完了後のページ遷移のためにメンバーIDを受け取る
$member_id = $_SESSION['member_id'];
$letter_id = "";

if ($amount <= 0) {
    echo "セッションの金額は", $amount;
    die('エラー: 金額が不正です');
}

\Stripe\Stripe::setApiKey(''); // あなたの秘密キーを設定

// stripeの規則で絶対パスを指定
$successUrl = "https://tanajun.sakura.ne.jp/throw_money_fun_letter/success.php";
// $successUrl = "http://localhost/gs_code/throw_money_fun_letter/success.php";
$cancelUrl = "https://tanajun.sakura.ne.jp/throw_money_fun_letter/cancel.php";
// $cancelUrl = "http://localhost/gs_code/throw_money_fun_letter/cancel.php";


$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'jpy',
            'product_data' => [
                'name' => '投げ銭ファンレター',
            ],
            'unit_amount' => $amount, // 10円 = 1000（Stripeでは金額は最小単位で指定）
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    //ここはフルパスでないとstripe側でエラーにしているのでhttpsから始めないといけない
    'success_url' => $successUrl,
    'cancel_url' => $cancelUrl,
]);

// セッションのURLにリダイレクト
header("Location: " . $session->url);
exit();
?>
