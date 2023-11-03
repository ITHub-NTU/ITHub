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
  }
?>
