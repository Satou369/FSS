<?php
session_start(); // Bắt đầu session để kiểm tra đăng nhập
?>



<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost"; // Thay bằng tên máy chủ MySQL của bạn
$username = "root"; // Thay bằng tên tài khoản MySQL của bạn
$password = ""; // Thay bằng mật khẩu MySQL của bạn
$database = "fss"; // Thay bằng tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu đã đăng nhập
if (isset($_SESSION['username'])) {
    $tenDangNhap = $_SESSION['username'];

    // Truy vấn dữ liệu giỏ hàng theo `TenDangNhap`
    $sql = "SELECT MaSP, TenSP, HinhAnh, Mau, Size, SoLuong, Gia FROM giohang WHERE TenDangNhap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tenDangNhap);
    $stmt->execute();
    $result = $stmt->get_result();

    // Tạo mảng để lưu thông tin sản phẩm trong giỏ hàng
    $gioHang = [];
    while ($row = $result->fetch_assoc()) {
        $gioHang[] = $row;
    }

    $stmt->close();
} else {
    echo "<p>Vui lòng đăng nhập để xem giỏ hàng!</p>";
    exit;
}


// Kiểm tra yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $masp = $_POST['masp']; // Lấy mã sản phẩm từ yêu cầu POST
    $tenDangNhap = $_SESSION['username']; // Lấy tên đăng nhập từ session

    // Xóa sản phẩm khỏi bảng giỏ hàng
    $sql = "DELETE FROM giohang WHERE MaSP = ? AND TenDangNhap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $masp, $tenDangNhap);

    if ($stmt->execute()) {
        // Trả về phản hồi JSON nếu xóa thành công
        echo json_encode(['status' => 'success']);
    } else {
        // Trả về phản hồi JSON nếu có lỗi
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
    $conn->close();
    exit; // Kết thúc xử lý, không cần tải lại trang
}

// Đóng kết nối
$conn->close();
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="giohangs.css">
</head>
<body>
<header>
			<a href="trangchu.php">
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
					<a href="giohang.php" class="login" style="top: 100px; left: 1300px;">
            Giỏ hàng
        </a>
					<a href="giohang.php" class="login" style="top: 100px; right: 30px;" ><span class="material-icons" 
					style="font-size: 40px; color: #111;" >shopping_cart </span></a>

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

<div style="display: flex; justify-content: space-between; align-items: center;">
  <a href="trangchu.php" class="back-link">
    <span class="material-icons" style="font-size: 40px; color: #111;">narrow_back</span> Quay về trang chủ
  </a>
  <a href="lichsudonhang.php" class="back-link" style = "margin-right: 30px ;">Lịch sử đơn hàng</a>
</div>


<div class="container">
    <form action="#" method="POST">
        <table class="giohang-table">
            <thead>
                <tr style="background-color: rgb(216, 216, 216);">
                    <th><input type="checkbox" id="select-all" /></th>
                    <th>Sản phẩm</th>
                    <th></th>
                    <th></th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Số tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
    <?php if (!empty($gioHang)): ?>
        <?php foreach ($gioHang as $sanPham): ?>
            <tr style="background-color: rgb(245, 245, 245);" data-price="<?php echo $sanPham['Gia']; ?>">
                <td><input type="checkbox" class="product-checkbox" /></td>
                <td><img src="<?php echo htmlspecialchars($sanPham['HinhAnh']); ?>" alt="<?php echo htmlspecialchars($sanPham['TenSP']); ?>"></td>
                <td><?php echo htmlspecialchars($sanPham['TenSP']); ?></td>
                <td>Phân loại hàng:<br> <?php echo htmlspecialchars($sanPham['Mau']) . ', ' . htmlspecialchars($sanPham['Size']); ?></td>
                <td><?php echo number_format($sanPham['Gia'], 0, ',', '.') . ' đ'; ?></td>
                <td><input type="number" class="quantity" value="<?php echo $sanPham['SoLuong']; ?>" min="1"></td>
                <td class="subtotal"><?php echo number_format($sanPham['Gia'] * $sanPham['SoLuong'], 0, ',', '.') . ' đ'; ?></td>
                <td>
    <button type="button" class="remove-btn" data-masp="<?php echo htmlspecialchars($sanPham['MaSP']); ?>">Xóa</button>
</td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">Giỏ hàng của bạn hiện đang trống.</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
    </form>
</div>

<div class="footer">
    <div class="total">
        Tổng thanh toán: <span id="total-price">0 đ</span>
    </div>
    <form id="checkout-form" action="xulygiohang.php" method="POST">
    <button type="submit" class="checkout-btn" name="checkout">Thanh toán</button>
    <input type="hidden" name="selected_products" id="selected-products" />
</form>

</div>

<script >
    // Hàm tính số tiền từng sản phẩm
function updateSubtotal(row) {
    const price = parseInt(row.dataset.price, 10); // Giá sản phẩm từ thuộc tính data-price
    const quantityInput = row.querySelector('.quantity'); // Lấy input số lượng
    const quantity = parseInt(quantityInput.value, 10) || 1; // Số lượng (mặc định là 1 nếu không hợp lệ)

    // Tính toán tổng tiền cho sản phẩm
    const subtotal = price * quantity;

    // Cập nhật hiển thị ở cột Số tiền
    row.querySelector('.subtotal').textContent = subtotal.toLocaleString('vi-VN') + ' đ';
}

// Hàm tính tổng tiền tất cả sản phẩm
function calculateTotal() {
    const checkboxes = document.querySelectorAll('.product-checkbox'); // Checkbox từng sản phẩm
    let total = 0;

    checkboxes.forEach((checkbox) => {
        const row = checkbox.closest('tr'); // Lấy hàng chứa sản phẩm hiện tại
        const quantityInput = row.querySelector('.quantity'); // Input số lượng
        const price = parseInt(row.dataset.price, 10); // Giá sản phẩm
        const quantity = parseInt(quantityInput.value, 10) || 1; // Số lượng (mặc định là 1 nếu không hợp lệ)

        if (checkbox.checked) {
            total += price * quantity; // Cộng tổng tiền các sản phẩm được chọn
        }
    });

    // Cập nhật hiển thị tổng tiền thanh toán
    document.getElementById('total-price').textContent = total.toLocaleString('vi-VN') + ' đ';
}

// Gán sự kiện thay đổi số lượng
document.querySelectorAll('.quantity').forEach((input) => {
    input.addEventListener('input', function () {
        const row = this.closest('tr'); // Lấy hàng chứa sản phẩm hiện tại
        updateSubtotal(row); // Cập nhật số tiền từng sản phẩm
        calculateTotal(); // Cập nhật tổng tiền
    });
});

// Gán sự kiện tick checkbox từng sản phẩm
document.querySelectorAll('.product-checkbox').forEach((checkbox) => {
    checkbox.addEventListener('change', calculateTotal);
});

// Xử lý khi checkbox "Chọn tất cả" được tick
document.getElementById('select-all').addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = this.checked; // Tick hoặc bỏ tick tất cả sản phẩm
    });

    calculateTotal(); // Cập nhật tổng tiền
});

// Tự động cập nhật tổng tiền ban đầu khi tải trang
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.quantity').forEach((input) => {
        const row = input.closest('tr');
        updateSubtotal(row); // Cập nhật từng sản phẩm ban đầu
    });
    calculateTotal(); // Cập nhật tổng tiền ban đầu
});
//  "Xóa"
document.querySelectorAll('.remove-btn').forEach((button) => {
    button.addEventListener('click', function () {
        const masp = this.getAttribute('data-masp'); // Lấy mã sản phẩm
        const row = this.closest('tr'); // Hàng của sản phẩm

        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            // Gửi yêu cầu xóa đến chính trang hiện tại
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=remove&masp=${masp}`, // Dữ liệu gửi đi
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'success') {
                        // Xóa hàng khỏi giao diện nếu thành công
                        row.remove();
                        alert('Sản phẩm đã được xóa.');
                        calculateTotal(); // Gọi hàm để cập nhật tổng tiền
                    } else {
                        alert('Không thể xóa sản phẩm. Vui lòng thử lại.');
                    }
                })
                .catch((error) => {
                    console.error('Lỗi:', error);
                    alert('Đã xảy ra lỗi khi xóa sản phẩm.');
                });
        }
    });
});
document.querySelector('.checkout-btn').addEventListener('click', function(event) {
    event.preventDefault(); // Ngăn form gửi ngay lập tức

    const selectedProducts = [];

    document.querySelectorAll('.product-checkbox:checked').forEach(checkbox => {
        const row = checkbox.closest('tr');
        const product = {
            MaSP: row.querySelector('.remove-btn').getAttribute('data-masp'),
            HinhAnh: row.querySelector('img').src,
            TenSP: row.cells[2].innerText,
            Mau: row.cells[3].innerText.split(', ')[0].split(': ')[1],
            Size: row.cells[3].innerText.split(', ')[1],
            SoLuong: row.querySelector('.quantity').value,
            Gia: row.dataset.price
        };
        selectedProducts.push(product);
    });
    document.getElementById('selected-products').value = JSON.stringify(selectedProducts);
    document.getElementById('checkout-form').submit(); // Gửi form
});
</script>
</body>
</html>
