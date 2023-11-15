<?php 

class TaiLieu {
    private $conn;
    private $tbltailieu = 'tbltailieu';
    private $tblloaitailieu = 'tblloaitailieu';
    private $tbldinhdangtl = 'tbldinhdangtl';
    private $tbltailieuyeuthich = 'tbltlyeuthich';
    private $tblnguoidung = 'tblnguoidung';
    private $tblloaivipham = 'tblloaivipham';
    private $tbltlvipham = 'tbltlvipham';

    public function __construct($db) {
        $this->conn = $db;
    }
    //Tuan Kiet
    public function layTaiLieu(){
        if($this->maTL) {
            $sqlQuery = "
                SELECT `tbltailieu`.*
                FROM ".$this->tbltailieu."
                WHERE maTL = '".$this->maTL."'";
            
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $result = $stmt->get_result();	
            $taiLieu = $result->fetch_assoc();			
            return $taiLieu;	
        }
    }
    //Duc nhong Lấy danh sách tài liệu 
    public function getTaiLieu($sort = '', $order = '') {
        $sql = "SELECT *
                FROM $this->tbltailieu TL
                INNER JOIN $this->tblloaitailieu LTL ON TL.maLoaiTL = LTL.maLoaiTL
                INNER JOIN $this->tbldinhdangtl DDTL ON TL.maDD = DDTL.maDD";
        $sql .= " GROUP BY TL.maTL";
        if (!empty($sort) && !empty($order)) {
            if ($sort == 'ngayDangTL') {
                $sort = 'TL.ngayDangTL';
            }
            $sql .= " ORDER BY $sort $order";
        }
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('Lỗi trong truy vấn Sql ' . $this->conn->error);
        }
        $stmt->execute();
        if ($stmt->error) {
            die('Lỗi thực thi sql: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        return $result;
    }
    // Lấy danh sách loại tài liệu
    public function getLoaiTaiLieu()
    {
        $query = "SELECT * FROM tblloaitailieu";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //DucNhong sắp xếp tài liệu bằng mã loại tài liệu 
    public function getTaiLieuBymaLoaiTL($sort = '', $order = '') {
        $sql = "SELECT *
                FROM $this->tbltailieu TL
                INNER JOIN $this->tblloaitailieu LTL ON TL.maLoaiTL = LTL.maLoaiTL
                INNER JOIN $this->tbldinhdangtl DDTL ON TL.maDD = DDTL.maDD
                WHERE TL.maLoaiTL = ?";
        $sql .= " GROUP BY TL.maTL";
        if (!empty($sort) && !empty($order)) {
            if ($sort == 'ngayDangTL') {
                $sort = 'TL.ngayDangTL';
            }
            $sql .= " ORDER BY $sort $order";
        }
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('Lỗi trong truy vấn Sql ' . $this->conn->error);
        }
        $stmt->bind_param("s", $this->maLoaiTL);
        $stmt->execute();
        if ($stmt->error) {
            die('Lỗi thực thi sql: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        return $result;
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
    //PhuongHa thêm tài liệu
    public function themTaiLieu($maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL, $ngayDangTL, $ngayDuyetTL) {
        $query = "INSERT INTO " . $this->tbltailieu . " (maTL, maLoaiTL, taiKhoan, maDD, tenTL, moTaTL, fileTL, trangThaiTL, ngayDangTL, ngayDuyetTL) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssss", $maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL,$ngayDangTL, $ngayDuyetTL);

        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    //Duc nhong kiểm tra tài khoản đã thích tài liệu đó chưa
    public function getTLYeuThich($taiKhoan, $maTL) {
        $query = "SELECT *
                FROM TblTLYeuThich
                WHERE taiKhoan = ? AND maTL = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $taiKhoan, $maTL);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Dữ liệu đã tồn tại, lấy nó và kiểm tra với $this->maTL
                $row = $result->fetch_assoc();
                if ($row['maTL'] == $maTL) {
                    return true;
                }
            }
        }
    }
    //Duc nhong thêm và xóa dữ liệu
    public function changeTLYeuThich($yeuThich,$taiKhoan,$maTL) {
        if ($yeuThich==true) {
            // Xóa dữ liệu từ bảng TblTLYeuThich nếu $yeuThich là true
            $query = "DELETE FROM $this->tbltailieuyeuthich WHERE taiKhoan = ? AND maTL = ?";
        } else {
            // Thêm dữ liệu vào bảng TblTLYeuThich nếu $yeuThich là false
            $query = "INSERT INTO $this->tbltailieuyeuthich (taiKhoan, maTL) VALUES (?, ?)";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $taiKhoan, $maTL);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //Duc nhong lấy dữ liệu tên định dạng từ bảng định dạng tài liệu
    public function getDSDDTaiLieu(){
        $query = "SELECT * FROM $this->tbldinhdangtl";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //Duc nhong cập nhật dữ liệu tài liệu
    public function chinhSuaTaiLieu($maTL, $maLoaiTL, $taiKhoan, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL, $ngayDangTL, $ngayDuyetTL) {
        $query = "UPDATE $this->tbltailieu 
                  SET maLoaiTL = ?, maDD = ?, tenTL = ?, moTaTL = ?, fileTL = ?, trangThaiTL = ?, ngayDangTL = ?, ngayDuyetTL = ?
                  WHERE maTL = ? AND taiKhoan = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssss", $maLoaiTL, $maDD, $tenTL, $moTaTL, $fileTL, $trangThaiTL, $ngayDangTL, $ngayDuyetTL, $maTL, $taiKhoan);
        $result = $stmt->execute();
        return $result;
    }
    //Duc nhong kiểm tra quyền chỉnh sửa
    public function kiemTraQuyenChinhSua($taiKhoan, $maTL){
            $query = "SELECT * FROM $this->tbltailieu WHERE taiKhoan = '".$taiKhoan."' AND maTL = '".$maTL."'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
    }
    //Duc nhong lấy loại danh sách vi phạm
    public function getDSLoaiViPham(){
        $query = "SELECT * FROM $this->tblloaivipham";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //Duc nhong kiểm tra tài khoản đó đã báo cáo tài liệu đó chưa
    public function daBaoCaoTaiLieu($maTL, $taiKhoan) {
        $query = "SELECT *
                FROM $this->tbltlvipham
                WHERE maTL = ? AND taiKhoan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $maTL, $taiKhoan);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->num_rows > 0; // Trả về true nếu tài liệu đã bị báo cáo, ngược lại trả về false
        }
        return false; // Trả về false nếu có lỗi trong truy vấn SQL
    }
    //Duc nhong thêm tài liệu bị báo cáo 
    public function insertTLBaoCao($maTL,$maLoaiVP,$taiKhoan) {
        // Thêm dữ liệu vào bảng Tbltlvipham
        $query = "INSERT INTO $this->tbltlvipham (maTL, maLoaiVP, taiKhoan) VALUES (?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss",  $maTL,$maLoaiVP,$taiKhoan);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
}
?>