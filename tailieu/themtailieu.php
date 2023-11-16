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
                $trangThaiTL = 'chuaduyet'; // Gán trạng thái mặc định hoặc thay đổi thành trạng thái tùy ý
                $fileTL = "upload-tailieu/"; // Đường dẫn lưu trữ file trên server
                $ngayDangTL = $currentDateTime->format('Y-m-d H:i:s');
                $ngayDuyetTL = null;
            
                if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    $file = $_FILES['file']['name'];
                    $fileTL .= $file;
            
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $fileTL)) {
                        // Lưu thông tin tệp vào cơ sở dữ liệu
                        if ($tblTaiLieu->themTaiLieu($maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL,$anhTL, $trangThaiTL, $ngayDangTL, $ngayDuyetTL)) {
                            echo '<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="successModalLabel">Thành công!</h5>
                                          <input type="button" class="btn btn-secondary" value="X" data-bs-dismiss="modal" aria-label="Close">
                                    </div>
                                    <div class="modal-body">
                                        Tài liệu đã được tải lên và lưu vào cơ sở dữ liệu thành công.Chờ duyệt tài liệu
                                    </div>
                                </div>
                            </div>
                        </div>';
                           
                        } else {
                            echo '<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="successModalLabel">Thành công</h5>
                                          <input type="button" class="btn btn-secondary" value="X" data-bs-dismiss="modal" aria-label="Close">
                                    </div>
                                    <div class="modal-body">
                                        Lỗi tải tệp
                                    </div>
                                </div>
                            </div>
                        </div>';
                        }
                    } else {
                        echo '<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="successModalLabel">Thành công</h5>
                                      <input type="button" class="btn btn-secondary" value="X" data-bs-dismiss="modal" aria-label="Close">
                                </div>
                                <div class="modal-body">
                                    Có lỗi trong quá trình tải lên
                                </div>
                            </div>
                        </div>
                    </div>';
                    }
                } 
                echo '<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="successModalLabel">Thành công!</h5>
                                          <input type="button" class="btn btn-secondary" value="Đóng" data-bs-dismiss="modal" aria-label="Close">
                                    </div>
                                    <div class="modal-body">
                                        Tài liệu đã được tải lên và lưu vào cơ sở dữ liệu thành công.Chờ duyệt tài liệu
                                    </div>
                                </div>
                            </div>
                        </div>';
                         $tblThongBao->themTBTL($taiKhoan, '', 'admin', $maLoaiTL, $maTL);
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
                        <div class="form-group">
                            <label for="maDD">Chọn kiểu tài liệu:</label>
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
                            <label for="formFile" class="form-label"></label>
                            <input class="form-control" type="file" id="formFile" required accept=".pdf, .doc, .docx, .pptx">
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

<script>
    // Sau khi xử lý thành công khi tệp được tải lên và lưu vào cơ sở dữ liệu
    // Kích hoạt modal thông báo thành công
    document.addEventListener('DOMContentLoaded', function () {
        <?php if ($tblTaiLieu->themTaiLieu($maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL, $ngayDangTL, $ngayDuyetTL)) { ?>
            $('#successModal').modal('show');
        <?php } ?>
    });
</script>

<?php include('../inc/footer.php'); ?>
