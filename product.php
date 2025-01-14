<?php
    require_once "inc/header.php";
    require_once "class/Database.php";
    require_once "class/Product.php";
    require "inc/init.php";
    require_once "class/Auth.php";
    require_once "class/Cart.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();

    $cat_id = empty($_GET["cat_id"])?NULL:$_GET["cat_id"];
    $brand_id = empty($_GET["brand_id"])?NULL:$_GET["brand_id"];

    // phân trang
    if(empty($_GET['page']))
        $page = 1;
    else
        $page = $_GET['page'];
    $ppp = 6; // sản phẩm trên 1 trang

    $limit = $ppp;
    $offset = ($page-1)*$ppp; // tính lấy 6 sp tiếp theo

    $qty_Pro = Product::countProduct($pdo, $cat_id, $brand_id, $search_keyword);
    $maxPages = ceil($qty_Pro / $ppp);
    
    // lấy data product theo chủ đề hoặc tìm kiếm (có sắp xếp)
    if (!empty($_GET["arrange"])) {
        $arrange = $_GET["arrange"];
        if ($arrange == 'updated') {
            $data_product = Product::getRecentlyUpdated($pdo, $cat_id, $brand_id, $search_keyword, $limit, $offset);
        } else {
            $data_product = Product::arrange($pdo, $cat_id, $brand_id, $search_keyword, $limit, $offset, $arrange);
        }
    } else {
        $data_product = Product::pagination($pdo, $cat_id, $brand_id, $search_keyword, $limit, $offset);
    }

    $product_id = "";
    $customer_id = "";
    $price = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $auth = new Auth();
        $auth->restrictAccess();
        
        $product_id = $_POST['product_id'];
        $customer_id = $_SESSION['user_id'];
        $price = $_POST["price"];

        if(!empty($customer_id)) {
            Cart::updateCartItem($pdo, $customer_id, $product_id, $quantity=1, $price);
        }
    }
?>

<div class="content py-3">
    <div class="container-md">
        <div class="row">
            <div class="col-12 px-5 py-2">
                <p>Trang chủ/ sản phẩm</p>
            </div>
        </div>
        <div class="row">
            <!-- Cột lọc sản phẩm -->
            <div class="col-md-3">
                <div class="section-filter">
                    <p class="text-uppercase fw-bold fs-6 pb-2">Tìm kiếm</p>
                    <form method="get">
                    <div class="input-group flex-nowrap">
                        <input type="text" name="search" class="form-control" placeholder="Search here" aria-label="Username" aria-describedby="addon-wrapping">
                        <span class="input-group-text" id="addon-wrapping" style="background-color: black;">
                            <button type="submit"  style="background-color: transparent; border: none;"><img src="assets/images/icons/searchengin.png" alt=""></button>
                        </span>
                    </div>
                    </form>
                </div>
                <div class="section-filter">
                    <p class="text-uppercase fw-bold fs-6 pb-2">Giới tính</p>
                    <div class="filter-content d-flex justify-content-evenly">
                        <!-- <a class="text-decoration-none text-black btn btn-outline-secondary" href="#" role="button">Nam</a> -->
                        <!-- <button  type="button" class="btn btn-outline-secondary" style="width: 80px;">Nam</button> -->
                        <!-- <a class="text-decoration-none text-black btn btn-outline-secondary"  href="#" role="button">Nữ</a> -->
                        <!-- <button type="button" class="btn btn-outline-secondary" style="width: 80px;">Nữ</button> -->
                        <a href="product.php?search=nam" class="btn btn-outline-secondary" style="width: 80px;">Nam</a>
                        <a href="product.php?search=nu" class="btn btn-outline-secondary" style="width: 80px;">Nữ</a>

                    </div>
                </div>

                <!-- <div class="section-filter">
                    <p class="text-uppercase fw-bold fs-6 pb-2">Thương hiệu</p>
                    <ul class="checkbox-list py-2 ">
                        <?php foreach($data_brand as $brand):?>
                                    <li class="brand-label btn "><a class="filled-button" href="product.php?brand_id=<?=$brand->brand_id?>"><?=$brand->brand_name?></a></li>
                                <?php endforeach;?>
                    </ul>
                </div> -->
                <div class="section-filter">
                    <p class="text-uppercase fw-bold fs-6 pb-2">Thương hiệu</p>
                    <ul class="checkbox-list py-2">
                        <?php foreach($data_brand as $brand): ?>
                            <li class="brand-label btn">
                                <a class="filled-button2" href="product.php?brand_id=<?=$brand->brand_id?>" onclick="highlight(this); return false;"><?=$brand->brand_name?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <script>
    function highlight(element) {
        // Remove 'selected' class from all links
        const links = document.querySelectorAll('.brand-label a');
        links.forEach(link => link.classList.remove('selected'));
        
        // Add 'selected' class to the clicked link
        element.classList.add('selected');
        
        // Redirect to the new page after a short delay
        setTimeout(() => {
            window.location.href = element.href;
        }, 100); // Adjust the delay as needed
    }
</script>
                </div>

                <div class="section-filter">
                    <p class="text-uppercase fw-bold fs-6">Lọc theo giá (VNĐ)</p>
                    <div class="wrapper-filter-price-input">
                        <input type="text" minlenght="1" maxlength="10" class="text-price-from" value="0" />
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4.1665 10H15.8332" stroke="#2E2E2E" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" /></svg></span>
                        <input type="text" minlenght="1" maxlength="10" id="selectedOption" class="text-price-to" value="0" />
                    </div>
                    
                    <ul class="css-price-filter">
                        <li>
                            <input type="radio" name="sprice" value="(price_variant:product < 1000000)" data-price="0đ_1,000,000đ" id="price-filter-1" class="input_filter">
                            <label for="price-filter-1">Dưới 1,000,000đ</label>
                        </li>
                        <li>
                            <input type="radio" name="sprice" value="(price_variant:product range 1000000_2000000)" data-price="1,000,000đ_5,000,000đ" id="price-filter-2" class="input_filter">
                            <label for="price-filter-2">1,000,000đ - 5,000,000đ</label>
                        </li>
                        <li>
                            <input type="radio" name="sprice" value="(price_variant:product range 500000_10000000)" data-price="5,000,000đ_10,000,000đ" id="price-filter-3" class="input_filter">
                            <label for="price-filter-3">5,000,000đ - 10,000,000đ</label>
                        </li>
                        <li>
                            <input type="radio" name="sprice" value="(price_variant:product > 10000000)" data-price="10,000,000đ_" id="price-filter-4" class="input_filter">
                            <label for="price-filter-4">Trên 10,000,000đ</label>
                        </li>
                    </ul>

                    <script>
                        const radioButtons = document.querySelectorAll('input[name="sprice"]');
                        const textPriceFrom = document.querySelector('.text-price-from');
                        const textPriceTo = document.querySelector('.text-price-to');

                        radioButtons.forEach((radioButton) => {
                            radioButton.addEventListener('change', (event) => {
                                const value = event.target.dataset.price; // Lấy giá trị từ thuộc tính data-price của radio button
                                const [from, to] = value.split('_'); // Phân tách giá trị thành 2 phần riêng biệt
                                textPriceFrom.value = from;
                                textPriceTo.value = to;
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- Cột hiển thị các sản phẩm -->
            <div class="col-md-9 px-5">
                <div class="row" style="margin: 55px 0 30px 0;">
                    <div class="col-md-9">
                        <h5><?=$qty_Pro?> sản phẩm</h5>
                    </div>
                    <div class="col-md-3">
                    <form method="GET" id="arrangeForm">
                        <select name="arrange" id="arrange" class="form-select" onchange="submitForm()">
                            <option value="" <?= isset($_GET['arrange']) && $_GET['arrange'] == '' ? 'selected' : '' ?>>Chọn</option>
                            <option value="updated" <?= isset($_GET['arrange']) && $_GET['arrange'] == 'updated' ? 'selected' : '' ?>>Mới cập nhật</option>
                            <option value="DESC" <?= isset($_GET['arrange']) && $_GET['arrange'] == 'DESC' ? 'selected' : '' ?>>Giá (cao - thấp)</option>
                            <option value="ASC" <?= isset($_GET['arrange']) && $_GET['arrange'] == 'ASC' ? 'selected' : '' ?>>Giá (thấp - cao)</option>
                        </select>
                        <input type="hidden" name="page" value="<?= $page ?>">
                        <input type="hidden" name="search" value="<?= isset($search_keyword) ? $search_keyword : '' ?>">
                        <input type="hidden" name="brand_id" value="<?= isset($brand_id) ? $brand_id : '' ?>">
                        <input type="hidden" name="cat_id" value="<?= isset($cat_id) ? $cat_id : '' ?>">
                    </form>

                    <script>
                        function submitForm() {
                            document.getElementById("arrangeForm").submit();
                        }
                    </script>

                    </div>
                </div>
                <?php if($qty_Pro == 0):?>
                    <!-- <h3 class="text-center p-3">Không tìm thấy sản phẩm</h3> -->
                    <div class="row text-center">
                        <h3>không thấy sản phẩm <h3 style="co"><?=$search_keyword?></h3> </h3>
                        <img class="img-fluid w-75" src="assets/images/notfound.png" alt="" style="margin: 0 auto;">
                    </div>
                <?php else:?>
                    <div class="row d-flex">
                        <?php foreach($data_product as $product): ?>
                            <div class="card card-product m-2 item" style="width: 18rem;">
                                <div class="product-miniature js-product-miniature item-one first-item">
                                    <div class="thumbnail-container">
                                        <a href="product-detail.php?product_id=<?=$product->product_id?>">
                                            <img class="img-fluid image-cover" src="assets/images/img_pro/<?=$product->product_image?>" alt="img">
                                            <img class="img-fluid image-secondary" src="assets/images/img_pro/<?=$product->product_image?>" alt="img">
                                        </a>
                                    </div><div class="card-body product-description">
                                        <h5 class="card-title"><?=$product->brand_name?></h5>
                                        <p class="card-text fs-6"><a href="product-detail.php?product_id=<?=$product->product_id?>"><?=$product->product_name?></a></p>
                                        <p class="fw-bold text-black fs-6 product-group-price"><?=number_format($product->product_price, 0, ',', '.')?> ₫</p>
                                        
                                        <div class="product-buttons d-flex justify-content-center pt-2">
                                            <form method="post" class="formAddToCart">
                                                <!-- <input type="hidden" name="id_product" value="1"> -->
                                                <!-- <a class="add-to-cart" href="" data-button-action="add-to-cart">
                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                </a> -->
                                                <input type="hidden" name="product_id" value="<?=$product->product_id?>">
                                                <input type="hidden" name="price" value="<?=$product->product_price?>">
                                                <button type="submit" class="add-to-cart" style="border-top-color: #ddd ;">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </button>
                                            </form>
                                            <!-- <a class="addToWishlist" href="#" data-rel="1" onclick="">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </a> -->
                                            <a href="product-detail.php?product_id=<?=$product->product_id?>" class="quick-view hidden-sm-down" data-link-action="quickview">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Phân trang -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                <?php if(!empty($search_keyword)): ?>
                                    <a class="page-link" href="<?= $page == 1 ? '#' : 'product.php?search='.$search_keyword.'&page='.($page-1) ?><?= isset($_GET["arrange"]) ? '&arrange='.$_GET["arrange"] : '' ?>" aria-disabled="<?= $page == 1 ? 'true' : 'false' ?>">Previous</a>
                                <?php else: ?>
                                    <a class="page-link" href="<?= $page == 1 ? '#' : 'product.php?'.($brand_id ? 'brand_id='.$brand_id : 'cat_id='.$cat_id).'&page='.($page-1) ?><?= isset($_GET["arrange"]) ? '&arrange='.$_GET["arrange"] : '' ?>" aria-disabled="<?= $page == 1 ? 'true' : 'false' ?>">Previous</a>
                                <?php endif; ?>
                            </li>

                            <?php for ($i = 1; $i <= $maxPages; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <?php if(!empty($search_keyword)): ?>
                                        <a class="page-link" href="product.php?search=<?=$search_keyword ?>&page=<?= $i ?><?= isset($_GET["arrange"]) ? '&arrange='.$_GET["arrange"] : '' ?>"><?= $i ?></a>
                                    <?php else: ?>
                                        <a class="page-link" href="product.php?<?= $brand_id ? 'brand_id='.$brand_id : 'cat_id='.$cat_id ?>&page=<?= $i ?><?= isset($_GET["arrange"]) ? '&arrange='.$_GET["arrange"] : '' ?>"><?= $i ?></a>
                                    <?php endif; ?>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= $page == $maxPages ? 'disabled' : '' ?>">
                                <?php if(!empty($search_keyword)): ?>
                                    <a class="page-link" href="<?= $page == $maxPages ? '#' : 'product.php?search='.$search_keyword.'&page='.($page+1) ?><?= isset($_GET["arrange"]) ? '&arrange='.$_GET["arrange"] : '' ?>" aria-disabled="<?= $page == $maxPages ? 'true' : 'false' ?>">Next</a>
                                <?php else: ?>
                                    <a class="page-link" href="<?= $page == $maxPages ? '#' : 'product.php?'.($brand_id ? 'brand_id='.$brand_id : 'cat_id='.$cat_id).'&page='.($page+1) ?><?= isset($_GET["arrange"]) ? '&arrange='.$_GET["arrange"] : '' ?>" aria-disabled="<?= $page == $maxPages ? 'true' : 'false' ?>">Next</a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>


                <?php endif;?>


            </div>
        </div>
    </div>
</div>

<?php
    require_once "inc/footer.php";
?>