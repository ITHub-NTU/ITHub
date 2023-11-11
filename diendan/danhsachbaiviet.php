<?php
include_once '../config/Database.php';
include_once '../class/ChuDeBV.php';
include_once '../class/BaiViet.php';
include_once '../class/TienIch.php';

$database = new Database();
$db = $database->getConnection();

$tblChuDeBV = new ChuDeBV($db);
$tienIch = new TienIch();
$tblBaiViet = new BaiViet($db);

include('../inc/header.php');
?>
<?php include("../inc/navbar.php");
	if(isset($_GET['maCD'])){
		$maCD = $_GET['maCD'];
	}

//--------------------------------------------
	
	$tblChuDeBV->maCD = $maCD ;
    $chuDeBV = $tblChuDeBV->layChuDeBV();
	$tblBaiViet->maCD = $maCD ;
	
	if(isset($_SESSION['taiKhoan'])){
		$taiKhoan = $_SESSION['taiKhoan'];
		$tblBaiViet->taiKhoan = $taiKhoan;
	}
	
	
?>
<div class="col-md-9">
	<?php 
		
		if(isset($_SESSION['taiKhoan'])){
			$resultBVDC = $tblBaiViet->SoLuongBaiVietDangCho();
			if ($resultBVDC) { 
				$row = $resultBVDC->fetch_row(); 
				$soLuong = $row[0]; 
				if($soLuong != 0){
					echo '
					<div class="card mt-2 mb-2" style="background-color: #DADDE1;">
						<div class="card-body">
							<div class="row">
								<div class="col-10">
									<div style="font-weight: bold">Bài viết đang chờ</div>
									<div>'.$soLuong.' bài viết</div>
								</div>
								<div class="col-2 m-auto">
									<button class="btn btn-primary">Quản lí bài viết</button>
								</div>
							</div>
						</div>
					</div>
				';
				}
			} 
		}
	?>
	
	<div class="card" style="background-color:cadetblue;">
		<div class="d-flex card-header">
			<h5 class="" ><?php echo $chuDeBV['tenCD'] ?></h5>
		//-----------------------------------	
		$tblBaiViet->maCD = $_GET['maCD'];
		$result = $tblBaiViet->layDanhSachBaiViet();
		$numRows = $result->num_rows;
		$rowCount = 0;
		while ($baiViet = $result->fetch_assoc()) {
			$tblBaiViet->maBV = $baiViet['maBV'];
			$soLuongThaoLuan = $tblBaiViet->laySoLuongThaoLuan();
			$thaoLuanMoiNhat = $tblBaiViet->layThaoLuanMoiNhat();
			if(!empty($baiViet['ngayDangBV'])) {
				$timestamp = strtotime($baiViet['ngayDangBV']);
			}else {
				$timestamp = NULL;
			}
			if(!empty($thaoLuanMoiNhat['ngayDangTLBV'])) {
				$timestamptwo = strtotime($thaoLuanMoiNhat['ngayDangTLBV']);
			}else {
				$timestamptwo = NULL;
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
				<div class="col-md-6 my-auto text-center">
					<div class="row my-auto " style="text-align:left;">
						<div class="col-md-3 my-auto">
							<img src="../image/<?php echo $baiViet['anhDaiDien'];?>" class="rounded m-3 d-block" style="width:4em" alt="...">
						</div>
						<div class="col-md-9 my-auto">
							<div class="row">
								<a class="text-decoration-none" href="chitietbaiviet.php?maBV=<?php echo $baiViet['maBV'];?>" title="">
									<?php
									$tenBV = $baiViet['tenBV'];
									$maxTitleLength = 2 * 100;
									if (strlen($tenBV) > $maxTitleLength) {
										$tenBV = substr($tenBV, 0, $maxTitleLength) . '...';
									}
									echo $tenBV;
									?>
								</a>
								<label>
									<?php echo $tienIch->formatTimeAgo($timestamp) ?> 
									<a class="text-decoration-none">
										<?php echo $baiViet['taiKhoan'] ?>
									</a>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 my-auto">
					<div class="row">
						<div class="col-md-3 text-center my-auto">
							<p>Bình luận</p>
							<p>Lượt xem</p>
						</div>
						<div class="col-md-3 text-center my-auto">
							<p><?php echo $soLuongThaoLuan;?></p>
							<p><?php echo $baiViet['luotXem'];?></p>
						</div>
						<div class="col-md-6 my-auto text-center">
							<div class="row my-auto">
								<?php if($timestamptwo != NULL){ 
									echo '
								<div class="col-md-7 my-auto">
									<div class="row" style="text-align:right;">
										<a class="text-decoration-none" href="chitietbaiviet.php?maBV='.$baiViet['maBV'].'#comment-'.$thaoLuanMoiNhat['maTLBV'].'" title="">
										'.$tienIch->formatTimeAgo($timestamptwo).'
										</a>
										<label>
											<a class="text-decoration-none">
												'.$thaoLuanMoiNhat['taiKhoan']
											.'</a>
										</label>
									</div>
								</div>
								<div class="col-md-5 my-auto">
									<img src="../image/images.png" class="rounded d-block" style="width:3em" alt="...">
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
		</div>	
	<?php } ?>
	</div>
</div>

<div class="card col-md-3">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include("../inc/footer.php"); ?>
