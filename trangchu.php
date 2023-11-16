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
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ITHub - Tài Liệu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        a {
            text-decoration: none;
            
        }
     
        .d-flex::-webkit-scrollbar{
            width: 5px;
            height:6px;
            }
            .d-flex::-webkit-scrollbar-track{
            background-color: #fafafa;
            
            }
            .d-flex::-webkit-scrollbar-thumb{
            background-image: linear-gradient(-45deg, #6a5af9, #d66efd);
            border-radius: 50px;
           
            }
            .overlay {
                position: absolute;
                top: 65%;
                left: 17%;
                mix-blend-mode: overlay;
                padding: 10px;
            }
           
       

        
           
    </style>
<body>
    <?php include($path."inc/navbar.php"); ?>
    <div class="row">
        <div id="carouselExampleCaptions" class="carousel slide ">
            <div class="carousel-inner rounded-4">
                <div class="carousel-item active">
                <div style="position: relative;">
                <img src="image/lienhe.png" class="d-block w-100 " alt="tài liệu">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                </div>
                <div class="carousel-item">
                <div style="position: relative;">
                    <img src="image/tailieu.png" class="d-block w-100" alt="tài liệu">
                    <div class="overlay">
                        <a href="../ITHub/tailieu/danhsachtailieu.php" class="btn btn-light">Truy cập ngay</a>
                    </div>
                </div>
                </div>
                <div class="carousel-item">
                <div style="position: relative;">
                <img src="image/baiviet.png" class="d-block w-100" alt="tài liệu">
                <div class="overlay">
                        <a href="../ITHub/tailieu/danhsachtailieu.php" class="btn btn-light xl">Truy cập ngay</a>
                    </div>
                </div>
                </div> 
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </br>
            <div class="row bg-secondary rounded-pill">
                <div class="col-xl-3 btn btn-secondary "><a href="#section1" style="color:white">Tài liệu mới nhất</a>
                </div>
                <div class="col-xl-3 btn btn-secondary "><a href="#section2" style="color:white">Bài viết mới nhất</a>
                </div>
                <div class="col-xl-3 btn btn-secondary "><a href="#section3" style="color:white">Tài liệu yêu thích</a>
                </div>
                <div class="col-xl-3 btn btn-secondary"><a href="#section4" style="color:white">Bài viết yêu thích</a>
                </div>
            </div>
        </div>
      
       
     
        <div class="col-xl-12">
        <h5 class="p-2 mt-2 fw-bold" id="section1" style=" border-bottom: 1px solid ;">  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fire text-danger me-2" viewBox="0 0 16 16">
            <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z"/>
            </svg>Tài liệu mới nhất</h5>
                <div class="d-flex" style="
                        flex-wrap: nowrap;
                        overflow-x: auto; 
                        padding-bottom: 20px;  ">       
                    <?php
                 
                    foreach ($dsTaiLieuMoiNhat as $taiLieuMoiNhat) :?>
                    <?php
                        $currentDomain = $_SERVER['HTTP_HOST'];
                        $chitiettailieuURL = "http://".$currentDomain."/ITHUB/tailieu/chitiettailieu.php?maTL=".$taiLieuMoiNhat['maTL'];
                        ?>
                        
                        <a href="<?php echo $chitiettailieuURL; ?>"  style="--bs-link-hover-color-rgb: 25, 135, 84;color:black">
                        <div class="col-xl-2 me-2" >
                            <div class="card" style="width: 200px;">
                            <?php if (!empty($taiLieuMoiNhat['anhTL'])) : ?>
                                            <img style="width: 100%; height: 250px; object-fit: contain;" class="card-img-top" src="image/<?php echo $taiLieuMoiNhat['anhTL']; ?>" alt="Image">
                                        <?php else : ?>
                                            <img style="width: 100%; height: 250px; object-fit: contain;" class="card-img-top" src="image/macdinh.jpg" alt="Default Image">
                                        <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title" style="height: 50px;-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $taiLieuMoiNhat['tenTL']?></h5>
                                    <p class="card-text" style="height:100px ;-webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $taiLieuMoiNhat['moTaTL']?></p>
                                    <a href="nguoidung/trangcanhan.php" class="me-4"style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;color:black">
                                    <?php
                                    echo'
                                    <img style="width: 30px; height: 30px; object-fit: cover;border: 3px solid" class="user-avatar rounded-circle" src="'.$path.'image/'.$taiLieuMoiNhat['anhDaiDien'].'" alt="User Avatar">';
                                    ?>
                                    <?php echo $taiLieuMoiNhat['taiKhoan']; ?></a>
                                    <i class="fa fa-calendar text-body-secondary me-5" aria-hidden="true">  <?php echo date('d-m-Y', strtotime($taiLieuMoiNhat['ngayDuyetTL'])); ?></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    <?php endforeach;?>
                   
                </div>
                <h5 id="section2" class="p-2 mt-2 fw-bold" style=" border-bottom: 1px solid ;">  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fire text-danger me-2" viewBox="0 0 16 16">
            <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z"/>
            </svg>Bài viết mới nhất</h5>
                <div class="d-flex" style="
                        flex-wrap: nowrap;
                        overflow-x: auto; 
                        padding-bottom: 20px;">
                
                <?php
                foreach ($dsBaiVietMoiNhat as $baiVietMoiNhat) :?>
                 <?php
                    $currentDomain = $_SERVER['HTTP_HOST'];
                    $chitietbaivietURL = "http://".$currentDomain."/ITHUB/diendan/chitietbaiviet.php?maBV=".$baiVietMoiNhat['maBV'];
                ?>
                  <a href="<?php echo $chitietbaivietURL; ?>"  style="--bs-link-hover-color-rgb: 25, 135, 84;color:black">
                        <div class="col-xl-2 me-2" >
                            <div class="card" style="width: 200px;">
                                <div class="card-body">
                                    <h5 class="card-title" style="height: 50px;-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $baiVietMoiNhat['tenBV']?></h5>
                                    <p class="card-text" style="height:100px ;-webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $baiVietMoiNhat['noiDungBV']?></p>
                                    <a href="nguoidung/trangcanhan.php" class="me-4"style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;color:black">
                                    <?php
                                    echo'
                                    <img style="width: 30px; height: 30px; object-fit: cover;border: 3px solid" class="user-avatar rounded-circle" src="'.$path.'image/'.$baiVietMoiNhat['anhDaiDien'].'" alt="User Avatar">';
                                    ?>
                                    <?php echo $baiVietMoiNhat['taiKhoan']; ?></a>
                                    <i class="fa fa-calendar text-body-secondary me-5" aria-hidden="true">  <?php echo date('d-m-Y', strtotime($baiVietMoiNhat['ngayDuyetBV'])); ?></i>
                                </div>
                            </div>
                        </div>
                        </a>  
                <?php endforeach;?>
                
                </div>
                <h5 class="p-2 mt-2 fw-bold" id="section3" style=" border-bottom: 1px solid ;">  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-heart text-success me-2" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"/>
              <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
              </svg>Tài liệu yêu thích</h5>
                <div class="d-flex" style="
                        flex-wrap: nowrap;
                        overflow-x: auto; 
                        padding-bottom: 20px;">
          
      
              <?php if ($dsTaiLieuYeuThich !== null) : ?>
                <?php
                    foreach ($dsTaiLieuYeuThich as $taiLieuYeuThich) :?>
                    <?php
                        $currentDomain = $_SERVER['HTTP_HOST'];
                        $chitiettailieuURL = "http://".$currentDomain."/ITHUB/tailieu/chitiettailieu.php?maTL=".$taiLieuYeuThich['maTL'];
                        ?>
                        <a href="<?php echo $chitiettailieuURL; ?>"  style="--bs-link-hover-color-rgb: 25, 135, 84;color:black">
                        <div class="col-xl-2 me-2" >
                            <div class="card" style="width: 200px;">
                            <?php if (!empty($taiLieuYeuThich['anhTL'])) : ?>
                                            <img style="width: 100%; height: 250px; object-fit: contain;" class="card-img-top" src="image/<?php echo $taiLieuYeuThich['anhTL']; ?>" alt="Image">
                                        <?php else : ?>
                                            <img style="width: 100%; height: 250px; object-fit: contain;" class="card-img-top" src="image/macdinh.jpg" alt="Default Image">
                                        <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title" style="height: 50px;-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $taiLieuYeuThich['tenTL']?></h5>
                                    <p class="card-text" style="height:100px ;-webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $taiLieuYeuThich['moTaTL']?></p>
                                    <a href="nguoidung/trangcanhan.php" class="me-4"style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;color:black">
                                    <?php
                                    echo'
                                    <img style="width: 30px; height: 30px; object-fit: cover;border: 3px solid" class="user-avatar rounded-circle" src="'.$path.'image/'.$taiLieuYeuThich['anhDaiDien'].'" alt="User Avatar">';
                                    ?>
                                    <?php echo $taiLieuYeuThich['taiKhoan']; ?></a>
                                    <i class="fa fa-calendar text-body-secondary me-5" aria-hidden="true">  <?php echo date('d-m-Y', strtotime($taiLieuYeuThich['ngayDuyetTL'])); ?></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </a>
                    <?php endforeach;?>
              <?php else : ?>
                  <p>Không tìm thấy tài liệu.</p>
              <?php endif; ?>
                </div>
              <h5 class="p-2 mt-2 fw-bold" id="section4" style=" border-bottom: 1px solid ;">  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check text-primary me-2" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
              <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
              </svg>Bài viết yêu thích</h5>
              <?php
                     foreach ($dsBaiVietYeuThich as $baiVietYeuThich) :?>
                 <?php
                    $currentDomain = $_SERVER['HTTP_HOST'];
                    $chitietbaivietURL = "http://".$currentDomain."/ITHUB/diendan/chitietbaiviet.php?maBV=".$baiVietYeuThich['maBV'];
                ?>
                  <a href="<?php echo $chitietbaivietURL; ?>"  style="--bs-link-hover-color-rgb: 25, 135, 84;color:black">
                        <div class="col-xl-2 me-2" >
                            <div class="card" style="width: 200px;">
                                <div class="card-body">
                                    <h5 class="card-title" style="height: 50px;-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $baiVietYeuThich['tenBV']?></h5>
                                    <p class="card-text" style="height:100px ;-webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"><?php echo  $baiVietYeuThich['noiDungBV']?></p>
                                    <a href="nguoidung/trangcanhan.php" class="me-4"style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;color:black">
                                    <?php
                                    echo'
                                    <img style="width: 30px; height: 30px; object-fit: cover;border: 3px solid" class="user-avatar rounded-circle" src="'.$path.'image/'.$baiVietYeuThich['anhDaiDien'].'" alt="User Avatar">';
                                    ?>
                                    <?php echo $baiVietYeuThich['taiKhoan']; ?></a>
                                    <i class="fa fa-calendar text-body-secondary me-5" aria-hidden="true">  <?php echo date('d-m-Y', strtotime($baiVietYeuThich['ngayDuyetBV'])); ?></i>
                                </div>
                            </div>
                        </div>
                        </a>

                <?php endforeach;?>
            </div>
 
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    
        $(document).ready(function() {
        function load_unseen_notification(view = '') {
            $.ajax({
                url: "../ITHub/notification/fetch.php",
                method: "POST",
                data: { view: view },
                dataType: "json",
                success: function(data) {
                    $('#notification').html(data.notification);
                    if (data.unseen_notification > 0) {
                        $('.badge.bg-danger').show();
                        if (data.unseen_notification > 10) {
                            $('.count').html('10<sup style="font-weight: bold;">+</sup>');
                        } else {
                            $('.count').html(data.unseen_notification);
                        }
                    } else {
                        $('.count').html('');
                        $('.badge.bg-danger').hide();
                    }
                    if (data.unseen_message > 0) {
                        $('.countTN').show();
                        if (data.unseen_message > 10) {
                            $('.countTN').html('10<sup style="font-weight: bold;">+</sup>');
                        } else {
                            $('.countTN').html(data.unseen_message);
                        }
                    } else {
                        $('.countTN').html('');
                        $('.countTN').hide();
                    }
                }
            });
        }

        load_unseen_notification();

        $('#comment_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#subject').val() != '' && $('#comment').val() != '') {
                var form_data = $(this).serialize();
                $.ajax({
                    url: "insert.php",
                    method: "POST",
                    data: form_data,
                    success: function(data) {
                        $('#comment_form')[0].reset();
                        load_unseen_notification();
                    }
                });
            } else {
                alert("Both Fields are Required");
            }
        });

        $(document).on('click', '#thongbao', function() {
            $('.count').html('');
            load_unseen_notification('yes');
        });

        setInterval(function() {
            load_unseen_notification();
        }, 5000);
    });
    </script>
<?php include($path.'inc/footer.php'); ?>
