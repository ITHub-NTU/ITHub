<?php
    include_once '../config/Database.php';
    include "auth.php";
	$database = new Database();
	$db = $database->getConnection();
    if ($_FILES["fileToUpload"]["error"] === 0) {
        $targetDirectory = "uploads_chat/";
        $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);

        if (file_exists($targetFile)) {
            echo "Tệp đã tồn tại.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                echo "Tệp đã được tải lên thành công.";
            } else {
                echo "Có lỗi xảy ra khi tải lên tệp.";
            }
        }
    } else {
        echo "Có lỗi xảy ra trong quá trình tải lên.";
    }
	if(isset($_SESSION['room'])) {
		$room = $_SESSION['room'];
        if(isset($_SESSION['folder']))
        {
            $folder = $_SESSION['folder'];
        }
        else{
            $folder = "img/user.png";
        }

        if(isset($_FILES["fileToUpload"]["name"]) && !empty($_FILES["fileToUpload"]["name"])) {
            $fileToUploadName = $_FILES["fileToUpload"]["name"];
            $chat = $_POST['chat'];
            
            $sqlFile = "INSERT INTO `$room` (`taiKhoan`, `msg`, `date`, `trangThaiTN`, `trangThaiXemTN`) VALUES ('$taiKhoan','$fileToUploadName', current_timestamp(), 0, 0 );";
            $db->query($sqlFile);
            
            if(!empty($chat)) {
                $sql = "INSERT INTO `$room` (`taiKhoan`, `msg`, `date`, `trangThaiTN`, `trangThaiXemTN`) VALUES ('$taiKhoan','$chat', current_timestamp(), 0, 0 );";
                $db->query($sql);
            }
            
            $sqlUpdate = "UPDATE `$room` SET `trangThaiTN` = 1, `trangThaiXemTN` = 1 WHERE `taiKhoan` <> '$taiKhoan'";
            $db->query($sqlUpdate);
        } else {
            $chat = $_POST['chat'];
            if(!empty($chat)) {
                $sql = "INSERT INTO `$room` (`taiKhoan`, `msg`, `date`, `trangThaiTN`, `trangThaiXemTN`) VALUES ('$taiKhoan','$chat', current_timestamp(), 0, 0 );";
                $sqlUpdate = "UPDATE `$room` SET `trangThaiTN` = 1, `trangThaiXemTN` = 1 WHERE `taiKhoan` <> '$taiKhoan'";
                $db->query($sqlUpdate);
                $result = $db->query($sql);
                if(!$result) {
                echo "Database Failure! Message not send";
            }
            } 
        }
        
    }
    
    if(!isset($_SESSION['room']) || $_SESSION['room']== "quantrivien_".$taiKhoan) {
		$room = $_SESSION['room'];
        $query_TT = "SELECT trangThai FROM tblnguoidung WHERE taiKhoan='quantrivien'";
        $result_TT = $db->query($query_TT);

        if ($result_TT) {
            $row = $result_TT->fetch_assoc();
            $trangThai = $row['trangThai'];
        } else {
            echo"lỗi truy vấn";
        }
        if($trangThai != "hoatdong") {
            $botChat = "Chúng tôi sẽ trả lời bạn sau vài phút!";
            $botSql = "INSERT INTO `$room` (`taiKhoan`, `msg`, `date`, `trangThaiTN`, `trangThaiXemTN`) VALUES ('quantrivien', '$botChat', current_timestamp(), 1, 1);";
            $botsSqlUpdate = "UPDATE `$room` SET `trangThaiTN` = 1, `trangThaiXemTN` = 1 WHERE `taiKhoan` <> 'quantrivien'";
            $db->query($botsSqlUpdate);
            $botResult = $db->query($botSql);
            if(!$botResult)
            {
                echo "Database Failure! Message not send";
            }
        } 
    }
?>