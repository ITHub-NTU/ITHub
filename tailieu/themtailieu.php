<?php 
include_once '../config/Database.php';
include_once '../class/LoaiTaiLieu.php';
include_once '../class/TaiLieu.php';
include_once '../class/TienIch.php';
include_once '../class/ThongBao.php';

$database = new Database();
$db = $database->getConnection();
$tienIch = new TienIch();
$tblLoaiTaiLieu = new LoaiTaiLieu($db);
$maTL = $tienIch->autoIncrement('TblTaiLieu','maTL','TL00000001');
$_SESSION['maTL'] = $maTL;
$tblTaiLieu = new TaiLieu($db);
$tblThongBao = new ThongBao($db);

date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ là Asia/Ho_Chi_Minh

$currentDateTime = new DateTime();
$currentDateTime->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));



if(isset($_SESSION['hoatdong'])|| empty($_SESSION['taiKhoan']))
{
    if (isset($_SESSION['taiKhoan'])) {
        $chDangNhap = true;
        $taiKhoan = $_SESSION['taiKhoan']; 
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['maDD'])&&isset($_POST['tenTL'])&&isset($_POST['moTaTL'])){
                $tblLoaiTaiLieu->maLoaiTL = $_GET['maLoaiTL'];
                $loaiTaiLieu = $tblLoaiTaiLieu->layLoaiTaiLieu();
                $maLoaiTL = $tblLoaiTaiLieu->maLoaiTL;
                $maDD = $_POST['maDD'];
                $tenTL = $_POST['tenTL']; 
                $moTaTL = $_POST['moTaTL'];
               
            
                // Lưu thông tin tệp vào cơ sở dữ liệu
                // Lưu thông tin tệp vào cơ sở dữ liệu
                $trangThaiTL = 'chuaduyet'; // Gán trạng thái mặc định hoặc thay đổi thành trạng thái tùy ý
                $fileTL = "upload-tailieu/"; // Đường dẫn lưu trữ file trên server
                $ngayDangTL = $currentDateTime->format('Y-m-d H:i:s');
                $ngayDuyetTL = null;
                
                if (isset($_FILES['anhTL']) && $_FILES['anhTL']['error'] === UPLOAD_ERR_OK) {
                    $anhTL = $_FILES['anhTL']['name'];
                    $pathToSave = "../image/" . $anhTL;
        
                    if (move_uploaded_file($_FILES['anhTL']['tmp_name'], $pathToSave)) {
                        if (isset($_FILES['fileTL']) && $_FILES['fileTL']['error'] === UPLOAD_ERR_OK) {
                            $file = $_FILES['fileTL']['name'];
                            $fileTL .= $file;
                            if (move_uploaded_file($_FILES['fileTL']['tmp_name'], $fileTL)) {
                                $tblTaiLieu->themTaiLieu($maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL, $ngayDangTL, $ngayDuyetTL,$anhTL);   
                                $tblThongBao->themTBTL($taiKhoan, '', 'admin', $maLoaiTL, $maTL); 
                               header("location:danhsachtailieu.php");
                            }
                        } 
                    }
                }
              
              
            }
           
        }
    }else {
        header("location:../nguoidung/dangnhap.php");
        $chDangNhap = false;
        $taiKhoan = null;   }

}


if (isset($_GET['maLoaiTL'])) {
    $maLoaiTL = $_GET['maLoaiTL'];
} else {
    die("Lỗi: 'maLoaiTL' không tồn tại.");
}



$query = "SELECT maDD, tenDD FROM TblDinhDangTL";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
include('../inc/header.php');
?>
<?php include("../inc/navbar.php"); ?>
<link href="../css/dropzone.min.css" rel="stylesheet" type="text/css" />

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thêm tài liệu</h4>
            </div>
            <div class="card-body">
                <div>
                    <form method="post" class="dropzone dz-clickable" action="#" enctype="multipart/form-data">
                        <input type="text" class="form-control mb-3 fs-2" placeholder="Tựa đề tài liệu" name="tenTL" aria-label="Tựa đề tài liệu" required>
                        <input type="text" class="form-control mb-3 fs-2" placeholder="Mô tả" name="moTaTL" aria-label="Mô tả" required>
                        <div>
                            <label for="anhTL">Ảnh tài liệu</label>
                            <input class="form-control" type="file" id="anhTL" required name="anhTL" accept="image/*">
                        </div>
                        <div class="form-group mt-3">
                            <label for="maDD">Chọn kiểu tài liệu</label>
                            <select class="form-control" id="maDD" name="maDD" required>
                                <?php
                                // $result contains the data from your SQL query
                                foreach ($result as $row) {
                                    echo "<option value='" . $row['maDD'] . "'>" . $row['tenDD'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="fallback">
                            <label for="fileTL" class="form-label"></label>
                            <input class="form-control" type="file" id="fileTL" name="fileTL" required accept=".pdf, .doc, .docx, .pptx">
                        </div>
                        <div class="dz-message needsclick text-center">
                            <div class="mb-3">
                                <i class="fas fa-upload fa-3x text-secondary"></i>
                            </div>
                            <h5 class="text-secondary">Thả tài liệu tại đây hoặc nhấn vào để đăng tải </h5>
                        </div>
                       
                        <div class="text-center mt-4">
                            <input type="submit" value="Đăng tài liệu" class="btn btn-dark my-3">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<!-- dropzone js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



<?php include('../inc/footer.php'); ?>
