<?php 
    include_once '../config/Database.php';
    include_once '../class/NguoiDung.php';
    include "auth.php";
	$database = new Database();
	$db = $database->getConnection();
    $tblNguoiDung = new NguoiDung($db);
	if(isset($_SESSION['room']))
	{
        $room = $_SESSION['room'];
        $count = 0;
        $search = isset($_POST['searchText']) ? $_POST['searchText'] : '';
        // $findSql = "SHOW TABLES FROM epiz_27865341_user";
        $findSql = "SHOW TABLES FROM ithub";
        $result = $db->query($findSql);
        if(mysqli_num_rows($result)>0)
        { 
            while($data = mysqli_fetch_assoc($result))
            {
                $table = $data['Tables_in_ithub'];
                $underscorePosition = strpos($table, '_');
                if ($underscorePosition !== false) {
                    $start = substr($table, $underscorePosition + 1);
                    $end = substr($table, 0, $underscorePosition);
                    if($start == $taiKhoan) {
                        $ifMe = $start;
                        $finalName = $end;
                    } else {
                        $ifMe = $end;
                        $finalName = $start;
                    }

                    if($table != "tblbaiviet" 
                    && $table != "tblbvvipham" 
                    && $table != "tblbvyeuthich" 
                    && $table != "tblchudebv" 
                    && $table != "tbldinhdangtl" 
                    && $table != "tblloaitailieu" 
                    && $table != "tblloaivipham"
                    && $table != "tblnguoidung" 
                    && $table != "tblquantribv"
                    && $table != "tblquantritl" 
                    && $table != "tbltailieu" 
                    && $table != "tblthaoluanbv" 
                    && $table != "tbltheodoichude"
                    && $table != "tblthongbao" 
                    && $table != "tbltlbvvipham" 
                    && $table != "tbltlvipham" 
                    && $table != "tbltlyeuthich" 
                    && $table != "quantrivien_quantrivien" 

                    && $ifMe == $taiKhoan) {                    

                if (stripos($finalName, $search) !== false) {
                    $last = "SELECT * FROM `$table` WHERE sn = ( SELECT MAX( sn ) FROM `$table` )";
                    $lastResult = $db->query($last);
                    if (mysqli_num_rows($lastResult) > 0) {
                        $lastData = mysqli_fetch_array($lastResult);
                        $readMsg = $lastData['msg'];
                        $trangThaiXemTN = $lastData['trangThaiXemTN'];
                        $taiKhoanND = $lastData['taiKhoan'];
                        $count=1;
                    } else {
                        $readMsg = "Bắt đầu trò chuyện với $finalName";
                    }
                    $getImg = $tblNguoiDung->getUserInfoByTaiKhoan($finalName);
                    $anhDaiDien = $getImg['anhDaiDien'];
                    $folder = "../image/";

                    if (file_exists($folder . $anhDaiDien)) {
                        $folder .= $anhDaiDien;
                    } else {
                        $folder .= "user.jpg";
                    }

                    $query_TT = "SELECT trangThai FROM tblnguoidung WHERE taiKhoan='$finalName'";
                    $result_TT = $db->query($query_TT);
    
                    if ($result_TT) {
                        $row = $result_TT->fetch_assoc();
                        $trangThai = $row['trangThai'];
    
                        switch ($trangThai) {
                            case 'hoatdong':
                                $hoatDong = "online";
                                break;
                            case 'ban':
                                $hoatDong = "busy";
                                break;
                            default:
                                $hoatDong = "offline";
                                break;
                        }
                    } else {
                       echo"lỗi truy vấn";
                    }
                        echo "
                            <a href='tinnhan.php?id=$table' style='text-decoration: none;'>
                                <li class='contact'>
                                    <div class='wrap'>
                                        <span class='contact-status $hoatDong'></span>
                                        <img src='$folder' alt='user' />
                                        <div class='meta'>
                                            <p class='name'>$finalName</p>";
                                            if($count==0) {
                                                echo "<p style='color: #ffffff7d;' class='preview'>$readMsg</p>";
                                            } else {
                                                if ($trangThaiXemTN == 0 and $taiKhoanND != $_SESSION['taiKhoan']) {
                                                    echo "<p style='color: #ffffff;' class='preview'><b>$readMsg</b></p>";
                                                } else {
                                                    echo "<p style='color: #ffffff7d;' class='preview'>$readMsg</p>";
                                                }
                                            }
                                            
                                            echo "
                                        </div>
                                    </div>
                                </li>
                            </a>";
                        }
                    }
                } else {}
                    
            }
        }
    }
    
?> 