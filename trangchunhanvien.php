<?php
session_start(); // Bắt đầu session để kiểm tra đăng nhập
?>
<?php
$servername = "localhost"; // Địa chỉ máy chủ
$username = "root"; // Tên người dùng
$password = ""; // Mật khẩu
$dbname = "fss"; // Tên cơ sở dữ liệu của bạn

// Kết nối với cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Lấy các giá trị lọc và tìm kiếm từ người dùng nếu có
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$sort = isset($_POST['sort']) ? $_POST['sort'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Xây dựng phần điều kiện lọc
$whereClauses = [];
if ($gender) {
    $whereClauses[] = "GioiTinh = '$gender'";
}
if ($type) {
    $whereClauses[] = "PhanLoai = '$type'";
}
if ($search) {
    $whereClauses[] = "TenSP LIKE '%$search%'";
}

// Kết hợp các điều kiện lọc
$whereSql = count($whereClauses) > 0 ? "WHERE " . implode(" AND ", $whereClauses) : "";

// Sắp xếp theo lựa chọn
$orderSql = "";
if ($sort == 'priceAsc') {
    $orderSql = "ORDER BY Gia ASC";
} elseif ($sort == 'priceDesc') {
    $orderSql = "ORDER BY Gia DESC";
} elseif ($sort == 'sold') {
    $orderSql = "ORDER BY luotmua DESC";
} elseif ($whereSql == "") {
    // Nếu không có điều kiện lọc và tìm kiếm, sắp xếp ngẫu nhiên
    $orderSql = "ORDER BY RAND()";
}

// Truy vấn sản phẩm với điều kiện lọc và sắp xếp
$sql = "SELECT * FROM SanPham $whereSql $orderSql LIMIT 8";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sowh Fashion</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="trangchunhanvien.css">
</head>
<body>

<!-- Hiển thị thanh header -->
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

<div class="container">
  <!-- Phần bên trái (poster) -->
  <div class="left">
    <img src="img/poster.png" alt="Poster" class="poster">
    <p class="description">
      Khám phá bộ sưu tập thời trang đa dạng và phong cách tại SOWH, nơi mang đến cho bạn những xu hướng mới nhất, chất lượng vượt trội và giá cả hợp lý.
    </p>
  </div>

  <!-- Phần bên phải (thông tin sản phẩm) -->
  <div class="right">
    <div class="containerr">
        <!-- Lọc và tìm kiếm sản phẩm -->
        <form method="POST" id="filterForm" action="">
        <div class="filter-box">
          <label>Giới tính:</label>
          <select id="genderFilter" name="gender">
            <option value="">Tất cả</option>
            <option value="nam" <?php if ($gender == 'nam') echo 'selected'; ?>>Nam</option>
            <option value="nữ" <?php if ($gender == 'nữ') echo 'selected'; ?>>Nữ</option>
          </select>

          <label>Loại:</label>
          <select id="typeFilter" name="type">
            <option value="">Tất cả</option>
            <option value="quần" <?php if ($type == 'quần') echo 'selected'; ?>>Quần</option>
            <option value="áo" <?php if ($type == 'áo') echo 'selected'; ?>>Áo</option>
            <option value="đồ bộ" <?php if ($type == 'đồ bộ') echo 'selected'; ?>>Đồ bộ</option>
            <option value="giày" <?php if ($type == 'giày') echo 'selected'; ?>>Giày</option>
            <option value="áo khoác" <?php if ($type == 'áo khoác') echo 'selected'; ?>>Áo khoác</option>
            <option value="mũ" <?php if ($type == 'mũ') echo 'selected'; ?>>Mũ</option>
          </select>

          <label>Sắp xếp:</label>
          <select id="sortFilter" name="sort">
            <option value="">Mặc định</option>
            <option value="priceAsc" <?php if ($sort == 'priceAsc') echo 'selected'; ?>>Giá tăng dần</option>
            <option value="priceDesc" <?php if ($sort == 'priceDesc') echo 'selected'; ?>>Giá giảm dần</option>
            <option value="sold" <?php if ($sort == 'sold') echo 'selected'; ?>>Số lượt mua</option>
          </select>
          <!-- Nút lọc -->
          <button type="button" id="filterButton" onclick="applyFilters()">Lọc</button>
        
          <!-- Tìm kiếm sản phẩm -->

          <div class="search-box">
            <span class="material-icons" style="font-size: 20px; color: #111;">search</span>
            <input type="text" id="searchInput" name="search" placeholder=" Nhập tên sản phẩm..." value="<?php echo $search; ?>">
          
            <!-- Nút tìm kiếm -->
          <button type="button" id="searchButton" onclick="searchProduct()">Tìm kiếm</button>
        </div>
        </div>
        </form>
      </div>

      <br>
      <div class="thanhngang"></div>
      <br>
      <div>
		<img src="img/dexuat.png" alt="Đề xuất" width="200px" style="margin-right: 650px">
		<button type="button" href="">Xóa</button>
		<button type="button" href="">Sửa</button>
		<button type="button" href="">+</button>
		<br><br>
      </div>
      <div class="product-container">
        <?php
        if ($result->num_rows > 0) {
            $counter = 0;
            while($row = $result->fetch_assoc()) {
                if ($counter % 4 == 0 && $counter != 0) {
                    echo '</div><div class="product-container">'; // Kết thúc hàng và tạo hàng mới sau 4 sản phẩm
                }
                echo '<div class="product-item">';
                echo '<img src="' . $row["img"] . '" alt="Product ' . $row["MaSP"] . '">';
                echo '<div class="product-info">';
                echo '<p class="product-name">' . $row["TenSP"] . '</p>';
                echo '<p class="product-price">đ' . number_format($row["Gia"], 0, ',', '.') ;
                echo '</div>';
                echo '</div>';
                $counter++;
            }
        } else {
            echo "Không có sản phẩm";
        }
        ?>
      </div>
  </div>
</div>

<script>
  // Hàm áp dụng bộ lọc
  function applyFilters() {
    document.getElementById('filterForm').submit(); // Gửi form khi bấm nút "Lọc"
  }

  // Hàm tìm kiếm
  function searchProduct() {
    document.getElementById('filterForm').submit(); // Gửi form khi bấm nút "Tìm kiếm"
  }
</script>

</body>
</html>
