<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Category.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();
    $cat = Category::getOneCategoryByID($pdo, $_GET['category_id']);
    
    $nameErrors = "";

    $id = "";
    $name = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $id = $_POST['id'];
        if(empty($name)) {
            $nameErrors ="Vui lòng nhập tên";
        }
        
        if(!$nameErrors) {
            $data = Category::editCategory($pdo, $id, $name);
        }

    }
?>
    <div class="container-fluid">
        <h2 class="text-center">Cập nhật danh mục</h2>
            <form class="w-50 m-auto" method="post">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input class="form-control" readonly id="id" name="id" value="<?=$cat->category_id?>">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục</label>
                    <input class="form-control" id="name" name="name" value="<?=$cat->category_name?>">
                    <span class="text-danger fw-bold"><?=$nameErrors?></span>
                </div>
                
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                
            </form>

    </div>

</div>
<?php
    require "inc/footer.php";
?>
