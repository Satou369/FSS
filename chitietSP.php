<?php
session_start(); // Bắt đầu session để kiểm tra đăng nhập

// Kết nối với cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fss";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy mã sản phẩm từ URL
$productId = isset($_GET['id']) ? $_GET['id'] : '';

// Truy vấn thông tin chi tiết sản phẩm
$sql = "SELECT * FROM SanPham WHERE MaSP = '$productId'";
$result = $conn->query($sql);

// Kiểm tra nếu có sản phẩm
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Sản phẩm không tồn tại";
    exit;
}

// Truy vấn các màu sắc hợp lệ (không phải NULL) cho sản phẩm
$colorSql = "SELECT DISTINCT Mau FROM Hinh WHERE MaSP = '$productId' AND Mau IS NOT NULL";
$colorResult = $conn->query($colorSql);
$colors = [];
while ($color = $colorResult->fetch_assoc()) {
    $colors[] = $color['Mau']; // Lưu tên màu vào mảng
}

// Lấy danh sách hình ảnh của sản phẩm
$imageSql = "SELECT * FROM Hinh WHERE MaSP = '$productId'";
$imageResult = $conn->query($imageSql);
$images = [];
while ($imageRow = $imageResult->fetch_assoc()) {
    $images[] = $imageRow; // Lưu hình ảnh vào mảng
}

// Kiểm tra các kích cỡ có sẵn
$sizes = [];
if ($product['S']) $sizes[] = 'S';
if ($product['L']) $sizes[] = 'L';
if ($product['XL']) $sizes[] = 'XL';
if ($product['XXL']) $sizes[] = 'XXL';

// Lưu vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    // Kiểm tra nếu người dùng đã đăng nhập
    if (isset($_SESSION['username'])) {
        $tenDangNhap = $_SESSION['username']; // Lấy tên đăng nhập từ session
        $tenSP = $_POST['tenSP'];
        $hinhAnh = $_POST['hinhAnh'];
        $mau = isset($_POST['mau']) ? $_POST['mau'] : ''; // Kiểm tra nếu màu sắc không được chọn
        $size = isset($_POST['size']) ? $_POST['size'] : ''; // Kiểm tra nếu size không được chọn
        $soLuong = isset($_POST['soLuong']) ? (int)$_POST['soLuong'] : 1; // Kiểm tra và ép kiểu số lượng
        $gia = $_POST['gia'];

        // Kiểm tra nếu màu sắc và size không được chọn
        if (empty($mau) || empty($size)) {
            echo "<script>alert('Vui lòng chọn màu sắc và kích thước sản phẩm.');</script>";
            exit;
        }

        // Thực hiện query để thêm thông tin vào giỏ hàng
        $sql = "INSERT INTO GioHang (TenDangNhap, MaSP, TenSP, HinhAnh, Mau, Size, SoLuong, Gia) 
                VALUES ('$tenDangNhap', '$productId', '$tenSP', '$hinhAnh', '$mau', '$size', $soLuong, $gia)";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Đã thêm sản phẩm vào giỏ hàng!');</script>";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.";
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="chitietSP.CSS">
</head>
<body>

<header>
<header>
    <a href="trangchu.php">
        <img src="img/logo.png" alt="Sowh Fashion Logo">
    </a>

    <?php if (isset($_SESSION['username'])): ?>
        <!-- Hiển thị tên đăng nhập nếu đã đăng nhập -->
        <a href="" class="login" style="top: 35px; left: 1300px;" ><b><?php echo htmlspecialchars($_SESSION['username']); ?></b></a>
       <a href="logout.php" class="login" style="top: 35px; right: 30px;" ><span class="material-icons" 
       style="font-size: 40px; color: #111;" >logout </span></a>
        <br>
    <a href="giohang.php" class="login" style="top: 100px; left: 1300px;">
     Giỏ hàng </a>
     <a href="giohang.php" class="login" style="top: 100px; right: 30px;" ><span class="material-icons" 
       style="font-size: 40px; color: #111;" >shopping_cart </span></a>

    <?php else: ?>
        <!-- Hiển thị nút Đăng nhập nếu chưa đăng nhập -->
        <a href="login.php" class="login" style="top: 35px; right: 110px;" ><span class="material-icons" 
      style="font-size: 40px; color: #111;" >account_circle</span></a><br>
    <a href="login.php" class="login">
     <b>Đăng nhập</b></a>
    <?php endif; ?>
</header>
</header>

<div class="product-page">
    <a href="trangchu.php" class="back-link"> <span class="material-icons" 
    style="font-size: 40px; color: #111;" >narrow_back </span>Quay về trang chủ</a>
    <div class="product-details">
        <div class="product-image">
            <img id="main-image" src="<?php echo $product['img']; ?>" alt="<?php echo $product['TenSP']; ?>">
            <div class="image-thumbnails">
                <?php foreach ($images as $image): ?>
                    <img class="thumbnail" src="<?php echo $image['Hinh']; ?>" alt="<?php echo $product['TenSP']; ?>" onclick="changeImage('<?php echo $image['Hinh']; ?>')">
                <?php endforeach; ?>
            </div>
        </div>

        <div class="product-info">
            <h1 class="nameSP"><?php echo $product['TenSP']; ?></h1>
            <p class="price">₫<?php echo number_format($product['Gia'], 0, ',', '.'); ?></p>
            <div class="options">
            <div class="colors">
    <span>Màu sắc:</span>
    <?php
    // Hiển thị các tên màu có sẵn
    foreach ($colors as $color) {
        echo "<button class='color-btn' onclick='selectColor(this)' data-color='{$color}'>{$color}</button>";
    }
    ?>
</div>
<div class="sizes">
    <span>Size:</span>
    <?php
    // Hiển thị các kích cỡ có sẵn
    foreach ($sizes as $size) {
        echo "<button class='size-btn' onclick='selectSize(this)' data-size='{$size}'>{$size}</button>";
    }
    ?>
</div>
            </div>
            <div class="quantity">
                <span>Số lượng:</span>
                <button class="quantity-btn" onclick="updateQuantity(-1)">-</button>
                <input type="number" id="quantity" value="1" min="1">
                <button class="quantity-btn" onclick="updateQuantity(1)">+</button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="tenSP" value="<?php echo $product['TenSP']; ?>">
                <input type="hidden" name="hinhAnh" value="<?php echo $product['img']; ?>">
                <input type="hidden" name="gia" value="<?php echo $product['Gia']; ?>">
                <input type="hidden" name="mau" id="selected-color">
                <input type="hidden" name="size" id="selected-size">
                <input type="hidden" name="soLuong" id="quantity-input">
                <div class="actions">
                <button type="submit" class="add-to-cart" name="add_to_cart">
    <span class="material-icons" style="font-size: 25px; color: #111;">shopping_cart</span>
    Thêm vào giỏ hàng
</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Hàm để chọn màu sắc
function selectColor(button) {
    // Loại bỏ lớp 'selected' khỏi tất cả các nút màu
    const colorButtons = document.querySelectorAll('.color-btn');
    colorButtons.forEach(btn => btn.classList.remove('selected'));

    // Thêm lớp 'selected' vào nút màu được chọn
    button.classList.add('selected');

    // Lấy giá trị màu đã chọn và hiển thị lên input ẩn
    const selectedColor = button.getAttribute('data-color');
    document.getElementById("selected-color").value = selectedColor; // Gửi màu sắc vào form
    console.log("Chọn màu:", selectedColor); // Có thể thực hiện hành động thêm nếu cần
}

// Hàm để chọn kích thước
function selectSize(button) {
    // Loại bỏ lớp 'selected' khỏi tất cả các nút kích thước
    const sizeButtons = document.querySelectorAll('.size-btn');
    sizeButtons.forEach(btn => btn.classList.remove('selected'));

    // Thêm lớp 'selected' vào nút kích thước được chọn
    button.classList.add('selected');

    // Lấy giá trị kích thước đã chọn và hiển thị lên input ẩn
    const selectedSize = button.getAttribute('data-size');
    document.getElementById("selected-size").value = selectedSize; // Gửi size vào form
    console.log("Chọn kích thước:", selectedSize); // Có thể thực hiện hành động thêm nếu cần
}

function updateQuantity(change) {
        const quantityInput = document.getElementById("quantity");
        let currentValue = parseInt(quantityInput.value);
        currentValue += change;
        if (currentValue < 1) currentValue = 1;
        quantityInput.value = currentValue;
        document.getElementById("quantity-input").value = currentValue;
    }

// Hàm để thay đổi hình ảnh chính khi chọn màu sắc
function changeImage(imageSrc) {
    document.getElementById('main-image').src = imageSrc;
}



</script>

</body>
</html>
