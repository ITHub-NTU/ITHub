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
        <div class="col-md-3 d-flex ">
            <div class="card" style="width: 300px;">
                <img  style="width: 100%; height: 250px; object-fit: contain;" src="../image/<?php echo  $danhSachTaiLieu['anhTL']?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title" style="height: 50px;-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $danhSachTaiLieu['tenTL']?></h5>
                    <p class="card-text" style="height:100px ;-webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $danhSachTaiLieu['moTaTL']?></p>
                    <a href="#" class="btn btn-warning">Đọc tài liệu</a>
                </div>
            </div>
        </div>
        <?php 
                }
            } else echo 'Không có kết quả tìm kiếm tài liệu cho từ khóa: '.$search;}
        ?>
        <!-- Hiển thị phân trang -->
        <nav aria-label="Page navigation document d-flex">
            <ul class="pagination mt-2 justify-content-center ">
            <?php 
                $numRows = $tblTimKiem->demSoLuongTaiLieu();
                $maxPage = floor($numRows/$resultsPerPage) + 1;
                
                if ($_GET['page'] > 1){
                    echo "<li class='page-item'><a class='page-link' class='page-link' href=" .$_SERVER['PHP_SELF']."?search=".$search."&page=".($_GET['page']-1).">Back</a></li> "; //gắn thêm nút Back
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
                    echo "<li class='page-item'><a class='page-link' href=" . $_SERVER['PHP_SELF'] . "?search=".$search."&page=" . ($_GET['page'] + 1) . ">Next</a></li>";  //gắn thêm nút Next
                }
            ?>
            </ul>
        </nav>
    </div>
    </div>
    </div>
</div>
<div class="col-md-12">
<div class="card ">
<h5 class="card-header" style="background-color:cadetblue;">Bài viết</h5>
<div class="row">
    <div class="col-3">ádnfasdf</div>
</div>
<div class="row">
    <div class="col-3">ádnfasdf</div>
</div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include("../inc/footer.php"); ?>
