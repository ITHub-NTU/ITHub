<?php
include_once './Database.php';
include_once './User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$confirmMessage = '';

if (!empty($_POST["submit"]) && !empty($_POST["matKhau"]) && !empty($_POST["xacNhanMK"])) {
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
        $changePasswordResult = $user->changePassword($newPassword, $confirmPassword);

        if ($changePasswordResult == 'Thay đổi mật khẩu thành công!') {
            header('Location: dangnhap.php');
            exit;
        } else {
            $confirmMessage = '123';
        }
    }
} else if (empty($_POST["submit"]) || empty($_POST["matKhau"]) || empty($_POST["xacNhanMK"])) {
    $confimMessage = 'Nhập mật khẩu mới.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
<form method="POST" action="">
    <section class="vh-100 bg-white">
    <div class="container py-5 px-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

                <div class="mb-md-1 mt-md-2 pb-1">

                <h2 class="fw-bold mb-2 text-uppercase">Đổi mật khẩu</h2>
                    <?php if (!empty($matKhauLoi)) {
                            foreach ($matKhauLoi as $msg) { ?>
                                <p class="text-white-50 mb-5"><?php echo $msg; ?></p> 
                            <?php } ?> 
                    <?php } ?>

                    <div class="form-outline form-white mb-4">
                        <input type="password" id="typePassword" class="form-control form-control-lg"  name="matKhau" placeholder="Mật khẩu"/>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <input type="password" id="typeConfirmPassword" class="form-control form-control-lg"  name="xacNhanMK" placeholder="Nhập lại mật khẩu"/>
                    </div>


                    <input type="submit" name="submit" value="Xác nhận" class="btn btn-outline-light btn-lg px-5 mb-md-3"></input>

                </div>

            <div>
            </div>
        </div>
        </div>
    </div>
    </section>
</form>
</body>
</html>
