<?php

class Auth {
    public $id, $email, $pass, $name, $phone;

    // public function __construct($email = "", $pass = "", $name = "", $phone = "") {
    //     $this->email = $email;
    //     $this->pass = $pass;
    //     $this->name = $name;
    //     $this->phone = $phone;
    // }

    // public static function login($pdo, $email, $pass) {
    //     $sql = "SELECT id, password, role FROM user WHERE email=:email";
    //     $stmt = $pdo->prepare($sql);

    //     $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    //     if($stmt->execute()){
    //         $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
    //         $auth = $stmt->fetch(); // Lấy đối tượng Auth từ kết quả truy vấn
    //         $passwd_verify = false;
    //         if($auth) {
    //             $hashed_password = $auth->password;
    //             $custom_id = $auth->id;
    //             $role = $auth->role;
    //             $passwd_verify = password_verify($pass, $hashed_password);
    //         }
    //         if($passwd_verify) {
    //             $_SESSION['user_id'] = $custom_id;
    //             $_SESSION['logged_user'] = $email;
    //             $_SESSION['role'] = $role;
    //             return true;
    //         }
    //         else {
    //             $errorMess = [];
    //             if(empty($email)) {
    //                 $errorMess['nameError'] ="Email không được để trống";
    //             }
    
    //             if(empty($pass)) {
    //                 $errorMess['passError']  ="Password không được để trống";
    //             }
    //             elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass)) {
    //                 $errorMess['passError']  = "Password phải có ít nhất 8 ký tự, có ít nhất 1 ký tự hoa, có số và ký tự đặc biệt!";
    //             }
    //             return $errorMess;
    //         }
    //     }
    // }
    public static function login($pdo, $email, $pass) {
        $sql = "SELECT id, password, name, email, role FROM user WHERE email=:email";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
            $auth = $stmt->fetch(); // Lấy đối tượng Auth từ kết quả truy vấn
            $passwd_verify = false;
            if($auth) {
                $hashed_password = $auth->password;
                $custom_id = $auth->id;
                $role = $auth->role;
                $name = $auth->name; // Lấy tên người dùng từ cơ sở dữ liệu
                $passwd_verify = password_verify($pass, $hashed_password);
            }
            if($passwd_verify) {
                $_SESSION['user_id'] = $custom_id;
                $_SESSION['logged_user'] = $name;  // Lưu email vào session
                $_SESSION['user_email'] = $email;    // Lưu name vào session
                $_SESSION['role'] = $role;
                return true;
            }
            else {
                $errorMess = [];
                if(empty($email)) {
                    $errorMess['emailError'] ="Email không được để trống";
                }
    
                if(empty($pass)) {
                    $errorMess['passError']  ="Password không được để trống";
                }
                elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass)) {
                    $errorMess['passError']  = "Password phải có ít nhất 8 ký tự, có ít nhất 1 ký tự hoa, có số và ký tự đặc biệt!";
                }
                return $errorMess;
            }
        }
    }
    

    public static function register($pdo, $name, $phone, $email, $pass, $pass_confirm) {
        $errorMess = [];
        if(empty($name)) {
            $errorMess['nameError'] ="Họ tên không được bỏ trống!";
        }

        if(empty($email)) {
            $errorMess['mailError'] ="Email không được bỏ trống!";
        }
        elseif(!preg_match("/^\\S+@\\S+\\.\\S+$/", $email)) {
            $errorMess['mailError'] = "Email không hợp lệ!";
        }
        elseif(self::isEmailExist($pdo, $email)) {
            $errorMess['mailError'] = "Email đã tồn tại";
        }
        
        if (empty($phone)) {
            $errorMess['phoneError'] = "Số điện thoại không được bỏ trống!";
        }
        elseif (!ctype_digit($phone)) {
            // Số điện thoại không hợp lệ
            $errorMess['phoneError'] = "Số điện thoại phải là chữ số nguyên";
        }
        elseif(!preg_match("/^[0-9]{10}$/", $phone)) {
            // Số điện thoại không hợp lệ, thông báo cho người dùng
            $errorMess['phoneError'] = "Số điện thoại phải đủ 10 số";
        }

        if(empty($pass)) {
            $errorMess['passError'] ="Mật khẩu không được bỏ trống!";
        }
        elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass)) {
            $errorMess['passError'] = "Password phải có ít nhất 8 ký tự, có ít nhất 1 ký tự hoa, có số và ký tự đặc biệt!";
        }

        if(empty($pass_confirm)) {
            $errorMess['passconfError'] = "Xác nhận mật khẩu không được bỏ trống!";
        }
        elseif($pass_confirm != $pass) {
            $errorMess['passconfError'] = "Xác nhận mật khẩu không đúng!";
        }

        if(empty($errorMess)) {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(name, phone, email, password, role) VALUES(:name, :phone, :email, :password, :role)";
            $role = "user";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(":role", $role, PDO::PARAM_STR);

            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
                // return $stmt->fetch();
                return true;
            }
        }
        else{
            return $errorMess;
        }
    }
    
    public function restrictAccess() {
        if(!isset($_SESSION['logged_user'])){
            header("location: login.php");
            exit;
        }
    }

    public function restrictAccessAdmin() {
        if(!isset($_SESSION['logged_user'])){
            header("location: ../login.php");
            exit;
        }
        else if($_SESSION['role'] != "admin") {
            header("location: 404.php");
            exit;
        }
    }

    // chức năng quên mật khẩu và đổi mật khẩu
    public static function isEmailExist($pdo, $email) {
        $sql = "SELECT COUNT(*) FROM user WHERE email=:email";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count>0?true:false;
    }

    public static function generateOTP($length = 6) {
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= mt_rand(0, 9);
        }
        return $otp;
    }

    public static function getPassword($pdo, $email) {
        $sql = "SELECT password FROM user WHERE email=:email ";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    public static function changePassword($pdo, $email, $passOld, $passNew) {
        $hashed_password = password_hash($passNew, PASSWORD_DEFAULT);
        
        $sql = "UPDATE user SET password=:passnew WHERE email=:email and password=:passold";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":passold", $passOld, PDO::PARAM_STR);
        $stmt->bindParam(":passnew", $hashed_password, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
            return true;
        }
    }

    public static function resetPassword($pdo, $email, $passNew) {
        $hashed_password = password_hash($passNew, PASSWORD_DEFAULT);
        
        $sql = "UPDATE user SET password=:passnew WHERE email=:email";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":passnew", $hashed_password, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
            return true;
        }
    }

    // --------- admin ----------
    // quản lý user
    public static function getAllUser($pdo, $limit, $offset) {
        $sql = "SELECT * FROM user
        ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);

        // $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
            return $stmt->FetchAll();
        }
    }

    public static function countAllUser($pdo) {
        $sql = "SELECT COUNT(*) FROM user";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    public static function getOneUserByID($pdo, $id) {
        $sql = "SELECT * FROM user WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
            return $stmt->fetch();
        }
    }

    public static function deleteUser($pdo, $id) {
        $sql = "DELETE FROM user WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            header("location: listUser.php");
        }

    }

    public static function addUser($pdo, $name, $phone, $email, $pass, $role) {
        $errorMess = [];
        if(empty($name)) {
            $errorMess['nameError'] ="Họ tên không được bỏ trống!";
        }

        if(empty($email)) {
            $errorMess['mailError'] ="Email không được bỏ trống!";
        }
        elseif(!preg_match("/^\\S+@\\S+\\.\\S+$/", $email)) {
            $errorMess['mailError'] = "Email không hợp lệ!";
        }
        elseif(self::isEmailExist($pdo, $email)) {
            $errorMess['mailError'] = "Email đã tồn tại";
        }

        if (empty($phone)) {
            $errorMess['phoneError'] = "Số điện thoại không được bỏ trống!";
        }
        elseif (!ctype_digit($phone)) {
            // Số điện thoại không hợp lệ
            $errorMess['phoneError'] = "Số điện thoại phải là chữ số nguyên";
        }
        elseif(!preg_match("/^[0-9]{10}$/", $phone)) {
            // Số điện thoại không hợp lệ, thông báo cho người dùng
            $errorMess['phoneError'] = "Số điện thoại phải đủ 10 số";
        }

        if(empty($pass)) {
            $errorMess['passError'] ="Mật khẩu không được bỏ trống!";
        }
        elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass)) {
            $errorMess['passError'] = "Password phải có ít nhất 8 ký tự, có ít nhất 1 ký tự hoa, có số và ký tự đặc biệt!";
        }

        if(empty($role) || $role == "Chọn quyền cho user") {
            $errorMess['roleError'] ="Hãy chọn quyền cho user";
        }

        if(empty($errorMess)) {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(name, phone, email, password, role) VALUES(:name, :phone, :email, :password, :role)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(":role", $role, PDO::PARAM_STR);

            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
                return true;
            }
        }
        else{
            return $errorMess;
        }
    }
    
    public static function editUser($pdo, $id, $email, $name, $phone, $role) {
        $sql = "UPDATE user SET email=:email, name=:name, phone=:phone, role=:role WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
        $stmt->bindParam(":role", $role, PDO::PARAM_STR);

        // if($stmt->execute()){
        //     $_SESSION['success_update'] = "Cập nhật thành công."; 
        //     header("location: listUser.php");
        // }
        if ($stmt->execute()) {
            $_SESSION['success_update'] = "Cập nhật thành công."; 
            return true; // Trả về true nếu cập nhật thành công
        }
        return false; // Trả về false nếu không thành công
    }

    public static function totalUser($pdo) {
        $sql = "SELECT COUNT(*) FROM user";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }
}