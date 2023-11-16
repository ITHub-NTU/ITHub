<?php
include_once '../config/Database.php';
include_once '../class/NguoiDung.php';

$database = new Database();
$db = $database->getConnection();

$tblNguoiDung = new NguoiDung($db);

$taiKhoan = $_SESSION["taiKhoan"];
$nguoiDung = new NguoiDung($db);
$userInfo = $nguoiDung->getUserInfoByTaiKhoan($taiKhoan);
$message = '';
$errorMessage = array();
$matKhauLoi = array();
if(!(isset($_SESSION['taiKhoan']))){
    header('Location:./dangnhap.php');
}
if ($userInfo) {
    $email = $userInfo["email"];
    $hoND = $userInfo["hoND"];
    $tenND = $userInfo["tenND"];
    $ngaySinh = $userInfo["ngaySinh"];
    $anhDaiDien = $userInfo["anhDaiDien"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['change'])) {
        $uploadOk = 1;
        $anhDaiDien = $userInfo["anhDaiDien"];

        if (isset($_FILES["anhDaiDien"]) && !empty($_FILES["anhDaiDien"]["name"])) {
            $targetDir = "../image/";
            $originalFileName = $_FILES["anhDaiDien"]["name"];
            $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
                $errorMessage[] = "Chỉ cho phép tải lên các tệp ảnh có định dạng JPG, JPEG, PNG.";
                $uploadOk = 0;
            } elseif ($_FILES["anhDaiDien"]["size"] > 2 * 1024 * 1024) {
                $errorMessage[] = "Tệp ảnh quá lớn. Giới hạn là 2MB.";
                $uploadOk = 0;
            }

            $fileToDelete = "../image/" . $userInfo["anhDaiDien"];

            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            } else {
                $errorMessage[] = "File ảnh cũ không tồn tại.";
            }

            if ($uploadOk == 1) {
                $newFileName = $taiKhoan .'.'. $imageFileType;
                $targetFile = $targetDir . $newFileName;

                if (move_uploaded_file($_FILES["anhDaiDien"]["tmp_name"], $targetFile)) {
                    $anhDaiDien = $newFileName;
                } else {
                    $errorMessage = "Có lỗi xảy ra khi tải lên tệp.";
                }
            }

        }
        
        if (empty($errorMessage)){
            $hoND = $_POST["hoND"];
            $tenND = $_POST["tenND"];
            $ngaySinh = $_POST["ngaySinh"];
            if (empty($anhDaiDien)) {
                $anhDaiDien = $userInfo["anhDaiDien"];
            }

            if (!preg_match('/^[\p{L}\s]+$/u', $hoND)) {
                $matKhauLoi[] = "Họ chỉ được chứa chữ cái và khoảng trắng.";
            }
            if (!preg_match('/^[\p{L}\s]+$/u', $tenND)) {
                $matKhauLoi[] = "Tên chỉ được chứa chữ cái và khoảng trắng.";
            }
            $ngayHienTai = strtotime(date("Y-m-d"));
            $tuoiMin = 18; 

            if ($ngayHienTai - strtotime($ngaySinh) < $tuoiMin * 365 * 24 * 60 * 60) {
                $matKhauLoi[] = 'Bạn chưa đủ 18 tuổi.';
            }


            if (empty($matKhauLoi)) {
                $tblNguoiDung->updateUserInfoByTaiKhoan($taiKhoan,$hoND, $tenND, $ngaySinh, $anhDaiDien);
                $message = "Cập nhật thành công!";
            }
        }
        
    }
}


include('../inc/header.php');
include('../inc/navbar.php');
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<form method="POST" action="" enctype="multipart/form-data">
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row border border-4 rounded">
    <div class="col-md-3 offset-md-1 border-right">
        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <img width="150px" height="150px" src="../image/<?php echo $anhDaiDien?>" class="rounded-circle">
            <span style="font-size: 20px" class="font-weight-bold mt-3"><?php echo $taiKhoan ?></span>
        </div>
    </div>
        <div class="col-md-6 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h1>Chỉnh sửa thông tin cá nhân</h1>
                </div>
                <?php if (!empty($matKhauLoi)) {
                                foreach ($matKhauLoi as $msg) { ?>
                                    <p class="text-dark-50 mb-3 text-center"><?php echo $msg; ?></p> 
                                <?php } ?> 
                <?php } ?>
                <?php if ($message != '') { ?>
                        <p class="text-dark-50 mb-5 text-center"><?php echo $message; ?></p>
                    <?php } ?>
                    <?php if (!empty($errorMessage)) {
                                foreach ($errorMessage as $msg) { ?>
                                    <p class="text-dark-50 mb-5"><?php echo $msg; ?></p> 
                                <?php } ?> 
                    <?php } ?>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label style="font-size: 20px">Họ</label>
                        <input type="text" class="form-control mt-3" placeholder="Họ" name="hoND" required value="<?php if(isset($hoND)) echo "$hoND"?>"/>
                    </div>
                    <div class="col-md-6">
                        <label style="font-size: 20px">Tên</label>
                        <input type="text" class="form-control mt-3" placeholder="Tên" name="tenND" required value="<?php if(isset($tenND)) echo "$tenND"?>"/>
                    </div>
                </div>
                <div class="row mt-3 mt-3">
                    <div class="col-md-12">
                        <label style="font-size: 20px">Email</label>
                        <input type="text" class="form-control mt-3" placeholder="Email" name="email" readonly value="<?php if(isset($email)) echo "$email"?>"/>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label style="font-size: 20px">Ngày sinh</label>
                        <input type="date" class="form-control mt-3" placeholder="Ngày sinh" name="ngaySinh" required value="<?php if(isset($ngaySinh)) echo "$ngaySinh"?>"/>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label style="font-size: 20px">Ảnh đại diện</label>                            
                        <input type="file" id="typeAvatar" class="form-control mt-3 form-control-lg" name="anhDaiDien" accept="image/*"/>
                    </div>
                </div>
                <div class="mt-5 text-center">
                <input type="submit" name="change" value="Thay đổi" class="btn btn-primary btn-lg px-5  mt-4"></input></div>
            </div>
        </div>
    
    </div>
</div>
</div>
</div>
</form>
<?php
include ("../inc/footer.php")

?>