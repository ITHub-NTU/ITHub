<?php 
class TimKiem {	
	
    private $tblBaiViet = 'tblbaiviet';
    private $tblNguoiDung = 'tblnguoidung';
    private $tblTaiLieu = 'tbltailieu';
    private $conn;
    
    public function __construct($db){
        $this->conn = $db;
    }	
    public function timkiemtailieuWithPagination($resultsPerPage, $offset) {
        if ($this->search) {
            $sqlQuery = "SELECT * FROM `tbltailieu` WHERE tenTL LIKE ? AND trangThaiTL = 'daduyet' ORDER BY ngayDuyetTL DESC  LIMIT ?, ? ";
            $this->search = "%".$this->search."%";
        } else {
            $sqlQuery = "SELECT * FROM `tbltailieu` WHERE trangThaiTL = 'daduyet' ORDER BY ngayDuyetTL DESC  LIMIT ?, ?";
        }
    
        $stmt = $this->conn->prepare($sqlQuery);
        if($this->search)
            $stmt->bind_param("sii", $this->search, $offset, $resultsPerPage);
        else
            $stmt->bind_param("ii", $offset, $resultsPerPage);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result;
    }
    public function timkiembaivietWithPagination($resultsPerPage, $offset) {
        if ($this->search) {
            $sqlQuery = "SELECT bv.*, nd.anhDaiDien, nd.quyen 
                         FROM `tblbaiviet` as bv
                         JOIN tblnguoidung as nd on bv.taiKhoan = nd.taiKhoan  
                         WHERE tenBV LIKE '%" . $this->search . "%' 
                         AND (trangThaiBV = 'daduyet' OR trangThaiBV = 'dachinhsua' ) LIMIT ?, ?";
        } else {
            $sqlQuery = "SELECT bv.*, nd.anhDaiDien, nd.quyen  
                         FROM `tblbaiviet` as bv
                         JOIN tblnguoidung as nd on bv.taiKhoan = nd.taiKhoan  
                         ORDER BY bv.ngayDuyetBV DESC 
                         LIMIT ?, ?";
        }
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("ii", $offset, $resultsPerPage);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
    public function demSoLuongTaiLieu($search){
        $sqlQuery = "SELECT * FROM tbltailieu WHERE tenTL LIKE '%".$search."%'";
        $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $result = $stmt->get_result();	
            return $result->num_rows;	
    }
    public function demSoLuongBaiViet($search){
        $sqlQuery = "SELECT * FROM tblbaiviet WHERE tenBV LIKE '%".$search."%'";
        $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $result = $stmt->get_result();	
            return $result->num_rows;	
    }
}
?>