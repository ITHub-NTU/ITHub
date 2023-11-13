<?php
require ('C:/xampp/phpMyAdmin/vendor/autoload.php');
require ('../class/NguoiDung.php');
include_once '../config/Database.php';


$verificationMessage = '';
$database = new Database();
$db = $database->getConnection();
$tblNguoiDung = new NguoiDung($db); 

if (isset($_POST["verify"])) {
    if (!empty($_POST["verificationCode"])) {
        $verificationCode = $_POST["verificationCode"];
        
        $email = $_SESSION['user_email'];
        
        if ($verificationCode  == $_SESSION['expectedVerificationCode']) { 
            $result = $tblNguoiDung->updateEmailVerificationStatus($email);

            if ($result === true) {
                header('Location: ./dangnhap.php');
            } else {
                $verificationMessage = 'Có lỗi xảy ra trong quá trình xác thực email.';
            }
        } else {
            $verificationMessage = 'Mã xác nhận không đúng. Vui lòng kiểm tra lại.';
        }
    } else {
        $verificationMessage = 'Vui lòng nhập mã xác nhận.';
    }
}

include '../inc/header.php';
include '../inc/navbar.php'

?>
<body>
<form method="POST" action="">
    <section class="vh-100 bg-white">
    <div class="container py-5 px-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
                <div class="mb-md-1 mt-md-2 pb-1">
                <h2 class="fw-bold mb-5 text-uppercase">Xác thực</h2>
                    <?php if ($verificationMessage != '') { ?>
                        <p class="text-white-50 mb-5"><?php echo $verificationMessage; ?></p>                         
                    <?php } ?>

                    <div class="form-outline form-white mb-5">
                        <input type="text" id="verificationCode" class="form-control form-control-lg"  name="verificationCode" placeholder="Nhập mã xác thực"/>
                    </div>

                    <input type="submit" name="verify" value="Xác thực" class="btn btn-outline-light btn-lg px-5 mb-md-3 mt-2"></input>
                </div>
            <div>
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

