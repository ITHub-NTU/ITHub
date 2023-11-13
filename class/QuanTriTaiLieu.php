<?php
class QuanTriTaiLieu{
    private $tblQuanTriTaiLieu = 'tblquantritl';
    private $tblLoaiTaiLieu = 'tblloaitailieu';
    private $tblTaiLieu = 'tbltailieu';
    private $tblDDTaiLieu = 'tbldinhdangtl';
    private $tblTLViPham = 'tbltlvipham';
    private $tblLoaiViPham = 'tblloaivipham';
    private $conn;


    public function __construct($db){
        $this->conn = $db;

    }	 
    

    public function layLoaiTaiLieuCuaAdmin($taiKhoan) {
        $sqlQuery = "SELECT qt.maLoaiTL, lt.tenLoaiTL 
                     FROM " . $this->tblQuanTriTaiLieu . " qt
                     JOIN " . $this->tblLoaiTaiLieu . " lt ON qt.maLoaiTL = lt.maLoaiTL
                     WHERE qt.maQuanTri = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $taiKhoan);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result;
    }
    

    public function layThongTinTaiLieuTheoMaLoaiTL($maLoaiTL) {
        $sqlQuery = "SELECT tl.maTL, ltl.`tenLoaiTL`, tl.taiKhoan, dd.`tenDD`, tl.tenTL, tl.moTaTL, tl.fileTL, tl.ngayDangTL, tl.ngayDuyetTL, tl.anhTL, tl.trangThaiTL
                     FROM " . $this->tblTaiLieu . " tl
                     LEFT JOIN ".$this->tblDDTaiLieu." AS dd ON tl.`maDD` = dd.`maDD`
                     LEFT JOIN ".$this->tblLoaiTaiLieu. " AS ltl ON tl.`maLoaiTL` = ltl.`maLoaiTL`
                     WHERE tl.maLoaiTL = ? AND tl.trangThaiTL = 'chuaduyet'";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $maLoaiTL);
        $stmt->execute();
        $result = $stmt->get_result();
      
        return $result;
    }

    public function layThongTinTaiLieuDeKiemDuyet($maTL) {
        $sqlQuery = "SELECT tl.maTL, ltl.`tenLoaiTL`, tl.taiKhoan, dd.`tenDD`, tl.tenTL, tl.moTaTL, tl.fileTL, tl.ngayDangTL, tl.ngayDuyetTL, tl.anhTL, tl.trangThaiTL
                     FROM " . $this->tblTaiLieu . " tl
                     LEFT JOIN ".$this->tblDDTaiLieu." AS dd ON tl.`maDD` = dd.`maDD`
                     LEFT JOIN ".$this->tblLoaiTaiLieu. " AS ltl ON tl.`maLoaiTL` = ltl.`maLoaiTL`
                     WHERE tl.maTL = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $maTL);
        $stmt->execute();
        $result = $stmt->get_result();
      
        return $result;
    }

    public function updateTailieu($maTL, $ngayDuyetTL) {
        $sql = "UPDATE " . $this->tblTaiLieu . " SET ngayDuyetTL = ?, trangThaiTL = 'daduyet' WHERE maTL = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $ngayDuyetTL, $maTL);
    
        if ($stmt->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
    
    public function deleteTaiLieu($maTL) {
        $sql = "DELETE FROM " . $this->tblTaiLieu . " WHERE maTL = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $maTL);
    
        if ($stmt->execute()) {
            return true; 
        } else {
            return false;
        }
    }
    

    public function layThongTinTaiLieuViPhamTheoMaLoaiTL($taiKhoan, $maLoaiTL) {
        $query = "SELECT tl.maTL, ltl.`tenLoaiTL`, tl.taiKhoan, dd.`tenDD`, tl.tenTL, tl.moTaTL, tl.fileTL, tl.ngayDangTL, tl.ngayDuyetTL, tl.anhTL
                  FROM " . $this->tblTaiLieu . " tl
                  INNER JOIN " . $this->tblDDTaiLieu . " AS dd ON tl.`maDD` = dd.`maDD`
                  INNER JOIN " . $this->tblLoaiTaiLieu . " AS ltl ON tl.`maLoaiTL` = ltl.`maLoaiTL`
                  INNER JOIN " . $this->tblQuanTriTaiLieu . " AS qttl ON ltl.`maLoaiTL` = qttl.`maLoaiTL`
                  INNER JOIN " . $this->tblTLViPham . " AS tlvp ON tl.maTL = tlvp.maTL
                  WHERE qttl.maQuanTri = ? AND tl.maLoaiTL = ?
                  GROUP BY tl.maTL"; 
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $taiKhoan, $maLoaiTL);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        return $result;
    }
    
    public function getTaiKhoanVaTenLoaiVP($maTL) {
        $sqlQuery = "SELECT tlvp.taiKhoan, lvp.tenLoaiVP
                     FROM " . $this->tblTLViPham . " AS tlvp
                     INNER JOIN " . $this->tblLoaiViPham . " AS lvp ON tlvp.maLoaiVP = lvp.maLoaiVP
                     WHERE tlvp.maTL = ?
                     GROUP BY tlvp.taiKhoan, lvp.tenLoaiVP";
        
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $maTL);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result; 
    }

    public function xoaBaoCao($maTL) {
        $sqlQuery = "DELETE FROM " . $this->tblTLViPham . " WHERE maTL = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $maTL);
    
        if ($stmt->execute()) {
            return true;
        } else {
            die("Lỗi thực hiện truy vấn: " . $stmt->error);
            return false;
        }
    }

    public function XoaTaiLieu($maTL) {
        $this->conn->begin_transaction();
        try {
            $queryDeleteTLViPham = "DELETE FROM tbltlvipham WHERE maTL = ?";
            $stmtDeleteTLViPham = $this->conn->prepare($queryDeleteTLViPham);
            $stmtDeleteTLViPham->bind_param("s", $maTL);
            $stmtDeleteTLViPham->execute();
    
            $queryDeleteTaiLieu = "DELETE FROM tbltailieu WHERE maTL = ?";
            $stmtDeleteTaiLieu = $this->conn->prepare($queryDeleteTaiLieu);
            $stmtDeleteTaiLieu->bind_param("s", $maTL);
            $stmtDeleteTaiLieu->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }
    
    public function layDSChuDeTLQT($maQuanTri){
        $sqlQuery = "
            SELECT a.*, b.tenLoaiTL
            FROM ".$this->tblQuanTriTaiLieu." AS a
            JOIN ".$this->tblLoaiTaiLieu." AS b ON a.maLoaiTL = b.maLoaiTL 
            WHERE a.maQuanTri = ?
            ORDER BY b.tenLoaiTL ASC";
    
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $maQuanTri);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result;
        } else {
            die("Lỗi thực hiện truy vấn: " . $stmt->error);
            return false;
        }
    }

    public function soLuongBaoCao($maTL) {
        $query = "SELECT COUNT(maTL) as soLuong 
                  FROM " . $this->tblTLViPham . " 
                  WHERE maTL = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $maTL);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $row = $result->fetch_assoc();
        $numDuplicates = $row['soLuong'];
        
        return $numDuplicates;
    }
    
}
?>