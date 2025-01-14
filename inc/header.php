<?php
require_once "class/Database.php";
require_once "inc/init.php";
require_once "class/Auth.php";
require_once "class/Product.php";
require_once "class/Brand.php";
require_once "class/Category.php";
require_once "class/Cart.php";
require_once "config-google.php";
ob_start(); // Bắt đầu bộ đệm đầu ra, ngăn bất kỳ đầu ra nào được gửi từ trước.

$current_page = basename($_SERVER['PHP_SELF']); // Lấy tên trang hiện tại

// Kiểm tra tên trang và thêm/xóa lớp CSS cho header tương ứng
$header_class = ($current_page !== 'index.php') ? 'header_section_other' : 'header_section';

$conn = new Database();
$pdo = $conn->getConnect();

$data_brand = Brand::getAll($pdo);
$data_category = Category::getAll($pdo);

$count = !empty($_SESSION['user_id']) ? Cart::countCartItem($pdo, $_SESSION['user_id']) : 0;

$page = empty($_GET['page']) ? 1 : $_GET['page'];
$ppp = 6; // sản phẩm trên 1 trang
$limit = $ppp;
$offset = ($page - 1) * $ppp;
$search_keyword = empty($_GET['search']) ? NULL : $_GET['search'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Min Watch</title>
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <?php if ($current_page !== 'shopping-cart.php'): ?>
        <div id="preloader">
            <div class="jumper">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    <?php endif; ?>
    <!-- ***** Preloader End ***** -->

    <header class="<?php echo $header_class; ?>">
        <div class="container-fluid">
            <div class="row inner-header align-items-baseline">
                <div class="col-md-1 logo text-center">
                    <a href="index.php"><img src="assets/images/logo.png" alt="" width="80"></a>
                </div>
                
                <nav class="col-md-6 main-menu mobile-menu">
                    <ul>
                        <li><a class="<?php echo (strpos(basename($_SERVER['REQUEST_URI']), 'index.php') !== false) ? 'active' : ''; ?>" href="index.php">Trang chủ</a></li>
                        <li><a class="<?php echo (strpos(basename($_SERVER['REQUEST_URI']), 'about.php') !== false) ? 'active' : ''; ?>" href="about.php">Giới thiệu</a></li>
                        <li><a class="<?php echo (strpos(basename($_SERVER['REQUEST_URI']), 'thuonghieu') !== false) ? 'active' : ''; ?>" href="product.php?category=thuonghieu">Thương hiệu</a>
                            <ul class="sub-menu">
                                <?php foreach ($data_brand as $brand): ?>
                                    <li><a href="product.php?brand_id=<?= $brand->brand_id ?>"><?= $brand->brand_name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li><a class="<?php echo (strpos(basename($_SERVER['REQUEST_URI']), 'nam') !== false) ? 'active' : ''; ?>" href="product.php?search=nam">Nam</a></li>
                        <li><a class="<?php echo (strpos(basename($_SERVER['REQUEST_URI']), 'nu') !== false) ? 'active' : ''; ?>" href="product.php?search=nu">Nữ</a></li>
                        <li><a class="<?php echo (strpos(basename($_SERVER['REQUEST_URI']), 'sanpham') !== false) ? 'active' : ''; ?>" href="product.php?category=sanpham">Sản phẩm</a>
                            <ul class="sub-menu">
                                <?php foreach ($data_category as $cat): ?>
                                    <li><a href="product.php?cat_id=<?= $cat->category_id ?>"><?= $cat->category_name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li><a href="contact.php">Liên hệ</a></li>
                    </ul>
                </nav>

                <div class="col-md-5 header-right">
                    <div id="search_widget" class="align-items-center justify-content-start d-flex">
                        <form method="get" action="product.php" class="form-search" style="max-width: 270px">
                            <input type="text" name="search" value="<?= $search_keyword ?>" placeholder="Tìm kiếm sản phẩm" class="ui-autocomplete-input border-0 input-search" style="color: #fff;" autocomplete="off">
                            <button type="submit" class="button-search">
                                <img src="assets/images/icons/searchengin.png" alt="" class="search-icon">
                            </button>
                        </form>

                        <div id="block_myaccount_infos" class="hidden-sm-down dropdown">
                            <div class="myaccount-title">
                                <a href="#acount" data-toggle="collapse" class="acount">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span style="color: #fff"><?php echo isset($_SESSION['logged_user']) ? $_SESSION['logged_user'] : 'Account' ?></span>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div id="acount" class="collapse">
                                <div class="account-list-content">
                                    <?php if (isset($_SESSION['logged_user'])): ?>
                                        <?php if ($_SESSION['role'] == "admin"): ?>
                                            <div>
                                                <a class="login" href="admin/index.php" rel="nofollow" title="Đơn hàng">
                                                    <i class="fa fa-user me-2"></i>
                                                    <span>Trở về trang admin</span>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <a class="login" href="tai-khoan.php" rel="nofollow" title="Tài khoản">
                                                <i class="fa fa-user me-2"></i>
                                                <span>Tài khoản</span>
                                            </a>
                                        </div>
                                        <div>
                                            <a class="login" href="order-details.php" rel="nofollow" title="Đơn hàng">
                                                <i class="fa fa-list-ul me-2"></i>
                                                <span>Đơn hàng</span>
                                            </a>
                                        </div>
                                        <div>
                                            <a class="login" href="logout.php" rel="nofollow" title="">
                                                <i class="fa fa-sign-in me-2"></i>
                                                <span>Đăng xuất</span>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <a class="login" href="login.php" rel="nofollow" title="Đăng nhập">
                                                <i class="fa fa-sign-in me-2"></i>
                                                <span>Đăng nhập</span>
                                            </a>
                                        </div>
                                        <div>
                                            <a class="register" href="register.php" rel="nofollow" title="Đăng ký thành viên">
                                                <i class="fa fa-user me-2"></i>
                                                <span>Đăng ký</span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <a href="shopping-cart.php" class="position-relative">
                            <?php if ($count > 0): ?>
                                <span class="cart-products-count text-center rounded-circle text-white"><?= $count ?></span>
                            <?php endif; ?>
                            <img src="assets/images/icons/cart-shopping-solid.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Page Content -->