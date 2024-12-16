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
    $maNV = $conn->real_escape_string($_POST['MaNV']);
    error_log("Deleting employee with MaNV: " . $maNV);

    $sql = "DELETE FROM nhanvien WHERE MaNV = '$maNV'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }
}

$conn->close();
?>
