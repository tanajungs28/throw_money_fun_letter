<?php
require 'vendor/autoload.php'; // Stripeライブラリを読み込む

\Stripe\Stripe::setApiKey('sk_test_51R3ARSLvX4xkEJEVRhiSMZRO6q1TYmhXeQiqY6BXxdasEnoB6tkyQk87HUrBrQAmNOIQa20966zjAXGGrSBVLurs00KpQZ65cc'); // あなたの秘密キーを設定

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'jpy',
            'product_data' => [
                'name' => '投げ銭ファンレター',
            ],
            'unit_amount' => 1000, // 10円 = 1000（Stripeでは金額は最小単位で指定）
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost//gs_code/idol_platform_test_local/success.php',
    'cancel_url' => 'http://localhost//gs_code/idol_platform_test_local/cancel.php',
]);

// セッションのURLにリダイレクト
header("Location: " . $session->url);
exit();
?>
