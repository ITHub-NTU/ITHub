<?php
	
	class ThaoLuanBV {	
   
		private $tblThaoLuanBV = 'tblthaoluanbv';
		private $tblNguoiDung = 'tblnguoidung';
		private $tblBaiViet = 'tblbaiviet';
		private $conn;
		
		public function __construct($db){
			$this->conn = $db;
		}	
	
		public function layDanhSachThaoLuanBV(){	
			if($this->maBV) {
				$sqlQuery = "
				SELECT a.*, b.anhDaiDien, b.quyen
				FROM ".$this->tblThaoLuanBV." as a
				JOIN tblnguoidung AS b ON a.taiKhoan = b.taiKhoan 
				WHERE a.maBV = '".$this->maBV."'
				ORDER BY a.ngayDangTLBV ASC";			
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();			
				return $result;	
			}
		}
	
		public function layThaoLuanPhanHoiBV(){	
			if($this->maPhanHoi) {
				$sqlQuery = "
				SELECT *
				FROM ".$this->tblThaoLuanBV."
				WHERE maTLBV = '".$this->maPhanHoi."'";		
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();			
				return $result;	
			}
		}
	
		public function layThaoLuanBV(){
			if($this->maTLBV_reply){
				$sqlQuery = 'SELECT * FROM tblthaoluanbv';
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();	
				return $result;	
			}
		}
		public function layThaoLuanReply(){
			if($this->maTLBV_reply_2)
			{
				$sqlQuery = "SELECT * FROM tblthaoluanbv WHERE maTLBV = '".$this->maTLBV_reply_2."' " ;
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();	
				if ($result->num_rows > 0) {
					$userInfo = $result->fetch_assoc();
					return $userInfo;
				} else {
					return null;
				}	
			}
		}
		public function baoCaoThaoLuanBaiViet(){
			if($this->maTLBV && $this->maLoaiVP && $this->taiKhoan){
				$sqlQuery = "
					INSERT IGNORE INTO `tbltlbvvipham` (`maTLBV`, `maLoaiVP`, `taiKhoan`) 
					VALUES ('".$this->maTLBV."', '". $this->maLoaiVP."', '". $this->taiKhoan."');
				";
				$stmt = $this->conn->prepare($sqlQuery);
				if ($stmt->execute()) {
					return true;
				}
				return false;
			}
		}
		public function layDanhSachThaoLuanBiCaoCao(){
			if($this->maCDKD){
				$sqlQuery = "
							SELECT
							TLBV.maTLBV,
							TLBV.maBV,
							TLBV.taiKhoan,
							TLBV.noiDungTLBV,
							LV.tenLoaiVP,
							TLBV.ngayDangTLBV,
							COUNT(TLBVVP.maTLBV) AS SoLuongBaoCao
						FROM TblThaoLuanBV TLBV
						LEFT JOIN TblTLBVViPham TLBVVP ON TLBV.maTLBV = TLBVVP.maTLBV
						INNER JOIN TblLoaiViPham LV ON TLBVVP.maLoaiVP = LV.maLoaiVP
						LEFT JOIN TblBaiViet BV ON TLBV.maBV = BV.maBV
						WHERE TLBV.maBV IN (
							SELECT maBV
							FROM TblBaiViet
							WHERE maCD = '".$this->maCDKD."'
						)
						GROUP BY TLBV.maTLBV
						ORDER BY SoLuongBaoCao DESC;
				";			
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();			
				return $result;	
			}
		}
		public function layThaoLuanBiBaoCao(){
			if($this->maTLBVBC){
				$sqlQuery = "
								SELECT * FROM tblthaoluanbv  
								WHERE maTLBV = '".$this->maTLBVBC."'
				";
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();			
				return $result;
			}
		}
		public function layNguoiDungBaoCao(){
			if($this->maTLBVBC){
				$query = "SELECT bvvp.taiKhoan, GROUP_CONCAT(lvp.tenLoaiVP) AS danhSachLoaiVP
				FROM tbltlbvvipham bvvp
				INNER JOIN tblloaivipham lvp ON bvvp.maLoaiVP = lvp.maLoaiVP
				WHERE bvvp.maTLBV = '".$this->maTLBVBC."'
				GROUP BY bvvp.taiKhoan";
	
				$stmt = $this->conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				return $result;
			}
		}	
		public function xoaThaoLuanViPham(){
			if ($this->maTLBVBC) {
				$this->conn->begin_transaction();
		
				try {
					// Xóa báo cáo thảo luận vi phạm
					$queryDeleteReports = "DELETE FROM tbltlbvvipham WHERE maTLBV = ?";
					$stmtReports = $this->conn->prepare($queryDeleteReports);
					$stmtReports->bind_param('s', $this->maTLBVBC);
					$stmtReports->execute();
		
					// Xóa thảo luận vi phạm
					$queryDeleteTLBV = "DELETE FROM tblthaoluanbv WHERE maTLBV = ?";
					$stmtTLBV = $this->conn->prepare($queryDeleteTLBV);
					$stmtTLBV->bind_param('s', $this->maTLBVBC);
					$stmtTLBV->execute();
					
					$this->conn->commit();
		
					return true;
				} catch (Exception $e) {
					$this->conn->rollback();
					return false;
				}
			}
		}
		public function boQuaThaoLuanBiBaoCao(){
			if($this->maTLBVBC){
				$queryDeleteReports = "DELETE FROM tbltlbvvipham WHERE maTLBV = ?";
				$stmt = $this->conn->prepare($queryDeleteReports);
				$stmt->bind_param('s', $this->maTLBVBC);
		
				if ($stmt->execute()) {
					return true;
				}
				return false;
			}
		}
	
	}
?>
