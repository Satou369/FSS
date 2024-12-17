<?php
session_start(); // Bắt đầu session để kiểm tra đăng nhập
?>
<?php
$servername = "localhost"; // Địa chỉ máy chủ
$username = "root"; // Tên người dùng
$password = ""; // Mật khẩu
$dbname = "fss"; // Tên cơ sở dữ liệu của bạn

// Kết nối với cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy mã đơn hàng
$MaDH = isset($_GET['id']) ? $_GET['id'] : '';

// Truy vấn sản phẩm với điều kiện lọc và sắp xếp
$sql = "SELECT donhang.*, sanpham.MaSP,sanpham.TenSP, sanpham.PhanLoai, sanpham.img FROM donhang,sanpham WHERE MaDH = '$MaDH' AND donhang.MaSP=sanpham.MaSP";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sowh Fashion</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="chitietDH.css">
</head>
<body>
    <!-- Hiển thị thanh header -->
    <header>
        <a href="trangchunhanvien.php">
            <img src="img/logo2.png" alt="Sowh Fashion Logo">
        </a>

        <?php if (isset($_SESSION['username'])): ?>
            <!-- Hiển thị tên đăng nhập nếu đã đăng nhập -->
            <div class="header">
                <section>
                    <a href="" class="login" style="top: 35px; left: 1300px;"><b><?php echo htmlspecialchars($_SESSION['username']); ?></b></a>
                    <a href="logout.php" class="login" style="top: 35px; right: 30px;"><span class="material-icons" style="font-size: 40px; color: #111;">logout</span></a>
                </section>
                <section>
                    <a href="" class="login" style="top: 100px; left: 1300px;">Khác</a>
                    <li class="dropdown">
                        <a href="" class="login"><span class="material-icons" style="font-size: 40px; color: #111;">menu</span></a>
                        <div class="dropdown-content">
							<a href="qlkhohang.php">Quản lý kho hàng</a>
							<a href="lsdonhang.php">Xem đơn hàng</a>
							<a href="baocaodoanhthu.php">Doanh thu</a>
                        </div>
                    </li>
                </section>
            </div>
        <?php else: ?>
            <!-- Hiển thị nút Đăng nhập nếu chưa đăng nhập -->
            <div class="header">
                <a href="login.php" class="login"><span class="material-icons" style="font-size: 40px; color: #111;">account_circle</span></a><br>
                <a href="login.php" class="login"><b>Đăng nhập</b></a>
            </div>
        <?php endif; ?>
    </header>

    <label>Chi tiết đơn hàng</label>
    <br>
    <label>Mã đơn hàng: <?php echo $MaDH; ?></label>
    <div class="thanhngang"></div>
    <div>
        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Lấy hàng dữ liệu duy nhất
            echo '
                <table>
                    <tr> <td>Tên người mua: </td> <td>'. $row["TaiKhoan"] .'</td></tr>
                    <tr> <td>Tên người nhận: </td> <td>'. $row["TenNguoiNhan"] .'</td></tr>
                    <tr> <td>Số điện thoại: </td> <td>'. $row["SoDienThoai"] .'</td></tr>
                    <tr> <td>Địa chỉ giao hàng: </td> <td>'. $row["DiaChi"] .'</td></tr>
                </table>
                <table>
                    <tr> <td colspan="2">'. $row["TenSP"] .' </td><td rowspan="5"><img src="' . $row["img"] . '" alt="Product ' . $row["MaSP"] . '"></td></tr>
                    <tr> <td>Loại: </td> <td>'. $row["PhanLoai"] .'</td></tr>
                    <tr> <td>Số lượng: </td> <td>'. $row["SoLuong"] .'</td></tr>
                    <tr> <td>Size: </td> <td>'. $row["Co"] .'</td></tr>
                    <tr> <td>Giá trị: </td> <td>'. $row["Gia"] .'</td></tr>
                </table>';
        } else {
            echo "Không có dữ liệu";
        }
        ?>
    </div>
    <br>
    <form method="post" id="orderForm">
        <label style="font-size: 16px; margin: 0 5% 0 10%;">Trạng thái đơn hàng: </label>
        <input style="font-size: 16px; margin: 0 20% 0 2%; color: red;" type="text" name="TT" id="TT" value="<?php echo $row["TrangThai"]; ?>" disabled>
        <button style="margin: 0 20% 0 70%;" type="button" id="confirmButton" onclick="confirmOrder()">Xác nhận</button>
    </form>
    <script>
        function checkValue() {
            var input = document.getElementById('TT').value;
            var button = document.getElementById('confirmButton');
            if (input === "Chưa xác nhận") {
                button.style.display = 'block';
            } else {
                button.style.display = 'none';
            }
        }

        function confirmOrder() {
            var input = document.getElementById('TT');
            var xhr = new XMLHttpRequest();
            var maDH = "<?php echo $MaDH; ?>"; // Lấy giá trị MaDH từ PHP
            xhr.open("POST", "process.php", true);      // Cập nhật giá trị input trên giao diện người dùng
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Trạng thái đã được cập nhật trong cơ sở dữ liệu.");
                }
            };
            xhr.send("TT=" + encodeURIComponent("Đã xác nhận") + "&MaDH=" + encodeURIComponent(maDH));
			location.reload();
        }

        // Kiểm tra giá trị khi trang được tải
        document.addEventListener('DOMContentLoaded', checkValue);
    </script>
</body>
</html>
