<?php
//Include thu vien
include_once '../config/Database.php';
include_once '../class/NguoiDung.php';
include_once '../class/BaiViet.php';
include_once '../class/TienIch.php';

$database = new Database();
$db = $database->getConnection();
$tblNguoiDung = new NguoiDung($db);

if(!(isset($_SESSION['taiKhoan']))){
    header('Location: ../dangnhap.php');
}
if(!(isset($_GET['taiKhoanBanBe']))){
    header('Location: ../trangchu.php');
}
if($_GET['taiKhoanBanBe'] == $_SESSION['taiKhoan']){
    header('Location: ./trangcanhan.php');
}
$taiKhoanBB = $_GET['taiKhoanBanBe'];
$taiKhoan = $_SESSION['taiKhoan'];
$userInfo = $tblNguoiDung->getUserInfoByTaiKhoan($taiKhoanBB);

if ($userInfo) {
    $taiKhoanBB = $userInfo['taiKhoan'];
    $email = $userInfo['email'];
    $hoND = $userInfo['hoND'];
    $tenND = $userInfo['tenND'];
    $quyen = $userInfo['quyen'];
    $ngaySinh = $userInfo['ngaySinh'];
    $anhDaiDienBB = $userInfo['anhDaiDien'];

    if ($quyen === 'nguoidung') {
        $quyen = 'Người dùng';
    } elseif ($quyen === 'quantrivien') {
        $quyen = 'Quản trị viên';
    } else {
        header('Location: ./trangchan.php');
    }

    $ngaySinh = date('d/m/Y', strtotime($ngaySinh));
} else {
    echo "Không tìm thấy thông tin người dùng.";
}

if (isset($_GET['taiKhoanBanBe'])) {
    $taiKhoanBB = $_GET['taiKhoanBanBe'];
    $countFriends = $tblNguoiDung->countFriends($taiKhoanBB) - 1;
    $countFriends = max(0, $countFriends);
    $tblNguoiDung->taiKhoan = $taiKhoanBB;
    $resultBV = $tblNguoiDung->layDanhSachBaiVietCuaNguoiDung();
    $countBaiViet = mysqli_num_rows($resultBV);
    $resultTL = $tblNguoiDung->layDanhSachTaiLieuCuaNguoiDung($taiKhoanBB);
    $countTaiLieu = mysqli_num_rows($resultTL);
    $resultTLYT = $tblNguoiDung->layDanhSachTaiLieuYeuThichCuaNguoiDung($taiKhoanBB);
    $resultBVYT = $tblNguoiDung->layDanhSachBaiVietYeuThichCuaNguoiDung($taiKhoanBB);
}

if(isset($_POST['banUser'])){
    $taiKhoanBan = $_POST['taiKhoanBan']; 
    $result = $tblNguoiDung->chanUser($taiKhoanBan); 
    if($result) {
        header('Location: ../trangchu.php');
        exit;
    } else {
        echo "Failed to ban user.";
    }
}

    
include('../inc/header.php');
include('../inc/navbar.php');
?>
<section class="mh-100 gradient-custom-2">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-md-9">
        <div class="card">
          <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
              <img src="../image/<?php echo $anhDaiDienBB?>"                          
                alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                style="width: 150px; height: 150px; object-fit: cover; z-index: 1">
              <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark"
                style="z-index: 1;">
                <a class="text-decoration-none" href="chinhsuathongtin.php">Chỉnh sửa</a>
              </button>
            </div>
            <div class="ms-3" style="margin-top: 170px;">
              <?php   
                echo '<h5>' .$taiKhoanBB. '</h5>';
              ?>
            </div>
          </div>
          <div class="p-2 text-black" style="background-color: #f8f9fa;">
            <div class="d-flex justify-content-end text-center py-1">
                <div>
                    <?php
                        $userInfoAdmin = $tblNguoiDung->getUserInfoByTaiKhoan($_SESSION['taiKhoan']);
                        $quyenadmin = $userInfoAdmin['quyen'];
                        if ($quyenadmin === 'quantrivien') {
                        ?>
                        <form method="post" action="">
                            <div class="mt-2">
                                <button type="button" class="text-decoration-none btn btn-danger" data-bs-toggle="modal" data-bs-target="#banModal">Chặn</button>
                            </div>
                        </form>
                        <?php
                        }
                    ?>
                </div>
                <div>
                    <a href="#" class="text-decoration-none">
                        <i class="fas fa-comment mx-5 mb-1 h5"></i>
                        <p class="small text-muted mb-0 mx-2">Nhắn tin</p>
                    </a>
                </div>
                
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

            <div class="d-flex justify-content-around">
              <button style="border-radius: 0;" id="showBaiViet" class="btn btn-primary col">Bài viết</button>
              <button style="border-radius: 0;" id="showTaiLieu" class="btn btn-primary col">Tài liệu</button>
              <button style="border-radius: 0;" id="showBaiVietYeuThich" class="btn btn-primary col">Bài viết yêu thích</button>
              <button style="border-radius: 0;" id="showTaiLieuYeuThich" class="btn btn-primary col">Tài liệu yêu thích</button>
            </div>

            <div class="card" id="baiVietSection">
            <h5  class="card-header h2" style="background-color: cadetblue; text-align: center">Bài viết đã đăng</h5>
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
                         
                          <div class="col-md-12 mx-2">
                            <a class="text-decoration-none" href="../diendan/chitietbaiviet.php?maBV=<?php echo $maBV; ?>" title="<?php echo $tenBV; ?>">
                              <div class="card mb-3">
                                  <div class="row g-0">
                                      <div class="col-3">
                                          <img src="../image/<?php echo $anhDaiDien; ?>" class="img-thumbnail d-block" style="width: 4em;" alt="...">
                                          <p style="color: blue; margin-left: 5px"><?php echo $taiKhoanBV; ?></p>
                                      </div>
                                      <div class="col-9">
                                          <div class="row">
                                              <div class="col-12">
                                                      <?php echo $tenBV; ?>
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


            <div class="card d-none" id="taiLieuSection">
                <h5 class="card-header h2" style="background-color: cadetblue; text-align: center">Tài liệu đã đăng</h5>
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

            <div class="card d-none" id="baiVietYeuThichSection">
            <h5 class="card-header h2" style="background-color: cadetblue; text-align: center">Bài viết yêu thích</h5>
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
                          
                          <div class="col-md-12 mx-2">
                            <a class="text-decoration-none" href="../diendan/chitietbaiviet.php?maBV=<?php echo $maBV; ?>" title="<?php echo $tenBV; ?>">
                              <div class="card mb-3">
                                  <div class="row g-0">
                                      <div class="col-3">
                                          <img src="../image/<?php echo $anhDaiDien; ?>" class="img-thumbnail d-block" style="width: 4em;" alt="...">
                                          <p style="color: blue; margin-left: 5px"><?php echo $taiKhoanBV; ?></p>
                                        </div>
                                      <div class="col-9">
                                          <div class="row">
                                              <div class="col-12">
                                                      <?php echo $tenBV; ?>
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
    

            <div class="card d-none" id="taiLieuYeuThichSection">
            <h5 class="card-header h2" style="background-color: cadetblue; text-align: center">Tài liệu yêu thích</h5>
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

<div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Khóa người dùng</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn khóa người dùng này?
      </div>
      <div class="modal-footer">
        <form  method="post">
          <input type="hidden"  name="taiKhoanBan" value="<?php echo $taiKhoanBB; ?>">
          <button type="submit" name="banUser" class="btn btn-danger">Khóa người dùng</button>
        </form>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Quay lại</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



<script>
    const showBaiVietButton = document.getElementById("showBaiViet");
    const showTaiLieuButton = document.getElementById("showTaiLieu");
    const showBaiVietYeuThichButton = document.getElementById("showBaiVietYeuThich");
    const showTaiLieuYeuThichButton = document.getElementById("showTaiLieuYeuThich");
    const baiVietSection = document.getElementById("baiVietSection");
    const taiLieuSection = document.getElementById("taiLieuSection");
    const baiVietYeuThichSection = document.getElementById("baiVietYeuThichSection");
    const taiLieuYeuThichSection = document.getElementById("taiLieuYeuThichSection");

    showBaiVietButton.addEventListener("click", function () {
        showBaiVietButton.classList.add("active");
        showTaiLieuButton.classList.remove("active");
        showBaiVietYeuThichButton.classList.remove("active");
        showTaiLieuYeuThichButton.classList.remove("active");

        baiVietSection.classList.remove("d-none");
        taiLieuSection.classList.add("d-none");
        baiVietYeuThichSection.classList.add("d-none");
        taiLieuYeuThichSection.classList.add("d-none");
    });

    showTaiLieuButton.addEventListener("click", function () {
        showBaiVietButton.classList.remove("active");
        showTaiLieuButton.classList.add("active");
        showBaiVietYeuThichButton.classList.remove("active");
        showTaiLieuYeuThichButton.classList.remove("active");

        baiVietSection.classList.add("d-none");
        taiLieuSection.classList.remove("d-none");
        baiVietYeuThichSection.classList.add("d-none");
        taiLieuYeuThichSection.classList.add("d-none");
    });

    showBaiVietYeuThichButton.addEventListener("click", function () {
        showBaiVietButton.classList.remove("active");
        showTaiLieuButton.classList.remove("active");
        showBaiVietYeuThichButton.classList.add("active");
        showTaiLieuYeuThichButton.classList.remove("active");

        baiVietSection.classList.add("d-none");
        taiLieuSection.classList.add("d-none");
        baiVietYeuThichSection.classList.remove("d-none");
        taiLieuYeuThichSection.classList.add("d-none");
    });

    showTaiLieuYeuThichButton.addEventListener("click", function () {
        showBaiVietButton.classList.remove("active");
        showTaiLieuButton.classList.remove("active");
        showBaiVietYeuThichButton.classList.remove("active");
        showTaiLieuYeuThichButton.classList.add("active");

        baiVietSection.classList.add("d-none");
        taiLieuSection.classList.add("d-none");
        baiVietYeuThichSection.classList.add("d-none");
        taiLieuYeuThichSection.classList.remove("d-none");
    });
</script>




<?php 
include('../inc/footer.php');
?>
