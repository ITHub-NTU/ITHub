<?php
include_once '../config/Database.php';
include_once '../class/NguoiDung.php';

$database = new Database();
$db = $database->getConnection();
$tblNguoiDung = new NguoiDung($db);
$taiKhoan = $_SESSION['taiKhoan'];

if (isset($_POST['deleteBV'])) {
    $maBV = $_POST['maBV'];
    $resultDBV= $tblNguoiDung->xoaBaiViet($maBV);
    
    if ($resultDBV) {
        $response = array("status" => "success");
    } else {
        $response = array("status" => "error");

    }
} elseif (isset($_POST['deleteTL'])) {
    $maTL = $_POST['maTL'];
    $resultDTL = $tblNguoiDung->xoaTaiLieu($maTL);
    if ($resultDTL) {
        $response = array("status" => "success");
    } else {
        $response = array("status" => "error");
    }
} elseif (isset($_POST['deleteBVYT'])) {
    $maBVYT = $_POST['maBVYT'];
    $resultDBVYT= $tblNguoiDung->xoaBaiVietYeuThich($taiKhoan, $maBVYT);
    if ($resultDBVYT) {
        $response = array("status" => "success");
    } else {
        $response = array("status" => "error");
    }
} elseif (isset($_POST['deleteTLYT'])) {
    $maTLYT = $_POST['maTLYT'];
    $resultDTLYT = $tblNguoiDung->xoaTaiLieuYeuThich($taiKhoan, $maTLYT);
    if ($resultDTLYT) {
        $response = array("status" => "success");
    } else {
        $response = array("status" => "error");
    }
}
echo json_encode($response);

?>
