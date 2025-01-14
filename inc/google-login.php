<?php
require_once '../config-google.php';
require_once '../class/Auth.php'; // Đảm bảo Auth được load để sử dụng register
require_once '../class/Database.php'; // Đường dẫn đúng đến Database.php
require_once '../inc/init.php'; // Đường dẫn đúng đến init.php
require_once '../class/Product.php'; // Đường dẫn đúng đến Product.php
require_once '../class/Brand.php'; // Đường dẫn đúng đến Brand.php
require_once '../class/Category.php'; // Đường dẫn đúng đến Category.php
require_once '../class/Cart.php'; // Đường dẫn đúng đến Cart.php

// Khởi tạo kết nối cơ sở dữ liệu
$conn = new Database();
$pdo = $conn->getConnect();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Nếu đã đăng nhập, chuyển hướng đến trang chính
    exit();
}

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    // Kiểm tra xem access_token có tồn tại không
    if (isset($token['access_token'])) {
        $client->setAccessToken($token['access_token']);
        
        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $userinfo = [
            'email' => $google_account_info['email'],
            'name' => $google_account_info['name'],
            'picture' => $google_account_info['picture'],
            'google_id' => $google_account_info['id'], // ID từ Google
        ];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userinfo['email']]);
        
        if ($stmt->rowCount() > 0) {
            // Người dùng đã tồn tại
            $userinfo = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Người dùng chưa tồn tại, thêm vào cơ sở dữ liệu
            // Lấy thông tin người dùng từ Google
            $name = $userinfo['name'];
            $email = $userinfo['email'];
            $password = ''; // Không cần mật khẩu khi đăng nhập qua Google
            $phone = ''; // Giả sử không có số điện thoại
            $role = 'user'; // Vai trò mặc định

            // Sửa câu lệnh INSERT
            $sql = "INSERT INTO user (email, password, name, phone, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // Thực hiện truy vấn INSERT
            $stmt->execute([$email, $password, $name, $phone, $role]);

            // Lấy ID của người dùng mới được tạo
            $userinfo['id'] = $pdo->lastInsertId();
        }

        // Lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $userinfo['id'];
        $_SESSION['user_email'] = $userinfo['email'];
        $_SESSION['logged_user'] = $userinfo['name'];
        $_SESSION['user_picture'] = $userinfo['picture'];
        $_SESSION['role'] = 'user';

        // Chuyển hướng đến trang chính
        header("Location: ../index.php");
        exit();
    } else {
        echo "Lỗi: Không thể lấy access token.";
        var_dump($token); // In ra thông tin để kiểm tra
        exit();
    }
}

// Nếu không có mã, chuyển hướng về trang chính
header("Location: index.php");
exit();
?>