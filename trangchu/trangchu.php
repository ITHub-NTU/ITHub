<?php
include_once '../config/Database.php';
include_once '../class/TrangChu.php';
include_once '../class/TaiLieu.php';
include_once '../class/BaiViet.php';



$database = new Database();
$db = $database->getConnection();

$trangChu = new TrangChu($db);
$taiLieu = new TaiLieu($db);

$dsTaiLieuYeuThich = $trangChu->layDanhSachTaiLieuYeuThich();
$dsBaiVietYeuThich = $trangChu->layDanhSachBaiVietYeuThich();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITHub - Tài Liệu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<style>
        a {
            text-decoration: none;
        }
    </style>
<body>
    <?php include("../inc/navbar.php"); ?>
    <div class="row">
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="../image/macdinh.jpg" class="d-block w-100" style="height:500px;" alt="Image">                            

                </div>
                <div class="carousel-item">
                <img src="../image/macdinh.jpg" class="d-block w-100" style="height:500px;" alt="Image">
                </div>
                <div class="carousel-item">
                <img src="../image/macdinh.jpg" class="d-block w-100" style="height:500px;" alt="Image">
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
        <div class="col-md-12 border border-1 rounded-2">
        <h5 class="text-center p-3 mt-2 bg-warning rounded-2">TOP 2 TÀI LIỆU YÊU THÍCH</h5>
        <?php if ($dsTaiLieuYeuThich !== null) : ?>
            <?php foreach ($dsTaiLieuYeuThich as $taiLieuYeuThich) : ?>
                <div class="border border-1 rounded-2 mt-2">
                    <div class="d-flex">
                        <?php if (!empty($taiLieuYeuThich['anhTL'])) : ?>
                            <img class="border border-3 rounded-4 m-3" style="width: 150px; height: 150px;" src="../image/macdinh.jpg" alt="Image" class="img-responsive">
                            <!-- "img/<?php echo $taiLieuYeuThich['anhTL']; ?>" -->
                        <?php else : ?>
                            <img class="border border-3 rounded-4 m-3" style="width: 150px; height: 150px;" src="../image/macdinh.jpg" alt="Default Image" class="img-responsive">
                        <?php endif; ?>
                        <div class="blog-details3902">
                            <h3 class="fw-medium mb-2 mt-3"><span><i id="fa-picture-o" aria-hidden="true"></i></span><?php echo $taiLieuYeuThich['tenTL']; ?></h3>
                            <p class="fw-normal mb-2 mt-2"><?php echo $taiLieuYeuThich['moTaTL']; ?></p>
                            <div class="ques-icon-info2933 mt-2 mb-2">
                                <a href="#" class="me-4"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle text-body-secondary" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                    </svg><?php echo $taiLieuYeuThich['taiKhoan']; ?></a>
                                <i class="fa fa-calendar text-body-secondary me-5" aria-hidden="true"> <?php echo $taiLieuYeuThich['ngayDangTL']; ?></i>
                            </div>
                            
                            <div class="continue-deatils738 m-3">
                            
                            <?php
                                $currentDomain = $_SERVER['HTTP_HOST'];
                                $chitiettailieuURL = "http://".$currentDomain."/ITHUB/tailieu/chitiettailieu.php?maTL=".$taiLieuYeuThich['maTL'];
                                ?>
                                    
                                <a href="<?php echo $chitiettailieuURL; ?>" class="icon-link icon-link-hover" style="--bs-link-hover-color-rgb: 25, 135, 84;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                                Tiếp tục đọc
                                </a>
                                <a href ="#" data-bs-toggle="modal" data-bs-target="#exampleModal1" class="icon-link icon-link-hover mt-3 ms-5" style="--bs-link-hover-color-rgb: 25, 135, 84;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill " viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                          
                                </svg>Yêu thích 
                                </a>
                                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm tài liệu yêu thích</h1>
                                            </div>
                                            <div class="form-check m-3">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Tài liệu yêu thích</label>
                                            </div>
                                        </div>
                                    </div>                                               
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else : ?>
                        <p>Không tìm thấy tài liệu.</p>
                    <?php endif; ?>
            <div>
                <h5 class="text-center p-3 mt-2 bg-warning rounded-2">TOP 2 BÀI VIẾT YÊU THÍCH</h5>
                <?php foreach ($dsBaiVietYeuThich as $baiVietYeuThich) : ?>
                    <div class="section-card border border-1 rounded-2 mt-2">
                        <div class="d-flex">
                            <div class="blog-details3902">
                                <?php
                                    $currentDomain = $_SERVER['HTTP_HOST'];
                                    $chitietbaivietURL = "http://".$currentDomain."/ITHUB/forum/chitietbaiviet.php?maBV=".$baiVietYeuThich['maBV'];
                                ?>
                            <h3 class="fw-medium mb-2 mt-3"><span><i id="fa-picture-o" aria-hidden="true"></i></span><?php echo $baiVietYeuThich['tenBV']; ?></h3>
                                </a>
                                <blockquote class="blockquote mb-0">
                                    <div id="partialContent">
                                        <?php
                                        $toanBoNoiDung = $baiVietYeuThich['noiDungBV'];
                                        $summary = substr($toanBoNoiDung, 0, 100);
                                        $readmore = '<a href="#" class="read-more"></br>Đọc thêm</a>';
                                        echo "<p class='full-content' style='display: none'>" . $toanBoNoiDung. "</p>";
                                        echo "<p class='summary'>" . $summary . $readmore . "</p><br/>";
                                        ?>
                                    </div>
                                </blockquote>
                                <a href="<?php echo $chitietbaivietURL; ?>" class="icon-link icon-link-hover mb-4" style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                        Tiếp tục đọc
                                </a>
                                <a href ="#" data-bs-toggle="modal" data-bs-target="#exampleModal2" class="icon-link icon-link-hover ms-5" style="--bs-link-hover-color-rgb: 25, 135, 84;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill " viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                          
                                </svg>Yêu thích 
                                </a>
                                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm bài viết yêu thích</h1>
                                            </div>
                                            <div class="form-check m-3">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Bài viết yêu thích</label>
                                            </div>
                                        </div>
                                    </div>                                               
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<script>
    $(document).ready(function() {
        $(".read-more").click(function(e) {
            e.preventDefault();
            var sectionCard = $(this).closest(".section-card");
            var toanBoNoiDung = sectionCard.find(".full-content");
            var summary = sectionCard.find(".summary");
            
            if (toanBoNoiDung.is(":visible")) {
                toanBoNoiDung.hide();
                summary.show();

            } else {
                toanBoNoiDung.show();
                summary.hide();

            }
        });
    });
</script>
<?php include('../inc/footer.php'); ?>