<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="Sthem.css">
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
            <li><a href="trangchuQTV.php"><i class="fa fa-home" aria-hidden="true"></i>  Trang chủ</a></li>
            <li><a href="trangch.php"><i class="fa fa-plus" id="clearBtn" aria-hidden="true"></i> QL. Nhân viên</a></li>
            <li><a href="trangchunhanvien.php"><i class="fa fa-plus" id="clearBtn" aria-hidden="true"></i> QL. Sản phẩm</a></li>
        </ul>
        <div class="logout">
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Thoát</a>
        </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Quản lý nhân viên</h1>
            <button class="Btn" id="addBtn">Thêm</button>
        </div>
        <div class="employee-list">
            <div class="employee">
                <div class="icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                <div class="info">
                    <p>Tạo tài khoản: <input type="text" class="MaNV" placeholder="..."></p>
					<p>Tạo mật khẩu: <input type="text" class="MatKhau" placeholder="..."></p>
					<p>Tên nhân viên: <input type="text" class="name" placeholder="..."></p>
                    <p>Giới tính: <input type="text" class="gt" placeholder="..."></p>
                    <p>Căn cước công dân: <input type="text" class="CCCD" placeholder="..."></p>
                    <p>Năm sinh: <input type="text" class="Namsinh" placeholder="..."></p>
                    <p>Số điện thoại: <input type="text" class="SDT" placeholder="..."></p>
                    <p>Email: <input type="text" class="email" placeholder="..."></p>
                </div>
                <div class="edit">
                    <i class="fa fa-plus" id="xoa" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#addBtn').click(function() {
			var MaNV = $('.MaNV').val().trim();
			var MatKhau = $('.MatKhau').val().trim();
			var name = $('.name').val().trim();
			var gender = $('.gt').val().trim();
			var cccd = $('.CCCD').val().trim();
			var birthDate = $('.Namsinh').val().trim();
			var phone = $('.SDT').val().trim();
			var email = $('.email').val().trim();
			var errors = [];

			// Kiểm tra không để trống các trường bắt buộc
			if (!MaNV || !MatKhau || !name || !gender || !cccd || !birthDate || !phone || !email) {
				errors.push("Tạo tài khoản nhân viên không thành công. Vui lòng nhập đầy đủ thông tin.");
			}

			// Kiểm tra định dạng email
			var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!emailPattern.test(email)) {
				errors.push("Tạo tài khoản nhân viên không thành công. Vui lòng nhập email đúng định dạng.");
			}

			// Kiểm tra định dạng số điện thoại và căn cước công dân (chỉ chứa ký tự số)
			var numberPattern = /^[0-9]+$/;
			if (!numberPattern.test(phone)) {
				errors.push("Tạo tài khoản nhân viên không thành công. Vui lòng nhập số điện thoại đúng định dạng.");
			}
			if (!numberPattern.test(cccd)) {
				errors.push("Tạo tài khoản nhân viên không thành công. Vui lòng nhập căn cước công dân đúng định dạng.");
			}
			
			// Kiểm tra định dạng số điện thoại và căn cước công dân (chỉ chứa ký tự số)

			// Kiểm tra số điện thoại
			if (!numberPattern.test(phone) || phone.length !== 10) {
				errors.push("Tạo tài khoản nhân viên không thành công. Số điện thoại phải có 10 số.");
			}

			// Kiểm tra số căn cước công dân
			if (!numberPattern.test(cccd) || cccd.length !== 12) {
				errors.push("Tạo tài khoản nhân viên không thành công. Số căn cước phải có 12 số.");
			}


			// Kiểm tra định dạng ngày tháng năm sinh (chỉ chứa ký tự số)
			var datePattern = /^(\d{2})-(\d{2})-(\d{4})$/;
			if (!datePattern.test(birthDate)) {
				errors.push("Tạo tài khoản nhân viên không thành công. Vui lòng nhập ngày tháng năm sinh đúng định dạng (dd-mm-yyyy).");
			} else {
				var today = new Date();
				var parts = birthDate.split('-');
				var birthDateObj = new Date(parts[2], parts[1] - 1, parts[0]); // yyyy, mm (0-based), dd
				if (birthDateObj > today) {
					errors.push("Kiểm tra lại ngày sinh");
				}
			}

			// Kiểm tra độ dài mật khẩu
			if (MatKhau.length < 6) {
				errors.push("Tạo tài khoản nhân viên không thành công. Mật khẩu có ít hơn 6 kí tự.");
			}

			// Kiểm tra nếu tên tài khoản, CCCD hoặc số điện thoại đã tồn tại (giả sử kiểm tra qua AJAX)
			$.ajax({
				url: 'check.php',
				method: 'POST',
				async: false,
				data: {
					MaNV: MaNV,
					cccd: cccd,
				},
				success: function(response) {
					response = JSON.parse(response);
					if (response.MaNV_exists) {
						errors.push("Tạo tài khoản nhân viên không thành công. Tên tài khoản đã tồn tại trong hệ thống.");
					}
					if (response.cccd_exists) {
						errors.push("Tạo tài khoản nhân viên không thành công. CCCD đã tồn tại trong hệ thống.");
					}
				}
			});

			// Hiển thị lỗi nếu có
			if (errors.length > 0) {
				alert(errors.join("\n"));
			} else {
				// Gửi dữ liệu đến máy chủ nếu không có lỗi
				$.ajax({
					url: 'addnv.php',
					method: 'POST',
					data: {
						MaNV: MaNV,
						MatKhau: MatKhau,
						name: name,
						gender: gender,
						cccd: cccd,
						birthDate: birthDate,
						phone: phone,
						email: email
					},
					success: function(response) {
						alert('Thêm nhân viên thành công!');
					},
					error: function() {
						alert('Có lỗi xảy ra. Vui lòng thử lại.');
					}
				});
			}
		});

		// Nút xóa nội dung
		$('#xoa').click(function() {
			$('.MaNV').val('');
			$('.MatKhau').val('');
			$('.name').val('');
			$('.gt').val('');
			$('.CCCD').val('');
			$('.Namsinh').val('');
			$('.SDT').val('');
			$('.email').val('');
		});
	});
	</script>
</body>
</html>

