-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 18, 2024 lúc 03:46 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `fss`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `loai` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`username`, `password`, `phone`, `email`, `loai`) VALUES
('bichtram', '2045', '0123456789', 'bichtram2045@gmail.com', 'nv'),
('Allen', '1234', '0234567890', 'df@gmail.com', NULL),
('Satou', '123456', '0969959804', 'annguyenduc@gmail.com', NULL),
('Admin', '1234', '0123456789', 'adjcnds@gmail.com', 'qtv'),
('School', '123456', '0123456789', 'truongdien@gmail.com', 'nv');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doanhthu`
--

CREATE TABLE `doanhthu` (
  `thoigian` varchar(7) NOT NULL,
  `doanhthu` int(11) NOT NULL,
  `chiphi` int(11) NOT NULL,
  `loinhuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `doanhthu`
--

INSERT INTO `doanhthu` (`thoigian`, `doanhthu`, `chiphi`, `loinhuan`) VALUES
('11/2024', 10000000, 30000000, 70000000),
('10/2024', 10000000, 20000000, 80000000),
('09/2024', 80000000, 30000000, 50000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDH` char(10) NOT NULL,
  `TaiKhoan` varchar(20) NOT NULL,
  `TenNguoiNhan` varchar(50) NOT NULL,
  `SoDienThoai` char(10) NOT NULL,
  `DiaChi` varchar(50) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `Co` char(1) NOT NULL,
  `Gia` int(11) NOT NULL,
  `TrangThai` varchar(50) NOT NULL,
  `MaSP` varchar(10) DEFAULT NULL,
  `ThoiGian` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDH`, `TaiKhoan`, `TenNguoiNhan`, `SoDienThoai`, `DiaChi`, `SoLuong`, `Co`, `Gia`, `TrangThai`, `MaSP`, `ThoiGian`) VALUES
('DH001', 'john_doe', 'Nguyen Van A', '0123456789', '123 Le Loi', 2, 'M', 50000, 'Chưa xác nhận', 'SP02', '2024-12-16 16:05:10'),
('DH002', 'jane_smith', 'Tran Thi B', '0987654321', '456 Tran Hung Dao', 1, 'L', 75000, 'Đã xác nhận', 'SP07', '2024-12-16 16:05:10'),
('DH003', 'alice_wonder', 'Le Van C', '0112233445', '789 Nguyen Trai', 3, 'S', 100000, 'Chưa xác nhận', 'SP09', '2024-12-16 16:05:10'),
('DH004', 'bob_builder', 'Pham Thi D', '0998877665', '321 Hai Ba Trung', 4, 'M', 125000, 'Chưa xác nhận', 'SP05', '2024-12-16 16:05:10'),
('DH005', 'charlie_brown', 'Hoang Van E', '0123987654', '654 Ly Thuong Kiet', 5, 'L', 150000, 'Đã xác nhận', 'SP06', '2024-12-16 16:05:10'),
('DH006', 'david_tennant', 'Nguyen Thi F', '0123456786', '987 Phan Chu Trinh', 2, 'S', 175000, 'Chưa xác nhận', 'SP04', '2024-12-16 16:05:10'),
('DH007', 'emily_blunt', 'Tran Van G', '0987654322', '123 Le Duan', 1, 'M', 200000, 'Chưa xác nhận', 'SP10', '2024-12-16 16:05:10'),
('DH008', 'frank_underwood', 'Le Thi H', '0112233446', '456 Nguyen Hue', 3, 'L', 225000, 'Đã xác nhận', 'SP10', '2024-12-16 16:05:10'),
('DH009', 'grace_hopper', 'Pham Van I', '0998877666', '789 Tran Quoc Toan', 4, 'S', 250000, 'Chưa xác nhận', 'SP07', '2024-12-16 16:05:10'),
('DH010', 'harry_potter', 'Hoang Thi J', '0123987655', '321 Le Thanh Ton', 5, 'M', 275000, 'Chưa xác nhận', 'SP05', '2024-12-16 16:05:10'),
('DH011', 'isaac_newton', 'Nguyen Van K', '0123456787', '654 Nguyen Dinh Chieu', 2, 'L', 300000, 'Đã xác nhận', 'SP06', '2024-12-16 16:05:10'),
('DH012', 'julia_roberts', 'Tran Thi L', '0987654323', '987 Le Van Sy', 1, 'S', 325000, 'Chưa xác nhận', 'SP01', '2024-12-16 16:05:10'),
('DH013', 'keanu_reeves', 'Le Van M', '0112233447', '123 Pham Van Dong', 3, 'M', 350000, 'Chưa xác nhận', 'SP09', '2024-12-16 16:05:10'),
('DH014', 'leonardo_dicaprio', 'Pham Thi N', '0998877667', '456 Vo Thi Sau', 4, 'L', 375000, 'Đã xác nhận', 'SP09', '2024-12-16 16:05:10'),
('DH015', 'michael_jordan', 'Hoang Van O', '0123987656', '789 Hoang Hoa Tham', 5, 'S', 400000, 'Chưa xác nhận', 'SP09', '2024-12-16 16:05:10'),
('DH016', 'natalie_portman', 'Nguyen Thi P', '0123456788', '321 Nguyen Van Cu', 2, 'M', 425000, 'Chưa xác nhận', 'SP07', '2024-12-16 16:05:10'),
('DH017', 'olivia_wilde', 'Tran Van Q', '0987654324', '654 Tran Phu', 1, 'L', 450000, 'Đã xác nhận', 'SP09', '2024-12-16 16:05:10'),
('DH018', 'peter_parker', 'Le Thi R', '0112233448', '987 Le Hong Phong', 3, 'S', 475000, 'Chưa xác nhận', 'SP02', '2024-12-16 16:05:10'),
('DH019', 'quentin_tarantino', 'Pham Van S', '0998877668', '123 Nguyen Thi Minh Khai', 4, 'M', 500000, 'Chưa xác nhận', 'SP03', '2024-12-16 16:05:10'),
('DH020', 'robert_downey', 'Hoang Thi T', '0123987657', '456 Le Loi', 5, 'L', 525000, 'Đã xác nhận', 'SP06', '2024-12-16 16:05:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang2`
--

CREATE TABLE `donhang2` (
  `ID` int(11) NOT NULL,
  `TenDangNhap` varchar(255) NOT NULL,
  `MaSP` varchar(10) DEFAULT NULL,
  `TenSP` varchar(255) DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `Mau` varchar(50) DEFAULT NULL,
  `Size` varchar(50) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `Gia` int(11) DEFAULT NULL,
  `TongTien` int(11) DEFAULT NULL,
  `HoTen` varchar(255) DEFAULT NULL,
  `SoDienThoai` varchar(20) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `NgayTao` timestamp NULL DEFAULT current_timestamp(),
  `MaDH` varchar(20) DEFAULT NULL,
  `trangthai` enum('Chưa xác nhận','Đã xác nhận') NOT NULL DEFAULT 'Chưa xác nhận'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang2`
--

INSERT INTO `donhang2` (`ID`, `TenDangNhap`, `MaSP`, `TenSP`, `HinhAnh`, `Mau`, `Size`, `SoLuong`, `Gia`, `TongTien`, `HoTen`, `SoDienThoai`, `DiaChi`, `NgayTao`, `MaDH`, `trangthai`) VALUES
(46, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Nguyễn Văn ABC', '0248069524', 'Hồ Chí Minh', '2024-12-16 17:11:56', 'DH67607501A4A15', 'Chưa xác nhận'),
(43, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Nguyễn Văn A', '0123456789', 'Hồ Chí Minh', '2024-12-16 17:55:53', 'DH676073D948F71', 'Chưa xác nhận'),
(42, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Nguyễn Văn A', '0123456789', 'Hồ Chí Minh', '2024-12-16 17:11:56', 'DH676073D948F71', 'Chưa xác nhận'),
(22, 'Satou', NULL, 'Áo khoác da nam', 'http://localhost/FSS/img/SP10.1.jpg', NULL, 'XXL', 50, 120000, 6000000, 'Trần An F', '0258147936', 'An Nhơn', '2024-12-16 16:07:01', 'DH67606B83701B3', 'Chưa xác nhận'),
(23, 'Satou', NULL, 'Áo len nữ cổ lọ', 'http://localhost/FSS/img/SP06.1.jpg', NULL, 'XL', 3, 200000, 600000, 'Trần An F', '0258147936', 'An Nhơn', '2024-12-16 16:07:01', 'DH67606B83701B3', 'Chưa xác nhận'),
(24, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Trần An F', '0258147936', 'An Nhơn', '2024-12-16 17:55:53', 'DH67606B83701B3', 'Chưa xác nhận'),
(25, 'Satou', NULL, 'Áo khoác da nam', 'http://localhost/FSS/img/SP10.1.jpg', NULL, 'XXL', 50, 120000, 6000000, 'Trần An F', '0258147936', 'An Nhơn', '2024-12-16 17:04:03', 'DH67606B83701B3', 'Chưa xác nhận'),
(26, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Trần An F', '0258147936', 'An Nhơn', '2024-12-16 17:11:56', 'DH67606B83701B3', 'Chưa xác nhận'),
(27, 'WILFRED', NULL, 'Áo phông nữ tay lỡ', 'http://localhost/FSS/img/SP08.1.jpg', NULL, 'L', 3, 100000, 300000, 'Trần An F', '0258147936', 'An Nhơn', '2024-12-16 17:55:53', 'DH67606B83701B3', 'Chưa xác nhận'),
(39, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Nguyễn Văn D', '0248069524', 'Hồ Chí Minh', '2024-12-16 17:55:53', 'DH6760739ADC476', 'Chưa xác nhận'),
(30, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Nguyễn Đức An', '0348965712', 'Quy Nhơn, Bình Định', '2024-12-16 17:11:56', 'DH67606E16D053F', 'Chưa xác nhận'),
(31, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Nguyễn Đức An', '0348965712', 'Quy Nhơn, Bình Định', '2024-12-16 17:55:53', 'DH67606E16D053F', 'Chưa xác nhận'),
(38, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Nguyễn Văn D', '0248069524', 'Hồ Chí Minh', '2024-12-16 17:11:56', 'DH6760739ADC476', 'Chưa xác nhận'),
(35, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'a', '789+456123', 'Hồ Chí Minh', '2024-12-16 17:11:56', 'DH676070E498650', 'Chưa xác nhận'),
(36, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'a', '789+456123', 'Hồ Chí Minh', '2024-12-16 17:55:53', 'DH676070E498650', 'Chưa xác nhận'),
(47, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Nguyễn Văn ABC', '0248069524', 'Hồ Chí Minh', '2024-12-16 17:55:53', 'DH67607501A4A15', 'Chưa xác nhận'),
(53, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Allen Chen', '0248069524', 'Hồ Chí Minh', '2024-12-16 17:11:56', 'DH676077677790B', 'Chưa xác nhận'),
(54, 'WILFRED', NULL, 'Quần short nam thể thao', 'http://localhost/FSS/img/SP07.1.jpg', NULL, 'XXL', 2, 250000, 500000, 'Allen Chen', '0248069524', 'Hồ Chí Minh', '2024-12-16 17:55:53', 'DH676077677790B', 'Chưa xác nhận'),
(73, 'WILFRED', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ỷdfnj', 'fghj', 'Quy Nhơn', '2024-12-16 19:55:57', 'DH676085CD15874', 'Chưa xác nhận');

--
-- Bẫy `donhang2`
--
DELIMITER $$
CREATE TRIGGER `trg_auto_delete_null_tensp` AFTER INSERT ON `donhang2` FOR EACH ROW BEGIN
    DELETE FROM donhang2
    WHERE TenSP IS NULL;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `id` int(11) NOT NULL,
  `TenDangNhap` varchar(255) NOT NULL,
  `MaSP` varchar(10) DEFAULT NULL,
  `TenSP` varchar(255) NOT NULL,
  `HinhAnh` varchar(255) NOT NULL,
  `Mau` varchar(50) NOT NULL,
  `Size` varchar(10) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `Gia` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`id`, `TenDangNhap`, `MaSP`, `TenSP`, `HinhAnh`, `Mau`, `Size`, `SoLuong`, `Gia`) VALUES
(27, 'WILFRED', 'SP08', 'Áo phông nữ tay lỡ', 'image/SP08.1.jpg', 'Hồng', 'L', 3, 100000.00),
(31, 'Allen', 'SP03', 'Áo khoác dạ nữ dài', 'image/SP03.1.jpg', 'Vàng', 'XXL', 3, 100000.00),
(32, 'Allen', 'SP08', 'Áo phông nữ tay lỡ', 'image/SP08.1.jpg', 'Vàng', 'XL', 2, 100000.00),
(26, 'WILFRED', 'SP07', 'Quần short nam thể thao', 'image/SP07.1.jpg', 'Xám', 'XXL', 2, 250000.00),
(30, 'WILFRED', 'SP03', 'Áo khoác dạ nữ dài', 'image/SP03.1.jpg', 'Hồng', 'XL', 3, 100000.00),
(29, 'WILFRED', 'SP03', 'Áo khoác dạ nữ dài', 'image/SP03.1.jpg', 'Trắng', 'XL', 2, 100000.00),
(25, 'WILFRED', 'SP03', 'Áo khoác dạ nữ dài', 'image/SP03.1.jpg', 'Hồng', 'XXL', 3, 100000.00),
(13, 'Satou', 'SP10', 'Áo khoác da nam', 'image/SP10.1.jpg', 'Nâu', 'XXL', 50, 120000.00),
(14, 'SATOU', 'SP06', 'Áo len nữ cổ lọ', 'image/SP06.1.jpg', 'Đỏ', 'XL', 3, 200000.00),
(15, 'Satou', 'SP10', 'Áo khoác da nam', 'image/SP10.1.jpg', 'Nâu', 'S', 4, 120000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinh`
--

CREATE TABLE `hinh` (
  `MaSP` varchar(10) NOT NULL,
  `Mau` varchar(20) DEFAULT NULL,
  `Hinh` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hinh`
--

INSERT INTO `hinh` (`MaSP`, `Mau`, `Hinh`) VALUES
('SP01', 'Trắng', 'img/SP01.1.jpg'),
('SP01', 'Đen', 'img/SP01.2.jpg'),
('SP01      ', 'Xám đốm', 'img/SP01.3.jpg'),
('SP01', 'Be nhạt', 'img/SP01.4.jpg'),
('SP01', NULL, 'img/SP01.5.jpg'),
('SP02', 'Xanh nhạt', 'img/SP02.1.jpg'),
('SP02', 'Xanh', 'img/SP02.2.jpg'),
('SP02', 'Đen', 'img/SP02.3.jpg'),
('SP03', 'Vàng', 'img/SP03.1.jpg'),
('SP03', 'Hồng', 'img/SP03.2.jpg'),
('SP03', 'Trắng', 'img/SP03.3.jpg'),
('SP03', NULL, 'img/SP03.4.jpg'),
('SP04', 'Xanh', 'img/SP04.1.jpg'),
('SP04      ', 'Đỏ', 'img/SP04.2.jpg'),
('SP04', 'Đen', 'img/SP04.3.jpg'),
('SP04', 'Xanh cổ vịt', 'img/SP04.4.jpg'),
('SP04', NULL, 'img/SP04.5.jpg'),
('SP05', 'Trắng', 'img/SP05.1.jpg'),
('SP05', NULL, 'img/SP05.2.jpg'),
('SP06', 'Trắng', 'img/SP06.1.jpg'),
('SP06', 'Đen', 'img/SP06.2.jpg'),
('SP06     ', 'Đỏ', 'img/SP06.3.jpg'),
('SP06      ', NULL, 'img/SP06.4.jpg'),
('SP07', NULL, 'img/SP07.1.jpg'),
('SP07', 'Đen', 'img/SP07.2.jpg'),
('SP07', 'Xám', 'img/SP07.3.jpg'),
('SP08', 'Vàng', 'img/SP08.1.jpg'),
('SP08', '', 'img/SP08.2.jpg'),
('SP08', 'Hồng', 'img/SP08.3.jpg'),
('SP08', NULL, 'img/SP08.4.jpg'),
('SP09', 'Nâu', 'img/SP09.1.jpg'),
('SP09', '', 'img/SP09.2.jpg'),
('SP09', NULL, 'img/SP09.3.jpg'),
('SP10', NULL, 'img/SP10.1.jpg'),
('SP10', 'Đen', 'img/SP10.2.jpg'),
('SP10', 'Nâu', 'img/SP10.3.jpg'),
('SP10', 'Xanh', 'img/SP10.4.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `TaiKhoan` varchar(20) NOT NULL,
  `MatKhau` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `SoDienThoai` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`TaiKhoan`, `MatKhau`, `Email`, `SoDienThoai`) VALUES
('Satou', '0969959804', 'annguyenduc369@gmail,com', '0862638140'),
('john_doe', 'password12', 'john.doe@example.com', '0123456789'),
('jane_smith', 'securepass', 'jane.smith@example.com', '0987654321'),
('alice_wonder', 'wonderland', 'alice.wonder@example.com', '0112233445'),
('bob_builder', 'buildit', 'bob.builder@example.com', '0998877665'),
('charlie_brown', 'peanuts', 'charlie.brown@example.com', '0123987654'),
('david_tennant', 'doctorwho', 'david.tennant@example.com', '0123456786'),
('emily_blunt', 'quietplace', 'emily.blunt@example.com', '0987654322'),
('frank_underwood', 'houseofcards', 'frank.underwood@example.com', '0112233446'),
('grace_hopper', 'computerscience', 'grace.hopper@example.com', '0998877666'),
('harry_potter', 'hogwarts', 'harry.potter@example.com', '0123987655'),
('isaac_newton', 'gravity', 'isaac.newton@example.com', '0123456787');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` char(10) NOT NULL,
  `MatKhau` varchar(50) NOT NULL,
  `TenNV` varchar(50) NOT NULL,
  `GT` varchar(50) NOT NULL,
  `CCCD` char(12) NOT NULL,
  `NamSinh` date NOT NULL,
  `SDT` char(10) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `MatKhau`, `TenNV`, `GT`, `CCCD`, `NamSinh`, `SDT`, `Email`) VALUES
('NV001', 'password123', 'Nguyễn Văn A', 'Nam', '123456789012', '1990-05-10', '0987654321', 'nguyenvana@gmail.com'),
('NV002', 'securepass', 'Trần Thị B', 'Nữ', '234567890123', '1985-11-20', '0912345678', 'tranthib@yahoo.com'),
('NV003', 'wonderland', 'Lê Minh C', 'Nam', '345678901234', '1992-02-15', '0901234567', 'leminhc@gmail.com'),
('NV004', 'buildit', 'Phan Thị D', 'Nữ', '456789012345', '1995-07-25', '0976543210', 'phanthid@hotmail.com'),
('NV005', 'domainpass', 'Ngô Thị F', 'Nữ', '678901234567', '1993-01-05', '0945678901', 'ngothif@domain.com'),
('NV006', 'buildit', 'Hoàng Văn G', 'Nam', '789012345678', '1991-04-12', '0961234567', 'hoangvang@mail.com'),
('NV007', 'securepass', 'Đặng Thị H', 'Nữ', '890123456789', '1994-03-18', '0916543210', 'dangthih@gmail.com'),
('NV008', 'buildit', 'Bùi Minh I', 'Nam', '901234567890', '1989-10-22', '0954321098', 'buiminhi@yahoo.com'),
('NV009', 'domainpass', 'Dương Thị K', 'Nữ', '012345678901', '1996-12-30', '0923456789', 'duongthik@domain.com'),
('NV010', 'securepass', 'Vũ Minh E', 'Nam', '567890123456', '1988-09-30', '0934567890', 'vuminhe@outlook.com'),
('School', '123456', 'Trường', 'Nam', '123456789456', '0000-00-00', '0123456789', 'truongdien@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` varchar(10) NOT NULL,
  `TenSP` varchar(50) NOT NULL,
  `MoTa` varchar(1000) NOT NULL,
  `Gia` int(11) NOT NULL,
  `GioiTinh` varchar(10) NOT NULL,
  `PhanLoai` varchar(20) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `luotmua` int(11) DEFAULT NULL,
  `S` tinyint(1) DEFAULT NULL,
  `L` tinyint(1) DEFAULT NULL,
  `XL` tinyint(1) DEFAULT NULL,
  `XXL` tinyint(1) DEFAULT NULL,
  `SLDaBan` int(11) DEFAULT NULL,
  `SLConLai` int(11) DEFAULT NULL,
  `MauSac` varchar(50) DEFAULT '',
  `Video` text DEFAULT '',
  `Anh` text DEFAULT '',
  `SoLuong` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `MoTa`, `Gia`, `GioiTinh`, `PhanLoai`, `img`, `luotmua`, `S`, `L`, `XL`, `XXL`, `SLDaBan`, `SLConLai`, `MauSac`, `Video`, `Anh`, `SoLuong`) VALUES
('SP01', 'Áo thun nam Basic', 'Áo thun nam cổ tròn, thiết kế đơn giản nhưng tinh tế. Chất liệu cotton mềm mại, thấm hút mồ hôi, phù hợp với nhiều phong cách từ đi chơi đến đi làm.', 100000, 'Nam', 'Áo', 'img/SP01.1.jpg', 640, 1, 1, 1, 1, 576, 13, '', '', '', 0),
('SP02', 'Quần jeans nữ rách gối', 'Quần jeans nữ với thiết kế rách gối thời trang, mang đến phong cách cá tính, năng động. Chất liệu denim co giãn nhẹ, thoải mái trong mọi hoạt động. Lý tưởng cho các buổi đi chơi hay dạo phố.', 150000, 'Nữ', 'Quần', 'img/SP02.1.jpg', 980, 1, 1, 1, 1, 337, 643, '', '', '', 0),
('SP03', 'Áo khoác dạ nữ dài', 'Áo khoác dạ nữ dài, thiết kế thanh lịch và ấm áp. Chất liệu vải dạ cao cấp giúp giữ nhiệt tốt, phù hợp với những ngày đông lạnh giá. Dễ dàng kết hợp với nhiều loại trang phục.', 100000, 'Nữ', 'Áo Khoác', 'img/SP03.1.jpg', 979, 1, 1, 1, 1, 203, 86, '', '', '', 0),
('SP04', 'Chân váy xòe midi', 'Chân váy xòe midi với phần chân váy rộng, tạo sự thoải mái khi di chuyển. Thiết kế đơn giản nhưng tinh tế, dễ dàng phối hợp với áo sơ mi hay áo phông. Chất liệu vải mềm mại, dễ chịu.', 100000, 'Nữ', 'Váy', 'img/SP04.1.jpg', 958, 1, 1, 1, 1, 819, 839, '', '', '', 0),
('SP05', 'Áo sơ mi nam cổ điển', 'Áo sơ mi nam cổ điển, chất liệu vải cotton mát mẻ, thoáng khí, mang đến sự lịch lãm và thoải mái. Phù hợp cho cả môi trường công sở lẫn những buổi tiệc tối sang trọng.', 100000, 'Nam', 'Áo', 'img/SP05.1.jpg', 851, 1, 1, 1, 1, 736, 165, '', '', '', 0),
('SP06', 'Áo len nữ cổ lọ', 'Áo len nữ cổ lọ dày dặn, giữ ấm tuyệt vời trong mùa đông. Chất liệu len mềm mại, không gây ngứa, thích hợp để mặc cùng quần jeans hoặc váy ngắn. Thiết kế cổ lọ giúp bảo vệ vùng cổ khỏi lạnh.', 200000, 'Nữ', 'Áo Len', 'img/SP06.1.jpg', 881, 1, 1, 1, 1, 614, 574, '', '', '', 0),
('SP07', 'Quần short nam thể thao', 'Quần short nam thể thao, phù hợp cho các hoạt động thể dục thể thao hoặc đi dạo. Chất liệu vải thoáng khí, co giãn tốt, giúp người mặc dễ dàng vận động. Thiết kế tối giản nhưng năng động.', 250000, 'Nam', 'Quần', 'img/SP07.1.jpg', 853, 1, 1, 1, 1, 27, 414, '', '', '', 0),
('SP08', 'Áo phông nữ tay lỡ', 'Áo phông nữ tay lỡ với thiết kế hiện đại, trẻ trung. Chất liệu cotton mềm mại, dễ chịu, phù hợp cho các buổi hẹn hò, đi dạo hoặc ở nhà. Có nhiều màu sắc và họa tiết để lựa chọn.', 100000, 'Nữ', 'Áo', 'img/SP08.1.jpg', 625, 1, 1, 1, 1, 988, 696, '', '', '', 0),
('SP09', 'Váy đầm suông dáng dài', 'Váy đầm suông dáng dài nữ tính, phù hợp cho những buổi dạo phố hoặc đi tiệc. Chất liệu vải nhẹ, thoáng khí, tạo cảm giác thoải mái cho người mặc. Phù hợp với nhiều dáng người.', 300000, 'Nữ', 'Váy', 'img/SP09.1.jpg', 564, 1, 1, 1, 1, 517, 496, '', '', '', 0),
('SP10', 'Áo khoác da nam', 'Áo khoác da nam sang trọng, thời trang, chất liệu da cao cấp. Thiết kế mạnh mẽ và nam tính, phù hợp với phong cách cá nhân nổi bật.', 120000, 'Nam', 'Áo Khoác', 'img/SP10.1.jpg', 945, 1, 1, 1, 1, 928, 150, '', '', '', 0);

--
-- Bẫy `sanpham`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_MaSP` BEFORE INSERT ON `sanpham` FOR EACH ROW BEGIN
    DECLARE next_id INT;
    DECLARE next_MaSP VARCHAR(10);
    
    -- Lấy giá trị lớn nhất hiện tại từ MaSP
    SELECT COALESCE(MAX(CAST(SUBSTRING(MaSP, 3) AS UNSIGNED)), 0) + 1 INTO next_id FROM SanPham;
    
    -- Sinh giá trị MaSP dạng SP01, SP02,...
    SET next_MaSP = CONCAT('SP', LPAD(next_id, 2, '0'));
    
    -- Gán giá trị cho cột MaSP
    SET NEW.MaSP = next_MaSP;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_MaSP_after_update` AFTER UPDATE ON `sanpham` FOR EACH ROW BEGIN
    UPDATE xuly
    SET MaSP = NEW.MaSP
    WHERE TenSP = NEW.TenSP;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xuly`
--

CREATE TABLE `xuly` (
  `ID` int(11) NOT NULL,
  `TenDangNhap` varchar(255) DEFAULT NULL,
  `MaSP` varchar(10) DEFAULT NULL,
  `TenSP` varchar(255) DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `Mau` varchar(50) DEFAULT NULL,
  `Size` varchar(50) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `Gia` int(11) DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT 'Đang xử lý',
  `NgayTao` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `xuly`
--

INSERT INTO `xuly` (`ID`, `TenDangNhap`, `MaSP`, `TenSP`, `HinhAnh`, `Mau`, `Size`, `SoLuong`, `Gia`, `TrangThai`, `NgayTao`) VALUES
(49, 'WILFRED', 'SP03', 'Áo khoác dạ nữ dài', 'http://localhost/FSS/image/SP03.1.jpg', NULL, 'XXL', 3, 100000, 'Chưa xác nhận', '2024-12-16 19:54:28'),
(50, 'WILFRED', 'SP08', 'Áo phông nữ tay lỡ', 'http://localhost/FSS/image/SP08.1.jpg', NULL, 'L', 3, 100000, 'Chưa xác nhận', '2024-12-16 19:55:44'),
(51, 'Satou', 'SP10', 'Áo khoác da nam', 'http://localhost/FSS/image/SP10.1.jpg', NULL, 'XXL', 50, 120000, 'Chưa xác nhận', '2024-12-17 02:32:33'),
(52, 'Satou', 'SP06', 'Áo len nữ cổ lọ', 'http://localhost/FSS/image/SP06.1.jpg', NULL, 'XL', 3, 200000, 'Chưa xác nhận', '2024-12-17 02:32:33'),
(53, 'Satou', 'SP10', 'Áo khoác da nam', 'http://localhost/FSS/image/SP10.1.jpg', NULL, 'XXL', 50, 120000, 'Chưa xác nhận', '2024-12-17 02:41:06'),
(48, 'WILFRED', 'SP06', 'Áo len nữ cổ lọ', 'http://localhost/FSS/image/SP06.1.jpg', NULL, 'L', 0, 200000, 'Chưa xác nhận', '2024-12-16 19:53:30'),
(46, 'WILFRED', 'SP08', 'Áo phông nữ tay lỡ', 'http://localhost/FSS/image/SP08.1.jpg', NULL, 'L', 3, 100000, 'Chưa xác nhận', '2024-12-16 19:39:25'),
(47, 'WILFRED', 'SP07', 'Quần short nam thể thao', 'http://localhost/FSS/image/SP07.1.jpg', NULL, 'XXL', 2, 250000, 'Chưa xác nhận', '2024-12-16 19:39:25');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `donhang2`
--
ALTER TABLE `donhang2`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_GioHang_SanPham` (`MaSP`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`);

--
-- Chỉ mục cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `xuly`
--
ALTER TABLE `xuly`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `donhang2`
--
ALTER TABLE `donhang2`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `xuly`
--
ALTER TABLE `xuly`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
