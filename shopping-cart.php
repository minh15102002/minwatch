<?php
    require_once "inc/header.php";
    require_once "class/Database.php";
    require_once "class/Cart.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    $auth = new Auth();
    $auth->restrictAccess();

    $customer_id = $_SESSION['user_id'];
    $data_cart = Cart::getAll($pdo, $customer_id);

    $total = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_id = $_POST['product_id'];

        if (isset($_POST["deleteCart"])) {
            Cart::deleteCartItem($pdo, $customer_id, $product_id);
        } else if (isset($_POST["deleteAll"])) {
            Cart::deleteCart($pdo, $customer_id);
        } else {
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            Cart::updateCartItemQuantityAndPrice($pdo, $customer_id, $product_id, $quantity, $price);
        }
    }
?>

<div class="container-md" id="cart">
    <div class="cart-grid row py-5">
        <div class="col-md-9 col-xs-12 check-info">
            <h1 class="title-page">Giỏ hàng</h1>
            <?php if (empty($data_cart)): ?>
                <div class="text-center">
                    <img class="img-fluid w-25" src="assets/images/cart-empty.png" alt="Giỏ hàng trống">
                    <h4 class="py-3 fw-bold text-black">Không có sản phẩm nào!</h4>
                    <p class="py-2 fs-6">Hãy mua sắm ngay lúc này để tận hưởng các ưu đãi hấp dẫn chỉ dành riêng cho bạn.</p>
                    <a href="product.php" class="continue btn btn-primary pull-xs-right text-uppercase fs-6">
                        Dạo một vòng xem nào!
                    </a>
                </div>
            <?php else: ?>
                <div class="cart-container">
                    <div class="cart-overview js-cart">
                        <ul class="cart-items">
                            <?php foreach ($data_cart as $product): ?>
                                <li class="cart-item">
                                    <div class="product-line-grid row justify-content-between">
                                        <div class="product-line-grid-left col-md-2">
                                            <span class="product-image media-middle">
                                                <a href="product-detail.php?product_id=<?=$product->product_id?>">
                                                    <img class="img-fluid" src="assets/images/img_pro/<?=$product->product_image?>" alt="Sản phẩm">
                                                </a>
                                            </span>
                                        </div>
                                        <div class="product-line-grid-body col-md-5">
                                            <div class="product-line-info">
                                                <span class="label-atrr"><a class="label" href="product.php?brand_id=<?=$product->brand_id?>"><?=$product->brand_name?></a></span>
                                            </div>
                                            <div class="product-line-info">
                                                <span class="label-atrr"><a href="product-detail.php?product_id=<?=$product->product_id?>"><?=$product->product_name?></a></span>
                                            </div>
                                            <div class="product-line-info product-price">
                                                <span class="value"><?=number_format($product->product_price, 0, ',', '.')?> ₫</span>
                                            </div>
                                        </div>
                                        <div class="product-line-grid-right text-center product-line-actions col-md-5">
                                            <div class="row">
                                                <div class="col-md-5 col">
                                                    <div class="label">Số lượng:</div>
                                                    <div class="quantity buttons_added">
                                                        <form method="post">
                                                            <input type="submit" name="decrease" value="-" class="minus">
                                                            <input type="number" name="quantity" value="<?=$product->quantity?>" class="input-text qty text" readonly>
                                                            <input type="submit" name="increase" value="+" class="plus">
                                                            <input type="hidden" name="product_id" value="<?=$product->product_id?>">
                                                            <input type="hidden" name="price" value="<?=$product->product_price?>">
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col price">
                                                    <div class="label">Tổng cộng:</div>
                                                    <div class="product-price total">
                                                        <?php 
                                                            $sum = $product->product_price * $product->quantity;
                                                            $total += $sum; 
                                                        ?>
                                                        <?=number_format($sum, 0, ',', '.')?> ₫
                                                    </div>
                                                </div>
                                                <div class="col-md-1 col text-xs-right align-self-end">
                                                    <form method="post">
                                                        <input type="hidden" name="product_id" value="<?=$product->product_id?>">
                                                        <button type="submit" name="deleteCart" class="remove-from-cart border-0">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <a href="product.php" class="continue btn btn-primary pull-xs-right">Tiếp tục mua sắm</a>
                <form method="post" class="float-end">
                    <button type="submit" name="deleteAll" class="continue btn btn-primary pull-xs-right">
                        Xóa tất cả
                    </button>
                </form>
            <?php endif; ?>
        </div>
        <div class="cart-grid-right col-xs-12 col-lg-3">
            <div class="cart__total">
                <h6>Bạn có <?=count($data_cart)?> sản phẩm trong giỏ hàng</h6>
                <ul>
                    <li>Tổng cộng <span><?=number_format($total, 0, ',', '.')?> ₫</span></li>
                </ul>
                <?php if (!empty($data_cart)): ?>
                    <a href="product-checkout.php" class="primary-btn">Thanh toán</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
    require_once "inc/footer.php";
?>