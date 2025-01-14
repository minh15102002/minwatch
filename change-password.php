<?php
    require_once "inc/header.php";
    require_once "class/Database.php";
    require_once "class/Auth.php";
    
    $conn =  new Database();
    $pdo = $conn->getConnect();
    
    $emailErrors = "";
    $passconfirmErrors = "";
    $passOldErrors = "";
    $passNewErrors = "";

    $email = "";
    $pass = "";
    $passOld = "";
    $passNew = "";
    $pass_confirm = "";
    $passwd_verify = "";
    $result = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email= $_POST['email'];
        $passOld =  $_POST['passold'];
        $passNew =  $_POST['passnew'];
        $pass_confirm = $_POST['password_confirm'];
        
        if(empty($email)) {
            $emailErrors ="Email không được để trống";
        }
        elseif(!Auth::isEmailExist($pdo, $email)) {
            $emailErrors ="Email không tồn tại";
        }
        else {
            $pass = Auth::getPassword($pdo, $email);
            $passwd_verify = password_verify($passOld, $pass);
        }

        if(empty($passOld)) {
            $passOldErrors ="Vui lòng nhập lại mật khẩu cũ!";
        }
        elseif($passOld != $passwd_verify) {
            $passOldErrors = "Mật khẩu không đúng!";
        }

        if(empty($passNew)) {
            $passNewErrors ="Vui lòng nhập mật khẩu mới";
        }
        elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $passNew)) {
            $passNewErrors = "Password phải có ít nhất 8 ký tự, có ít nhất 1 ký tự hoa, có số và ký tự đặc biệt!";
        }

        if(empty($pass_confirm)) {
            $passconfirmErrors = "Vui lòng nhập lại mật khẩu mới!";
        }
        elseif($pass_confirm != $passNew) {
            $passconfirmErrors = "Xác nhận mật khẩu không đúng!";
        }

        if(!$emailErrors && !$passconfirmErrors && !$passOldErrors && !$passNewErrors) {
            $result = Auth::changePassword($pdo, $email, $pass, $passNew)?'<div class="alert alert-success" role="alert">Đổi mật khẩu thành công</div>':"";
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
                            <h1 class="text-center title-page">Đổi mật khẩu</h1>
                            <form id="customer-form" class="js-customer-form" method="post">
                                <div>
                                    <div class="form-group">
                                        <div>
                                            <input class="form-control" name="email" type="email" placeholder="Email" value="<?=$email?>">
                                        </div>
                                        <p class="text-danger text-start fw-bold"><?=$emailErrors?></p>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <div class="input-group js-parent-focus">
                                                <input class="form-control js-child-focus js-visible-password" name="passold" type="password" placeholder="Nhập mật khẩu cũ" value="<?=$passOld?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-danger text-start fw-bold"><?=$passOldErrors?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <div class="input-group js-parent-focus">
                                                <input class="form-control js-child-focus js-visible-password" name="passnew" type="password" placeholder="Nhập mật khẩu mới" value="<?=$passNew?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-danger text-start fw-bold"><?=$passNewErrors?></p>
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
                                        <?=$result?>
                                        <button class="btn btn-account" data-link-action="sign-in" type="submit">
                                            Đổi mật khẩu
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