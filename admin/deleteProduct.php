<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Product.php";
    require_once "../class/Auth.php";
    // require "inc/init.php";

    $nameErrors = "";
    $desErrors = "";
    $priceErrors = "";

    $id = "";
    $name = "";
    $des = "";
    $price = "";

    // $auth = new Auth();
    // $auth->restrictAccess();

    $conn =  new Database();
    $pdo = $conn->getConnect();
    $product = Product::getDetailProductByID($pdo, $_GET["product_id"]);
    $count = 0;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $des= $_POST['des'];
        $price =  $_POST["price"];
        
        $conn =  new Database();
        $pdo = $conn->getConnect();

        $count = Product::isExistProductOrder($pdo, $id);
        if($count == 0) {
            Product::deleteProduct($pdo, $id);
        }
    }
?>
                <div class="container-fluid">
                    <h2 class="text-center">Xóa sản phẩm</h2>
                        <form class="w-50 m-auto" method="post">
                            <div class="mb-3">
                                <label for="id" class="form-label">Id</label>
                                <input class="form-control" id="id" name="id" readonly value="<?=$product->product_id?>">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên SP</label>
                                <input class="form-control" id="name" name="name" readonly value="<?=$product->product_name?>">
                            </div>
                            <div class="mb-3">
                                <label for="textarea" class="form-label">Description</label>
                                <textarea rows="6" readonly class="form-control" id="message" name="des" placeholder="Your description"><?=$product->product_description?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Hình ảnh</label>
                                <img  class="m-2 border" width="100" src="../assets/images/img_pro/<?=$product->product_image ?>" style="border-color: black; border: 2px">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá</label>
                                <input class="form-control" id="price" name="price" readonly value="<?=number_format($product->product_price, 0, ',', '.')?> đ">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Danh mục</label>
                                <input class="form-control" id="price" name="price" readonly value="<?=$product->category_name?>">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Thương hiệu</label>
                                <input class="form-control" id="price" name="price" readonly value="<?=$product->brand_name?>">
                            </div>
                                <?php if($count>0): ?>
                                    <div class="alert alert-danger text-center" role="alert">
                                        Bạn không thể xóa sản phẩm này!
                                    </div>
                                <?php endif;?>
                                <button type="submit" class="btn btn-primary">Xóa SP</button>
                        </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->

            <?php
                require "inc/footer.php";
            ?>