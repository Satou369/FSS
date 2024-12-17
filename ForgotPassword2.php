<!DOCTYPE html>
<html>
<head>
    <title>ForgotPassword</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img src="img/bg.png" width="100%" height="60%">
    <div class="ForgotPasswordForm">
        <div class="arrow"><a href="ForgotPassword.php">
            <img src="img/arrow.jpg">
        </a></div>
        <div class="ForgotPassword">Nhập mã xác nhận</div>
        <div class="LabelForgotPassword"> 
            <?php
                session_start();
                echo 'Mã sẽ được gửi qua email ' .htmlspecialchars($_SESSION['email']);
            ?>
        </div>
        <div>
            <form id="ForgotPasswordForm" method="POST" novalidate>
                <div class="ForgotPasswordElement">
                    <input type="text" id="OTP" name="OTP" placeholder="Nhập mã xác nhận">
                </div>
                <div class="ForgotPasswordButton">
                    <button type="submit" name="ForgotPassword2">Xác nhận</button>
                </div>
                <div class="resendOTP"><button name="resendOTP">Gửi lại mã</button>
                    
                </div>
                <div class="ForgotPassword3-error">
                <?php
                        require("PHPMailer-master/src/PHPMailer.php");
                        require("PHPMailer-master/src/SMTP.php");
                        require("PHPMailer-master/src/Exception.php");
            
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (isset($_POST['resendOTP'])) {
                                $otp = rand(100000, 999999);
                                $_SESSION['otp'] = $otp;
            
                                $email = $_SESSION['email'];
                                $mail = new PHPMailer\PHPMailer\PHPMailer();
                                $mail->IsSMTP();
                                $mail->SMTPAuth = true;
                                $mail->SMTPSecure = 'ssl';
                                $mail->Host = "smtp.gmail.com";
                                $mail->Port = 465;
                                $mail->IsHTML(true);
                                $mail->CharSet = 'UTF-8';
                                $mail->Username = "web82004199@gmail.com";
                                $mail->Password = "wzahhloikamjxhed";
                                $mail->SetFrom("web82004199@gmail.com", "Shop SOWH");
                                $mail->Subject = "Gửi mã xác nhận";
                                $mail->Body = "Mã OTP của bạn là: <strong>$otp</strong>";
                                $mail->AddAddress($email);
            
                                if ($mail->send()) {
                                    echo "Đã gửi lại mã xác nhận.";
                                } else {
                                    echo "Không thể gửi email. Vui lòng thử lại sau.";
                                }
                            } else if (isset($_POST['ForgotPassword2'])) {
                                $inputOtp = trim($_POST['OTP']);
                                if ($inputOtp == $_SESSION['otp']) {
                                    header("Location: ForgotPassword3.php");
                                    exit;
                                } else {
                                    echo "Mã OTP không chính xác.";
                                }
                            }
                        }
                        ?>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
