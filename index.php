<?php
    require_once "inc/header.php";
    require_once "inc/slider.php";
    require_once "class/Database.php";
    require_once "class/Product.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();

    $getProductMale = Product::getNewProduct($pdo, "Nam", 4);
    $getProductFemale = Product::getNewProduct($pdo, "Nữ", 4);
    $getProductCouple = Product::getNewProduct($pdo, "Cặp", 4);
?>

<div class="content py-3">
    <div class="container-fluid w-75">
        <div class="row">
            <h3 class="text-center py-2">THƯƠNG HIỆU ĐỒNG HỒ NỔI TIẾNG</h3>
            <div class="row p-2 justify-content-center">
                <?php foreach($data_brand as $brand):?>
                    <div class="col-md-2 img-brand py-2">
                        <a href="product.php?brand_id=<?=$brand->brand_id?>"><img src="assets/images/brand/<?=$brand->brand_image?>" alt="" class="border border-dark"></a>
                    </div>
                <?php endforeach;?>
            </div>
        </div>

        <hr>
        <div class="row p-2">
            <div class="col-md-5 ">
                <div class="card w-100 border-0">
                    <a href="product.php?cat_id=14"><img src="assets/images/banner.png" class="card-img-top rounded-4" alt="..."></a>
                    <div class="card-body position-absolute start-50 translate-middle-x text-center text-banner w-100">
                        <h5 class="text-white text-uppercase">Đồng hồ cao cấp</h5>
                        <a href="product.php?cat_id=14" class="text-decoration-none banner-link">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7 ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0">
                            <a href="product.php?search=nam"><img src="assets/images/banner-dong-ho-nam.png" class="card-img-top rounded-4" alt="..."></a>
                            <div class="card-body position-absolute start-50 translate-middle-x text-center text-banner">
                                <!-- <h5 class="text-white text-uppercase">Bộ sưu tập mới</h5>
                                <a href="#" class="text-decoration-none banner-link">Xem ngay</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0">
                            <a href="product.php?search=nu"><img src="assets/images/banner-dong-ho-nu.png" class="card-img-top rounded-4" alt="..."></a>
                            <div class="card-body position-absolute start-50 translate-middle-x text-center text-banner">
                                <!-- <h5 class="text-white text-uppercase">Bộ sưu tập mới</h5>
                                <a href="#" class="text-decoration-none banner-link">Xem ngay</a> -->
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="card border-0">
                        <a href="product.php?cat_id=3">
                            <img src="assets/images/banner-dong-ho-cap.png" class="card-img-top rounded-4" alt="..." style="width: 638px; padding-top: 15px; height: 294px;">
                        </a>
                        <div class="card-body position-absolute start-50 translate-middle-x text-center text-banner">
                            <!-- <h5 class="text-white text-uppercase">Bộ sưu tập mới</h5>
                            <a href="#" class="text-decoration-none banner-link">Xem ngay</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <hr>
        <div style=" margin-right:5%; margin-left:5%">
        <div class="section-product rounded-4">
            <div class="row justify-content-center">
                <h3 class="text-center py-2 text-uppercase text-white">ĐỒNG HỒ NAM MỚI NHẤT</h3>
                <div class="row justify-content-center">
                    <?php foreach($getProductMale as $pro):?>
                        <div class="card card-product m-2" style="width: 16rem;">
                            <a href="product-detail.php?product_id=<?=$pro->product_id?>"><img src="assets/images/img_pro/<?=$pro->product_image?>" class="card-img-top card-img" alt="..."></a>
                            <div class="card-body">
                                <h5 class="card-title"><?=$pro->brand_name?></h5>
                                <p class="card-text fs-6"><a href="product-detail.php?product_id=<?=$pro->product_id?>"><?=$pro->product_name?></a></p>
                                <p class="fw-bold text-black fs-6"><?=number_format($pro->product_price, 0, ',', '.')?> ₫</p>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
                <a class="btn filled-button btn-section p-2 m-2" href="product.php?search=nam" role="button">Xem thêm</a>
            </div>
        </div>

        <hr>
        <!--  style="background: linear-gradient(to right, #f7d3e2, #a86f8f);" -->
        <div class="section-product rounded-4">
            <div class="row justify-content-center">
                <h3 class="text-center py-2 text-uppercase text-white">ĐỒNG HỒ NỮ MỚI NHẤT</h3>
                <div class="row justify-content-center">
                    <?php foreach($getProductFemale as $pro):?>
                        <div class="card card-product m-2" style="width: 16rem;">
                            <a href="product-detail.php?product_id=<?=$pro->product_id?>"><img src="assets/images/img_pro/<?=$pro->product_image?>" class="card-img-top card-img" alt="..."></a>
                            <div class="card-body">
                                <h5 class="card-title"><?=$pro->brand_name?></h5>
                                <p class="card-text fs-6"><a href="#"><?=$pro->product_name?></a></p>
                                <p class="fw-bold text-black fs-6"><?=number_format($pro->product_price, 0, ',', '.')?> ₫</p>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
                <a class="btn filled-button btn-section p-2 m-2" href="product.php?search=nu" role="button">Xem thêm</a>
            </div>
        </div>

        <hr>
        <div class="section-product rounded-4">
            <div class="row justify-content-center">
                <h3 class="text-center py-2 text-uppercase text-white">ĐỒNG HỒ CẶP ĐÔI</h3>
                <div class="row justify-content-center">
                    <?php foreach($getProductCouple as $pro):?>
                        <div class="card card-product m-2" style="width: 16rem;">
                            <a href="product-detail.php?product_id=<?=$pro->product_id?>"><img src="assets/images/img_pro/<?=$pro->product_image?>" class="card-img-top card-img" alt="..."></a>
                            <div class="card-body">
                                <h5 class="card-title"><?=$pro->brand_name?></h5>
                                <p class="card-text fs-6"><a href="#"><?=$pro->product_name?></a></p>
                                <p class="fw-bold text-black fs-6"><?=number_format($pro->product_price, 0, ',', '.')?> ₫</p>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
                <a class="btn filled-button btn-section p-2 m-2" href="product.php?cat_id=3" role="button">Xem thêm</a>
            </div>
        </div>
    </div>
</div>


<?php  require_once "inc/footer.php";?>