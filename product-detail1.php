<?php
    require_once "inc/header.php";
    require_once "class/Database.php";
    require_once "class/Product.php";
    require_once "class/Cart.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();
    $id = $_GET["product_id"];

    $cat_id = empty($_GET["cat_id"])?NULL:$_GET["cat_id"];
    $brand_id = empty($_GET["brand_id"])?NULL:$_GET["brand_id"];
    $limit = 4;

    $product = Product::getOneProductByID($pdo, $id);
    $related_pro = Product::getRelatedProduct($pdo, $id, $cat_id, $brand_id, $limit);

    $product_id = "";
    $customer_id = "";
    $price = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $auth = new Auth();
        $auth->restrictAccess();

        $product_id = $_POST['product_id'];
        $customer_id = $_SESSION['user_id'];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];

        if(!empty($customer_id)) {
            Cart::updateCartItem($pdo, $customer_id, $product_id, $quantity, $price);
        }

    }

?>
<body id="product-detail">
    <!-- main content -->
    <div class="main-content">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-md-12">
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
                                                <!-- <div id="item2" class="tab-pane fade">
                                                    <img src="assets/images/cap-1.png" alt="img">
                                                </div>
                                                <div id="item3" class="tab-pane fade">
                                                    <img src="assets/images/dong-ho-Casio-MTP-VT01L-1BUDF-1.png" alt="img">
                                                </div>
                                                <div id="item4" class="tab-pane fade">
                                                    <img src="assets/images/dong-ho-Casio-MTP-VT01L-1BUDF-1.png" alt="img">
                                                </div> -->
                                            </div>
                                            <!-- <ul class="product-tab nav nav-tabs d-flex">
                                                <li class="active col">
                                                    <a href="#item1" data-toggle="tab" aria-expanded="true" class="active show">
                                                        <img src="assets/images/dong-ho-Casio-MTP-VT01L-1BUDF-1.png" alt="img">
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a href="#item2" data-toggle="tab">
                                                        <img src="assets/images/cap-1.png" alt="img">
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a href="#item3" data-toggle="tab">
                                                        <img src="assets/images/dong-ho-Casio-MTP-VT01L-1BUDF-1.png" alt="img">
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a href="#item4" data-toggle="tab">
                                                        <img src="assets/images/dong-ho-Casio-MTP-VT01L-1BUDF-1.png" alt="img">
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
                                            <p>Categories :
                                                <span class="content2">
                                                    <a href="#"><?=$product->category_name?></a>
                                                </span>
                                            </p>
                                            <p>Brand :
                                                <span class="content2">
                                                    <a href="#"><?=$product->brand_name?></a>
                                                    <!-- <a href="#">Overcoat</a>,
                                                    <a href="#">Luxury</a>,
                                                    <a href="#">men</a>,
                                                    <a href="#">summer</a>,
                                                    <a href="#">autumn</a> -->
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="review">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#description" class="active show">MÔ TẢ SẢN PHẨM</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#tag">VỀ THƯƠNG HIỆU</a>
                                    </li>
                                    <!-- <li>
                                        <a data-toggle="tab" href="#tag">THÔNG TIN BẢO QUẢN</a>
                                    </li> -->
                                    
                                </ul>

                                <div class="tab-content">
                                    <div id="description" class="tab-pane fade in active show">
                                        <p><?=$product->product_description?></p>
                                    </div>
                                    <!-- <div id="review" class="tab-pane fade in">
                                        <p><?=$product->brand_desc?></p>
                                    </div> -->
                                    <div id="tag" class="tab-pane fade in">
                                        <p><?=$product->brand_desc?></p>
                                    </div>
                                </div>
                            </div>
                <!-- danh gia sp -->
                                <div style="margin-top: 80px;" class="container">
                                    <h5 style="margin-bottom: 40px;">ĐÁNH GIÁ SẢN PHẨM</h5>
                                    <div style="margin-top: 10px; font-size: 18px;">
                                        (Đánh giá: 0 lượt)
                                    </div>
                                    <div>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i> 
                                    </div>
                                    <div>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i> 
                                    </div>
                                    <div>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i> 
                                    </div>
                                    <div>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i>
                                    </div>
                                    <div>
                                        <i class="fa fa-star" style="margin-right: 10px; color: #e3c01c;"></i> 
                                    </div>
                                        <div>
                                            <div>
                                                <i class="fa fa-user-circle" style="font-size: 40px;"></i> 
                                            </div>
                                            <div style="margin-left: 40px;">
                                                <div></div>
                                                <div></div>
                                                <p style="font-size: 18px;"></p>
                                            </div>
                                            <hr />
                                        </div>
                                        <div style="font-size: 18px; color: #14134f;">
                                            Sản phẩm chưa có đánh giá !
                                        </div>
                                    </div>
                                <div class="container mt-4" style="background-color: #ffffff; border-radius: 8px; padding: 20px;">
                                    <div class="mb-3">
                                        <textarea
                                            class="form-control"
                                            rows="4"
                                            placeholder="Bình luận ..."
                                            style="background-color: #ebe9da; color: #b0b0b0; border: 1px solid #444; border-radius: 8px;">
                                        </textarea>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <select class="form-select" style="background-color: #2c2c2c; color: #b0b0b0; border: 1px solid #444;">
                                                <option>Mới nhất</option>
                                                <option>Cũ nhất</option>
                                            </select>
                                        </div>
                                        <span style="color: #b0b0b0;"> Bình luận</span>
                                        <button class="btn btn-warning" style="border-radius: 8px;">
                                            GỬI
                                        </button>
                                    </div>
                                </div>
                            </div>



                             <!--end dgsp  -->
                            <div class="related">
                                <div class="title-tab-content text-center">
                                    <div class="title-product justify-content-start">
                                        <h2>SẢN PHẨM LIÊN QUAN</h2>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="row d-flex justify-content-center">
                                        <!-- <div class="item text-center col-md-4">
                                            <div class="product-miniature js-product-miniature item-one first-item">
                                                <div class="thumbnail-container border border">
                                                    <a href="product-detail.html">
                                                        <img class="img-fluid image-cover" src="assets/images/dong-ho-Casio-MTP-VT01L-1BUDF-1.png" alt="img">
                                                        <img class="img-fluid image-secondary" src="assets/images/dong-ho-Casio-MTP-VT01L-1BUDF-1.pngg" alt="img">
                                                    </a>
                                                    <div class="highlighted-informations">
                                                        <div class="variant-links">
                                                            <a href="#" class="color beige" title="Beige"></a>
                                                            <a href="#" class="color orange" title="Orange"></a>
                                                            <a href="#" class="color green" title="Green"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-description">
                                                    <div class="product-groups">
                                                        <div class="product-title">
                                                            <a href="product-detail.html">Nulla et justo non augue</a>
                                                        </div>
                                                        <div class="rating">
                                                            <div class="star-content">
                                                                <div class="star"></div>
                                                                <div class="star"></div>
                                                                <div class="star"></div>
                                                                <div class="star"></div>
                                                                <div class="star"></div>
                                                            </div>
                                                        </div>
                                                        <div class="product-group-price">
                                                            <div class="product-price-and-shipping">
                                                                <span class="price">£28.08</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-buttons d-flex justify-content-center">
                                                        <form action="#" method="post" class="formAddToCart">
                                                            <a class="add-to-cart" href="#" data-button-action="add-to-cart">
                                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                            </a>
                                                        </form>
                                                        <a class="addToWishlist" href="#" data-rel="1" onclick="">
                                                            <i class="fa fa-heart" aria-hidden="true"></i>
                                                        </a>
                                                        <a href="#" class="quick-view hidden-sm-down" data-link-action="quickview">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <?php foreach($related_pro as $product): ?>
                                            <div class="card card-product m-2" style="width: 16rem;">
                                                <a href="product-detail.php?product_id=<?=$product->product_id?>"><img src="assets/images/img_pro/<?=$product->product_image?>" class="card-img-top card-img" alt="..."></a>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?=$product->brand_name?></h5>
                                                    <p class="card-text fs-6"><a href="product-detail.php?product_id=<?=$product->product_id?>"><?=$product->product_name?></a></p>
                                                    <p class="fw-bold text-black fs-6"><?=number_format($product->product_price, 0, ',', '.')?> ₫</p>
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
    </div>

<?php
    require_once "inc/footer.php";
?>