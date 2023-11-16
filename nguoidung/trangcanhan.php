    <?php
    include_once '../config/Database.php';
    include_once '../class/NguoiDung.php';
    include_once '../class/BaiViet.php';
    include_once '../class/TienIch.php';

    $database = new Database();
    $db = $database->getConnection();
    $tblNguoiDung = new NguoiDung($db);

    if(!(isset($_SESSION['taiKhoan']))){
    header('Location:./dangnhap.php');
    }

    $modalMessage ='';
    $taiKhoan = $_SESSION['taiKhoan'];
    $userInfo = $tblNguoiDung->getUserInfoFromDatabase();

    if ($userInfo) {
        $taiKhoan = $userInfo['taiKhoan'];
        $email = $userInfo['email'];
        $hoND = $userInfo['hoND'];
        $tenND = $userInfo['tenND'];
        $quyen = $userInfo['quyen'];
        $ngaySinh = $userInfo['ngaySinh'];
        $anhDaiDien = $userInfo['anhDaiDien'];

        if ($quyen === 'nguoidung') {
            $quyen = 'Người dùng';
        } elseif ($quyen === 'quantrivien') {
            $quyen = 'Quản trị viên';
        } else {
            $quyen = 'Người dùng bị chặn';
        }

        $ngaySinh = date('d/m/Y', strtotime($ngaySinh));
    } else {
        echo "Không tìm thấy thông tin người dùng.";
    }

    if (isset($_SESSION['taiKhoan'])) {
        $countFriends = $tblNguoiDung->countFriends($taiKhoan) - 1;
        $countFriends = max(0, $countFriends);
        $taiKhoan = $_SESSION['taiKhoan'];
        $tblNguoiDung->taiKhoan = $taiKhoan;
        $resultBV = $tblNguoiDung->layDanhSachBaiVietCuaNguoiDung();
        $countBaiViet = mysqli_num_rows($resultBV);
        $resultTL = $tblNguoiDung->layDanhSachTaiLieuCuaNguoiDung();
        $countTaiLieu = mysqli_num_rows($resultTL);
        $resultTLYT = $tblNguoiDung->layDanhSachTaiLieuYeuThichCuaNguoiDung();
        $resultBVYT = $tblNguoiDung->layDanhSachBaiVietYeuThichCuaNguoiDung();
    }



include('../inc/header.php');
include('../inc/navbar.php');
?>
<style>
  .custom-bg {
    background-image: url('../image/lienhe.png'); 
    background-size: cover; 
    height: 200px;
  }
</style>
<section class="mh-100 gradient-custom-2">
<div class="container py-5 h-100">
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col col-md-9">
    <div class="card">
        <div class="rounded-top text-white d-flex flex-row custom-bg" >
        <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
            <img src="../image/<?php echo $anhDaiDien?>"                          
            alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
            style="width: 150px; height: 150px; object-fit: cover; z-index: 1">
            <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark"
            style="z-index: 1;">
            <a class="text-decoration-none" href="chinhsuathongtin.php">Chỉnh sửa</a>
            </button>
        </div>
        <div class="ms-3" style="margin-top: 170px;">
            <?php   
            echo '<h5>' .$taiKhoan. '</h5>';
            ?>
        </div>
        </div>
        <div class="p-2 text-black" style="background-color: #f8f9fa;">
        <div class="d-flex justify-content-end text-center py-1">
            <div>
            <p class="mb-1 h5"><?php echo $countTaiLieu; ?></p>
            <p class="small text-muted mb-0">Tài liệu</p>
            </div>
            <div class="px-3">
            <p class="mb-1 h5"><?php echo $countBaiViet; ?></p>
            <p class="small text-muted mb-0">Bài viết</p>
            </div>
            <div>
            <p class="mb-1 h5"><?php echo "$countFriends"?></p>
            <p class="small text-muted mb-0">Bạn</p>
            </div>
        </div>
        </div>
        <div class="card-body p-4 text-black">
        <div class="mb-5">
            <p class="lead fw-normal mb-1">Thông tin cá nhân</p>
            <div class="p-4" style="background-color: #f8f9fa;">
            <?php   
                
                echo '<p class="font-italic mb-1">Họ và tên: ' . $hoND . ' ' . $tenND . '</p>';
                echo '<p class="font-italic mb-1">Ngày sinh: ' .$ngaySinh. '</p>';
                echo '<p class="font-italic mb-0">Quyền: ' .$quyen. '</p>';
            ?>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button id="baiVietButton" class="nav-link active" >Bài viết</button >
            </li>
            <li class="nav-item ">
                <button id="taiLieuButton" class="nav-link " >Tài liệu</button >
            </li>
            <li class="nav-item ">
                <button id="baiVietYTButton" class="nav-link " >Bài viết yêu thích</button >
            </li>
            <li class="nav-item ">
                <button id="taiLieuYTButton" class="nav-link" >Tài liệu yêu thích</button >
            </li>
        </ul>

        <div class="card" id="baiVietSection" >
            <div class="row">
                <?php
                if (mysqli_num_rows($resultBV) > 0) {
                ?>
                <div class="row">
                    <?php
                    while ($baiViet = $resultBV->fetch_assoc()) {
                        $tblTienIch = new TienIch($db);
                        $maBV = $baiViet['maBV'];
                        $tenBV = $baiViet['tenBV'];
                        $ngayDangBV = $baiViet['ngayDangBV'];
                        $taiKhoanBV = $baiViet['taiKhoan'];
                        $luotXem = $baiViet['luotXem'];
                        $ngayDangFormatted = strtotime($baiViet['ngayDangBV']);
                        $ngayDang = $tblTienIch->formatTimeAgo($ngayDangFormatted);
                        $anhDaiDien = $baiViet['anhDaiDien'];

                        $tblbaiViet = new BaiViet($db);
                        $tblbaiViet->maBV = $maBV;
                        $soLuongThaoLuan = $tblbaiViet->laySoLuongThaoLuan();
                        $thaoLuanMoiNhat = $tblbaiViet->layThaoLuanMoiNhat();
                        ?>
                        
                        <div class="col-md-12 justify-content-center">
                            <a class="text-decoration-none" href="../diendan/chitietbaiviet.php?maBV=<?php echo $maBV; ?>" title="<?php echo $tenBV; ?>">
                                <div style="margin-left: 20px" class="card mt-3 mb-3">
                                    <div class="row g-0 justify-content-center">
                                        <div class="col-2">
                                            <img src="../image/<?php echo $anhDaiDien; ?>" class="img-thumbnail d-block" style="width: 5em; " alt="...">
                                            <p style="color: blue; margin-left: 5px"><?php echo $taiKhoanBV; ?></p>
                                        </div>
                                        <div class="col-10">
                                            <div class="row justify-content-center">
                                                <div class="col-10">
                                                    <?php echo $tenBV; ?>
                                                </div>
                                                <div class="col-2 d-flex">
                                                    <form name="deleteBV" method="post">
                                                        <input type="hidden" name="maBV" value="<?php echo $maBV; ?>">
                                                        <button type="submit" name="deleteBV" class="btn btn-danger mt-4">
                                                            <i class="fas fa-trash-alt"></i> 
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 d-flex justify-content-between">
                                        <p>Bình luận: <?php echo $soLuongThaoLuan; ?></p>
                                        <p>Lượt xem: <?php echo $luotXem; ?></p>
                                        <p><?php echo $ngayDang; ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        
                    <?php
                    }
                    ?>
                </div>
                <?php
                } else {
                    echo "<div class='col-12 text-center d-flex justify-content-center align-items-center' style='height: 300px; color: red; font-size: 24px;'>
                    Không có đăng bài viết nào. 
                    </div>";
                }
                ?>
            </div>
        </div>


        <div class="card d-none" id="taiLieuSection" >
            <div class="card-body">
                <div class="row">
                    <?php
                    if (mysqli_num_rows($resultTL) > 0) {
                        while ($taiLieu = $resultTL->fetch_assoc()) {
                            $maTL = $taiLieu['maTL'];
                            $maLoaiTL = $taiLieu['tenLoaiTL'];
                            $taiKhoan = $taiLieu['taiKhoan'];
                            $tenTL = $taiLieu['tenTL'];
                            $moTaTL = $taiLieu['moTaTL'];
                            $fileTL = $taiLieu['fileTL'];
                            $ngayDangFormatte = strtotime($taiLieu['ngayDangTL']);
                            $ngayDangTL = $tblTienIch->formatTimeAgo($ngayDangFormatte);
                            $anhTL = $taiLieu['anhTL'];
                            $trangThaiTL = $taiLieu['trangThaiTL'];
                            $tenDD = $taiLieu['tenDD'];
                            $tenLoaiTL = $taiLieu['tenLoaiTL'];
                    ?>
                    <div class="col-md-12">
                        <a class="text-decoration-none text-black" href="tailieu/chitiettailieu.php?maTL=<?php echo $maTL; ?>" title="<?php echo $tenTL; ?>">
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="./image/<?php echo $anhTL; ?>" style="height: 100%" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title text-black h3 text-center"><?php echo $tenTL; ?></h5>
                                            <p class="card-text"><?php echo $moTaTL; ?></p>
                                            <p class="card-text">Ngày đăng: <?php echo $ngayDangTL; ?></p>
                                            <p class="card-text">Loại tài liệu: <?php echo $tenLoaiTL; ?></p>
                                            <p class="card-text">Danh mục: <?php echo $tenDD; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center align-items-center"> 
                                    <form name="deleteTL" method="post">
                                        <input type="hidden" name="maTL" value="<?php echo $maTL; ?>">
                                        <div class="d-flex justify-content-center align-items-center"> 
                                            <button type="submit" name="deleteTL" class="btn btn-danger mb-3">
                                                <i class="fas fa-trash-alt"></i> 
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <?php
                        }
                    } else {
                        echo "<div class='col-12 text-center d-flex justify-content-center align-items-center ' style='height: 300px; color: red; font-size: 24px;'>
                        Không có đăng tài liệu nào.
                        </div>";
                    }
                    ?>
                </div>
            </div>
        </div>



        <div class="card d-none" id="baiVietYeuThichSection"">
            <div class="row">
                <?php
                if (mysqli_num_rows($resultBVYT) > 0) {
                ?>
                <div class="row">
                    <?php
                    while ($baiVietYT = $resultBVYT->fetch_assoc()) {
                    $tblTienIch = new TienIch($db);
                    $maBV = $baiVietYT['maBV'];
                    $tenBV = $baiVietYT['tenBV'];
                    $ngayDangBV = $baiVietYT['ngayDangBV'];
                    $taiKhoanBV = $baiVietYT['taiKhoan'];
                    $luotXem = $baiVietYT['luotXem'];
                    $ngayDangFormatted = strtotime($baiVietYT['ngayDangBV']);
                    $ngayDang = $tblTienIch->formatTimeAgo($ngayDangFormatted);
                    $anhDaiDien = $baiVietYT['anhDaiDien'];
    
                    $tblbaiViet = new BaiViet($db);
                    $tblbaiViet->maBV = $maBV;
                    $soLuongThaoLuan = $tblbaiViet->laySoLuongThaoLuan();
                    $thaoLuanMoiNhat = $tblbaiViet->layThaoLuanMoiNhat();
                    ?>
                        
                        <div class="col-md-12">
                        <a class="text-decoration-none" href="../diendan/chitietbaiviet.php?maBV=<?php echo $maBV; ?>" title="<?php echo $tenBV; ?>">
                            <div style="margin-left: 20px" class="card mt-3 mb-3">
                                <div class="row g-0 justify-content-center">
                                    <div class="col-2">
                                        <img src="../image/<?php echo $anhDaiDien; ?>" class="img-thumbnail d-block" style="width: 4em;" alt="...">
                                        <p style="color: blue; margin-left: 5px"><?php echo $taiKhoanBV; ?></p>
                                    </div>
                                    <div class="col-10">
                                        <div class="row justify-content-center">
                                            <div class="col-10">
                                                    <?php echo $tenBV; ?>
                                            </div>
                                            <div class="col-2 d-flex">
                                                <form name="deleteBV" method="post">
                                                    <input type="hidden" name="maBV" value="<?php echo $maBV; ?>">
                                                    <button type="submit" name="deleteBV" class="btn btn-danger mt-4">
                                                        <i class="fas fa-trash-alt"></i> 
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="px-4 d-flex justify-content-between">
                                    <p>Bình luận: <?php echo $soLuongThaoLuan; ?></p>
                                    <p>Lượt xem: <?php echo $luotXem; ?></p>
                                    <p><?php echo $ngayDang; ?></p>
                                </div>
                            </div>
                        </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                } else {
                    echo "<div class='col-12 text-center d-flex justify-content-center align-items-center' style='height: 300px; color: red; font-size: 24px;'>
                    Không có bài viết yêu thích. 
                    </div>";
                }
                ?>
            </div>
        </div>


        <div class="card d-none" id="taiLieuYeuThichSection" >
            <div class="card-body">
                <div class="row">
                    <?php
                    if (mysqli_num_rows($resultTLYT) > 0) {
                        while ($taiLieuYT = $resultTLYT->fetch_assoc()) {
                            $maTL = $taiLieuYT['maTL'];
                            $maLoaiTL = $taiLieuYT['tenLoaiTL'];
                            $taiKhoan = $taiLieuYT['taiKhoan'];
                            $tenTL = $taiLieuYT['tenTL'];
                            $moTaTL = $taiLieuYT['moTaTL'];
                            $fileTL = $taiLieuYT['fileTL'];
                            $ngayDangFormatte = strtotime($taiLieuYT['ngayDangTL']);
                            $ngayDangTL = $tblTienIch->formatTimeAgo($ngayDangFormatte);
                            $anhTL = $taiLieuYT['anhTL'];
                            $trangThaiTL = $taiLieuYT['trangThaiTL'];
                            $tenDD = $taiLieuYT['tenDD'];
                            $tenLoaiTL = $taiLieuYT['tenLoaiTL'];
                    ?>
                    <div class="col-md-12">
                        <a class="text-decoration-none text-black" href="tailieu/chitiettailieu.php?maTL=<?php echo $maTL; ?>" title="<?php echo $tenTL; ?>">
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="./image/<?php echo $anhTL; ?>" style="height: 100%" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title text-black h3 text-center"><?php echo $tenTL; ?></h5>
                                            <p class="card-text"><?php echo $moTaTL; ?></p>
                                            <p class="card-text">Ngày đăng: <?php echo $ngayDangTL; ?></p>
                                            <p class="card-text">Loại tài liệu: <?php echo $tenLoaiTL; ?></p>
                                            <p class="card-text">Danh mục: <?php echo $tenDD; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center align-items-center"> 
                                    <form name="deleteTLYT" method="post">
                                        <input type="hidden" name="maTL" value="<?php echo $maTL; ?>">
                                        <div class="d-flex justify-content-center align-items-center"> 
                                            <button type="submit" name="deleteTLYT" class="btn btn-danger mb-3">
                                                <i class="fas fa-trash-alt"></i> 
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                        }
                    } else {
                        echo "<div class='col-12 text-center d-flex justify-content-center align-items-center ' style='height: 300px; color: red; font-size: 24px;'>
                        Không có tài liệu yêu thích nào.
                        </div>";
                    }
                    ?>
                </div>
            </div>
        </div>


        </div>
    </div>
    </div>
</div>
</div>
</section>

<div id="myModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Thông báo</h5>
            <button type="button" class="close" data-dismiss="modal" id="modalCloseButton">&times;</button>
        </div>
        <div class="modal-body" id="modalMessage">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeButton">Đóng</button>
        </div>
    </div>
</div>
</div>
<script>
$('form[name="deleteBV"]').submit(function(event) {
event.preventDefault(); 

var maBV = $(this).find('input[name="maBV"]').val();

$.ajax({
    type: 'POST',
    url: 'xoadulieu.php',
    data: { deleteBV: true, maBV: maBV },
    dataType: 'json',
    success: function(response) {
        if (response.status === "success") {
            $('#myModal').modal('show');
            $('#modalMessage').text('Đã xóa bài viết thành công.');
            setTimeout(function() {
                location.reload();
            }, 2000); 
        } else {
            $('#modalMessage').text('Đã xảy ra lỗi trong quá trình xóa bài viết.');
            $('#myModal').modal('show');
        }
    },
    error: function(xhr, status, error) {
        $('#modalMessage').text('Đã xảy ra lỗi trong quá trình xóa bài viết Error.');
        $('#myModal').modal('show');
    }
});
});

$('form[name="deleteTL"]').submit(function(event) {
event.preventDefault(); 

var maTL = $(this).find('input[name="maTL"]').val();

$.ajax({
    type: 'POST',
    url: 'xoadulieu.php',
    data: { deleteTL: true, maTL: maTL },
    dataType: 'json',
    success: function(response) {
        if (response.status === 'success') {
            $('#myModal').modal('show');
            $('#modalMessage').text('Đã xóa tài liệu thành công.');
            setTimeout(function() {
                location.reload();
            }, 2000); 
        } else {
            $('#modalMessage').text('Đã xảy ra lỗi trong quá trình xóa tài liệu.');
            $('#myModal').modal('show');
        }
    },
    error: function(xhr, status, error) {
        $('#modalMessage').text('Đã xảy ra lỗi trong quá trình xóa tài liệu.');
        $('#myModal').modal('show');
    }
});
});

$('form[name="deleteBVYT"]').submit(function(event) {
event.preventDefault(); 

var maBVYT = $(this).find('input[name="maBVYT"]').val();

$.ajax({
    type: 'POST', 
    url: 'xoadulieu.php',
    data: { deleteBVYT: true, maBVYT: maBVYT },
    dataType: 'json',
    success: function(response) {
        if (response.status === 'success'){
            $('#myModal').modal('show');
            $('#modalMessage').text('Đã xóa bài viết yêu thích thành công.');
            setTimeout(function() {
                location.reload();
            }, 2000); 
        } else {
            $('#modalMessage').text('Đã xảy ra lỗi trong quá trình xóa bài viết yêu thích.');
            $('#myModal').modal('show');
        }
        
    },
    error: function(xhr, status, error) {
        $('#modalMessage').text('Đã xảy ra lỗi trong quá trình xóa bài viết yêu thích.');
        $('#myModal').modal('show');
    }
});
});


$('form[name="deleteTLYT"]').submit(function(event) {
event.preventDefault(); 

var maTLYT = $(this).find('input[name="maTLYT"]').val();

$.ajax({
    type: 'POST',
    url: 'xoadulieu.php',
    data: { deleteTLYT: true, maTLYT: maTLYT },
    dataType: 'json',
    success: function(response) {
        if (response.status === 'success'){
            $('#myModal').modal('show');
            $('#modalMessage').text('Đã xóa tài liệu yêu thích thành công.');
            setTimeout(function() {
                location.reload();
            }, 2000); 
        } else {
            $('#modalMessage').text('Đã xảy ra lỗi trong quá trình xóa tài liệu yêu thích.');
            $('#myModal').modal('show');
        }
        
    },
    error: function(xhr, status, error) {
        $('#modalMessage').text('Đã xảy ra lỗi trong quá trình xóa tài liệu yêu thích.');
        $('#myModal').modal('show');
    }
});
});
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById("baiVietButton").addEventListener("click", function() {

    document.getElementById("baiVietSection").classList.remove("d-none");
    document.getElementById("taiLieuSection").classList.add("d-none");
    document.getElementById("baiVietYeuThichSection").classList.add("d-none");
    document.getElementById("taiLieuYeuThichSection").classList.add("d-none");
});

document.getElementById("taiLieuButton").addEventListener("click", function() {
    document.getElementById("taiLieuSection").classList.remove("d-none");
    document.getElementById("baiVietSection").classList.add("d-none");
    document.getElementById("baiVietYeuThichSection").classList.add("d-none");
    document.getElementById("taiLieuYeuThichSection").classList.add("d-none");
});

document.getElementById("baiVietYTButton").addEventListener("click", function() {
    document.getElementById("baiVietYeuThichSection").classList.remove("d-none");
    document.getElementById("baiVietSection").classList.add("d-none");
    document.getElementById("taiLieuSection").classList.add("d-none");
    document.getElementById("taiLieuYeuThichSection").classList.add("d-none");
});

document.getElementById("taiLieuYTButton").addEventListener("click", function() {
    document.getElementById("taiLieuYeuThichSection").classList.remove("d-none");
    document.getElementById("baiVietSection").classList.add("d-none");
    document.getElementById("taiLieuSection").classList.add("d-none");
    document.getElementById("baiVietYeuThichSection").classList.add("d-none");
});

$(document).ready(function() {
    $('.nav-link').click(function() {
        $('.nav-link').removeClass('active');
        
        $(this).addClass('active');
    });
});
</script>



<script>
<?php if (!empty($modalMessage)) { ?>
    $(document).ready(function() {
        $('#myModal').modal('show');
    });
<?php } ?>
document.getElementById("closeButton").addEventListener("click", function() {
    $('#myModal').modal('hide');
});

document.getElementById("modalCloseButton").addEventListener("click", function() {
    $('#myModal').modal('hide');
});
</script>

<?php 
include('../inc/footer.php');
?>
