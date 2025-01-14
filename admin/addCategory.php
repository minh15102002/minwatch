<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Category.php";

    $nameErrors = "";
    $name = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        if(empty($name)) {
            $nameErrors ="Vui lòng nhập tên";
        }
        
        if(!$nameErrors) {
            $conn =  new Database();
            $pdo = $conn->getConnect();
            $data = Category::addOneCategory($pdo, $name);
            header("location: listCategory.php");
        }

    }
?>
    <div class="container-fluid">
        <h2 class="text-center">Thêm danh mục mới</h2>
            <form class="w-50 m-auto" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục</label>
                    <input class="form-control" id="name" name="name" value="<?=$name?>">
                    <span class="text-danger fw-bold"><?=$nameErrors?></span>
                </div>
                
                <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                
            </form>

    </div>

</div>
<?php
    require "inc/footer.php";
?>
