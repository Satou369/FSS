<!DOCTYPE html>
<html>
<head>
    <title>ForgotPassword</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img src="img/bg.png" width="100%" height="60%">
    <div class="ForgotPasswordForm">
        <div class="arrow"><a href="login.php">
            <img src="img/arrow.jpg">
        </a></div>
        <div class="ForgotPassword">Quên mật khẩu</div>
        <div>
            <form id="ForgotPasswordForm" method="POST" novalidate>
                <div class="ForgotPasswordElement">
                    <input type="text" id="email" name="email" placeholder="Email">
                </div>
                <div id="ForgotPassword-error">
                    <?php 
                        require("PHPMailer-master/src/PHPMailer.php");
                        require("PHPMailer-master/src/SMTP.php");
                        require("PHPMailer-master/src/Exception.php");
                        
                        session_start();
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ForgotPassword'])) {
                            $email = trim($_POST['email']);
                            
                            $conn = new mysqli('localhost', 'root', '', 'fss');
                            if ($conn->connect_error) {
                                die("Kết nối thất bại: " . $conn->connect_error);
                            }
                        
                            // Kiểm tra dữ liệu đầu vào
                            if (empty($email)) {
                                echo 'Vui lòng nhập email.';
                            } else {
                                // Kiểm tra email có tồn tại không
                                $caulenh = "SELECT * FROM account WHERE email='$email'";
                                $kq = $conn->query($caulenh);
                        
                                if ($kq && $kq->num_rows > 0) {
                                    // Nếu email tồn tại, tạo mã OTP ngẫu nhiên có 6 chữ số
                                    $otp = rand(100000, 999999);  
                        
                                    // Lưu mã OTP vào session
                                    $_SESSION['otp'] = $otp;
                                    $_SESSION['email'] = $email;  // Lưu email vào session để kiểm tra sau khi nhập OTP
                        
                                    $mail = new PHPMailer\PHPMailer\PHPMailer();
                                    $mail->IsSMTP(); // enable SMTP
                        
                                    $mail->SMTPDebug = 0; // không hiển thị thông tin debug trên web
                                    $mail->SMTPAuth = true;
                                    $mail->SMTPSecure = 'ssl';
                                    $mail->Host = "smtp.gmail.com";
                                    $mail->Port = 465;
                                    $mail->IsHTML(true);
                                    $mail->CharSet = 'UTF-8'; // mã hoá tránh lỗi font khi gửi mail
                                    $mail->Username = "web82004199@gmail.com";
                                    $mail->Password = "wzahhloikamjxhed";
                                    $mail->SetFrom("web82004199@gmail.com", "Shop SOWH");
                                    $mail->Subject = "Gửi mã xác nhận";
                                    $mail->Body = "Mã OTP của bạn là: <strong>$otp</strong>";
                                    $mail->AddAddress($email);
                        
                                    if ($mail->send()){
                                        header("Location: ForgotPassword2.php");  // Chuyển hướng đến trang nhập OTP
                                        exit;
                                    } else {
                                        echo "Không thể gửi email. Vui lòng thử lại sau";
                                    }
                                } else {
                                    echo 'Email không tồn tại trong hệ thống.';  // Trường hợp email không tồn tại
                                }
                            }
                            $conn->close();
                        }
                    ?>
                    </div>
                <div class="ForgotPasswordButton">
                    <button type="submit" name="ForgotPassword">Gửi mã</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
