<?php 

class TaiLieu {
    private $conn;
	private $tbltailieu = 'tbltailieu';
    private $tblloaitailieu = 'tblloaitailieu';
    private $tbldinhdangtl = 'tbldinhdangtl';

	public function __construct($db){
        $this->conn = $db;
    }
    
    public function getTaiLieu($sort = '', $order = '') {
        $sql = "SELECT *
                FROM $this->tbltailieu TL
                INNER JOIN $this->tblloaitailieu LTL ON TL.maLoaiTL = LTL.maLoaiTL
                INNER JOIN $this->tbldinhdangtl DDTL ON TL.maDD = DDTL.maDD";
        $sql .= " GROUP BY TL.maTL";
        if (!empty($sort) && !empty($order)) {
            if ($sort == 'ngayDangTL') {
                $sort = 'TL.ngayDangTL'; // Update the column name here
            }
            $sql .= " ORDER BY $sort $order";
        }
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('Error in SQL query: ' . $this->conn->error);
        }
        $stmt->execute();
        if ($stmt->error) {
            die('Error in query execution: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        return $result;
    }
    public function getLoaiTaiLieu()
    {
        $query = "SELECT * FROM tblloaitailieu";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getTaiLieuBymaLoaiTL() {
        if ($this->maLoaiTL) {
            $query = $query = "SELECT *
                FROM $this->tbltailieu TL
                INNER JOIN $this->tblloaitailieu LTL ON TL.maLoaiTL = LTL.maLoaiTL
                INNER JOIN $this->tbldinhdangtl DDTL ON TL.maDD = DDTL.maDD
                WHERE TL.maLoaiTL = ?
                GROUP BY TL.maTL";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $this->maLoaiTL);
            $stmt->execute();
            $result = $stmt->get_result();
            $taiLieus = array();
            while ($row = $result->fetch_assoc()) {
                $taiLieus[] = $row;
            }
            return $taiLieus;
        }
    }
    public function getChiTietTaiLieu() {
       if($this->maTL){
        $query = "SELECT *
                FROM $this->tbltailieu TL
                INNER JOIN $this->tblloaitailieu LTL ON TL.maLoaiTL = LTL.maLoaiTL
                INNER JOIN $this->tbldinhdangtl DDTL ON TL.maDD = DDTL.maDD
                WHERE TL.maTL = '".$this->maTL."'";
       $stmt = $this->conn->prepare($query);
       $stmt->execute();
       $result = $stmt->get_result();	
      
        return   $result->fetch_assoc();
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
   // thêm tài liêu yêu thích vào bảng tài liệu yêu thích
   public function themTaiLieuYeuThich($maTL, $taiKhoan) {
    $query = "INSERT INTO " . $this->tblTaiLieuYeuThich . " (maTL, taiKhoan) VALUES (?, ?)";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ss", $maTL, $taiKhoan);

    if ($stmt->execute()) {
        return true;
    } else {
        // Handle any errors here
        return false;
        }
    }
}
?>