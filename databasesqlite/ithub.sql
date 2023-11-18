-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 18, 2023 lúc 06:42 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ithub`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblbaiviet`
--

CREATE TABLE `tblbaiviet` (
  `maBV` varchar(10) NOT NULL,
  `maCD` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL,
  `tenBV` varchar(255) NOT NULL,
  `noiDungBV` text NOT NULL,
  `trangThaiBV` enum('daduyet','chuaduyet','chinhsua','dachinhsua','khoa') NOT NULL,
  `ngayDangBV` datetime NOT NULL DEFAULT current_timestamp(),
  `ngayDuyetBV` datetime DEFAULT NULL,
  `ngayChinhSuaBV` datetime DEFAULT NULL,
  `luotXem` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblbaiviet`
--

INSERT INTO `tblbaiviet` (`maBV`, `maCD`, `taiKhoan`, `tenBV`, `noiDungBV`, `trangThaiBV`, `ngayDangBV`, `ngayDuyetBV`, `ngayChinhSuaBV`, `luotXem`) VALUES
('BV00000001', 'CD00000001', 'kabee', 'Các lỗi thường gặp khi viết chương trình C/C++', 'Việc học lập trình không phải là chuyện đơn giản như nói là có thể làm được mà nó là một quá trình tích lũy kinh nghiệm trên cơ sở thực hành thường xuyên. Những người mới bắt đầu với ngôn ngữ lập trình C/C++ thường gặp phải những lỗi làm họ sớm nản lòng, nhưng thực sự những lỗi đó có quá khó không? Phần này đưa ra một số lỗi cơ bản thường gặp phải đối với những ai mới bắt đầu học lập trình C/C++. 1. Quên khai báo các biến sử dụng trong chương trình (Undeclared Variables) Ví dụ: int main() { printf(x); scanf(“%d”,&x); } Chương trình trên bị lỗi vì trình biên dịch không biết x là cái gì. Chúng ta cần phải khai báo biến x. 2. Không khởi tạo giá trị cho biến (Uninitialized Variable) Ví dụ: int count; while(count<100) { printf(“%d”,count); } Khi thi hành, chương trình không in ra gì cả. Lý do là ở đoạn chương trình trên, biến count chưa được khởi tạo giá trị. Vì vậy khi chương trình chạy nó có thể là giá trị bất kỳ nào trong dãy các số nguyên (int). Có thể nó sẽ có giá trị là 586 chẳng hạn, vậy thì nó sẽ không vào trong vòng lặp while khiến cho kết quả chương trình bị sai, có thể chương trình sẽ in ra kết quả là các giá trị rác từ –1000 đến 99. 3. Thiết lập một biến với một giá trị chưa khởi tạo (Setting a variable to an uninitialized value) Ví dụ: int a, b; int sum=a+b; printf(“Enter two numbers to add: “); scanf(“%d”,&b); printf(“The sum is: %d”, sum); Khi chạy (RUN): Enter two numbers to add: 1 3 The sum is: -1393 Câu hỏi đặt ra: Có gì sai với chương trình trên? 1 http://www.cprogramming.com/tutorial/common.html Bài giảng Nhập môn lập trình Lê Thị Bích Hằng – ĐH Nha Trang 118 Khi chúng ta gán giá trị cho một biến, nó có giá trị đó cho đến khi nó được gán một giá trị khác. Trong chương trình ví dụ trên, bởi vì a, b không được khởi tạo giá trị nên tổng của chúng sẽ là một giá trị rác ngẫu nhiên. Có thể sửa chương trình trên như sau: int a, b; int sum; printf(“Enter two numbers to add: “); scanf(“%d%d”,&a, &b); sum=a+b; printf(“The sum is: %d”, sum); 4. Sử dụng một dấu bằng trong phép so sánh (Using a single equal sign to check equality) Ví dụ: char x=\'Y\'; while(x=\'Y\') { //... printf(\"Continue? (Y/N)\"); x=getche(); } Câu hỏi đặt ra: Tại sao vòng lặp này không bao giờ kết thúc? Nếu sử dụng một dấu bằng trong phép so sánh, chương trình thay vì so sánh giá trị bên trái có đúng với giá trị bên phải hay không thì nó sẽ thực hiện phép gán giá trị bên phải cho bên trái, và phép gán này tất nhiên trả về giá trị TRUE. Do đó vòng lặp không bao giờ kết thúc. Do đó chúng ta nên nhớ sử dụng == cho phép so sánh của mình. Và lời khuyên trong trường hợp này là nên đặt biến phía bên phải giá trị để cho chương trình báo lỗi thay vì thực hiện một vòng lặp vô hạn. Chương trình có thể viết lại như sau: char x=\'Y\'; while(\'Y\'==x) { //... printf(\"Continue? (Y/N)\"); x=getche(); } 5. Không khai báo hàm (Undeclared function) Ví dụ: int main() { menu(); } void menu(){ //...} Câu hỏi đặt ra: Chương trình trên đã xảy ra lỗi gì? Trình biên dịch không biết hàm menu() được khai báo trong hàm main() là gì. Lý do là hàm menu() được dịnh nghĩa phía dưới hàm main(). Do đó hàm menu() nên được đặt phía trên hàm main(), hoặc ta có thể sử dụng một khai báo nguyên mẫu (prototype ) cho hàm menu() nếu muốn định nghĩa nó bên dưới hàm main(), như ví dụ dưới đây: Bài giảng Nhập môn lập trình Lê Thị Bích Hằng – ĐH Nha Trang 119 void menu(); int main() { menu(); } void menu(){ ...} 6. Thừa dấu chấm phẩy (Extra semicolons) Ví dụ: int x; for(x=0; x<100; x++); printf(“%d5”,x); Tất nhiên kết quả chương trình đưa ra không phải là các số từ 1 đến 100. Bởi vì trong chương trình trên thừa một dấu chấm phẩy (;) sau vòng lặp for. Nếu chúng ta đặt thừa một dấu chấm phẩy ở bất kỳ nơi nào trong chương trình thì thì rất có thể chương trình sẽ báo lỗi. 7. Vượt quá giới hạn của mảng (Overstepping array boundaries) Ví dụ: int array[10]; //... for(int x=1; x<=10; x++) printf(“%d”,array[x]); Câu hỏi đặt ra: Tại sao chương trình chạy ra có kết quả không đúng? Trong C/C++, một mảng khi khai báo sẽ bắt đầu từ phần tử số 0 chứ không phải là số 1, và kết thúc sẽ là độ dài của mảng khai báo trừ đi 1. Chương trình trên sửa lại như sau: int array[10]; //... for(int x=0; x<10; x++) printf(“%d”,array[x]); 8. Lạm dụng các toán tử && và || (Misusing the && and || operator) Ví dụ: int value; do { //... value=10; } while(!(value==10) || !(value==20)) Câu hỏi đặt ra: Tại sao giá trị value bằng 10 mà vòng lặp vẫn chạy? Nên nhớ công thức của hàm Boolean là: !(A || B) tương đương với !A && !B. Do đó chương trình đúng sẽ là: int value; do { //... value=10; }while(!(value==10) && !(value==20))', 'daduyet', '2023-10-10 17:37:21', '2023-10-10 22:37:21', NULL, 12),
('BV00000002', 'CD00000002', 'hienhuynh', 'Những app, thủ thật khi dùng điện thoại Android', '1. NextDNS : Dịch vụ dns này bảo vệ mình khỏi các mối đe dọa bảo mật, chặn quảng cáo và các trình theo dõi trên các trang web và cả trong ứng dụng. Có máy chủ tại Việt Nam nên tốc độ mạng tốt hơn nhiều. Spoiler: Dùng NextDNS được tài trợ bởi Hostsvn2. Cromite : Trình duyệt yêu thích của mình những ngày gần đây. Nhanh, mượt, bảo mật, riêng tư, mã nguồn mở là những đặc điểm của em nó. Có adblock tích hợp sẵn. 3. InnerTune : Mới phát hiện ra ngày hôm qua. Ứng dụng rất mượt, phát nhạc từ Youtube/YT Music mà ko có quảng cáo. Trải nghiệm khá giống Apple Music mình đang dùng. 4. Proton VPN : Một trong những VPN được đánh giá tốt nhất về tính riêng tư, bảo mật. Ứng dụng miễn phí tới 3 servers (Japan, Netherlands, U.S) 5. HDFLIX : App xem film lậu khá tốt với chất lượng xem HD. Mình đang xem bộ One Piece người đóng qua đây. 6. AntennaPod : Ứng dụng nghe podcast tổng hợp từ toàn bộ các nguồn. Như mình đang theo dõi một kênh chỉ post lên Apple Podcast nên khá bất tiện khi máy chỉ có Spotify Podcast.', 'daduyet', '2023-10-10 17:37:21', '2023-10-11 17:37:21', NULL, 1),
('BV00000003', 'CD00000003', 'phuongha', 'Hướng dẫn FIX lỗi tối màn 3 phút của Laptop CoffeeLake khi khởi động và lỗi Wifi/ Bluetooth của card Intel / Broadcom trên macOS 13.4', '<p>1. Fix lỗi blacklight g&acirc;y tối m&agrave;n 3 ph&uacute;t khi khởi động của Laptop CoffeeLake tr&ecirc;n macOS 13.4​ Lỗi n&agrave;y hiện tại chỉ 13.4 bị. 13.5 Beta v&agrave; dưới 13.4 kh&ocirc;ng bị Bước 1 : Update kext l&ecirc;n bản mới nhất Bước 2 : Mở config.plist. Xo&aacute; boot-args -igfxblr v&agrave; enable-backlight-registers-fix ở device-properties Bước 3 : Th&ecirc;m v&agrave;o boot-args: -igfxblt Bước 4 : Restart ----------------------------------------------------- 2. Fix lỗi Wifi/ Bluetooth tr&ecirc;n macOS 13.4+​ Như c&aacute;c b&aacute;c đ&atilde; biết, macOS 13.4+ c&oacute; nhiều lỗi li&ecirc;n quan đến Wifi v&agrave; Bluetooth. V&agrave; đ&acirc;y dưới đ&acirc;y l&agrave; c&aacute;ch fix cho cả intel v&agrave; broadcom Đối với card Intel​ Bước 1 : Tải kext mới nhất cho Wifi : Tải ở đ&acirc;y . Bước 2 : Tải kext mới nhất cho Bluetooth: Tải ở đ&acirc;y v&agrave; ở đ&acirc;y. Bước 3 : Giải n&eacute;n. Sau đ&oacute; copy Airportitlwm v&agrave; IntelBluetoothFirmware + BlueToolFixup.kext v&agrave;o thư mục EFI/OC/kexts Buớc 4 : Mở config.plist bằng Propertree. T&igrave;m đến NVRAM &gt;&gt; Add &gt;&gt; 7C436110-AB2A-4BBB-A880-FE41995C9F82 v&agrave; th&ecirc;m 2 key như sau : bluetoothInternalControllerInfo 00000000 00000000 00000000 0000 bluetoothExternalDongleFailed 00 Bước 5. T&igrave;m đến NVRAM &gt;&gt; Delete &gt;&gt; 7C436110-AB2A-4BBB-A880-FE41995C9F82 v&agrave; th&ecirc;m 2 key với value như sau : bluetoothInternalControllerInfo bluetoothExternalDongleFailed V&iacute; dụ phần config tr&ecirc;n: Tại đ&acirc;y Bước 6 . Sau đ&oacute; bấm Ctrl + R Chọn thư mục EFI/OC ➝ Select Folder. Sau khi xong bấm Ctrl + S để Save config. Bước 7 : Restart ----------------------------------------------------- Đối với card Broadcom​ Bước 1 : Tải kext mới nhất cho Wifi : Tải ở đ&acirc;y Nếu wifi hoạt động b&igrave;nh thường th&igrave; kh&ocirc;ng cần th&ecirc;m kext cho Wifi Bước 2 : Tải kext mới nhất cho Bluetooth : Tải ở đ&acirc;y Bước 3 : Giải n&eacute;n, copy kext AirportBrcmFixup ( nếu card wifi của bạn cần ) v&agrave; BlueToolFixup + BrcmPatchRAM3.kext + BrcmFirmwareData.kext v&agrave;o thư mục EFI/OC/kexts Bước 4 : Mở config.plist, th&ecirc;m: -btlfxallowanyaddr v&agrave;o boot-args. Buớc 5 : Mở config.plist bằng Propertree. T&igrave;m đến NVRAM &gt;&gt; Add &gt;&gt; 7C436110-AB2A-4BBB-A880-FE41995C9F82 v&agrave; th&ecirc;m 2 key như sau: bluetoothInternalControllerInfo 00000000 00000000 00000000 0000 bluetoothExternalDongleFailed 00 Bước 6 : T&igrave;m đến NVRAM &gt;&gt; Delete &gt;&gt; 7C436110-AB2A-4BBB-A880-FE41995C9F82 v&agrave; th&ecirc;m 2 key với value như sau : bluetoothInternalControllerInfo bluetoothExternalDongleFailed V&iacute; dụ phần config tr&ecirc;n: Tại đ&acirc;y Bước 7 : Sau đ&oacute; bấm Ctrl + R Chọn thư mục EFI/OC ➝ Select Folder. Sau khi xong bấm Ctrl + S để Save config. Bước 8 : Restart ----------------------------------------------------- Good luck !</p>', 'dachinhsua', '2023-11-16 17:37:21', '2023-11-16 12:46:03', '2023-11-16 12:45:55', 2),
('BV00000009', 'CD00000002', 'phuongha', 'Tổng hợp software cần thiết cho máy tính', '<p>Rảnh rỗi sinh nông nỗi làm một cái danh sách share aE chơi, sau này cài lại Win cứ thế mà táng :D\n\nMục Lục\n1. System Tuning\n2. Internet & Networking\n3. Office & Productivity\n4. Privacy & Security\n5. Multimedia\n6. Win/Office ISO & Other\n\nLưu ý\n1. Tiêu chí lựa chọn của mình là sạch sẽ, an toàn, cần thiết cho đại đa số, không động đến hàng chuyên biệt phục vụ công việc hoặc sở thích cá nhân.\n2. Có thể có pm tốt hơn mình giới thiệu nhưng giao diện xấu, không free hoặc phải xxx bằng patch gì gì đó xin miễn bàn.\n3. Một số pm dẫn link Softpedia hoặc đại loại nhằm đảm bảo trong thớt toàn St&alone (Offline Installer).\n4. Thớt chỉ giới thiệu ngắn gọn, không kèm theo hướng dẫn sử dụng pm.\n5. vOz tân ko cho share pm trả phí nên mềnh đã xóa hết key ccleaner, revo, winrar... mong các thym thông cảm, chịu khó tự seach :v\n\nGhi chú\n(P): Portable by hãng\n(PA): Portable by PortableApps</p>', 'daduyet', '2023-11-16 18:22:19', '2023-11-16 18:22:27', '0000-00-00 00:00:00', 1),
('BV00000010', 'CD00000002', 'ducnhong', 'Hướng dẫn dùng Cloudflare Zero Trust', '<p>Bài viết này sẽ hướng dẫn dùng Cloudflare Zero Trust để làm server dns chặn quảng cáo, tracking..., cho điện thoại, trình duyệt, router... miễn phí, tương tự Nextdns nhưng không giới hạn lượt truy vấn dns, có ECS để trả server CDN gần với mình.\nI/ Chuẩn bị:\n1. Tài khoản Github:\nBuild software better, together (https://github.com/signup)\nFork repo này:\nGitHub - mrrfv/cloudflare-gateway-pihole-scripts: Use Cloudflare Gateway DNS/VPN to block ads, malware and tracking domains - free alternative to NextDNS, Pi-hole and Adguard (https://github.com/mrrfv/cloudflare-gateway-pihole-scripts)</p>', 'daduyet', '2023-11-16 18:41:25', '2023-11-16 18:41:34', '0000-00-00 00:00:00', 4),
('BV00000011', 'CD00000003', 'kabee', 'Có cách nào set cố định public IP không các bác', '<p>What Is My IP?\nCheck the IP address assigned to your device. Show my IP city, state, and country. What Is An IP Address? IPv4, IPv6, public IP explained.\nwww.whatismyip.com www.whatismyip.com\nMình check IP ở trang này thỉnh thoảng thay đổi. Mình muốn fix cố định thì làm thế nào nhỉ? Ai có soft or cách nào xin tip với. Tks.</p>', 'daduyet', '2023-11-16 18:44:05', '2023-11-16 18:44:13', '0000-00-00 00:00:00', 1),
('BV00000012', 'CD00000002', 'thienlan', 'Hành trình tự học photoshop', '<p>Chào mấy thím!\nNăm nay để nâng cấp bản thân thì mình có học thêm về photoshop. Đó giờ mình chẳng biết gì về thiết kế cả. Mình sẽ làm 30 poster về bất cứ cái gì mình thích trên đời trong vòng 30 ngày. jmEBCky.gif\n\nMỗi poster mình sẽ chú thích thêm kĩ năng mình học được của ngày hôm đó. Phiên bản photoshop mình sử dụng là bản free của cs2 và bản photoshop online của 1 team vnJGdqgzY.png\n\nDay 1: Softcult - Uzumaki\nDay 2: Nah - Baller\nDay 3: Nike - Retro Quality</p>', 'daduyet', '2023-11-16 19:42:04', '2023-11-17 05:49:59', '0000-00-00 00:00:00', 6),
('BV00000013', 'CD00000001', 'hienhuynh', 'Cài đặt cam imou trên iOS', '<p>Hi các b,\n\nTình hình là có mua 2 cam imou (cái A và B)\nCái A mình lấy điện thoại ba mình dùng Android và đã setup thành công, cái B thì mình tạm cất chưa đung tới. Hôm nay do cái A bị dây điện hỏng với lại mình muốn setup cho cái B và cả 2 cái mình muốn làm chủ rồi share lại cho mọi người trong nhà dùng.\nMình đã xoá thiết bị và tài khoản của ba mình mà trước đây mình đã cài đặt trên app imou ở ĐT của ba mình. Tiếp theo mình bật app imou trên ĐT của mình lên rồi cài đặt để kết nối cam B vào, nhưng đến bước này thì mình ko thể connect vào WIFI của cam B được nên không đi tiếp được. (có đính kèm hình ảnh bị lỗi bên dưới)\n\nNhờ các b có kinh nghiệm chỉ giúp ạ,\nThanks</p>', 'daduyet', '2023-11-17 05:49:48', '2023-11-17 22:17:41', '0000-00-00 00:00:00', 3),
('BV00000014', 'CD00000003', 'ducnhong', 'Cách ẩn tin nhắn, xem tin nhắn ẩn trên Zalo đơn giản, nhanh chóng', 'Nếu như bạn cảm thấy không an tâm với cách đặt mã khóa cho Zalo để bảo mật tin nhắn thì hãy cùng tìm hiểu cách ẩn và xem lại cuộc trò chuyện bị ẩn theo hướng dẫn trong bài viết dưới đây nhé!\r\n1. Hướng dẫn cách ẩn tin nhắn trò chuyện trên Zalo\r\n- Bước 1: Chọn tin nhắn trò chuyện cần ẩn\r\nBạn đăng nhập vào ứng dụng Zalo trên điện thoại > Nhấn giữ vào cuộc trò chuyện muốn ẩn.\r\n- Bước 2: Ẩn cuộc trò chuyện\r\nĐể ẩn tin nhắn, bạn chọn Ẩn trò chuyện > Nhập mã PIN của bạn (Nếu bạn chưa đặt hay quên mã Pin bạn có thể chọn Cài đặt lại mã để đặt lại).\r\n2. Hướng dẫn cách xem lại tin nhắn ẩn trên Zalo\r\n- Bước 1: Tìm cuộc trò chuyện bị ẩn\r\nTại thanh tìm kiếm trong ứng dụng Zalo, bạn nhập mã PIN đã ẩn cuộc trò chuyện > Nhấn vào cuộc trò chuyện cần xem lại.\r\n- Bước 2: Xem lại cuộc trò chuyện bị ẩn\r\nBạn chọn Bỏ ẩn cuộc trò chuyện > Chọn Có để có thể xem lại cuộc trò chuyện này.Để mở lại cuộc trò chuyện bị ẩn: Tại thanh tìm kiếm tin nhắn > Bạn nhập mã PIN ẩn trò chuyện > Nhấn chuột phải vào cuộc trò chuyện cần xem > Chọn Bỏ ẩn trò chuyện > Chọn Có.\r\n3. Một số câu hỏi thường gặp\r\n- Khi ẩn rồi có nhận được cuộc gọi hay tin nhắn từ người bị ẩn không?\r\nKhi ẩn trò chuyện thì bạn vẫn nhận được cuộc gọi và tin nhắn như bình thường.\r\n\r\n- Quên mất tên người bị ẩn, làm sao để tìm lại?\r\nBạn hãy nhập mã pin cuộc trò chuyện để tìm lại nhé.\r\n\r\n- Bỏ ẩn trò chuyện xong bị mất tin nhắn, có khôi phục được không?\r\nRất tiếc là trường hợp này không thể khôi phục lại tin nhắn. Bỏ ẩn trò chuyện và bị mất tin nhắn thì có thể do bạn đăng nhập trên thiết bị khác hoặc gỡ ứng dụng Zalo.\r\n\r\n- Nếu ẩn trò chuyện thì người đó có còn hiển thị trong danh sách bạn bè không?\r\nNếu bạn ẩn cuộc trò chuyện thì người đó cũng sẽ bị ẩn đi trong danh sách bạn bè.', 'daduyet', '2023-11-18 23:28:51', '2023-11-18 23:28:51', NULL, 200),
('BV00000015', 'CD00000002', 'hienhuynh', 'Tư vấn usb soundcarr/dac cho android HU để cải thiện âm thanh xe', 'Tình hình là vầy: mấy cái đầu HU xài android chip giải mã âm thanh tệ quá nên sound ra em thấy bị đục đục mờ mờ kiểu gì ấy. Nên em nhờ mấy bác giúp tư vấn 1 thiết bị đáp ứng được nhu cầu :\r\n\r\n1. Khi cắm vào đầu HU nó sẽ hoạt động như 1 chip giải mã âm thanh cho đầu android tương tự sound card trên pc ấy. Thiết bị này nó không giống DAC vì trên xe em đã hết cổng Aux để DAC cắm ngược vào rồi.(cổng aux đang bị đầu android HU cắm vào)', 'daduyet', '2023-11-18 23:33:16', '2023-11-18 23:33:16', NULL, 2),
('BV00000016', 'CD00000002', 'kabee', 'Huawei sẽ đoạn tuyệt với ứng dụng Android', 'Thông tin đến từ các nhà phát triển chuyên về HarmonyOS cho thấy Huawei muốn tách mình hoàn toàn khỏi Android khi không có dấu vết của mã AOSP trong phiên bản cập nhật tiếp theo của nó.\r\nKể từ các hạn chế vào năm 2019, Huawei đã buộc phải điều chỉnh phần mềm của mình cho phù hợp với tình hình mới, hoàn toàn bỏ qua khuôn khổ dịch vụ của Google để hình thành HarmonyOS - một phiên bản sửa đổi của Android với mã riêng và tương thích với các tệp .APK (mặc dù mã của nó đổi tên định dạng tệp sau này).', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 3),
('BV00000017', 'CD00000004', 'kabee', 'Trí tuệ nhân tạo có được phép tự do ngôn luận?', 'Liệu con người có mất đi vị trí \"độc tôn\" khi AI phát triển vượt bậc? (Ảnh: phonlamaiphoto/Adobe).\r\n\r\nKhả năng của AI đã làm một số người \"choáng váng\". Một số lo lắng về hậu quả loài người sẽ tuyệt chủng nếu để AI trở nên quá mạnh mẽ, một số khác muốn trao cho nó quyền tự do ngôn luận.\r\nNhưng chính xác thì vì sao chúng ta cần cho các cỗ máy như ChatGPT quyền tự do phát ngôn? Đa số câu trả lời liên quan đến quyền tự do bất khả xâm phạm, quyền mà luật pháp quốc tế quy định tất cả mọi người đều có.\r\nVà bởi vì AI đang trở thành một phần quan trọng trong cuộc sống hàng ngày của chúng ta nên chúng ta cần mở rộng quyền tự do đó cho các hệ thống như ChatGPT vì AI có thể giúp hỗ trợ suy nghĩ của chúng ta bằng cách cung cấp thông tin và đưa ra các câu trả lời khi chúng ta đặt câu hỏi. Sự hỗ trợ này dẫn đến một số mong muốn rằng AI cũng xứng đáng có quyền tự do ngôn luận.\r\n\r\nMặc dù việc này nghe có vẻ thú vị nhưng một số chuyên gia cho rằng chúng ta chỉ nên cho AI quyền đó nếu nó phù hợp với quyền tự do suy nghĩ của con người. Một trong số các ý kiến cho rằng các hệ thống AI không phải là người dân nên chúng cần được xếp với hạng mục các chính trị gia và các tập đoàn.\r\n\r\nCác phát biểu và ý tưởng của các hệ thống này không nên bị kiểm duyệt vì chúng có thể cung cấp những nguồn thông tin đa dạng và trái chiều, cho phép mọi người suy nghĩ tự do hơn.\r\n\r\nTuy nhiên, một vấn đề lớn của các hệ thống AI, chẳng hạn như ChatGPT, là cung cấp thông tin sai lệch, thậm chí là thông tin bịa đặt. Vì thế việc trao quyền tự do ngôn luận cho AI có thể trở thành thảm họa.\r\n\r\nVì trước khả năng cung cấp thông tin dồi dào như nó vốn có thì các thông tin sai lệch sẽ dễ được hòa trộn và hiểu nhầm rằng cũng là thông tin chính xác và rất dễ dàng ảnh hưởng đến cách suy nghĩ của nhiều người.\r\n\r\nĐây thực sự là một vấn đề gây tranh cãi nhưng cũng rất thú vị và chắc chắn sẽ đòi hỏi các cơ quan chức năng tìm cách vận hành các hệ thống này cho phù hợp.', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 2),
('BV00000018', 'CD00000004', 'phuongha', 'Một sinh viên Trường đại học Ngoại ngữ - tin học TP.HCM bị giảng viên trừ 50% điểm vì sử dụng các ứng dụng AI viết bài tiểu luận.​', 'Một sinh viên Trường đại học Ngoại ngữ tin học TP.HCM (HUFLIT) cho biết bài tiểu luận môn viết của mình bị giảng viên trừ 50% số điểm. Lý do: bài làm sử dụng ứng dụng trí tuệ nhân tạo (AI) để viết bài.\r\n\r\nCũng theo sinh viên này, bản thân từng nghe giảng viên nhắc nhở dùng AI viết tiểu luận sẽ tính đạo văn nếu bị phát hiện. Tuy nhiên sinh viên này không nghĩ rằng giảng viên sẽ phát hiện nếu sử dụng các phần mềm dịch thuật.\r\n\r\nGiảng viên giải thích rằng việc sử dụng những phần mềm dịch thuật từ Việt sang Anh cũng có nguy cơ tính là sử dụng AI, khi kiểm tra đạo văn bằng các phần mềm chuyên dụng sẽ phát hiện.\r\n\r\nTrao đổi với Tuổi Trẻ Online, ông Nguyễn Ngọc Vũ - phó hiệu trưởng HUFLIT - cho biết trường có hướng dẫn sinh viên các nguyên tắc sử dụng các ứng dụng AI như sự minh bạch, trách nhiệm và hiểu rõ những ưu điểm và hạn chế của các mô hình tạo sinh.\r\nVăn bản chính thức về chế tài đối với việc sinh viên sử dụng ứng dụng AI làm bài tập thì chưa có, song trường có các quy định về liêm chính học thuật.\r\n\r\n\"Trong trường hợp này, giảng viên đã dặn dò sinh viên trước khi làm bài tiểu luận không sử dụng các ứng dụng AI làm bài.', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 221),
('BV00000019', 'CD00000004', 'hienhuynh', 'Việt Nam đang dẫn đầu về phát triển trí tuệ nhân tạo trong khu vực Đông Nam Á', 'Ngân hàng JPMorgan đánh giá cao sự đầu tư và phát triển của Việt Nam trong lĩnh vực trí tuệ nhân tạo (AI) so với các nước trong khu vực Đông Nam Á.\r\nRanjan Sharma, người đứng đầu bộ phận nghiên cứu vốn cổ phần TMT ASEAN tại JPMorgan, cho biết Việt Nam có tầm nhìn dài hạn hơn về trí tuệ nhân tạo (AI) so với Malaysia và Philippines.', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 74),
('BV00000020', 'CD00000004', 'hienhuynh', 'Đèn giao thông dùng trí tuệ nhân tạo giúp giảm 1/3 tắc đường', 'Đèn giao thông thiếu linh hoạt không chỉ gây khó chịu cho người lái xe, mà còn làm gia tăng ô nhiễm không khí khi ô tô cứ nổ máy và đứng im một chỗ.​\r\nSử dụng lượng dữ liệu khổng lồ liên quan đến giao thông thu được từ ứng dụng Google Maps và sức mạnh của trí tuệ nhân tạo (AI), tập đoàn công nghệ Google đang hy vọng giải quyết cả hai vấn đề đó bằng cách điều chỉnh cơ sở hạ tầng hiện có.\r\nDự án Đèn xanh - Google Green Light - đang được thí điểm tại 12 thành phố ở Mỹ, châu Âu và châu Á, sẽ mở rộng thêm trong năm tới.\r\nÔ tô dừng chờ đèn đỏ nhiều sẽ góp phần làm gia tăng ô nhiễm không khí (Ảnh minh họa: ST).\r\nMô hình dựa trên AI sẽ xem xét cấu trúc, mô hình giao thông xanh và lập kế hoạch đảo đèn ở từng giao lộ, sử dụng dữ liệu từ Google Maps. Sau đó, mô hình sẽ đưa ra các đề xuất nhằm tối ưu hóa đèn giao thông, điều chỉnh thời gian đèn đỏ tùy theo lưu lượng xe.\r\nNhững điều chỉnh đó không chỉ giới hạn ở một đèn giao thông duy nhất, mà có thể phối hợp nhiều nút giao gần đó, tạo ra \"làn sóng đèn xanh\", giúp giảm tắc nghẽn giao thông.\r\n\r\n\r\n\r\n\r\nPlay\r\nMặc dù hệ thống giám sát trực truyến có vẻ hiệu quả và dễ thực hiện hơn, nhưng giải pháp của Google không đòi hỏi bất kỳ sự thay đổi, nâng cấp nào với cơ sở hạ tầng hiện có, nên không tốn kém.\r\nTập đoàn công nghệ này cho biết, trước khi có dự án Google Green Light, đèn giao thông được tối ưu hóa \"bằng cách sử dụng các cảm biến đắt tiền hoặc việc đếm xe thủ công tốn nhiều thời gian\". Hiệu quả của dự án sẽ càng rõ ràng hơn ở những nơi đang dùng hệ thống đèn giao thông lạc hậu, không có sự giám sát.\r\nTheo các nghiên cứu, ô nhiễm không khí ở các nút giao thông trong thành phố có thể cao hơn 29 lần so với đường thông thoáng và một nửa trong số đó đến từ việc xe phải dừng lại chờ đèn, hoặc tắc đường.\r\nThống kê ban đầu từ các thử nghiệm của Google cho thấy dùng AI điều khiển đèn giao thông có thể giúp giảm 30% số lần dừng xe và giảm tới 10% lượng khí thải ở các giao lộ.\r\nDự án Google Green Light đang được triển khai ở 12 thành phố, bao gồm Seattle (Mỹ), Rio de Janeiro (Brazil), Manchester (Anh), Hamburg (Đức), Budapest (Hungary), Haifa (Israel), Abu Dhabi (UAE), Bangalore, Hyderabad, và Kolkata (Ấn Độ), Bali và Jakarta (Indonesia), tác động đến 30 triệu hành trình bằng ô tô mỗi tháng.\r\nGoogle hy vọng sẽ mở rộng dự án trong năm 2024, và đã mời các kỹ sư giao thông đô thị từ khắp nơi trên thế giới đăng ký tham gia.', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 300),
('BV00000021', 'CD00000004', 'hienhuynh', 'Nông dân sẽ nhận được hỗ trợ đắc lực từ trí tuệ nhân tạo', 'Với nền tảng Mạng nhà nông, nông dân sẽ nhận được những hỗ trợ đắc lực từ trí tuệ nhân tạo, chẳng hạn cập nhật nhanh nhất thông tin thị trường, ứng dụng công nghệ, kiến thức khoa học, vốn tín dụng...\r\nNgày 21.10, tại TP.Cần Thơ, Trung tâm Chuyển đổi số và Thống kê nông nghiệp Bộ NN-PTNT phối hợp Công ty Cổ phần Thế giới công nghệ phần mềm (Worldsoft) và Báo Nông nghiệp Việt Nam tổ chức lễ ra mắt nền tảng \"Mạng nhà nông - Hành trình nông dân số\r\nVới nền tảng Mạng nhà nông, nông dân sẽ nhận được những hỗ trợ đắc lực từ trí tuệ nhân tạo như tiếp cận thông tin thị trường, mùa vụ, tín dụng...\r\nĐÌNH TUYỂN\r\n\r\nMạng nhà nông cũng có đầy đủ tính năng của một mạng xã hội, tích hợp nhiều công cụ hệ thống hỗ trợ các HTX, nông dân, trang trại, doanh nghiệp trên nhiều phương diện. Có thể kể đến như khả năng quản trị, nắm bắt kiến thức khoa học, tối ưu nguyên liệu đầu vào, tiếp cận nguồn vốn tín dụng… Ngoài ra, nền tảng còn có kênh phân phối nông sản phù hợp với xu thế tiêu dùng, dễ dàng kết nối với các thiết bị nông nghiệp thông minh...\".\r\n\r\nĐại diện Công ty Cổ phần Worldsoft cho biết, nền tảng Mạng nhà nông là diễn đàn nông dân rộng lớn được hỗ trợ bởi trí tuệ nhân tạo (Al). Các thông tin thị trường sẽ được cập nhật mới nhất, nhanh nhất với các số liệu chính xác. Những ứng dụng công nghệ, cách làm tốt hoặc bất cứ vấn đề gì liên quan đến lĩnh vực nông nghiệp đều được giải đáp ngay lập tức. Người sử dụng nền tảng bao gồm nhà nông sẽ dễ dàng và linh hoạt hơn trong việc tạo lập kế hoạch tài chính, báo cáo mùa vụ theo mục tiêu đề ra với sự hỗ trợ của các công cụ tiên tiến.Trung tâm Chuyển đổi số và Thống kê nông nghiệp Bộ NN-PTNT, Báo Nông nghiệp Việt Nam và Công ty Cổ phần Worldsoft ký kết cùng phát triển Mạng nhà nông\r\nTHANH DUY\r\n\r\nÔng Nguyễn Quốc Toản, Giám đốc Trung tâm Chuyển đổi số và Thống kê nông nghiệp cho rằng việc ra mắt mạng nhà nông là hành động cụ thể nhằm góp phần thúc đẩy chuyển đổi số trong lĩnh vực nông nghiệp và phát triển nông thôn. Đây là không gian kết nối, chia sẻ kinh nghiệm giữa nông dân và các chuyên gia. Đặc biệt, hệ sinh thái này giúp nông dân có thể chủ động trong mua - bán, lập kế hoạch sản xuất và theo dõi kế hoạch tài chính. Từ đó, giá thành sản xuất, giá nông sản khi đến tay người tiêu dùng cũng sẽ được cải thiện hơn thông qua nền tảng thương mại điện tử.', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 56),
('BV00000022', 'CD00000005', 'phuongha', 'Tạo wifi mesh với Tp-link Deco M4 và E4', 'Các bác cho em hỏi, em có nâng cấp wifi ở nhà lên mesh với 2 node, 1 node chính dùng M4 cắm qua modem, cục E4 dùng để mesh, tắt phát wifi của modem nhưng cài đặt xong thì mọi thứ không như kỳ vọng.\r\n1. Nếu để chế độ Router Wifi, set IP tĩnh cho router để tránh trùng IP rồi thì node chính rất hay bị reset rớt mạng, vài phút 1 lần, chạy test tốc độ mạng là reset, rớt mạng (kiểu quá tải).\r\n2. Nếu để chế độ AP thì đỡ reset hơn nhưng thỉnh thoảng vẫn có, chạy test tốc độ mạng là reset, rớt mạng (kiểu quá tải).\r\n3. Tất cả các thiết bị đều kết nối và vào mạng được nhuwg duy chi có chiếc PC làm việc là không thể vào mạng được hoặc có lúc vào được 1 tí rồi rớt, chạy kiểm tra mạng thì báo IP không hợp lệ hoặc gateway không hợp lệ hoặc cả 2. Rút 1 node E4 ra thì vào được mạng nhưng vì ở xa nên mạng rất yếu.\r\nCác cao nhân cho em ý kiến với chứ em ong thủ với quả wifi hiện đại, hại điện này quá. Cảm ơn các bác!', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 2),
('BV00000023', 'CD00000005', 'kabee', 'Tựađề', 'Nộidung', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 97),
('BV00000024', 'CD00000005', 'thienlan', 'Đi chuyển mạng giữ số, phát hiện bị giả chữ ký trong giấy cam kết không chuyển mạng', 'Một khách hàng của nhà mạng Mobifone tại Quảng Bình đi làm thủ tục chuyển mạng giữ số thì bất ngờ phát hiện mình bị giả chữ ký trong một tờ giấy cam kết không chuyển mạng.Chi nhánh Mobifone Quảng Bình - nơi anh T. đến khiếu nại việc chuyển mạng giữ số nhưng bị từ chối - Ảnh: QUỐC NAM\r\n\r\nNhững ngày qua, một khách hàng của nhà mạng Mobifone tại Quảng Bình đang rất bức xúc vì đăng ký dịch vụ chuyển mạng giữ số để chuyển qua dùng mạng Viettel nhưng không được Mobifone chấp thuận.\r\n\r\nCàng bất ngờ hơn khi nhân viên của nhà mạng Mobifone còn cung cấp một giấy cam kết với nội dung chủ thuê bao này cam kết không chuyển qua mạng khác vô thời hạn.\r\n\r\nTuy nhiên chủ thuê bao phát hiện chữ ký trong cam kết này không phải của mình, và mình cũng chưa từng cam kết gì với nhà mạng Mobifone từ khi mua sim.\r\n\r\nGiấy cam kết từ trên trời rơi xuống​\r\nPhản ánh với Tuổi Trẻ Online, anh N.T.T., 34 tuổi, trú tại TP Đồng Hới - là chủ thuê bao 0902822….– cho biết anh mua lại sim của nhà mạng Mobifone từ tháng 7-2023. Sim này đã được kích hoạt từ trước và anh đã đăng ký chính chủ khi mua lại.\r\n\r\nĐến giữa tháng 10 vừa qua, vì đặc thù công việc phải đi miền núi nhiều, anh đến chi nhánh Viettel Quảng Bình đề nghị được chuyển số thuê bao của mình qua mạng Viettel theo hình thức chuyển mạng giữ số.\r\n\r\nSau khi tiếp nhận, nhân viên của chi nhánh Viettel Quảng Bình đã kết nối với chi nhánh nhà mạng Mobifone tại Quảng Bình để thực hiện các bước chuyển mạng cho khách hàng theo quy định.\r\n\r\nTuy nhiên phía nhà mạng Mobifone không thực hiện yêu cầu này mà không đưa ra lý do. Đến ngày 19-10, anh T. đã trực tiếp đến phòng giao dịch chi nhánh Mobifone Quảng Bình để làm phiếu khiếu nại về sự việc trên.\r\n\r\nSau đó, đến đầu tháng 11, nhân viên tại chi nhánh Mobifone Quảng Bình đã gửi đến chi nhánh Viettel của tỉnh này một giấy cam kết.\r\n\r\nNội dung giấy cam kết này ghi anh T. cam kết chỉ sử dụng nhà mạng Mobifone, không chuyển mạng giữ số trong quá trình sử dụng sim 0902822… Thông tin cá nhân trong giấy cam kết đúng là của anh T. và đúng số căn cước công dân của anh.Chữ ký do anh T. ký trong phiếu khiếu nại gửi cho chi nhánh Mobifone Quảng Bình và chữ ký giả hoàn toàn khác trong giấy cam kết không chuyển mạng mà Mobifone cung cấp - Ảnh: QUỐC NAM\r\n\r\nTuy nhiên, anh T. nói anh mới mua lại sim này được khoảng 4 tháng và chưa hề làm bất cứ giấy cam kết nào. Anh T. cũng khẳng định chữ ký trong giấy cam kết này cũng không phải của anh.\r\n\r\nĐể khẳng định đó là chữ ký giả, anh T. cung cấp bản chụp tờ phiếu khiếu nại mà trước đó anh gửi cho nhà mạng Mobifone. Chữ ký của anh trong phiếu khiếu nại này cũng hoàn toàn khác với chữ ký tên anh trong giấy cam kết.\r\n\r\nÔng Phan Xuân Hồng - giám đốc chi nhánh Viettel tỉnh Quảng Bình - cũng xác nhận diễn biến sự việc như anh T. trình bày, gồm cả tờ giấy cam kết mà phía nhà mạng Mobifone Quảng Bình đã gửi qua cho chi nhánh Viettel Quảng Bình.\r\n\r\nÔng Hồng cho biết sau khi tiếp nhận yêu cầu chuyển mạng giữ số của anh T., nhân viên chi nhánh Viettel Quảng Bình đã thực hiện đúng các trình tự như quy định của Bộ Thông tin và Truyền thông để đáp ứng yêu cầu của khách hàng.\r\n\r\n\"Thậm chí chúng tôi đã có ý kiến gửi ra Cục Viễn thông đề nghị giải quyết sự việc này. Sau đó phía nhà mạng Mobifone cung cấp cho chúng tôi tờ giấy cam kết nói trên\", ông Hồng thuật lại.\r\n\r\nAi đã giả mạo chữ ký?​\r\nSau khi có phản hồi về tờ giấy cam kết không phải do mình làm và chữ ký giả với nhà mạng Mobifone Quảng Bình, một nhân viên dịch vụ của nhà mạng Mobifone - là người trước đó trực tiếp sang tên chính chủ sim cho anh T. - đã chủ động liên lạc với anh T.\r\n\r\nNgười này cho biết mình là người đã soạn cái giấy cam kết đó và tải lên hệ thống của Mobifone.\r\n\r\nTuy nhiên, khi anh T. thắc mắc vì sao lại giả chữ ký thì người này không trả lời mà nói xin lỗi vì giấy cam kết mình ghi không rõ ràng thời hạn.\r\n\r\nSau đó, nhân viên này còn nằng nặc xin anh T. cho mình làm lại một tờ cam kết khác ghi thời hạn cam kết không chuyển mạng là 24 tháng.\r\n\r\n\"Em hủy giấy cam kết cũ. Em gửi giấy cam kết mới ra nhờ anh ký rồi em cho anh nhân viên chạy qua anh ký rồi chụp lại để em tải lên hệ thống\", nhân viên này nài nỉ.\r\n\r\nAnh T. hỏi cam kết sử dụng 24 tháng là của nhà mạng hay của pháp luật thì nhân viên này xác nhận là quy định của nhà mạng.', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 2),
('BV00000025', 'CD00000005', 'kabee', ' Hiện tượng lạ cho tốc độ mạng gói 100Mbps .', 'Tôi dùng mạng VNPT gói 100Mbps. Sau router GW040 tôi lắp 3 cục mesh Tenda MW6. Hôi nay đo kiểm xem mạng mẹo thế nào thì rất lạ là : Tôi dùng pc cắm dây trực tiếp với router đo tốc độ mạng được kết quả Download 93,29 Upload 93,41 Mbps . Điều này phù hợp với gói cước. Nhưng ngay đồng thới tôi đo tốc độ wifi bằng ip 10 thì được kết quả Download 286 Upload 288 Mbps. Ảnh tôi chụp kèm theo. Có thể hiều các kết quả đó như thế nào? Tôi dân ngoại đạo mong đước ace giúp đỡ.', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 2),
('BV00000026', 'CD00000005', 'nguyenduy', ' PC không vào được mạng LAN', 'Em mới chuyển nhà.\r\nĐã đi mua dây mạng LAN mới, 55k/10m. Lúc mới cắm vào thì trên Modem chỉ nháy đèn LAN 1 của tầng dưới, mặc dù e cắm LAN 2 nhưng lại không sáng đèn đổi sang cổng LAN 3 cũng vậy, nhưng lúc đó vẫn vào được mạng, lướt chạy phà phà ok.\r\nQua ngày hôm sau thì không có mạng, trong khi WIFI điện thoại vẫn báo 5 vạch căng đét và vào mạng bình thường.\r\nEm đã thử các cách trên GG như uninstall driver mạng, rút ra cắm lại dây LAN, reset Modem nhưng không hiệu quả.\r\nAi đã từng gặp tình trạng này cho e xin cách xử lý với ạ.', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 24),
('BV00000027', 'CD00000005', 'thanhmai', 'Em bấm mạng chuẩn B đủ 8 sợi mà vẩn 100Mbps là sao các bác.', 'Em bấm mạng chuẩn B đủ 8 sợi, cắm bộ test sáng full 8 led mà vẩn 100Mbps là sao các bác.', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 2),
('BV00000028', 'CD00000005', 'hienhuynh', 'Hỏi bộ test mạng của hãng nào chất lượng...', 'Như tiêu đề mình mua cục test mạng như thế này cứ vài tuần là hư 1 cái, chả hiểu sao. Anh em tư vấn loại nào tốt với cho mình hỏi sao nó hay bị lỗi mất 1-2 dây hoặc chạy loạn 2 3 dây 1 lần...', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 2),
('BV00000029', 'CD00000005', 'truongminh', 'Cách đổi tên mạng dây hay tên cục router', 'huhu, các thím ơi =((, sau khi trư reset cục router thì giờ cắm mạng dây vào nó hiện tên như thế này. :( trư buồn rất. Có thím nào biết cách khắc phục không :adore: Lần đầu vào box, có gì nhầm lẫn mong mod bỏ qua', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 3),
('BV00000030', 'CD00000005', 'hoangtrang', 'Nhờ tư vấn lắp camera, mạng nhà nghỉ', 'Gia đình mình đang hoàn thiện nhà nghỉ ở quê, diện tích khoảng 200m, 3 tầng, mỗi tầng 7 phòng tổng là 14 phòng\r\nNgân sách dự kiến là khoảng 10 củ\r\nVề wifi em đọc mấy bài trong này thì thấy vozer đánh giá mấy con xiaomi p/p tốt mà em thấy hay phải cập nhật thì phải, mà nhà nghỉ cần ổn định hơn.\r\nCamera: tầng 2, 3 do cầu thang ở giữa nên em tính mỗi tầng 2 cái mà người nhà bảo chỉ cần 1 cái. cửa trước cửa sau, lễ tân, chỗ để xe, tổng khoảng 6 mắt. Dự kiến dùng imou\r\nLúc đầu tính không cần đầu ghi mà sẽ đẩy thẳng lên cloud mà 6 mắt thì khả năng sẽ chiếm kha khá băng thông mạng\r\nNhờ các thím tư vấn giúp mấy điểm:\r\nLắp đặt mạng, gói cước, wifi mesh\r\nCamera cần dùng đầu ghi hay không, nên đi dây hay wifi', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 2),
('BV00000031', 'CD00000005', 'lananh', 'CẦN TUYỂN CHUYÊN VIÊN Quản Trị Mạng TẠI QUẬN 1 – HỒ CHÍ MINH', 'CẦN TUYỂN CHUYÊN VIÊN Quản Trị Mạng TẠI QUẬN 1 – HỒ CHÍ MINH\r\nSở Ngoại vụ TP.HCM cần tuyển:\r\n👉 1 Chuyên Viên Quản Trị Mạng (Ưu tiên Đại học)\r\n☘ Thời gian làm việc: giờ hành chính, từ thứ 2 đến thứ 6;\r\n☘️ Tham gia đầy đủ chế độ BHXH, BHYT, BHTN\r\n☘ Chế độ:\r\nDu lịch hằng năm, hỗ trợ khám sức khoẻ hằng năm, phụ cấp trang phục, .....\r\nĐược học tiếng anh miễn phí, có cơ hội đi nhiệm kỳ nước ngoài\r\n☘ Địa điểm làm việc: phường Bến Nghé, Quận 1.\r\n☘ Mức lương: theo quy định nhà nước, và được bổ sung các khoản thu nhập, thưởng\r\n😍😍 Môi trường làm việc vui vẻ, hoà đồng, thân thiện\r\nMộ tả công việc:\r\nHổ trợ người dùng về hệ thống phần cứng máy vi tính, máy in, fax, camera.\r\nCài đặt cấu hình và sử dụng thành thạo hệ thống phần mềm: hệ điều hành thông thường, hệ điều hành server, phần mềm tiện ích, ứng dụng văn phòng; xử lý các lổi phát sinh.\r\nQuản trị, vận hành các hệ thống quản lý tập trung như Active Directory, Mail server, ảo hóa Vmware...\r\nQuy hoạch và quản trị bảo trì hệ thống mạng ( Tường lửa, Switch, Router, Wi-Fi…)\r\nĐảm bảo máy tính, hệ thống mạng, thiết bị hoạt động hiệu quả.\r\nCó hiểu biết về CSDL SQL, lập trình web.\r\nThực hiện công việc theo phân công của tổ chức.\r\n🌸🌸 YÊU CẦU:\r\n- Có kinh nghiệm ở vị trí tương đương;\r\n- Tốt nghiệp Đại học chuyên ngành Công nghệ thông tin hoặc An toàn thông tin;\r\n- Trung thực, nhanh nhẹn, nhiệt tình.\r\n- Biết tiếng Anh và có chứng chỉ CCNA hoặc MCSA là một lợi thế\r\nCác bạn quan tâm vui lòng gửi CV về địa chỉ mail longlt@mofahcm.gov.vn và liên hệ SĐT: 0909.88.34.20 – Long\r\nHạn nhận hồ sơ đến hết ngày 24-11-2023', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 2),
('BV00000032', 'CD00000005', 'vanlinh', 'Những hiểu lầm về mạng 2G khiến người dân vẫn dùng điện thoại \"cục gạch\"', 'Nhiều người dân vẫn đang suy nghĩ sai lầm khi cho rằng mạng 2G an toàn, khó bị tấn công mạng hay lừa đảo như dùng smartphone, hoặc cho con trẻ dùng điện thoại “cục gạch” để dễ dàng quản lý chi phí và hạn chế những hệ lụy khi dùng mạng Internet…\r\n\r\nTuy nhiên, theo nhiều nghiên cứu thực tế và chia sẻ từ các chuyên gia công nghệ, mạng 2G ngày càng bộc lộ nhiều điểm yếu khiến người dùng dễ bị tấn công mạng, theo dõi thu thập thông tin cá nhân và các hành vi lừa đảo.\r\nDễ bị tấn công nếu vẫn dùng mạng 2G\r\nNhiều khảo sát đã cho thấy mạng 2G sử dụng mã hóa yếu hơn so với các phiên bản mạng di động cao cấp hơn. Mã hóa yếu này làm cho thông tin gửi qua mạng 2G dễ bị giải mã và đánh cắp bởi những kẻ tấn công với các kỹ thuật mã hóa phức tạp. Chẳng hạn, người dùng mạng 2G có thể bị kẻ gian tấn công bằng kỹ thuật “IMSI Catching“ để lấy thông tin về thiết bị và người dùng hoặc kỹ thuật “Call Interception” để nghe lén cuộc gọi và tin nhắn. Điều này có thể dẫn đến việc lộ thông tin cá nhân và các dữ liệu như nội dung cuộc gọi/tin nhắn/vị trí của người dùng và bị kẻ gian sử dụng cho các mục đích xấu.\r\n\r\nTheo các chuyên gia, mạng 2G thường dễ bị lợi dụng để phát tán tin nhắn rác và thực hiện các hoạt động lừa đảo như tin nhắn lừa đảo về tài khoản ngân hàng hoặc các chiêu trò lừa đảo khác. Đặc biệt, kẻ tấn công có thể mạo danh số điện thoại để thực hiện cuộc gọi giả mạo và lừa đảo người dùng. Điều này có thể dẫn đến việc người dùng tiết lộ thông tin cá nhân hoặc thực hiện các hành động không mong muốn.\r\n\r\nMạng 2G không “an toàn” như nhiều người vẫn lầm tưởng\r\nMạng 2G không “an toàn” như nhiều người vẫn lầm tưởng. Ảnh: Viettel\r\n\r\nMột trong những chiêu lừa từng hoành hành người dùng điện thoại ở Việt Nam được phát hiện trong thời gian qua là sử dụng trạm phát sóng BTS giả để phát tán tin nhắn lừa đảo. Tính đến nay, cơ quan chức năng đã phát hiện đến hàng chục vụ lừa đảo theo hình thức này. Trong đó có nhiều vụ các đối tượng bị bắt quả tang khi đang dùng trạm BTS giả để phát tán tin nhắn.\r\n\r\nTheo Bộ Thông tin và Truyền thông, các thiết bị của trạm phát sóng giả phát tán tín hiệu đè lên sóng của các nhà mạng, khi đó thuê bao di động kết nối vào trạm phát sóng giả này mà không qua các nhà mạng. Đặc biệt, các thiết bị giả có thể thực hiện hàng ngàn tin nhắn trong 1 phút. Trong nội dung tin nhắn rác thường gắn kèm các link lừa đảo, game độc hại, mạo danh website ngân hàng để lừa đảo…\r\n\r\nNguyên nhân xảy ra tình trạng này do lỗ hổng bảo mật của mạng 2G. Mạng di động này chỉ yêu cầu xác thực người sử dụng điện thoại nhưng không yêu cầu người sử dụng xác thực nhà mạng. Hiện tại, trên thế giới cũng chưa có giải pháp khắc phục triệt để vấn đề này. Cơ quan chức năng cũng thừa nhận việc ngăn chặn tình trạng này chưa thực sự hiệu quả triệt để, các đối tượng vẫn tiếp tục tái diễn sử dụng các trạm thu phát sóng giả để mạo danh tin nhắn tổ chức tài chính, ngân hàng lừa đảo người dùng.\r\n', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 2),
('BV00000033', 'CD00000005', 'kabee', 'Ngân hàng lớn nhất thế giới bị tấn công mạng đã trả tiền chuộc', 'Đại diện của nhóm ransomware Lockbit ngày 13.11 tuyên bố Ngân hàng Công thương Trung Quốc (ICBC) đã trả tiền chuộc sau vụ tấn công mạng vào tuần trước, theo Reuters.​\r\n\r\n\r\n\"Họ đã trả tiền chuộc, giao dịch đã kết thúc\", đại diện Lockbit nói với Reuters thông qua ứng dụng nhắn tin trực tuyến Tox. Hiện chưa có thông tin về phản ứng của ICBC. Theo Bloomberg, ICBC là ngân hàng lớn nhất thế giới xét về giá trị tài sản.\r\nTrước đó, công ty con của ICBC là Công ty Dịch vụ Tài chính ICBC (ICBCFS), trụ sở tại New York (Mỹ), đã bị tấn công mạng vào ngày 8.11 và kéo dài đến ngày 9.11, khiến ICBCFS không thể hoàn tất các giao dịch trái phiếu kho bạc Mỹ. Cuối ngày 9.11, ICBCFS đăng thông cáo trên website xác nhận rằng công ty đã \"gặp phải một cuộc tấn công bằng ransomware (mã độc tống tiền) dẫn đến sự gián đoạn đối với một số hệ thống [dịch vụ tài chính] nhất định\".\r\nVụ ngân hàng lớn nhất thế giới bị tấn công mạng: ngân hàng đã trả tiền chuộc - Ảnh 1.\r\nLogo của Ngân hàng Công thương Trung Quốc (ICBC) được nhìn thấy ở Bắc Kinh (Trung Quốc) ngày 30.3.2016\r\nReuters\r\nĐến ngày 10.11, Reuters dẫn một số nguồn tin tiết lộ vụ tấn công mạng đã khiến ICBCFS tạm thời nợ Ngân hàng New York Mellon 9 (BNY Mellon) 9 tỉ USD do các giao dịch không được giải quyết, khiến ICBC phải bơm vốn vào đơn vị này để giải quyết các giao dịch. Các nguồn tin cho biết thêm BNY Mellon đã được trả khoản nợ đó.\r\n\r\n\r\n\r\n\r\n\r\n\r\nNgân hàng ICBC trả tiền chuộc cho tin tặc\r\nTại sao phải trả tiền chuộc?​\r\nLockbit đã tấn công một số tổ chức lớn trên thế giới trong những tháng gần đây, đánh cắp và rò rỉ dữ liệu nhạy cảm trong trường hợp nạn nhân từ chối trả tiền chuộc. Chỉ trong ba năm, Lockbit đã trở thành mối đe dọa ransomware hàng đầu thế giới, theo Reuters dẫn lời các quan chức Mỹ.\r\nLockbit bị cho là đã tấn công mạng hơn 1.700 tổ chức của Mỹ trong hầu hết mọi lĩnh vực từ dịch vụ tài chính và thực phẩm đến trường học, giao thông vận tải và các cơ quan chính phủ.\r\nGiới chức từ lâu đã khuyến cáo không nên trả tiền cho các nhóm dùng ransomware nhằm phá vỡ mô hình kinh doanh của các bọn tội phạm. Tiền chuộc thường được yêu cầu dưới dạng tiền kỹ thuật số, loại tiền khó bị theo dõi hơn và mang lại sự ẩn danh cho người nhận.\r\nMột số công ty bị tấn công đã âm thầm trả tiền nh', 'daduyet', '2023-11-19 00:01:53', '2023-11-19 00:01:53', NULL, 3),
('BV00000034', 'CD00000006', 'ducnhong', 'Góc cảnh báo việc làm. Lâu quá quên nên giờ mới đăng.', 'Chuyện là đầu tháng 10 mình có rảnh rỗi vì tìm kiếm việc làm thêm. Vì tính chất thời gian học và chuyện nhà không ổn định nên mình chỉ có thể tìm 1 công việc xoay ca linh động nhất có thể. Mình đã tìm tới bảo vệ siêu thị hay gọi sang là Security tại siêu thị Lotte nằm trên đường 23/10. Cùng cảnh là sinh viên, thấy rất tội, mong các bạn có tìm việc, đặc biệt các việc có kí kết hợp đồng hãy đòi hỏi, xem kỹ hợp đồng và giữ 1 bản làm tin. Tâm lý chúng ta khó khăn tìm việc nên rất dễ bị bắt bài, tiền lương không đúng với sức lao động bỏ ra. Hãy cẩn thận khi tìm việc các bạn nhé đặc biệt là những chỗ đăng tuyển quanh năm suốt tháng', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 201),
('BV00000035', 'CD00000006', 'ducnhong', 'Tuyển thợ chụp phụ', 'Không biết trong nhóm trường mình có bạn nào thích và đam mê chụp hình không, bên mình đang tuyển thợ chụp phụ  ( nếu ko biết chụp sẻ đc hướng dẫn chụp ) test trc 1 tuần nếu ok đc thì đi làm có lương tính theo showw hỗ trợ chỗ ăn chỗ ở nha \r\nCảm ơn AD đã duyệt', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 101),
('BV00000036', 'CD00000006', 'ducnhong', 'Xin mọi người một ít thời gian điền khảo sát báo cáo', 'Dạ em chào mọi người.\r\nXin lỗi vì đã làm phiền ạ! Hi vọng mọi người có thể bỏ 1 ít thời gian làm giúp nhóm em bài khảo sát để qua môn Nghiên Cứu Marketing.\r\nCảm ơn mọi người rất nhiều ạ.\r\nNGHIÊN CỨU CÁC YẾU TỐ THIẾT KẾ BAO BÌ ẢNH HƯỞNG ĐẾN HÀNH VI QUYẾT ĐỊNH MUA HÀNG CỦA KHÁCH HÀNG TRONG NGÀNH F&B TẠI NHA TRANG\r\nNhóm mình đang làm một bài nghiên cứu về vấn đề quyết định mua hàng của khách hàng dựa vào yếu tố bao bì, nên mong các bạn khảo sát khách quan nhất để nhóm mình có thể có kết quả khảo sát tốt và khách quan nhất\r\n', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 500),
('BV00000037', 'CD00000006', 'ducnhong', 'Tìm bạn tham gia dự án film ngắn', 'Hello hello các bạn!.\r\nMình đang cần 3 bạn biết chút xíu về quay dựng bằng đt để tham gia cùng dự án film ngắn của mình.\r\nBạn nào chưa có kinh nghiệm được đào tạo từ A —> Á nhen!.\r\nwellcome to me…..hí hí', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 201),
('BV00000038', 'CD00000006', 'ducnhong', 'Tâm sự 20/11 nhoa cả nhà', 'Dạ cho em hỏi 20/11 được nghỉ toàn trưởng hay sao ạ?? Em cảm ơn ạ', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 201),
('BV00000039', 'CD00000007', 'ducnhong', 'Cách học hiệu quả trong môn Toán', 'Học hiệu quả trong môn Toán đòi hỏi sự tổ chức, kế hoạch hóa và sử dụng các phương pháp học tập phù hợp. Dưới đây là một số cách giúp bạn học Toán hiệu quả:\r\n\r\n1. *Xác định mục tiêu học tập:*\r\n   - Xác định những kiến thức cụ thể bạn muốn học.\r\n   - Đặt mục tiêu rõ ràng và đo lường được để theo dõi tiến trình học tập.\r\n\r\n2. *Lập lịch học tập đều đặn:*\r\n   - Phân chia thời gian học thành các đợt ngắn để giữ tinh thần tập trung.\r\n   - Lên kế hoạch học vào các khoảng thời gian khi tâm trí là nhất quán nhất.\r\n\r\n3. *Hiểu rõ kiến thức cơ bản:*\r\n   - Đảm bảo bạn hiểu rõ những kiến thức cơ bản trước khi chuyển sang những phần khó khăn hơn.\r\n   - Xem lại và luyện tập những bài tập căn bản để củng cố kiến thức.\r\n\r\n4. *Sử dụng nhiều nguồn tài nguyên:*\r\n   - Đọc sách giáo trình, bài giảng, và tài liệu tham khảo để nhận được nhiều góc nhìn về một vấn đề.\r\n   - Sử dụng các ứng dụng, video giảng dạy và trang web học trực tuyến.\r\n\r\n5. *Giải bài tập thực hành:*\r\n   - Học Toán không chỉ là việc đọc lý thuyết mà còn là việc thực hành nhiều bài tập.\r\n   - Lựa chọn bài tập đa dạng, từ dễ đến khó, để rèn kỹ năng giải quyết vấn đề.\r\n\r\n6. *Tham gia nhóm học tập:*\r\n   - Thảo luận và giải bài tập cùng các bạn cùng lớp.\r\n   - Nhận xét và giải đáp những thắc mắc của nhau.\r\n\r\n7. *Duy trì sức khỏe tốt:*\r\n   - Ngủ đủ giấc để tăng cường sức mạnh tư duy.\r\n   - Dinh dưỡng cân đối để cung cấp năng lượng cho não.\r\n\r\n8. *Sử dụng kỹ thuật học tập hiệu quả:*\r\n   - Tạo sơ đồ, sơ đồ tư duy để hình dung mối quan hệ giữa các khái niệm.\r\n   - Sử dụng flashcard để ôn tập kiến thức.\r\n\r\n9. *Làm việc chủ động với giáo viên:*\r\n   - Hỏi giáo viên về những điểm mà bạn không hiểu.\r\n   - Tham gia lớp học thêm hoặc những buổi tư vấn giáo viên.\r\n\r\n10. *Tạo phương pháp học tập cá nhân:*\r\n    - Tìm hiểu về cách học tập phù hợp với bản thân.\r\n    - Điều chỉnh kế hoạch học tập dựa trên trải nghiệm cá nhân.', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 200),
('BV00000040', 'CD00000007', 'ducnhong', '5 Phương pháp học tốt môn Lý tưởng cho sinh viên đại học', 'Để học tốt môn Lý tưởng cho sinh viên đại học, bạn có thể thử áp dụng các phương pháp học tập sau đây:\r\n\r\n1. *Hiểu Rõ Các Khái Niệm Cơ Bản:*\r\n   - Bắt đầu từ những khái niệm cơ bản và đảm bảo bạn hiểu chúng rõ ràng.\r\n   - Sử dụng ví dụ và ứng dụng thực tế để giúp bạn kết nối kiến thức với cuộc sống hàng ngày.\r\n\r\n2. *Thực Hành Bài Tập Thường Xuyên:*\r\n   - Lý tưởng là thực hành giải nhiều bài tập và ví dụ khác nhau để rèn kỹ năng giải quyết vấn đề.\r\n   - Chọn những bài tập đa dạng, từ dễ đến khó, để kiểm tra sự hiểu biết và ứng dụng kiến thức.\r\n\r\n3. *Tham Gia Nhóm Học Tập:*\r\n   - Tham gia nhóm học tập hoặc tạo một nhóm học tập với các đồng học cùng lớp.\r\n   - Thảo luận về các khái niệm khó khăn và giải bài tập cùng nhau.\r\n\r\n4. *Sử Dụng Tài Nguyên Học Tập Trực Tuyến:*\r\n   - Sử dụng video giảng dạy, ứng dụng di động, và tài liệu trực tuyến để học mọi lúc, mọi nơi.\r\n   - Tìm kiếm tài nguyên trực tuyến để giải thích các khái niệm phức tạp.\r\n\r\n5. *Tạo Sơ Đồ và Biểu Đồ Tư Duy:*\r\n   - Sử dụng sơ đồ và biểu đồ tư duy để hình dung mối quan hệ giữa các khái niệm.\r\n   - Tạo các biểu đồ lý tưởng, hình ảnh hoặc mô hình hóa để giúp bạn nhớ kiến thức dễ dàng hơn.\r\n\r\nNhớ rằng việc học Lý tưởng đôi khi đòi hỏi sự kiên nhẫn và thực hành liên tục. Hãy duy trì thái độ tích cực, tìm kiếm sự giúp đỡ khi cần, và đặt mục tiêu cụ thể để theo đuổi.', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 200);
INSERT INTO `tblbaiviet` (`maBV`, `maCD`, `taiKhoan`, `tenBV`, `noiDungBV`, `trangThaiBV`, `ngayDangBV`, `ngayDuyetBV`, `ngayChinhSuaBV`, `luotXem`) VALUES
('BV00000041', 'CD00000007', 'ducnhong', 'Hướng dẫn ôn thi môn Hóa hiệu quả', 'Ôn thi môn Hóa hiệu quả đòi hỏi sự tổ chức, kế hoạch hóa và sử dụng phương pháp học tập phù hợp. Dưới đây là một hướng dẫn chi tiết để ôn thi môn Hóa:\r\n\r\n1. *Xác Định Chuẩn Bị:*\r\n   - Đọc kỹ chương trình học của môn Hóa.\r\n   - Xác định những chủ đề quan trọng và trọng tâm của bài kiểm tra.\r\n\r\n2. *Lập Lịch Ôn Thi:*\r\n   - Lên kế hoạch hóa việc ôn tập để đảm bảo bạn ôn đủ mọi chủ đề.\r\n   - Chia thời gian ôn thành các đợt ngắn để giữ tinh thần tập trung.\r\n\r\n3. *Hiểu Rõ Lý Thuyết:*\r\n   - Đọc sách giáo trình và tài liệu giảng dạy.\r\n   - Ghi chú các khái niệm cơ bản và công thức quan trọng.\r\n\r\n4. *Thực Hành Bài Tập:*\r\n   - Giải nhiều bài tập và ví dụ để rèn kỹ năng giải quyết vấn đề.\r\n   - Chọn bài tập từ các nguồn đa dạng để đảm bảo ôn đủ mọi loại bài.\r\n\r\n5. *Sử Dụng Tài Nguyên Trực Tuyến:*\r\n   - Tìm kiếm video giảng dạy trên YouTube hoặc các trang web giáo dục trực tuyến.\r\n   - Sử dụng ứng dụng di động và trang web học tập để ôn mọi lúc, mọi nơi.\r\n\r\n6. *Tham Gia Nhóm Học Tập:*\r\n   - Thảo luận và giải bài tập cùng bạn bè hoặc tham gia các nhóm ôn tập.\r\n   - Trao đổi kiến thức và giải đáp thắc mắc với nhau.\r\n\r\n7. *Làm Sáng Tạo:*\r\n   - Tạo flashcard cho các khái niệm và công thức.\r\n   - Sử dụng mô hình, hình ảnh, hoặc sơ đồ để hình dung mối quan hệ giữa các khái niệm.\r\n\r\n8. *Luyện Tập Với Đề Thi Thử:*\r\n   - Làm đề thi thử để làm quen với định dạng của bài kiểm tra.\r\n   - Kiểm tra thời gian và làm bài thi thử dưới điều kiện giống như thực tế.\r\n\r\n9. *Chú Ý Đến Các Thí Nghiệm:*\r\n   - Hiểu rõ về các phương pháp thí nghiệm và phản ứng hóa học.\r\n   - Nắm vững các kỹ thuật thực hành và biết cách đọc kết quả thí nghiệm.\r\n\r\n10. *Dinh Dưỡng và Nghỉ Ngơi Đủ:*\r\n    - Dinh dưỡng cân đối để duy trì sức khỏe và tăng cường năng lượng.\r\n    - Ngủ đủ giấc để giữ tâm trí tinh thần và tăng cường khả năng tập trung.\r\n\r\n11. *Kiểm Tra Lại và Đánh Giá Bản Thân:*\r\n    - Đánh giá kiến thức của mình bằng cách giải các đề thi mẫu.\r\n    - Xem xét lại những chủ đề mà bạn cảm thấy yếu và ôn lại chúng.\r\n\r\nNhớ rằng ôn thi không chỉ là quá trình học thuộc lòng mà còn là quá trình hiểu và ứng dụng kiến thức. Hãy ôn tập một cách đa dạng và linh hoạt để chuẩn bị tốt cho bài kiểm tra Hóa.', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 200),
('BV00000042', 'CD00000007', 'ducnhong', 'Tổng hợp các câu hỏi ôn thi môn Vật lý đại cương', 'Dưới đây là một số câu hỏi ôn thi môn Vật lý đại cương mà bạn có thể sử dụng để ôn tập. Nhớ kiểm tra câu trả lời của bạn sau mỗi câu hỏi để đảm bảo rằng bạn hiểu rõ kiến thức và chuẩn bị tốt cho kỳ thi.\r\n\r\n1. *Chương Trình Học Vật Lý Đại Cương:*\r\n   - Mô tả chương trình học của môn Vật lý đại cương.\r\n   - Nêu mục tiêu và lợi ích của việc học môn này.\r\n\r\n2. *Động Lực Học Vật Lý:*\r\n   - Tại sao bạn quyết định học Vật lý?\r\n   - Nêu lý do Vật lý là một môn học quan trọng.\r\n\r\n3. *Hệ Đo Lường và Đơn Vị:*\r\n   - Mô tả các hệ đo lường phổ biến trong Vật lý.\r\n   - Nêu đơn vị của các lực, khối lượng, và thời gian.\r\n\r\n4. *Chuyển Động:*\r\n   - Định nghĩa và mô tả chuyển động.\r\n   - Trình bày biểu thức tính vận tốc và gia tốc.\r\n\r\n5. *Lực và Chuyển Động:*\r\n   - Áp dụng Định luật Newton cho các vật thể chuyển động.\r\n   - Trình bày khái niệm về lực trọng trường và lực ma sát.\r\n\r\n6. *Năng Lượng và Công:*\r\n   - Giải thích khái niệm về năng lượng và công.\r\n   - Mô tả quan hệ giữa năng lượng và công.\r\n\r\n7. *Điện:*\r\n   - Trình bày cấu trúc của nguyên tử và các hạt điện tích.\r\n   - Mô tả các đặc điểm của dòng điện và điện trường.\r\n\r\n8. *Quang Học:*\r\n   - Nêu các đặc điểm cơ bản của ánh sáng.\r\n   - Mô tả các hiện tượng quang học như tán xạ và giao thoa.\r\n\r\n9. *Nhiệt Độ và Nhiệt Động Lực Học:*\r\n   - Trình bày cách đo nhiệt độ và các đặc tính của chất nhiệt độ.\r\n   - Giải thích các nguyên lý cơ bản của nhiệt động lực học.\r\n\r\n10. *Âm Nhạc và Sóng:*\r\n    - Trình bày cấu trúc sóng và âm nhạc.\r\n    - Mô tả các hiện tượng sóng như giao thoa và tán xạ.\r\n\r\n11. *Vật Lý Hiện Đại:*\r\n    - Trình bày các khái niệm cơ bản của vật lý hiện đại.\r\n    - Mô tả những phát hiện quan trọng trong lĩnh vực này.\r\n\r\nNhớ rằng, việc ôn tập càng hiệu quả khi bạn kết hợp nó với việc giải nhiều bài tập thực hành và làm các đề thi mẫu.', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 200),
('BV00000043', 'CD00000007', 'ducnhong', 'Cách nắm vững kiến thức môn Sinh học đại cương', 'Để nắm vững kiến thức môn Sinh học đại cương, bạn có thể thực hiện những bước sau đây:\r\n\r\n1. *Hiểu Rõ Chương Trình Học:*\r\n   - Đọc và hiểu rõ chương trình học của môn Sinh học.\r\n   - Xác định những chủ đề quan trọng và mối liên quan giữa chúng.\r\n\r\n2. *Tạo Lịch Ôn Tập:*\r\n   - Lập lịch ôn tập theo từng chủ đề để đảm bảo bạn ôn đủ mọi phần.\r\n   - Phân chia thời gian ôn thành các đợt ngắn để giữ tinh thần tập trung.\r\n\r\n3. *Sử Dụng Nhiều Nguồn Tài Nguyên:*\r\n   - Sử dụng sách giáo trình, bài giảng, và tài liệu tham khảo để có góc nhìn đa dạng về kiến thức.\r\n   - Tìm kiếm tài nguyên trực tuyến, video giảng dạy, và các ứng dụng học tập.\r\n\r\n4. *Thực Hành Giải Bài Tập và Ví Dụ:*\r\n   - Làm nhiều bài tập và ví dụ để áp dụng kiến thức vào các tình huống thực tế.\r\n   - Chọn bài tập từ dễ đến khó để từ từ nâng cao khả năng hiểu biết.\r\n\r\n5. *Tham Gia Nhóm Học Tập:*\r\n   - Tham gia nhóm học tập hoặc tự tạo một nhóm ôn tập cùng các bạn cùng lớp.\r\n   - Thảo luận và trao đổi kiến thức với nhau để hiểu sâu hơn.\r\n\r\n6. *Sử Dụng Hình Ảnh và Sơ Đồ:*\r\n   - Vẽ sơ đồ, biểu đồ, và hình ảnh để hình dung mối quan hệ giữa các khái niệm.\r\n   - Sử dụng hình ảnh để ghi nhớ các cấu trúc và quy trình sinh học.\r\n\r\n7. *Kết Hợp Lý Thuyết và Thực Hành:*\r\n   - Kết hợp giảng dạy lý thuyết với thực hành thí nghiệm nếu có thể.\r\n   - Hiểu rõ quy trình thực hành và tác động của nó đến lý thuyết.\r\n\r\n8. *Tạo Flashcard và Ghi Chú:*\r\n   - Tạo flashcard với các khái niệm chính và công thức quan trọng.\r\n   - Ghi chú từ những thông tin quan trọng trong sách giáo trình và bài giảng.\r\n\r\n9. *Kiểm Tra Bản Thân:*\r\n   - Tổ chức các bài kiểm tra nhỏ để kiểm tra hiểu biết của bạn về mỗi chủ đề.\r\n   - Đặt câu hỏi cho bản thân và giải đáp chúng.\r\n\r\n10. *Sử Dụng Ứng Dụng và Simulations:*\r\n    - Sử dụng ứng dụng di động và phần mềm mô phỏng để thấy rõ các quá trình sinh học.\r\n    - Tham gia các bài giảng trực tuyến và các mô phỏng để tăng cường hiểu biết.\r\n\r\n11. *Thực Hiện Các Dự Án và Bài Nghiên Cứu:*\r\n    - Nếu có cơ hội, thực hiện các dự án và bài nghiên cứu liên quan đến môn học.\r\n    - Áp dụng kiến thức vào thực tế để nắm vững sâu sắc hơn.\r\n\r\nNhớ rằng, sự hiểu biết sâu rộng của môn Sinh học đại cương đòi hỏi sự kiên nhẫn và thực hành liên tục. Hãy duy trì thái độ tích cực và tìm kiếm sự giúp đỡ khi cần thiết.', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 200),
('BV00000044', 'CD00000008', 'ducnhong', 'Các nhà nghiên cứu bảo mật luôn khuyến cáo người dùng nên sử dụng trình quản lý mật khẩu , vậy lý do của việc này là gì?', 'Chuyên gia bảo mật luôn khuyên người dùng nên sử dụng nhiều mật khẩu khác nhau cho các tài khoản trực tuyến để tránh rủi ro rò rỉ dữ liệu. Tuy nhiên làm sao để nhớ mọi mật khẩu khi mỗi người đang sở hữu nhiều tài khoản khác nhau như mạng xã hội, email, dịch vụ mạng, tài khoản ngân hàng?\r\n\r\nMột giải pháp đang được nhiều người lựa chọn là sử dụng phần mềm quản lý mật khẩu để hỗ trợ ghi thay bạn.\r\n\r\nPhần mềm quản lý ứng dụng là phần mềm ghi nhớ mật khẩu thay bạn, tương tự như một quyển sổ ghi chép mật khẩu. Tiện ích này là sẽ lưu và nhớ mật khẩu cho bạn, phòng trường hợp bạn đặt một mật khẩu cho tài khoản của mình rồi lại quên mất ngay sau đó.', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 200),
('BV00000045', 'CD00000008', 'ducnhong', 'Nâng cao kiến thức cho các chuyên gia bảo mật Việt Nam qua tình huống mô phỏng', 'Cuộc thi an ninh mạng ‘Fortinet Security Fabric Range Challenge’ vừa được tổ chức, với mục đích tạo cơ hội cho các chuyên gia bảo mật Việt Nam được trải nghiệm nhiều tình huống tấn công mạng mô phỏng. https://vietnamnet.vn/nang-cao-kien-thuc-cho-cac-chuyen-gia-bao-mat-viet-nam-qua-tinh-huong-mo-phong-2215669.html', 'daduyet', '2023-11-19 00:21:48', '2023-11-19 00:21:48', NULL, 200),
('BV00000046', 'CD00000008', 'nguyenduy', 'Ba lưu ý bảo mật khi xây dựng mạng 5G độc lập', 'Các doanh nghiệp chọn xây dựng mạng 5G riêng thay vì chọn mạng từ nhà cung cấp cơ sở hạ tầng chuyên dụng thường dựa trên nhận định mạng 5G độc lập có khả năng an toàn và kiểm soát nhiều hơn đối với các luồng dữ liệu.\r\nSong, nếu chưa từng vận hành một mạng lưới như vậy trước đó, mục tiêu bảo vệ dữ liệu người dùng và hệ thống có thể trở thành thách thức.\r\n\r\n“Về mặt bảo mật, 5G cực kỳ an toàn”, William Webb, thành viên của IEEE và Giám đốc công nghệ tại Access Partnership, nói với Insider. \"Tương tự như 4G, các yếu tố bảo mật mới được thiết kế theo tiêu chuẩn và cho đến nay vẫn chưa phát hiện vi phạm nào đáng kể trên mạng 5G”.\r\n\r\nDù vậy, các chuyên gia trong lĩnh vực cũng thừa nhận vẫn tồn tại những rủi ro trong quá trình xây dựng cơ sở hạ tầng CNTT doanh nghiệp với 5G là trung tâm.\r\n\r\nCảnh giác với tương tác bên ngoài hệ thống\r\n\r\n5G vốn là một công nghệ an toàn, song chỉ hoạt động tốt khi có “không gian vùng đệm” giữa mạng độc lập kết hợp cơ sở hạ tầng CNTT khác. Đây cũng chính là khu vực có nhiều khả năng phát sinh rủi ro bảo mật.\r\nĐể giảm thiểu các mối đe dọa, Sandhu gợi ý cần áp dụng “chính sách bảo mật hiện có đối với 5G tương tự như mạng doanh nghiệp”.\r\n“Rủi ro bảo mật sẽ phát sinh bên ngoài mạng 5G, chẳng hạn khi mạng CNTT doanh nghiệp bị xâm nhập”, Webb nói. “Nếu mạng doanh nghiệp không được đảm bảo an toàn, thì đó sẽ là cửa ngõ để tin tặc xâm nhập hệ thống 5G thông qua giao diện điều khiển”.\r\n\r\nParm Sandhu, Phó Chủ tịch phụ trách các sản phẩm và dịch vụ 5G dành cho doanh nghiệp tại NTT Ltd, cho hay, mặc dù 5G là an toàn nhưng “người ta vẫn thường tích hợp một ứng dụng vào trung tâm dữ liệu doanh nghiệp, để kết nối nhiều thiết bị, từ đó làm tăng mức độ rủi ro cả hệ thống”.\r\n\r\nNguy cơ tương tự như trên “đám mây”\r\n\r\nMặc dù 5G được coi là an toàn hơn các công nghệ kết nối khác, song nó vẫn thuộc diện sử dụng công khai, ngay cả đó là mạng lưới độc lập. Nguyên nhân là do công cụ và công nghệ truy cập mạng 5G về bản chất là công khai, nên sẽ dẫn đến những rủi ro tương tự.\r\n\r\n“5G cũng tận dụng công nghệ đám mây và ảo hóa, do đó, đương nhiên nó thừa hưởng nhiều thách thức mà CNTT và đám mây phải đối mặt”, Aarthi Krishna, người đứng đầu toàn cầu về bảo mật công nghiệp thông minh tại Capgemini cho biết. “Tuy nhiên, hiện nay, việc giám sát mạng 5G đang yêu cầu các yếu tố khác so với mạng IT và OT do công cụ giám sát không được xây dựng để điều chỉnh trực tiếp môi trường di động”. \r\n\r\nMối đe doạ gia tăng theo quy mô sử dụng\r\n\r\nMột trong những lợi ích chính của 5G là khả năng sử dụng theo nhiều cách, từ cung cấp năng lượng cho Internet vạn vật (IoT), đến khả năng xử lý biên cho hàng triệu người dùng trên thiết bị di động.\r\n\r\n“Khi phạm vi toàn cầu của 5G mở rộng, rủi ro bảo mật liên quan cũng tăng theo”, Krishna chia sẻ. “Các vấn đề bảo mật trong 5G phát sinh từ việc triển khai phức tạp và bề mặt tấn công mở rộng do nhiều thiết bị và dữ liệu cần được bảo vệ”.\r\n\r\nDo đó, điều quan trọng là phải liên tục đánh giá quy mô hoạt động của mạng 5G theo thời gian thực. “Lưu lượng truy cập vào và ra khỏi tất cả các điểm vào mạng 5G cần được theo dõi và kiểm tra để phát hiện các mối đe dọa”, Sandhu đề xuất.\r\n\r\nVà để làm được điều này, chuyên gia trong ngành cũng gợi ý các công ty cần đảm bảo ngay từ đầu cấu hình mạng đúng cách. “Đối với triển khai quy mô doanh nghiệp, cần tránh tách biệt cấu trúc mặt điều khiển và người dùng, do nó là điều không cần thiết, đồng thời làm tăng bề mặt tấn công tiềm năng”.', 'daduyet', '2023-11-19 00:38:49', '2023-11-19 00:38:49', NULL, 200),
('BV00000047', 'CD00000008', 'thanhmai', 'Xuất hiện mã độc xuyên thủng khả năng bảo mật điện thoại Android', 'Vụ này tụi nó dùng email giả nhân viên Apple để lừa lấy câu hỏi bảo mật của bọn nghệ sĩ mà, chứ hack cc gì được iCloud.', 'daduyet', '2023-11-19 00:38:49', '2023-11-19 00:38:49', NULL, 201),
('BV00000048', 'CD00000008', 'truongminh', 'Chia sẻ kiến thức và kinh nghiệm làm đồ án CNTT', 'Trong quá trình làm đồ án CNTT, chúng ta có thể đối mặt với nhiều thách thức và học hỏi được nhiều điều mới. Việc chia sẻ kiến thức và kinh nghiệm làm đồ án không chỉ giúp tăng cường kiến thức cá nhân mà còn là cơ hội để học hỏi từ những góc nhìn khác nhau. Bài viết này sẽ chia sẻ một số kinh nghiệm và kiến thức quan trọng trong quá trình làm đồ án CNTT. Chúc các bạn đọc bài viết vui vẻ và hữu ích!', 'daduyet', '2023-11-19 00:38:49', '2023-11-19 00:38:49', NULL, 201),
('BV00000049', 'CD00000009', 'hoangtrang', 'Chia sẻ kinh nghiệm làm đồ án CNTT: Học hỏi và vượt qua thách thức', 'Trong quá trình thực hiện đồ án CNTT, mình đã gặp phải nhiều thách thức nhưng qua đó, mình cũng học được rất nhiều điều mới mẻ. Bài viết này là sự chia sẻ của mình về những kinh nghiệm và cách vượt qua những thách thức trong quá trình làm đồ án CNTT. Mong rằng sẽ hữu ích cho các bạn đang theo đuổi ngành CNTT.', 'daduyet', '2023-11-19 00:38:49', '2023-11-19 00:38:49', NULL, 201),
('BV00000050', 'CD00000009', 'trungtam', 'Chia sẻ kinh nghiệm: Quy trình làm đồ án CNTT hiệu quả', 'Trong quá trình làm đồ án CNTT, việc áp dụng một quy trình làm việc hiệu quả có vai trò quan trọng. Bài viết này sẽ chia sẻ về quy trình mà mình đã áp dụng để hoàn thành đồ án một cách thành công. Hy vọng sẽ là nguồn cảm hứng cho các bạn đang chuẩn bị làm đồ án.', 'daduyet', '2023-11-19 00:38:49', '2023-11-19 00:38:49', NULL, 200),
('BV00000051', 'CD00000009', 'kimthanh', 'Bí quyết hoàn thành đồ án CNTT một cách xuất sắc', 'Đồ án CNTT không chỉ là bài kiểm tra kiến thức mà còn là cơ hội để thể hiện bản lĩnh và kỹ năng thực tế. Bài viết này sẽ chia sẻ những bí quyết giúp bạn hoàn thành đồ án CNTT một cách xuất sắc. Hãy cùng nhau khám phá!', 'daduyet', '2023-11-19 00:38:49', '2023-11-19 00:38:49', NULL, 201),
('BV00000052', 'CD00000009', 'vanlinh', 'Chia sẻ kiến thức: Xử lý vấn đề trong đồ án CNTT', 'Trong quá trình làm đồ án CNTT, việc gặp phải các vấn đề là điều không tránh khỏi. Bài viết này sẽ chia sẻ những kinh nghiệm và cách xử lý vấn đề một cách hiệu quả. Hy vọng sẽ giúp ích cho các bạn đang đối mặt với những khó khăn trong quá trình làm đồ án.', 'daduyet', '2023-11-19 00:38:49', '2023-11-19 00:38:49', NULL, 200),
('BV00000053', 'CD00000009', 'vanlinh', 'Chia sẻ kiến thức: Hướng dẫn thực hiện đồ án CNTT', 'Đồ án CNTT đòi hỏi sự chăm chỉ, kiên trì và kiến thức chuyên sâu. Bài viết này sẽ hướng dẫn chi tiết về cách thực hiện đồ án CNTT một cách hiệu quả. Cùng nhau tìm hiểu và chia sẻ kinh nghiệm nhé!', 'daduyet', '2023-11-19 00:38:49', '2023-11-19 00:38:49', NULL, 200);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblbvvipham`
--

CREATE TABLE `tblbvvipham` (
  `maBV` varchar(10) NOT NULL,
  `maLoaiVP` varchar(10) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblbvvipham`
--

INSERT INTO `tblbvvipham` (`maBV`, `maLoaiVP`, `taiKhoan`) VALUES
('BV00000047', 'VP00000003', 'kabee');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblbvyeuthich`
--

CREATE TABLE `tblbvyeuthich` (
  `maBV` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblchantinnhan`
--

CREATE TABLE `tblchantinnhan` (
  `maChanTN` int(128) NOT NULL,
  `tenTN` varchar(50) NOT NULL,
  `nguoiChan` varchar(100) NOT NULL,
  `nguoiBiChan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblchantinnhan`
--

INSERT INTO `tblchantinnhan` (`maChanTN`, `tenTN`, `nguoiChan`, `nguoiBiChan`) VALUES
(3, 'hienhuynh_kabee', 'kabee', 'hienhuynh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblchudebv`
--

CREATE TABLE `tblchudebv` (
  `maCD` varchar(10) NOT NULL,
  `tenCD` varchar(255) NOT NULL,
  `anhCD` varchar(255) NOT NULL,
  `trangThaiCD` enum('khoa','hoatdong') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblchudebv`
--

INSERT INTO `tblchudebv` (`maCD`, `tenCD`, `anhCD`, `trangThaiCD`) VALUES
('CD00000001', 'Lập trình', 'chude1.png', 'hoatdong'),
('CD00000002', 'Android', 'chude2.png', 'khoa'),
('CD00000003', 'Thủ thuật', 'chude3.png', 'hoatdong'),
('CD00000004', 'Trí tuệ nhân tạo', 'ai.jpg', 'hoatdong'),
('CD00000005', 'Mạng máy tính ', 'mangmaytinh.jpg', 'hoatdong'),
('CD00000006', 'Chuyện vặt NTU', 'ntu.jpg', 'hoatdong'),
('CD00000007', 'Đại cương NTU', 'daicuong.jpg', 'hoatdong'),
('CD00000008', 'Bảo mật', 'baomat.jpg', 'hoatdong'),
('CD00000009', 'Chia sẻ dự án lập trình', 'chiaseduanlaptrinh.jpg', 'hoatdong'),
('CD00000010', 'Sự kiện và thông tin mới', 'sukienvathongtinmoi.jpg', 'hoatdong');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbldinhdangtl`
--

CREATE TABLE `tbldinhdangtl` (
  `maDD` varchar(10) NOT NULL,
  `tenDD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbldinhdangtl`
--

INSERT INTO `tbldinhdangtl` (`maDD`, `tenDD`) VALUES
('DD00000001', 'PPTX'),
('DD00000002', 'PDF'),
('DD00000003', 'DOCX');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblloaitailieu`
--

CREATE TABLE `tblloaitailieu` (
  `maLoaiTL` varchar(10) NOT NULL,
  `tenLoaiTL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblloaitailieu`
--

INSERT INTO `tblloaitailieu` (`maLoaiTL`, `tenLoaiTL`) VALUES
('PLTL000001', 'Cơ sở dữ liệu'),
('PLTL000002', 'Lập trình'),
('PLTL000003', 'Đồ án');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblloaivipham`
--

CREATE TABLE `tblloaivipham` (
  `maLoaiVP` varchar(10) NOT NULL,
  `tenLoaiVP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblloaivipham`
--

INSERT INTO `tblloaivipham` (`maLoaiVP`, `tenLoaiVP`) VALUES
('VP00000001', 'Quấy rối bắt nạt qua mạng'),
('VP00000002', 'Spam'),
('VP00000003', 'Ngôn từ gây thù ghét'),
('VP00000004', 'Bán hàng trái phép'),
('VP00000005', 'Nội dung khiêu dâm');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblnguoidung`
--

CREATE TABLE `tblnguoidung` (
  `taiKhoan` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `matKhau` varchar(100) NOT NULL,
  `quyen` enum('quantrivien','nguoidung','nguoidungbichan') NOT NULL DEFAULT 'nguoidung',
  `hoND` varchar(100) NOT NULL,
  `tenND` varchar(255) NOT NULL,
  `ngaySinh` date NOT NULL,
  `anhDaiDien` varchar(255) NOT NULL DEFAULT 'user.png',
  `xacThuc` enum('daxacminh','chuaxacminh') NOT NULL DEFAULT 'chuaxacminh',
  `trangThai` enum('hoatdong','ban','dunghoatdong') NOT NULL DEFAULT 'dunghoatdong'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblnguoidung`
--

INSERT INTO `tblnguoidung` (`taiKhoan`, `email`, `matKhau`, `quyen`, `hoND`, `tenND`, `ngaySinh`, `anhDaiDien`, `xacThuc`, `trangThai`) VALUES
('ducnhong', 'nhong.nnd.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Nguyễn', 'Ngọc Đức Nhông', '2002-01-21', 'nuno.jpg', 'daxacminh', 'dunghoatdong'),
('hathanh', 'thanh.ha@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Hà', 'Thanh', '1997-01-31', 'hathanh.jpg', 'daxacminh', 'dunghoatdong'),
('hienhuynh', 'hien.ht.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Huỳnh', 'Thanh Hiền', '2002-09-25', 'thanhhien.jpg', 'daxacminh', 'dunghoatdong'),
('hienhuynh1', 'hien37211@gmail.com', '$2y$12$g67m.aCv4gr92D/5K1syOebBYXI1mcHFbSbx1r/sMmbRwmjdZh1Bi', 'nguoidung', 'hádf', 'fsjdf', '2000-06-18', 'user.png', 'daxacminh', 'dunghoatdong'),
('hienhuynh2', 'hien@gmail.com', '$2y$12$8gXXBzIOgN4r48f0NDB14OoD6qCilmq2oVUfGVMrz8cC33BAkh60q', 'nguoidung', 'hádf', 'fsjdf', '2000-06-18', 'user.png', 'chuaxacminh', 'dunghoatdong'),
('hoangtrang', 'trang.hoang@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Hoàng', 'Trang', '2000-02-28', 'hoangtrang.jpg', 'daxacminh', 'dunghoatdong'),
('kabee', 'kiet.nt.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'quantrivien', 'Nguyễn', 'Tuấn Kiệt', '2002-09-08', 'kabee.jpg', 'daxacminh', 'hoatdong'),
('kimthanh', 'thanh.kim@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Kim', 'Thanh', '1987-10-05', 'kimthanh.png', 'daxacminh', 'dunghoatdong'),
('lananh', 'anh.lan@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Lan', 'Anh', '1999-04-18', 'lananh.png', 'daxacminh', 'dunghoatdong'),
('nguyenduy', 'duy.nguyen@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Nguyễn', 'Duy', '1990-05-20', 'nguyenduy.jpg', 'daxacminh', 'dunghoatdong'),
('phuongha', 'ha.ptp.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Phan', 'Thị Phương Hà', '2002-01-21', 'phuongha.jpg', 'daxacminh', 'dunghoatdong'),
('quantrivien', 'ithub.@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'quantrivien', 'Quản', 'Trị Viên', '2002-09-08', 'quantri.jpg', 'daxacminh', 'dunghoatdong'),
('thanhmai', 'mai.thanh@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Thanh', 'Mai', '1988-09-15', 'thanhmai.jpg', 'daxacminh', 'dunghoatdong'),
('thienlan', 'lan.pnt.62cntt@ntu.edu.vn', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidungbichan', 'Phạm', 'Nguyễn Thiên Lân', '2002-12-23', 'thienlan.jpg', 'daxacminh', 'dunghoatdong'),
('thituyet', 'tuyet.thi@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Thi', 'Tuyết', '1992-07-10', 'thituyet.png', 'daxacminh', 'dunghoatdong'),
('trungtam', 'tam.trung@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Trung', 'Tâm', '1985-06-25', 'trungtam.png', 'daxacminh', 'dunghoatdong'),
('truongminh', 'minh.truong@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Trương', 'Minh', '1995-12-03', 'truongminh.png', 'daxacminh', 'dunghoatdong'),
('vanlinh', 'linh.van@gmail.com', '$2y$10$gNRx4lOFIVxxbcGPoi/S9eHjIKDQrzT7gTZKjGDpJuyEzpNy45ZOa', 'nguoidung', 'Văn', 'Linh', '1993-08-12', 'vanlinh.jpeg', 'daxacminh', 'dunghoatdong');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblquantribv`
--

CREATE TABLE `tblquantribv` (
  `maQuanTri` varchar(50) NOT NULL,
  `maCD` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblquantribv`
--

INSERT INTO `tblquantribv` (`maQuanTri`, `maCD`) VALUES
('kabee', 'CD00000001'),
('kabee', 'CD00000002'),
('kabee', 'CD00000003');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblquantritl`
--

CREATE TABLE `tblquantritl` (
  `maQuanTri` varchar(50) NOT NULL,
  `maLoaiTL` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblquantritl`
--

INSERT INTO `tblquantritl` (`maQuanTri`, `maLoaiTL`) VALUES
('kabee', 'PLTL000001'),
('kabee', 'PLTL000002'),
('kabee', 'PLTL000003');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbltailieu`
--

CREATE TABLE `tbltailieu` (
  `maTL` varchar(10) NOT NULL,
  `maLoaiTL` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL,
  `maDD` varchar(10) NOT NULL,
  `tenTL` varchar(255) NOT NULL,
  `moTaTL` text NOT NULL,
  `fileTL` varchar(255) NOT NULL,
  `ngayDangTL` datetime NOT NULL DEFAULT current_timestamp(),
  `ngayDuyetTL` datetime DEFAULT NULL,
  `anhTL` varchar(255) NOT NULL,
  `trangThaiTL` enum('daduyet','chuaduyet') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbltailieu`
--

INSERT INTO `tbltailieu` (`maTL`, `maLoaiTL`, `taiKhoan`, `maDD`, `tenTL`, `moTaTL`, `fileTL`, `ngayDangTL`, `ngayDuyetTL`, `anhTL`, `trangThaiTL`) VALUES
('TL00000001', 'PLTL000001', 'kabee', 'DD00000002', 'Giáo trình hệ quản trị cơ sở dữ liệu', 'Các trúc này bao gồm ít nhất một tập tin dữ liệu (data file) và một tập tin viết thao tác (transaction log file). Hiểu cách thức Microsoft SQL Server.', 'hqtcsdl.pdf', '2023-09-21 08:45:23', '2023-10-08 08:50:23', 'hqtcsdl.jpg', 'daduyet'),
('TL00000002', 'PLTL000002', 'ducnhong', 'DD00000002', 'Hướng dẫn lập trình Python', 'Hướng dẫn lập trình Python từ cơ bản đến nâng cao. Bao gồm ví dụ và bài tập thực hành.', 'python.pdf', '2023-09-21 08:45:23', '2023-10-08 08:50:23', 'python.jpg', 'daduyet'),
('TL00000003', 'PLTL000003', 'hienhuynh', 'DD00000002', 'Đồ án môn Toán rời rạc', 'Bài tập và đồ án môn Toán rời rạc cho sinh viên ngành Công nghệ thông tin.', 'trr.pdf', '2023-09-21 08:45:23', '2023-10-08 08:50:23', 'trr.jpg', 'daduyet'),
('TL00000004', 'PLTL000001', 'thienlan', 'DD00000002', 'Phát triển mã nguồn mở ', 'Phần mềm nguồn mở (Open source software – OSS) là phần mềm được phân phối cùng với mã nguồn, do đó, luôn sẵn sàng đối với việc sử dụng, sửa đổi và chia sẻ quyền truy cập. \n\nMã nguồn là một phần của phần mềm mà hầu hết người dùng không bao giờ thấy. Đó là mã được các lập trình viên máy tính thiết lập để kiểm soát hoạt động của một chương trình hoặc ứng dụng. Các lập trình viên có quyền truy cập vào mã nguồn, tiến hành các thay đổi chương trình bằng cách thêm hoặc sửa chữa các phần trong đó. OSS thường bao gồm một giấy phép cho phép các lập trình viên sửa đổi phần mềm để phù hợp nhất với nhu cầu của họ và kiểm soát cách phần mềm có thể được phân phối.', 'upload-tailieu/', '2023-11-15 19:53:48', '2023-11-15 19:56:43', 'php.png', 'daduyet'),
('TL00000005', 'PLTL000002', 'kabee', 'DD00000002', 'Quản lí dự án ', 'Quản lý dự án là ngành khoa học nghiên cứu về việc lập kế hoạch, tổ chức và quản lý, giám sát quá trình phát triển của dự án nhằm đảm bảo cho dự án hoàn thành đúng thời gian, trong phạm vi ngân sách đã được duyệt, đảm bảo chất lượng, đạt được mục tiêu cụ thể của dự án và các mục đích đề ra', 'upload-tailieu/', '2023-11-16 20:32:54', '2023-11-16 20:33:03', 'qlda.jpg', 'daduyet'),
('TL00000020', 'PLTL000001', 'hienhuynh', 'DD00000002', 'Trí tuệ nhân tạo', 'Trong khoa học máy tính, trí tuệ nhân tạo hay AI (tiếng Anh: artificial intelligence), đôi khi được gọi là trí thông minh nhân tạo, là trí thông minh được thể hiện bằng máy móc, trái ngược với trí thông minh tự nhiên của con người. Thông thường, thuật ngữ \"trí tuệ nhân tạo\" thường được sử dụng để mô tả các máy chủ móc (hoặc máy tính) có khả năng bắt chước các chức năng \"nhận thức\" mà con người thường phải liên kết với tâm trí, như \"học tập\" và \"giải quyết vấn đề\".[1][2][3]', 'upload-tailieu/', '2023-11-17 05:17:10', '2023-11-17 05:46:51', 'ai.jpg', 'daduyet'),
('TL00000025', 'PLTL000001', 'hienhuynh', 'DD00000002', 'Hệ quản trị MySQL', 'MySQL là một hệ thống quản lý cơ sở dữ liệu quan hệ mã nguồn mở (RDBMS) dựa trên ngôn ngữ truy vấn có cấu trúc ( SQL) được phát triển, phân phối và hỗ trợ bởi tập đoàn Oracle. MySQL chạy trên hầu hết tất cả các nền tảng, bao gồm cả Linux , UNIX và Windows. MySQL thường được kết hợp với các ứng dụng web.', 'mysql.png', '2023-11-17 05:25:42', '2023-11-17 19:52:37', 'mysql.png', 'daduyet'),
('TL00000026', 'PLTL000001', 'hienhuynh1', 'DD00000002', 'Tài liệu 5', 'Đây là tài liệu', 'upload-tailieu/CV-HuynhThanhHien-NTU-INTER-Gravity-Global.pdf', '2023-11-17 23:31:57', '2023-11-17 23:37:01', 'h.jpg', 'daduyet');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblthaoluanbv`
--

CREATE TABLE `tblthaoluanbv` (
  `maTLBV` varchar(10) NOT NULL,
  `maBV` varchar(10) NOT NULL,
  `maPhanHoi` varchar(10) NOT NULL DEFAULT '0',
  `taiKhoan` varchar(50) NOT NULL,
  `noiDungTLBV` text NOT NULL,
  `trangThaiTLBV` enum('dadang','chinhsua','khoa') NOT NULL,
  `ngayDangTLBV` datetime NOT NULL DEFAULT current_timestamp(),
  `ngayChinhSuaTLBV` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblthaoluanbv`
--

INSERT INTO `tblthaoluanbv` (`maTLBV`, `maBV`, `maPhanHoi`, `taiKhoan`, `noiDungTLBV`, `trangThaiTLBV`, `ngayDangTLBV`, `ngayChinhSuaTLBV`) VALUES
('TL00000001', 'BV00000001', '0', 'kabee', 'Làm thế nào để xác định lỗi \"segmentation fault\" trong chương trình C của bạn?', 'chinhsua', '2023-10-08 08:45:23', '2023-10-08 10:28:56'),
('TL00000002', 'BV00000001', 'TL00000001', 'kabee', 'Để xác định lỗi \"segmentation fault\" trong chương trình C của bạn, bạn nên sử dụng các công cụ như GDB hoặc Valgrind để gỡ lỗi và xem thông báo lỗi chi tiết.', 'dadang', '2023-10-09 10:27:43', NULL),
('TL00000003', 'BV00000001', 'TL00000002', 'hienhuynh', '<p>aloalo</p>', 'dadang', '2023-11-07 15:29:15', NULL),
('TL00000004', 'BV00000001', 'TL00000003', 'kabee', '<p>bieets goif</p>', 'dadang', '2023-11-07 15:33:20', NULL),
('TL00000005', 'BV00000001', 'TL00000003', 'kabee', '<p>alo</p>', 'dadang', '2023-11-07 15:33:55', NULL),
('TL00000006', 'BV00000001', 'TL00000005', 'hienhuynh', '<p>bieets goif</p>', 'dadang', '2023-11-07 15:35:15', NULL),
('TL00000007', 'BV00000001', 'TL00000003', 'kabee', '<p>aol</p>', 'dadang', '2023-11-15 21:06:03', NULL),
('TL00000008', 'BV00000001', 'TL00000006', 'kabee', '<p>ok</p>', 'dadang', '2023-11-15 21:11:57', NULL),
('TL00000009', 'BV00000010', '0', 'kabee', '<p>ffff</p>', 'dadang', '2023-11-17 12:12:54', NULL),
('TL00000010', 'BV00000010', '0', 'kabee', '<p>ff</p>', 'dadang', '2023-11-17 12:13:03', NULL),
('TL00000011', 'BV00000010', 'TL00000010', 'kabee', '<p>hh</p>', 'dadang', '2023-11-17 12:14:32', NULL),
('TL00000012', 'BV00000010', '0', 'kabee', '<p>jj</p>\r\n<p>&nbsp;</p>', 'dadang', '2023-11-17 12:14:39', NULL),
('TL00000013', 'BV00000009', '0', 'kabee', '<p>jj</p>', 'dadang', '2023-11-17 12:14:52', NULL),
('TL00000014', 'BV00000011', '0', 'kabee', '<p>hhh</p>', 'dadang', '2023-11-17 12:15:06', NULL),
('TL00000015', 'BV00000010', '0', 'kabee', '<p>asdfasdf</p>', 'dadang', '2023-11-17 18:26:45', NULL),
('TL00000016', 'BV00000010', '0', 'kabee', '<p>;</p>\r\n<p>&nbsp;</p>', 'dadang', '2023-11-17 18:27:21', NULL),
('TL00000017', 'BV00000012', '0', 'kabee', '<p>;</p>', 'dadang', '2023-11-17 18:27:32', NULL),
('TL00000018', 'BV00000012', '0', 'kabee', '<p>;</p>', 'dadang', '2023-11-17 18:28:43', NULL),
('TL00000019', 'BV00000049', '0', 'kabee', '<p>Ụa rồi chia sẻ đ&acirc;u?? Kinh nghiệm đ&acirc;u ?? sao thấy n&oacute;i k z ?</p>\r\n<p>Ụa bjan k&ecirc;u bạn chia sẻ m&agrave; ??</p>', 'dadang', '2023-11-19 00:40:00', NULL),
('TL00000020', 'BV00000051', '0', 'kabee', '<p>Biết n&oacute;i k&nbsp;</p>\r\n<p>&nbsp;</p>', 'dadang', '2023-11-19 00:40:27', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbltheodoichude`
--

CREATE TABLE `tbltheodoichude` (
  `taiKhoan` varchar(10) NOT NULL,
  `maCD` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbltheodoichude`
--

INSERT INTO `tbltheodoichude` (`taiKhoan`, `maCD`) VALUES
('kabee', 'CD00000002');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblthongbao`
--

CREATE TABLE `tblthongbao` (
  `maTB` int(128) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL,
  `anhTB` varchar(255) NOT NULL,
  `iconTB` text NOT NULL,
  `linkTB` text NOT NULL,
  `noiDungTB` text NOT NULL,
  `ngayDangTB` datetime NOT NULL DEFAULT current_timestamp(),
  `trangThaiTB` int(1) NOT NULL,
  `trangThaiXemTB` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tblthongbao`
--

INSERT INTO `tblthongbao` (`maTB`, `taiKhoan`, `anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) VALUES
(1, 'kabee', 'hqtcsdl.png', '<i class=\"fas fa-file notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-color: #67e486; font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'quantri/tailieukiemduyet.php', 'Bạn có <strong>2</strong> tài liệu mới cần duyệt trong chủ đề <strong>Cơ sở dữ liệu</strong>', '2023-11-17 23:31:57', 1, 0),
(2, 'kabee', 'hqtcsdl.png', '<i class=\"fas fa-file notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-color: #67e486; font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'quantri/tailieukiemduyet.php', 'Bạn có <strong>2</strong> tài liệu mới cần duyệt trong chủ đề <strong>Đồ án</strong>', '2023-11-17 05:46:40', 1, 1),
(3, 'kabee', 'hqtcsdl.jpg', '<i class=\"fas fa-file notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-color: #67e486; font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'tailieu/chitiettailieu.php?maTL=TL00000020', 'Tài liệu của bạn đã được đăng trong chủ đề <strong>Cơ sở dữ liệu</strong>', '2023-11-17 05:46:51', 1, 0),
(4, 'kabee', 'thanhhien.jpg', '<i class=\"fas fa-heart notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #fc4c51, #fd6292); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'tailieu/chitiettailieu.php?maTL=TL00000002', '<strong>thienlan</strong> và <strong>2 người khác</strong> đã yêu thích tài liệu của bạn trong loại tài liệu <strong>Lập trình</strong>', '2023-11-17 05:48:09', 1, 0),
(5, 'kabee', 'chude1.png', '<i class=\"fas fa-book-open notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'quantri/baivietkiemduyet.php', 'Bạn có <strong>2</strong> bài viết mới cần duyệt trong chủ đề <strong>Lập trình</strong>', '2023-11-17 22:17:31', 1, 1),
(6, 'kabee', 'chude2.png', '<i class=\"fas fa-users notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'diendan/chitietbaiviet.php?maBV=BV00000012', 'Bài viết của bạn đã được đăng trong chủ đề <strong>Android</strong>', '2023-11-17 05:49:59', 1, 0),
(7, 'kabee', 'chude1.png', '<i class=\"fas fa-users notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'diendan/chitietbaiviet.php?maBV=BV00000013', 'Bài viết của bạn đã được đăng trong chủ đề <strong>Lập trình</strong>', '2023-11-17 22:17:41', 1, 0),
(8, 'kabee', 'chude1.png', '<i class=\"fas fa-users notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'diendan/chitietbaiviet.php?maBV=BV00000014', 'Bài viết của bạn đã được đăng trong chủ đề <strong>Lập trình</strong>', '2023-11-17 22:17:44', 1, 1),
(9, 'kabee', 'chude2.png', '<i class=\"fas fa-bell notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #dc3545, #dc3545); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'quantri/thaoluanbaocao.php', 'Bạn có <strong>1</strong> thảo luận vi phạm mới cần kiểm tra trong chủ đề <strong>Android</strong>', '2023-11-17 22:19:51', 1, 0),
(10, 'kabee', 'chude1.png', '<i class=\"fas fa-users notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'diendan/chitietbaiviet.php?maBV=BV00000014', 'Bài viết của bạn đã được đăng trong chủ đề <strong>Lập trình</strong>', '2023-11-17 22:48:54', 1, 1),
(11, 'kabee', 'chude2.png', '<i class=\"fas fa-book-open notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'quantri/baivietkiemduyet.php', 'Bạn có <strong>1</strong> bài viết mới cần duyệt trong chủ đề <strong>Android</strong>', '2023-11-17 23:40:37', 1, 1),
(12, 'kabee', 'chude2.png', '<i class=\"fas fa-users notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'diendan/chitietbaiviet.php?maBV=BV00000014', 'Bài viết của bạn đã được đăng trong chủ đề <strong>Android</strong>', '2023-11-17 23:40:45', 1, 0),
(13, 'hoangtrang', 'kabee.jpg', '<i class=\"fas fa-comment-alt notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'diendan/chitietbaiviet.php?maBV=BV00000049#comment-TL00000019', '<strong>kabee</strong> đã bình luận về bài viết của bạn trong chủ đề <strong>Chia sẻ dự án lập trình</strong>', '2023-11-19 00:40:00', 0, 0),
(14, 'kimthanh', 'kabee.jpg', '<i class=\"fas fa-comment-alt notification-reaction\" style=\"width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;\"></i>', 'diendan/chitietbaiviet.php?maBV=BV00000051#comment-TL00000020', '<strong>kabee</strong> đã bình luận về bài viết của bạn trong chủ đề <strong>Chia sẻ dự án lập trình</strong>', '2023-11-19 00:40:27', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbltlbvvipham`
--

CREATE TABLE `tbltlbvvipham` (
  `maTLBV` varchar(10) NOT NULL,
  `maLoaiVP` varchar(10) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbltlbvvipham`
--

INSERT INTO `tbltlbvvipham` (`maTLBV`, `maLoaiVP`, `taiKhoan`) VALUES
('TL00000018', 'VP00000002', 'kabee');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbltlvipham`
--

CREATE TABLE `tbltlvipham` (
  `maTL` varchar(10) NOT NULL,
  `maLoaiVP` varchar(10) NOT NULL,
  `taiKhoan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbltlvipham`
--

INSERT INTO `tbltlvipham` (`maTL`, `maLoaiVP`, `taiKhoan`) VALUES
('TL00000020', 'VP00000003', 'kabee');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbltlyeuthich`
--

CREATE TABLE `tbltlyeuthich` (
  `maTL` varchar(10) NOT NULL,
  `taiKhoan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbltlyeuthich`
--

INSERT INTO `tbltlyeuthich` (`maTL`, `taiKhoan`) VALUES
('TL00000001', 'ducnhong'),
('TL00000001', 'hienhuynh'),
('TL00000001', 'kabee'),
('TL00000001', 'thienlan'),
('TL00000002', 'hienhuynh'),
('TL00000002', 'kabee'),
('TL00000002', 'thienlan'),
('TL00000003', 'kabee'),
('TL00000004', 'ducnhong'),
('TL00000004', 'hienhuynh'),
('TL00000004', 'kabee'),
('TL00000005', 'kabee');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tblbaiviet`
--
ALTER TABLE `tblbaiviet`
  ADD PRIMARY KEY (`maBV`),
  ADD KEY `fk_TblChuDeBV_maCD_TblBaiViet` (`maCD`),
  ADD KEY `fk_TblNguoiDung_taiKhoan_TblBaiViet` (`taiKhoan`);

--
-- Chỉ mục cho bảng `tblbvvipham`
--
ALTER TABLE `tblbvvipham`
  ADD PRIMARY KEY (`maBV`,`maLoaiVP`,`taiKhoan`),
  ADD KEY `fk_TblLoaiViPham_maLoaiVP_TblBVViPham` (`maLoaiVP`),
  ADD KEY `fk_TblNguoiDung_taiKhoan_TblBVViPham` (`taiKhoan`);

--
-- Chỉ mục cho bảng `tblbvyeuthich`
--
ALTER TABLE `tblbvyeuthich`
  ADD PRIMARY KEY (`maBV`,`taiKhoan`),
  ADD KEY `fk_TblNguoiDung_taiKhoan_TblBVYeuThich` (`taiKhoan`);

--
-- Chỉ mục cho bảng `tblchantinnhan`
--
ALTER TABLE `tblchantinnhan`
  ADD PRIMARY KEY (`maChanTN`),
  ADD KEY `fk_TblNguoiDung_nguoiChan_TblThongBao` (`nguoiChan`),
  ADD KEY `fk_TblNguoiDung_nguoiBiChan_TblThongBao` (`nguoiBiChan`);

--
-- Chỉ mục cho bảng `tblchudebv`
--
ALTER TABLE `tblchudebv`
  ADD PRIMARY KEY (`maCD`);

--
-- Chỉ mục cho bảng `tbldinhdangtl`
--
ALTER TABLE `tbldinhdangtl`
  ADD PRIMARY KEY (`maDD`);

--
-- Chỉ mục cho bảng `tblloaitailieu`
--
ALTER TABLE `tblloaitailieu`
  ADD PRIMARY KEY (`maLoaiTL`);

--
-- Chỉ mục cho bảng `tblloaivipham`
--
ALTER TABLE `tblloaivipham`
  ADD PRIMARY KEY (`maLoaiVP`);

--
-- Chỉ mục cho bảng `tblnguoidung`
--
ALTER TABLE `tblnguoidung`
  ADD PRIMARY KEY (`taiKhoan`);

--
-- Chỉ mục cho bảng `tblquantribv`
--
ALTER TABLE `tblquantribv`
  ADD PRIMARY KEY (`maQuanTri`,`maCD`),
  ADD KEY `fk_TblChuDeBV_maLoaiTL_TblQuanTriBV` (`maCD`);

--
-- Chỉ mục cho bảng `tblquantritl`
--
ALTER TABLE `tblquantritl`
  ADD PRIMARY KEY (`maQuanTri`,`maLoaiTL`),
  ADD KEY `fk_TblLoaiTaiLieu_maLoaiTL_TblQuanTriTL` (`maLoaiTL`);

--
-- Chỉ mục cho bảng `tbltailieu`
--
ALTER TABLE `tbltailieu`
  ADD PRIMARY KEY (`maTL`),
  ADD KEY `fk_TblLoaiTaiLieu_maLoaiTL_TblTaiLieu` (`maLoaiTL`),
  ADD KEY `fk_TblDinhDangTL_maDD_TblTaiLieu` (`maDD`),
  ADD KEY `fk_TblNguoiDung_taiKhoan_TblTaiLieu` (`taiKhoan`);

--
-- Chỉ mục cho bảng `tblthaoluanbv`
--
ALTER TABLE `tblthaoluanbv`
  ADD PRIMARY KEY (`maTLBV`),
  ADD KEY `fk_TblBaiViet_maTL_TblThaoLuanBV` (`maBV`),
  ADD KEY `fk_TblNguoiDung_taiKhoan_TblThaoLuanBV` (`taiKhoan`);

--
-- Chỉ mục cho bảng `tbltheodoichude`
--
ALTER TABLE `tbltheodoichude`
  ADD PRIMARY KEY (`taiKhoan`,`maCD`),
  ADD KEY `fk_TblChuDeBV_maLoaiTL_TblTheoDoiChuDe` (`maCD`);

--
-- Chỉ mục cho bảng `tblthongbao`
--
ALTER TABLE `tblthongbao`
  ADD PRIMARY KEY (`maTB`),
  ADD KEY `fk_TblNguoiDung_taiKhoan_TblThongBao` (`taiKhoan`);

--
-- Chỉ mục cho bảng `tbltlbvvipham`
--
ALTER TABLE `tbltlbvvipham`
  ADD PRIMARY KEY (`maTLBV`,`maLoaiVP`,`taiKhoan`),
  ADD KEY `fk_TblLoaiViPham_maLoaiVP_TblTLBVViPham` (`maLoaiVP`),
  ADD KEY `fk_TblNguoiDung_taiKhoan_TblTLBVViPham` (`taiKhoan`);

--
-- Chỉ mục cho bảng `tbltlvipham`
--
ALTER TABLE `tbltlvipham`
  ADD PRIMARY KEY (`maTL`,`maLoaiVP`,`taiKhoan`),
  ADD KEY `fk_TblLoaiViPham_maLoaiVP_TblTLViPham` (`maLoaiVP`),
  ADD KEY `fk_TblNguoiDung_taiKhoan_TblTLViPham` (`taiKhoan`);

--
-- Chỉ mục cho bảng `tbltlyeuthich`
--
ALTER TABLE `tbltlyeuthich`
  ADD PRIMARY KEY (`maTL`,`taiKhoan`),
  ADD KEY `fk_TblNguoiDung_taiKhoan_TblTLYeuThich` (`taiKhoan`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tblchantinnhan`
--
ALTER TABLE `tblchantinnhan`
  MODIFY `maChanTN` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tblthongbao`
--
ALTER TABLE `tblthongbao`
  MODIFY `maTB` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tblbaiviet`
--
ALTER TABLE `tblbaiviet`
  ADD CONSTRAINT `fk_TblChuDeBV_maCD_TblBaiViet` FOREIGN KEY (`maCD`) REFERENCES `tblchudebv` (`maCD`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblBaiViet` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tblbvvipham`
--
ALTER TABLE `tblbvvipham`
  ADD CONSTRAINT `fk_TblBaiViet_maBV_TblBVViPham` FOREIGN KEY (`maBV`) REFERENCES `tblbaiviet` (`maBV`),
  ADD CONSTRAINT `fk_TblLoaiViPham_maLoaiVP_TblBVViPham` FOREIGN KEY (`maLoaiVP`) REFERENCES `tblloaivipham` (`maLoaiVP`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblBVViPham` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tblbvyeuthich`
--
ALTER TABLE `tblbvyeuthich`
  ADD CONSTRAINT `fk_TblBaiViet_maTL_TblBVYeuThich` FOREIGN KEY (`maBV`) REFERENCES `tblbaiviet` (`maBV`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblBVYeuThich` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tblchantinnhan`
--
ALTER TABLE `tblchantinnhan`
  ADD CONSTRAINT `fk_TblNguoiDung_nguoiBiChan_TblThongBao` FOREIGN KEY (`nguoiBiChan`) REFERENCES `tblnguoidung` (`taiKhoan`),
  ADD CONSTRAINT `fk_TblNguoiDung_nguoiChan_TblThongBao` FOREIGN KEY (`nguoiChan`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tblquantribv`
--
ALTER TABLE `tblquantribv`
  ADD CONSTRAINT `fk_TblChuDeBV_maLoaiTL_TblQuanTriBV` FOREIGN KEY (`maCD`) REFERENCES `tblchudebv` (`maCD`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblQuanTriBV` FOREIGN KEY (`maQuanTri`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tblquantritl`
--
ALTER TABLE `tblquantritl`
  ADD CONSTRAINT `fk_TblLoaiTaiLieu_maLoaiTL_TblQuanTriTL` FOREIGN KEY (`maLoaiTL`) REFERENCES `tblloaitailieu` (`maLoaiTL`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblQuanTriTL` FOREIGN KEY (`maQuanTri`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tbltailieu`
--
ALTER TABLE `tbltailieu`
  ADD CONSTRAINT `fk_TblDinhDangTL_maDD_TblTaiLieu` FOREIGN KEY (`maDD`) REFERENCES `tbldinhdangtl` (`maDD`),
  ADD CONSTRAINT `fk_TblLoaiTaiLieu_maLoaiTL_TblTaiLieu` FOREIGN KEY (`maLoaiTL`) REFERENCES `tblloaitailieu` (`maLoaiTL`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTaiLieu` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tblthaoluanbv`
--
ALTER TABLE `tblthaoluanbv`
  ADD CONSTRAINT `fk_TblBaiViet_maTL_TblThaoLuanBV` FOREIGN KEY (`maBV`) REFERENCES `tblbaiviet` (`maBV`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblThaoLuanBV` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tbltheodoichude`
--
ALTER TABLE `tbltheodoichude`
  ADD CONSTRAINT `fk_TblChuDeBV_maLoaiTL_TblTheoDoiChuDe` FOREIGN KEY (`maCD`) REFERENCES `tblchudebv` (`maCD`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTheoDoiChuDe` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tblthongbao`
--
ALTER TABLE `tblthongbao`
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblThongBao` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`);

--
-- Các ràng buộc cho bảng `tbltlbvvipham`
--
ALTER TABLE `tbltlbvvipham`
  ADD CONSTRAINT `fk_TblLoaiViPham_maLoaiVP_TblTLBVViPham` FOREIGN KEY (`maLoaiVP`) REFERENCES `tblloaivipham` (`maLoaiVP`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTLBVViPham` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`),
  ADD CONSTRAINT `fk_TblThaoLuanBV_maTLBV_TblTLBVViPham` FOREIGN KEY (`maTLBV`) REFERENCES `tblthaoluanbv` (`maTLBV`);

--
-- Các ràng buộc cho bảng `tbltlvipham`
--
ALTER TABLE `tbltlvipham`
  ADD CONSTRAINT `fk_TblLoaiViPham_maLoaiVP_TblTLViPham` FOREIGN KEY (`maLoaiVP`) REFERENCES `tblloaivipham` (`maLoaiVP`),
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTLViPham` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`),
  ADD CONSTRAINT `fk_TblTaiLieu_maTL_TblTLViPham` FOREIGN KEY (`maTL`) REFERENCES `tbltailieu` (`maTL`);

--
-- Các ràng buộc cho bảng `tbltlyeuthich`
--
ALTER TABLE `tbltlyeuthich`
  ADD CONSTRAINT `fk_TblNguoiDung_taiKhoan_TblTLYeuThich` FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung` (`taiKhoan`),
  ADD CONSTRAINT `fk_TblTaiLieu_maTL_TblTLYeuThich` FOREIGN KEY (`maTL`) REFERENCES `tbltailieu` (`maTL`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
