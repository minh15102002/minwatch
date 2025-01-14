<?php
    require_once "inc/header.php";
    require_once "class/Database.php";
    // require_once "class/Product.php";
    require_once "class/Cart.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();

    $auth = new Auth();
    $auth->restrictAccess();
    $total = 0;

    $customer_id = $_SESSION['user_id'];
    $data_cart = Cart::getAll($pdo, $customer_id);

    $product_id = "";
    // $customer_id = "";
    $price = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $product_id = $_POST['product_id'];
        $customer_id = $_SESSION['user_id'];

        if(isset($_POST["deleteCart"])) {
            Cart::deleteCartItem($pdo, $customer_id, $product_id);
        }
        else if(isset($_POST["deleteAll"])){
            Cart::deleteCart($pdo, $customer_id);
        }
        else {
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
    
            Cart::updateCartItemQuantityAndPrice($pdo, $customer_id, $product_id, $quantity, $price);
        }

    }
?>
<div class="container-md" id="cart">
    <div class="cart-grid row py-5">
        <div class="col-md-12 col-xs-12 check-info">
            <div class="text-center" style="margin: 0 auto; ">
                <img class="img-fluid w-25" src="assets/images/order-success-icon.png" alt="Organic Strawberry Fruits">
                <h4 class="py-3 fw-bold text-black">Đặt hàng thành công</h4>
                <p class="py-2 fs-6 fw-bold">Cảm ơn bạn đã mua hàng tại website Min Watch</p>
                <p class="py-2 fs-6 ">Bạn đã đặt hàng thành công.</p>
                <p class="py-2 fs-6 "> Để kiểm tra chi tiết về đơn hàng, vui lòng chọn "Theo dõi đơn hàng của bạn" hoặc tiếp tục khám phá thêm nhiều sản phẩm khác.</p>
                <a href="index.php" class="continue btn btn-primary pull-xs-right text-uppercase fs-6">
                    Trang chủ
                </a>
                <a href="order-details.php" class="continue btn btn-primary pull-xs-right text-uppercase fs-6">
                    Theo dõi đơn hàng
                </a>
            </div>
        </div>

    </div>
</div>


<?php
    require_once "inc/footer.php";
?>