<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    if($currentPage == 'trangchu.php') {
        $path = '../ITHub/';
    } else {
        $path = '../';
    }
    if(isset($_SESSION['taiKhoan']) and !empty($_SESSION['taiKhoan'])){
        $taiKhoan = $_SESSION['taiKhoan'];
    } else{
        header($path."nguoidung/dangnhap.php");
    }
?>