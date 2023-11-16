<?php
$currentPage = basename($_SERVER['PHP_SELF']);
if($currentPage == 'trangchu.php') {
    $path = '../ITHub/';
} else {
    $path = '../';
}
include_once $path.'config/Database.php';
include_once $path.'class/TrangChu.php';
include_once $path.'class/TaiLieu.php';
include_once $path.'class/BaiViet.php';



$database = new Database();
$db = $database->getConnection();

$trangChu = new TrangChu($db);
$taiLieu = new TaiLieu($db);

$dsTaiLieuYeuThich = $trangChu->layDanhSachTaiLieuYeuThich();
$dsBaiVietYeuThich = $trangChu->layDanhSachBaiVietYeuThich();
$dsTaiLieuMoiNhat = $trangChu->getTaiLieuMoiNhat();
$dsBaiVietMoiNhat = $trangChu->getBaiVietMoiNhat();

include($path."inc/header.php");
?>
    <?php include($path."inc/navbar.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
<?php include($path.'inc/footer.php'); ?>
