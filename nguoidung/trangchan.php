<?php
include_once '../config/Database.php';
include_once '../class/NguoiDung.php';

$database = new Database();
$db = $database->getConnection();
$tblNguoiDung = new NguoiDung($db);
if(!(isset($_SESSION['taiKhoan']))){
    header('Location:./dangnhap.php');
}

include('../inc/header.php');
include('../inc/navbar.php');
?>
<div class="row justify-content-center align-items-center" style="height: 50vh;">
    <div class="col-12 text-center">
        <h1>
            <i class="fas fa-lock"></i>
        </h1>
        <h1>Bạn hiện không xem được nội dung này</h1>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php
include_once ('../inc/footer.php');
?>