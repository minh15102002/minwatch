<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';

    require_once "inc/header.php";
    require_once "class/Database.php";
    require_once "class/Auth.php";
    require_once "inc/init.php";
    // require_once "inc/Mail.php";
    
    $conn =  new Database();
    $pdo = $conn->getConnect();
    $result = "";
    $email = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];

        $check = Auth::isEmailExist($pdo, $email);
        if($check) {
            $otp = Auth::generateOTP();
            $mail = new PHPMailer(true);
            // $mail->charset = 'UTF-8';
        
            try {
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'nguyennhuminh2002@gmail.com';                     //SMTP username
                $mail->Password   = 'mcmw ezjg vkex xjax';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                $mail->Port       = 587;                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
                //Recipients
                // $mail->setFrom('phthanhvote.info@gmail.com', 'Min Watch');
                $mail->setFrom('nguyennhuminh2002@gmail.com', 'Min Watch');
                $mail->addAddress("$email", "$email");     //Add a recipient
        
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = '<p>Chào bạn, chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn</p>
                <p>Mã OPT của bạn là: <b>'. $otp .'</b></p>
                <p><b style="color:red;">Lưu ý: Mã chỉ có thời hạn trong 2 phút</b></p>
                <p>Trân trọng</p>
                <p><b>Min Watch</b></p>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
                $mail->send();
                $_SESSION['code'] = $otp;
                $_SESSION['emailreset'] = $email;
                
                // Thiết lập thời gian sống cho session (120 giây)
                $session_lifetime = 120;
                $_SESSION['expire_time'] = time() + $session_lifetime;

                header("location:verification.php");

            } catch (Exception $e) {
                $result = "Không thể gửi mail. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        else {
            $result = '<div class="alert alert-danger" role="alert">Email không tồn tại!</div>';
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
                            <h1 class="text-center title-page">Quên mật khẩu</h1>
                            <form id="customer-form" class="js-customer-form" method="post">
                                <div>
                                    <div class="form-group">
                                        <div>
                                            <input class="form-control" name="email" type="email" placeholder="Email" value="<?=$email?>">
                                        </div>
                                    </div>
                                    <div class="form-group text-start">
                                        <p>Bạn chưa có tài khoản? <a href="register.php" class="text-success fw-bold">Đăng kí ngay</a></p>
                                        <p>Bạn đã có tài khoản? <a href="login.php" class="text-success fw-bold">Đăng nhập</a></p>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div>
                                        <?=$result?>
                                        <button class="btn btn-account" data-link-action="sign-in" type="submit">
                                            Send Email
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
