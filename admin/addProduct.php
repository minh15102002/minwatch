<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Category.php";
    require_once "../class/Brand.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();
    $data_cat = Category::getAll($pdo);
    $data_brand = Brand::getAll($pdo);
    // $id = Product::getLastId($pdo);

    $nameErrors = "";
    $desErrors = "";
    $priceErrors = "";
    $imgErrors = "";
    $catErrors = "";
    $brandErrors = "";

    $name = "";
    $desc = "";
    $price = "";
    $img  = "";
    $cate  = "";
    $brand  = "";

    // $auth = new Auth();
    // $auth->restrictAccess();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $desc= $_POST['des'];
        $price =  $_POST["price"];
        // $img =  $_POST["image"];
        $cate =  $_POST["cat"];
        $brand =  $_POST["brand"];

        if(empty($name)) {
            $nameErrors ="Vui lòng nhập tên";
        }

        if(empty($desc)) {
            $desErrors ="Vui lòng nhập mô tả";
        }

        if(empty($price)) {
            $priceErrors ="Vui lòng nhập giá";
        }
        elseif (!ctype_digit($price)) {
            $priceErrors = "Giá phải là chữ số nguyên";
        }

        if($cate == 0) {
            $catErrors ="Vui lòng chọn danh mục";
        }

        if($brand == 0) {
            $brandErrors ="Vui lòng chọn thương hiệu";
        }
        else {
            $brand_name = Brand::getNameBrand($pdo, $brand);
            try{
                if(empty($_FILES['file'])) { // TH hy hữu (vì ng dùng đã submit thì dù kh chọn file thì vẫn có thông tin)
                    throw new Exception('Invalid upload');
                }
                switch($_FILES['file']['error']) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new Exception('Không có file');
                    default:
                        throw new Exception('An error Occured');
                }
    
                if($_FILES['file']['size'] > 1000000) { // ktra file > 1MB (tính theo byte)
                    throw new Exception('File quá lớn');
                }
    
                $mime_types = ['image/png', 'image/jpeg'];
    
                $file_info = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($file_info, $_FILES['file']['tmp_name']); // trả về type file mà ng dùng up lên, ktra chính xác mà kh cần biết đuôi file là gì
    
                if(!in_array($mime_type, $mime_types)) { // ktra type file dựa vào phần đuôi (.png,..) nên user có thể đổi đuôi file từ doc thành jpg nên ktra này kh tối ưu
                    throw new Exception('Phải up 1 hình ảnh');
                }
    
                $pathinfo = pathinfo($_FILES['file']['name']); // lấy tên file
                $extension = $pathinfo['extension']; // lấy đuôi file
                $fname = $brand_name . '.' . $extension;
                $dest = '../assets/images/img_pro/' . $fname;
                $i = 1;
                while(file_exists($dest)) { // nếu file tồn tại rồi thì đặt tên khác (image-1, image-2,...)
                    $fname = $brand_name. "-$i". '.' . $extension;
                    $dest = '../assets/images/img_pro/' . $fname;
                    $i++;
                }
    
                // unlink("uploads/image.jpg"); // xóa file sau khi đã upload
    
            }catch(Exception $e) {
                $imgErrors =  $e->getMessage();
            }
        }

        if(!$nameErrors && !$desErrors && !$priceErrors &&
        !$imgErrors && !$catErrors && !$brandErrors) {
            if(move_uploaded_file($_FILES['file']['tmp_name'], $dest)) { // đỗi đg dẫn lưu
                $img = $fname;
                Product::addOneProduct($pdo, $name, $price, $desc, $img, $brand, $cate);
                header("location: listProduct.php");
            }
            else {
                $imgErrors = 'Unable to move file.';
            }

        }
        // var_dump($cate);
    }
?>
    <div class="container-fluid">
        <h2 class="text-center">Thêm sản phẩm mới</h2>
            <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                <!-- <div class="mb-3">
                    <label for="name" class="form-label">Mã SP</label>
                    <input class="form-control" id="idpro" name="idpro" value="<?=$id + 1?>" readonly>
                </div> -->
                <div class="mb-3">
                    <label for="name" class="form-label">Tên SP</label>
                    <input class="form-control" id="name" name="name" value="<?=$name?>">
                    <span class="text-danger fw-bold"><?=$nameErrors?></span>
                </div>
                <div class="mb-3">
                    <label for="textarea" class="form-label">Description</label>
                    <textarea rows="6" class="form-control" id="message" name="des" placeholder="Your description"><?=$desc?></textarea>
                    <span class="text-danger fw-bold"><?=$desErrors?></span>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Giá</label>
                    <input class="form-control" id="price" name="price"  value="<?=$price?>">
                    <span class="text-danger fw-bold"><?=$priceErrors?></span>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Hình ảnh</label>
                    <img id="preview" src="../assets/images/img_pro/<?=$product->product_image ?>" class="m-2 border" width="100">
                    <input type="file" class="form-control" id="image" name="file"  value="<?=$img?>" onchange="previewImage(event)">
                    <span class="text-danger fw-bold"><?=$imgErrors?></span>
                </div>
                <script>
                    function previewImage(event) {
                        var input = event.target;
                        var reader = new FileReader();
                        var imgElement = document.getElementById('preview');

                        reader.onload = function () {
                            imgElement.src = reader.result;
                            imgElement.style.display = 'block'; // Hiển thị thẻ img
                        };

                        if (input.files && input.files[0]) {
                            reader.readAsDataURL(input.files[0]);
                        } else {
                            imgElement.style.display = 'none'; // Ẩn thẻ img nếu không có hình ảnh
                        }
                    }
                </script>

                <div class="mb-3">
                    <label for="price" class="form-label">Loại sản phẩm</label>
                    <select class="form-select" aria-label="Default select example" name="cat">
                        <option value="0" selected>Chọn danh mục sản phẩm</option>
                        <?php foreach($data_cat as $cat): ?>
                            <option <?=($cate==$cat->category_id)?'selected':''?> value="<?=$cat->category_id?>"><?=$cat->category_name?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-danger fw-bold"><?=$catErrors?></span>

                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Thương hiệu</label>
                    <select class="form-select" aria-label="Default select example" name="brand">
                        <option value="0"  selected>Chọn thương hiệu</option>
                        <?php foreach($data_brand as $b): ?>
                            <option <?=($brand==$b->brand_id)?'selected':''?> value="<?=$b->brand_id?>"><?=$b->brand_name?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-danger fw-bold"><?=$brandErrors?></span>
                </div>
                
                <button type="submit" class="btn btn-primary">Thêm SP</button>
                
            </form>

    </div>
</div>

<!-- Footer -->
<?php
    require "inc/footer.php";
?>