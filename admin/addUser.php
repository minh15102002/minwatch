<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Auth.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();

    $nameErrors = "";
    $emailErrors = "";
    $passErrors = "";
    $phoneErrors = "";
    $roleErrors = "";

    $name = "";
    $email = "";
    $pass = "";
    $phone = "";
    $result = "";
    $role = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email= $_POST['email'];
        $pass =  $_POST['password'];
        $role = $_POST['role'];
        
        $check = Auth::addUser($pdo, $name, $phone, $email, $pass, $role);
        if($check === true){
            header("location:listUser.php");
        }
        else{
            if(isset($check['nameError']))
                $nameErrors = $check['nameError'];

            if(isset($check['mailError']))
                $emailErrors = $check['mailError'];

            if(isset($check['passError']))
                $passErrors = $check['passError'];

            if(isset($check['phoneError']))
                $phoneErrors = $check['phoneError'];

            if(isset($check['roleError']))
                $roleErrors = $check['roleError'];
        }
    }
?>
    <div class="container-fluid">
        <h2 class="text-center">Thêm User</h2>
            <form class="w-50 m-auto" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Email</label>
                    <input class="form-control" name="email" type="email" placeholder="Email" value="<?=$email?>">
                    <span class="text-danger fw-bold"><?=$emailErrors?></span>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Tên User</label>
                    <input class="form-control" name="name" type="text" placeholder="Họ tên" value="<?=$name?>">
                    <span class="text-danger fw-bold"><?=$nameErrors?></span>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Số điện thoại</label>
                    <input class="form-control" name="phone" type="text" placeholder="Số điện thoại" value="<?=$phone?>">
                    <span class="text-danger fw-bold"><?=$phoneErrors?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input id="password" class="form-control" name="password" type="" placeholder="Mật khẩu" value="<?=$pass?>">
                        <button type="button" class="btn btn-secondary" onclick="generatePassword()">Tạo mật khẩu</button>
                        <button type="button" class="btn btn-secondary" onclick="clearPassword()">Clear</button>
                    </div>
                    <span class="text-danger fw-bold"><?=$passErrors?></span>
                </div>
                <script>
                    function generatePassword() {
                        var length = 10,
                            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                            specialChars = "!@#$%^&",
                            // specialChars = "!@#$%^&*()_+{}:<>?[];,.",
                            password = "";

                        password += getRandomCharacter("abcdefghijklmnopqrstuvwxyz");
                        password += getRandomCharacter("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
                        password += getRandomCharacter("0123456789");
                        password += getRandomCharacter(specialChars);

                        for (var i = 4, n = charset.length; i < length; ++i) {
                            password += charset.charAt(Math.floor(Math.random() * n));
                        }

                        password = shuffleString(password);

                        var passwordField = document.getElementById("password");
                        passwordField.value = password;
                        // passwordField.readOnly = false;  // Bỏ readonly khi tạo mật khẩu
                    }

                    function getRandomCharacter(charset) {
                        return charset.charAt(Math.floor(Math.random() * charset.length));
                    }

                    function shuffleString(str) {
                        var arr = str.split('');
                        for (var i = arr.length - 1; i > 0; i--) {
                            var j = Math.floor(Math.random() * (i + 1));
                            var temp = arr[i];
                            arr[i] = arr[j];
                            arr[j] = temp;
                        }
                        return arr.join('');
                    }

                    function clearPassword() {
                        var passwordInput = document.getElementById("password");
                        passwordInput.value = "";
                        passwordInput.readOnly = true;
                    }
                </script>
                <div class="mb-3">
                    <label for="name" class="form-label">Role</label>
                    <select name="role" class="form-select" aria-label="Default select example">
                        <option>Chọn quyền cho user</option>
                        <option value="user" <?= (isset($role) && $role == 'user') ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= (isset($role) && $role == 'admin') ? 'selected' : '' ?>>Admin</option>
                    </select>
                    <span class="text-danger fw-bold"><?=$roleErrors?></span>
                </div>
                <button type="submit" class="btn btn-primary">Thêm User</button>
                
            </form>

    </div>

</div>
<?php
    require "inc/footer.php";
?>
