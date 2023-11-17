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
<link rel="stylesheet" href="../inc/main.css">
<style>
	.m-ltb-auto{
		margin-left: auto;
		margin-top: auto;
		margin-bottom: auto;
	}
</style>
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
								<div class="col-md-7 col-xs-6">
									<div style="font-weight: bold">Bài viết đang chờ</div>
									<div>'.$soLuong.' bài viết</div>
								</div>
								<div  class="col-md-5 col-xs-6 m-auto d-flex justify-content-end">
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
	
	<div class="card" >
		<div class="d-flex card-header " style="background-color:cadetblue;">
			<div>
			<h5 class=""  ><?php echo $chuDeBV['tenCD']?> </h5>
			<h5 style="font-weight:unset; font-size: 16px">[ <?php $soLuong = $tblChuDeBV->laySoLuongNguoiTheoDoiCD($maCD ); 
						$resultSoLuong = $soLuong->fetch_assoc();
			echo $resultSoLuong['soLuong']?> người theo dõi ]
			</h5>
			</div>
			<?php 
				if(isset($_SESSION['taiKhoan'])){
					if($theodoi){
						echo '
						<form method="post" class="m-ltb-auto" >
							<button class="btn btn-success " value ="'.$maCD.'" name="theodoichude">Hủy theo dõi</button>
						</form>
						';
					}
					else{
						echo '
						<form method="post" class="m-ltb-auto" >
							<button class="btn btn-success " value ="'.$maCD.'" name="theodoichude">Theo dõi</button>
						</form>
						';
					}
				}
				else{
					echo '
						<form method="post" class="m-ltb-auto">
							<button class="btn btn-success " value ="'.$maCD.'" name="theodoichude">Theo dõi</button>
						</form>
						';
				}
			?>
		</div>
	
		<?php
			$tblBaiViet->maCD = $_GET['maCD'];
			//Phân trang 
				$resultsPerPageBV = 8;
				//Lưu biến trang Bài viết
				if (isset($_GET['pageBV']) && is_numeric($_GET['pageBV'])) {
					$pageBV = $_GET['pageBV'];
				} else {
					$pageBV = 1;
					$_GET['pageBV'] = 1;
				}
				// Tính toán OFFSET cho LIMIT trong truy vấn SQL
				$offsetBV = ($pageBV - 1) * $resultsPerPageBV;

			$result = $tblBaiViet->layDanhSachBaiViet($resultsPerPageBV, $offsetBV);
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
			<div class="row p-2">
				<div class="col-lg-1 col-sm-2 col-m-2">
					<img src="../image/<?php echo $baiViet['anhDaiDien'];?>" style="width: 60px;
								height: 60px;
								object-fit: cover;
								border-radius: 50%;" alt="...">
				</div>
				<div class="col-lg-6 col-sm-10 col-m-10 pl-5">
					<div >
						<div>
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
						</div>
						<div>
							<?php echo $tienIch->formatTimeAgo($timestamp) ?> 
							<a class="text-decoration-none">
								<?php echo $baiViet['taiKhoan'] ?>
							</a>
						</div>
					</div>
				</div>
				<div class="col-lg-5 col-sm-12 ">
					<div class="row">
						<div class="col-lg-4 col-sm-3 col-m-4">
							<div>
								Bình luận: <?php echo $soLuongThaoLuan;?>
							</div>
							<div>
								Lượt xem: <?php echo $baiViet['luotXem'];?>
							</div>
						</div>
						<div class="col-lg-8 col-sm-9 col-m-8">
							<?php if($timestamptwo != NULL){ 
								echo '
									<div style="display: flex">
										<div style="width: 82%; text-align: right; padding-right: 5px">
											<a class="text-decoration-none" href="chitietbaiviet.php?maBV='.$baiViet['maBV'].'#comment-'.$thaoLuanMoiNhat['maTLBV'].'" title="">
											'.$tienIch->formatTimeAgo($timestamptwo).'
											</a>
											<div>
												<a class="text-decoration-none">
													'.$thaoLuanMoiNhat['taiKhoan']
												.'</a>
											</div>
										</div>
										<div style="width: 18%">
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
		<!-- Hiển thị phân trang -->
		<nav aria-label="Page navigation document d-flex ">
			<ul class="pagination mt-3 justify-content-center ">
				<?php 
					$numRowsPage = $tblBaiViet->laySoLuongBVTheoCD($maCD);
					if($numRowsPage % $resultsPerPageBV == 0){
						$maxPageBV = $numRowsPage/$resultsPerPageBV;
					}
					else
						$maxPageBV = floor($numRowsPage/$resultsPerPageBV) + 1;
					if ($pageBV > 1){
						echo "<li class='page-item'><a class='page-link' class='page-link' href='" .$_SERVER['PHP_SELF']."?maCD=".$maCD."&pageBV=".($pageBV-1)."'>Trước</a></li> "; //gắn thêm nút Back
					}
					for ($i=1 ; $i<=$maxPageBV ; $i++)
					{
						if ($i == $pageBV)
						{
							echo '<li class="page-item"><b class="page-link">Trang'.$i.'</b> </li> '; //trang hiện tại sẽ được bôi đậm
						}
						else {
							echo "<li class='page-item'><a class='page-link'  href='" . $_SERVER['PHP_SELF'] . "?maCD=".$maCD."&pageBV=".($i)."'>Trang " . $i . "</a></li> ";
						}
					}
					if ($pageBV < $maxPageBV) {
						echo "<li class='page-item'><a class='page-link' href='" . $_SERVER['PHP_SELF'] . "?maCD=".$maCD."&pageBV=".($pageBV+1)."'>Tiếp</a></li>";  //gắn thêm nút Next
					}
				?>
			</ul>
		</nav>
	</div>
</div>

<div class="col-md-3" id="rightmenu">
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include("../inc/footer.php"); ?>
