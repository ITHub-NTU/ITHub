<?php include_once '../config/Database.php'; ?>
<?php include_once '../class/TaiLieu.php'; ?>
<?php include_once '../class/LoaiTaiLieu.php'; ?>
<?php include_once '../class/ThongBao.php'; ?>
    <?php
    $database = new Database();
    $db = $database->getConnection();
    $taiLieu = new TaiLieu($db);
    $taiLieu = new TaiLieu($db);
    $tblThongBao = new ThongBao($db);

    // Kiểm tra tài khoản có hoạt động hoặc bận và tài khoản đã đăng xuất chưa
    if(isset($_SESSION['hoatdong']))
    {
        $chDangNhap = true;
        $taiKhoan = $_SESSION['taiKhoan'];  
            //Thêm và xóa tài liệu yêu thích
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['maTL']) and isset($_POST['yeuThich']) and isset($_POST['taiKhoan'])){
                $maTL = $_POST['maTL'];
                $yeuThich = $_POST['yeuThich'];
                $taiKhoan = $_POST['taiKhoan'];
                $taiLieuMaTL = $maTL;
                $taiLieu->maTL = $taiLieuMaTL; 
                $chiTietTaiLieu = $taiLieu->layTaiLieu();
                // Thêm thông tin yêu thích vào cơ sở dữ liệu
                $themXoaTLYeuThich = $taiLieu->changeTLYeuThich($yeuThich, $taiKhoan,$maTL);
                $tblThongBao->themTBTL($chiTietTaiLieu['taiKhoan'], $taiKhoan, 'yeuthichtailieu', $chiTietTaiLieu['maLoaiTL'], $maTL);
            } 
        }
    }else{
        
        $chDangNhap = false;
        $taiKhoan = null;  
    }
  
     // Số lượng tài liệu trên mỗi trang
     $recordsPerPage = 4;

     // Trang hiện tại, mặc định là trang 1
      $trangHienTai = isset($_GET['page']) ? $_GET['page'] : 1;
 
     // Tính toán OFFSET dựa trên trang hiện tại
     $offset = ( $trangHienTai - 1) * $recordsPerPage;
 
    

    // lấy dữ liệu dưới để kiểm tra rồi sắp xếp
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $order = isset($_GET['order']) ? $_GET['order'] : '';

    $selectedCategory = '';
    if (isset($_GET['maLoaiTL'])) {
        $maLoaiTL = $_GET['maLoaiTL'];
        $taiLieu->maLoaiTL = $maLoaiTL;
        $taiLieus = $taiLieu->getTaiLieuBymaLoaiTL($sort, $order,$recordsPerPage, $offset);
        $chon = 'maLoaiTL';
        $selectedCategory = $maLoaiTL;
         // Đếm tổng số tài liệu
     $tongTaiLieu = $taiLieu->countTotalTaiLieu($maLoaiTL);
 
     // Tính số trang dựa trên tổng số tài liệu và số lượng tài liệu trên mỗi trang
     $tongTrang = ceil($tongTaiLieu / $recordsPerPage);
    } else {
        $chon = '';
        $taiLieus = $taiLieu->getTaiLieu($sort, $order, $recordsPerPage, $offset);
        $maLoaiTL = null;
         // Đếm tổng số tài liệu
     $tongTaiLieu = $taiLieu->countTotalTaiLieu($maLoaiTL);
    
     // Tính số trang dựa trên tổng số tài liệu và số lượng tài liệu trên mỗi trang
     $tongTrang = ceil($tongTaiLieu / $recordsPerPage);
        
    }
 

    include('../inc/header.php');
    ?>
  
        <?php include("../inc/navbar.php"); ?>
        <div class="section-body">
       
            <div class="row">
                <nav class="col-lg-3 border border-1 rounded-2" >
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
                <div class="col-lg-9">
                    <div class="row">
                       <div class=" section-card col-lg-10 ">
                            <div>
                                <tr>
                                <th>
                                    <svg class="me-5 ms-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z"/>
                                    </svg>
                                </th>       
                            </tr>
                            <tr>
                               
                                <th>
                                    <a class="text-secondary icon-link icon-link-hover text-decoration-none m-2 me-5" href="?<?php echo $chon?>=<?php echo $selectedCategory; ?>&sort=tenTL&order=<?php echo ($sort == 'tenTL' && $order == 'ASC') ? 'DESC' : 'ASC'; ?>" id="sort-tenTL">Tên tài liệu
                                        <?php if ($sort == 'tenTL') : ?>
                                            <?php if ($order == 'ASC') : ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
                                                    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
                                                </svg>
                                            <?php else : ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-up" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
                                                    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 0 1-.708.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 0 1-.707.708L4.5 3.707V13.5z"/>
                                                </svg>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th>
                                    <a class="text-secondary icon-link icon-link-hover text-decoration-none m-2 me-5" href="?<?php echo $chon?>=<?php echo $selectedCategory; ?>&sort=taiKhoan&order=<?php echo ($sort == 'taiKhoan' && $order == 'ASC') ? 'DESC' : 'ASC'; ?>" id="sort-taiKhoan">Tên tài khoản
                                        <?php if ($sort == 'taiKhoan') : ?>
                                            <?php if ($order == 'ASC') : ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
                                                    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
                                                </svg>
                                            <?php else : ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-up" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
                                                    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 0 1-.708.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 0 1-.707.708L4.5 3.707V13.5z"/>
                                                </svg>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th>
                                    <a class="text-secondary icon-link icon-link-hover text-decoration-none m-2" href="?<?php echo $chon?>=<?php echo $selectedCategory; ?>&sort=ngayDangTL&order=<?php echo ($sort == 'ngayDangTL' && $order == 'ASC') ? 'DESC' : 'ASC'; ?>" id="sort-ngayDangTL">Ngày đăng
                                        <?php if ($sort == 'ngayDangTL') : ?>
                                            <?php if ($order == 'ASC') : ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
                                                    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
                                                </svg>
                                            <?php else : ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-up" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
                                                    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 0 1-.708.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 0 1-.707.708L4.5 3.707V13.5z"/>
                                                </svg>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </a>
                                </th>
                              
                            </tr>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning text-white" style="width:100%">Thêm tài liệu</button>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Đăng tài liệu vào chủ đề...</h1>
                                    <button type="button" class="btn-close" data-bs-dimdiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group">
                                      
                                    <?php
                                    $database = new Database();
                                    $db = $database->getConnection();
                                    $tblLoaiTaiLieu = new LoaiTaiLieu($db);
                                    $result = $tblLoaiTaiLieu->layDSLoaiTaiLieu();

                                    while ($loaiTaiLieu = $result->fetch_assoc()) {
                                        $maLoaiTL = $loaiTaiLieu['maLoaiTL'];
                                        echo '<li class="list-group-item"><a style="text-decoration: none; color: black"  href="themtailieu.php?maLoaiTL='.$maLoaiTL.'">' . $loaiTaiLieu['tenLoaiTL'] . '</a></li>';
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <!-- End Modal -->
                <?php if ($taiLieus !== null) : ?>
                    <?php foreach ($taiLieus as $taiLieu) : ?>
                        <?php if ($taiLieu['trangThaiTL'] == 'daduyet' ) : ?>
                        <div class="section-card border border-1 rounded-2 mt-2">
                            <div class="row">
                                <div class="col-lg-3 text-center">
                                    <?php if (!empty($taiLieu['anhTL'])) : ?>
                                        <img class="border border-3 rounded-4 m-3" style="width: 150px; height: 150px;" src="../image/<?php echo $taiLieu['anhTL']; ?>" alt="Image" class="img-responsive">
                            
                                    <?php else : ?>
                                        <img class="border border-3 rounded-4 m-3" style="width: 150px; height: 150px;" src="../image/macdinh.jpg" alt="Default Image" class="img-responsive">
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-lg-9">
                                    <div class="mt-2 mb-2 row" >
                                    <h3 class="fw-medium mb-2 mt-3" ><span><i id="fa-picture-o" aria-hidden="true"></i></span><?php echo $taiLieu['tenTL']; ?></h3>
                                   </div>
                                    <div class="mt-2 mb-2 row" >
                                    <p class="fw-normal mb-2 mt-2" ><?php echo $taiLieu['moTaTL']; ?></p>
                                    </div>
                                    <div class="row">
                                        <div class="col"> <a href="#"><i class="fa fa-user text-body-secondary me-5" aria-hidden="true"> <?php echo $taiLieu['taiKhoan']; ?></i></a>
                                        </div>
                                        <div class="col"> <a href="#"><i class="fa fa-calendar text-body-secondary me-5" aria-hidden="true"> <?php echo date('d-m-Y', strtotime($taiLieu['ngayDuyetTL'])); ?></i></a>
                                        </div>
                                       
                                        <div class="col"><a href="#"><i class="fa fa-book text-body-secondary me-5" aria-hidden="true"> <?php echo $taiLieu['tenLoaiTL']; ?></i></a>
                                        </div>
                                        <div class="col"><a href="#"><i class="fa fa-folder text-body-secondary " aria-hidden="true"> <?php echo $taiLieu['tenDD']; ?></i></a>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3 mt-3">  
                                        <div>
                                        <a class="btn btn-warning me-4" href="chitiettailieu.php?maTL=<?php echo $taiLieu['maTL']; ?>" class="icon-link icon-link-hover me-4" style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                            Tiếp tục đọc 
                                        </a>
                                        </div>
                                        <?php if ($chDangNhap): ?>
                                        <div>
                                        <?php $database = new Database();
                                            $db = $database->getConnection();
                                            $taiLieuYT = new TaiLieu($db);
                                            $taiLieuYeuThich = $taiLieuYT->getTLYeuThich($taiKhoan,$taiLieu['maTL']);
                                        if($taiLieuYeuThich==true):?>
                                            <form action="#" method="post" id="like_form">
                                            <input type="hidden" name="maTL" id="maTL" value="<?php echo $taiLieu['maTL']; ?>">
                                                <input type="hidden" name="taiKhoan" id="taiKhoan" value="<?php echo $taiKhoan; ?>">
                                                <input type="hidden" name="yeuThich" id="yeuThich" value="<?php $yeuThich=true; echo $yeuThich ?>">
                                                <button type="submit" class="btn btn-warning me-4" id="post_like" style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                                    </svg>
                                                    Đã yêu thích
                                                </button>
                                            </form>
                                            <?php else:?>
                                            <form action="#" method="post" id="like_form">
                                                <input type="hidden" name="maTL" id="maTL" value="<?php echo $taiLieu['maTL']; ?>">
                                                <input type="hidden" name="taiKhoan" id="taiKhoan" value="<?php echo $taiKhoan; ?>">
                                                <input type="hidden" name="yeuThich" id="yeuThich" value="<?php $yeuThich=false; echo $yeuThich ?>">
                                                <button type="submit" class="btn btn-warning me-4" id="post_like" style="--bs-link-hover-color-rgb: 25, 135, 84; text-decoration:none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suit-heart" viewBox="0 0 16 16">
                                                <path d="m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z"/>
                                                </svg>
                                                    yêu thích
                                                </button>
                                            </form>
                                        <?php endif;?>
                                        </div>
                                        <?php endif;?>
                                        <div>
                                            <a href="download-pdf.php?pdf=<?php echo $taiLieu['fileTL']; ?>" class="btn btn-warning">Tải về</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Không tìm thấy tài liệu.</p>
                <?php endif; 
                  echo '<ul class="pagination">';
                  // Nút back
                  if ( $trangHienTai > 1) {
                      echo '<li class="page-item"><a class="page-link" href="?page=' . ( $trangHienTai - 1) . '">Back</a></li>';
                  }
                  
                  for ($i = 1; $i <= $tongTrang; $i++) {
                      $activeClass = ($i ==  $trangHienTai) ? 'active' : '';
                      echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?'.$chon.'='.$selectedCategory.'&page=' . $i . '">' . ($i ==  $trangHienTai ? '<strong>' . $i . '</strong>' : $i) . '</a></li>';
                  }
                  
                  // Nút next
                  if ( $trangHienTai < $tongTrang) {
                      echo '<li class="page-item"><a class="page-link" href="?page=' . ( $trangHienTai + 1) . '">Next</a></li>';
                  }
                  
                  echo '</ul>';
                ?>

                </div>
            </div>
        </div>
        <?php include('../inc/footer.php'); ?>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var sortArrow = document.querySelector('#sort-tenTL .bi-sort-alpha-up');
        if (sortArrow) {
            sortArrow.addEventListener('click', function() {
                sortArrow.classList.toggle('bi-sort-alpha-down');
            });
        }

        var sortArrows = document.querySelectorAll('.bi-sort-alpha-up');
        sortArrows.forEach(function(arrow) {
            arrow.addEventListener('click', function() {
                arrow.classList.toggle('bi-sort-alpha-down');
            });
        });
        
    </script>

