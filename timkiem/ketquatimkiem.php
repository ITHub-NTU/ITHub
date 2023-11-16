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
<style>
    * {
    box-sizing: border-box;
    }

    .headerr {
    border: 1px solid red;
    padding: 15px;
    }

    .roww::after {
    content: "";
    clear: both;
    display: table;
    }

    @media only screen and (max-width: 576px) {
    .col-m-1 {width: 8.33%;}
    .col-m-2 {width: 16.66%;}
    .col-m-3 {width: 25%;}
    .col-m-4 {width: 33.33%;}
    .col-m-5 {width: 41.66%;}
    .col-m-6 {width: 50%;}
    .col-m-7 {width: 58.33%;}
    .col-m-8 {width: 66.66%;}
    .col-m-9 {width: 75%;}
    .col-m-10 {width: 83.33%;}
    .col-m-11 {width: 91.66%;}
    .col-m-12 {width: 100%;}
    }
    @media only screen and (min-width: 600px) {
    /* For tablets: */
    .col-t-1 {width: 8.33%;}
    .col-t-2 {width: 16.66%;}
    .col-t-3 {width: 25%;}
    .col-t-4 {width: 33.33%;}
    .col-t-5 {width: 41.66%;}
    .col-t-6 {width: 50%;}
    .col-t-7 {width: 58.33%;}
    .col-t-8 {width: 66.66%;}
    .col-t-9 {width: 75%;}
    .col-t-10 {width: 83.33%;}
    .col-t-11 {width: 91.66%;}
    .col-t-12 {width: 100%;}
    .mr-n-30 {margin-right: 0;}
    }
    @media only screen and (min-width: 768px) {
    /* For desktop: */
    .col-d-1 {width: 8.33%;}
    .col-d-2 {width: 16.66%;}
    .col-d-3 {width: 25%;}
    .col-d-4 {width: 33.33%;}
    .col-d-5 {width: 41.66%;}
    .col-d-6 {width: 50%;}
    .col-d-7 {width: 58.33%;}
    .col-d-8 {width: 66.66%;}
    .col-d-9 {width: 75%;}
    .col-d-10 {width: 83.33%;}
    .col-d-11 {width: 91.66%;}
    .col-d-12 {width: 100%;}
    .mr-n-30 {margin-right: -30px;}
    }
</style>
<div class="col-md-12 " style="padding: 0; ">
    <div class="card ">
    <h5 class="card-header" style="background-color:cadetblue;">Tài liệu</h5>
    <div class="row"  style="padding: 0 20px!important; ">
        <?php
        // Số lượng kết quả trên mỗi trang
        $resultsPerPage = 4;
        // Xác định trang hiện tại
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
            $_GET['page'] = 1;
        }
        // Tính toán OFFSET cho LIMIT trong truy vấn SQL
        $offset = ($page - 1) * $resultsPerPage;
        // Thực hiện truy vấn SQL với LIMIT và OFFSET
          $resultTL = $tblTimKiem->timkiemtailieuWithPagination($resultsPerPage, $offset);
            if (!$resultTL) {
                die("Lỗi truy vấn SQL: " );
            }
            else{
                if ($resultTL->num_rows > 0) {
                    while($danhSachTaiLieu = $resultTL->fetch_assoc()){
        
        ?>
        <div class="col-lg-3 col-sm-6 d-flex mt-3">
            <div class="card" style="width: 300px;">
                <img  style="width: 100%; height: 250px; object-fit: contain;" src="../image/<?php echo  $danhSachTaiLieu['anhTL']?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title" style="height: 50px;-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $danhSachTaiLieu['tenTL']?></h5>
                    <p class="card-text" style="height:100px ;-webkit-line-clamp: 4; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $danhSachTaiLieu['moTaTL']?></p>
                    <a href="#" class="btn btn-warning">Đọc tài liệu</a>
                </div>
            </div>
        </div>
        <?php 
                }
            } else echo 'Không có kết quả tìm kiếm tài liệu cho từ khóa: '.$search;}
        ?>
        <!-- Hiển thị phân trang -->
        <nav aria-label="Page navigation document d-flex ">
            <ul class="pagination mt-3 justify-content-center ">
            <?php 
                $numRows = $tblTimKiem->demSoLuongTaiLieu($search);
                $maxPage = floor($numRows/$resultsPerPage) + 1;
                
                if ($_GET['page'] > 1){
                    echo "<li class='page-item'><a class='page-link' class='page-link' href=" .$_SERVER['PHP_SELF']."?search=".$search."&page=".($_GET['page']-1).">Trước</a></li> "; //gắn thêm nút Back
                }
                for ($i=1 ; $i<=$maxPage ; $i++)
                {
                    if ($i == $_GET['page'])
                    {
                        echo '<li class="page-item"><b class="page-link">Trang'.$i.'</b> </li> '; //trang hiện tại sẽ được bôi đậm
                    }
                    else {
                        echo "<li class='page-item'><a class='page-link'  href=" . $_SERVER['PHP_SELF'] . "?search=".$search."&page=" . $i . ">Trang " . $i . "</a></li> ";
                    }
                }
                if ($_GET['page'] < $maxPage) {
                    echo "<li class='page-item'><a class='page-link' href=" . $_SERVER['PHP_SELF'] . "?search=".$search."&page=" . ($_GET['page'] + 1) . ">Tiếp</a></li>";  //gắn thêm nút Next
                }
            ?>
            </ul>
        </nav>
    </div>
    </div>
    </div>
</div>

<div class=" col-md-12 ">
    <div class="row">
    <div class="card col-md-9" style="padding: 0; ">
        <h5 class="card-header" style="background-color:cadetblue;">Bài viết</h5>
        <?php
            // Số lượng kết quả trên mỗi trang
            $resultsPerPageT = 5;
            // Xác định trang hiện tại
            if (isset($_GET['pageT']) && is_numeric($_GET['pageT'])) {
                $pageT = $_GET['pageT'];
            } else {
                $pageT = 1;
                $_GET['pageT'] = 1;
            }
            // Tính toán OFFSET cho LIMIT trong truy vấn SQL
            $offsetT = ($pageT - 1) * $resultsPerPageT;
            // Thực hiện truy vấn SQL với LIMIT và OFFSETT
            $resultBV = $tblTimKiem->timkiembaivietWithPagination($resultsPerPageT, $offsetT);
                if (!$resultBV) {
                    die("Lỗi truy vấn SQL: " );
                }
                else{
                    if ($resultBV->num_rows > 0) {
                        while($danhSachBaiViet = $resultBV->fetch_assoc()){
            ?>           
        <div class="row">
            <div class="col-d-2 col-m-4 mr-n-30" >
                <img src="../image/<?php echo $danhSachBaiViet['anhDaiDien']?>" alt="" class="img-fluid " style="width: 80px; border-radius: 100%; height: 80px; object-fit: cover; margin: 10px">
            </div>
            <div class="col-d-10 col-m-8 " style="margin-top: 10px; padding-right: 20px!important">
                <div class="h5" style="-webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo $danhSachBaiViet['tenBV'] ?></div>
                <div style="-webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"> <?php echo $danhSachBaiViet['noiDungBV'] ?></div>
                <div class="div d-flex">
                    <a href="" style="text-decoration: none; " class=" text-primary"><?php echo $danhSachBaiViet['taiKhoan'] ?></a>
                    &nbsp - &nbsp 
                    <span><?php echo $tienIch->formatTimeAgo(strtotime($danhSachBaiViet['ngayDuyetBV']));?></span>
                </div>
            </div>
        </div>
        <?php 
                }
            } else echo 'Không có kết quả tìm kiếm bài viết cho từ khóa: '.$search;}
        ?>
    </div>
    <div class="col-md-3 " id="rightmenu">
    </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include("../inc/footer.php"); ?>
