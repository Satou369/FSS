<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="Styles.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> 
</head>
<body>
    <div class="menu">
        <div class="profile">
            <i class="fa fa-user" aria-hidden="true"></i>
            <h2>Quản trị viên</h2>
        </div>
        <br>
        <div class ="dt1"></div>
        <ul class="menu">
            <li><a href="#"><img src="home.png" alt="Home">  Trang chủ</a></li>
            <li><a href="#"><img src="employee.png" alt="Employee"> QL. Nhân viên</a></li>
            <li><a href="#"><img src="product.png" alt="Product"> QL. Sản phẩm</a></li>
        </ul>
        <div class="logout">
            <a href="#"><img src="logout.png" alt="Logout"> Thoát</a>
        </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Quản lý nhân viên</h1>
            <button class="Btn" id="updateBtn">Cập nhật</button>
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
            <div class="employee">
                <div class="icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                <div class="info">
                    <p>Tên nhân viên: <input type="text" class="name" value="<?php echo $name; ?>" data-manv="<?php echo $MaNV; ?>" disabled></p>
                    <p>Giới tính: <input type="text" class="gt" value="<?php echo $GT; ?>" data-manv="<?php echo $MaNV; ?>" disabled></p>
                    <p>Căn cước công dân: <input type="text" class="CCCD" value="<?php echo $CCCD; ?>" data-manv="<?php echo $MaNV; ?>" disabled></p>
                    <p>Năm sinh: <input type="text" class="Namsinh" value="<?php echo $Namsinh; ?>" data-manv="<?php echo $MaNV; ?>" disabled></p>
                    <p>Số điện thoại: <input type="text" class="SDT" value="<?php echo $SDT; ?>" data-manv="<?php echo $MaNV; ?>" disabled></p>
                    <p>Email: <input type="text" class="email" value="<?php echo $email; ?>" data-manv="<?php echo $MaNV; ?>" disabled></p>
                </div>
                <div class="edit">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </div>
            </div>
            <?php
                    }
					echo '<input type="text" class="name" value="' . htmlspecialchars($name) . '" data-MaNV="' . htmlspecialchars($MaNV) . '">';

                }
                $conn->close();
            ?>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#updateBtn').click(function() {
                var updatedData = [];

                $('.employee .info input').each(function() {
    var manv = $(this).data('manv'); // Lấy MaNV từ trường 'name'

                    var name = $(this).hasClass('name') ? $(this).val() : '';
                    var gender = $(this).hasClass('gt') ? $(this).val() : '';
                    var cccd = $(this).hasClass('CCCD') ? $(this).val() : '';
                    var birthYear = $(this).hasClass('Namsinh') ? $(this).val() : '';
                    var phone = $(this).hasClass('SDT') ? $(this).val() : '';
                    var email = $(this).hasClass('email') ? $(this).val() : '';
                    if (name || gender || cccd || birthYear || phone || email) {
                        updatedData.push({
                            MaNV: manv,
                            name: name,
                            gender: gender,
                            cccd: cccd,
                            birthYear: birthYear,
                            phone: phone,
                            email: email
							
                        });
}
                });

                $.ajax({
                    url: 'update_employee.php',
                    method: 'POST',
                    data: { employees: JSON.stringify(updatedData) },
                    success: function(response) {
                        alert('Cập nhật thành công!');
                    },
                    error: function() {
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                });
            });
        });
    </script>
	<script>
        // Lấy tất cả các phần tử có class 'edit'
		const editButtons = document.querySelectorAll('.edit i');

		// Lặp qua tất cả các phần tử 'edit'
		editButtons.forEach(button => {
			button.addEventListener('click', function() {
				// Tìm phần tử 'info' chứa input của nhân viên đang được chỉnh sửa
				const info = this.closest('.employee').querySelector('.info');

				// Lấy tất cả các input trong phần tử 'info'
				const inputs = info.querySelectorAll('input');

				// Tạo một biến lưu trữ trạng thái
				const areInputsDisabled = inputs[0].disabled;

				// Nếu các input đang bị khóa, mở khóa chúng và ngược lại
				inputs.forEach(input => {
					input.disabled = !areInputsDisabled;
				});
			});
		});
    </script>
</body>
</html>
