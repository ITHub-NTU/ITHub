	<?php
	class TrangChu {    
		private $tblTaiLieuYeuThich = 'tbltlyeuthich';
		private $tblTaiLieu = 'tbltailieu';
		private $tblBaiViet = 'tblbaiviet';
		private $tblNguoiDung = 'tblnguoidung';
		private $tblBaiVietYeuThich = 'tblbvyeuthich';
		private $conn;
		
		public function __construct($db){
			$this->conn = $db;
		}   

		public function layDanhSachTaiLieuYeuThich(){    
			$sqlQuery = "SELECT *  FROM $this->tblTaiLieuYeuThich TLYT
			INNER JOIN $this->tblTaiLieu TL ON TLYT.maTL = TL.maTL
			GROUP BY TL.tenTL
			ORDER BY TL.maTL DESC
			LIMIT 2";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_all(MYSQLI_ASSOC);
		}
		public function layDanhSachBaiVietYeuThich(){    
			$sqlQuery = "SELECT *  FROM $this->tblBaiVietYeuThich BVYT
			INNER JOIN $this->tblBaiViet BV ON BVYT.maBV = BV.maBV
			GROUP BY BV.tenBV
			ORDER BY BV.maBV DESC
			LIMIT 2";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_all(MYSQLI_ASSOC);
		}
	
	}
?>