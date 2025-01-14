<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Auth.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();
    $user = Auth::getOneUserByID($pdo, $_GET['id']);
    
    $nameErrors = "";
    $emailErrors = "";
    $phoneErrors = "";
    $roleErrors = "";

    $id = "";
    $name = "";
    $email = "";
    $phone = "";
    $role = "";
    $check = true;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $role = $_POST['role'];

        if(empty($name)) {
            $nameErrors ="Vui lòng nhập tên";
        }

        if(empty($email)) {
            $emailErrors ="Vui lòng nhập Email";
        }
        
        if(empty($phone)) {
            $phoneErrors ="Vui lòng nhập số điện thoại";
        }
        elseif (!ctype_digit($phone)) {
            // Số điện thoại không hợp lệ
            $phoneErrors = "Số điện thoại phải là chữ số nguyên";
        }
        elseif(!preg_match("/^[0-9]{10}$/", $phone)) {
            $phoneErrors = "Số điện thoại phải đủ 10 số";
        }

        if(empty($role) || $role == "Chọn quyền cho user") {
            $roleErrors ="Vui lòng chọn quyền cho User";
        }

        $check = !$nameErrors && !$emailErrors && !$phoneErrors && !$roleErrors;
        
        // if($check) {
        //     Auth::editUser($pdo, $id, $email, $name, $phone, $role);
            
        // }
        // if ($check) {
        //     if (Auth::editUser($pdo, $id, $email, $name, $phone, $user->role)) {
        //         header("Location: listUser.php");
        //         unset($_SESSION['success_update']);
        //     } else {
        //         echo "<script>alert('Cập nhật không thành công.');</script>";
        //     }
        // }
        if ($check) {
            // Cập nhật thông tin người dùng
            if (Auth::editUser($pdo, $id, $email, $name, $phone, $user->role)) {
                // Cập nhật thành công
                echo "<script>alert('" . $_SESSION['success_update'] . "');</script>";
                unset($_SESSION['success_update']); // Xóa thông báo sau khi hiển thị
            } else {
                // Cập nhật không thành công
                echo "<script>alert('Cập nhật không thành công.');</script>";
            }
        }
        
    }
?>
    <div class="container-fluid">
        <h2 class="text-center">Cập nhật User</h2>
            <form class="w-50 m-auto" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Mã User</label>
                    <input class="form-control" name="id" type="id" placeholder="Email" value="<?=$user->id?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Email</label>
                    <input class="form-control" name="email" type="email" placeholder="Email" value="<?=$check?$user->email:$email?>">
                    <span class="text-danger fw-bold"><?=$emailErrors?></span>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Tên User</label>
                    <input class="form-control" name="name" type="text" placeholder="Họ tên" value="<?=$check?$user->name:$name?>">
                    <span class="text-danger fw-bold"><?=$nameErrors?></span>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Số điện thoại</label>
                    <input class="form-control" name="phone" type="text" placeholder="Số điện thoại" value="<?=$check?$user->phone:$phone?>">
                    <span class="text-danger fw-bold"><?=$phoneErrors?></span>
                </div>
                
                <div class="mb-3">
                    <label for="name" class="form-label">Role</label>
                    <select name="role" class="form-select" aria-label="Default select example">
                        <option>Chọn quyền cho user</option>
                        <option value="user" <?= ($check?$user->role:$role) == 'user' ? 'selected' : '' ?>>user</option>
                        <option value="admin" <?= ($check?$user->role:$role) == 'admin' ? 'selected' : '' ?>>admin</option>
                    </select>
                    <span class="text-danger fw-bold"><?=$roleErrors?></span>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật User</button>
                
            </form>

    </div>

</div>
<?php
    require "inc/footer.php";
?>
