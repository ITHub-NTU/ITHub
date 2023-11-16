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
			INNER JOIN $this->tblNguoiDung NG ON TLYT.taiKhoan = NG.taiKhoan
			WHERE trangThaiTL = 'daduyet'
			GROUP BY TL.tenTL
			ORDER BY TL.maTL DESC
			LIMIT 5";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_all(MYSQLI_ASSOC);
		}
		public function layDanhSachBaiVietYeuThich(){    
			$sqlQuery = "SELECT *  FROM $this->tblBaiVietYeuThich BVYT
			INNER JOIN $this->tblBaiViet BV ON BVYT.maBV = BV.maBV
			INNER JOIN $this->tblNguoiDung NG ON BVYT.taiKhoan = NG.taiKhoan
			WHERE trangThaiBV = 'daduyet'
			GROUP BY BV.tenBV
			ORDER BY BV.maBV DESC
			LIMIT 5";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_all(MYSQLI_ASSOC);
		}
		public function themTaiLieuYeuThich($maTL, $taiKhoan) {
			$query = "INSERT INTO " . $this->tbltailieu . " (maTL, taiKhoan) 
			  VALUES (?, ?)";
	
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param("ss", $maTL, $taiKhoan);
	
			
			if ($stmt->execute()) {
				return true;
			}
			
			return false;
		}
		public function getTaiLieuMoiNhat() {
			$sqlQuery = "SELECT * FROM $this->tblTaiLieu TL
			INNER JOIN $this->tblNguoiDung NG ON TL.taiKhoan = NG.taiKhoan
			WHERE trangThaiTL = 'daduyet' ORDER BY maTL DESC LIMIT 10";
			
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_all(MYSQLI_ASSOC);
		}

		public function getBaiVietMoiNhat() {
			$sqlQuery = "SELECT * FROM $this->tblBaiViet BV
			INNER JOIN $this->tblNguoiDung NG ON BV.taiKhoan = NG.taiKhoan
			WHERE trangThaiBV = 'daduyet' ORDER BY maBV DESC LIMIT 10";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_all(MYSQLI_ASSOC);
		}
	}
	?>
