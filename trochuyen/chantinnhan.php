<?php
    include_once '../config/Database.php';
    include_once '../class/NguoiDung.php';
    include "auth.php";

    $database = new Database();
    $db = $database->getConnection();
    $tblNguoiDung = new NguoiDung($db);

    if(isset($_GET['id']) and isset($_GET['nguoiChan']) and isset($_GET['nguoiBiChan']) and isset($_GET['hanhDong'])) {
        $tenTinNhan = $_GET['id'];
        $nguoiChan = $_GET['nguoiChan'];
        $nguoiBiChan = $_GET['nguoiBiChan'];
        $hanhDong = $_GET['hanhDong'];
        if(!empty($tenTinNhan) and !empty($nguoiChan) and !empty($nguoiBiChan) and $nguoiBiChan != 'quantrivien') {
            if($hanhDong == 'chan') {
                $checkDuplicateQuery = "SELECT * FROM tblchantinnhan WHERE tenTN = '$tenTinNhan' AND nguoiChan = '$nguoiChan' AND nguoiBiChan = '$nguoiBiChan'";
                $stmtDuplicate = $db->prepare($checkDuplicateQuery);
                $stmtDuplicate->execute();
                $resultDuplicate = $stmtDuplicate->get_result();
                if ($resultDuplicate->num_rows > 0) {
                } else {
                    $result = $tblNguoiDung->chanTinNhanNguoiDung($tenTinNhan, $nguoiChan, $nguoiBiChan, $hanhDong);
                }
            } else {
                $result = $tblNguoiDung->chanTinNhanNguoiDung($tenTinNhan, $nguoiChan, $nguoiBiChan, $hanhDong);
            }     
            header("Location: tinnhan.php?id=".$nguoiBiChan."_".$nguoiChan."");
        }
    }
?>
