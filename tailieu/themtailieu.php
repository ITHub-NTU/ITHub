<?php
include_once '../config/Database.php';
include_once '../class/TaiLieu.php';
include_once '../class/ThongBao.php';
$database = new Database();
$db = $database->getConnection();
$taiLieu = new TaiLieu($db);
$tblThongBao = new ThongBao($db);
$taiLieuMaTL = $_GET['maTL'];
$taiLieu->maTL = $taiLieuMaTL; 
$chiTietTaiLieu = $taiLieu->layTaiLieu();
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ là Asia/Ho_Chi_Minh

$currentDateTime = new DateTime();
$currentDateTime->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
if(isset($_SESSION['hoatdong']))
{
    if (isset($_SESSION['taiKhoan'])) {
        
        $chDangNhap = true;
        $taiKhoan = $_SESSION['taiKhoan'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['maTL']) and isset($_POST['yeuThich']) and isset($_POST['taiKhoan'])){
                $maTL = $_POST['maTL'];
                $yeuThich = $_POST['yeuThich'];
                $taiKhoan = $_POST['taiKhoan'];
                // Thêm thông tin yêu thích vào cơ sở dữ liệu
                $themXoaTLYeuThich = $taiLieu->changeTLYeuThich($yeuThich, $taiKhoan,$maTL);
                $tblThongBao->themTBTL($chiTietTaiLieu['taiKhoan'], $taiKhoan, 'yeuthichtailieu', $chiTietTaiLieu['maLoaiTL'], $maTL);
            } 
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['maLoaiTL'])and isset($_POST['maDD'])and isset($_POST['tenTL'])and isset($_POST['moTaTL'])){
                $maLoaiTL = $_POST['maLoaiTL'];
                $maDD = $_POST['maDD'];
                $tenTL = $_POST['tenTL']; 
                $moTaTL = $_POST['moTaTL'];
               
            
                // Lưu thông tin tệp vào cơ sở dữ liệu
                $trangThaiTL = 'chuaduyet'; // Gán trạng thái mặc định hoặc thay đổi thành trạng thái tùy ý
                $ngayDuyetTL = null;
                $ngayDangTL = $currentDateTime->format('Y-m-d H:i:s');
            
                $fileTL = "upload-tailieu/"; // Đường dẫn lưu trữ file trên server
                
                if (isset($_FILES['anhTL']) && $_FILES['anhTL']['error'] === UPLOAD_ERR_OK) {
                    $anhTL = $_FILES['anhTL']['name'];
                    $pathToSave = "../image/" . $anhTL;
        
                    if (move_uploaded_file($_FILES['anhTL']['tmp_name'], $pathToSave)) {
                        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                            $file = $_FILES['file']['name'];
                            $fileTL .= $file;
                    
                            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                                $taiLieu->chinhSuaTaiLieu($taiLieuMaTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL,$ngayDangTL, $ngayDuyetTL,$anhTL);
                                $tblThongBao->themTBTL($taiKhoan, '', 'admin', $maLoaiTL, $taiLieuMaTL);
                                echo '<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="successModalLabel">Thành công</h5>
                                              <input type="button" class="btn btn-secondary" value="X" data-bs-dismiss="modal" aria-label="Close">
                                        </div>
                                        <div class="modal-body">
                                            Tài liệu đã được chỉnh sửa và lưu vào cơ sở dữ liệu thành công. Vui lòng chờ duyệt tài liệu. 
                                        </div>
                                    </div>
                                </div>
                            </div>';
                             
                            }
                        } 
                    }
                }

              
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['maTL']) and isset($_POST['maLoaiVP']) and isset($_POST['taiKhoan'])) {
                $maTL = $_POST['maTL'];
                $maLoaiVP = $_POST['maLoaiVP'];
                $taiKhoan = $_POST['taiKhoan'];
                $themTLViPham = $taiLieu->insertTLBaoCao($maTL, $maLoaiVP, $taiKhoan);
                $tblThongBao->themTBTL('', '', 'baocaotailieu', $maLoaiVP, $maTL);
            }
        }
        
    }
}
else {
    header("location:../nguoidung/dangnhap.php");
    $chDangNhap = false;
    $taiKhoan = null;
}

     // Số lượng tài liệu trên mỗi trang
     $recordsPerPage = 4;

     // Trang hiện tại, mặc định là trang 1
      $trangHienTai = isset($_GET['page']) ? $_GET['page'] : 1;
 
     // Tính toán OFFSET dựa trên trang hiện tại
     $offset = ( $trangHienTai - 1) * $recordsPerPage;

$chiTietTaiLieu = $taiLieu->getChiTietTaiLieu();
$dinhDangTaiLieus = $taiLieu->getDSDDTaiLieu();
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';

$selectedCategory = '';
if (isset($_GET['maLoaiTL'])) {
    $maLoaiTL = $_GET['maLoaiTL'];
    $taiLieu->maLoaiTL = $maLoaiTL;
    $taiLieus = $taiLieu->getTaiLieuBymaLoaiTL($sort, $order,$recordsPerPage, $offset);
    $chon = 'maLoaiTL';
    $selectedCategory = $maLoaiTL;
} else {
    $chon = '';
    $taiLieus = $taiLieu->getTaiLieu($sort, $order,$recordsPerPage, $offset);
}





 include('../inc/header.php');?>

<?php include("../inc/navbar.php");?>
            <div class="row">
                <nav class="col-sm-3 border border-1 rounded-2" >
                    <h5 class="text-center p-3 mt-2 bg-warning rounded-2 ">Loại tài liệu</h5>
                    <div class="list-group">
                            <?php
                            $loaiTaiLieus = $taiLieu->getLoaiTaiLieu();
                            $activeClass = ($selectedCategory == '') ? 'active' : ''; // Check if "Tất cả" is selected
                            echo '<a class="p-2 mt-2 rounded-2 list-group-item list-group-item-action list-group-item-success ' . $activeClass . '" style="width:100%" href="danhsachtailieu.php" class="list-group-item list-group-item-action">Tất cả</a>';
                            
                            foreach ($loaiTaiLieus as $loaiTaiLieu) {
                                $parameters = array(
                                    'maLoaiTL' => $loaiTaiLieu['maLoaiTL'],
                                    'sort' => $sort,
                                    'order' => $order
                                );
                                $queryString = http_build_query($parameters);
                                $activeClass = ($selectedCategory == $loaiTaiLieu['maLoaiTL']) ? 'active' : '';
                                echo '<a class="p-2 mt-2 rounded-2 list-group-item list-group-item-action list-group-item-success ' . $activeClass . '" style="width:100%" id="loaitailieu" href="danhsachtailieu.php?' . $queryString . '" class="list-group-item list-group-item-action">' . $loaiTaiLieu['tenLoaiTL'] . '</a>';
                            }
                            ?>
                        </div>
                </nav>
                <div class="col-md-9">
                    <div class="section-card">
                        <div class="row border border-1 rounded-2 p-2 bg-warning ms-1 me-1">
                            <div class="col-lg-9">
                                <h4><?php echo $chiTietTaiLieu['tenTL'] ?></h4>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <?php 
                                        if($taiLieu->kiemTraQuyenChinhSua($taiKhoan,$chiTietTaiLieu['maTL'])):?>
                                        <div class="col-3">
                                            <button class="btn btn-warning me-4" data-bs-toggle="modal" data-bs-target="#editModal" style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <?php else : ?>
                                            <div class="col-3">
                                        </div>
                                    <?php endif; ?>
                                        <div class="col-3">
                                            <?php $database = new Database();
                                                $db = $database->getConnection();
                                                $taiLieuYT = new TaiLieu($db);
                                                $taiLieuYeuThich = $taiLieuYT->getTLYeuThich($taiKhoan,$chiTietTaiLieu['maTL']);
                                            if($taiLieuYeuThich==true):?>
                                                <form action="#" method="post">
                                                    <input type="hidden" name="maTL" value="<?php echo $chiTietTaiLieu['maTL']; ?>">
                                                    <input type="hidden" name="taiKhoan" value="<?php echo $taiKhoan; ?>">
                                                    <input type="hidden" name="yeuThich" value="<?php $yeuThich=true; echo $yeuThich ?>">
                                                    <button type="submit" class="btn btn-warning me-4" style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                                        </svg>
                                                        
                                                    </button>
                                                </form>
                                                <?php else:?>
                                                <form action="#" method="post">
                                                    <input type="hidden" name="maTL" value="<?php echo $chiTietTaiLieu['maTL']; ?>">
                                                    <input type="hidden" name="taiKhoan" value="<?php echo $taiKhoan; ?>">
                                                    <input type="hidden" name="yeuThich" value="<?php $yeuThich=false; echo $yeuThich ?>">
                                                    <button type="submit" class="btn btn-warning me-4" style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suit-heart" viewBox="0 0 16 16">
                                                    <path d="m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z"/>
                                                    </svg>
                                                    </button>
                                                </form>
                                            <?php endif;?>
                                        </div>
                                        <div class="col-3">
                                            
                                            <a href="download-pdf.php?pdf=<?php echo $chiTietTaiLieu['fileTL']; ?>" class="btn btn-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                </svg>
                                            </a>
                                        
                                        </div>
                                    
                                        <div class="col-3"> 
                                            <?php
                                                $database = new Database();
                                                $db = $database->getConnection();
                                                $taiLieu = new TaiLieu($db);
                                                $loaiViPhams = $taiLieu->getDSLoaiViPham();
                                                $kiemTraTLBiBaoCao = $taiLieu->daBaoCaoTaiLieu($chiTietTaiLieu['maTL'],$taiKhoan);
                                                if(!$kiemTraTLBiBaoCao):
                                                    echo'                
                                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning text-danger" style="width:100%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
                                                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z"/>
                                                </svg>
                                           </button>
                                            <!-- Modal -->
                                            <form method="post" action="#">
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Báo cáo tài liệu</h1>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="list-group">';     
                                                            foreach ($loaiViPhams as $loaiViPham) {
                                                                echo'<div class="list-group-item rounded-2 mb-3">
                                                                <input type="hidden" name="maTL" value="'.  $chiTietTaiLieu['maTL'] .'">
                                                                <input type="hidden" name="taiKhoan" value="'.  $taiKhoan.'">
                                                                <input class="form-check-input " type="radio" name="maLoaiVP" id="'.$loaiViPham['maLoaiVP'].'" value="'.$loaiViPham['maLoaiVP'].'" checked>
                                                                <label class="form-check-label" for="'.$loaiViPham['maLoaiVP'].'">
                                                                '.$loaiViPham['tenLoaiVP'].'
                                                                </label>
                                                            </div>';
                                                            }
                                                            echo'
                                                            </ul>
                                                            <div style="float:right;">
                                                            <input type="submit" class="btn btn-danger" value="Báo cáo">
                                                            <input type="button" class="btn btn-secondary" value="Hủy" data-bs-dismiss="modal" aria-label="Close">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                            ?>
                                            </form>
                                            <!-- End Modal -->
                                            <?php else: ?>
                                                <button disabled class="btn btn-warning text-danger" style="width:100%">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
                                                        <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"/>
                                                    </svg>
                                                </button>
                                        <?php endif; ?>   
                                        </div>
                                    </div>
                                </div>
                            <!--Start Modal Edit -->
                            <form method="post" action="#" enctype="multipart/form-data">
                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editModalLabel">Chỉnh sửa tài liệu</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex ">
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-4">
                                                            <img src="../image/images.png" style="width:80%;border-radius: 100%" >
                                                        </div>
                                                        <div class="col-8">
                                                            <h5 class="card-title"><a href="#" class="text-decoration-none"><?php if(isset( $chiTietTaiLieu['taiKhoan'])) echo $chiTietTaiLieu['taiKhoan']; ?></a></h5>
                                                        </div>
                                                    </div>
                                                    <div>
                                                    <input class="form-control mb-3" name="tenTL" type="text" required placeholder="Tên tài liệu" value="<?php echo $chiTietTaiLieu['tenTL']?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="anhTL">Ảnh tài liệu</label>
                                                        <input class="form-control" type="file" required id="anhTL" name="anhTL" accept="image/*">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <select class="form-control" id="maDD" name="maDD" required>
                                                            <?php
                                                            echo "<option value='" . $chiTietTaiLieu['maDD'] . "'>" .  $chiTietTaiLieu['tenDD'] . "</option>";
                                                            foreach ($dinhDangTaiLieus as $dinhDangTaiLieu) {
                                                                if ($chiTietTaiLieu['maDD'] != $dinhDangTaiLieu['maDD']){
                                                                    echo "<option value='" . $dinhDangTaiLieu['maDD'] . "'>" .  $dinhDangTaiLieu['tenDD'] . "</option>";
                                                                }
                                                                
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <select class="form-control" id="maLoaiTL" name="maLoaiTL" required>
                                                            <?php
                                                            echo "<option value='" . $chiTietTaiLieu['maLoaiTL'] . "'>" .  $chiTietTaiLieu['tenLoaiTL'] . "</option>";
                                                            foreach ($loaiTaiLieus as $loaiTaiLieu) {
                                                                if ($chiTietTaiLieu['maLoaiTL'] != $loaiTaiLieu['maLoaiTL']){
                                                                    echo "<option value='" . $loaiTaiLieu['maLoaiTL'] . "'>" .  $loaiTaiLieu['tenLoaiTL'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                   
                                                    <div>
                                                    <input class="form-control mb-3" name="moTaTL" type="text" required placeholder="Mô tả tài liệu" value="<?php echo $chiTietTaiLieu['moTaTL']?>">
                                                    </div>
                                                   
                                                    <div>
                                                        <input type="file" id="newFile" name="file" style="display: none;" required accept=".pdf, .doc, .docx, .pptx"> <!-- Đặt accept để chỉ cho phép tải lên các loại tệp cụ thể-->
                                                        <label for="newFile" class="btn btn-primary mb-3">Chọn tệp</label>
                                                        <p class="form-control" id="currentFileName"> <?php echo $chiTietTaiLieu['fileTL'] ?> </p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary" value="Lưu chỉnh sửa">
                                            <input type="reset" class="btn btn-primary" value="reset">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <!--End Modal Edit-->
                        </div>
                        <div class="row border border-1 rounded-2 p-2  ms-1 me-1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><h6>Người đăng</h6> <div class="col-lg-3">  <a href="../nguoidung/trangbanbe.php?taiKhoanBanBe=<?php echo $chiTietTaiLieu['taiKhoan'];?>" class="me-4"style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;color:black">
                                    <?php
                                    echo'
                                    <img style="width: 30px; height: 30px; object-fit: cover;border: 3px solid" class="user-avatar rounded-circle" src="'.$path.'image/'.$chiTietTaiLieu['anhDaiDien'].'" alt="User Avatar">';
                                    ?>
                                    <?php echo $chiTietTaiLieu['taiKhoan']; ?></a>
                                        </div></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><h6>Ngày đăng</h6><span class="text-secondary"> <?php echo date('d-m-Y', strtotime($chiTietTaiLieu['ngayDuyetTL'])); ?></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><h6>Mô tả </h6><?php echo $chiTietTaiLieu['moTaTL']; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <object data="<?php echo $chiTietTaiLieu['fileTL']; ?>" type="application/pdf" width="100%" height="600">
                                        <p>Không thể hiển thị tệp PDF. <a href="<?php echo $chiTietTaiLieu['fileTL']; ?>">Tải về</a> thay vào đó.</p>
                                    </object>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('../inc/footer.php');?>
            <script>
            document.getElementById('newFile').addEventListener('change', function() {
                var fileName = this.value.split('\\').pop();
                document.getElementById('currentFileName').innerText = fileName;
                document.getElementById('currentFileName').setAttribute('href', this.value);
            });
            // Sau khi xử lý thành công khi tệp được tải lên và lưu vào cơ sở dữ liệu
    // Kích hoạt modal thông báo thành công
    document.addEventListener('DOMContentLoaded', function () {
    <?php if ($taiLieu->chinhSuaTaiLieu($taiLieuMaTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL,$ngayDangTL, $ngayDuyetTL)) { ?>
            $('#successModal').modal('show');
        <?php } ?>
    });
            </script>
           
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
