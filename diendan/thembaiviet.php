<?php
include_once '../config/Database.php';
include_once '../class/ChuDeBV.php';
include_once '../class/BaiViet.php';
include_once '../class/ThongBao.php';
include_once '../class/TienIch.php';
$database = new Database();
$db = $database->getConnection();
$tienIch = new TienIch();
$tblChuDeBV = new ChuDeBV($db);
$tblThongBao = new ThongBao($db);
$maBV = $tienIch->autoIncrement('tblbaiviet', 'maBV', 'BV00000001');
$_SESSION['maBV'] = $maBV;
$tblBaiViet = new BaiViet($db);
$tblChuDeBV->maCD = $_GET['maCD'];
    $chuDeBV = $tblChuDeBV->layChuDeBV();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST['noi_dung']) || is_null($_POST['noi_dung'])){
        $tua_de = $_POST['tua_de'];
    }
    else{
        $tblChuDeBV->maCD = $_GET['maCD'];
        $chuDeBV = $tblChuDeBV->layChuDeBV();
        $maCD = $tblChuDeBV->maCD;
        $taiKhoan = $_SESSION['taiKhoan'];
        $tenBV = $_POST['tua_de'];
        $noiDungBV = $_POST['noi_dung'];
        $trangThaiBV = 'chuaduyet'; 
        $ngayDuyetBV = NULL; 
        $ngayChinhSuaBV = NULL; 
        if ($tblBaiViet->themBaiViet($maBV,$maCD, $taiKhoan, $tenBV, $noiDungBV, $trangThaiBV, $ngayDuyetBV, $ngayChinhSuaBV)) {
            $tblThongBao->themTBBV($taiKhoan,'admin', $maCD, $maBV);
            header("Location:chudebaiviet.php");
        }
    }
    
}
include('../inc/header.php');
?>
<?php include("../inc/navbar.php"); ?>
<script src="https://cdn.tiny.cloud/1/id38n7baf9sugfjkempo62ey1gfyhjofshz0lge19m8pgufs/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="js/editor.js"></script>
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
    height: 400,
    plugins: 'image table | lists | textcolor code',
    toolbar: 'undo redo | bold italic fontsize | image | table | bullist numlist | forecolor backcolor | code',
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
            <h5 class="card-header" style="background-color:cadetblue;">Thêm bài viết vào <?php echo $chuDeBV['tenCD'] ?></h5>
            <div class="container">
                <form method="post" enctype="multipart/form-data" id="post_form" class="mt-3" onsubmit="return validateForm()">
                    <input type="text" class="form-control mb-3 fs-2" placeholder="Tựa đề bài viết" name="tua_de" aria-label="Tựa đề bài viết" required value="<?php if(isset($tua_de)) echo $tua_de;?>">
                    <textarea name="noi_dung" id="editor"></textarea>
                    <?php if(isset($tua_de)) echo '<span id="error_message" style="color: red;">*Vui lòng nhập nội dung bài viết.</span>'?>
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-dark my-3" value="Đăng bài viết">
                    </div>
                </form>
            </div>
            </div>
        </div>
        <div class="col-md-3" id="rightmenu">
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include("../inc/footer.php"); ?>
