<?php
session_start(); // Bắt đầu session để kiểm tra đăng nhập

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
if (!isset($_SESSION['username'])) {
    echo "<p>Vui lòng đăng nhập để xem giỏ hàng!</p>";
    exit;
}

$tenDangNhap = $_SESSION['username'];

// Truy vấn dữ liệu giỏ hàng theo `TenDangNhap`
$sql = "SELECT MaSP, TenSP, HinhAnh, Mau, Size, SoLuong, Gia FROM xuly WHERE TenDangNhap = ?";
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



// Kiểm tra xem form đã được gửi chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_info'])) {
    // Lấy thông tin từ POST và loại bỏ khoảng trắng thừa
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';

    // Kiểm tra nếu tất cả thông tin đã được nhập
    if ($name && $phone && $address) {
        // Sinh mã đơn hàng ngẫu nhiên
        $maDH = "DH" . strtoupper(uniqid()); // Tạo mã đơn hàng

        // Kiểm tra sự tồn tại của session 'tenDangNhap'
        if (isset($_SESSION['tenDangNhap'])) {
            $tenDangNhap = $_SESSION['tenDangNhap'];
        } else {
            echo "Chưa đăng nhập, vui lòng đăng nhập để tiếp tục!";
            exit;
        }

        // Câu lệnh INSERT vào bảng donhang2
        $sql = "INSERT INTO donhang2 (MaDH, HoTen, SoDienThoai, DiaChi, TenDangNhap) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Kiểm tra nếu câu lệnh chuẩn bị thành công
        if ($stmt === false) {
            echo "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error;
            exit;
        }

        $stmt->bind_param("sssss", $maDH, $name, $phone, $address, $tenDangNhap);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            echo "Thông tin đã được thêm thành công! Mã đơn hàng: " . $maDH;
        } else {
            echo "Lỗi khi thêm thông tin: " . $stmt->error;
        }

        // Đóng statement
        $stmt->close();
    } else {
        // Nếu thiếu thông tin, hiển thị thông báo
        echo "Vui lòng nhập đầy đủ thông tin!";
    }
}




// Kiểm tra khi nhấn nút "Xác nhận" (checkout)
if (isset($_POST['checkout'])) {
    echo "Đang xử lý đơn hàng!";

    // Lấy thông tin từ POST
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';

    if ($name && $phone && $address) {
        // Sinh mã đơn hàng ngẫu nhiên
        $maDH = "DH" . strtoupper(uniqid());

        // Kiểm tra sự tồn tại của session 'tenDangNhap'
        if (isset($_SESSION['tenDangNhap'])) {
            $tenDangNhap = $_SESSION['tenDangNhap'];
        } else {
            echo "Chưa đăng nhập, vui lòng đăng nhập để tiếp tục!";
            exit;
        }

        // Câu lệnh INSERT vào bảng donhang2
        $sqlInsert = "INSERT INTO donhang2 (MaDH, HoTen, SoDienThoai, DiaChi, TenDangNhap) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("sssss", $maDH, $name, $phone, $address, $tenDangNhap);

        if ($stmtInsert->execute()) {
            echo "Thông tin đã được thêm thành công! Mã đơn hàng: " . $maDH;

            $sqlInsertFromXuly = "INSERT INTO donhang2 (TenDangNhap, MaSP, TenSP, HinhAnh, Mau, Size, SoLuong, Gia, TongTien, HoTen, SoDienThoai, DiaChi, NgayTao, MaDH)
                                  SELECT 
                                      x.TenDangNhap,
                                      x.MaSP,
                                      x.TenSP,
                                      x.HinhAnh,
                                      x.Mau,
                                      x.Size,
                                      x.SoLuong,
                                      x.Gia,
                                      x.SoLuong * x.Gia AS TongTien,
                                      d.HoTen,
                                      d.SoDienThoai,
                                      d.DiaChi,
                                      x.NgayTao,
                                      ? AS MaDH
                                  FROM 
                                      xuly x
                                  JOIN 
                                      donhang2 d ON d.MaDH = ? 
                                  WHERE 
                                      x.TenSP IS NOT NULL";

            if ($stmtInsertFromXuly = $conn->prepare($sqlInsertFromXuly)) {
                $stmtInsertFromXuly->bind_param("ss", $maDH, $maDH);

                if ($stmtInsertFromXuly->execute()) {
                    echo "Dữ liệu đã được sao chép từ bảng xuly vào bảng donhang2!";
                    
                    // Xóa sản phẩm khỏi bảng xuly sau khi xử lý thành công
                    $sqlDeleteFromXuly = "DELETE FROM xuly WHERE TenDangNhap = ?";
                    if ($stmtDeleteFromXuly = $conn->prepare($sqlDeleteFromXuly)) {
                        $stmtDeleteFromXuly->bind_param("s", $tenDangNhap);
                        $stmtDeleteFromXuly->execute();
                        $stmtDeleteFromXuly->close();
                    }

                    // Chuyển hướng tới trang chủ sau khi đặt hàng thành công
                    echo "<script>alert('Đặt hàng thành công!'); window.location.href = 'trangchu.php';</script>";
                } else {
                    echo "Lỗi khi sao chép dữ liệu: " . $stmtInsertFromXuly->error;
                }

                $stmtInsertFromXuly->close();
            } else {
                echo "Lỗi khi chuẩn bị câu lệnh sao chép từ xuly: " . $conn->error;
            }

        } else {
            echo "Lỗi khi thêm thông tin: " . $stmtInsert->error;
        }
        $stmtInsert->close();
    } else {
        echo "Vui lòng nhập đầy đủ thông tin!";
    }


    // Đóng kết nối
    $conn->close();
}
?>
   
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="thanhtoan.css">
    <script>
        function updateSubtotal(element) {
            var row = element.closest('tr');
            var price = parseInt(row.getAttribute('data-price'));
            var quantity = parseInt(element.value);
            var subtotal = price * quantity;
            row.querySelector('.subtotal').textContent = subtotal.toLocaleString() + ' đ';
            updateTotal();
        }

        function updateTotal() {
            var total = 0;
            document.querySelectorAll('.subtotal').forEach(function(subtotal) {
                total += parseInt(subtotal.textContent.replace(' đ', '').replace('.', ''));
            });
            document.getElementById('total-price').textContent = total.toLocaleString() + ' đ';
        }

        window.onload = updateTotal;
    </script>
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
				</div><a href="trangchu.php" class="back-link"> <span class="material-icons" 
    style="font-size: 40px; color: #111;" >narrow_back </span>Quay về trang chủ</a>
			<?php endif; ?>
		</header>

    <div class="address-wrapper">
        <div class="address-container">
            <span class="material-icons location-icon">location_on</span>
            <div class="address-content">
                <div class="title-row">
                    <strong class="title">Địa chỉ nhận hàng</strong>
                    <a href="#" id="editInfoLink" class="edit-link">Thay đổi thông tin</a>
                </div>
                <div class="info-row">
                    <span><strong>Nguyễn Văn D</strong> | 0948563268</span><br>
                    <span>289 ABC, Phường Ngô Mây, Tp Quy Nhơn</span>
                </div>
            </div>
        </div>
    </div>
<div class="container">

    <form action="#" method="POST">
        <table class="giohang-table">
            <thead>
                <tr style="background-color: rgb(216, 216, 216);">
                    <th>Sản phẩm</th>
                    <th></th>
                    <th></th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Số tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($gioHang)): ?>
                    <?php foreach ($gioHang as $sanPham): ?>
                        <tr style="background-color: rgb(245, 245, 245);" data-price="<?php echo $sanPham['Gia']; ?>">
                            <?php if (!empty($sanPham['HinhAnh'])): ?>
                                <td><img src="<?php echo htmlspecialchars($sanPham['HinhAnh']); ?>" alt="<?php echo htmlspecialchars($sanPham['TenSP']); ?>"></td>
                            <?php endif; ?>
                            <?php if (!empty($sanPham['TenSP'])): ?>
                                <td><?php echo htmlspecialchars($sanPham['TenSP']); ?></td>
                            <?php endif; ?>
                            <?php if (!empty($sanPham['Mau']) || !empty($sanPham['Size'])): ?>
                                <td>Phân loại hàng:<br> 
                                    <?php 
                                    if (!empty($sanPham['Mau'])) {
                                        echo htmlspecialchars($sanPham['Mau']);
                                    }
                                    if (!empty($sanPham['Mau']) && !empty($sanPham['Size'])) {
                                        echo ', ';
                                    }
                                    if (!empty($sanPham['Size'])) {
                                        echo htmlspecialchars($sanPham['Size']);
                                    }
                                    ?>
                                </td>
                            <?php endif; ?>
                            <?php if (!empty($sanPham['Gia'])): ?>
                                <td><?php echo number_format($sanPham['Gia'], 0, ',', '.') . ' đ'; ?></td>
                            <?php endif; ?>
                            <?php if (!empty($sanPham['SoLuong'])): ?>
                                <td><?php echo $sanPham['SoLuong']; ?></td>
                            <?php endif; ?>
                            <?php if (!empty($sanPham['Gia']) && !empty($sanPham['SoLuong'])): ?>
                                <td class="subtotal"><?php echo number_format($sanPham['Gia'] * $sanPham['SoLuong'], 0, ',', '.') . ' đ'; ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</div>

<div class="footer">

    
    <div class="total">
    Tổng thanh toán: <span id="total-price">0 đ</span> 
    </div>
    <div class="payment-method">
        Phương thức thanh toán: <p style="color: gray; display: inline;">Thanh toán khi nhận hàng</p>
    </div>
    <form method="post">
    <button type="submit" class="checkout-btn" name="checkout" onclick="redirectToHome()">Xác nhận</button>
</form>

<script>
    function redirectToHome() {
        // Ngừng thực thi submit form ngay lập tức
        event.preventDefault();

        // Hiển thị thông báo hoặc bất kỳ hiệu ứng nào nếu cần
        alert("Đặt hàng thành công");

        // Sau 5 giây, chuyển hướng về trang chủ
        setTimeout(function() {
            window.location.href = "trangchu.php"; // Thay đổi đường dẫn nếu cần
        }, 5000);
    }
</script>

</div>


```
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Chỉnh sửa thông tin</h2>
        <label for="inputName">Họ và Tên:</label>
        <input type="text" id="inputName" placeholder="Nhập họ tên" required>

        <label for="inputPhone">Số điện thoại:</label>
        <input type="text" id="inputPhone" placeholder="Nhập số điện thoại" required>

        <label for="inputAddress">Địa chỉ:</label>
        <input type="text" id="inputAddress" placeholder="Nhập địa chỉ" required>

        <button type="button" id="saveButton">Lưu</button>
    </div>
</div>

<script>
    const modal = document.getElementById('editModal');
    const editInfoLink = document.getElementById('editInfoLink');
    const closeModal = document.getElementById('closeModal');
    const saveButton = document.getElementById('saveButton');

    editInfoLink.addEventListener('click', function(e) {
        e.preventDefault();
        modal.style.display = 'block';
    });

    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    saveButton.addEventListener('click', function() {
    const name = document.getElementById('inputName').value.trim();
    const phone = document.getElementById('inputPhone').value.trim();
    const address = document.getElementById('inputAddress').value.trim();

    if (name && phone && address) {
        // Update displayed information
        document.querySelector('.info-row').innerHTML = `
            <span><strong>${name}</strong> | ${phone}</span><br>
            <span>${address}</span>
        `;

        // Close modal after saving
        modal.style.display = 'none';

        // Send information to server for updating (AJAX or form submit)
        var formData = new FormData();
        formData.append('name', name);
        formData.append('phone', phone);
        formData.append('address', address);
        formData.append('save_info', 'true');

        fetch('thanhtoan.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert("Thông tin đã được lưu thành công!");
        })
        .catch(error => {
            console.error('Lỗi:', error);
        });
    } else {
        alert("Vui lòng nhập đầy đủ thông tin!");
    }
});

</script>

</body>
</html>
