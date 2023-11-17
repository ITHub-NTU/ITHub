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
<link rel="stylesheet" href="../inc/main.css">
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
			<div class="row p-2">
				<div class="col-lg-1 col-sm-2 col-m-2">
					<img src="../image/<?php echo $chuDeBV['anhCD'];?>" style="width: 60px;
								height: 60px;
								object-fit: cover;
								border-radius: 50%;" alt="...">
				</div>
				<div class="col-lg-4 col-sm-10 col-m-10 pl-5">
					<div >
						<div>
							<a class="text-decoration-none tenCD" href="danhsachbaiviet.php?maCD=<?php echo $chuDeBV['maCD'];?>" title="">
								<?php
								$tenCD = $chuDeBV['tenCD'];
								$maxTitleLength = 2 * 100;
								if (strlen($tenCD) > $maxTitleLength) {
									$tenCD = substr($tenCD, 0, $maxTitleLength) . '...';
								}
								echo $tenCD;
								?>
							</a>
						</div>
						
					</div>
				</div>
				<div class="col-lg-7 col-sm-12 ">
					<div class="row">
						<div class="col-lg-4 col-sm-3 col-m-4">
							<div>
								Bài viết
							</div>
							<div>
								<a class="text-decoration-none" href="danhsachbaiviet.php?maCD=<?php echo $chuDeBV['maCD'];?>" title="">
									<?php echo $soLuongBaiViet; ?>      
								</a>
							</div>
						</div>
						<div class="col-lg-8 col-sm-9 col-m-8">
							<?php if($timestamptwo != NULL){ 
								echo '
									<div style="display: flex">
										<div style="width: 66%; text-align: right; padding-right: 5px">
											<a class="text-decoration-none" href="chitietbaiviet.php?maBV='.$baiViet['maBV'].'#comment-'.$thaoLuanMoiNhat['maTLBV'].'" title="">
											'.$tienIch->formatTimeAgo($timestamptwo).'
											</a>
											<div>
												<a class="text-decoration-none">
													'.$thaoLuanMoiNhat['taiKhoan']
												.'</a>
											</div>
										</div>
										<div style="width: 33%">
											<img src="../image/'.$thaoLuanMoiNhat['anhDaiDien'].'" style="width: 50px;object-fit: cover;border-radius: 50%;" alt="...">
										</div>
									</div>
								';
								} else {
									echo 'Chưa có bình luận nào';
								} ?> 
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