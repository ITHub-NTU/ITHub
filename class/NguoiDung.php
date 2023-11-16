<?php
$currentPage = basename($_SERVER['PHP_SELF']);
if($currentPage == 'trangchu.php') {
    $path = '../ITHub/';
} else {
    $path = '../';
}

require ('C:/xampp/phpMyAdmin/vendor/autoload.php');

require($path.'phpmailer/phpmailer/src/Exception.php');

require ($path.'phpmailer/phpmailer/src/PHPMailer.php');

require ($path.'phpmailer/phpmailer/src/SMTP.php');

use phpmailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class NguoiDung {	
	private $tblNguoiDung = 'tblnguoidung';	
    private $tblBaiViet = 'tblbaiviet';
    private $tblTaiLieu = 'tbltailieu';
    private $tblDDTaiLieu = 'tbldinhdangtl';
    private $tblLoaiTaiLieu = 'tblloaitailieu';
    private $tblQuanTriTL = 'tblquantritl';
    private $tblTLYeuThich = 'tbltlyeuthich';
    private $tblBVYeuThich = 'tblbvyeuthich';
	private $conn;
    public $expectedVerificationCode;

	public function __construct($db){
        $this->conn = $db;

    }	    

	public function getTblNguoiDung() {
        return $this->tblNguoiDung;
        
    }

    public function setGenerateVerificationCode() {
        $_SESSION['expectedVerificationCode'] = mt_rand(100000, 999999);
    }

    public function saveEmailToSession($email) {
        $_SESSION['user_email'] = $email;
    }

	
	
	public function login(){	
		if($this->taiKhoan && $this->matKhau) {	
            $sqlQuery = "
                SELECT * FROM ".$this->tblNguoiDung." 
                WHERE taiKhoan = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bind_param("s", $this->taiKhoan);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if($result->num_rows > 0){
                $user = $result->fetch_assoc();
                $hashedPassword = $user['matKhau'];
    
                if (password_verify($this->matKhau, $hashedPassword)) {
                    $_SESSION["taiKhoan"] = $user['taiKhoan'];
                    $_SESSION["hoND"] = $user['hoND'];	
                    $_SESSION["tenND"] = $user['tenND'];
                    $this->quyen = $user['quyen'];

                    if (!empty($_POST["rememberMe"])) {
                        setcookie("taiKhoan", $this->taiKhoan, time() + 3600 * 24 * 7, "/");
                        setcookie("matKhau", $this->matKhau, time() + 3600 * 24 * 7, "/");
                    }
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
	
	public function loggedIn (){
		if(!empty($_SESSION["taiKhoan"])) {
			return 1;
		} else {
			return 0;
		}
	}



	public function register($taiKhoan, $email, $matKhau, $hoND, $tenND, $ngaySinh) {
		if($this->isDuplicateAccount($taiKhoan) && $this->isDuplicateEmail($email)){
			return 'Tài khoản và Email đã tồn tại!';
		}
		elseif ($this->isDuplicateAccount($taiKhoan)) {
            return 'Tài khoản đã tồn tại!';
        } elseif ($this->isDuplicateEmail($email)) {
            return 'Email đã tồn tại!';
        }
        $this->setGenerateVerificationCode();

		$quyen = 'nguoidung';
		$xacThuc = 'chuaxacminh';
		$anhDaiDien = 'user.png';
        $trangThai = 'dunghoatdong';

        $_SESSION['user_email'] = $email; 

        $options = [
            'cost' => 12, 
        ];
        $matKhauHashed = password_hash($matKhau, PASSWORD_DEFAULT, $options);

		$sqlQuery = "INSERT INTO " . $this->tblNguoiDung . " (taiKhoan, email, matKhau, quyen, hoND, tenND, ngaySinh, anhDaiDien, xacThuc, trangThai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->bind_param("sssssssss", $taiKhoan, $email, $matKhauHashed, $quyen, $hoND, $tenND, $ngaySinh, $anhDaiDien, $xacThuc);
	
		if ($stmt->execute()) {
            $verificationCode = $_SESSION['expectedVerificationCode'];
            $result = $this->sendVerificationEmail($email, $verificationCode);
            if ($result === true) {
                header('Location: verifyaccount.php');
                exit;
            } else {
                return 'Đăng ký thành công, nhưng không thể gửi mã xác nhận qua email.';
            }
        } else {
            return 'Lỗi khi đăng ký!' . $stmt->error;
        }
	}



    public function getUserInfoByTaiKhoan($taiKhoan) {
        $sqlQuery = "SELECT * FROM " . $this->tblNguoiDung . " WHERE taiKhoan = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $taiKhoan);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $userInfo = $result->fetch_assoc();
            return $userInfo;
        } else {
            return null;
        }
    }

    public function updateUserInfoByTaiKhoan($taiKhoan, $email, $hoND, $tenND, $ngaySinh, $anhDaiDien) {
        $sqlQuery = "UPDATE " . $this->tblNguoiDung . " SET email = ?, hoND = ?, tenND = ?, ngaySinh = ?, anhDaiDien = ?  WHERE taiKhoan = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("ssssss",  $email, $hoND, $tenND, $ngaySinh, $anhDaiDien, $taiKhoan);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



	public function sendVerificationEmail($email, $verificationCode) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'lan.pnt.62cntt@ntu.edu.vn';
        $mail->Password = '06122002'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('lan.pnt.62cntt@ntu.edu.vn', 'AlanWalker'); 
        $mail->addAddress($email); 
        $mail->Subject = 'Ma xac nhan';
        $mail->Body = 'Mã xác nhận của bạn là: ' . $verificationCode;

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

	private function isDuplicateAccount($taiKhoan) {
        $checkAccountQuery = "SELECT taiKhoan FROM $this->tblNguoiDung WHERE taiKhoan = ?";
        $stmt = $this->conn->prepare($checkAccountQuery);
        $stmt->bind_param("s", $taiKhoan);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function updateEmailVerificationStatus($email) {
        $upDateEmailQuery = "UPDATE " . $this->tblNguoiDung . " SET xacThuc = 'daxacminh' WHERE email = ?";
        $stmt = $this->conn->prepare($upDateEmailQuery);
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function accountOnline($taiKhoan) {
        $accountOnlineQuery = "UPDATE " . $this->tblNguoiDung . " SET trangThai = 'hoatdong' WHERE taiKhoan = ?";
        $stmt = $this->conn->prepare($accountOnlineQuery);
        $stmt->bind_param("s", $taiKhoan);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isDuplicateEmail($email) {
        $checkEmailQuery = "SELECT email FROM $this->tblNguoiDung WHERE email = ?";
        $stmt = $this->conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function verifyEmailRequest($email) {
        if ($this->isDuplicateEmail($email)) {
            $this->setGenerateVerificationCode();
            $verificationCode = $_SESSION['expectedVerificationCode'];
            $this->saveEmailToSession($email);
            $result = $this->sendVerificationEmail($email, $verificationCode);
            if ($result === true) {
                header('Location: verifycpassword.php');
                exit;
            } else {
                return 'Lỗi thực thi!';
            }
        } else {
            return 'Email không tồn tại!';
        }
    }

    public function changePassword($password, $confirmpassword) {
        if ($password === $confirmpassword) {
            $email = $_SESSION['user_email'];
            
            if ($this->isDuplicateEmail($email)) {
                $newPasswordHashed = password_hash($password, PASSWORD_DEFAULT);
                
                $updatePasswordQuery = "UPDATE " . $this->tblNguoiDung . " SET matKhau = ? WHERE email = ?";
                $stmt = $this->conn->prepare($updatePasswordQuery);
                $stmt->bind_param("ss", $newPasswordHashed, $email);
                
                if ($stmt->execute()) {
                    unset($_SESSION['user_email']);
                    
                    return 'Thay đổi mật khẩu thành công!';
                } else {
                    return 'Lỗi khi thay đổi mật khẩu!';
                }
            } else {
                return 'Email không tồn tại!';
            }
        } else {
            return 'Mật khẩu và mật khẩu xác nhận không khớp!';
        }
    }


    public function getUserInfoFromDatabase() {
        if (!empty($_SESSION["taiKhoan"])) {
            $taiKhoan = $_SESSION["taiKhoan"];
            $sqlQuery = "SELECT * FROM " . $this->tblNguoiDung . " WHERE taiKhoan = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bind_param("s", $taiKhoan);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $userInfo = $result->fetch_assoc();
                return $userInfo;
            }
        }
        return null; 
    }


    public function countFriends($account) {
    $sqlQuery = "SELECT COUNT(TABLE_NAME) as tableCount FROM information_schema.tables WHERE TABLE_SCHEMA = 'ithub' AND TABLE_NAME LIKE ?";
    $stmt = $this->conn->prepare($sqlQuery);
    $likeParam = '%' . $account . '%';
    $stmt->bind_param("s", $likeParam);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['tableCount'];
            }
        }
        return -1;
    }

    public function logOut(){
        $currentPage = $_SERVER['REQUEST_URI'];
        $taiKhoan = $_SESSION['taiKhoan'];
        session_unset();
        session_destroy();
        $sql = "UPDATE " . $this->tblNguoiDung . " SET trangThai = 'dunghoatdong' WHERE taiKhoan = ?";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("s", $taiKhoan);
            $stmt->execute();
    
            $stmt->close();
            header('Location:'.$currentPage);
        } else {
            echo "Lỗi truy vấn: ";
        }
    
    }

    public function getTrangThaiHoatDong() {
        if (isset($_SESSION['taiKhoan'])) {
            $this->taiKhoan = $_SESSION['taiKhoan']; 
            $sqlQuery = "SELECT `trangThai` FROM " . $this->tblNguoiDung . " WHERE `taiKhoan` = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bind_param("s", $this->taiKhoan);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['trangThai'];
            } else {
                return null; 
            }
        } else {
            return null;
        }
    }
    
    public function changeTrangThaiHoatDong() {
        if (isset($_SESSION['taiKhoan'])) {
            $this->taiKhoan = $_SESSION['taiKhoan'];
    
            $trangThai = $this->getTrangThaiHoatDong();
            $trangThai = strval($trangThai);
            if ($trangThai == 'ban') {
                $sqlQuery = "UPDATE " . $this->tblNguoiDung . " SET trangThai = 'hoatdong' WHERE taiKhoan = ?";
            } elseif ($trangThai == 'hoatdong') {
                $sqlQuery = "UPDATE " . $this->tblNguoiDung . " SET trangThai = 'ban' WHERE taiKhoan = ?";
            } else {
                return false; 
            }
    
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bind_param("s", $this->taiKhoan);
    
            if ($stmt->execute()) {
                return true;
            }
        }
        return false; 
    }

	public function layDanhSachBaiVietCuaNguoiDung() {
		$sqlQuery = "
			SELECT t.*, c.taiKhoan, c.anhDaiDien
			FROM " . $this->tblBaiViet . " as t
			LEFT JOIN " . $this->tblNguoiDung . " as c ON t.taiKhoan = c.taiKhoan
			WHERE t.taiKhoan = '".$this->taiKhoan."'
			ORDER BY t.maBV DESC";
	
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result(); 

		
		return $result;
	}

    public function layDanhSachTaiLieuCuaNguoiDung() {
        $sqlQuery = "
            SELECT tl.`maTL`, ltl.`tenLoaiTL`, tl.`taiKhoan`, tl.`tenTL`, tl.`moTaTL`, tl.`fileTL`, tl.`ngayDangTL`, tl.`ngayDuyetTL`, tl.`anhTL`, tl.`trangThaiTL`, dd.`tenDD`
            FROM ".$this->tblTaiLieu." AS tl
            LEFT JOIN ".$this->tblDDTaiLieu." AS dd ON tl.`maDD` = dd.`maDD`
            LEFT JOIN ".$this->tblLoaiTaiLieu. " AS ltl ON tl.`maLoaiTL` = ltl.`maLoaiTL`
            WHERE tl.`trangThaiTL` = 'daduyet' AND tl.`taiKhoan` = ?";
        
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $this->taiKhoan);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result;
    }

    
    public function changePasswordLogin($oldPassword, $newPassword, $confirmPassword){
        $taiKhoan = $_SESSION['taiKhoan'];
        $sqlQuery = "SELECT matKhau FROM " . $this->tblNguoiDung . " WHERE taiKhoan = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $taiKhoan);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['matKhau'];

            if (password_verify($oldPassword, $hashedPassword)){
                if ($newPassword === $confirmPassword) {
                    if ($oldPassword === $newPassword) {
                        return 'Mật khẩu cũ và mật khẩu mới không được trùng nhau!';
                    }

                    $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);

                    $updatePasswordQuery = "UPDATE " . $this->tblNguoiDung . " SET matKhau = ? WHERE taiKhoan = ?";
                    $stmt = $this->conn->prepare($updatePasswordQuery);
                    $stmt->bind_param("ss", $newPasswordHashed, $taiKhoan);

                    if ($stmt->execute()) {
                        return 'Thay đổi mật khẩu thành công!';
                    } else {
                        return 'Lỗi khi thay đổi mật khẩu!';
                    }
                } else {
                    return 'Mật khẩu mới và mật khẩu xác nhận không khớp!';
                }
            } else {
                return 'Mật khẩu cũ không đúng!';
            }
        } else {
            return 'Lỗi khi thay đổi mật khẩu!';
        }
    }
    
    public function layDanhSachTaiLieuYeuThichCuaNguoiDung() {
        $sqlQuery = "
            SELECT tl.`maTL`, ltl.`tenLoaiTL`, tl.`taiKhoan`, tl.`tenTL`, tl.`moTaTL`, tl.`fileTL`, tl.`ngayDangTL`, tl.`ngayDuyetTL`, tl.`anhTL`, tl.`trangThaiTL`, dd.`tenDD`
            FROM " . $this->tblTaiLieu . " AS tl
            LEFT JOIN " . $this->tblDDTaiLieu . " AS dd ON tl.`maDD` = dd.`maDD`
            LEFT JOIN " . $this->tblLoaiTaiLieu . " AS ltl ON tl.`maLoaiTL` = ltl.`maLoaiTL`
            LEFT JOIN " . $this->tblTLYeuThich . " AS yeuthich ON tl.`maTL` = yeuthich.`maTL`
            WHERE yeuthich.`taiKhoan` = ?";
    
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $this->taiKhoan);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result;
    }
    
    public function layDanhSachBaiVietYeuThichCuaNguoiDung() {
        $sqlQuery = "
            SELECT t.*, c.taiKhoan, c.anhDaiDien
            FROM " . $this->tblBaiViet . " as t
            LEFT JOIN " . $this->tblNguoiDung . " as c ON t.taiKhoan = c.taiKhoan
            LEFT JOIN " . $this->tblBVYeuThich . " as bvyt ON t.maBV = bvyt.maBV
            WHERE bvyt.taiKhoan = '".$this->taiKhoan."'
            ORDER BY t.maBV DESC";
    
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result;
    }

    public function xoaBaiVietYeuThich($taiKhoan, $maBV) {
        $sqlQuery = "DELETE FROM " . $this->tblBVYeuThich . " WHERE maBV = ? AND taiKhoan = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("ss", $maBV, $taiKhoan);
    
        if ($stmt->execute()) {
            return true;
        } else {
            die("Lỗi thực hiện truy vấn: " . $stmt->error);
            return false;
        }
    }
    

    public function xoaTaiLieuYeuThich($taiKhoan, $maTL) {
        $sqlQuery = "DELETE FROM " . $this->tblTLYeuThich . " WHERE maTL = ? AND taiKhoan = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("ss", $maTL, $taiKhoan);
    
        if ($stmt->execute()) {
            return true;
        } else {
            die("Lỗi thực hiện truy vấn: " . $stmt->error);
            return false;
        }
    }

    public function xoaBaiViet($maBV) {
        $this->conn->begin_transaction();
        try {
            $queryDeleteBVViPham = "DELETE FROM tblbvvipham WHERE maBV = ?";
            $stmtDeleteBVViPham = $this->conn->prepare($queryDeleteBVViPham);
            $stmtDeleteBVViPham->bind_param("s", $maBV);
            $stmtDeleteBVViPham->execute();
    
            $queryDeleteTLBV= "DELETE FROM tblthaoluanbv WHERE maBV = ?";
            $stmtDeleteTLBV = $this->conn->prepare($queryDeleteTLBV);
            $stmtDeleteTLBV->bind_param("s", $maBV);
            $stmtDeleteTLBV->execute();

            $queryDeleteBV = "DELETE FROM tblbaiviet WHERE maBV = ?";
            $stmtDeleteBV = $this->conn->prepare($queryDeleteBV);
            $stmtDeleteBV->bind_param("s", $maBV);
            $stmtDeleteBV->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    

    public function xoaTaiLieu($maTL) {
        $sqlQuery = "DELETE FROM " . $this->tblTaiLieu . " WHERE maTL = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $maTL);
    
        if ($stmt->execute()) {
            return true;
        } else {
            die("Lỗi thực hiện truy vấn: " . $stmt->error);
            return false;
        }
    }

    public function setVerificationCode() {
        $_SESSION['expectedVerificationCode'] = mt_rand(100000, 999999); 
        $_SESSION['verificationCodeExpiration'] = time() + 60; 
    }



    public function resendVerificationCode($email) {
        $this->setGenerateVerificationCode();
        $verificationCode = $_SESSION['expectedVerificationCode'];
        $this->saveEmailToSession($email);
        $result = $this->sendVerificationEmail($email, $verificationCode);
        if ($result === true) {
            header('Location: verifycpassword.php');
            exit;
        } else {
            return 'Lỗi thực thi!';
        }
    }

    public function layThongTinQuanTriTrucTuyen($tenBangQT) {
        $sqlQuery = " 
                SELECT DISTINCT s.* FROM ".$this->tblNguoiDung." s
                JOIN ".$tenBangQT." t ON t.maQuanTri = s.taiKhoan
                WHERE trangThai = 'hoatdong';";
				
		$stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();			
        return $result;	
    } 

    public function layChuDeQT($taiKhoan) {
        $sqlQuery = " 
            SELECT s.*, k.*
            FROM ".$this->tblNguoiDung." s
            JOIN `tblquantribv` t ON t.maQuanTri = s.taiKhoan
            JOIN `tblchudebv` k ON t.maCD = k.maCD
            WHERE t.maQuanTri = '".$taiKhoan."';";
        
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $danhSachChuDeQT = array();
        
        while ($row = $result->fetch_assoc()) {
            $danhSachChuDeQT[] = '<a class="text-decoration-none" href="danhsachbaiviet.php?maCD='.$row['maCD'].'" style="display:flex">'.trim($row['tenCD']).'</a>';
        }        
    
        $chuDeQT = implode(', ', $danhSachChuDeQT);
    
        return $chuDeQT;
    }

    public function layTongTaiKhoan(){
        $sqlQuery = "
            SELECT COUNT(*) AS soLuongTK
            FROM ".$this->tblNguoiDung."";
            
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $result = $stmt->get_result();	
            $tongTaiKhoan = $result->fetch_assoc();			
            return $tongTaiKhoan['soLuongTK'];	
    }

    public function chanUser($taiKhoan) {
        $banQuery = "UPDATE " . $this->tblNguoiDung . " SET quyen = 'nguoidungbichan' WHERE taiKhoan = ?";
        $stmt = $this->conn->prepare($banQuery);
        $stmt->bind_param("s", $taiKhoan);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
