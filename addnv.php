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
    $MatKhau = $conn->real_escape_string($_POST['MatKhau']);
    $name = $conn->real_escape_string($_POST['name']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $cccd = $conn->real_escape_string($_POST['cccd']);
    $birthDate = $conn->real_escape_string($_POST['birthDate']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "INSERT INTO nhanvien (MaNV, MatKhau, TenNV, CCCD, GT, NamSinh, SDT, Email)
            VALUES ('$MaNV', '$MatKhau', '$name', '$cccd', '$gender', '$birthDate', '$phone', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm nhân viên thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
