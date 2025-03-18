<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require 'vendor/autoload.php'; // Stripeライブラリを読み込む

// セッションで金額を受け取る
$amount = isset($_SESSION['amount']) ? intval($_SESSION['amount']) : 0;

if ($amount <= 0) {
    echo "セッションの金額は", $amount;
    die('エラー: 金額が不正です');
}

\Stripe\Stripe::setApiKey('sk_test_51R3ARSLvX4xkEJEVRhiSMZRO6q1TYmhXeQiqY6BXxdasEnoB6tkyQk87HUrBrQAmNOIQa20966zjAXGGrSBVLurs00KpQZ65cc'); // あなたの秘密キーを設定

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
    // 'success_url' => 'http://localhost//gs_code/throw_money_fun_letter/success.php',
    // 'cancel_url' => 'http://localhost//gs_code/throw_money_fun_letter/cancel.php',
    'success_url' => 'https://tanajun.sakura.ne.jp/throw_money_fun_letter/success.php',
    'cancel_url' => 'https://tanajun.sakura.ne.jp/throw_money_fun_letter/cancel.php',
]);

// セッションのURLにリダイレクト
header("Location: " . $session->url);
exit();
?>
