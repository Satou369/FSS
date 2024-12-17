
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

$maDH = $_POST['MaDH'];
    // Cập nhật giá trị trong cơ sở dữ liệu
		$sql = "UPDATE donhang SET TrangThai='Đã xác nhận' WHERE MaDH = '$maDH'";

		if ($conn->query($sql) === TRUE) {
			echo "Cập nhật thành công!";
		} else {
			echo "Lỗi: " . $sql . "<br>" . $conn->error;
		}
	
// Đóng kết nối
$conn->close();
?>
