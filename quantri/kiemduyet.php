<?php
include_once '../config/Database.php';
include_once '../class/QuanTriTaiLieu.php';
include_once '../class/TienIch.php';
include_once '../class/ThongBao.php';
include_once '../class/TaiLieu.php';

$database = new Database();
$db = $database->getConnection();
$tblQuanTriTaiLieu = new QuanTriTaiLieu($db);
$tblTienIch = new TienIch($db);
$tblThongBao = new ThongBao($db);
$tblTaiLieu = new TaiLieu($db);
date_default_timezone_set('Asia/Ho_Chi_Minh'); 

$msg ="";
    if(!(isset($_SESSION['taiKhoan']))){
        header('Location: ../nguoidung/dangnhap.php');
    }
    
    if (isset($_SESSION['taiKhoan'])) {
        $taiKhoan = $_SESSION['taiKhoan'];
        $tblQuanTriTaiLieu->taiKhoan = $taiKhoan;
        $result = $tblQuanTriTaiLieu->layLoaiTaiLieuCuaAdmin($taiKhoan);
    }

    $maTL = $_GET['maTL'];
    $tblTaiLieu->maTL = $maTL;
    $taiLieuKiemDuyet = $tblTaiLieu->layTaiLieu();
    if (isset($_POST['dongy'])) {
        $ngayDuyetTL = date('Y-m-d H:i:s');
        if ($tblQuanTriTaiLieu->updateTailieu($maTL, $ngayDuyetTL)) {
            $tblThongBao->themTBTL($taiLieuKiemDuyet['taiKhoan'], '', 'duyettailieu', $taiLieuKiemDuyet['maLoaiTL'], $maTL);
            header("Location: ./tailieukiemduyet.php");
            exit;
        } else {
            echo 'error' . $db->error;
            exit;
        }
    }

    if (isset($_POST['xoa'])) {
        if ($tblQuanTriTaiLieu->deleteTaiLieu($maTL)) {
            header("Location: ./tailieukiemduyet.php");
        } else {
            echo 'error' . $db->error;
        }
    }
include('../inc/header.php');
include('../inc/navbar.php');
?>


<ul class="nav nav-tabs">
<?php
    if(isset($_SESSION['taiKhoan'])){
      $username = $_SESSION['taiKhoan'];
      $queryRoleBV = "SELECT * FROM `tblquantribv` WHERE maQuanTri = '$username'";
      $resultRoleBV = $db->query($queryRoleBV);
      if ($resultRoleBV) {
        if ($resultRoleBV->num_rows > 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="baivietkiemduyet.php">Bài viết kiểm duyệt</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="baivietbaocao.php">Bài viết bị báo cáo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="thaoluanbaocao.php">Thảo luận bị báo cáo</a>
            </li>
            ';
        }
       
      } 
      else {
         echo 'Lỗi truy vấn ';
      }
    }
  ?>
  <li class="nav-item ">
    <a class="nav-link active" href="#">Tài liệu kiểm duyệt</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="tailieubaocao.php">Tài liệu bị báo cáo</a>
  </li>
</ul>


<div style="min-height: 450px; border: #dee2e6 solid 1px; border-top: none; border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;">
    <div class="col-12 col-sm-12 tab-content" id="v-pills-tabContent">
        <?php
        if (isset($result) && $result !== null && $result->num_rows > 0) {
            $taiLieuKiemDuyet = $tblQuanTriTaiLieu->layThongTinTaiLieuDeKiemDuyet($maTL);
            while ($taiLieu = $taiLieuKiemDuyet->fetch_assoc()) {
                $maTL = $taiLieu['maTL'];
                $taiKhoan = $taiLieu['taiKhoan'];
                $tenLoaiTL = $taiLieu['tenLoaiTL'];
                $tenTL = $taiLieu['tenTL'];
                $moTaTL = $taiLieu['moTaTL'];
                $ngayDangTL = strtotime($taiLieu['ngayDangTL']);
                $ngayDangFormatted = date('d-m-Y H:i:s', $ngayDangTL);
                $anhTL = $taiLieu['anhTL'];
                $trangThaiTL = $taiLieu['trangThaiTL'];
                $tenDD = $taiLieu['tenDD'];
                $fileTL = $taiLieu['fileTL'];
            ?>
            <div class="col-md-12">
                    <div class="section-card">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <h1><?php echo $tenTL ?></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p>Người đăng: <?php echo $taiKhoan; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p>Ngày đăng: <?php echo $ngayDangFormatted; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p>Mô tả: <?php echo $moTaTL; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <object data="../tailieu/TaiLieuDinhDang/<?php echo $fileTL; ?>" type="application/pdf" width="100%" height="600">
                                    <p>Không thể hiển thị tệp PDF. <a href="../tailieu/TaiLieuDinhDang/<?php echo $fileTL; ?>">Tải về</a> thay vào đó.</p>
                                </object>
                            </div>
                        </div>
                        <div class="text-center mt-3 mb-3">
                            <form action="" method="POST">
                                <button type="button" class="btn btn-primary" id="duyetButton" data-bs-toggle="modal" data-bs-target="#acceptModal">Duyệt</button>
                                <button type="submit" class="btn btn-danger" id="xoaButton" name="xoa">Không duyệt</button>
                            </form>
                        </div>
                        <?php if (isset($msg)) {
                            echo "<div style='font-weight: bold; text-align: center'>" . $msg . "</div>";
                        } ?>
                    </div>
                </div>
            <?php
            }
            echo '</div>'; 
        }
        ?>
        
        <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Duyệt tài liệu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn duyệt tài liệu này không?
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="maTL" value="<?php echo $maTL; ?>">
                        <button type="submit" name="dongy" class="btn btn-success">Duyệt tài liệu</button>
                    </form>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Quay lại</button>
                </div>
                </div>
            </div>
        </div>


      </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $("#readMoreLink").click(function (e) {
            e.preventDefault(); 
            $("#fullContent").show(); 
            $("#readMoreLink").hide(); 
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php 
include('../inc/footer.php');
?>
