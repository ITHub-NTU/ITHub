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
        
        


    }

?>