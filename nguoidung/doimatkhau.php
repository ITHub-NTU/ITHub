<?php
include_once '../config/Database.php';
include_once '../class/NguoiDung.php';

$database = new Database();
$db = $database->getConnection();

$tblNguoiDung = new NguoiDung($db);

$confirmMessage = '';

if (!empty($_POST["submit"]) && !empty($_POST["matKhau"]) && !empty($_POST["matkhaucu"]) && !empty($_POST["xacNhanMK"])) {
    $oldPassWord = $_POST['matkhaucu'];
    $newPassword = $_POST["matKhau"];
    $confirmPassword = $_POST["xacNhanMK"];

    $matKhauLoi = array();

    if (!preg_match('/[A-Z]/', $newPassword)) {
        $matKhauLoi[] = "Mật khẩu phải có ít nhất một chữ hoa";
    }
    
    if (!preg_match('/[a-z]/', $newPassword)) {
        $matKhauLoi[] = "Mật khẩu phải chứa ít nhất một chữ cái viết thường";
    }
    
    if (!preg_match('/[0-9]/', $newPassword)) {
        $matKhauLoi[] = "Mật khẩu phải chứa ít nhất một chữ số";
    }
    

    if (!preg_match('/[^A-Za-z0-9]/', $newPassword)) {
        $matKhauLoi[] = "Mật khẩu phải có ký tự đặc biệt";
    }
    

    if (strlen($newPassword) < 8) {
        $matKhauLoi[] = "Mật khẩu phải tối thiểu 8 ký tự";
    }
    
    if ($newPassword != $confirmPassword) {
        $matKhauLoi[] = "Mật khẩu không trùng khớp với mật khẩu xác thực";
    }

    if (empty($matKhauLoi)) {
        $result = $tblNguoiDung->changePasswordLogin($oldPassWord, $newPassword, $confirmPassword);

        if ($result == 'Thay đổi mật khẩu thành công!') {
            header('Location: ./trangcanhan.php');
            exit;
        } else {
            $confirmMessage = $result;
        }
    }
} else if (empty($_POST["submit"]) || empty($_POST["matkhaucu"])|| empty($_POST["matKhau"]) || empty($_POST["xacNhanMK"])) {
    $confimMessage = 'Nhập mật khẩu cũ và mới.';
}
?>

<?php
include('../inc/header.php');
include('../inc/navbar.php');
?>


<form method="POST" action="">
    <section class="vh-100 bg-white">
    <div class="container py-5 px-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

                <div class="mb-md-1 mt-md-2 pb-1">

                <h2 class="fw-bold mb-2 text-uppercase">Đổi mật khẩu</h2>
                    <?php if ($confirmMessage != '') { ?>
                            <p class="text-white-50 mt-3"><?php echo $confirmMessage; ?></p>                         
                    <?php } ?>

                    <?php if (!empty($matKhauLoi)) {
                            foreach ($matKhauLoi as $msg) { ?>
                                <p class="text-white-50 mb-2"><?php echo $msg; ?></p> 
                            <?php } ?> 
                    <?php } ?>

                    <div class="form-outline form-white mb-4 mt-5">
                        <input type="password" id="typePassword" class="form-control form-control-lg"  name="matkhaucu" placeholder="Mật khẩu cũ"/>
                    </div>

                    <div class="form-outline form-white mb-4 mt-5">
                        <input type="password" id="typePassword" class="form-control form-control-lg"  name="matKhau" placeholder="Mật khẩu mới"/>
                    </div>

                    <div class="form-outline form-white mb-4 mt-5">
                        <input type="password" id="typeConfirmPassword" class="form-control form-control-lg"  name="xacNhanMK" placeholder="Nhập lại mật khẩu mới"/>
                    </div>


                    <input type="submit" name="submit" value="Xác nhận" class="btn btn-outline-light btn-lg px-5 mb-md-3 mt-5"></input>

                </div>

            <div>
            </div>
        </div>
        </div>
    </div>
    </section>
</form>
<?php 
include('../inc/footer.php');
?>