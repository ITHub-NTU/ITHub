<?php 
    include_once '../config/Database.php';
    include "auth.php";
	$database = new Database();
	$db = $database->getConnection();
?>
<?php
    $id = $_GET['id'];
    $underscorePosition = strpos($id, '_');
        if ($underscorePosition !== false) {
            $start = substr($id, $underscorePosition + 1);
            $end = substr($id, 0, $underscorePosition);
            if($start == $taiKhoan) {
                $friendtaiKhoan = $end;
            } else {
                $friendtaiKhoan = $start;
            }
    }
    $ifExists = $taiKhoan."_".$friendtaiKhoan;
    if($friendtaiKhoan != $taiKhoan && $friendtaiKhoan != 'quantrivien')
    { 
        $findTable = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'ithub' AND TABLE_NAME = '$ifExists'";
        $findResult = $db->query($findTable);
        if(mysqli_num_rows($findResult)>0)
        {
            $id = $ifExists;
        } 
    }
    $sql = 'CREATE TABLE `ithub`.'.$id.' (
        `sn` INT(128) NOT NULL AUTO_INCREMENT,
        `taiKhoan` VARCHAR(50) NOT NULL,
        `msg` VARCHAR(255) NOT NULL,
        `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `trangThaiTN` INT(1) NOT NULL,
        `trangThaiXemTN` INT(1) NOT NULL,
        PRIMARY KEY (`sn`),
        CONSTRAINT fk_taiKhoan_'.$id.' FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung`(`taiKhoan`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
      ';
    $result = $db->query($sql);
    if($result){
        $_SESSION['room'] = $id;
        header("Location: tinnhan.php?id=".$_SESSION['room']);
    }
    else{
        $_SESSION['room'] = $id;
        header("Location: tinnhan.php?id=".$_SESSION['room']);
    }
?>
