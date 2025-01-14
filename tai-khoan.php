<?php
    require_once "inc/header.php";
    require_once "class/Database.php";
    require_once "class/Product.php";
    require "inc/init.php";
    require_once "class/Auth.php";
    require_once "class/Cart.php";

// Kiểm tra xem người dùng đã đăng nhập chưa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Khởi tạo kết nối cơ sở dữ liệu
$conn = new Database();
$pdo = $conn->getConnect();

// Lấy thông tin người dùng từ session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Lấy thông tin người dùng
$id = $_SESSION['user_id'];
$user = Auth::getOneUserByID($pdo, $id);

if (!$user) {
    echo "Người dùng không tồn tại.";
    exit();
}

$nameErrors = "";
$emailErrors = "";
$phoneErrors = "";
$roleErrors = "";

$name = $user->name;
$email = $user->email;
$phone = $user->phone;
$role = $user->role;
$check = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $user->role; 

    
    if (empty($name)) {
        $nameErrors = "Vui lòng nhập tên";
    }

    if (empty($email)) {
        $emailErrors = "Vui lòng nhập Email";
    }
    
    if (empty($phone)) {
        $phoneErrors = "Vui lòng nhập số điện thoại";
    } elseif (!ctype_digit($phone)) {
        $phoneErrors = "Số điện thoại phải là chữ số nguyên";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $phoneErrors = "Số điện thoại phải đủ 10 số";
    }

   
    $check = !$nameErrors && !$emailErrors && !$phoneErrors && !$roleErrors;
    

    if ($check) {
      
        if (Auth::editUser($pdo, $id, $email, $name, $phone, $user->role)) {
            // Cập nhật thành công
            echo "<script>alert('" . $_SESSION['success_update'] . "');</script>";
            unset($_SESSION['success_update']); 
        } else {
            // Cập nhật không thành công
            echo "<script>alert('Cập nhật không thành công.');</script>";
        }
    }
}
?>

<div class="container-fluid">
    <h2 class="text-center">Cập nhật tài khoản</h2>
    <form class="w-50 m-auto" method="post">
        <div class="mb-3">
            <label for="id" class="form-label">Số tài khoản</label>
            <input class="form-control" name="id" type="text" value="<?=$user->id?>" readonly>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input class="form-control" name="email" type="email" placeholder="Email" value="<?=$email?>" readonly>
            <span class="text-danger fw-bold"><?=$emailErrors?></span>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Tên</label>
            <input class="form-control" name="name" type="text" placeholder="Họ tên" value="<?=$name?>">
            <span class="text-danger fw-bold"><?=$nameErrors?></span>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input class="form-control" name="phone" type="text" placeholder="Thêm số điện thoại" value="<?=$phone?>">
            <span class="text-danger fw-bold"><?=$phoneErrors?></span>
        </div>

        <input type="hidden" name="role" value="<?=$user->role?>">

        <button type="submit" class="btn btn-primary">Cập nhật Tài khoản</button>
    </form>
</div>

<?php
require "inc/footer.php";
?>