<?php
    class LoaiTaiLieu{
        private $tblLoaiTL = 'tblloaitailieu';
        private $tbltailieu = 'tbltailieu';
        private $tbldinhdangtl = 'tbldinhdangtl';
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        } 

        public function layDSLoaiTaiLieu(){
            $sqlQuery = "SELECT * FROM `" . $this->tblLoaiTL . "` ORDER BY tenLoaiTL ASC";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }
        
        

        public function layLoaiTaiLieu(){
            if($this->maLoaiTL){
                $sqlQuery = "
                    SELECT tenLoaiTL
                    FROM `".$this->tblLoaiTL."`
                    WHERE maLoaiTL = '".$this->maLoaiTL."' ";
                           
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->execute();
                $result = $stmt->get_result();
                $categoryDetails = $result->fetch_assoc();
                return $categoryDetails;
            }
        }
        
        // public function themTaiLieu($maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL, $ngayDuyetTL) {
	// 	$query = "INSERT INTO " . $this->tbltailieu . " (maTL, maLoaiTL, taiKhoan, maDD, tenTL, moTaTL, fileTL, trangThaiTL, ngayDuyetTL) 
	// 			  VALUES ('$maTL','$maLoaiTL', '$taiKhoan', '$maDD', '$tenTL', '$moTaTL', '$fileTL', '$trangThaiTL', '$ngayDuyetTL')";
	
	// 	$stmt = $this->conn->prepare($query);
	
	// 	if ($stmt->execute()) {
	// 		return true;
	// 	}
	
	// 	return false;
	// }
    public function themTaiLieu($maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL, $ngayDuyetTL) {
        $query = "INSERT INTO " . $this->tbltailieu . " (maTL, maLoaiTL, taiKhoan, maDD, tenTL, moTaTL, fileTL, trangThaiTL, ngayDuyetTL) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssssss", $maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL, $ngayDuyetTL);

        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }


    }

?>