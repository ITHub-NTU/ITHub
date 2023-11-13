<?php
include_once '../config/Database.php';
include_once '../class/NguoiDung.php';

$database = new Database();
$db = $database->getConnection();


$tblNguoiDung = new NguoiDung($db);

$registerMessage = '';
$matKhauLoi = array();
if (isset($_POST["register"])) {
    if (
        !empty($_POST["taiKhoan"]) &&
        !empty($_POST["matKhau"]) &&
        !empty($_POST["xacNhanMK"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["hoND"]) &&
        !empty($_POST["tenND"]) &&
        !empty($_POST["ngaySinh"])
    ) {
        $taiKhoan = $_POST["taiKhoan"];
        $matKhau = $_POST["matKhau"];
        $xacNhanMK = $_POST["xacNhanMK"];
        $email = $_POST["email"];
        $hoND = $_POST["hoND"];
        $tenND = $_POST["tenND"];
        $ngaySinh = date("Y-m-d", strtotime($_POST["ngaySinh"]));

            if (!preg_match('/^[a-zA-Z\s]+$/', $hoND)) {
                $matKhauLoi[] = "Họ chỉ được chứa chữ cái và khoảng trắng.";
            }
            if (!preg_match('/^[a-zA-Z\s]+$/', $tenND)) {
                $matKhauLoi[] = "Tên chỉ được chứa chữ cái và khoảng trắng.";
            }
            if (!preg_match('/^[a-z0-9]+$/', $taiKhoan)) {
                $matKhauLoi[] = "Tên tài khoản chỉ được chứa chữ thường và số";
            }
            if (!preg_match('/[A-Z]/', $matKhau)) {
                $matKhauLoi[] = "Mật khẩu phải có ít nhất một chữ hoa";
            }
            
            if (!preg_match('/[a-z]/', $matKhau)) {
                $matKhauLoi[] = "Mật khẩu phải chứa ít nhất một chữ cái viết thường";
            }
            
            if (!preg_match('/[0-9]/', $matKhau)) {
                $matKhauLoi[] = "Mật khẩu phải chứa ít nhất một chữ số";
            }
            
            if (!preg_match('/[^A-Za-z0-9]/', $matKhau)) {
                $matKhauLoi[] = "Mật khẩu phải có ký tự đặc biệt";
            }
            
            if (strlen($matKhau) < 8) {
                $matKhauLoi[] = "Mật khẩu phải tối thiểu 8 ký tự";
            }
            
            if ($xacNhanMK != $matKhau) {
                $matKhauLoi[] = "Mật khẩu không trùng khớp với mật khẩu xác thực";
            }
            
            $ngayHienTai = strtotime(date("Y-m-d"));
            $tuoiMin = 18; 

            if ($ngayHienTai - strtotime($ngaySinh) < $tuoiMin * 365 * 24 * 60 * 60) {
                $matKhauLoi[] = 'Bạn chưa đủ 18 tuổi.';
            }

            if (empty($matKhauLoi)) {
                $result = $tblNguoiDung->register($taiKhoan, $email, $matKhau, $hoND, $tenND, $ngaySinh);
                $registerMessage = $result;
            }
    } else {
        $registerMessage = 'Thiếu dữ liệu';
    }
}
include '../inc/header.php';
include '../inc/navbar.php'

?>
<body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var btnNoiQuy = document.getElementById('btnNoiQuy');
        var myModal = new bootstrap.Modal(document.getElementById('myModal'));

        btnNoiQuy.addEventListener('click', function (event) {
            event.preventDefault();  // Ngăn chặn sự kiện mặc định (làm mới trang)
            myModal.show();
        });
    });
    </script>    
<form method="POST" action="">
    <section class="mh-100 bg-white">
    <div class="container py-5 px-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">

                <div class="mb-md-1 mt-md-2 pb-1">

                    <h2 class="fw-bold mb-2 text-uppercase pb-5">Đăng ký</h2>
                        <?php if ($registerMessage != '') { ?>
                            <p class="text-white-50 mb-5"><?php echo $registerMessage; ?></p>                         
                        <?php } ?>
                        <?php if (!empty($matKhauLoi)) {
                                foreach ($matKhauLoi as $msg) { ?>
                                    <p class="text-white-50 mb-5"><?php echo $msg; ?></p> 
                                <?php } ?> 
                        <?php } ?>


                        <button type="button" id="btnNoiQuy" class="btn btn-outline-light btn-lg px-5 mb-5">Nội quy đăng ký</button>


                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-dark" id="exampleModalLabel">Nội quy đăng ký</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="color: black; text-align: left">1. Tài khoản chỉ được chứa chữ cái in thường và số.</p>
                                        <p style="color: black; text-align: left">2. Mật khẩu phải có ít nhất 1 chữ in hoa, 1 thường, 1 số,1 ký tự đặc biệt và tối thiểu 8 ký tự.</p>
                                        <p style="color: black; text-align: left">3. Bạn phải trên 18 tuổi</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="form-outline form-white mb-4">
                        <input type="text" id="typeAccount" class="form-control form-control-lg" name="taiKhoan" placeholder="Tên tài khoản" value="<?php if(isset($taiKhoan)) echo "$taiKhoan" ?>"/>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <input type="email" id="typeEmailX" class="form-control form-control-lg"  name="email" placeholder="Email"  value="<?php if(isset($email)) echo "$email" ?>"/>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <input type="password" id="typePassword" class="form-control form-control-lg"  name="matKhau" placeholder="Mật khẩu"/>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <input type="password" id="typeConfirmPassword" class="form-control form-control-lg"  name="xacNhanMK" placeholder="Nhập lại mật khẩu"/>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <input type="text" id="typeFirstName" class="form-control form-control-lg"  name="hoND" placeholder="Họ" value="<?php if(isset($hoND)) echo "$hoND" ?>"/>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <input type="text" id="typeLastName" class="form-control form-control-lg"  name="tenND" placeholder="Tên" value="<?php if(isset($tenND)) echo "$tenND" ?>"/>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <input type="date" id="typeBirthday" class="form-control form-control-lg"  name="ngaySinh" placeholder="Ngày sinh" value="<?php if(isset($ngaySinh)) echo "$ngaySinh"?>"/>
                    </div>
                    <div class="pb-5">
                        <input type="submit" name="register" value="Đăng ký" class="btn btn-outline-light btn-lg px-5 mt-5"></input>
                    </div>
                        
                        <a href="dangnhap.php" class="text-white-50 fw-bold">Quay về trang đăng nhập</a>
                </div>


                </div>
            </div>
        </div>
        </div>
    </div>
    </section>
</form>

</body>

<?php 
include '../inc/footer.php';
?>
