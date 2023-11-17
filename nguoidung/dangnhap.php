<?php
include_once '../config/Database.php';
include_once '../class/NguoiDung.php';

$database = new Database();
$db = $database->getConnection();

$tblNguoiDung = new NguoiDung($db);

// if($tblNguoiDung->loggedIn()) {
//     header("Location: ");
// }

$loginMessage = '';
if(!empty($_POST["login"]) && !empty($_POST["taiKhoan"]) && !empty($_POST["matKhau"])) {
    $tblNguoiDung->taiKhoan = $_POST["taiKhoan"];
    $tblNguoiDung->matKhau = $_POST["matKhau"];
    if($tblNguoiDung->login()) {
        $_SESSION['hoatdong'] = 'hoatdong';
        $_SESSION['taiKhoan'] = $_POST["taiKhoan"];
        $_SESSION['pass'] = $_POST["matKhau"];
        switch ($tblNguoiDung->xacThuc){
            case 'chuaxacminh':
                $loginMessage = "Người dùng chưa xác minh";
                session_unset();
                session_destroy();
                break;
            case 'daxacminh':
                switch ($tblNguoiDung->quyen) {
                    case 'quantrivien':
                        $tblNguoiDung->accountOnline($_POST["taiKhoan"]);
                        header("Location: ../trangchu.php");
                        break;
                    case 'nguoidung':
                        $tblNguoiDung->accountOnline($_POST["taiKhoan"]);
                        header("Location: ../trangchu.php");
                        break;
                    case 'nguoidungbichan':
                        $loginMessage = "Người dùng đã bị chặn";
                        session_unset();
                        session_destroy();
                        break;
                }
        }
        

        
    } else {
        $loginMessage = 'Đăng nhập không hợp lệ! Vui lòng thử lại.';
    }
} else if (empty($_POST["login"]) || empty($_POST["taiKhoan"]) || empty($_POST["matKhau"])){
    $loginMessage = 'Nhập tên tài khoản và mật khẩu.';
}

include '../inc/header.php';
include '../inc/navbar.php'

?>

<body>
<form method="POST" action="">
    <section class="mh-100 bg-white">
    <div class="container py-5 px-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

                <div class="mb-md-1 mt-md-2 pb-1">

                    <h2 class="fw-bold mb-2 text-uppercase">Đăng nhập</h2>
                        <?php if ($loginMessage != '') { ?>
                            <p class="text-white-50 mb-5"><?php echo $loginMessage; ?></p>                         
                        <?php } ?>

                    <div class="form-outline form-white mb-4">
                        <input type="text" id="typeAccount" class="form-control form-control-lg" name="taiKhoan" placeholder="Tên tài khoản" <?php if(isset($_COOKIE['taiKhoan'])) { echo 'value="' . $_COOKIE['taiKhoan'] . '"'; } ?> />
                    </div>

                    <div class="form-outline form-white mb-4">
                        <input type="password" id="typePasswordX" class="form-control form-control-lg"  name="matKhau" placeholder="Mật khẩu" <?php if(isset($_COOKIE['matKhau'])) { echo 'value="' . $_COOKIE['matKhau'] . '"'; } ?>/>
                    </div>
                    <div class="mb-3 form-check d-flex align-items-center">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                        <label class="form-check-label mb-0 mx-2" for="rememberMe">Nhớ mật khẩu</label>
                    </div>

                        <p class="small mb-1 pb-lg-2"><a class="text-white-50" href="./nhapemail.php">Quên mật khẩu?</a></p>

                        <input type="submit" name="login" value="Đăng nhập" class="btn btn-outline-light btn-lg px-5 mb-md-3"></input>
                </div>

                <div>
                    <p class="mb-0">Bạn đã có tài khoản chưa? <a href="dangky.php" class="text-white-50 fw-bold">Đăng ký</a></p>
                    
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
