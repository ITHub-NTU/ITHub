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
	if(isset($_SESSION['taiKhoan'])){
		$tblChuDeBV->taiKhoan = $_SESSION['taiKhoan'];
		$tblChuDeBV->maCDTD = $maCD;
		$theodoi = $tblChuDeBV->kiemTraTheoDoiChuDe();
	}
	else
		$theodoi = false;
	if(isset($_POST['theodoichude'])){
		if(isset($_SESSION['taiKhoan'])){
			$maCD = $_POST['theodoichude'];
			$tblChuDeBV->maCDTD = $maCD;
			$tblChuDeBV->taiKhoan = $_SESSION['taiKhoan'];
			$tblChuDeBV->maCDTD = $maCD;
			$tblChuDeBV->thayDoiTheoDoiChuDe($theodoi);
			$theodoi = $tblChuDeBV->kiemTraTheoDoiChuDe();
		}
		else{
			header('Location: ../nguoidung/dangnhap.php');
		}
	}
	
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
					<div class="card  mb-2" style="background-color: #DADDE1;">
						<div class="card-body">
							<div class="row">
								<div class="col-10">
									<div style="font-weight: bold">Bài viết đang chờ</div>
									<div>'.$soLuong.' bài viết</div>
								</div>
								<div class="col-2 m-auto">
									<form method="get" action="quanlibaivietchoduyet.php">
										<input name="maCDBV" hidden value="'.$maCD.'"/>
										<button type="submit" class="btn btn-primary">Quản lí bài viết</button>
									</form>
									
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
			<h5 class="" ><?php echo $chuDeBV['tenCD']?> </h5>
			<h5 style="font-weight:unset">&nbsp;[ <?php $soLuong = $tblChuDeBV->laySoLuongNguoiTheoDoiCD($maCD ); 
						$resultSoLuong = $soLuong->fetch_assoc();
			echo $resultSoLuong['soLuong']?> người theo dõi ]
			</h5>
			<?php 
				if(isset($_SESSION['taiKhoan'])){
					if($theodoi){
						echo '
						<form method="post" style="margin-left: auto">
							<button class="btn btn-success " value ="'.$maCD.'" name="theodoichude">Hủy theo dõi</button>
						</form>
						';
					}
					else{
						echo '
						<form method="post" style="margin-left: auto">
							<button class="btn btn-success " value ="'.$maCD.'" name="theodoichude">Theo dõi</button>
						</form>
						';
					}
				}
				else{
					echo '
						<form method="post" style="margin-left: auto">
							<button class="btn btn-success " value ="'.$maCD.'" name="theodoichude">Theo dõi</button>
						</form>
						';
				}
			?>
		</div>
	
	<?php
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
							<img src="../image/<?php echo $baiViet['anhDaiDien'];?>" class=" m-3 d-block" style="width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;" alt="...">
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
								<div class="col-md-6 my-auto">
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
								<div class="col-md-6 my-auto">
									<img src="../image/'.$thaoLuanMoiNhat['anhDaiDien']
									.'" class=" d-block" style="width: 80px;
										height: 80px;
										object-fit: cover;
										border-radius: 50%;" alt="...">
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

<div class="col-md-3" id="rightmenu">
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include("../inc/footer.php"); ?>
