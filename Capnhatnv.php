<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="Scapnhat.css">
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
        <div class="dt1"></div>
        <ul class="menu">
            <li><a href="trangchuQTV.php"><i class="fa fa-home" aria-hidden="true"></i>  Trang chủ</a></li>
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
                    <div class="error-message" style="color:red;"></div> 
                </div>
                <div class="edit">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
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
    <script>
        $(document).ready(function() {
            $('#updateBtn').click(function() {
                var updatedData = [];
                var isValid = true;
                var totalErrors = 0;

                $('.employee').each(function() {
                    var manv = $(this).find('.name').data('manv'); // Lấy MaNV từ trường 'data-manv'
                    var name = $(this).find('.name').val().trim();
                    var gender = $(this).find('.gt').val().trim();
                    var cccd = $(this).find('.CCCD').val().trim();
                    var birthYear = $(this).find('.Namsinh').val().trim();
                    var phone = $(this).find('.SDT').val().trim();
                    var email = $(this).find('.email').val().trim();
                    var errorMessage = $(this).find('.error-message');
                    var errorCount = 0;

                    // Kiểm tra các trường thông tin có bị bỏ trống không
                    if (!name || !gender || !cccd || !birthYear || !phone || !email) {
                        errorMessage.text('Vui lòng nhập đầy đủ thông tin');
                        isValid = false;
                        errorCount++;
                    }

                    // Kiểm tra định dạng email
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        errorMessage.text('Vui lòng nhập email đúng định dạng');
                        isValid = false;
                        errorCount++;
                    }

                    // Kiểm tra định dạng số điện thoại và căn cước công dân
                    var phoneAndCccdRegex = /^[0-9]+$/;
                    if (!phoneAndCccdRegex.test(phone) || !phoneAndCccdRegex.test(cccd)) {
                        errorMessage.text('Vui lòng nhập số điện thoại và căn cước công dân đúng định dạng');
                        isValid = false;
                        errorCount++;
                    }

					// Kiểm tra số điện thoại
					if (!phoneAndCccdRegex.test(phone) || phone.length !== 10) {
						errorMessage.text('Số điện thoại phải có 10 số.');
						isValid = false;
						errorCount++;
					}

					// Kiểm tra số căn cước công dân
					if (!phoneAndCccdRegex.test(cccd) || cccd.length !== 12) {
						errorMessage.text('Số căn cước phải có 12 số.');
						isValid = false;
						errorCount++;
					}


                    // Kiểm tra định dạng ngày tháng năm sinh
                    var birthYearRegex = /^(\d{2})-(\d{2})-(\d{4})$/;
                    if (!birthYearRegex.test(birthYear)) {
                        errorMessage.text('Vui lòng nhập ngày tháng năm sinh đúng định dạng');
                        isValid = false;
                        errorCount++;
                    } else {
                        var today = new Date();
                        var parts = birthYear.split('-');
                        var birthDateObj = new Date(parts[2], parts[1] - 1, parts[0]); // yyyy, mm (0-based), dd
                        if (birthDateObj > today) {
                            errorMessage.text('Kiểm tra lại ngày sinh');
                            isValid = false;
                            errorCount++;
                        }
                    }

                    // Kiểm tra tổng số lỗi
                    if (errorCount >= 2) {
                        errorMessage.text('Cập nhật nhân viên không thành công. Vui lòng nhập đúng dữ liệu');
                        isValid = false;
                        totalErrors++;
                        return; // Dừng kiểm tra nhân viên này và tiếp tục với nhân viên khác
                    }

                    if (errorCount === 0) {
                        errorMessage.text('');
                    }

                    updatedData.push({
                        MaNV: manv,
                        name: name,
                        gender: gender,
                        cccd: cccd,
                        birthYear: birthYear,
                        phone: phone,
                        email: email
                    });
                });

                if (!isValid) {
                    return false;
                }

                $.ajax({
                    url: 'updatenv.php',
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
