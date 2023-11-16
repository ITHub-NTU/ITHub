<?php
include_once '../config/Database.php';
include_once '../class/ChuDeBV.php';
include_once '../class/BaiViet.php';
include_once '../class/TienIch.php';
include_once '../class/QuanTriTaiLieu.php';

$database = new Database();
$db = $database->getConnection();

$tblChuDeBV = new ChuDeBV($db);
$tblTienIch = new TienIch();
$tblBaiViet = new BaiViet($db);
$tblQuanTriTaiLieu = new QuanTriTaiLieu($db);

if (isset($_SESSION['taiKhoan'])) {
  $taiKhoan = $_SESSION['taiKhoan'];
  $result = $tblQuanTriTaiLieu->layLoaiTaiLieuCuaAdmin($taiKhoan);
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

<div class="row" style=" border: #dee2e6 solid 1px; border-top: none; border-bottom-left-radius: 10px; padding-top: 10px;padding-bottom: 10px;
    border-bottom-right-radius: 10px; margin: 0">
  <div class="col-md-9" style="margin-bottom: -10px">
    <?php 
      if (isset($_SESSION['taiKhoan'])) {
        $taiKhoan = $_SESSION['taiKhoan'];
        $result1 = $tblQuanTriTaiLieu->layLoaiTaiLieuCuaAdmin($taiKhoan);
      }
      while($danhSachKiemDuyet = $result1->fetch_assoc()){
        $thongTinTaiLieu = $tblQuanTriTaiLieu->layThongTinTaiLieuTheoMaLoaiTL($danhSachKiemDuyet['maLoaiTL']);


    ?>
    <div class="card" style="margin-left: -10px; margin-bottom: 10px">
    <h5 class="card-header" style="background-color:cadetblue;"><?php echo $danhSachKiemDuyet['tenLoaiTL']?></h5>
        <?php
          while ($taiLieu = $thongTinTaiLieu->fetch_assoc()) {
            $foundDocuments = true;
            $maTL = $taiLieu['maTL'];
            $taiKhoan = $taiLieu['taiKhoan'];
            $tenLoaiTL = $taiLieu['tenLoaiTL'];
            $tenTL = $taiLieu['tenTL'];
            $moTaTL = $taiLieu['moTaTL'];
            $ngayDangFormatte = strtotime($taiLieu['ngayDangTL']);
            $ngayDangTL = $tblTienIch->formatTimeAgo($ngayDangFormatte);
            $anhTL = $taiLieu['anhTL'];
            $tenDD = $taiLieu['tenDD'];
        ?>
        <div class="row">
            <div class="col-md-10 pt-4">
                <a class="text-decoration-none text-black" href="../quantri/kiemduyet.php?maTL=<?php echo $maTL; ?>" title="<?php echo $tenTL; ?>">         
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="../image/<?php echo $anhTL; ?>" style="height: 100%" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-black h3 text-center"><?php echo $tenTL; ?></h5>
                                    <p class="card-text"><?php echo $moTaTL; ?></p>
                                    <p class="card-text">
                                        <i class="fas fa-user"></i> Người đăng: <?php echo $taiKhoan; ?>
                                    </p>
                                    <p class="card-text">
                                        <i class="fas fa-calendar"></i> Ngày đăng: <?php echo $ngayDangTL; ?>
                                    </p>
                                    <p class="card-text">
                                        <i class="fas fa-folder"></i> Loại tài liệu: <?php echo $tenLoaiTL; ?>
                                    </p>
                                    <p class="card-text">
                                        <i class="fas fa-file"></i> Định dạng: <?php echo $tenDD; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
          <div class="col-md-2 my-auto">
          
            <a href="kiemduyet.php?maTL=<?php echo $maTL?>"><div class="btn btn-success">Kiểm duyệt</div></a>
            
          </div>
        </div>
        <?php } if ($thongTinTaiLieu->num_rows == 0)
       echo '<div style="padding: 10px; font-size: 20px; height:4em; line-height: 2.5em">
          Chưa có tài liệu nào cần duyệt
        </div>'?>
      </div>
    <?php } 
      
    ?>
    </div>
    <div class="card col-md-3">
    <?php 
      $resultDSTL =  $tblQuanTriTaiLieu->layDSChuDeTLQT($taiKhoan);
      while($danhSachTL = $resultDSTL->fetch_assoc()){
    ?>
      <a href="../tailieu/danhsachtailieu.php?maLoaiTL=<?php echo $danhSachTL['maLoaiTL']?>" class="text-decoration-none">
        <div class="row p-3">
          <img src="../image/images.png" alt="" class="col-md-5" style="width: 40%">
          <h5 style="line-height: 4;margin-bottom: 0px; white-space: nowrap" class="col-md-7 d-flex" ><?php echo $danhSachTL['tenLoaiTL']?></h5>
        </div>
      </a>
  <?php }?>
  </div>
</div>

<?php 
include('../inc/footer.php');
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>