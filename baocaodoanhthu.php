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
$sql = "SELECT * FROM doanhthu";
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
	  <link rel="stylesheet" href="baocaodoanhthu.css">
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
			<label>Báo cáo doanh thu</label>
			<form action="test.php" method="post"> 
				<button type="submit" name="export">Xuất</button> 
			</form>
		</div>
		<div class="thanhngang"></div>
		<table>
			<thead>
				<tr>
					<th>Thời gian</th>
					<th>Doanh thu</th>
					<th>Chi phí</th>
					<th>Lợi nhuận</th>
				</tr>
			</thead>
			<tbody>
				<div>
					<?php
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo'
							<tr>
								<td>'. $row["thoigian"] .'</td>
								<td>'. $row["doanhthu"] .'</td>
								<td>'. $row["chiphi"] .'</td>
								<td>'. $row["loinhuan"] .'</td>
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
