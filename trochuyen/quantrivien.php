<?php
    include_once '../config/Database.php';
    include "auth.php";
	$database = new Database();
	$db = $database->getConnection();

    if(!isset($_SESSION['room']) || $_SESSION['room'] == "quantrivien_".$taiKhoan && $_SESSION['room'] !== "quantrivien_quantrivien")
	{
		$room = $_SESSION['room'];
        $botImg = "img/boss.jpg";
        $chat0 = "ITHub Xin chào! $taiKhoan";
        $chat1 = "IThub là cộng đồng chia sẻ tài liệu và trao đổi các vấn đề liên quan đến Trường Đại Học Nha Trang.";
        $chat2 = 'Bạn có thể tìm kiếm tài liệu <a style="color:white" href="../tailieu/danhsachtailieu.php">tại đây.</a> ';
        $chat3 = 'Bạn có thể trao đổi và thảo luận các vấn đề <a style="color:white" href="../diendan/chudebaiviet.php"> tại đây.</a> ';
        $chat4 = 'Tìm kiếm những người bạn để bắt đầu trò chuyện <a style="color:white" href="timkiembanbe.php">tại đây.</a> ';
        $chat5 = "Nếu bạn có bất kì vấn đề nào cứ liên hệ chúng tôi qua kênh trò chuyện này. Xin cảm ơn!";

        $sql = "INSERT INTO `$room` (`taiKhoan`, `msg`, `date`, `trangThaiTN`, `trangThaiXemTN`) VALUES 
        ('quantrivien', '$chat0', current_timestamp(), 1, 1),
        ('quantrivien', '$chat1', current_timestamp(), 1, 1),
        ('quantrivien', '$chat2', current_timestamp(), 1, 1),
        ('quantrivien', '$chat3', current_timestamp(), 1, 1),
        ('quantrivien', '$chat4', current_timestamp(), 1, 1),
        ('quantrivien', '$chat5', current_timestamp(), 1, 1)";
        $result = $db->query($sql);
        if(!$result)
        {
            echo "Database Failure! Bot initialization failed.";
        }
        
    }
    header("Location: tinnhan.php");
?>