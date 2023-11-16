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
            $sqlQuery = "SELECT * FROM `tbltailieu` WHERE tenTL LIKE '%" . $this->search . "%' LIMIT ?, ?";
        } else {
            $sqlQuery = "SELECT * FROM `tbltailieu` LIMIT ?, ?";
        }
    
        $stmt = $this->conn->prepare($sqlQuery);
        
        // Bắt đầu binding các tham số
        if ($this->search) {
            $stmt->bind_param("sii", $this->search, $offset, $resultsPerPage);
        } else {
            $stmt->bind_param("ii", $offset, $resultsPerPage);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result;
    }
    public function timkiembaivietWithPagination($resultsPerPage, $offset) {
        if ($this->search) {
            $sqlQuery = "SELECT * FROM `tblbaiviet` WHERE tenBV LIKE '%" . $this->search . "%' LIMIT ?, ?";
        } else {
            $sqlQuery = "SELECT * FROM `tblbaiviet` LIMIT ?, ?";
        }
    
        $stmt = $this->conn->prepare($sqlQuery);
        
        // Bắt đầu binding các tham số
        if ($this->search) {
            $stmt->bind_param("sii", $this->search, $offset, $resultsPerPage);
        } else {
            $stmt->bind_param("ii", $offset, $resultsPerPage);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public function timkiembaiviet(){
        if($this->search){
            $sqlQuery = "SELECT * FROM tblbaiviet WHERE tenBV LIKE '%".$this->search."%'";

            $stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();			
				return $result;	
        }
    }
    public function demSoLuongTaiLieu(){
        $sqlQuery = "SELECT * FROM tbltailieu";
        $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $result = $stmt->get_result();	
            return $result->num_rows;	
    }
}
?>