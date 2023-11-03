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
				SELECT *
				FROM ".$this->tblThaoLuanBV."
				WHERE maBV = '".$this->maBV."'
				ORDER BY ngayDangTLBV ASC";			
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
	}
?>
