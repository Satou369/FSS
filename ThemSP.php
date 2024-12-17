<?php

session_start(); // Bắt đầu session để kiểm tra đăng nhập

// Kết nối tới cơ sở dữ liệu MySQL
$conn = new mysqli('localhost', 'root', '', 'fss');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    // Kiểm tra các trường
    if (empty($_POST['productname']) || empty($_FILES['photo']['name'][0]) || empty($_POST['quantity'])) {
        $errors[] = "Thêm sản phẩm vào kho hàng không thành công. Vui lòng điền đầy đủ thông tin";
    }

    // Kiểm tra trường số lượng và giá chỉ chứa ký tự số
    if (!empty($_POST['quantity']) && !preg_match('/^\d+$/', $_POST['quantity'])) {
        $errors[] = "Thêm sản phẩm không thành công. Vui lòng nhập số lượng đúng định dạng.";
    }

    if (empty($errors)) {
        $productname = $_POST['productname'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        // Lấy MaSP cuối cùng từ cơ sở dữ liệu
        $result = $conn->query("SELECT MaSP FROM sanpham ORDER BY MaSP DESC LIMIT 1");
        $lastMaSP = "SP00"; // Mặc định nếu chưa có sản phẩm nào
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastMaSP = $row['MaSP'];
        }

        // Tách phần số, tăng giá trị và định dạng lại MaSP
        $lastNumber = (int) substr($lastMaSP, 2); // Lấy 2 số cuối
        $newNumber = $lastNumber + 1;
        $newMaSP = "SP" . str_pad($newNumber, 2, "0", STR_PAD_LEFT);

        // Kiểm tra và tạo thư mục uploads nếu chưa tồn tại
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Xử lý hình ảnh
        $photos = [];
        foreach ($_FILES['photo']['name'] as $key => $name) {
            $tmp_name = $_FILES['photo']['tmp_name'][$key];
            $photo_path = "uploads/" . basename($name);
            if (!move_uploaded_file($tmp_name, $photo_path)) {
                $errors[] = "Không thể di chuyển tệp ảnh: $name";
            } else {
                $photos[] = $photo_path;
            }
        }
        $photo_str = implode(",", $photos);

        // Xử lý video
        $video_path = "";
        if (!empty($_FILES['video']['name'])) {
            $tmp_name = $_FILES['video']['tmp_name'];
            $video_path = "uploads/" . basename($_FILES['video']['name']);
            if (!move_uploaded_file($tmp_name, $video_path)) {
                $errors[] = "Không thể di chuyển tệp video.";
            }
        }

        
        // Câu lệnh SQL để chèn dữ liệu
        $sql = "INSERT INTO sanpham (MaSP, TenSP, Anh, Video, SoLuong, img)
                VALUES ('$newMaSP', '$productname', '$photo_str', '$video_path', '$quantity', '$photo_str')";

        if ($conn->query($sql) === TRUE) {
            $success = "Sản phẩm đã được thêm thành công!";
        } else {
            $errors[] = "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm sản phẩm</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="ThemSP.css">
</head>
<header>
			<a href="trangchunhanvien.php">
				<img src="img/logo2.png" alt="Sowh Fashion Logo">
			</a>

			<?php if (isset($_SESSION['username'])): ?>
				<!-- Hiển thị tên đăng nhập nếu đã đăng nhập -->
				<div class="header">
					<section>
						<a href="" class="login" style="top: 35px; left: 1300px;" ><b><?php echo htmlspecialchars($_SESSION['username']); ?></b></a>
						<a href="logout.php" class="login" style="top: 35px; right: 30px;" ><span class="material-icons" 
							style="font-size: 40px; color: #111;" >logout </span></a>
					</section>
					<section>
						<a href="" class="login" style="top: 100px; left: 1300px;">Khác</a>
						<li class="dropdown">
							<a href="" class="login" ><span class="material-icons" style="font-size: 40px; color: #111;">menu</span> </a>
							<div class="dropdown-content">
								<a href="qlkhohang.php">Quản lý kho hàng</a>
								<a href="lsdonhang.php">Xem đơn hàng</a>
								<a href="baocaodoanhthu.php">Doanh thu</a>
							</div>
						</li>
					</section>
				</div>
			<?php else: ?>
				<!-- Hiển thị nút Đăng nhập nếu chưa đăng nhập -->
				<div class="header">
					<a href="login.php" class="login"><span class="material-icons" 
						style="font-size: 40px; color: #111;" >account_circle</span></a><br>
					<a href="login.php" class="login"><b>Đăng nhập</b></a>
				</div>
			<?php endif; ?>
		</header>
    <div class="title">
        <div class="arrow"><a href="qlkhohang.php"><img src="img/arrow.jpg" alt="Back"></a></div>
        <div class="add"><b>Thêm sản phẩm</b></div>
    </div>
    <div class="AddProductForm">
        <div>
            <form id="AddProductForm" method="POST" enctype="multipart/form-data">
                <div class="Nameproduct">
                    <div><b>Tên sản phẩm: </b></div>
                    <div class="input_nameproduct"><input type="text" id="productname" name="productname" placeholder="Thêm tên sản phẩm vào đây!" value=""></div>
                </div>
                <div class="left">
                    <div class="UpPhotoLabel">Thêm ít nhất 1 hình ảnh/video về sản phẩm</div>
                    <div class="Up">
                        <div>
                            <input type="file" id="photo" name="photo[]" accept="image/*" multiple style="display:none" onchange="previewFiles(event, 'image')">
                            <button type="button" class="photo" onclick="document.getElementById('photo').click();"><img src="img/camera.jpg" alt="Upload Photo"></button>
                        </div>
                        <div>
                            <input type="file" id="video" name="video" accept="video/*" style="display:none" onchange="previewFiles(event, 'video')">
                            <button type="button" class="video" onclick="document.getElementById('video').click();"><img src="img/camcorder.jpg" alt="Upload Video"></button>
                        </div>
                    </div>
                    <div id="image-preview" style="margin-top: 5px;"></div> <!-- Div để hiển thị ảnh -->
                    <div id="video-preview" style="margin-top: 5px;"></div> <!-- Div để hiển thị video -->
                    
                    <div class="UpQuantity">
                        <div>Số lượng: </div>
                        <div class="input_quantity"><input type="text" id="quantity" name="quantity" placeholder="nhập số lượng vào đây!" value=""></div>
                    </div>
                    
                </div>
                <div class="right">
                    <div class="AddProduct-error">
                        <?php if (!empty($errors)): ?>
                        <p><?php echo implode('<br>', $errors); ?></p>
                        <?php elseif (!empty($success)): ?>
                        <p><?php echo $success; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="AddButton">
                        <button type="submit" name="addproduct">Thêm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewFiles(event, type) {
            var files = event.target.files;
            var preview = type === 'image' ? document.getElementById('image-preview') : document.getElementById('video-preview');

            if (type === 'video') {
                preview.innerHTML = ''; // Xóa video cũ nếu có
            }

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = (function(file) {
                    return function(e) {
                        var container = document.createElement('div');
                        container.classList.add('preview-container');

                        if (type === 'image') {
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            img.width = 100;
                            img.height = 100;
                            container.appendChild(img);
                        } else if (type === 'video') {
                            var video = document.createElement('video');
                            video.src = e.target.result;
                            video.width = 200;
                            video.controls = true;
                            container.appendChild(video);
                        }

                        var removeButton = document.createElement('button');
                        removeButton.classList.add('remove-button');
                        removeButton.innerHTML = 'X';
                        removeButton.onclick = function() {
                            container.remove();
                            if (type === 'image' && document.getElementById('photo').files.length === 1) {
                                document.getElementById('photo').value = '';
                            } else if (type === 'video') {
                                document.getElementById('video').value = '';
                            }
                        };

                        container.appendChild(removeButton);
                        preview.appendChild(container);
                    };
                })(files[i]);

                reader.readAsDataURL(files[i]);
            }
        }
    </script>
</body>
</html>
