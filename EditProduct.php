<?php

session_start(); // Bắt đầu session để kiểm tra đăng nhập
if (isset($_GET['selectedProduct'])) {
    $maSP = $_GET['selectedProduct'];

    // Kết nối tới cơ sở dữ liệu MySQL
    $conn = new mysqli('localhost', 'root', '', 'fss2');

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

// Truy vấn để lấy các ảnh từ bảng hinh
$lay_hinh = "SELECT Hinh FROM hinh WHERE MaSP = '$maSP'";
$result = $conn->query($lay_hinh);
$list_anh = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $list_anh[] = $row['Hinh'];
    }
}
    $product = [];

    // Lấy thông tin sản phẩm từ database
    if ($maSP) {
        $sql = "SELECT * FROM sanpham WHERE MaSP = '$maSP'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {
            die("Sản phẩm không tồn tại.");
        }
    }

    // Xử lý khi người dùng bấm nút cập nhật
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = [];

        // Kiểm tra các trường bắt buộc
        if (empty($_POST['productname']) || empty($_FILES['photo']['name'][0]) || empty($_POST['price']) || empty($_POST['quantity'])) {
            $errors[] = "Vui lòng điền đầy đủ thông tin ở các ô: Tên sản phẩm, Hình ảnh, Số lượng, Giá.";
        }

        // Kiểm tra số lượng và giá
        if (!empty($_POST['quantity']) && !preg_match('/^\d+$/', $_POST['quantity'])) {
            $errors[] = "Vui lòng nhập số lượng đúng định dạng.";
        }
        if (!empty($_POST['price']) && !preg_match('/^\d+$/', $_POST['price'])) {
            $errors[] = "Vui lòng nhập giá cả đúng định dạng.";
        }

        if (empty($errors)) {
            $productname = $_POST['productname'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $description = $_POST['description'];

            // Xử lý ảnh
            $photos = [];
            if (!empty($_FILES['photo']['name'][0])) {
                // Upload ảnh mới
                foreach ($_FILES['photo']['name'] as $key => $name) {
                    $tmp_name = $_FILES['photo']['tmp_name'][$key];
                    $photo_path = "uploads/" . basename($name);

                    if (move_uploaded_file($tmp_name, $photo_path)) {
                        $photos[] = $photo_path; // Chỉ lưu ảnh mới vào mảng
                    } else {
                        $errors[] = "Không thể di chuyển tệp ảnh: $name";
                    }
                }
            }

            // Ghép mảng ảnh mới để lưu vào database
            $photo_str = implode(",", $photos); // Lưu tất cả ảnh mới vào cột Anh
            $first_image = $photos[0] ?? ''; // Ảnh đầu tiên cho cột img

            // Xử lý video
            $video_path = $product['Video'] ?? '';
            if (!empty($_FILES['video']['name'])) {
                $tmp_name = $_FILES['video']['tmp_name'];
                $video_path = "uploads/" . basename($_FILES['video']['name']);
                if (!move_uploaded_file($tmp_name, $video_path)) {
                    $errors[] = "Không thể di chuyển tệp video.";
                }
            }

            // Xử lý màu sắc
            $colors = [];
            if (!empty($_POST['colors'])) {
                $colors = $_POST['colors'];
            }
            $color_str = implode(",", $colors);

            if (empty($errors)) {
                // Cập nhật dữ liệu mới
                $sql = "UPDATE sanpham SET 
                    TenSP = '$productname', 
                    Anh = '$photo_str', 
                    img = '$first_image', 
                    Video = '$video_path', 
                    MauSac = '$color_str', 
                    SoLuong = '$quantity', 
                    Gia = '$price', 
                    MoTa = '$description'
                WHERE MaSP = '$maSP'";

                if ($conn->query($sql) === TRUE) {
                    header('Location: trangchunhanvien.php');
                    exit;
                } else {
                    $errors[] = "Lỗi: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>  
<head>
    <title>Sửa sản phẩm</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
        <div class="arrow"><a href="trangchunhanvien.php"><img src="img/arrow.jpg" alt="Back"></a></div>
        <div class="add"><b>Sửa sản phẩm</b></div>
    </div>
    <div class="AddProductForm">
        <div>
            <form id="AddProductForm" method="POST" enctype="multipart/form-data" onsubmit="return confirmSave()">
                <div class="Nameproduct">
                    <div><b>Tên sản phẩm: </b></div>
                    <div class="input_nameproduct"><input type="text" id="productname" name="productname" placeholder="Thêm tên sản phẩm vào đây!" value="<?php echo htmlspecialchars($product['TenSP'] ?? '', ENT_QUOTES); ?>"></div>
                </div>
                <div class="left">
                    <div class="UpPhotoLabel">Thêm ít nhất 1 hình ảnh về sản phẩm</div>
                    <div class="Up">
                        <div>
                            <input type="file" id="photo" name="photo[]" accept="image/*" multiple style="display:none" onchange="previewFiles(event, 'image')">
                            <button type="button" class="photo" onclick="document.getElementById('photo').click();"><img src="camera.jpg" alt="Upload Photo"></button>
                        </div>
                        <div>
                            <input type="file" id="video" name="video" accept="video/*" style="display:none" onchange="previewFiles(event, 'video')">
                            <button type="button" class="video" onclick="document.getElementById('video').click();"><img src="camcorder.jpg" alt="Upload Video"></button>
                        </div>
                    </div>
                    <div id="image-preview" style="margin-top: 5px;">
                        <?php if (!empty($list_anh)): ?>
                            <?php foreach ($list_anh as $photo): ?>
                                <div class="preview-container">
                                    <img src="<?php echo $photo; ?>" width="100" height="100">
                                    <button type="button" class="remove-button" onclick="this.parentElement.remove();">X</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div id="video-preview" style="margin-top: 5px;">
                        <?php if (!empty($product['Video'])): ?>
                            <div class="preview-container">
                                <video src="<?php echo $product['Video']; ?>" width="200" controls></video>
                                <button type="button" class="remove-button" onclick="this.parentElement.remove();">X</button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="UpColor">
                        <div class="LabelColor">Màu sắc: </div>
                        <div><button type="button" class="plus" onclick="addColorInput()">+</button></div>
                    </div>
                    <div id="color-inputs">
                        <?php if (!empty($product['MauSac'])): ?>
                            <?php foreach (explode(',', $product['MauSac']) as $color): ?>
                                <div class="color-box">
                                <?php echo htmlspecialchars($color, ENT_QUOTES); ?>
                                    <button type="button" class="remove-button" onclick="this.parentElement.remove();">X</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="UpQuantity">
                        <div>Số lượng: </div>
                        <div class="input_quantity"><input type="text" id="quantity" name="quantity" placeholder="nhập số lượng vào đây!" value="<?php echo htmlspecialchars($product['SoLuong'] ?? '', ENT_QUOTES); ?>"></div>
                    </div>
                    <div class="UpPrice">
                        <div>Giá: </div>
                        <div class="input_price"><input type="text" id="price" name="price" placeholder="nhập giá cả vào đây!" value="<?php echo htmlspecialchars($product['Gia'] ?? '', ENT_QUOTES); ?>"></div>
                    </div>
                </div>
                <div class="right">
                    <div class="UpDescription">
                        <div>Mô tả: </div>
                        <div class="input_description"><textarea id="description" name="description" placeholder="viết mô tả sản phẩm vào đây!"><?php echo htmlspecialchars($product['MoTa'] ?? '', ENT_QUOTES); ?></textarea></div>
                    </div>
                    <div class="AddProduct-error">
                        <?php if (!empty($errors)): ?>
                        <p><?php echo implode('<br>', $errors); ?></p>
                        <?php elseif (!empty($success)): ?>
                        <p><?php echo $success; ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <input type="hidden" name="deleted_photos" id="deleted_photos" value="">
                    <div class="AddButton">
                        <button type="submit" name="addproduct">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
function previewFiles(event, type) {
    var files = event.target.files;
    var previewContainer = type === 'image' ? document.getElementById('image-preview') : document.getElementById('video-preview');
    
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = function(e) {
            var previewElement = document.createElement('div');
            previewElement.classList.add('preview-container');

            if (type === 'image') {
                previewElement.innerHTML = `
                    <img src="${e.target.result}" width="100" height="100">
                    <button type="button" class="remove-button" onclick="this.parentElement.remove();">X</button>
                `;
            } else if (type === 'video') {
                previewElement.innerHTML = `
                    <video src="${e.target.result}" width="200" controls></video>
                    <button type="button" class="remove-button" onclick="this.parentElement.remove();">X</button>
                `;
            }

            previewContainer.appendChild(previewElement);
        };

        reader.readAsDataURL(file);
    }
}

function addColorInput() {
    var colorInputsContainer = document.getElementById('color-inputs');
    var colorInput = document.createElement('div');
    colorInput.classList.add('color-box');
    colorInput.innerHTML = `
        <input type="text" name="colors[]" placeholder="Nhập màu sắc">
        <button type="button" class="remove-button" onclick="this.parentElement.remove();">X</button>
    `;
    colorInputsContainer.appendChild(colorInput);
}
        function addColorBox(color) {
            var colorInputs = document.getElementById('color-inputs');
            var container = document.createElement('div');
            container.classList.add('color-box');
            container.innerHTML = color;

            var removeButton = document.createElement('button');
            removeButton.classList.add('remove-button');
            removeButton.innerHTML = 'X';
            removeButton.onclick = function() {
                container.remove();
            };

            container.appendChild(removeButton);
            colorInputs.appendChild(container);
        }
    function confirmSave() {
        return confirm("Bạn có chắc chắn muốn sửa thông tin ở sản phẩm này?");
        }
</script>
</body>
</html>
