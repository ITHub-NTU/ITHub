<?php
include_once '../config/Database.php';
include_once '../class/ChuDeBV.php';
include_once '../class/BaiViet.php';
include_once '../class/TienIch.php';

$database = new Database();
$db = $database->getConnection();

$tblChuDeBV = new ChuDeBV($db);
$tienIch = new TienIch();
$tblBaiViet = new BaiViet($db);
include('../inc/header.php');
include('../inc/navbar.php');
?>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link " aria-current="page" href="baivietkiemduyet.php">Bài viết kiểm duyệt</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="#">Bài viết bị báo cáo</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="thaoluanbaocao.php">Thảo luận bị báo cáo</a>
  </li>
  <?php 
    if(isset($_SESSION['taiKhoan'])){
      $username = $_SESSION['taiKhoan'];
      $queryRoleTL = "SELECT maQuanTri FROM `tblquantritl` WHERE maQuanTri = '$username'";
      $resultRoleTL = $db->query($queryRoleTL);
      if ($resultRoleTL) {
        if ($resultRoleTL->num_rows > 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link" href="tailieukiemduyet.php">Tài liệu kiểm duyệt</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tailieubaocao.php">Tài liệu bị báo cáo</a>
            </li>
            ';
        }
      }
      else {
         echo 'Lỗi truy vấn ';
      }
    }
  ?>
</ul>
<div class="row" style=" border: #dee2e6 solid 1px; border-top: none; border-bottom-left-radius: 10px; padding-top: 10px;padding-bottom: 10px;
    border-bottom-right-radius: 10px; margin: 0">
  <div class="col-md-9" style="margin-bottom: -10px">
    <?php 
      $tblChuDeBV->maQuanTri = $username;
      $resultCD =  $tblChuDeBV->layDSChuDeBVQT();
      while($danhSachKiemDuyet = $resultCD->fetch_assoc()){
        $maCD = $danhSachKiemDuyet['maCD'];
        $tblBaiViet->maCDKD = $maCD;
    ?>
    <div class="card" style="margin-left: -10px; margin-bottom: 10px">
    <h5 class="card-header" style="background-color:cadetblue;"><?php echo $danhSachKiemDuyet['tenCD']?></h5>
        <?php
          $resultMaBVVaSoLuong = $tblBaiViet->layMaBVVaSoLuong();
          while($danhSachMaBV = $resultMaBVVaSoLuong->fetch_assoc()){
            $tblBaiViet->maBVBC = $danhSachMaBV['maBV'];
            $resultBaiViet = $tblBaiViet->layThongTinBaiVietBiBaoCao();
            $baiVietBiBaoCao = $resultBaiViet->fetch_assoc();
            if(!empty($baiVietBiBaoCao['ngayDangBV'])) {
              $timestamp = strtotime($baiVietBiBaoCao['ngayDangBV']);
            }else {
              $timestamp = NULL;
            }
        ?>
        <div class="row">
          <div class="col-md-10 my-auto text-center">
            <div class="row my-auto " style="text-align:left;">
              <div class="col-md-1 my-auto">
                <img src="../image/images.png" class="rounded m-3 d-block" style="width:4em" alt="...">
              </div>
              <div class="col-md-6 my-auto" >
                <div class="row"  style="margin-left: 20px;">
                  <a class="text-decoration-none" href="" title="">
                    <?php
                      $tenBV = $baiVietBiBaoCao['tenBV'];
                      $maxTitleLength = 2 * 50;
                      if (strlen($tenBV) > $maxTitleLength) {
                        $tenBV = substr($tenBV, 0, $maxTitleLength) . '...';
                      }
                      echo $tenBV;
                    ?>
                  </a>
                  <label>
                    <?php echo $tienIch->formatTimeAgo($timestamp) ?> 
                    <a href=""><?php echo $baiVietBiBaoCao['taiKhoan']?></a>
                  </label>
                  <span style="font-size: 15px; color: red">Có <?php echo $danhSachMaBV['soLuong']?> lượt báo cáo</span>
                </div>
              </div>
              <div class="col-md-5 my-auto">
              <?php
                $noiDungBV = $baiVietBiBaoCao['noiDungBV'];
                $lengthND = 2 * 75;
                if (strlen($noiDungBV) > $lengthND) {
                  $noiDungBV = substr($noiDungBV, 0, $lengthND) . '...';
                }
                echo $noiDungBV;
              ?>
              </div>
            </div>
          </div>
          <div class="col-md-2 my-auto">
          
            <a href="chitietbaivietbibaocao.php?maBV=<?php echo $baiVietBiBaoCao['maBV'].'&taiKhoan='.$baiVietBiBaoCao['taiKhoan']?>"><div class="btn btn-success">Kiểm duyệt</div></a>
            
          </div>
        </div>
        <?php } if ($resultMaBVVaSoLuong->num_rows == 0)
       echo '<div style="padding: 10px; font-size: 20px; height:4em; line-height: 2.5em">
          Chưa có bài viết bị báo cáo
        </div>'?>
      </div>
    <?php } 
      
    ?>
    </div>
    <div class="card col-md-3">
    <?php 
      $resultDSCD =  $tblChuDeBV->layDSChuDeBVQT();
      while($danhSachCD = $resultDSCD->fetch_assoc()){
    ?>
      <a href="../diendan/danhsachbaiviet.php?maCD=<?php echo $danhSachCD['maCD']?>" class="text-decoration-none">
        <div class="row p-3">
          <img src="../image/images.png" alt="" class="col-md-5" style="width: 40%">
          <h5 style="line-height: 4;margin-bottom: 0px;" class="col-md-7" ><?php echo $danhSachCD['tenCD']?></h5>
        </div>
      </a>
  <?php }?>
  </div>
</div>
<?php 
include('../inc/footer.php');
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
