<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Brand.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();
    $brand = Brand::getOneBrandByID($pdo, $_GET['brand_id']);
    
    $id = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];

        Brand::deleteBrand($pdo, $id);
        header("location: listBrand.php");

    }
?>
    <div class="container-fluid">
        <h2 class="text-center">Xóa thương hiệu</h2>
            <form class="w-50 m-auto" method="post">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input class="form-control" readonly id="id" name="id" value="<?=$brand->brand_id?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên thương hiệu</label>
                    <input class="form-control" readonly id="name" name="name" value="<?=$brand->brand_name?>">
                </div>
                <fieldset  class="mb-3">
                    <label for="textarea" class="form-label">Mô tả</label>
                    <textarea rows="6" readonly class="form-control" id="desc" name="desc" placeholder="Your description"><?=$brand->brand_desc?></textarea>
                </fieldset>
                <div class="mb-3">
                    <label for="img" class="form-label">Hình ảnh</label>
                    <img class="img-fluid mx-3 w-25" src="../assets/images/brand/<?=$brand->brand_image?>" width="100" style="border-color: black; border: 2px">
                </div>
                <button type="submit" class="btn btn-primary">Xóa thương hiệu</button>
                
            </form>

    </div>

</div>
<?php
    require "inc/footer.php";
?>
