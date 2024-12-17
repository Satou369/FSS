<?php
session_start(); // Bắt đầu session

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $conn = new mysqli('localhost', 'root', '', 'fss');
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error); // Kiểm tra kết nối
    }

    // Kiểm tra dữ liệu đầu vào
    if (empty($username) || empty($password)) {
        $loginError = 'Đăng nhập không thành công.<br>Vui lòng nhập đầy đủ thông tin.';
    } else {
        // Sử dụng Prepared Statement để tránh SQL Injection
        $stmt = $conn->prepare("SELECT * FROM account WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // So sánh mật khẩu người dùng nhập vào với mật khẩu trong cơ sở dữ liệu
            if ($password === $user['password']) {
                // Đăng nhập thành công, lưu thông tin vào session
                $_SESSION['username'] = $username;
                $_SESSION['loai'] = $user['loai']; // Lưu loại người dùng (nhân viên hoặc qtv)

                // Chuyển hướng dựa trên loại người dùng
                if ($user['loai'] == 'nv') {
                    header('Location: trangchunhanvien.php');
                } elseif ($user['loai'] == 'qtv') {
                    header('Location: trangchuQTV.php');
                } else {
                    header('Location: trangchu.php');
                }
                exit;
            } else {
                $loginError = 'Đăng nhập không thành công.<br>Mật khẩu không chính xác.';
            }
        } else {
            $loginError = 'Đăng nhập không thành công.<br>Tên đăng nhập không tồn tại.';
        }

        $stmt->close();
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img src="bg.png" width="100%" height="60%">
    <div class="LoginForm">
        <div class="Login">Đăng nhập</div>
        <div>
            <form id="LoginForm" method="POST" novalidate>
                <div class="LoginElement">
                    <input type="text" id="username" name="username" placeholder="Tên đăng nhập" 
                    value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                </div>
                <div class="LoginElement">
                    <input type="password" id="password" name="password" placeholder="Mật khẩu"
                    value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                </div>
                <div class="LoginElement">
                    <a href="ForgotPassword.php">Quên mật khẩu?</a>
                </div>
                <div id="login-error">
                    <?php 
                    if (isset($loginError)) {
                        echo $loginError;
                    }
                    ?>
                </div>
                <div class="LoginButton">
                    <button type="submit" id="login" name="login">Đăng nhập</button>
                </div>
                <div class="LinkSignup">
                    Bạn chưa có tài khoản? <a href="signup.php">Đăng ký ngay</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
