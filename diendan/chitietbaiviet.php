<?php
include_once '../config/Database.php';
include_once '../class/BaiViet.php';
include_once '../class/ThaoLuanBV.php';
include_once '../class/TienIch.php';
include_once '../class/ThongBao.php'; //
include_once '../class/NguoiDung.php'; 

$database = new Database();
$db = $database->getConnection();
$tienIch = new TienIch();
$tblBaiViet = new BaiViet($db);
$tblThaoLuanBV = new ThaoLuanBV($db);
$tblThongBao = new ThongBao($db); //
$tblNguoiDung = new NguoiDung($db);
if(!isset($_SESSION['hoatdong']))
{
header("location: ../nguoidung/dangnhap.php");
}
$taiKhoan = $_SESSION['taiKhoan'];
$userinfo = $tblNguoiDung->getUserInfoByTaiKhoan($taiKhoan);
include('../inc/header.php');
?>
<?php include("../inc/navbar.php");
	$tblBaiViet->maBV = $_GET['maBV'];
  
  $tblBaiViet->taiKhoan = $taiKhoan;
  $maBV = $_GET['maBV'];
  
  if (isset($_SESSION['visited_' . $tblBaiViet->maBV = $_GET['maBV']])) {
  } else {
    $tblBaiViet->themLuotXem();
    $_SESSION['visited_' . $tblBaiViet->maBV = $_GET['maBV']] = true;
  }
  if(isset($GLOBALS['maTLBV_reply']))
    $maTLBV_reply = $GLOBALS['maTLBV_reply'];
	$chiTietBaiViet = $tblBaiViet->layBaiViet();

  if (isset($_POST['reply'])) {
    $GLOBALS['checkPhanHoi'] = 1;
    $maTLBV_reply = $_POST['maTLBV_reply'];
    $GLOBALS['maTLBV_reply'] = $maTLBV_reply;
    $query_reply = "SELECT * FROM `tblthaoluanbv` WHERE maTLBV = ?";
    $stmt = $db->prepare($query_reply);
    $stmt->bind_param('s', $maTLBV_reply);
    $stmt->execute();
    $result_reply = $stmt->get_result();
    if ($result_reply->num_rows > 0) {
        // Lấy dữ liệu từ bản ghi duy nhất
        $row_reply = $result_reply->fetch_assoc();
        $noiDungReply = $row_reply['noiDungTLBV'];
        $taiKhoanReply = $row_reply['taiKhoan'];
        $_SESSION['taiKhoanDuocPhanHoi'] = $taiKhoanReply;
    }
  }
  if(isset($_SESSION['taiKhoanDuocPhanHoi'])) {
    $taiKhoanDuocPhanHoi = $_SESSION['taiKhoanDuocPhanHoi'];
  }
  
// Them thao luan
if (isset($_POST['thaoluan'])) {
  $noiDungTLBV = $_POST['noiDungTLBV'];
  if(isset($_POST['maTLBV_reply'])) {
    $maPhanHoi = $_POST['maTLBV_reply'];
  } else {
    $maPhanHoi = '0';
  }

  if($maPhanHoi == '0') {
    $loaiTB = 'binhluan';
  } else {
    $loaiTB = 'phanhoi';
  }

  
  $maTLBV = $tienIch->autoIncrement('tblthaoluanbv', 'maTLBV', 'TL00000001');
  $query = "INSERT INTO tblthaoluanbv (maTLBV, maBV, maPhanHoi, taiKhoan, noiDungTLBV, trangThaiTLBV) VALUES (?, ?, ?, ?, ?, 'dadang')";
  $stmt = $db->prepare($query);
  $stmt->bind_param('sssss', $maTLBV, $maBV, $maPhanHoi , $taiKhoan, $noiDungTLBV);
  
  if ($stmt->execute()) {
    $tblThongBao->themTBPhanHoiBV($chiTietBaiViet['taiKhoan'], $taiKhoan, $loaiTB, $chiTietBaiViet['maCD'], $maBV, $maTLBV, $taiKhoanDuocPhanHoi);
  }else {
    echo "Lỗi khi thêm thảo luận: " . $stmt->error;
  }
  $stmt->close();
}
  
  $bookmark = $tblBaiViet->getBookmarkTaiKhoan();

  if(isset($_GET['save_bookmark'])){
    $tblBaiViet->maBVBK = $_GET['maBV'];
    $tblBaiViet->changeBookmark($bookmark);
    $bookmark = $tblBaiViet->getBookmarkTaiKhoan();
  }
  if(isset($_POST['chinhSuaBaiViet'])){
    $tenBV = $_POST['tenBV'];
    $noiDungBV = $_POST['noiDungBV'];
    $tblBaiViet->chinhSuaBaiViet($tenBV, $noiDungBV);
    header("Location: ./chudebaiviet.php");
  }
  if(isset($_POST['xoaBaiViet'])){
    if(isset($_POST['maBV'])){
      $maBV = $_POST['maBV'];
      $tblBaiViet->maBV = $maBV;
      $tblBaiViet->xoaBaiViet();
      header("Location: ./chudebaiviet.php");
    }
    else{
      header('Location: 404notfound.php');
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
  .bookmark{
    border: none; 
    background-color: white;
  }
  .bookmark:hover{
    color: #ffc107;
  }
</style>
<script src="https://cdn.tiny.cloud/1/id38n7baf9sugfjkempo62ey1gfyhjofshz0lge19m8pgufs/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.withCredentials = false;
      xhr.open('POST', 'upload-img.php');
      
      xhr.upload.onprogress = (e) => {
          progress(e.loaded / e.total * 100);
      };
      
      xhr.onload = () => {
          if (xhr.status === 403) {
              reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
              return;
          }
        
          if (xhr.status < 200 || xhr.status >= 300) {
              reject('HTTP Error: ' + xhr.status);
              return;
          }
        
          const json = JSON.parse(xhr.responseText);
        
          if (!json || typeof json.location != 'string') {
              reject('Invalid JSON: ' + xhr.responseText);
              return;
          }
        
          resolve(json.location);
      };
      
      xhr.onerror = () => {
        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
      };
      
      const formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());
      
      xhr.send(formData);
  });

    tinymce.init({
    selector: 'textarea',
    plugins: 'image table | lists |image | table | bullist numlist |  textcolor code | autoresize',
    toolbar: 'undo redo | bold italic fontsize | image | table | bullist numlist | forecolor backcolor  | link',
    menubar: "insert  format table ",
    images_upload_url: 'upload-img.php',
    images_upload_handler: image_upload_handler_callback,
    automatic_uploads: true,
    images_upload_credentials: true,
    apiKey: 'id38n7baf9sugfjkempo62ey1gfyhjofshz0lge19m8pgufs',
    setup: function (editor) {
    editor.on('dialogopen', function (e) {
      if (e.dialog.dialogRef.name === 'image') {
        e.dialog.dialogRef.find('media').active(true);
        }
        });
    }
});

</script>
<div class="col-md-9">
  <div class="card">
    <h5 class="card-header"><?php echo $chiTietBaiViet['tenBV']; ?></h5>
    <div class="row g-0">
        <div class="col-md-3 card" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-top-left-radius: 0">
            <img src="../image/<?php if(isset( $chiTietBaiViet['anhDaiDien'])) echo $chiTietBaiViet['anhDaiDien'];  ?>" style="width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;" class="card-img-top mx-auto  mt-2" alt="...">
            <div class="card-body mx-auto">
              <h5 style="text-align: center;" class="card-title"><a href="#" class="text-decoration-none "><?php if(isset( $chiTietBaiViet['taiKhoan'])) echo $chiTietBaiViet['taiKhoan']; ?></a></h5>
              <?php if(isset( $chiTietBaiViet['quyen'])) {
                if($chiTietBaiViet['quyen']=='quantrivien')
                  echo '
                  <span style="background-color: green; color:white;  border-radius: 5px; padding:2px 4px">
                    Quản trị viên
                  </span>
                  ';
                else
                  echo '
                    <span style="background-color: gray; color:white;  border-radius: 5px; padding:2px 4px">
                      Người dùng
                    </span>
                    ';
                }
                  ?>
            </div>
        </div>
      <div class="col-md-9">
        <div class="card-body">
            <table class="table">
              <tbody>
                <tr>
                  <td class="row">
                    <div class="col-9 d-flex">
                      <?php echo 
                            $tienIch->formatTimeAgo(strtotime($chiTietBaiViet['ngayDuyetBV']));
                            if($chiTietBaiViet['trangThaiBV'] =='dachinhsua'){
                              echo ' <div style="padding: 3px 6px; margin: 0 5px; border-radius: 4px; background-color: gray; width: fit-content; color: white">Đã chỉnh sửa</div>';
                            }
                      ; ?>
                      
                    </div> 
                    
                    <div  class="col-1  <?php if(!$tblBaiViet->kiemTraQuyenChinhSua()){ echo 'offset-2';}  ?>">
                      <form method="get">
                        <input type="text" name="maBV" value="<?php echo $maBV?>" hidden>
                        <button type="submit" name="save_bookmark" class="bookmark" value="<?php echo $bookmark?>">
                          <?php 
                            if($bookmark)
                              echo '<i class="fa fa-bookmark " style="cursor: pointer;"></i>';
                            else  
                              echo '<i class="far fa-bookmark " style="cursor: pointer;"></i>';
                          ?>
                          
                        </button>
                      </form>
                    </div>
                    <?php 
                      if($tblBaiViet->kiemTraQuyenChinhSua()){
                        echo '
                        <div class="col-1">
                          <button  name="edit" class="bookmark"  data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="fa fa-pen " style="cursor: pointer;"></i>
                          </button>
                        </div>
                        <div class="col-1">
                          <button  name="remove" class="bookmark"  data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fa fa-trash " style="cursor: pointer;"></i>
                          </button>
                        </div>';
                      }
                    ?>
                    <!--Start Modal Edit -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog" style="max-width: 800px; width: 80%; /">
                        <form action="" method="post">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Chỉnh sửa bài viết</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="d-flex  ">
                              <div >
                              <img src="../image/<?php if(isset( $chiTietBaiViet['anhDaiDien'])) echo $chiTietBaiViet['anhDaiDien']; ?>" style="width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;" alt="" class="" >
                              </div>
                              <div style="padding: 15px;">
                                <h5 class="card-title"><a href="#" class="text-decoration-none"><?php if(isset( $chiTietBaiViet['taiKhoan'])) echo $chiTietBaiViet['taiKhoan']; ?></a></h5>
                                <span style="padding: 2px 4px!important;background-color: green; color:white;  border-radius: 5px">
                                 <?php if(isset( $chiTietBaiViet['quyen'])) {
                                  if($chiTietBaiViet['quyen']=='quantrivien')
                                    echo '
                                    <span style="background-color: green; color:white;  border-radius: 5px">
                                      Quản trị viên
                                    </span>
                                    ';
                                  else
                                    echo '
                                      <span style="background-color: gray; color:white;  border-radius: 5px">
                                        Người dùng
                                      </span>
                                      ';
                                 }
                                   ?>
                                </span>
                                <div> 
                                 <?php if(isset( $chiTietBaiViet['ngayDangBV'])) echo $chiTietBaiViet['ngayDangBV']; ?>
                                </div>
                              </div>
                            </div>
                            <div>
                              <div style="padding: 5px">
                              <input class="form-control form-control-lg" type="text" name="tenBV" value="<?php if(isset( $chiTietBaiViet['tenBV'])) echo $chiTietBaiViet['tenBV']; ?>" id="">
                              </div>
                              <textarea name="noiDungBV" id="editor"><?php if(isset( $chiTietBaiViet['noiDungBV'])) echo $chiTietBaiViet['noiDungBV']; ?></textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ chỉnh sửa</button>
                            <button type="submit" class="btn btn-success" name="chinhSuaBaiViet">Lưu chỉnh sửa</button>
                          </div>
                        </div>
                        </form>
                      </div>
                    </div>
                    <!--End Modal Edit-->
                    <!--Start Modal delete -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <form action="" method="post">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Xóa bài viết</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            
                            <div class="h5">Bạn có chắc chắn muốn xóa bài viết này?</div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                            <form action="" method="post">
                              <input name="maBV" type="text" hidden value="<?php echo $chiTietBaiViet['maBV']?>">
                              <button type="submit" class="btn btn-danger" name="xoaBaiViet">Xóa bài viết</button>
                            </form>
                          </div>
                        </div>
                        </form>
                      </div>
                    </div>
                    <!--End Modal delete-->
                  </td>
                </tr>
                <tr>
                    <td>
                      <blockquote class="blockquote mb-0">
                        <div id="partialContent">
                            <?php
                            $content = $chiTietBaiViet['noiDungBV'];
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
                    <!-- <a href="baocaobaiviet.php?maBV=<?php echo $maBV.'&taiKhoan='.$taiKhoan.'&maLoaiVP='.$maLoaiVP?>" class="text-decoration-none btn btn-danger">Báo cáo</a> -->
                    <span>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                          Báo cáo
                        </button>
                       <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Báo cáo bài viết vi phạm</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="padding-bottom: -10px;">
                            <?php 
                                $conn = $database->getConnection();
                                $query = "SELECT * FROM tblloaivipham";
                                $result = $conn->query($query);
                                
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<a style="text-decoration: none; margin-bottom: 10px" href="baocaobaiviet.php?maLoaiVP='.$row['maLoaiVP'].'&maBV='.$maBV.'&taiKhoan='.$taiKhoan.'" class="form-control">'.$row['tenLoaiVP'].'</a>';
                                        
                                    }
                                } else {
                                    echo "Không tìm thấy lỗi vi phạm.";
                                }
                                $conn->close();
                            ?>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </span>
                    <span style="float:right;"><a href="#guithaoluan" class="text-decoration-none btn btn-warning">Bình luận</a></span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
      </div>
      
    </div>
    
  </div>
  <?php  
if (isset($_GET['msg'])) {
    $msg = "";
    if ($_GET['msg'] == 1) {
        $msg = "Đã báo cáo bài viết cho quản trị viên";
    } elseif ($_GET['msg'] == 0) {
        $msg = "Báo cáo bài viết không thành công";
    }
    if (!empty($msg)) {
        echo '
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#messageModal" style="display: none;">
              Launch modal
            </button>
            <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Báo cáo bài viết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>' . $msg . '</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                  </div>
                </div>
              </div>
            </div>
            <script>
                var messageModal = new bootstrap.Modal(document.getElementById("messageModal"));
                messageModal.show();
            </script>
        ';
    }
}
if (isset($_GET['msgtl'])) {
  $msgtl = "";
  if ($_GET['msgtl'] == 1) {
      $msgtl = "Đã báo cáo thảo luận vi phạm cho quản trị viên";
  } elseif ($_GET['msgtl'] == 0) {
      $msgtl = "Báo cáo thảo luận vi phạm không thành công";
  }
  if (!empty($msgtl)) {
      echo '
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#messageModal" style="display: none;">
            Launch modal
          </button>
          <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Báo cáo thảo luận vi phạm</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>' . $msgtl . '</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
              </div>
            </div>
          </div>
          <script>
              var messageModal = new bootstrap.Modal(document.getElementById("messageModal"));
              messageModal.show();
          </script>
      ';
  }
}
?>
  <?php if(!empty($_GET['maBV'])) {	   
    $tblThaoLuanBV->maBV = $_GET['maBV'];				
    $result = $tblThaoLuanBV->layDanhSachThaoLuanBV();
      while ($thaoLuanBV = $result->fetch_assoc()) {
        $date = date_create($thaoLuanBV['ngayDangTLBV']);
      ?>
      <div class="card mt-2">
        <div class="row g-0">
          <div class="col-md-3 card" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
            <img src="../image/<?php echo $thaoLuanBV['anhDaiDien'] ?>" style="width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;" class="card-img-top mx-auto  mt-2" alt="...">
            <div class="card-body mx-auto">
              <h5  style="text-align: center;" class="card-title"><a href="#" class="text-decoration-none"><?php echo $thaoLuanBV['taiKhoan'] ?></a></h5>
              <?php if(isset( $thaoLuanBV['quyen'])) {
                if($thaoLuanBV['quyen']=='quantrivien')
                  echo '
                  <span style="background-color: green; color:white;  border-radius: 5px; padding:2px 4px">
                    Quản trị viên
                  </span>
                  ';
                else
                  echo '
                    <span style="background-color: gray; color:white;  border-radius: 5px; padding:2px 4px">
                      Người dùng
                    </span>
                    ';
                }
              ?>
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
                      <td style="border-style: none !important; display: flex;">
                        <span>                          
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#<?php echo $thaoLuanBV['maTLBV']?>">Báo cáo</button>
                            <!-- start modal bao cao thao luan bai viet  -->
                            <div class="modal fade" id="<?php echo $thaoLuanBV['maTLBV']?>" tabindex="-1" aria-labelledby="<?php echo $thaoLuanBV['maTLBV']?>Label" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="<?php echo $thaoLuanBV['maTLBV']?>Label">Báo cáo thảo luận vi phạm</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body" style="padding-bottom: -10px;">
                                  <?php  
                                    $query_BaoCaoThaoLuan = "SELECT * FROM tblloaivipham";
                                    $result_BaoCaoThaoLuan = $db->query($query);
                                    if ($result_BaoCaoThaoLuan->num_rows > 0) {
                                      while ($rowBaoCaoThaoLuan = $result_BaoCaoThaoLuan->fetch_assoc()) {
                                          echo '<a style="text-decoration: none; margin-bottom: 10px" href="baocaothaoluan.php?maLoaiVP='.$rowBaoCaoThaoLuan['maLoaiVP'].'&maTLBV='.$thaoLuanBV['maTLBV'].'&taiKhoan='.$taiKhoan.'&maBV='.$maBV.'" class="form-control">'.$rowBaoCaoThaoLuan['tenLoaiVP'].'</a>';
                                      }
                                    } else {
                                        echo "Không tìm thấy lỗi vi phạm.";
                                    }
                                    
                                  ?>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- end modal bao cao thao luan bai viet  -->
                        </span>
                        
                        <form  style=" justify-content: right; margin-left: auto" method="post">
                          <input type="text" name="maTLBV_reply" style="display: none;" 
                          value="<?php echo $thaoLuanBV['maTLBV']?>" >
                          <span style="float:right;">
                            <a href="#phanhoibaiviet" class="text-decoration-none"><button class=" btn btn-warning" type="submit" name="reply">Phản hồi</button></a>
                          </span>
                        </form>
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

    <div class="card mt-2">
      <div class="row g-0">
          <div class="col-md-3 card" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-top-left-radius: 0">
              <img src="../image/<?php if(isset($userinfo['anhDaiDien']))echo $userinfo['anhDaiDien']; ?>" style="width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;" class="card-img-top mx-auto  mt-2" alt="...">
              <div class="card-body mx-auto">
                <h5 style="text-align: center;" class="card-title"><a href="#" class="text-decoration-none"><?php if(isset($userinfo['taiKhoan']))echo $userinfo['taiKhoan']; ?></a></h5>
                <?php if(isset( $userinfo['quyen'])) {
                if($userinfo['quyen']=='quantrivien')
                  echo '
                  <span style="background-color: green; color:white;  border-radius: 5px; padding:2px 4px">
                    Quản trị viên
                  </span>
                  ';
                else
                  echo '
                    <span style="background-color: gray; color:white;  border-radius: 5px; padding:2px 4px">
                      Người dùng
                    </span>
                    ';
                }
                  ?>                     
              </div>
          </div>
        <div class="col-md-9">
          <!-- Start Phan hoi  -->
          <div  id="phanhoibaiviet" class="card m-2" style="display: <?php if(!isset($maTLBV_reply)) echo "none" ?>;">
            <div class="card-header d-flex">
               Phản hồi  
              <a style="margin-left: 3px;" href=""><?php if(isset($taiKhoanReply))
                echo $taiKhoanReply;?></a>:
              <form method="post">
                <button name="close" style="border: none;" > <i class="fa fa-close "></i></button>
              </form>
            </div>
            <div class="card-body">
              <p><?php if(isset($noiDungReply)) echo $noiDungReply?></p>
            </div>
          </div>	
          <!-- End phan hoi -->
          <form method="post" id="guithaoluan">
            <textarea name="noiDungTLBV" id="editor"></textarea>
            <input style="display: none;" type="text" name="maTLBV_reply"
             value="<?php if(isset($maTLBV_reply)) echo $maTLBV_reply; else echo "0";?>" >
            <div class="d-flex justify-content-end m-2">
            <input name="thaoluan" type="submit"  class="btn btn-warning ml-auto" value="Gửi thảo luận"></input>
          </form>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="card col-md-3">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include("../inc/footer.php"); ?>
