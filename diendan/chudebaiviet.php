<?php
include_once '../config/Database.php';
include_once '../class/ChuDeBV.php';
include_once '../class/BaiViet.php';
include_once '../class/TienIch.php';
include_once '../class/NguoiDung.php';		
$database = new Database();
$db = $database->getConnection();

$tblChuDeBV = new ChuDeBV($db);
$tienIch = new TienIch();
$tblBaiViet = new BaiViet($db);
$tblNguoiDung = new NguoiDung($db);;
include('../inc/header.php');
?>

<?php include("../inc/navbar.php"); ?>
<div class="row">
	<div class="col-md-3">
		<button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning text-white" style="margin-bottom: 5px;">Thêm bài viết</button>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Đăng bài viết vào chủ đề...</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  	<ul class="list-group">
          <?php
		  
          // Lấy danh sách các chủ đề từ cơ sở dữ liệu và hiển thị chúng
          $database = new Database();
          $db = $database->getConnection();
          $tblChuDeBV = new ChuDeBV($db);
          $result = $tblChuDeBV->layDSChuDeBV();

          while ($chuDeBV = $result->fetch_assoc()) {
			$maCD = $chuDeBV['maCD'];
            echo '<li class="list-group-item"><a style="text-decoration: none; color: black" class="chude-link" href="thembaiviet.php?maCD='.$maCD.'">' . $chuDeBV['tenCD'] . '</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
<div class="col-md-9">
	<div class="card">
		<h5 class="card-header" style="background-color:cadetblue;">Chủ đề bài viết</h5>
		<?php
			$result = $tblChuDeBV->layDSChuDeBV();
			$numRows = $result->num_rows;
			$rowCount = 0;
			while ($chuDeBV = $result->fetch_assoc()) {
				$tblChuDeBV->maCD = $chuDeBV['maCD'];
				$soLuongBaiViet = $tblChuDeBV->laySoLuongBaiViet();
				$soLuongThaoLuan = $tblChuDeBV->laySoLuongThaoLuan();
				$thaoLuanMoiNhat = $tblChuDeBV->layThaoLuanMoiNhat();
				
				if(!empty($thaoLuanMoiNhat['ngayDangTLBV'])) {
					$timestamp = strtotime($thaoLuanMoiNhat['ngayDangTLBV']);
				}else {
					$timestamp = NULL;
				}

				$rowCount++;
				$isLast = ($rowCount == $numRows);

				if ($isLast) {
					echo '<div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0">';
				} else {
					echo '<div class="card" style="border-radius:unset">';
			}
		?>
			<div class="row">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-3">
							<img src="../image/<?php echo $chuDeBV['anhCD']; ?>" class=" m-3 d-block" style="width:5em; height: 5em; object-fit: cover;" alt="...">
						</div>
						<div class="col-md-9 my-auto">
							<a class="text-decoration-none m-5" href="danhsachbaiviet.php?maCD=<?php echo $chuDeBV['maCD'];?>" title=""><?php echo $chuDeBV['tenCD']; ?></a>
						</div>
					</div>
				</div>
				<div class="col-md-8 my-auto">
					<div class="row">
						<div class="col-md-5 text-center my-auto">
							<div class="row">
								<div class="col-md-6">
									<p>Bài viết</p>
									<a class="text-decoration-none" href="danhsachbaiviet.php?maCD=<?php echo $chuDeBV['maCD'];?>" title="">
										<?php echo $soLuongBaiViet; ?>		
									</a>
								</div>
								<div class="col-md-6">
									<p>Thảo luận</p>
									<a class="text-decoration-none" href="danhsachbaiviet.php?maCD=<?php echo $chuDeBV['maCD'];?>" title="">
										<?php echo $soLuongThaoLuan; ?>		
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-7 my-auto text-center">
							<div class="row my-auto">
								<?php if($timestamp != NULL){ 
									echo '<div class="col-md-3 my-auto">
									<img src="../image/'.$thaoLuanMoiNhat['anhDaiDien']
									.'" class=" d-block" style="width: 80px;height: 80px;object-fit: cover;border-radius: 50%;" alt="...">
									</div>
									<div class="col-md-9 my-auto" style="text-align:left;">
										<div class="row">
											<a href="chitietbaiviet.php?maBV='.$thaoLuanMoiNhat['maBV'].'"'.'class="text-decoration-none" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 14.5em;">
												'.$thaoLuanMoiNhat['tenBaiViet']
											.'</a>
											<label class"">
											'.$tienIch->formatTimeAgo($timestamp) . '. 
											<a class="text-decoration-none">
												'. $thaoLuanMoiNhat['taiKhoan']
											.'</a>
											</label>
										</div>
									</div>';
									} else {
										$queryBVMN = "
											SELECT bv.*, cd.tenCD
											FROM tblbaiviet bv
											JOIN tblchudebv cd ON bv.maCD = cd.maCD
											WHERE bv.trangThaiBV = 'daduyet' or bv.trangThaiBV = 'dachinhsua'
											ORDER BY bv.ngayDuyetBV DESC LIMIT 1;";
										$resultBVMN = $db->query($queryBVMN);
										$chiTietBaiViet = $resultBVMN->fetch_assoc();
										$thongTinNguoiDung = $tblNguoiDung->getUserInfoByTaiKhoan($chiTietBaiViet['taiKhoan']);
            							$anhND = $thongTinNguoiDung['anhDaiDien'];
										echo '<div class="col-md-3 my-auto">
											<img src="../image/'.$anhND
											.'" class=" d-block" style="width: 80px;height: 80px;object-fit: cover;border-radius: 50%;" alt="...">
											</div>
											<div class="col-md-9 my-auto" style="text-align:left;">
												<div class="row">
													<a href="chitietbaiviet.php?maBV='.$chiTietBaiViet['maBV'].'"'.'class="text-decoration-none" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 14.5em;">
														'.$chiTietBaiViet['tenBV']
													.'</a>
													<label class"">
													'.$tienIch->formatTimeAgo(strtotime($chiTietBaiViet['ngayDuyetBV'])). '. 
													<a class="text-decoration-none">
														'. $chiTietBaiViet['taiKhoan']
													.'</a>
													</label>
												</div>
											</div>';
									} ?> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<?php } ?>
	</div>
</div>

<div class="col-md-3" id="rightmenu">
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<?php include("../inc/footer.php"); ?>