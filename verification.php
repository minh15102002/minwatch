<?php
    require_once "inc/header.php";
    require_once "class/Database.php";
    require_once "class/Auth.php";
    require_once "inc/init.php";
    
    $conn =  new Database();
    $pdo = $conn->getConnect();
    
    $code = "";
    $error = "";

    // var_dump($_SESSION['code']);
    // var_dump($_SESSION['emailreset']);

    // var_dump($_SESSION['expire_time']);
    // var_dump(time());

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Kiểm tra xem session đã hết hạn chưa
        if (isset($_SESSION['expire_time']) && time() > $_SESSION['expire_time']) {
            // Nếu session đã hết hạn, xoá nó và làm sạch dữ liệu
            unset($_SESSION['code']);
            unset($_SESSION['expire_time']);
            unset($_SESSION['emailreset']);
        }
    
        $code = $_POST['code'];
        if (isset($_SESSION['code'])) {
            if ($code == $_SESSION['code']) {
                unset($_SESSION['code']); // Xoá mã xác nhận khi hợp lệ
                header("location: reset-password.php");
            } else {
                $error = '<div class="alert alert-danger" role="alert">Mã xác nhận không hợp lệ!</div>';
            }
        } else {
            $error = '<div class="alert alert-danger" role="alert">Mã xác nhận đã hết thời hạn! <p>Trang sẽ chuyển hướng sau 5s để bạn nhập email và nhận mã mới</p></div>';
            header("refresh:5,url=forgot-password.php");
        }
    }

    
?>

<div id="wrapper-site">
    <div class="container">
        <div class="row">
            <div id="content-wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 onecol">
                <div id="main-register">
                    <div id="content" class="page-content-account">
                        <div class="register-form text-center">
                            <h1 class="text-center title-page">Nhập mã xác nhận</h1>
                            <form id="customer-form" class="js-customer-form" method="post">
                                <div>
                                    <div class="alert alert-success" role="alert">Hãy nhập mã xác nhận mà chúng tôi đã gửi cho bạn về mail</div>
                                    <div class="form-group">
                                        <div>
                                            <input class="form-control" name="code" type="" placeholder="Code" value="<?=$code?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div>
                                        <?=$error?>
                                        <button class="btn btn-account" data-link-action="sign-in" type="submit">
                                            Gửi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    require_once "inc/footer.php";
?>