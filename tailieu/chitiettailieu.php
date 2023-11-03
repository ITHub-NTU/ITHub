<?php
include_once '../config/Database.php';
include_once '../class/TaiLieu.php';
$database = new Database();
$db = $database->getConnection();
$taiLieu = new TaiLieu($db);
$taiLieuMaTL = $_GET['maTL'];

$taiLieu->maTL = $taiLieuMaTL; 

$chiTietTaiLieu = $taiLieu->getChiTietTaiLieu();

 include('../inc/header.php');
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ITHub - Tài Liệu</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        
    </head>
   
<?php include("../inc/navbar.php");?>
            <div class="row">
                <nav class="col-md-3 border border-1 rounded-2 " style="padding-top: 0px;">
                    <h5 class="text-center p-3 mt-2 bg-warning rounded-2 ">Loại tài liệu</h5>
                    <?php 
                    $loaiTaiLieus = $taiLieu->getLoaiTaiLieu();
                    foreach ($loaiTaiLieus as $loaiTaiLieu) {
                        $activeClass = (isset($_GET['maLoaiTL']) && $_GET['maLoaiTL'] == $loaiTaiLieu['maLoaiTL']) ? 'active' : '';
                        echo '<a class="p-2 mt-2 rounded-2 list-group-item list-group-item-action list-group-item-success" style="width:100%" href="danhsachtailieu.php?maLoaiTL=' . $loaiTaiLieu['maLoaiTL'] . '" class="' . $activeClass . '">' . $loaiTaiLieu['tenLoaiTL'] . '</a>';
                    }
                    ?>
                </nav>
                <div class="col-md-9 ">
                    <div class="border border border-1 rounded-2  ">
                        <div class="section-card m-2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="text-center"><?php echo $chiTietTaiLieu['tenTL'] ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><h6>Người đăng</h6> <a class="text-decoration-none" href="#"> <?php echo $chiTietTaiLieu['taiKhoan']; ?></a></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><h6>Ngày đăng</h6><span class="text-secondary"> <?php echo $chiTietTaiLieu['ngayDangTL']; ?></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><h6>Mô tả </h6><?php echo $chiTietTaiLieu['moTaTL']; ?></p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-2">
                                    <a href="download-pdf.php?pdf=<?php echo $chiTietTaiLieu['fileTL']; ?>" class="btn btn-primary">Tải về</a>
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-primary">Thích</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <object data="<?php echo $chiTietTaiLieu['fileTL']; ?>" type="application/pdf" width="100%" height="600">
                                        <p>Không thể hiển thị tệp PDF. <a href="<?php echo $chiTietTaiLieu['fileTL']; ?>">Tải về</a> thay vào đó.</p>
                                    </object>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include('../inc/footer.php');?>