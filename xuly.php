<?php
if($_POST["dndk"] == "Đăng nhập"){
//lấy dữ liệu từ form
$tk = $_POST['tk'];
$mk = $_POST['mk'];
//kết nối dữ liệu
$kn = mysqli_connect("localhost","root","","FSS") or die("Không kết nối được!");
//xây dựng câu lệnh truy vấn
$caulenh = "select * from nhanvien where MaNV='".$tk."' and MatKhau='".$mk."'";
//thực hiện câu lệnh
$kq = mysqli_query($kn,$caulenh);
//lấy kết quả trả về
$dong = mysqli_fetch_array($kq);
//xử lý kết quả trả về

if ($dong){


	header('location:trangchunhanvien.php');
}
else{
	echo "Bạn đăng nhập không thành công,<br> tên tài khoản hoặc mật khẩu không đúng";
}

mysqli_close($kn);
}

if($_POST["dndk"] == "Đăng ký"){
$tk = $_POST['tk'];
$mk1 = $_POST['mk1'];
$mk2 = $_POST['mk2'];
$email = $_POST['email'];
if($tk == "" || $mk1 == "" || $mk2 == "" || $email == ""){
	echo("Không được bỏ trống :))");
}else if($mk1!=$mk2){
	echo "Bạn đăng ký không thành công,<br> 2 mật khẩu không giống nhau";
}else{
$kn = mysqli_connect("localhost","root","","laixe") or die("Không kết nối được!");

$caulenh = "select * from taikhoan where tk='".$tk."'";
$kq = mysqli_query($kn,$caulenh);
$dong = mysqli_fetch_array($kq);
if ($dong){
	echo "Đăng ký không thành công<br>";
	echo "Tên người dùng đã tồn tại.";
	
}
else{
$caulenh = "insert into taikhoan (tk,mk,email) values ('$tk','$mk1','$email')";
mysqli_query($kn,$caulenh);
echo "Đăng ký thành công.";
}

mysqli_close($kn);
}

}
if($_POST["dndk"] == "Lấy mật khẩu"){
$tk = $_POST['tk'];
$email = $_POST['email'];
$kn = mysqli_connect("localhost","root","","laixe") or die("Không kết nối được!");
//xây dựng câu lệnh truy vấn
$caulenh = "select * from taikhoan where tk='".$tk."'";
//thực hiện câu lệnh
$kq = mysqli_query($kn,$caulenh);
//lấy kết quả trả về
$dong = mysqli_fetch_array($kq);
if ($dong){
	if($email == $dong['email']){
		echo("Mật khẩu của bạn là: ".$dong['mk']);
	}else{
		echo("Email của bạn không chính xác");
	}
}else{
	echo("Tài khoản của bạn không tồn tại.");
}

mysqli_close($kn);
}	
?>
	<?php
    // Khởi tạo phiên mới
    session_start();

    // Giả sử bạn đã kiểm tra thông tin đăng nhập và nó hợp lệ
    // Lưu tên đăng nhập vào phiên
    $_SESSION['username'] = $tk;
?>