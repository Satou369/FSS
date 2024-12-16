<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fss";

// Kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MaNV = $conn->real_escape_string($_POST['MaNV']);
    $cccd = $conn->real_escape_string($_POST['cccd']);
    $response = [];

    // Kiểm tra mã nhân viên
    $sql = "SELECT * FROM nhanvien WHERE MaNV='$MaNV'";
    $result = $conn->query($sql);
    $response['MaNV_exists'] = ($result->num_rows > 0);

    // Kiểm tra CCCD
    $sql = "SELECT * FROM nhanvien WHERE CCCD='$cccd'";
    $result = $conn->query($sql);
    $response['cccd_exists'] = ($result->num_rows > 0);

    echo json_encode($response);
}

$conn->close();
?>
