
<?php 
  ob_start();
  include_once '../config/Database.php';
  include_once '../class/BaiViet.php';
  include_once '../class/ThaoLuanBV.php';
  include_once '../class/TienIch.php';
  $database = new Database();
  $db = $database->getConnection();
  $tienIch = new TienIch();
  $tblBaiViet = new BaiViet($db);
  $tblThaoLuanBV = new ThaoLuanBV($db);
  if(!isset($_SESSION['hoatdong']))
  {
  header("location: ../dangnhap.php");
  }
  $taiKhoan = $_SESSION['taiKhoan'];
  include('../inc/header.php');
  include("../inc/navbar.php");
	$tblBaiViet->maBV = $_GET['maBV'];
    $baiViet = $tblBaiViet->layBaiViet();

    if(isset($_POST['bo_qua_thaoluan'])){
        $maTLBVBC = $_POST['maTLBVBC'];
        $tblThaoLuanBV->maTLBVBC = $maTLBVBC;
        if ($tblThaoLuanBV->boQuaThaoLuanBiBaoCao()) {
          header("location: thaoluanbaocao.php");
        } else {
            echo "Lỗi trong quá trình bỏ qua thảo luận: " . $db->error;
        }
    }    
    if(isset($_POST['xoa_thaoluan'])){
      $maTLBVBC = $_POST['maTLBVBC'];
      $tblThaoLuanBV->maTLBVBC = $maTLBVBC;
      if ($tblThaoLuanBV->xoaThaoLuanViPham()) {
          header("location: thaoluanbaocao.php"); 
      } else {
          echo "Lỗi trong quá trình xóa thảo luận: " . $db->error;
      }
  }
  
?>
<style>
  svg{
    display: none;
  }
  .tox-tinymce{
    margin: 5px;
  }
  
</style>
<script src="https://cdn.tiny.cloud/1/id38n7baf9sugfjkempo62ey1gfyhjofshz0lge19m8pgufs/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<div class="col-md-9">
  <div class="card">
    <h5 class="card-header" style="background-color: cadetblue;">Bài viết: <?php echo $baiViet['tenBV']?></h5>
    <div class="row g-0">
        <div class="col-md-3 card" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-top-left-radius: 0">
            <img src="../image/images.png" style="width:5em" class="card-img-top mx-auto  mt-2" alt="...">
            <div class="card-body mx-auto">
              <h5 class="card-title"><a href="#" class="text-decoration-none"><?php echo $baiViet['taiKhoan']?></a></h5>
            </div>
        </div>
      <div class="col-md-9">
        <div class="card-body">
            <table class="table">
              <tbody>
                <tr>
                  <td><?php echo $baiViet['ngayDangBV']?></td>
                </tr>
                <tr>
                    <td>
                      <blockquote class="blockquote mb-0">
                        <div id="partialContent">
                            <?php
                            $content =  $baiViet['noiDungBV'];
                            $maxLength = 500;
                            if (strlen($content) > $maxLength) {
                                $trimmedContent = substr($content, 0, $maxLength);
                                $lastSpace = strrpos($trimmedContent, ' ');
                                if ($lastSpace !== false) {
                                    echo substr($trimmedContent, 0, $lastSpace);
                                    ?>
                                    <span id="fullContent" style="display: none;"><?php echo substr($content, $lastSpace); ?></span>
                                    <a href="#" id="readMoreLink">Xem thêm</a>
                                    <?php
                                } else {
                                    echo $trimmedContent;
                                }
                            } else {
                                echo $content;
                            }
                            ?>
                        </div>
                      </blockquote>
                    </td>
                </tr>
                
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
  <?php if(!empty($_GET['maBV'])) {	   
    $tblThaoLuanBV->maBV = $_GET['maBV'];
    $tblThaoLuanBV->maTLBVBC = $_GET['maTLBVBC'];	
    $result = $tblThaoLuanBV->layThaoLuanBiBaoCao();
      while ($thaoLuanBV = $result->fetch_assoc()) {
        $date = date_create($thaoLuanBV['ngayDangTLBV']);
      ?>
      <div class="card mt-2 border-danger">
      <h5 class="card-header bg-danger">Thảo luận bị báo cáo</h5>
        <div class="row g-0">
          <div class="col-md-3 card" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
            <img src="../image/images.png" style="width:5em" class="card-img-top mx-auto  mt-2" alt="...">
            <div class="card-body mx-auto">
              <h5 class="card-title"><a href="#" class="text-decoration-none"><?php echo $thaoLuanBV['taiKhoan'] ?></a></h5>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card-body">
                <table class="table">
                  <tbody>
                    <tr  id="comment-<?php echo $thaoLuanBV['maTLBV']; ?>">
                      <td><?php echo $thaoLuanBV['ngayDangTLBV']; ?></td>
                    </tr>
                    <tr>
                      <td>
                        <?php if($thaoLuanBV['maPhanHoi'] == 0) { } else {
                          $tblThaoLuanBV->maPhanHoi = $thaoLuanBV['maPhanHoi'];				
                          $result_ = $tblThaoLuanBV->layThaoLuanPhanHoiBV();
                            while ($thaoLuanPhanHoiBV = $result_->fetch_assoc()) {
                        ?>
                        <div class="card">
                          <div class="card-header">
                            <?php echo '<a href="#comment-'.$thaoLuanBV['maPhanHoi'].'">'.$thaoLuanPhanHoiBV['taiKhoan'].'</a>' ?>: cho hay
                          </div>
                          <div class="card-body">
                            <p><?php echo $thaoLuanPhanHoiBV['noiDungTLBV']; ?></p>
                          </div>
                        </div>	
                        <?php } } ?>
                        <blockquote class="blockquote mb-0">
                          <?php echo $thaoLuanBV['noiDungTLBV']; ?>
                        </blockquote>
                      </td>
                    </tr>
                      
                    <tr style="border-style: none !important;">
                      <td style="border-style: none !important;">
                        <button type="button" class="text-decoration-none btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa thảo luận</button>
                        <a  class="text-decoration-none btn btn-primary" href="javascript:window.history.back(-1);">Quay lại</a>
                        <button type="button" class="text-decoration-none btn btn-success" style="float:right;" data-bs-toggle="modal" data-bs-target="#skipModal">Bỏ qua thảo luận</button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
            
          </div>
          
        </div>
      </div>
      

    <?php } ?>	  
  <?php } ?>
  
</div>
<div class="col-md-3 card">
  <div class="form-control mt-2 mb-2 bg-danger text-light " style="text-align: center">Người dùng báo cáo</div>
<?php
  $result = $tblThaoLuanBV->layNguoiDungBaoCao();
  if ($result) {
    if ($result->num_rows > 0) {
      while ($rowNguoiDungBaoCao = $result->fetch_assoc()) { ?>
        
          <div class="row p-2">
              <div class="col-3 ">
                <img src="../image/images.png" style="width:90%" class="" alt="...">
              </div>
              <div class=" col-9">
                <h5 class=""><a href="" class="text-decoration-none"><?php echo $rowNguoiDungBaoCao['taiKhoan']?></a></h5>
                <!-- <h6 class="text-body-secondary">Quyền người dùng</h6> -->
                <?php
                        $baoCaoArr = explode(',', $rowNguoiDungBaoCao['danhSachLoaiVP']);
                        foreach ($baoCaoArr as $baoCao) {
                            echo '<p class="">' . $baoCao . '</p>';
                        }
                    ?>
              </div>
          </div>
        
      <?php }
    } else {
      echo 'Chưa có báo cáo nào cho bài viết này.';
    }
  } else {
    echo 'Lỗi trong quá trình truy vấn cơ sở dữ liệu: ' . $db->error;
  }
?>
</div>


<!-- Modal xóa thảo luận bị báo cáo -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa thảo luận</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn xóa thảo luận này?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Quay lại</button>
        <form  method="post">
          <input type="hidden" name="maTLBVBC" value="<?php echo  $_GET['maTLBVBC']; ?>">
          <button type="submit" name="xoa_thaoluan" class="btn btn-danger">Xóa thảo luận</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal bỏ qua thảo luận bị báo cáo -->
<div class="modal fade" id="skipModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Bỏ qua thảo luận</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn bỏ qua thảo luận này?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Quay lại</button>
        <form method="post">
          <input type="hidden" name="maTLBVBC" value="<?php echo  $_GET['maTLBVBC']; ?>">
          <button type="submit" name="bo_qua_thaoluan" class="btn btn-success">Bỏ qua thảo luận</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var replyButton = document.querySelector("[name='reply']");
        var guithaoluanForm = document.querySelector("#guithaoluan");

        replyButton.addEventListener("click", function (e) {
            e.preventDefault(); 
            guithaoluanForm.scrollIntoView({ behavior: "smooth" });
        });
    });
</script>

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

<?php include("../inc/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
