<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Brand.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();
    $brand = Brand::getOneBrandByID($pdo, $_GET['brand_id']);
    
    $nameErrors = "";
    $desErrors = "";
    $imgErrors = "";
    
    $img = "";
    $id = "";
    $name = "";
    $desc = "";
    $check = true;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $desc= $_POST['des'];
        $img = $brand->brand_image;

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
                    throw new Exception('File too large');
                }
    
                $mime_types = ['image/png', 'image/jpeg'];
    
                $file_info = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($file_info, $_FILES['file']['tmp_name']); // trả về type file mà ng dùng up lên, ktra chính xác mà kh cần biết đuôi file là gì
    
                if(!in_array($mime_type, $mime_types)) { // ktra type file dựa vào phần đuôi (.png,..) nên user có thể đổi đuôi file từ doc thành jpg nên ktra này kh tối ưu
                    throw new Exception('Invalid file type');
                }
    
                $pathinfo = pathinfo($_FILES['file']['name']); // lấy tên file
                $extension = $pathinfo['extension']; // lấy đuôi file
                $fname = 'logo' . '.' . $extension;
                $dest = '../assets/images/brand/' . $fname;
                $i = 1;
                while(file_exists($dest)) { // nếu file tồn tại rồi thì đặt tên khác (image-1, image-2,...)
                    $fname = 'logo'. "-$i". '.' . $extension;
                    $dest = '../assets/images/brand/' . $fname;
                    $i++;
                }
            }

            // unlink("uploads/image.jpg"); // xóa file sau khi đã upload

        }catch(Exception $e) {
            $imgErrors =  $e->getMessage();
        }

        if(empty($name)) {
            $nameErrors ="Vui lòng nhập tên";
        }

        if(empty($desc)) {
            $desErrors ="Vui lòng nhập mô tả";
        }

        $check = !$nameErrors && !$desErrors && !$imgErrors;
        if($check) {
            if($_FILES['file']['error'] != 4) {
                if(move_uploaded_file($_FILES['file']['tmp_name'], $dest)) { // đỗi đg dẫn lưu
                    $img = $fname;
                }
                else {
                    $imgErrors = 'Unable to move file.';
                }
            }
            Brand::editBrand($pdo, $id, $name, $desc, $img);
        }

    }
?>
    <div class="container-fluid">
        <h2 class="text-center">Cập nhật thương hiệu</h2>
            <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input class="form-control" readonly id="id" name="id" value="<?=$brand->brand_id?>">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Tên thương hiệu</label>
                    <input class="form-control" id="name" name="name" value="<?=$check?$brand->brand_name:$name?>">
                    <span class="text-danger fw-bold"><?=$nameErrors?></span>
                </div>

                <fieldset  class="mb-3">
                    <label for="textarea" class="form-label">Mô tả</label>
                    <textarea rows="6" class="form-control" id="desc" name="des" placeholder="Your description"><?=$check?$brand->brand_desc:$desc?></textarea>
                    <span class="text-danger fw-bold"><?=$desErrors?></span>
                </fieldset>
                <div class="mb-3">
                    <label for="price" class="form-label">Hình ảnh</label>
                    <img id="preview" src="../assets/images/brand/<?=$brand->brand_image ?>" class="m-2 border" width="100">
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
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                
            </form>

    </div>

</div>
<?php
    require "inc/footer.php";
?>
