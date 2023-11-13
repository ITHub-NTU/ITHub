<?php
require ('C:/xampp/phpMyAdmin/vendor/autoload.php');
require ('../class/NguoiDung.php');
include_once '../config/Database.php';


$emailMessage = '';
$database = new Database();
$db = $database->getConnection();
$tblNguoiDung = new NguoiDung($db); 

if (isset($_POST["submit"])) {
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        $emailMessage = $tblNguoiDung->verifyEmailRequest($email);
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

                    <h2 class="fw-bold mb-2 text-uppercase pb-4">Nhập email </h2>
                        <?php if ($emailMessage != '') { ?>
                            <p class="text-white-50 mb-5"><?php echo $emailMessage; ?></p>                         
                        <?php } ?>


                    <div class="form-outline form-white mb-4 pb-4">
                        <input type="email" id="typeEmailX" class="form-control form-control-lg"  name="email" placeholder="Email"/>
                    </div>
                    <div class="pb-4">
                        <input type="submit" name="submit" value="Gửi" class="btn btn-outline-light btn-lg px-5"></input>
                    </div>           
                    
                        
                        <a href="./dangnhap.php" class="text-white-50 fw-bold">Quay về trang đăng nhập</a>
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
