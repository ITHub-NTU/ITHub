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

INSERT INTO `tbldinhdangtl` (`maDD`, `tenDD`) VALUES 
('DD00000001', 'PPTX'), 
('DD00000002', 'PDF'), 
('DD00000003', 'DOCX');

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

INSERT INTO TblTaiLieu (maTL, maLoaiTL, taiKhoan, maDD, tenTL, moTaTL, fileTL, ngayDangTL, ngayDuyetTL, anhTL, trangThaiTL)
VALUES
 ('TL00000001', 'PLTL000001', 'kabee', 'DD00000002', 'Giáo trình hệ quản trị cơ sở dữ liệu', 'Các trúc này bao gồm ít nhất một tập tin dữ liệu (data file) và một tập tin viết thao tác (transaction log file). Hiểu cách thức Microsoft SQL Server.', 'upload-tailieu/hqtcsdl.pdf','2023-09-21 08:45:23', '2023-10-08 08:50:23', 'hqtcsdl.jpg', 'daduyet'),

 ('TL00000002', 'PLTL000002', 'kabee', 'DD00000002', 'Hướng dẫn lập trình Python', 'Hướng dẫn lập trình Python từ cơ bản đến nâng cao. Bao gồm ví dụ và bài tập thực hành.', 'upload-tailieu/python.pdf', '2023-09-21 08:45:23', '2023-10-08 08:50:23', 'python.jpg', 'daduyet'),

 ('TL00000003', 'PLTL000003', 'kabee', 'DD00000002', 'Đồ án môn Toán rời rạc', 'Bài tập và đồ án môn Toán rời rạc cho sinh viên ngành Công nghệ thông tin.', 'upload-tailieu/trr.pdf','2023-09-21 08:45:23', '2023-10-08 08:50:23', 'trr.jpg', 'daduyet');

CREATE TABLE `TblTLYeuThich` (
  `maTL` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `TblTLYeuThich` (`maTL`, `taiKhoan`) VALUES
('TL00000001', 'ducnhong'),
('TL00000001', 'hienhuynh'),
('TL00000001', 'kabee'),
('TL00000002', 'ducnhong'),
('TL00000002', 'phuongha'),
('TL00000003', 'kabee'),
('TL00000003', 'thienlan');

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

INSERT INTO `TblChuDeBV` (`maCD`, `tenCD`, `anhCD`, `trangThaiCD`) VALUES 
('CD00000001', 'Lập trình', 'chude1.png', 'hoatdong'), 
('CD00000002', 'Android', 'chude2.png', 'khoa'), 
('CD00000003', 'Thủ thuật', 'chude3.png', 'hoatdong');

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

INSERT INTO `TblBaiViet` (`maBV`, `maCD`, `taiKhoan`, `tenBV`, `noiDungBV`, `trangThaiBV`, `ngayDangBV`, `ngayDuyetBV`, `ngayChinhSuaBV`, `luotXem`) VALUES 
('BV00000001', 'CD00000001', 'kabee', 'Các lỗi thường gặp khi viết chương trình C/C++', 'Việc học lập trình không phải là chuyện đơn giản như nói là có thể làm được mà nó là một quá trình tích lũy kinh nghiệm trên cơ sở thực hành thường xuyên. Những người mới bắt đầu với ngôn ngữ lập trình C/C++ thường gặp phải những lỗi làm họ sớm nản lòng, nhưng thực sự những lỗi đó có quá khó không? Phần này đưa ra một số lỗi cơ bản thường gặp phải đối với những ai mới bắt đầu học lập trình C/C++. 1. Quên khai báo các biến sử dụng trong chương trình (Undeclared Variables) Ví dụ: int main() { printf(x); scanf(“%d”,&x); } Chương trình trên bị lỗi vì trình biên dịch không biết x là cái gì. Chúng ta cần phải khai báo biến x. 2. Không khởi tạo giá trị cho biến (Uninitialized Variable) Ví dụ: int count; while(count<100) { printf(“%d”,count); } Khi thi hành, chương trình không in ra gì cả. Lý do là ở đoạn chương trình trên, biến count chưa được khởi tạo giá trị. Vì vậy khi chương trình chạy nó có thể là giá trị bất kỳ nào trong dãy các số nguyên (int). Có thể nó sẽ có giá trị là 586 chẳng hạn, vậy thì nó sẽ không vào trong vòng lặp while khiến cho kết quả chương trình bị sai, có thể chương trình sẽ in ra kết quả là các giá trị rác từ –1000 đến 99. 3. Thiết lập một biến với một giá trị chưa khởi tạo (Setting a variable to an uninitialized value) Ví dụ: int a, b; int sum=a+b; printf(“Enter two numbers to add: “); scanf(“%d”,&b); printf(“The sum is: %d”, sum); Khi chạy (RUN): Enter two numbers to add: 1 3 The sum is: -1393 Câu hỏi đặt ra: Có gì sai với chương trình trên? 1 http://www.cprogramming.com/tutorial/common.html Bài giảng Nhập môn lập trình Lê Thị Bích Hằng – ĐH Nha Trang 118 Khi chúng ta gán giá trị cho một biến, nó có giá trị đó cho đến khi nó được gán một giá trị khác. Trong chương trình ví dụ trên, bởi vì a, b không được khởi tạo giá trị nên tổng của chúng sẽ là một giá trị rác ngẫu nhiên. Có thể sửa chương trình trên như sau: int a, b; int sum; printf(“Enter two numbers to add: “); scanf(“%d%d”,&a, &b); sum=a+b; printf(“The sum is: %d”, sum); 4. Sử dụng một dấu bằng trong phép so sánh (Using a single equal sign to check equality) Ví dụ: char x=\'Y\'; while(x=\'Y\') { //... printf(\"Continue? (Y/N)\"); x=getche(); } Câu hỏi đặt ra: Tại sao vòng lặp này không bao giờ kết thúc? Nếu sử dụng một dấu bằng trong phép so sánh, chương trình thay vì so sánh giá trị bên trái có đúng với giá trị bên phải hay không thì nó sẽ thực hiện phép gán giá trị bên phải cho bên trái, và phép gán này tất nhiên trả về giá trị TRUE. Do đó vòng lặp không bao giờ kết thúc. Do đó chúng ta nên nhớ sử dụng == cho phép so sánh của mình. Và lời khuyên trong trường hợp này là nên đặt biến phía bên phải giá trị để cho chương trình báo lỗi thay vì thực hiện một vòng lặp vô hạn. Chương trình có thể viết lại như sau: char x=\'Y\'; while(\'Y\'==x) { //... printf(\"Continue? (Y/N)\"); x=getche(); } 5. Không khai báo hàm (Undeclared function) Ví dụ: int main() { menu(); } void menu(){ //...} Câu hỏi đặt ra: Chương trình trên đã xảy ra lỗi gì? Trình biên dịch không biết hàm menu() được khai báo trong hàm main() là gì. Lý do là hàm menu() được dịnh nghĩa phía dưới hàm main(). Do đó hàm menu() nên được đặt phía trên hàm main(), hoặc ta có thể sử dụng một khai báo nguyên mẫu (prototype ) cho hàm menu() nếu muốn định nghĩa nó bên dưới hàm main(), như ví dụ dưới đây: Bài giảng Nhập môn lập trình Lê Thị Bích Hằng – ĐH Nha Trang 119 void menu(); int main() { menu(); } void menu(){ ...} 6. Thừa dấu chấm phẩy (Extra semicolons) Ví dụ: int x; for(x=0; x<100; x++); printf(“%d5”,x); Tất nhiên kết quả chương trình đưa ra không phải là các số từ 1 đến 100. Bởi vì trong chương trình trên thừa một dấu chấm phẩy (;) sau vòng lặp for. Nếu chúng ta đặt thừa một dấu chấm phẩy ở bất kỳ nơi nào trong chương trình thì thì rất có thể chương trình sẽ báo lỗi. 7. Vượt quá giới hạn của mảng (Overstepping array boundaries) Ví dụ: int array[10]; //... for(int x=1; x<=10; x++) printf(“%d”,array[x]); Câu hỏi đặt ra: Tại sao chương trình chạy ra có kết quả không đúng? Trong C/C++, một mảng khi khai báo sẽ bắt đầu từ phần tử số 0 chứ không phải là số 1, và kết thúc sẽ là độ dài của mảng khai báo trừ đi 1. Chương trình trên sửa lại như sau: int array[10]; //... for(int x=0; x<10; x++) printf(“%d”,array[x]); 8. Lạm dụng các toán tử && và || (Misusing the && and || operator) Ví dụ: int value; do { //... value=10; } while(!(value==10) || !(value==20)) Câu hỏi đặt ra: Tại sao giá trị value bằng 10 mà vòng lặp vẫn chạy? Nên nhớ công thức của hàm Boolean là: !(A || B) tương đương với !A && !B. Do đó chương trình đúng sẽ là: int value; do { //... value=10; }while(!(value==10) && !(value==20))', 'daduyet', '2023-10-10 17:37:21', '2023-10-10 22:37:21', NULL, 1),
('BV00000002', 'CD00000002', 'hienhuynh', 'Những app, thủ thật khi dùng điện thoại Android', '1. NextDNS : Dịch vụ dns này bảo vệ mình khỏi các mối đe dọa bảo mật, chặn quảng cáo và các trình theo dõi trên các trang web và cả trong ứng dụng. Có máy chủ tại Việt Nam nên tốc độ mạng tốt hơn nhiều. Spoiler: Dùng NextDNS được tài trợ bởi Hostsvn2. Cromite : Trình duyệt yêu thích của mình những ngày gần đây. Nhanh, mượt, bảo mật, riêng tư, mã nguồn mở là những đặc điểm của em nó. Có adblock tích hợp sẵn. 3. InnerTune : Mới phát hiện ra ngày hôm qua. Ứng dụng rất mượt, phát nhạc từ Youtube/YT Music mà ko có quảng cáo. Trải nghiệm khá giống Apple Music mình đang dùng. 4. Proton VPN : Một trong những VPN được đánh giá tốt nhất về tính riêng tư, bảo mật. Ứng dụng miễn phí tới 3 servers (Japan, Netherlands, U.S) 5. HDFLIX : App xem film lậu khá tốt với chất lượng xem HD. Mình đang xem bộ One Piece người đóng qua đây. 6. AntennaPod : Ứng dụng nghe podcast tổng hợp từ toàn bộ các nguồn. Như mình đang theo dõi một kênh chỉ post lên Apple Podcast nên khá bất tiện khi máy chỉ có Spotify Podcast.', 'daduyet', '2023-10-10 17:37:21', '2023-10-11 17:37:21', NULL, 0),
('BV00000003', 'CD00000003', 'kabee', 'Hướng dẫn FIX lỗi tối màn 3 phút của Laptop CoffeeLake khi khởi động và lỗi Wifi/ Bluetooth của card Intel / Broadcom trên macOS 13.4', '1. Fix lỗi blacklight gây tối màn 3 phút khi khởi động của Laptop CoffeeLake trên macOS 13.4​ Lỗi này hiện tại chỉ 13.4 bị. 13.5 Beta và dưới 13.4 không bị Bước 1 : Update kext lên bản mới nhất Bước 2 : Mở config.plist. Xoá boot-args -igfxblr và enable-backlight-registers-fix ở device-properties Bước 3 : Thêm vào boot-args: -igfxblt Bước 4 : Restart ----------------------------------------------------- 2. Fix lỗi Wifi/ Bluetooth trên macOS 13.4+​ Như các bác đã biết, macOS 13.4+ có nhiều lỗi liên quan đến Wifi và Bluetooth. Và đây dưới đây là cách fix cho cả intel và broadcom Đối với card Intel​ Bước 1 : Tải kext mới nhất cho Wifi : Tải ở đây . Bước 2 : Tải kext mới nhất cho Bluetooth: Tải ở đây và ở đây. Bước 3 : Giải nén. Sau đó copy Airportitlwm và IntelBluetoothFirmware + BlueToolFixup.kext vào thư mục EFI/OC/kexts Buớc 4 : Mở config.plist bằng Propertree. Tìm đến NVRAM >> Add >> 7C436110-AB2A-4BBB-A880-FE41995C9F82 và thêm 2 key như sau : bluetoothInternalControllerInfo <data> 00000000 00000000 00000000 0000 bluetoothExternalDongleFailed <data> 00 Bước 5. Tìm đến NVRAM >> Delete >> 7C436110-AB2A-4BBB-A880-FE41995C9F82 và thêm 2 key với value như sau : bluetoothInternalControllerInfo bluetoothExternalDongleFailed Ví dụ phần config trên: Tại đây Bước 6 . Sau đó bấm Ctrl + R Chọn thư mục EFI/OC ➝ Select Folder. Sau khi xong bấm Ctrl + S để Save config. Bước 7 : Restart ----------------------------------------------------- Đối với card Broadcom​ Bước 1 : Tải kext mới nhất cho Wifi : Tải ở đây Nếu wifi hoạt động bình thường thì không cần thêm kext cho Wifi Bước 2 : Tải kext mới nhất cho Bluetooth : Tải ở đây Bước 3 : Giải nén, copy kext AirportBrcmFixup ( nếu card wifi của bạn cần ) và BlueToolFixup + BrcmPatchRAM3.kext + BrcmFirmwareData.kext vào thư mục EFI/OC/kexts Bước 4 : Mở config.plist, thêm: -btlfxallowanyaddr vào boot-args. Buớc 5 : Mở config.plist bằng Propertree. Tìm đến NVRAM >> Add >> 7C436110-AB2A-4BBB-A880-FE41995C9F82 và thêm 2 key như sau: bluetoothInternalControllerInfo <data> 00000000 00000000 00000000 0000 bluetoothExternalDongleFailed <data> 00 Bước 6 : Tìm đến NVRAM >> Delete >> 7C436110-AB2A-4BBB-A880-FE41995C9F82 và thêm 2 key với value như sau : bluetoothInternalControllerInfo bluetoothExternalDongleFailed Ví dụ phần config trên: Tại đây Bước 7 : Sau đó bấm Ctrl + R Chọn thư mục EFI/OC ➝ Select Folder. Sau khi xong bấm Ctrl + S để Save config. Bước 8 : Restart ----------------------------------------------------- Good luck !', 'chuaduyet', '2023-10-11 17:37:21', '2023-10-13 17:37:21', NULL, 1);

CREATE TABLE `TblBVYeuThich` (
  `maBV` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `TblBVYeuThich` (`maBV`, `taiKhoan`) VALUES
('BV00000001', 'ducnhong'),
('BV00000001', 'kabee'),
('BV00000001', 'phuongha'),
('BV00000002', 'hienhuynh'),
('BV00000002', 'kabee'),
('BV00000002', 'thienlan'),
('BV00000003', 'phuongha'),
('BV00000003', 'thienlan');

CREATE TABLE `TblBVViPham` (
  `maBV` varchar(10) NOT NULL,
  `maLoaiVP` varchar(10) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TblThaoLuanBV` (
  `maTLBV` varchar(10) NOT NULL,
  `maBV` varchar(10) NOT NULL,
  `maPhanHoi` varchar(10) NOT NULL DEFAULT '0',
  `taiKhoan` varchar(50) NOT NULL,
  `noiDungTLBV` text NOT NULL,
  `trangThaiTLBV` ENUM('dadang', 'chinhsua', 'khoa') NOT NULL,
  `ngayDangTLBV` datetime NOT NULL DEFAULT current_timestamp(),
  `ngayChinhSuaTLBV` datetime NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `TblThaoLuanBV` (`maTLBV`, `maBV`, `maPhanHoi`, `taiKhoan`, `noiDungTLBV`, `trangThaiTLBV`, `ngayDangTLBV`, `ngayChinhSuaTLBV`) VALUES
('TL00000001', 'BV00000001', '0',	'kabee',	'Làm thế nào để xác định lỗi "segmentation fault" trong chương trình C của bạn?',	'chinhsua',	'2023-10-08 08:45:23',	'2023-10-08 10:28:56'),
('TL00000002',	'BV00000001',	'TL00000001',	'kabee',	'Để xác định lỗi "segmentation fault" trong chương trình C của bạn, bạn nên sử dụng các công cụ như GDB hoặc Valgrind để gỡ lỗi và xem thông báo lỗi chi tiết.',	'dadang',	'2023-10-09 10:27:43',	NULL);


CREATE TABLE `TblTLBVViPham` (
  `maTLBV` varchar(10) NOT NULL,
  `maLoaiVP` varchar(10) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TblQuanTriTL` (
  `maQuanTri` varchar(50) NOT NULL,
  `maLoaiTL` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `TblQuanTriTL` (`maQuanTri`, `maLoaiTL`)
VALUES
('kabee', 'PLTL000001'),
('kabee', 'PLTL000002'),
('kabee', 'PLTL000003');

CREATE TABLE `TblQuanTriBV` (
  `maQuanTri` varchar(50) NOT NULL,
  `maCD` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `TblQuanTriBV` (`maQuanTri`, `maCD`)
VALUES
('kabee', 'CD00000001'),
('kabee', 'CD00000002'),
('kabee', 'CD00000003');

CREATE TABLE `TblTheoDoiChuDe` (
  `taiKhoan` varchar(10) NOT NULL,
  `maCD` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `TblTheoDoiChuDe` (`taiKhoan`, `maCD`)
VALUES
('kabee', 'CD00000001'),
('hienHuynh', 'CD00000002'),
('kabee', 'CD00000003');

CREATE TABLE `TblThongBao` (
  `maTB` INT(128) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL,
  `noiDungTB` text NOT NULL,
  `ngayDangTB` datetime NOT NULL DEFAULT current_timestamp(),
  `trangThaiTB` int(1) NOT NULL,
  `trangThaiXemTB` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--Primary Key

ALTER TABLE `TblNguoiDung`
	ADD PRIMARY KEY (`taiKhoan`);

ALTER TABLE `TblLoaiViPham`
	ADD PRIMARY KEY (`maLoaiVP`);

ALTER TABLE `TblLoaiTaiLieu`
	ADD PRIMARY KEY (`maLoaiTL`);

ALTER TABLE `TblDinhDangTL`
	ADD PRIMARY KEY (`maDD`);

ALTER TABLE `TblTaiLieu`
	ADD PRIMARY KEY (`maTL`);

ALTER TABLE `TblTLYeuThich`
	ADD PRIMARY KEY (`maTL`, `taiKhoan`);

ALTER TABLE `TblTLViPham`
	ADD PRIMARY KEY (`maTL`, `maLoaiVP`, `taiKhoan`);

ALTER TABLE `TblChuDeBV`
	ADD PRIMARY KEY (`maCD`);

ALTER TABLE `TblBaiViet`
	ADD PRIMARY KEY (`maBV`);

ALTER TABLE `TblBVYeuThich`
	ADD PRIMARY KEY (`maBV`, `taiKhoan`);

ALTER TABLE `TblBVViPham`
	ADD PRIMARY KEY (`maBV`, `maLoaiVP`, `taiKhoan`);

ALTER TABLE `tblThongBao`
  ADD PRIMARY KEY (`maTB`);

ALTER TABLE `tblThongBao`
  MODIFY `maTB` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `TblThaoLuanBV`
	ADD PRIMARY KEY (`maTLBV`);
ALTER TABLE `TblTLBVViPham`
	ADD PRIMARY KEY (`maTLBV`, `maLoaiVP`, `taiKhoan`);

ALTER TABLE `TblQuanTriTL`
	ADD PRIMARY KEY (`maQuanTri`, `maLoaiTL`);

ALTER TABLE `TblQuanTriBV`
	ADD PRIMARY KEY (`maQuanTri`, `maCD`);

ALTER TABLE `TblTheoDoiChuDe`
	ADD PRIMARY KEY (`taiKhoan`, `maCD`);

--Foreign Key

ALTER TABLE `TblTaiLieu`
	ADD CONSTRAINT `fk_TblLoaiTaiLieu_maLoaiTL_TblTaiLieu`
	FOREIGN KEY (`maLoaiTL`) REFERENCES `TblLoaiTaiLieu` (`maLoaiTL`),
	ADD CONSTRAINT `fk_TblDinhDangTL_maDD_TblTaiLieu`
	FOREIGN KEY (`maDD`) REFERENCES `TblDinhDangTL` (`maDD`),
	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTaiLieu`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`);
ALTER TABLE `TblTLYeuThich`
	ADD CONSTRAINT `fk_TblTaiLieu_maTL_TblTLYeuThich`
	FOREIGN KEY (`maTL`) REFERENCES `TblTaiLieu` (`maTL`),
	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTLYeuThich`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`);

ALTER TABLE `TblTLViPham`
	ADD CONSTRAINT `fk_TblTaiLieu_maTL_TblTLViPham`
	FOREIGN KEY (`maTL`) REFERENCES `TblTaiLieu` (`maTL`),
	ADD CONSTRAINT `fk_TblLoaiViPham_maLoaiVP_TblTLViPham`
	FOREIGN KEY (`maLoaiVP`) REFERENCES `TblLoaiViPham` (`maLoaiVP`),
  	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTLViPham`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`);

ALTER TABLE `TblBaiViet`
	ADD CONSTRAINT `fk_TblChuDeBV_maCD_TblBaiViet`
	FOREIGN KEY (`maCD`) REFERENCES `TblChuDeBV` (`maCD`),
	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblBaiViet`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`);

ALTER TABLE `TblBVYeuThich`
	ADD CONSTRAINT `fk_TblBaiViet_maTL_TblBVYeuThich`
	FOREIGN KEY (`maBV`) REFERENCES `TblBaiViet` (`maBV`),
	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblBVYeuThich`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`);

ALTER TABLE `TblBVViPham`
	ADD CONSTRAINT `fk_TblBaiViet_maBV_TblBVViPham`
	FOREIGN KEY (`maBV`) REFERENCES `TblBaiViet` (`maBV`),
	ADD CONSTRAINT `fk_TblLoaiViPham_maLoaiVP_TblBVViPham`
	FOREIGN KEY (`maLoaiVP`) REFERENCES `TblLoaiViPham` (`maLoaiVP`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblBVViPham`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`);

ALTER TABLE `TblThaoLuanBV`
	ADD CONSTRAINT `fk_TblBaiViet_maTL_TblThaoLuanBV`
	FOREIGN KEY (`maBV`) REFERENCES `TblBaiViet` (`maBV`),
	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblThaoLuanBV`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`);

ALTER TABLE `TblTLBVViPham`
	ADD CONSTRAINT `fk_TblThaoLuanBV_maTLBV_TblTLBVViPham`
	FOREIGN KEY (`maTLBV`) REFERENCES `TblThaoLuanBV` (`maTLBV`),
	ADD CONSTRAINT `fk_TblLoaiViPham_maLoaiVP_TblTLBVViPham`
	FOREIGN KEY (`maLoaiVP`) REFERENCES `TblLoaiViPham` (`maLoaiVP`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTLBVViPham`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`);;

ALTER TABLE `TblQuanTriTL`
	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblQuanTriTL`
	FOREIGN KEY (`maQuanTri`) REFERENCES `TblNguoiDung` (`taiKhoan`),
	ADD CONSTRAINT `fk_TblLoaiTaiLieu_maLoaiTL_TblQuanTriTL`
	FOREIGN KEY (`maLoaiTL`) REFERENCES `TblLoaiTaiLieu` (`maLoaiTL`);

ALTER TABLE `TblQuanTriBV`
	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblQuanTriBV`
	FOREIGN KEY (`maQuanTri`) REFERENCES `TblNguoiDung` (`taiKhoan`),
	ADD CONSTRAINT `fk_TblChuDeBV_maLoaiTL_TblQuanTriBV`
	FOREIGN KEY (`maCD`) REFERENCES `TblChuDeBV` (`maCD`);

ALTER TABLE `TblTheoDoiChuDe`
	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTheoDoiChuDe`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`),
	ADD CONSTRAINT `fk_TblChuDeBV_maLoaiTL_TblTheoDoiChuDe`
	FOREIGN KEY (`maCD`) REFERENCES `TblChuDeBV` (`maCD`);


ALTER TABLE `TblThongBao`
	ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblThongBao`
	FOREIGN KEY (`taiKhoan`) REFERENCES `TblNguoiDung` (`taiKhoan`);
