<?php 
    include_once '../config/Database.php';
    include_once '../class/ThaoLuanBV.php';
    include_once '../class/TienIch.php';
    include_once '../class/BaiViet.php';
    include_once '../class/ThongBao.php';
    $database = new Database();
    $db = $database->getConnection();
    $tienIch = new TienIch();
    $tblThaoLuanBV = new ThaoLuanBV($db);
    $tblBaiViet = new BaiViet($db);
    $tblThongBao = new ThongBao($db);
    if(isset($_GET['maTLBV'])&&isset($_GET['maLoaiVP'])){
        $maBV = $_GET['maBV'];
        $maTLBV = $_GET['maTLBV'];
        $maLoaiVP = $_GET['maLoaiVP'];
        $taiKhoan = $_GET['taiKhoan'];
        $tblThaoLuanBV->maTLBV = $maTLBV;
        $tblThaoLuanBV->maLoaiVP = $maLoaiVP;
        $tblThaoLuanBV->taiKhoan = $taiKhoan;
        $tblBaiViet->maBV = $maBV;
        $tblBaiViet->maLoaiVP = $maLoaiVP;
        $tblBaiViet->taiKhoan = $taiKhoan;
        $chiTietBaiViet = $tblBaiViet->layBaiViet();
        if($tblThaoLuanBV->baoCaoThaoLuanBaiViet()){
            header("location: chitietbaiviet.php?maBV=$maBV&msgtl=1");
            $tblThongBao->themTBBV('','baocaothaoluan', $chiTietBaiViet['maCD'], $maBV);
        }
        else{
            header("location: chitietbaiviet.php?maBV=$maBV&msgtl=0");
        }
    }
    else{
        header('location: chudebaiviet.php');
    }

?>
