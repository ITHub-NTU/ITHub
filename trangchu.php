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
    <title>ITHub - Tài Liệu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        a {
            text-decoration: none;
        }
    </style>
<body>
    <?php include($path."inc/navbar.php"); ?>
    <div class="row">
        <div id="carouselExampleIndicators" class="carousel slide col-lg-12">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="<?php echo $path ?>image/macdinh.jpg" class="d-block w-100" style="height:500px;" alt="Image">                            

                </div>
                <div class="carousel-item">
                <img src="<?php echo $path ?>image/macdinh.jpg" class="d-block w-100" style="height:500px;" alt="Image">
                </div>
                <div class="carousel-item">
                <img src="<?php echo $path ?>image/macdinh.jpg" class="d-block w-100" style="height:500px;" alt="Image">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Lùi</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Tiếp</span>
            </button>
        </div>
        <div class="row">
            <div class="col-lg-4">
            <div class="col-lg-12">
                <h5 class="text-center p-3 mt-2 bg-warning rounded-2">TOP 5 TÀI LIỆU YÊU THÍCH</h5>
                <?php if ($dsTaiLieuYeuThich !== null) : ?>
                    <?php foreach ($dsTaiLieuYeuThich as $taiLieuYeuThich) : ?>
                        <div class="border border-1 rounded-2 mt-2">
                            <div class="d-flex">
                                <div>
                                <?php
                                        $currentDomain = $_SERVER['HTTP_HOST'];
                                        $chitiettailieuURL = "http://".$currentDomain."/ITHUB/tailieu/chitiettailieu.php?maTL=".$taiLieuYeuThich['maTL'];
                                        ?>
                                <a href="<?php echo $chitiettailieuURL; ?>"  style="--bs-link-hover-color-rgb: 25, 135, 84;"> <h5 class="fw-medium mb-2 mt-3"><span><i id="fa-picture-o" aria-hidden="true"></i></span><?php echo $taiLieuYeuThich['tenTL']; ?></h5></a>
                                    <p class="fw-normal mb-2 mt-2"><?php echo $taiLieuYeuThich['moTaTL']; ?></p>
                                    <div class="ques-icon-info2933 mt-2 mb-2">
                                        <a href="nguoidung/trangcanhan.php" class="me-4"style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle text-body-secondary" viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                            </svg><?php echo $taiLieuYeuThich['taiKhoan']; ?></a>
                                        <i class="fa fa-calendar text-body-secondary me-5" aria-hidden="true">  <?php echo date('d-m-Y', strtotime($taiLieuYeuThich['ngayDuyetTL'])); ?></i>
                                    </div>
                                    
                            
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Không tìm thấy tài liệu.</p>
                <?php endif; ?>
                
            <h5 class="text-center p-3 mt-2 bg-warning rounded-2">TOP 5 BÀI VIẾT YÊU THÍCH</h5>
                <?php foreach ($dsBaiVietYeuThich as $baiVietYeuThich) : ?>
                    <div class="section-card border border-1 rounded-2 mt-2">
                        <div class="d-flex">
                            <div class="blog-details3902">
                                <?php
                                    $currentDomain = $_SERVER['HTTP_HOST'];
                                    $chitietbaivietURL = "http://".$currentDomain."/ITHUB/diendan/chitietbaiviet.php?maBV=".$baiVietYeuThich['maBV'];
                                ?>
                                   <a href="<?php echo $chitietbaivietURL; ?>" style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;"><h5 class="fw-medium mb-2 mt-3"><span><i id="fa-picture-o" aria-hidden="true"></i></span><?php echo $baiVietYeuThich['tenBV']; ?></h5>
                                </a>
                                <blockquote class="blockquote mb-0">
                                    <div id="partialContent">
                                        <?php
                                            $currentDomain = $_SERVER['HTTP_HOST'];
                                            $chitietbaivietURL = "http://".$currentDomain."/ITHUB/diendan/chitietbaiviet.php?maBV=".$baiVietYeuThich['maBV'];        
                                        $toanBoNoiDung = $baiVietYeuThich['noiDungBV'];
                                        $summary = substr($toanBoNoiDung, 0, 100);
                                        $readmore = '<a href="'.$chitietbaivietURL.'"style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;" >...</a>';
                                        echo "<p class='full-content' style='display: none'>" . $toanBoNoiDung. "</p>";
                                        echo "<p class='summary'>" . $summary . $readmore . "</p><br/>";
                                        ?>
                                    </div>
                                </blockquote>
                             
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-8">
            <h5 class="text-center p-3 mt-2 bg-warning rounded-2">TÀI LIỆU VÀ BÀI VIẾT MỚI NHẤT</h5>
                <?php
                foreach ($dsTaiLieuMoiNhat as $taiLieuMoiNhat) :?>
                <div class="section-card border border-1 rounded-2 mt-2">
                    <a href="<?php echo $chitiettailieuURL; ?>"  style="--bs-link-hover-color-rgb: 25, 135, 84;"> <h5 class="fw-medium mb-2 mt-3"><span><i id="fa-picture-o" aria-hidden="true"></i></span><?php echo $taiLieuMoiNhat['tenTL']; ?></h5></a>
                    <p class="fw-normal mb-2 mt-2"><?php echo $taiLieuMoiNhat['moTaTL']; ?></p>
                    <div class="ques-icon-info2933 mt-2 mb-2">
                        <a href="nguoidung/trangcanhan.php" class="me-4"style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle text-body-secondary" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg><?php echo $taiLieuMoiNhat['taiKhoan']; ?></a>
                        <i class="fa fa-calendar text-body-secondary me-5" aria-hidden="true">  <?php echo date('d-m-Y', strtotime($taiLieuMoiNhat['ngayDuyetTL'])); ?></i>
                    </div>
                </div>  
                <?php endforeach;?>
               
                <?php
                
                foreach ($dsBaiVietMoiNhat as $baiVietMoiNhat) :?>
                 <div class="section-card border border-1 rounded-2 mt-2">
                    <a href="<?php echo  $chitietbaivietURL; ?>"  style="--bs-link-hover-color-rgb: 25, 135, 84;"> <h5 class="fw-medium mb-2 mt-3"><span><i id="fa-picture-o" aria-hidden="true"></i></span><?php echo $baiVietMoiNhat['tenBV']; ?></h5></a>
                    <div id="partialContent">
                        <?php
                       $toanBoNoiDung = $baiVietMoiNhat['noiDungBV'];
                        $summary = substr($toanBoNoiDung, 0, 100);
                        $readmore = '<a href="'.$chitietbaivietURL.'"style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;" >...</a>';
                        echo "<p class='full-content' style='display: none'>" . $toanBoNoiDung. "</p>";
                        echo "<p class='summary'>" . $summary . $readmore . "</p><br/>";
                        ?>
                    </div>
                </div>  
                <?php endforeach;?>
                
            </div>
        </div>
    </div>
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
<?php include($path.'inc/footer.php'); ?>
