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
  				AND t.trangThaiBV = 'daduyet'
  				ORDER BY t.maBV DESC";
  
  			$stmt = $this->conn->prepare($sqlQuery);
  			$stmt->execute();
  			$result = $stmt->get_result();			
  			return $result;	
  		}
  	}
	
  	public function layBaiViet(){
  		if($this->maBV) {
  			$sqlQuery = "
  				SELECT *
  				FROM ".$this->tblBaiViet." 
  				WHERE maBV = '".$this->maBV."'";
  			
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
				WHERE t.maCD = '".$this->maCDKD."' and t.trangThaiBV = 'chuaduyet'
				ORDER BY t.ngayDangBV";			
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();			
			return $result;	
		}
	}
	public function duyetBaiViet(){
		if($this->maBV){
			$queryUpdateStatus = "UPDATE tblbaiviet SET trangThaiBV = 'daduyet', ngayDuyetBV = CURRENT_TIMESTAMP() WHERE maBV = '".$this->maBV."'";
			$stmt = $this->conn->prepare($queryUpdateStatus);
			if ($stmt->execute()) {
				return true;
			}
			return false;
		}
	}
	public function xoaBaiViet(){
		if ($this->maBV) {
			$this->conn->begin_transaction();
	
			try {
				
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
  }
?>