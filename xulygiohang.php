<?php
session_start(); // Bắt đầu session để kiểm tra đăng nhập

// Kết nối tới cơ sở dữ liệu
$servername = "localhost"; // Thay bằng tên máy chủ MySQL của bạn
$username = "root"; // Thay bằng tên tài khoản MySQL của bạn
$password = ""; // Thay bằng mật khẩu MySQL của bạn
$database = "fss"; // Thay bằng tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu đã đăng nhập
if (!isset($_SESSION['username'])) {
    echo "<p>Vui lòng đăng nhập để tiếp tục.</p>";
    exit;
}

$tenDangNhap = $_SESSION['username'];

// Kiểm tra và giải mã dữ liệu sản phẩm đã chọn
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_products'])) {
    $selectedProducts = json_decode($_POST['selected_products'], true);

    if (!empty($selectedProducts)) {
        // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng xuly
        $sql = "INSERT INTO xuly (TenDangNhap, TenSP, HinhAnh, Mau, Size, SoLuong, Gia, TrangThai, NgayTao) VALUES (?, ?, ?, ?, ?, ?, ?, 'Chưa xác nhận', NOW())";
        $stmt = $conn->prepare($sql);

        foreach ($selectedProducts as $product) {
            $stmt->bind_param("ssssssi", $tenDangNhap, $product['TenSP'], $product['HinhAnh'], $product['Mau'], $product['Size'], $product['SoLuong'], $product['Gia']);
            $stmt->execute();
        }

        echo "<script>window.location.href = 'thanhtoan.php';</script>";
} else {
    echo "<script>alert('Không có sản phẩm nào được chọn!');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
