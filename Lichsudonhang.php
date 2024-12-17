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
    echo "<p>Vui lòng đăng nhập để xem giỏ hàng!</p>";
    exit;
}

$tenDangNhap = $_SESSION['username'];

// Truy vấn dữ liệu giỏ hàng theo `TenDangNhap`
$sql = "SELECT MaSP, TenSP, HinhAnh, Mau, Size, SoLuong, Gia, TrangThai FROM donhang2 WHERE TenDangNhap = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tenDangNhap);
$stmt->execute();
$result = $stmt->get_result();

// Tạo mảng để lưu thông tin sản phẩm trong giỏ hàng
$gioHang = [];
while ($row = $result->fetch_assoc()) {
    $gioHang[] = $row;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="lichsudonhang.css">
</head>
<body>
<!-- Hiển thị thanh header -->
<header>
			<a href="trangchu.php">
				<img src="img/logo2.png" alt="Sowh Fashion Logo">
			</a>

			<?php if (isset($_SESSION['username'])): ?>
				<!-- Hiển thị tên đăng nhập nếu đã đăng nhập -->
				<div class="header">
					<section>
						<a href="" class="login" style="top: 35px; left: 1300px;" ><b><?php echo htmlspecialchars($_SESSION['username']); ?></b></a>
						<a href="logout.php" class="login" style="top: 35px; right: 30px;" ><span class="material-icons" 
							style="font-size: 40px; color: #111;" >logout </span></a>
					</section>
					<section>
					<a href="giohang.php" class="login" style="top: 100px; left: 1300px;">
            Giỏ hàng
        </a>
					<a href="giohang.php" class="login" style="top: 100px; right: 30px;" ><span class="material-icons" 
					style="font-size: 40px; color: #111;" >shopping_cart </span></a>

					</section>
				</div>
			<?php else: ?>
				<!-- Hiển thị nút Đăng nhập nếu chưa đăng nhập -->
				<div class="header">
					<a href="login.php" class="login"><span class="material-icons" 
						style="font-size: 40px; color: #111;" >account_circle</span></a><br>
					<a href="login.php" class="login"><b>Đăng nhập</b></a>
				</div>
			<?php endif; ?>
		</header>

		<a href="trangchu.php" class="back-link"> <span class="material-icons" 
		style="font-size: 40px; color: #111;" >narrow_back </span>Quay về trang chủ</a>


		<div class="container">

    <form action="" method="POST">
        <table class="giohang-table">
            <thead>
                <tr style="background-color: rgb(216, 216, 216);">
                    <th>Sản phẩm</th>
                    <th></th>
                    <th></th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Số tiền</th>
					<th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
    <?php if (!empty($gioHang)): ?>
        <?php foreach ($gioHang as $sanPham): ?>
            <?php if (empty($sanPham['TenSP'])) continue; // Bỏ qua nếu TenSP trống ?>
            <tr style="background-color: rgb(245, 245, 245);" data-price="<?php echo $sanPham['Gia']; ?>">
                <?php if (!empty($sanPham['HinhAnh'])): ?>
                    <td><img src="<?php echo htmlspecialchars($sanPham['HinhAnh']); ?>" alt="<?php echo htmlspecialchars($sanPham['TenSP']); ?>"></td>
                <?php endif; ?>
                <?php if (!empty($sanPham['TenSP'])): ?>
                    <td><?php echo htmlspecialchars($sanPham['TenSP']); ?></td>
                <?php endif; ?>
                <?php if (!empty($sanPham['Mau']) || !empty($sanPham['Size'])): ?>
                    <td>Phân loại hàng:<br> 
                        <?php 
                        if (!empty($sanPham['Mau'])) {
                            echo htmlspecialchars($sanPham['Mau']);
                        }
                        if (!empty($sanPham['Mau']) && !empty($sanPham['Size'])) {
                            echo ', ';
                        }
                        if (!empty($sanPham['Size'])) {
                            echo htmlspecialchars($sanPham['Size']);
                        }
                        ?>
                    </td>
                <?php endif; ?>
                <?php if (!empty($sanPham['Gia'])): ?>
                    <td><?php echo number_format($sanPham['Gia'], 0, ',', '.') . ' đ'; ?></td>
                <?php endif; ?>
                <?php if (!empty($sanPham['SoLuong'])): ?>
                    <td><?php echo $sanPham['SoLuong']; ?></td>
                <?php endif; ?>
                <?php if (!empty($sanPham['Gia']) && !empty($sanPham['SoLuong'])): ?>
                    <td class="subtotal"><?php echo number_format($sanPham['Gia'] * $sanPham['SoLuong'], 0, ',', '.') . ' đ'; ?></td>
                <?php endif; ?>
                <td>
                    <?php
                    // Kiểm tra trạng thái của sản phẩm và hiển thị ảnh phù hợp
                    if ($sanPham['TrangThai'] == 'Đã xác nhận') {
                        echo '<img src="img/xacnhan.png" alt="Đã xác nhận" style="width: auto; height: 100px;">';
                    } else {
                        echo '<img src="img/wait.png" alt="Chưa xác nhận" style="width: auto; height: 100px;">';
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>

        </table>
    </form>
</div>
</body>
</html>
