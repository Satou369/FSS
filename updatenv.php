<?php

// Kết nối cơ sở dữ liệu
$servername = "localhost"; // Hoặc địa chỉ server của bạn
$username = "root";        // Tên người dùng
$password = "";            // Mật khẩu (nếu có)
$dbname = "fss";           // Tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý dữ liệu nhận từ AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ POST
    $data = json_decode($_POST['employees'], true);

    foreach ($data as $employee) {
        $MaNV = $conn->real_escape_string($employee['MaNV']);
        $name = $conn->real_escape_string($employee['name']);
        $gender = $conn->real_escape_string($employee['gender']);
        $cccd = $conn->real_escape_string($employee['cccd']);
        $birthYear = $conn->real_escape_string($employee['birthYear']);
        $phone = $conn->real_escape_string($employee['phone']);
        $email = $conn->real_escape_string($employee['email']);
        // Thực hiện cập nhật thông tin nhân viên
        $sql = "UPDATE nhanvien SET ";
		$updates = []; if (!empty($name)) {
			$updates[] = "TenNV='$name'";
		}
		if (!empty($gender)) {
			$updates[] = "GT='$gender'";
		}
		if (!empty($cccd)) {
			$updates[] = "CCCD='$cccd'";
		}
		if (!empty($birthYear)) {
			$updates[] = "NamSinh='$birthYear'";
		}
		if (!empty($phone)) {
			$updates[] = "SDT='$phone'";
		}
		if (!empty($email)) {
			$updates[] = "Email='$email'";
		}
		if (count($updates) > 0) {
			$sql .= implode(", ", $updates);
			$sql .= " WHERE MaNV='$MaNV'";
			if ($conn->query($sql) !== TRUE) {
				echo "Lỗi cập nhật: " . $conn->error;
			}
		}
    }

    echo "Cập nhật thành công!";
}

// Đóng kết nối
$conn->close();
?>
	