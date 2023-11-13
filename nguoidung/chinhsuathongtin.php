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

            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                $errorMessage[] = "Chỉ cho phép tải lên các tệp ảnh có định dạng JPG, JPEG, PNG.";
                $uploadOk = 0;
            } elseif ($_FILES["anhDaiDien"]["size"] > 2 * 1024 * 1024) {
                $errorMessage[] = "Tệp ảnh quá lớn. Giới hạn là 2MB.";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                // Đổi tên tệp thành 'thienlan.jpg', 'thienlan.jpeg' hoặc 'thienlan.png'
                $newFileName = "thienlan." . $imageFileType;
                $targetFile = $targetDir . $newFileName;

                if (move_uploaded_file($_FILES["anhDaiDien"]["tmp_name"], $targetFile)) {
                    $anhDaiDien = $newFileName;
                } else {
                    $errorMessage = "Có lỗi xảy ra khi tải lên tệp.";
                }
            }
        }
        
        if (empty($errorMessage)) {
            $email = $_POST["email"];
            $hoND = $_POST["hoND"];
            $tenND = $_POST["tenND"];
            $ngaySinh = $_POST["ngaySinh"];
            if (empty($anhDaiDien)) {
                $anhDaiDien = $userInfo["anhDaiDien"];
            }
        
            if ($tblNguoiDung->updateUserInfoByTaiKhoan($taiKhoan, $email, $hoND, $tenND, $ngaySinh, $anhDaiDien)) {
                $message = "Cập nhật thành công!";
            } else {
                $message = "Có lỗi xảy ra.";
            }
        }
        
    }
}

include('../inc/header.php');
include('../inc/navbar.php');
?>

<form method="POST" action="" enctype="multipart/form-data">
    <section class="mh-100 bg-white">
    <div class="container py-5 px-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-10 col-lg-8 col-xl-6">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                    <h2 class="fw-bold mb-5 text-uppercase">Thông tin cá nhân</h2>
                    <?php if ($message != '') { ?>
                        <p class="text-white-50 mb-5"><?php echo $message; ?></p>
                    <?php } ?>
                    <?php if (!empty($errorMessage)) {
                                foreach ($errorMessage as $msg) { ?>
                                    <p class="text-white-50 mb-5"><?php echo $msg; ?></p> 
                                <?php } ?> 
                        <?php } ?>

                    <div class="row mb-4">
                        <div class="col-md-3 my-2 text-end">
                            <label for="typeEmail" class="form-label">Email:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="typeEmail" class="form-control form-control-lg" require name="email" placeholder="Email" value="<?php if(isset($email)) echo "$email"?>"/>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 my-2 text-end">
                            <label for="typeLastName" class="form-label">Họ:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="typeLastName" class="form-control form-control-lg" require name="hoND" placeholder="Họ" value="<?php if(isset($hoND)) echo "$hoND"?>"/>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 my-2 text-end">
                            <label for="typeFirstName" class="form-label">Tên:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="typeFirstName" class="form-control form-control-lg" require name="tenND" placeholder="Tên" value="<?php if(isset($tenND)) echo "$tenND"?>"/>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 my-2 text-end">
                            <label for="typeBirthday" class="form-label">Ngày sinh:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" id="typeBirthday" class="form-control form-control-lg" require name="ngaySinh" placeholder="Ngày sinh" value="<?php if(isset($ngaySinh)) echo "$ngaySinh"?>"/>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 my-2 text-end">
                            <label for="typeAvatar" class="form-label">Ảnh đại diện:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" id="typeAvatar" class="form-control form-control-lg" name="anhDaiDien" accept="image/*"/>
                        </div>
                    </div>
                    <input type="submit" name="change" value="Thay đổi" class="btn btn-outline-light btn-lg px-5  mt-4"></input>
                </div>
            </div>
        </div>
        </div>
    </div>
    </section>
</form>
<?php
include ("../inc/footer.php")

?>