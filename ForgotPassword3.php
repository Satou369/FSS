<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img src="img/bg.png" width="100%" height="60%">
    <div class="ForgotPasswordForm">
        <div class="arrow"><a href="ForgotPassword2.php">
            <img src="img/arrow.jpg">
        </a></div>
        <div class="ForgotPassword">Đặt lại mật khẩu</div>
        <div>
            <form id="ForgotPasswordForm" method="POST" novalidate>
                <div class="ForgotPasswordElement">
                    <input type="password" id="password1" name="password1" placeholder="Mật khẩu mới" 
                    value="<?php echo isset($_POST['password1']) ? $_POST['password1'] : ''; ?>">
                </div>
                <div class="ForgotPasswordElement">
                    <input type="password" id="password2" name="password2" placeholder="Xác nhận mật khẩu"
                    value="<?php echo isset($_POST['password2']) ? $_POST['password2'] : ''; ?>">
                </div>
                <div id="ForgotPassword-error">
                    <?php 
                        session_start();
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ForgotPassword3'])) {
                            $password1 = trim($_POST['password1']);
                            $password2 = trim($_POST['password2']);
                            $email = $_SESSION['email'];
                        
                            $conn = new mysqli('localhost', 'root', '', 'fss');
                            if ($conn->connect_error) {
                                die("Kết nối thất bại: " . $conn->connect_error);
                            }
                        
                            // Kiểm tra dữ liệu đầu vào
                            if ($password1 != $password2) {
                                echo 'Mật khẩu và xác nhận mật khẩu không khớp.<br>Vui lòng kiểm tra lại.';
                            } else {
                                $updatePassword = "UPDATE account SET password='$password1' WHERE email='$email'";
                                if ($conn->query($updatePassword) === TRUE) {
                                    header("Location: login.php");
                                    exit;
                                } else {
                                    echo 'Lỗi khi cập nhật mật khẩu.';
                                }
                            }
                            $conn->close();
                        }
                    ?>
                </div>
                <div class="ForgotPasswordButton">
                    <button type="submit" name="ForgotPassword3">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
