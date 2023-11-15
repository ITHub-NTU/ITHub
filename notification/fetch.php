
<?php
include_once '../config/Database.php';
include_once '../class/ThongBao.php';
include_once '../class/TienIch.php';
$database = new Database();
$db = $database->getConnection();
$tblThongBao = new ThongBao($db);
$tienIch = new TienIch();

if (isset($_POST["linkHref"])) {
    if ($_POST["linkHref"] != '') {
        $linkHref = $_POST["linkHref"];
        $tblThongBao->capNhatTrangThaiXemThongBao($linkHref);
    }
}

if (isset($_POST['view'])) {
    if ($_POST["view"] != '') {
        $tblThongBao->taiKhoan = $_SESSION['taiKhoan'];
        $tblThongBao->capNhatThongBao();
        
    }

    $currentPage = $_SESSION['currentPage'];
    if($currentPage == 'trangchu.php') {
        $path = '../ITHub/';
    } else {
        $path = '../';
    }

    $query = "SELECT * FROM tblthongbao WHERE taiKhoan = '{$_SESSION["taiKhoan"]}' ORDER BY ngayDangTB DESC LIMIT 30";
    $result = $db->query($query);
    $output = '<li style="padding-left:5px;font-weight:bold; font-size:18px;margin-top:-10px; background-color:#f0f0f0f0">Thông báo</li>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $anhTB = $row['anhTB'];
            $folder = "../image/";
            if($currentPage == 'trangchu.php') {
                $folder = '../ITHub/image/'.$anhTB;
            } else {
                $folder .= $anhTB;
            }

            if(!empty($row['ngayDangTB'])) {
				$timestamp = strtotime($row['ngayDangTB']);
			}else {
				$timestamp = NULL;
			}
            if($row['trangThaiXemTB'] == '0') {
                $output .= '
                <li>
                    <a class="text-decoration-none notifications" href="'.$path.$row['linkTB'].'" style="font-weight:bold;">
                        <div class="card notification-item mx-1" style="width: 380px; max-height: 95px; min-height:95px; border: none;">
                            <div class="row g-0 m-1" style="padding-bottom:1px;">
                                <div class="col-md-2 col-sm-3">
                                    <img src="'.$folder.'" class="img-fluid" alt="..." style = "width: 65px; height: 65px; border-radius: 65px; -o-object-fit: cover; object-fit: cover;">
                                    '.$row['iconTB'].'
                                </div>
                                <div class="col-md-9 col-sm-9" style="padding-left: 15px; line-height: 1.5; position: relative;">
                                    <p style="font-size: 15px; -webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word">
                                        '.$row['noiDungTB'].'
                                    </p>
                                    <span style="position: absolute; bottom: -2px; color: #1876F2; font-size: 15px;"><small>'.$tienIch->formatTimeAgo($timestamp).'</small><br></span>
                                    </div>
                                <div class="col-md-1 my-auto">
                                    <i class="fas fa-circle" style="font-size: 12px; color: #1876F2; text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.3); transform: rotate(0deg);"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>       
            ';
            } else {
                $output .= '
                <li>
                    <a class="text-decoration-none notifications" href="'.$path.$row['linkTB'].'" >
                        <div class="card notification-item mx-1" style="width: 380px; max-height: 95px; min-height:95px; border: none;">
                            <div class="row g-0 m-1" style="padding-bottom:1px;">
                                <div class="col-md-2 col-sm-3">
                                    <img src="'.$folder.'" class="img-fluid" alt="..." style = "width: 65px; height: 65px; border-radius: 65px; -o-object-fit: cover; object-fit: cover;">
                                    '.$row['iconTB'].'
                                </div>
                                <div class="col-md-9 col-sm-9" style="padding-left: 15px; line-height: 1.5; position: relative;">
                                    <p style="font-size: 15px; -webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word">
                                        '.$row['noiDungTB'].'
                                    </p>
                                    <span style="position: absolute; bottom: -2px; color: #1876F2; font-size: 15px;"><small>'.$tienIch->formatTimeAgo($timestamp).'</small><br></span>
                                </div>
                                <div class="col-md-1 my-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </a>
                </li>      
            ';
            }
        }
    } else {
        $output .= '
        <li style="padding-left:5px;font-weight:bold; font-size:15px; width:200px">Chưa có thông báo nào</li>';
    }

    $status_query = "SELECT * FROM tblthongbao WHERE trangThaiTB=0 AND taiKhoan='{$_SESSION["taiKhoan"]}'";
    $result_query = $db->query($status_query);
    $count = $result_query->num_rows;

    $queryTN = "SHOW TABLES LIKE '%{$_SESSION["taiKhoan"]}%'";
    $tables = $db->query($queryTN);
    if ($tables) {
        $countTN = 0;
        while ($table = $tables->fetch_array()) {
            $tableName = $table[0];
            $checkQueryTN = "SELECT COUNT(*) FROM $tableName WHERE taiKhoan <> '{$_SESSION["taiKhoan"]}' AND trangThaiTN = 0";
            $result_TN = $db->query($checkQueryTN);
            if ($result_TN) {
                $row_TN = $result_TN->fetch_row();
                $rowCountTN = $row_TN[0];
                if ($rowCountTN > 0) {
                    $countTN++;
                }
            }
        }
    } else {
        $countTN = 0;
    }

    $data = array(
        'notification' => $output,
        'unseen_notification' => $count,
        'unseen_message' => $countTN
    );

    echo json_encode($data);
}
?>
