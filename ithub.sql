CREATE DATABASE `ithub`;

USE `ithub`;

--Create Table

CREATE TABLE `TblNguoiDung` (
  `taiKhoan` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `matKhau` varchar(100) NOT NULL,
  `quyen` ENUM('quantrivien', 'nguoidung', 'nguoidungbichan') NOT NULL DEFAULT 'nguoidung',
  `hoND` varchar(100) NOT NULL,
  `tenND` varchar(255) NOT NULL,
  `ngaySinh` date NOT NULL,
  `anhDaiDien` varchar(255) NOT NULL DEFAULT 'user.png',
  `xacThuc`ENUM('daxacminh', 'chuaxacminh') NOT NULL DEFAULT 'chuaxacminh',
  `trangThai`ENUM('hoatdong', 'ban', 'dunghoatdong') NOT NULL DEFAULT 'dunghoatdong'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tblnguoidung` (`taiKhoan`, `email`, `matKhau`, `quyen`, `hoND`, `tenND`, `ngaySinh`, `anhDaiDien`, `xacThuc`, `trangthai`) VALUES
('kabee', 'kiet.nt.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Nguyễn', 'Tuấn Kiệt', '2002-09-08', 'kabee.jpg', 'daxacminh', 'dunghoatdong'),
('hienhuynh', 'hien.ht.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'quantrivien', 'Huỳnh', 'Thanh Hiền', '2002-09-25', 'thanhhien.jpg', 'daxacminh', 'dunghoatdong'),
('phuongha', 'ha.ptp.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'quantrivien', 'Phan', 'Thị Phương Hà', '2002-01-21', 'phuongha.jpg', 'daxacminh', 'dunghoatdong'),
('ducnhong', 'nhong.nnd.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'quantrivien', 'Nguyễn', 'Ngọc Đức Nhông', '2002-01-21', 'nuno.jpg', 'daxacminh', 'dunghoatdong'),
('thienlan', 'lan.pnt.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidungbichan', 'Phạm', 'Nguyễn Thiên Lân', '2002-12-23', 'thienlan.jpg', 'daxacminh', 'dunghoatdong'),
('quantri', 'ithub.@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'quantrivien', 'Quản', 'Trị Viên', '2002-09-08', 'quantri.jpg', 'daxacminh', 'hoatdong');;

CREATE TABLE `TblLoaiViPham` (
  `maLoaiVP` varchar(10) NOT NULL,
  `tenLoaiVP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `TblLoaiViPham` (`maLoaiVP`, `tenLoaiVP`) VALUES
('VP00000001', 'Quấy rối bắt nạt qua mạng'),
('VP00000002', 'Spam'),
('VP00000003', 'Ngôn từ gây thù ghét'),
('VP00000004', 'Bán hàng trái phép'),
('VP00000005', 'Nội dung khiêu dâm');

CREATE TABLE `TblLoaiTaiLieu` (
  `maLoaiTL` varchar(10) NOT NULL,
  `tenLoaiTL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tblloaitailieu` (`maLoaiTL`, `tenLoaiTL`) VALUES 
('PLTL000001', 'Cơ sở dữ liệu'),  
('PLTL000002', 'Lập trình'), 
('PLTL000003', 'Đồ án');

CREATE TABLE `TblDinhDangTL` (
  `maDD` varchar(10) NOT NULL,
  `tenDD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `TblDinhDangTL`
	ADD PRIMARY KEY (`maDD`);

CREATE TABLE `TblTaiLieu` (
  `maTL` varchar(10) NOT NULL,
  `maLoaiTL` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL,
  `maDD` varchar(10) NOT NULL,
  `tenTL` varchar(255) NOT NULL,
  `moTaTL` text NOT NULL,
  `fileTL` varchar(255) NOT NULL,
  `ngayDangTL` datetime NOT NULL DEFAULT current_timestamp(),
  `ngayDuyetTL` datetime NULL,
  `anhTL` varchar(255) NOT NULL,
  `trangThaiTL` ENUM('daduyet', 'chuaduyet') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TblTLYeuThich` (
  `maTL` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TblTLViPham` (
  `maTL` varchar(10) NOT NULL,
  `maLoaiVP` varchar(10) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TblChuDeBV` (
  `maCD` varchar(10) NOT NULL,
  `tenCD` varchar(255) NOT NULL,
  `anhCD` varchar(255) NOT NULL,
  `trangThaiCD` ENUM('khoa', 'hoatdong') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TblBaiViet` (
  `maBV` varchar(10) NOT NULL,
  `maCD` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL,
  `tenBV` varchar(255) NOT NULL,
  `noiDungBV` text NOT NULL,
  `trangThaiBV` ENUM('daduyet', 'chuaduyet', 'chinhsua', 'khoa') NOT NULL,
  `ngayDangBV` datetime NOT NULL DEFAULT current_timestamp(),
  `ngayDuyetBV` datetime NULL,
  `ngayChinhSuaBV` datetime NULL,
  `luotXem` bigint NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TblBVYeuThich` (
  `maBV` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TblBVViPham` (
  `maBV` varchar(10) NOT NULL,
  `maLoaiVP` varchar(10) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TblThongBao` (
  `maTB` INT(128) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL,
  `noiDungTB` text NOT NULL,
  `ngayDangTB` datetime NOT NULL DEFAULT current_timestamp(),
  `trangThaiTB` int(1) NOT NULL,
  `trangThaiXemTB` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--Primary Key

ALTER TABLE `TblTaiLieu`
	ADD PRIMARY KEY (`maTL`);

ALTER TABLE `TblNguoiDung`
	ADD PRIMARY KEY (`taiKhoan`);

ALTER TABLE `TblLoaiViPham`
	ADD PRIMARY KEY (`maLoaiVP`);

ALTER TABLE `TblLoaiTaiLieu`
	ADD PRIMARY KEY (`maLoaiTL`);

ALTER TABLE `TblBaiViet`
	ADD PRIMARY KEY (`maBV`);

ALTER TABLE `TblBVViPham`
	ADD PRIMARY KEY (`maBV`, `maLoaiVP`, `taiKhoan`);

ALTER TABLE `tblThongBao`
  ADD PRIMARY KEY (`maTB`);

ALTER TABLE `tblThongBao`
  MODIFY `maTB` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
