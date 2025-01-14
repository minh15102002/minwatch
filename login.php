<?php
    require_once "inc/header.php";
    require_once "class/Database.php";
    require_once 'config-google.php';
    $conn =  new Database();
    $pdo = $conn->getConnect();
    
    $emailErrors = "";
    $passErrors = "";
    $login_failed = "";

    $email = "";
    $pass = "";
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $check = Auth::login($pdo, $email, $pass);

        if($check===true) {
            if($_SESSION['role'] == "user") {
                header("location:index.php");
            }
            else if($_SESSION['role'] == "admin") {
                header("location:admin/index.php");
            }
        }
        else {
            // echo "<script>alert('Đăng nhập thất bại');</script>";
            if(isset($check['nameError']))
                $emailErrors = $check['nameError'];

            if(isset($check['passError']))
                $passErrors = $check['passError'];
            $login_failed = "Đăng nhập thất bại!";
        }
    }
?>

<div id="wrapper-site">
    <div class="container">
        <div class="row">
            <div class='alert alert-info text-center w-50 fs-6' role='alert' style="margin: 20px auto;">
                Hãy đăng nhập để thêm sản phẩm vào giỏ hàng nhé 😉
            </div>"
            <div id="content-wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 onecol">
                <div id="main-register">
                    <div id="content" class="page-content-account">
                        <div class="register-form text-center">
                            <h1 class="text-center title-page">Đăng nhập</h1>
                            <form id="customer-form" class="js-customer-form" method="post">
                                <div>
                                    <div class="form-group">
                                        <div>
                                            <input class="form-control" name="email" type="email" placeholder="Email" value="<?=$email?>">
                                        </div>
                                        <p class="text-danger text-start fw-bold"><?=$emailErrors?></p>
                                    </div>
                                    <div class="form-group">
                                            <div class="input-group js-parent-focus">
                                                <input class="form-control js-child-focus js-visible-password" name="password" type="password" placeholder="Mật khẩu" value="<?=$pass?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-danger text-start fw-bold"><?=$passErrors?></p>
                                    </div>
                                    <div class="form-group text-center">
                                        <a href="forgot-password.php" class="px-5 fw-bold">Quên mật khẩu?</a>
                                        <a href="change-password.php" class="px-5 fw-bold">Đổi mật khẩu?</a>
                                    </div>
                                    
                                </div>

                                

                                <div class="clearfix">
                                    <div>
                                        <h5 class="text-danger fw-bold"><?=$login_failed?></h5>
                                        <button class="btn btn-account" data-link-action="sign-in" type="submit">
                                            Đăng nhập
                                        </button>
                                        <div style='display: flex;text-align: center;justify-content: center; margin-top: 5px;margin-bottom: 20px; '>
                                            <a href="<?php echo htmlspecialchars($client->createAuthUrl()); ?>" style='width: 300px;height: 35px;border: 2px solid red;border-radius: 5px;text-align: center;display: flex;justify-content: center;align-items: center;'>
                                                <img src='assets/images/google.png' alt='Google Login' style='width: 25px; height: 25px;margin-right:8px'>
                                                Google Login
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="register.php" class="px-5 ">Bạn chưa có tài khoản? Đăng ký</a>
                                    
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