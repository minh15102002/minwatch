<?php
require_once "vendor/autoload.php";
require_once "class/Database.php";

$conn = new Database();
$pdo = $conn->getConnect();

\Stripe\Stripe::setApiKey('sk_test_51Q7tJC02rlSVc5oe9TxN24WMiIFJlFtxU0hHY7L6k9LgvwVXOqL3PUIc5nLBsgRiJcILFdWunbC9SdSx2QTwf5PT00WcURgjSH');

$order_id = $_GET['order_id'];
$total_price = $_GET['total_price']; // Số tiền cần thanh toán (đơn vị: đồng)

if (!$order_id || !$total_price) {
    die("Thông tin đơn hàng không hợp lệ.");
}

// Stripe yêu cầu số tiền phải tính theo đơn vị nhỏ nhất (e.g., cents).
$total_price_cents = $total_price * 1;

// Tạo phiên thanh toán Stripe
$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'vnd',
            'product_data' => [
                'name' => "Đơn hàng #$order_id",
            ],
            'unit_amount' => $total_price_cents,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => "http://localhost/Website_BanDongHo/order-success.php",
    'cancel_url' => "http://localhost/Website_BanDongHo/product-checkout.php",
]);

// Chuyển hướng tới phiên thanh toán Stripe
header("Location: " . $session->url);
exit();
?>
