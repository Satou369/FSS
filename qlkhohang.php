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

// Truy vấn sản phẩm với điều kiện lọc và sắp xếp
$sql = "SELECT * FROM SanPham";
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
	  <link rel="stylesheet" href="qlkhohang.css">
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
						<a href="" class="login" style="top: 35px; left: 1300px;" ><b><?php echo htmlspecialchars($_SESSION['username']); ?></b></a>
						<a href="logout.php" class="login" style="top: 35px; right: 30px;" ><span class="material-icons" 
							style="font-size: 40px; color: #111;" >logout </span></a>
					</section>
					<section>
						<a href="" class="login" style="top: 100px; left: 1300px;">Khác</a>
						<li class="dropdown">
							<a href="" class="login" ><span class="material-icons" style="font-size: 40px; color: #111;">menu</span> </a>
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
					<a href="login.php" class="login"><span class="material-icons" 
						style="font-size: 40px; color: #111;" >account_circle</span></a><br>
					<a href="login.php" class="login"><b>Đăng nhập</b></a>
				</div>
			<?php endif; ?>
		</header>

		<div style="padding-top: 20px" >
			<label>Quản lý kho hàng</label>
			<button type="button" onclick="window.location.href='ThemSP.php';">+</button>
		</div>
		<div class="thanhngang"></div>
		<table class= "table">
			<thead>
				<tr>
					<th>Tên sản phẩm</th>
					<th>Hình ảnh</th>
					<th>Mô tả</th>
					<th>Giá bán</th>
					<th>Kích cỡ</th>
					<th>Số sản phẩm đã bán</th>
					<th>Số sản phẩm còn lại</th>
				</tr>
			</thead>
			<tbody>
				<div>
					<?php
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							 $sizes = array();
								if ($row['S'] == 1) $sizes[] = 'S';
								if ($row['L'] == 1) $sizes[] = 'L';
								if ($row['XL'] == 1) $sizes[] = 'XL';
								if ($row['XXL'] == 1) $sizes[] = 'XXL';
								
								$sizeString = implode(', ', $sizes);
							echo'
							<tr>
								<td>'. $row["TenSP"] .'</td>
								<td><img src="' . $row["img"] . '" alt="Product ' . $row["MaSP"] . '"></td>
								<td>'. $row["MoTa"] .'</td>
								<td>'. $row["Gia"] .'</td>
								<td>'. $sizeString .'</td>
								<td>'. $row["SLDaBan"] .'</td>
								<td>'. $row["SLConLai"] .'</td>
							</tr>';
						}
					} else {
						echo "Không có sản phẩm";
					}
					?>
				 </div>
			</tbody>
		</table>
	</body>
</html>
