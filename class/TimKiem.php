<?php 
class TimKiem {	
	
    private $tblBaiViet = 'tblbaiviet';
    private $tblNguoiDung = 'tblnguoidung';
    private $tblTaiLieu = 'tbltailieu';
    private $conn;
    
    public function __construct($db){
        $this->conn = $db;
    }	
    public function timkiemtailieu(){
        if($this->search){
            $sqlQuery = "SELECT * FROM `tbltailieu` WHERE tenTL LIKE '%".$this->search."%'";
            
        }
        else{
            $sqlQuery = "SELECT * FROM `tbltailieu`";
        }
            $stmt = $this->conn->prepare($sqlQuery);
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
}
?>