<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Auth.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();
    $user = Auth::getOneUserByID($pdo, $_GET['id']);
    
    $id = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];

        Auth::deleteUser($pdo, $id);

    }
?>
    <div class="container-fluid">
        <h2 class="text-center">Xóa User</h2>
            <form class="w-50 m-auto" method="post">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input class="form-control" readonly id="id" name="id" value="<?=$user->id?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Email</label>
                    <input class="form-control" readonly id="name" name="name" value="<?=$user->email?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên User</label>
                    <input class="form-control" readonly id="name" name="name" value="<?=$user->name?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Số điện thoại</label>
                    <input class="form-control" readonly id="name" name="name" value="<?=$user->phone?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Role</label>
                    <input class="form-control" readonly id="name" name="name" value="<?=$user->role?>">
                </div>
                <button type="submit" class="btn btn-primary">Xóa User</button>
                
            </form>

    </div>

</div>
<?php
    require "inc/footer.php";
?>
