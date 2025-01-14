<?php
    require_once "inc/header.php";
    require_once "class/Database.php";
    
    $conn =  new Database();
    $pdo = $conn->getConnect();
    
    $nameErrors = "";
    $emailErrors = "";
    $passErrors = "";
    $phoneErrors = "";
    $passconfirmErrors = "";

    $name = "";
    $email = "";
    $pass = "";
    $phone = "";
    $pass_confirm = "";
    $result = "";
    $role = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email= $_POST['email'];
        $pass =  $_POST['password'];
        $pass_confirm = $_POST['password_confirm'];
        
        $check = Auth::register($pdo, $name, $phone, $email, $pass, $pass_confirm);

        if($check === true){
            $result = "Đăng ký thành công";
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

            if(isset($check['passconfError']))
                $passconfirmErrors = $check['passconfError'];
                
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
                            <h1 class="text-center title-page">Đăng ký tài khoản</h1>
                            <form id="customer-form" class="js-customer-form" method="post">
                                <div>
                                    <div class="form-group">
                                        <div>
                                            <input class="form-control" name="name" type="text" placeholder="Họ tên" value="<?=$name?>">
                                        </div>
                                        <p class="text-danger text-start fw-bold"><?=$nameErrors?></p>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <input class="form-control" name="phone" type="text" placeholder="Số điện thoại" value="<?=$phone?>">
                                        </div>
                                        <p class="text-danger text-start fw-bold"><?=$phoneErrors?></p>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <input class="form-control" name="email" type="email" placeholder="Email" value="<?=$email?>">
                                        </div>
                                        <p class="text-danger text-start fw-bold"><?=$emailErrors?></p>
                                    </div>
                                    <div class="form-group">
                                        <div>
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
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <div class="input-group js-parent-focus">
                                                <input class="form-control js-child-focus js-visible-password" name="password_confirm" type="password" placeholder="Nhập lại mật khẩu"  value="<?=$pass_confirm?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-danger text-start fw-bold"><?=$passconfirmErrors?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div>
                                        <h5 class="text-success"><?=$result?></h5>

                                        <button class="btn btn-account" data-link-action="sign-in" type="submit">
                                            Đăng ký
                                        </button>

                                        <?php if(!empty($result)):?>
                                            <button class="btn btn-account">
                                                <a href="login.php" class="text-white text-decoration-none">Đăng nhập</a>
                                            </button>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div>
                                <a href="login.php" class="px-5 ">Bạn đã tài khoản? Đăng nhập</a>
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