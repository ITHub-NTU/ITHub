<?php include_once '../config/Database.php'; ?>
<?php include_once '../class/TaiLieu.php'; ?>
<?php include_once '../class/LoaiTaiLieu.php'; ?>
    <?php
    $database = new Database();
    $db = $database->getConnection();
    $taiLieu = new TaiLieu($db);
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $order = isset($_GET['order']) ? $_GET['order'] : '';
    $selectedCategory = '';
    if (isset($_GET['maLoaiTL'])) {
        $maLoaiTL = $_GET['maLoaiTL'];
        $taiLieu->maLoaiTL = $maLoaiTL;
        $taiLieus = $taiLieu->getTaiLieuBymaLoaiTL($sort, $order);
        $selectedCategory = $maLoaiTL;
    } else {
        $taiLieus = $taiLieu->getTaiLieu($sort, $order);
    }
    include('../inc/header.php');
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ITHub - Tài Liệu</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        
    </head>
   
    <body>
        <?php include("../inc/navbar.php"); ?>
        <div class="section-body">
            <div class="row">
                <nav class="col-md-3 border border-1 rounded-2 " style="padding-top: 0px;">
                    <h5 class="text-center p-3 mt-2 bg-warning rounded-2 ">Loại tài liệu</h5>
                    <?php
                    $loaiTaiLieus = $taiLieu->getLoaiTaiLieu();
                    foreach ($loaiTaiLieus as $loaiTaiLieu) {
                        $activeClass = ($selectedCategory == $loaiTaiLieu['maLoaiTL']) ? 'active' : '';
                        echo '<a class="p-2 mt-2 rounded-2 list-group-item list-group-item-action list-group-item-success" style="width:100%" id="loaitailieu" href="danhsachtailieu.php?maLoaiTL=' . $loaiTaiLieu['maLoaiTL'] . '&sort=' . $sort . '&order=' . $order . '" class="list-group-item list-group-item-action ' . $activeClass . '">' . $loaiTaiLieu['tenLoaiTL'] . '</a>';
                    }
                    ?>
                </nav>
                <div class="col-md-9">
                    <div class="row">
                       
                    <div class="border border border-1 rounded-2 col-md-9 ms-3">
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
                                <a class="text-secondary icon-link icon-link-hover text-decoration-none m-2 me-5" href="?tenTL=<?php echo $selectedCategory; ?>&sort=tenTL&order=<?php echo ($sort == 'tenTL' && $order == 'ASC') ? 'DESC' : 'ASC'; ?>" id="sort-tenTL">Tên tài liệu
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
                                <a class="text-secondary icon-link icon-link-hover text-decoration-none m-2 me-5" href="?taiKhoan=<?php echo $selectedCategory; ?>&sort=taiKhoan&order=<?php echo ($sort == 'taiKhoan' && $order == 'ASC') ? 'DESC' : 'ASC'; ?>" id="sort-taiKhoan">Tên tài khoản
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
                                <a class="text-secondary icon-link icon-link-hover text-decoration-none m-2" href="?ngayDang=<?php echo $selectedCategory; ?>&sort=ngayDangTL&order=<?php echo ($sort == 'ngayDangTL' && $order == 'ASC') ? 'DESC' : 'ASC'; ?>" id="sort-ngayDangTL">Ngày đăng
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
                        <div class="col-md-2">
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning text-white" style="margin-bottom: 5px;">Thêm tài liệu</button>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Đăng tài liệu vào chủ đề...</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <div class="section-card border border-1 rounded-2 mt-2">
                                <div class="d-flex">
                                    <?php if (!empty($taiLieu['anhTL'])) : ?>
                                        <img class="border border-3 rounded-4 m-3" style="width: 150px; height: 150px;" src="../image/macdinh.jpg" alt="Image" class="img-responsive">
                                        <!-- "img/<?php echo $taiLieu['anhTL']; ?>" -->
                                    <?php else : ?>
                                        <img class="border border-3 rounded-4 m-3" style="width: 150px; height: 150px;" src="../image/macdinh.jpg" alt="Default Image" class="img-responsive">
                                    <?php endif; ?>
                                    <div class="blog-details3902">
                                        <h3 class="fw-medium mb-2 mt-3"><span><i id="fa-picture-o" aria-hidden="true"></i></span><?php echo $taiLieu['tenTL']; ?></h3>
                                        <p class="fw-normal mb-2 mt-2"><?php echo $taiLieu['moTaTL']; ?></p>
                                        <div class="ques-icon-info2933 mt-2 mb-2">
                                            <a href="#"><i class="fa fa-user text-body-secondary me-5" aria-hidden="true"> <?php echo $taiLieu['taiKhoan']; ?></i></a>
                                            <a href="#"><i class="fa fa-calendar text-body-secondary me-5" aria-hidden="true"> <?php echo $taiLieu['ngayDangTL']; ?></i></a>
                                            <a href="#"><i class="fa fa-book text-body-secondary me-5" aria-hidden="true"> <?php echo $taiLieu['tenLoaiTL']; ?></i></a>
                                            <a href="#"><i class="fa fa-folder text-body-secondary " aria-hidden="true"> <?php echo $taiLieu['tenDD']; ?></i></a>
                                        </div>
                                        <div class="continue-deatils738">
                                            <a href="chitiettailieu.php?maTL=<?php echo $taiLieu['maTL']; ?>">
                                                <i class="fa fa-plus mt-3" aria-hidden="true"> Tiếp tục đọc</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Không tìm thấy tài liệu.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

<?php include('../inc/footer.php'); ?>