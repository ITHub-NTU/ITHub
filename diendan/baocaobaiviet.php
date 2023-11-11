<?php 
    include_once '../config/Database.php';
    include_once '../class/BaiViet.php';
    include_once '../class/TienIch.php';
    include_once '../class/ThongBao.php';
    $database = new Database();
    $db = $database->getConnection();
    $tienIch = new TienIch();
    $tblBaiViet = new BaiViet($db);
    $tblThongBao = new ThongBao($db);
    if(isset($_GET['maBV'])&&isset($_GET['maLoaiVP'])){
        $maBV = $_GET['maBV'];
        $maLoaiVP = $_GET['maLoaiVP'];
        $taiKhoan = $_GET['taiKhoan'];
        $tblBaiViet->maBV = $maBV;
        $tblBaiViet->maLoaiVP = $maLoaiVP;
        $tblBaiViet->taiKhoan = $taiKhoan;
        $chiTietBaiViet = $tblBaiViet->layBaiViet();
        if($tblBaiViet->baoCaoBaiViet()){
            header("location: chitietbaiviet.php?maBV=$maBV&msg=1");
            $tblThongBao->themTBBV('','baocao', $chiTietBaiViet['maCD'], $maBV);
        }
        else{
            header("location: chitietbaiviet.php?maBV=$maBV&msg=0");
        }
    }
    else{
        header('location: chudebaiviet.php');
    }

?>
