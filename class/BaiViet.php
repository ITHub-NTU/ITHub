<?php
	class BaiViet {	
	
		private $tblBaiViet = 'tblbaiviet';
		private $tblNguoiDung = 'tblnguoidung';
		private $tblThaoLuanBV = 'tblthaoluanbv';
		private $conn;
		
		public function __construct($db){
			$this->conn = $db;
		}	
		
		public function layDanhSachBaiViet(){	
			if($this->maCD) {
				$sqlQuery = "
					SELECT t.*, c.taiKhoan, c.anhDaiDien
					FROM ".$this->tblBaiViet." as t 
					LEFT JOIN ".$this->tblNguoiDung." as c ON t.taiKhoan = c.taiKhoan
					WHERE t.maCD = '".$this->maCD."'
					AND (t.trangThaiBV = 'daduyet' OR t.trangThaiBV = 'dachinhsua')
					ORDER BY t.maBV DESC";

				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();			
				return $result;	
			}
		}
		
		//Chỉnh sửa 
		public function layBaiViet(){
			if($this->maBV) {
				$sqlQuery = "
					SELECT `tblbaiviet`.*, `tblnguoidung`.`quyen`, `tblnguoidung`.`anhDaiDien`
					FROM ".$this->tblBaiViet.", `tblnguoidung` 
					WHERE tblbaiviet.taiKhoan = tblnguoidung.taiKhoan 
					and  maBV = '".$this->maBV."'";
				
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();	
				$topicDetails = $result->fetch_assoc();			
				return $topicDetails;	
			}
		}
		
		public function laySoLuongThaoLuan(){
			if($this->maBV) {
				$sqlQuery = "
				SELECT COUNT(*) AS soLuongThaoLuan 
				FROM ".$this->tblThaoLuanBV."
				WHERE maBV = '".$this->maBV."'";
				
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();	
				$categoryDetails = $result->fetch_assoc();			
				return $categoryDetails['soLuongThaoLuan'];	
			}
		}

		public function layThaoLuanMoiNhat(){
			if($this->maBV) {
				$sqlQuery = "
				SELECT a.*, b.tenBV AS tenBaiViet, c.anhDaiDien 
				FROM ".$this->tblThaoLuanBV." AS a 
				JOIN ".$this->tblBaiViet." AS b ON a.maBV = b.maBV 
				JOIN ".$this->tblNguoiDung." AS c ON b.taiKhoan = c.taiKhoan 
				WHERE b.maBV = '".$this->maBV."'
				ORDER BY a.ngayDangTLBV DESC LIMIT 1";    
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();    
				$categoryDetails = $result->fetch_assoc();            
				return $categoryDetails;
			}
		}

		public function themLuotXem() {
			if ($this->maBV) {
				$sqlQuery = "
					UPDATE {$this->tblBaiViet} 
					SET luotXem = luotXem + 1
					WHERE maBV = ?";
		
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->bind_param("s", $this->maBV);
		
				if ($stmt->execute()) {
					$stmt->close();
					return true;
				} else {
					$stmt->close();
					return false;
				}
			}
		}
		
		public function themBaiViet($maBV,$maCD, $taiKhoan, $tenBV, $noiDungBV, $trangThaiBV, $ngayDuyetBV, $ngayChinhSuaBV) {
			$query = "INSERT INTO " . $this->tblBaiViet . " (maBV, maCD, taiKhoan, tenBV, noiDungBV, trangThaiBV, ngayDuyetBV, ngayChinhSuaBV) 
					VALUES ('$maBV','$maCD', '$taiKhoan', '$tenBV', '$noiDungBV', '$trangThaiBV', '$ngayDuyetBV', '$ngayChinhSuaBV')";
		
			$stmt = $this->conn->prepare($query);
		
			if ($stmt->execute()) {
				return true;
			}
			return false;
		}
		public function layDanhSachBaiVietKiemDuyet(){
			if($this->maCDKD) {
				$sqlQuery = "
					SELECT t.*, c.taiKhoan, c.anhDaiDien		
					FROM ".$this->tblBaiViet." as t 
					LEFT JOIN ".$this->tblNguoiDung." as c ON t.taiKhoan = c.taiKhoan
					WHERE t.maCD = '".$this->maCDKD."' and (t.trangThaiBV = 'chuaduyet' or t.trangThaiBV = 'chinhsua')
					ORDER BY t.ngayDangBV";			
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();			
				return $result;	
			}
		}
		public function duyetBaiViet() {
			if ($this->maBV) {
				$queryUpdateStatus = "UPDATE tblbaiviet SET ";
				switch ($this->trangThaiBV) {
					case 'choduyet':
						$queryUpdateStatus .= "trangThaiBV = 'daduyet', ";
						break;
					case 'chinhsua':
						$queryUpdateStatus .= "trangThaiBV = 'dachinhsua', ";
						break;
					default:
						return false;
				}
		
				// Thêm phần cập nhật ngày duyệt
				$queryUpdateStatus .= "ngayDuyetBV = CURRENT_TIMESTAMP() WHERE maBV = '".$this->maBV."'";
		
				$stmt = $this->conn->prepare($queryUpdateStatus);
				if ($stmt->execute()) {
					return true;
				}
				return false;
			}
			return false; // Trả về false nếu không có $maBV
		}
		
		public function xoaBaiViet(){
			if ($this->maBV) {
				$this->conn->begin_transaction();
				try {
					$querydeletebookmark = "DELETE FROM tblbvyeuthich WHERE maBV = ?";
					$stmtbookmark = $this->conn->prepare($querydeletebookmark);
					$stmtbookmark->bind_param('s', $this->maBV);
					$stmtbookmark->execute();	
					
					$queryDeleteComments = "DELETE FROM tblthaoluanbv WHERE maBV = ?";
					$stmtComments = $this->conn->prepare($queryDeleteComments);
					$stmtComments->bind_param('s', $this->maBV);
					$stmtComments->execute();

					$queryDeleteReports = "DELETE FROM tblbvvipham WHERE maBV = ?";
					$stmtReports = $this->conn->prepare($queryDeleteReports);
					$stmtReports->bind_param('s', $this->maBV);
					$stmtReports->execute();
		
					$queryDeleteBV = "DELETE FROM tblbaiviet WHERE maBV = ?";
					$stmtBV = $this->conn->prepare($queryDeleteBV);
					$stmtBV->bind_param('s', $this->maBV);
					$stmtBV->execute();
					$this->conn->commit();
		
					return true;
				} catch (Exception $e) {
					$this->conn->rollback();
					return false;
				}
			}
		}
		public function baoCaoBaiViet(){
			if($this->maBV && $this->maLoaiVP && $this->taiKhoan){
				$sqlQuery = "
					INSERT IGNORE INTO `tblbvvipham` (`maBV`, `maLoaiVP`, `taiKhoan`) 
					VALUES ('".$this->maBV."', '". $this->maLoaiVP."', '". $this->taiKhoan."');
				";
				$stmt = $this->conn->prepare($sqlQuery);
				if ($stmt->execute()) {
					return true;
				}
				return false;
			}
		}

		public function layMaBVVaSoLuong(){
			if($this->maCDKD) {
				$sqlQuery = "
					SELECT t.maBV, COUNT(v.maBV) AS soLuong
					FROM tblbaiviet AS t
					INNER JOIN tblbvvipham AS v ON t.maBV = v.maBV
					WHERE t.maCD = '".$this->maCDKD."'
					GROUP BY t.maBV;
				";			
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();			
				return $result;	
			}
		}

		public function layThongTinBaiVietBiBaoCao(){
			if($this->maBVBC) {
				$sqlQuery = "
					SELECT  * FROM tblbaiviet 
					WHERE maBV = '".$this->maBVBC."'
					;
				";			
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();			
				return $result;	
			}
		}
		public function boQuaBaiVietBiBaoCao(){
			if($this->maBV){
				$queryUpdateStatus = "DELETE FROM tblbvvipham WHERE maBV = '".$this->maBV."'";
				$stmt = $this->conn->prepare($queryUpdateStatus);
				if ($stmt->execute()) {
					return true;
				}
				return false;
			}
		}

		public function layNguoiDungBaoCao(){
			if($this->maBV){
				$query = "SELECT bvvp.taiKhoan, GROUP_CONCAT(lvp.tenLoaiVP) AS danhSachLoaiVP
				FROM tblbvvipham bvvp
				INNER JOIN tblloaivipham lvp ON bvvp.maLoaiVP = lvp.maLoaiVP
				WHERE bvvp.maBV = '".$this->maBV."'
				GROUP BY bvvp.taiKhoan";
				$stmt = $this->conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				return $result;
			}
		}
		// new update
		public function getBookmarkTaiKhoan() {
			if ($this->taiKhoan && $this->maBV) {
				$query = "SELECT *
						FROM TblBVYeuThich
						WHERE taiKhoan = ? AND maBV = ?";
				$stmt = $this->conn->prepare($query);
				$stmt->bind_param("ss", $this->taiKhoan, $this->maBV);
				if ($stmt->execute()) {
					$result = $stmt->get_result();
					if ($result->num_rows > 0) {
						// Dữ liệu đã tồn tại, lấy nó và kiểm tra với $this->maBV
						$row = $result->fetch_assoc();
						if ($row['maBV'] == $this->maBV) {
							return true;
						}
						return false;
					}
				}
			}
			return false; // Trường hợp không có dữ liệu hoặc nếu $this->taiKhoan hoặc $this->maBV không có giá trị
		}
		public function changeBookmark($bookmark) {
			if ($this->taiKhoan && $this->maBVBK) {
				if ($bookmark) {
					// Xóa dữ liệu từ bảng TblBVYeuThich nếu $bookmark là true
					$query = "DELETE FROM TblBVYeuThich WHERE taiKhoan = ? AND maBV = ?";
				} else {
					// Thêm dữ liệu vào bảng TblBVYeuThich nếu $bookmark là false
					$query = "INSERT INTO TblBVYeuThich (taiKhoan, maBV) VALUES (?, ?)";
				}
				
				$stmt = $this->conn->prepare($query);
				$stmt->bind_param("ss", $this->taiKhoan, $this->maBVBK);
				
				if ($stmt->execute()) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		public function SoLuongBaiVietDangCho(){
			if($this->taiKhoan && $this->maCD){
				$query = "SELECT COUNT(*) FROM `tblbaiviet` WHERE taiKhoan = '".$this->taiKhoan."' AND maCD = '".$this->maCD."' AND (trangThaiBV = 'chuaduyet' OR trangThaiBV = 'chinhsua')";
				$stmt = $this->conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				return $result;
			}
		}
		//new 
		public function kiemTraQuyenChinhSua(){
			if ($this->taiKhoan && $this->maBV) {
				$query = "SELECT * FROM tblbaiviet WHERE taiKhoan = '".$this->taiKhoan."' AND maBV = '".$this->maBV."'";
				$stmt = $this->conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					return true;
				} else {
					return false;
				}
			}
		}
		
		public function chinhSuaBaiViet($tenBV, $noiDungBV){
			if($this->maBV){
				$query = "UPDATE tblbaiviet
						SET tenBV = '".$tenBV."',noiDungBV = '".$noiDungBV."', trangThaiBV = 'chinhsua', ngayChinhSuaBV = NOW()
						WHERE maBV = '".$this->maBV."';
				";
				$stmt = $this->conn->prepare($query);
				if ($stmt->execute()) {
					return true;
				}
				else {
					return false;
				}
			}
		}
		public function layDanhSachBaiVietDangChoDuyet($maCDBV, $taiKhoan){
			$sqlQuery = "
				SELECT t.*, c.taiKhoan, c.anhDaiDien, c.quyen
				FROM ".$this->tblBaiViet." AS t
				LEFT JOIN ".$this->tblNguoiDung." AS c ON t.taiKhoan = c.taiKhoan
				WHERE t.maCD = '".$maCDBV."' AND (t.trangThaiBV = 'chuaduyet' OR t.trangThaiBV = 'chinhsua' ) AND c.taiKhoan = '".$taiKhoan."'
				ORDER BY t.ngayDangBV;
			";            
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();            
			return $result;    
		}
		
		public function layTongBaiViet(){
			$sqlQuery = "
				SELECT COUNT(*) AS soLuongBV 
				FROM ".$this->tblBaiViet."
				WHERE trangThaiBV = 'daduyet' or trangThaiBV = 'dachinhsua'";
				
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();	
				$soLuongBV = $result->fetch_assoc();			
				return $soLuongBV['soLuongBV'];	
		}

		public function layTongThaoLuan(){
			$sqlQuery = "
				SELECT COUNT(*) AS soLuongThaoLuan 
				FROM ".$this->tblThaoLuanBV."";
				
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();	
				$tongThaoLuan = $result->fetch_assoc();			
				return $tongThaoLuan['soLuongThaoLuan'];	
		}
	}
?>