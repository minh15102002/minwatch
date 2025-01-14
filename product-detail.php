<?php
require_once "inc/header.php";
require_once "class/Database.php";
require_once "class/Product.php";
require_once "class/Cart.php";
require_once "class/Comment.php";

// Kết nối cơ sở dữ liệu
$conn = new Database();
$pdo = $conn->getConnect();

// Lấy ID sản phẩm từ URL
$product_id = $_GET["product_id"] ?? null;
if (!$product_id) {
    die("Sản phẩm không tồn tại.");
}

// Lấy các tham số bộ lọc
$cat_id = $_GET["cat_id"] ?? null;
$brand_id = $_GET["brand_id"] ?? null;
$limit = 4;

// Lấy chi tiết sản phẩm và các sản phẩm liên quan
$product = Product::getOneProductByID($pdo, $product_id);
$related_pro = Product::getRelatedProduct($pdo, $product_id, $cat_id, $brand_id, $limit);

// Xử lý khi người dùng thêm sản phẩm vào giỏ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auth = new Auth();
    $auth->restrictAccess();  // Kiểm tra quyền người dùng

    $product_id = $_POST['product_id'] ?? null;
    $customer_id = $_SESSION['user_id'] ?? null;
    $price = $_POST["price"] ?? null;
    $quantity = $_POST["quantity"] ?? null;

    if ($customer_id && $product_id && $quantity && $price) {
        Cart::updateCartItem($pdo, $customer_id, $product_id, $quantity, $price);
    }
}

// Xử lý khi người dùng gửi bình luận
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'], $_POST['comment_text'])) {
    // session_start();
    $user_id = $_SESSION['user_id'] ?? null;
    $rating = $_POST['rating'];
    $comment_text = $_POST['comment_text'];
    $product_id = $_GET["product_id"] ?? null;
    if ($user_id && $rating && $comment_text) {
        Comment::addComment($pdo, $product_id, $user_id, $rating, $comment_text);
        header("Location: product-detail.php?product_id=$product_id");
        exit();
    } else {
        $error = "Vui lòng điền đầy đủ thông tin.";
    }
}

// Lấy bình luận của sản phẩm
$order = $_GET['order'] ?? 'DESC';
$comments = Comment::getAllComments($pdo, $product_id, 5, $order);
?>

<body id="product-detail">
    <div class="main-content">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="main-product-detail" style="padding: 20px 0;">
                            <h2>Chi tiết sản phẩm</h2>
                            <div class="product-single row">
                                <div class="product-detail col-xs-12 col-md-5 col-sm-5">
                                    <div class="page-content" id="content">
                                        <div class="images-container">
                                            <div class="js-qv-mask mask tab-content border">
                                                <div id="item1" class="tab-pane fade active in show">
                                                    <img src="assets/images/img_pro/<?=$product->product_image?>" alt="img">
                                                </div>
                                            </div>
                                            <!-- <ul class="product-tab nav nav-tabs d-flex">
                                                <li class="active col">
                                                    <a href="#item1" data-toggle="tab" aria-expanded="true" class="active show">
                                                        <img src="assets/images/img_pro/Rolex-1.png" alt="img">
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a href="#item2" data-toggle="tab">
                                                        <img src="assets/images/img_pro/Rolex-2.png" alt="img">
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a href="#item3" data-toggle="tab">
                                                        <img src="assets/images/img_pro/Rolex-3.png" alt="img">
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a href="#item4" data-toggle="tab">
                                                        <img src="assets/images/img_pro/Rolex-4.png" alt="img">
                                                    </a>
                                                </li>
                                            </ul> -->
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info col-xs-12 col-md-7 col-sm-7">
                                    <div class="detail-description">
                                        <!-- <p class="fs-5">Casio</p> -->
                                        <h2><?=$product->product_name?></h2>
                                        <p class="description"><?=$product->product_description?></p>
                                        <div class="price-del">
                                            <span class="price fs-4"><?=number_format($product->product_price, 0, ',', '.')?> ₫</span>
                                        </div>
                                        <div style="background-color: white; text-align: center; display: flex; justify-content: center; align-items: center; margin-top: 30px;">
                                            <div style="padding: 16px; width: 80%;  background-color:rgb(213, 227, 241); border: 2px solid red; border-radius: 5px;">
                                                <div style="display: flex; justify-content: center;margin-bottom:10px">
                                                    <div style="width: 205px; height: 20px; display: flex; align-items: center;">
                                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" style="color: red; margin-right:10px" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
                                                        </svg>
                                                        <span class="text-sm">Miễn phí vận chuyển</span>
                                                    </div>
                                                    <div style="width: 205px; height: 20px; display: flex; align-items: center;">
                                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" style="color: red; margin-right:10px" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"></path>
                                                            <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"></path>
                                                        </svg>
                                                        <span class="text-sm">Bảo hành 12 tháng</span>
                                                    </div>
                                                </div>
                                                <div style="display: flex; justify-content: center;padding:16px">
                                                    <div style="width: 205px; height: 20px; display: flex; align-items: center;">
                                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" style="color: red; margin-right:10px" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"></path>
                                                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"></path>
                                                        </svg>
                                                        <span class="text-sm">Đổi trả trong 30 ngày</span>
                                                    </div>
                                                    <div style="width: 205px; height: 20px; display: flex; align-items: center;">
                                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" style="color: red; margin-right:10px;" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"></path>
                                                        </svg>
                                                        <span class="text-sm">Chính hãng 100%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="has-border cart-area" style="padding: 20px 0;">
                                            <div class="product-quantity">
                                                <div class="qty">
                                                    <div class="input-group d-flex flex-column">
                                                        <form method="post">
                                                            <div class="quantity d-flex align-items-center">
                                                                <span class="control-label fs-6 float-start me-2">Số lượng : </span>
                                                                <div class="quantity buttons_added">
                                                                    <input type="button" value="-" class="minus fs-6">
                                                                    <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text fs-6 text-center" size="4" pattern="" inputmode="" readonly style="width: 70px;">
                                                                    <input type="button" value="+" class="plus fs-6">
                                                                </div>

                                                                <div class="add py-3">
                                                                    <input type="hidden" name="product_id" value="<?=$product->product_id?>">
                                                                    <input type="hidden" name="price" value="<?=$product->product_price?>">
    
                                                                    <button class="btn btn-primary add-to-cart add-item" data-button-action="add-to-cart" type="submit">
                                                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                                        <span>Thêm vào giỏ hàng</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <!-- <p>SKU :
                                                <span class="content2">
                                                    <a href="#">e-02154</a>
                                                </span>
                                            </p> -->
                                            <p>Danh mục :
                                                <span class="content2">
                                                    <a href="#"><?=$product->category_name?></a>
                                                </span>
                                            </p>
                                            <p>Thương hiệu :
                                                <span class="content2">
                                                    <a href="#"><?=$product->brand_name?></a>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab content -->
                            <div class="review">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#description" style="text-decoration: underline;">MÔ TẢ SẢN PHẨM</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#tag">VỀ THƯƠNG HIỆU</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="description" class="tab-pane fade in active show">
                                        <p><?=$product->product_description?></p>
                                    </div>
                                    <div id="tag" class="tab-pane fade in">
                                        <p><?=$product->brand_desc?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Lọc Bình Luận -->
                            <h5 style="margin-top: 30px;">Bình Luận</h5>
                            <form method="get" class="mb-3">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                                <select name="order" class="form-select w-25 d-inline" onchange="this.form.submit()">
                                    <option value="DESC" <?= $order === 'DESC' ? 'selected' : '' ?>>Mới nhất</option>
                                    <option value="ASC" <?= $order === 'ASC' ? 'selected' : '' ?>>Cũ nhất</option>
                                </select>
                            </form>

                            <!-- Hiển Thị Bình Luận -->
                            <div class="comments-section">
                                <?php if (!empty($comments)): ?>
                                    <?php foreach ($comments as $comment): ?>
                                        <div class="comment-item border rounded p-3 mb-3">
                                            <p><strong><?= htmlspecialchars($comment['name']) ?></strong> - 
                                                <span class="rating">⭐ <?= $comment['rating'] ?>/5</span>
                                            </p>
                                            <p><?= htmlspecialchars($comment['comment_text']) ?></p>
                                            <small><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Chưa có bình luận nào.</p>
                                <?php endif; ?>
                            </div>

                            <!-- Form Gửi Bình Luận -->
                            
                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>
                            <form method="post">
                                <div class="form-group mb-2">
                                    <label for="rating">Đánh giá:</label>
                                    <select name="rating" id="rating" class="form-select" required>
                                        <option value="5">5 sao</option>
                                        <option value="4">4 sao</option>
                                        <option value="3">3 sao</option>
                                        <option value="2">2 sao</option>
                                        <option value="1">1 sao</option>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <textarea name="comment_text" class="form-control" placeholder="Viết bình luận..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi Bình Luận</button>
                            </form>

                            <!-- Sản Phẩm Liên Quan -->
                            <div class="related">
                                <div class="title-tab-content text-center">
                                    <h2>SẢN PHẨM LIÊN QUAN</h2>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <?php foreach ($related_pro as $related_product): ?>
                                        <div class="card card-product m-2" style="width: 16rem;">
                                            <a href="product-detail.php?product_id=<?=$related_product->product_id?>">
                                                <img src="assets/images/img_pro/<?=$related_product->product_image?>" class="card-img-top" alt="...">
                                            </a>
                                            <div class="card-body">
                                                <h5 class="card-title"><?=$related_product->brand_name?></h5>
                                                <p class="card-text fs-6"><a href="product-detail.php?product_id=<?=$related_product->product_id?>"><?=$related_product->product_name?></a></p>
                                                <p class="fw-bold text-black fs-6"><?=number_format($related_product->product_price, 0, ',', '.')?> ₫</p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
require_once "inc/footer.php";
?>
