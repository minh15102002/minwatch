<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Product.php";
    require_once "../class/Category.php";
    require_once "../class/Brand.php";
    require_once "../class/Auth.php";
    // require_once "inc/init.php";

    $nameErrors = "";
    $desErrors = "";
    $priceErrors = "";
    $catErrors = "";
    $brandErrors = "";
    $imgErrors = "";
    
    $id = "";
    $name = "";
    $desc = "";
    $price = "";
    $cat  = "";
    $brand  = "";
    $img = "";
    $brand_name  = "";
    $dest = "";

    // $auth = new Auth();
    // $auth->restrictAccess();
    $check = true;

    $conn =  new Database();
    $pdo = $conn->getConnect();
    $product = Product::getDetailProductByID($pdo, $_GET["product_id"]);
    $data_cat = Category::getAll($pdo);
    $data_brand = Brand::getAll($pdo);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $desc= $_POST['des'];
        $price =  $_POST['price'];
        $cat =  $_POST["cat"];
        $brand =  $_POST["brand"];
        $img =  $product->product_image;

        if(empty($name)) {
            $nameErrors ="Vui lòng nhập tên";
        }

        if(empty($desc)) {
            $desErrors ="Vui lòng nhập mô tả";
        }

        if(empty($price)) {
            $priceErrors ="Vui lòng nhập giá";
        }elseif (!ctype_digit($price)) {
            $priceErrors = "Giá phải là chữ số nguyên";
        }

        if($cat == 0) {
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
                        // throw new Exception('No file uploaded');
                        break;
                    // default:
                    //     throw new Exception('An error Occured');
                }
    
                if($_FILES['file']['error'] != 4) {
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
                }
    
                // unlink("uploads/image.jpg"); // xóa file sau khi đã upload
    
            }catch(Exception $e) {
                $imgErrors =  $e->getMessage();
            }
        }

        $check = !$nameErrors && !$desErrors && !$imgErrors && !$priceErrors &&
        !$catErrors && !$brandErrors;

        if($check) {
            if($_FILES['file']['error'] != 4) {
                if(move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
                    $img = $fname;
                }
                else {
                    $imgErrors = 'Unable to move file.';
                }
            }
            Product::editProduct($pdo, $id, $name, $price, $desc, $img, $brand, $cat);
        }

    }
?>
    <div class="container-fluid">
        <h2 class="text-center">Cập nhật sản phẩm</h2>
            <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input class="form-control" id="id" name="id" readonly value="<?=$product->product_id?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên SP</label>
                    <input class="form-control" id="name" name="name" value="<?=$check?$product->product_name:$name?>">
                    <span class="text-danger fw-bold"><?=$nameErrors?></span>
                </div>
                <fieldset>
                    <label for="textarea" class="form-label">Description</label>
                    <textarea rows="6" class="form-control" id="message" name="des" placeholder="Your description"><?=$check?$product->product_description:$desc?></textarea>
                    <span class="text-danger fw-bold"><?=$desErrors?></span>
                </fieldset>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Hình ảnh</label>
                    <img id="preview" src="../assets/images/img_pro/<?=$product->product_image ?>" class="m-2 border" width="100">
                    <input type="file" class="form-control" id="image" name="file" value="<?=$img?>" onchange="previewImage(event)">
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
                    <label for="price" class="form-label">Giá</label>
                    <input class="form-control" id="price" name="price" value="<?=$check?$product->product_price:$price?>">
                    <span class="text-danger fw-bold"><?=$priceErrors?></span>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Loại sản phẩm</label>
                    <select class="form-select" aria-label="Default select example" name="cat">
                        <option value="0">Chọn danh mục sản phẩm</option>
                        <?php foreach($data_cat as $cat): ?>
                            <option value="<?=$cat->category_id ?>" <?=($cat->category_id == $product->category_id)?'selected':''?>><?=$cat->category_name?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-danger fw-bold"><?=$catErrors?></span>
                </div>


                <div class="mb-3">
                    <label for="price" class="form-label">Thương hiệu</label>
                    <select class="form-select" aria-label="Default select example" name="brand">
                        <option value="0">Chọn thương hiệu</option>
                        <?php foreach($data_brand as $b): ?>
                            <option value="<?=$b->brand_id?>" <?= ($b->brand_id == $product->brand_id) ? 'selected' : '' ?>><?=$b->brand_name?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-danger fw-bold"><?=$brandErrors?></span>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật SP</button>
                
            </form>

    </div>

</div>
<?php
    require "inc/footer.php";
?>