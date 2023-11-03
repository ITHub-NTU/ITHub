<?php 
include_once '../config/Database.php';
include_once '../class/LoaiTaiLieu.php';
include_once '../class/TaiLieu.php';
include_once '../class/TienIch.php';

$database = new Database();
$db = $database->getConnection();
$tienIch = new TienIch();
$tblLoaiTaiLieu = new LoaiTaiLieu($db);
$maTL = $tienIch->autoIncrement('TblTaiLieu','maTL','TL00000001');
$_SESSION['maTL'] = $maTL;
$tblTaiLieu = new TaiLieu($db);

if (isset($_GET['maLoaiTL'])) {
    $maLoaiTL = $_GET['maLoaiTL'];
} else {
    die("Lỗi: 'maLoaiTL' không tồn tại.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tblLoaiTaiLieu->maLoaiTL = $_GET['maLoaiTL'];
    $loaiTaiLieu = $tblLoaiTaiLieu->layLoaiTaiLieu();
    $maLoaiTL = $tblLoaiTaiLieu->maLoaiTL;
    $taiKhoan = 'phuongha';
    $maDD = $_POST['maDD'];
    $tenTL = $_POST['tenTL']; 
    $moTaTL = $_POST['moTaTL'];

    // Lưu thông tin tệp vào cơ sở dữ liệu
    $trangThaiTL = 'Trạng thái mặc định'; // Gán trạng thái mặc định hoặc thay đổi thành trạng thái tùy ý
    $ngayDuyetTL = date("Y-m-d H:i:s"); // Sử dụng ngày và giờ hiện tại
    $fileTL = "upload-tailieu/"; // Đường dẫn lưu trữ file trên server

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file']['name'];
        $fileTL .= $file;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $fileTL)) {
            // Lưu thông tin tệp vào cơ sở dữ liệu
            if ($tblTaiLieu->themTaiLieu($maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL, $ngayDuyetTL)) {
                echo "Tệp đã được tải lên và lưu vào cơ sở dữ liệu thành công.";
                
            } else {
                echo "Có lỗi xảy ra trong quá trình lưu tệp vào cơ sở dữ liệu.";
            }
        } else {
            echo "Có lỗi xảy ra trong quá trình tải lên.";
        }
    } 
    echo "Tài liệu đã thêm thành công, chờ duyệt nhé cưng!";
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
                            <input name="file" type="file">
                        </div>
                        <div class="dz-message needsclick">
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
<script src="../js/dropzone.min.js"></script>
<?php include('../inc/footer.php'); ?>
