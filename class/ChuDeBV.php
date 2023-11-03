<?php
	class ChuDeBV {	
	
		private $tblChuDeBV = 'tblchudebv';
		private $tblBaiViet = 'tblbaiviet';
		private $tblThaoLuanBV = 'tblthaoluanbv';
		private $tblNguoiDung = 'tblnguoidung';
		private $tblQuanTriBV = 'tblquantribv';
		private $conn;
		
		public function __construct($db){
			$this->conn = $db;
		}	
		
		public function layDSChuDeBV(){		
			$sqlQuery = "
				SELECT *
				FROM ".$this->tblChuDeBV." ORDER BY tenCD ASC";
			
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();			
			return $result;	
		}
		
		public function layChuDeBV(){
			if($this->maCD) {
				$sqlQuery = "
					SELECT tenCD
					FROM ".$this->tblChuDeBV." 
					WHERE maCD = '".$this->maCD."'";
				
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();	
				$categoryDetails = $result->fetch_assoc();			
				return $categoryDetails;	
			}
		}
		
		public function laySoLuongBaiViet(){
			if($this->maCD) {
				$sqlQuery = "
					SELECT count(*) as soLuongBV
					FROM ".$this->tblChuDeBV." as p
					LEFT JOIN ".$this->tblBaiViet." as t ON p.maCD = t.maCD
					WHERE p.maCD = '".$this->maCD."'
					AND t.trangThaiBV = 'daduyet'";
				
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();    
				$categoryDetails = $result->fetch_assoc();            
				return $categoryDetails['soLuongBV'];    
			}
		}

		public function laySoLuongThaoLuan(){
			if($this->maCD) {
				$sqlQuery = "
					SELECT count(t.maTLBV) as soLuongTLBV
					FROM ".$this->tblChuDeBV." as p
					LEFT JOIN ".$this->tblBaiViet." as c ON p.maCD = c.maCD
					LEFT JOIN ".$this->tblThaoLuanBV." as t ON c.maBV = t.maBV
					WHERE c.maCD = '".$this->maCD."'";			
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();	
				$categoryDetails = $result->fetch_assoc();			
				return $categoryDetails['soLuongTLBV'];	
			}
		}

		public function layThaoLuanMoiNhat(){
			if($this->maCD) {
				$sqlQuery = "
				SELECT a.*, b.tenBV AS tenBaiViet, c.anhDaiDien 
				FROM ".$this->tblThaoLuanBV." AS a 
				JOIN ".$this->tblBaiViet." AS b ON a.maBV = b.maBV 
				JOIN ".$this->tblNguoiDung." AS c ON b.taiKhoan = c.taiKhoan 
				WHERE b.maCD = '".$this->maCD."'
				ORDER BY a.ngayDangTLBV DESC LIMIT 1";    
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();    
				$categoryDetails = $result->fetch_assoc();            
				return $categoryDetails;
			}
		}
	}
?>