<?php

include_once '../config/Database.php';
include_once '../class/ThongBao.php';
include_once '../class/TienIch.php';
include_once '../class/TimKiem.php';
$database = new Database();
$db = $database->getConnection();
$tblTimKiem = new TimKiem($db);
$tienIch = new TienIch();
$tblThongBao = new ThongBao($db);
include('../inc/header.php');
if(isset($_GET['search'])){
    $search = $_GET['search'];
    $tblTimKiem->search = $search;
}
include("../inc/navbar.php");
?>
<div class="col-md-12 ">
    <div class="card ">
    <h5 class="card-header" style="background-color:cadetblue;">Tài liệu</h5>
    <div class="row"  style="padding: 20px!important;">
        <?php
          $resultTL = $tblTimKiem->timkiemtailieu();
            if (!$resultTL) {
                die("Lỗi truy vấn SQL: " );
            }
            else{
                if ($resultTL->num_rows > 0) {
                    while($danhSachTaiLieu = $resultTL->fetch_assoc()){
        
        ?>
        <div class="col-md-3 d-flex ">
            <div class="card" style="width: 100%;">
                <img src="../image/<?php echo  $danhSachTaiLieu['anhTL']?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo  $danhSachTaiLieu['tenTL']?></h5>
                    <p class="card-text"><?php echo  $danhSachTaiLieu['moTaTL']?></p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <?php 
                }
            } else echo 'Không có kết quả tìm kiếm';}
        ?>
    </div>
    </div>
    </div>
</div>
<div class="col-md-12">
<div class="card ">
<h5 class="card-header" style="background-color:cadetblue;">Bài viết</h5>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include("../inc/footer.php"); ?>
