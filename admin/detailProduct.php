<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Product.php";
    require_once "../class/Category.php";
    require_once "../class/Brand.php";
    require_once "../class/Auth.php";
    
    $conn =  new Database();
    $pdo = $conn->getConnect();
    $product = Product::getDetailProductByID($pdo, $_GET["product_id"]);

?>
    <div class="container-fluid">
        <h2 class="text-center">Xem chi tiết sản phẩm</h2>
            <form class="w-50 m-auto" method="post">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input class="form-control" id="id" name="id" readonly value="<?=$product->product_id?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên SP</label>
                    <input class="form-control" readonly id="name" name="name" value="<?=$product->product_name?>">
                </div>
                <fieldset class="mb-3">
                    <label for="textarea" class="form-label">Mô tả sản phẩm</label>
                    <textarea rows="6" class="form-control" readonly id="message" name="des" placeholder="Your description"><?=$product->product_description?></textarea>
                </fieldset>
                <div class="mb-3">
                    <label for="img" class="form-label">Hình ảnh</label>
                    <img id="preview" src="../assets/images/img_pro/<?=$product->product_image ?>" class=" border" width="100">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Giá</label>
                    <input class="form-control" readonly id="price" name="price" value="<?=number_format($product->product_price, 0, ',', '.')?> đ">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Danh mục</label>
                    <input class="form-control" readonly id="name" name="name" value="<?=$product->category_name?>">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Thương hiệu</label>
                    <input class="form-control" readonly id="name" name="name" value="<?=$product->brand_name?>">
                </div>

                <a class="btn btn-primary" href="listProduct.php">Danh sách sản phẩm</a>
            </form>

    </div>

</div>
<?php
    require "inc/footer.php";
?>