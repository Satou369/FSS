<?php
$servername = "localhost"; // Địa chỉ máy chủ
$username = "root"; // Tên người dùng
$password = ""; // Mật khẩu
$dbname = "fss"; // Tên cơ sở dữ liệu của bạn

// Kết nối với cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); // Đảm bảo kết nối sử dụng UTF-8

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Kiểm tra nếu nút 'export' được nhấn
if (isset($_POST['export'])) {
    header('Content-Type: application/vnd.ms-excel; charset=utf-8'); 
	header('Content-Disposition: attachment;filename="data_export.xls"'); 
	header('Cache-Control: max-age=0');

	echo "\xEF\xBB\xBF"; // Thêm BOM để Excel nhận dạng UTF-8
	
    // Lấy dữ liệu từ cơ sở dữ liệu
    $sql = "SELECT * FROM doanhthu";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Tạo tiêu đề cột
        echo "Thời gian,Doanh thu,Chi phí,Lợi nhuận\n"; // Thay đổi tiêu đề cột theo bảng của bạn

        // Xuất dữ liệu
        while ($row = $result->fetch_assoc()) {
            echo $row['thoigian'] . "," . $row['doanhthu'] . "," . $row['chiphi'] . "," . $row['loinhuan'] . "\n"; // Thay đổi theo tên cột của bạn
        }
    } else {
        echo "Không có dữ liệu";
    }
    exit();
}
?>
