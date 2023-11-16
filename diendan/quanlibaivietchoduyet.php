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

include('../inc/header.php');
include("../inc/navbar.php");
if(!isset($_SESSION['taiKhoan']))
    header('Location: ../nguoidung/dangnhap.php');
$taiKhoan = $_SESSION['taiKhoan'];
if(isset($_GET['maCDBV']))
    $maCD = $_GET['maCDBV'];
else    
    header('Location: chudebaiviet.php');

$tblBaiViet->taiKhoan = $taiKhoan;
$tblBaiViet->maCD = $maCD;
//Chỉnh sửa bài viết
if(isset($_POST['chinhSuaBaiViet'])){
    $tenBV = $_POST['tenBV'];
    $noiDungBV = $_POST['noiDungBV'];
    $tblBaiViet->maBV = $_POST['maBV'];
    $tblBaiViet->chinhSuaBaiViet($tenBV, $noiDungBV);
    header("Location: ./quanlibaivietchoduyet.php?maCDBV=".$maCD);
  }
if(isset($_POST['xoaBaiViet'])){
if(isset($_POST['maBV'])){
    $maBV = $_POST['maBV'];
    $tblBaiViet->maBV = $maBV;
    $tblBaiViet->xoaBaiViet();
    header("Location: ./quanlibaivietchoduyet.php?maCDBV=".$maCD);
}
else{
    header('Location: 404notfound.php');
}
}
$resultDanhSachBV = $tblBaiViet->layDanhSachBaiVietDangChoDuyet($maCD, $taiKhoan);
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
    <div class="card ">
        <div class="card-body">
            <div class="row">
                <div class="col-9 d-flex">
                    <div style="font-weight: bold; line-height: 35px; font-size: 20px">Đang chờ • <?php
                        $resultBVDC = $tblBaiViet->SoLuongBaiVietDangCho();
                        if ($resultBVDC) { 
                            $row = $resultBVDC->fetch_row(); 
                            $soLuong = $row[0]; 
                            if($soLuong != 0) echo $soLuong;
                            else    echo 0;
                        }
                    ?></div>
                </div>
                <!-- <div class="col-3 m-auto">
                    <form method="get" action="quanlibaivietchoduyet.php">
                        <input name="maCDBV" hidden value="'.$maCD.'"/>
                        <button type="submit" class="btn btn-primary">Mới nhất</button>
                    </form>
                    
                </div> -->
            </div>
        </div>
    </div>
    <?php 
        if($resultDanhSachBV->num_rows == 0)
            echo '<div class="h3">Không có bài viết nào đang chờ duyệt trong chủ đề này</div>';
        while($chiTietBaiViet = $resultDanhSachBV->fetch_assoc()){
           
    ?>
    <div class="card mt-2">
        <h5 class="card-header">Tên bài viết</h5>
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
                        <div class="col-10">
                        <?php if(isset($chiTietBaiViet['ngayDangBV'])){
                                echo $chiTietBaiViet['ngayDangBV'];
                                if($chiTietBaiViet['trangThaiBV'] =='chinhsua'){
                                    echo ' <div style="padding: 3px; border-radius: 4px; background-color: gray; width: fit-content; color: white">Đã chỉnh sửa</div>';
                                }
                        }
                                
                        ; ?>
                        
                        </div> 
                        
                        <div class="col-1">
                            <button  name="edit" class="bookmark"  data-bs-toggle="modal" data-bs-target="#editModal<?php echo $chiTietBaiViet['maBV']?>">
                                <i class="fa fa-pen " style="cursor: pointer;"></i>
                            </button>
                            </div>
                            <div class="col-1">
                            <button  name="remove" class="bookmark"  data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $chiTietBaiViet['maBV']?>">
                                <i class="fa fa-trash " style="cursor: pointer;"></i>
                            </button>
                        </div>
                        <!--Start Modal Edit -->
                        <div class="modal fade" id="editModal<?php echo $chiTietBaiViet['maBV']?>" tabindex="-1" aria-labelledby="editModal<?php echo $chiTietBaiViet['maBV']?>Label" aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 800px; width: 80%; /">
                            <form action="" method="post">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editModal<?php echo $chiTietBaiViet['maBV']?>Label">Chỉnh sửa bài viết</h1>
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
                                    <!-- Lưu biến mã bài viết bằng input hidden -->
                                <input hidden type="text" value="<?php echo $chiTietBaiViet['maBV']?>" name="maBV">
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
                        <div class="modal fade" id="deleteModal<?php echo $chiTietBaiViet['maBV']?>" tabindex="-1" aria-labelledby="deleteModal<?php echo $chiTietBaiViet['maBV']?>Label" aria-hidden="true">
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
                                <input name="maBV" type="text" hidden value="<?php echo $chiTietBaiViet['maBV']?>"/>
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
                        <td style="border-bottom: none">
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
                    
                </tbody>
                </table>
            </div>
            
        </div>
        
        </div>
        
    </div>
    <?php }?>
    
</div>
<div class="col-md-3" id="rightmenu">
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

<?php include("../inc/footer.php"); ?>