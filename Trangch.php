<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> 
    <link rel="stylesheet" href="Strangch.css">
</head>
<body>
    <div class="menu">
        <div class="profile">
            <i class="fa fa-user" aria-hidden="true"></i>
            <h2>Quản trị viên</h2>
        </div>
        <br>
        <div class="dt1"></div>
        <ul class="menu">
            <li><a href="trangchuQTV.php" ><i class="fa fa-home" aria-hidden="true"></i>  Trang chủ</a></li>
            <li><a href="trangch.php"><i class="fa fa-plus" aria-hidden="true"></i> QL. Nhân viên</a></li>
            <li><a href="trangchunhanvien.php"><i class="fa fa-plus" aria-hidden="true"></i> QL. Sản phẩm</a></li>
        </ul>
        <div class="logout">
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Thoát</a>
        </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Quản lý nhân viên</h1>
            <button class="Btn1" id="updateBtn">Cập nhật</button>
            <button class="Btn2" id="addBtn"> Thêm</button>
        </div>
        <div class="employee-list">
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "fss";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                $sql = "SELECT MaNV, TenNV, GT, CCCD, Namsinh, SDT, Email FROM nhanvien";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $MaNV = $row['MaNV'];
                        $name = $row['TenNV'];
                        $GT = $row['GT'];
                        $CCCD = $row['CCCD'];
                        $Namsinh = $row['Namsinh'];
                        $SDT = $row['SDT'];
                        $email = $row['Email'];
            ?>
            <div class="employee" data-manv="<?php echo $MaNV; ?>"> <!-- Add data-manv attribute -->
                <div class="icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                <div class="info">
                    <p>Tên nhân viên: <input type="text" class="name" value="<?php echo $name; ?>" disabled></p>
                    <p>Giới tính: <input type="text" class="gt" value="<?php echo $GT; ?>" disabled></p>
                    <p>Căn cước công dân: <input type="text" class="CCCD" value="<?php echo $CCCD; ?>" disabled></p>
                    <p>Năm sinh: <input type="text" class="Namsinh" value="<?php echo $Namsinh; ?>" disabled></p>
                    <p>Số điện thoại: <input type="text" class="SDT" value="<?php echo $SDT; ?>" disabled></p>
                    <p>Email: <input type="text" class="email" value="<?php echo $email; ?>" disabled></p>
                </div>
                <div class="edit">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </div>
            <?php
                    }
                }
                $conn->close();
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#updateBtn').click(function() {
				window.open('Capnhatnv.php', '_blank');
			});
			$('#addBtn').click(function() {
				window.open('them.php', '_blank');
			});

			$('.edit i').click(function() {
				var employeeDiv = $(this).closest('.employee');
				var maNV = employeeDiv.data('manv');

				if(confirm('Bạn có chắc chắn muốn xóa nhân viên này?')) {
					$.ajax({
						url: 'deletenv.php',
						method: 'POST',
						data: { MaNV: maNV },
						success: function(response) {
							console.log(response); // In phản hồi từ máy chủ để kiểm tra
							if(response.trim() === 'success') {
								employeeDiv.remove();
								alert('Xóa nhân viên thành công!');
							} else {
								alert('Có lỗi xảy ra. Vui lòng thử lại.');
							}
						},
						error: function() {
							alert('Có lỗi xảy ra. Vui lòng thử lại.');
						}
					});
				}
			});
		});
	</script>
</body>
</html>
