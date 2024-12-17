<!DOCTYPE html>
<html>
<head>
    <title>Sign up</title> 
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img src="bg.png" width="100%" height="60%">
    <div class="SignupForm">
        <div class="arrow"><a href="login.php">
            <img src="img/arrow.jpg">
        </a></div>
        <div class="Signup">Đăng ký</div>
        <div>
            <form id="SignupForm" method="POST" novalidate>
                <div class="signupElement"><input type="text" id="username" name="username" placeholder="Tên đăng nhập"
                                            value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"></div>
                <div class="signupElement"><input type="password" id="password" name="password" placeholder="Mật khẩu"
                                            value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>"></div>
                <div class="signupElement"><input type="tel" id="phone" name="phone" placeholder="Số điện thoại"
                                            value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>"></div>
                <div class="signupElement"><input type="email" id="email" name="email" placeholder="Email"
                                            value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"></div>
                <div id="form-error"><?php 
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
                        $username = ($_POST['username']);
                            $password =($_POST['password']);
                            $phone = ($_POST['phone']);
                            $email = ($_POST['email']);
                        $conn = new mysqli('localhost', 'root', '', 'fss');
                        if ($conn->connect_error) {
                            die("Kết nối thất bại: " . $conn->connect_error);
                        }
                    
                        // Kiểm tra các trường có được điền đầy đủ không
                        if (empty($username) || empty($password) || empty($phone) || empty($email)) {
                            echo 'Đăng ký không thành công.<br>Vui lòng điền đầy đủ thông tin';
                        } else {
                            // Kiểm tra tên đăng nhập có tồn tại không
                            $caulenh = "SELECT * FROM account WHERE username='$username'";
                            $kq = mysqli_query($conn, $caulenh);
                            $dong = mysqli_fetch_array($kq);

                            if ($dong) {
                                echo 'Đăng ký không thành công.<br>Tên đăng nhập đã tồn tại.';
                            } else if (!preg_match('/^[0-9]{10}$/', $phone)) { // ktra số điện thoại đúng định dạng không
                                echo 'Đăng ký không thành công.<br>Vui lòng nhập số điện thoại đúng định dạng.';
                            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //ktra email
                                echo 'Đăng ký không thành công.<br>Vui lòng nhập email đúng định dạng.'; 
                            } else {
                                // Đăng ký thành công, thêm tài khoản vào csdl
                                $caulenh = "INSERT INTO account (username, password, phone, email) VALUES ('$username', '$password', '$phone', '$email')";
                                if (mysqli_query($conn, $caulenh)) {
                                    header("Location: login.php");
                                    exit;
                                } else {
                                    echo 'Có lỗi xảy ra, vui lòng thử lại.';
                                }
                            }
                        }
                    $conn->close();
                    }
                ?>
                </div>
                <div class="signupButton"><button type="submit" id="signup" name="signup">Đăng ký</button></div>
            </form>
        </div>
    </div>
</body>
</html>