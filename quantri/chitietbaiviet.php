<?php
ob_start();
include_once '../config/Database.php';
include_once '../class/ChuDeBV.php';
include_once '../class/BaiViet.php';
//----------------------------------------
include_once '../class/TienIch.php';
$database = new Database();
$db = $database->getConnection();
$tblChuDeBV = new ChuDeBV($db);
$tienIch = new TienIch();
$tblBaiViet = new BaiViet($db);
//----------------------------------------
if(!isset($_SESSION['hoatdong']))
{
header("location: ../dangnhap.php");
}
$taiKhoan = $_SESSION['taiKhoan'];
include('../inc/header.php');
include("../inc/navbar.php");
?>
<?php 
	$tblBaiViet->maBV = $_GET['maBV'];
  
  $maBV = $_GET['maBV'];
  $baiViet = $tblBaiViet->layBaiViet();
  $tblBaiViet->trangThaiBV = $baiViet['trangThaiBV'];
  if(isset($_POST['duyet_baiviet'])){
      //----------------------------------------
    
      if ($tblBaiViet->duyetBaiViet()) {
          header('Location: ../quantri/baivietkiemduyet.php');
      } else {
          echo "Lỗi trong quá trình duyệt bài viết: " . $db->error;
      }
  }    
  if(isset($_POST['xoa_baiviet'])){
    if ($tblBaiViet->xoaBaiViet()) {
        header("Location: baivietkiemduyet.php"); 
    } else {
        echo "Lỗi trong quá trình xóa bài viết: " . $db->error;
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
    <h5 class="card-header"><?php echo $baiViet['tenBV']?></h5>
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
                  <td class="d-flex"><?php echo 
                    $tienIch->formatTimeAgo(strtotime($baiViet['ngayDangBV']));
                            if($baiViet['trangThaiBV'] =='chinhsua'){
                              echo ' <div style="padding: 3px 6px; margin: 0 5px; border-radius: 4px; background-color: gray; width: fit-content; color: white">Chỉnh sửa</div>';
                            }
                      ; ?></td>
                </tr>
                <tr>
                    <td>
                      <blockquote class="blockquote mb-0">
                        <div id="partialContent">
                            <?php
                            $content =  $baiViet['noiDungBV'];
                            $maxLength = 1000;
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
                <tr style="border-style: none !important;">
                  <td style="border-style: none !important;">
                    <button type="button"  class="text-decoration-none btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa bài viết</button>
                    <button type="button" class="text-decoration-none btn btn-success" style="float:right;" data-bs-toggle="modal" data-bs-target="#acceptModal">Duyệt bài viết</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>

<!-- Modal xóa bài viết bị kiểm duyệt -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa bài viết</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn xóa bài viết này?
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Quay lại</button>
        <form  method="post">
          <input type="hidden" name="maBV" value="<?php echo $maBV; ?>">
          <button type="submit" name="xoa_baiviet" class="btn btn-danger">Xóa bài viết</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal duyệt bài viết -->
<div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Duyệt bài viết</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn duyệt bài viết này?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Quay lại</button>
        <form method="post">
          <input type="hidden" name="maBV" value="<?php echo $maBV; ?>">
          <button type="submit" name="duyet_baiviet" class="btn btn-success">Duyệt bài viết</button>
        </form>
      </div>
    </div>
  </div>
</div>
  
</div>

<div class="card col-md-3">
    <?php 
      $tblChuDeBV->maQuanTri = $taiKhoan;
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
