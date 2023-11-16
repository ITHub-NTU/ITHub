<?php
require ('C:/xampp/phpMyAdmin/vendor/autoload.php');
require ('../class/NguoiDung.php');
include_once '../config/Database.php';


$verificationMessage = '';
$database = new Database();
$db = $database->getConnection();
$tblNguoiDung = new NguoiDung($db); 
$_SESSION['startCountdown'] = true;

$_SESSION['time'] = isset($_SESSION['time']) ? $_SESSION['time'] : time();

if (isset($_POST["verify"])) {
    $timeElapsed = time() - $_SESSION['time'];
    $timeRemaining = 60 - $timeElapsed;

    if ($timeElapsed < 60) {
        $_SESSION['startCountdown'] = false;
        if (!empty($_POST["verificationCode"])) {
            if (isset($_SESSION['expectedVerificationCode'])) {
                $verificationCode = $_POST["verificationCode"];
                $email = $_SESSION['user_email'];

                if ($verificationCode == $_SESSION['expectedVerificationCode']) {
                    $result = $tblNguoiDung->updateEmailVerificationStatus($email);

                    if ($result === true) {
                        header('Location: ./changepassword.php');
                        exit;
                    } else {
                        $verificationMessage = 'Có lỗi xảy ra trong quá trình xác thực email.';
                    }
                } else {
                    $verificationMessage = 'Mã xác nhận không đúng. Vui lòng kiểm tra lại.';
                }
            } else {
                $verificationMessage = 'Mã của bạn đã hết thời hạn.';
            }
        } else {
            $verificationMessage = 'Vui lòng nhập mã xác nhận.';
        }
    } else {
        unset($_SESSION['expectedVerificationCode']);
        unset($_SESSION['time']);
        $verificationMessage = 'Mã xác thực đã hết hạn. Vui lòng gửi lại mã.';
    }
}

if (isset($_POST["resendCode"])) {
    $_SESSION['startCountdown'] = true;
    $email = $_SESSION['user_email'];
    $tblNguoiDung->setVerificationCode();
    $verificationCode = $_SESSION['expectedVerificationCode'];
    $result = $tblNguoiDung->sendVerificationEmail($email, $verificationCode);

    if ($result === true) {
        header('Location: ./verifycpassword.php');
        exit;
    } else {
        $verificationMessage = 'Có lỗi xảy ra trong quá trình xác thực email.';
    }
}

include '../inc/header.php';
include '../inc/navbar.php';
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
                <h2 class="fw-bold mb-5 text-uppercase">Xác thực Email</h2>
                    <?php if ($verificationMessage != '') { ?>
                        <p class="text-white-50 mb-3"><?php echo $verificationMessage; ?></p>                         
                    <?php } ?>

                    <div class="form-outline form-white mb-5">
                        <input type="text" id="verificationCode" class="form-control form-control-lg"  name="verificationCode" placeholder="Nhập mã xác thực"/>
                    </div>
                    
                    <p id="countdown" class="text-white-50 mb-5"></p>
                    <input type="submit" name="resendCode" value="Gửi lại mã" class="btn btn-outline-light btn-lg px-4 mx-4 mb-md-3 mt-2"></input>

                    <input type="submit" name="verify" value="Xác thực" class="btn btn-outline-light btn-lg px-4 mb-md-3 mt-2"></input>

                    
                </div>
            <div>
            </div>
        </div>
        </div>
    </div>
    </section>
</form>

<script>
        var countdown = 60;


        var startCountdown = <?php echo isset($_SESSION['startCountdown']) ? $_SESSION['startCountdown'] : 'false'; ?>;
        
        if (startCountdown) {
            var interval = setInterval(function() {
                countdown--;
                if (countdown >= 0) {
                    document.getElementById('countdown').innerText = "Bộ đếm ngược: " + countdown + " giây";
                }
                if (countdown === 0) {
                    document.getElementById('countdown').innerText = "Mã của bạn đã hết hạn";
                    <?php
                    $_SESSION['startCountdown'] = false;
                    ?>
                }
            }, 1000);
        }
    </script>


</body>
<?php 
include '../inc/footer.php';
?>

