<?php 
    class ThongBao {
        private $conn;
        private $tblThongBao = 'tblthongbao';
        private $tblChuDeBV = 'tblchudebv';
        private $tblBaiViet = 'tblbaiviet';
        private $tblNguoiDung = 'tblnguoidung';
        private $tblThaoLuanBV = 'tblthaoluanbv';
        private $tblTheoDoiChuDe = 'tbltheodoichude';
        private $tblBVViPham = 'tblbvvipham';
        private $tblTLBVViPham = 'tbltlbvvipham';
        private $tblQuanTriBV = 'tblquantribv';
        private $tblLoaiTaiLieu = 'tblloaitailieu';
        private $tblTaiLieu = 'tbltailieu';
        private $tblTaiLieuViPham = 'tbltlvipham';
        private $tblTLYeuThich = 'tbltlyeuthich';
        private $tblQuanTriTL = 'tblquantritl';

        public function __construct($db) {
            $this->conn = $db;
        }
        
        public function capNhatThongBao() {      
            $sqlQuery = "UPDATE " . $this->tblThongBao . " SET trangThaiTB = 1 WHERE trangThaiTB = 0 AND taiKhoan='" . $this->taiKhoan . "'";
            $stmt = $this->conn->prepare($sqlQuery);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        

        public function capNhatTrangThaiXemThongBao($linkHref) {
            $linkHref = $this->conn->real_escape_string($linkHref);
        
            $sqlQuery = "UPDATE " . $this->tblThongBao . " SET trangThaiXemTB = 1 WHERE linkTB = '$linkHref'";
            $stmt = $this->conn->prepare($sqlQuery);
        
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
        public function themTBBV($taiKhoanDangBai, $loaiTB, $maCD, $maBV) {
            if ($loaiTB == 'admin') {
                $iconTB = '<i class="fas fa-book-open notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'quantri/baivietkiemduyet.php';
        
                $notifications = array();

                $sqlQuery = "SELECT * FROM " . $this->tblQuanTriBV . ";";
                $stmtTB = $this->conn->prepare($sqlQuery);
                $stmtTB->execute();
                $resultTB = $stmtTB->get_result();
        
                while ($quanTriBV = $resultTB->fetch_assoc()) {
                    if ($quanTriBV['maCD'] == $maCD) {
                        $sqlQueryCD = "
                            SELECT *
                            FROM " . $this->tblChuDeBV . "
                            WHERE maCD = '" . $quanTriBV['maCD'] . "'";
        
                        $stmtCD = $this->conn->prepare($sqlQueryCD);
                        $stmtCD->execute();
                        $resultCD = $stmtCD->get_result();
                        $chuDeBV = $resultCD->fetch_assoc();
        
                        $countBV = "
                            SELECT COUNT(*) AS soLuongBVChuaDuyet 
                            FROM " . $this->tblBaiViet . "
                            WHERE trangThaiBV = 'chuaduyet' AND maCD = '" . $quanTriBV['maCD'] . "';";
        
                        $stmtCountBV = $this->conn->prepare($countBV);
                        $stmtCountBV->execute();
                        $resultCountBV = $stmtCountBV->get_result();
                        $count = $resultCountBV->fetch_assoc();
                        $soLuongBVChuaDuyet = $count['soLuongBVChuaDuyet'];
                        $noiDungTB = "Bạn có <strong>" . $soLuongBVChuaDuyet . "</strong> bài viết mới cần duyệt trong chủ đề <strong>" . $chuDeBV['tenCD'] . "</strong>";
        
                        $taiKhoan = $quanTriBV['maQuanTri'];
                        $anhTB =  $chuDeBV['anhCD'];
                        $notifications[] = array(
                            'taiKhoan' => $taiKhoan,
                            'anhTB' => $anhTB,
                            'iconTB' => $iconTB,
                            'linkTB' => $linkTB,
                            'noiDungTB' => $noiDungTB,
                        );
                    }
                }
                foreach ($notifications as $notification) {
                    $checkDuplicateQuery = "SELECT * FROM " . $this->tblThongBao . " WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$chuDeBV[tenCD]%';";
                    $stmtDuplicate = $this->conn->prepare($checkDuplicateQuery);
                    $stmtDuplicate->execute();
                    $resultDuplicate = $stmtDuplicate->get_result();
            
                    if ($resultDuplicate->num_rows > 0) {
                        $updateQuery = "UPDATE " . $this->tblThongBao . " SET noiDungTB = '$notification[noiDungTB]', ngayDangTB = current_timestamp(), trangThaiTB = '0', trangThaiXemTB = '0' WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$chuDeBV[tenCD]%';";
                        $stmtUpdate = $this->conn->prepare($updateQuery);
            
                        if (!$stmtUpdate->execute()) {
                        }
                    } else {
                        $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`,`anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) VALUES (NULL, '$notification[taiKhoan]', '$notification[anhTB]', '$notification[iconTB]', '$notification[linkTB]', '$notification[noiDungTB]', current_timestamp(), '0', '0');";
                        $stmt = $this->conn->prepare($insertQuery);
            
                        if (!$stmt->execute()) {
                        }
                    }
                }
            }elseif($loaiTB == 'duyetbaiviet') {
                $iconTB = '<i class="fas fa-users notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'diendan/chitietbaiviet.php?maBV='.$maBV;
                $sqlQueryCD = "
                            SELECT *
                            FROM " . $this->tblChuDeBV . "
                            WHERE maCD = '" . $maCD . "'";
        
                $stmtCD = $this->conn->prepare($sqlQueryCD);
                $stmtCD->execute();
                $resultCD = $stmtCD->get_result();
                $chuDeBV = $resultCD->fetch_assoc();
                $noiDungTB = "Bài viết của bạn đã được đăng trong chủ đề <strong>" . $chuDeBV['tenCD'] . "</strong>";
                $taiKhoan = $taiKhoanDangBai;
                $anhTB = $chuDeBV['anhCD'];
                $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`, `anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) 
                            VALUES (NULL, '$taiKhoan', '$anhTB', '$iconTB', '$linkTB', '$noiDungTB', current_timestamp(), '0', '0');";
                            
                $stmt = $this->conn->prepare($insertQuery);

                if ($stmt->execute()) {
                    return true;
                }
            }elseif($loaiTB == 'baocao') {
                $iconTB = '<i class="fas fa-bell notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #dc3545, #dc3545); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'quantri/baivietbaocao.php';
        
                $notifications = array();

                $sqlQuery = "SELECT * FROM " . $this->tblQuanTriBV . ";";
                $stmtTB = $this->conn->prepare($sqlQuery);
                $stmtTB->execute();
                $resultTB = $stmtTB->get_result();
        
                while ($quanTriBV = $resultTB->fetch_assoc()) {
                    if ($quanTriBV['maCD'] == $maCD) {
                        $sqlQueryCD = "
                            SELECT *
                            FROM " . $this->tblChuDeBV . "
                            WHERE maCD = '" . $quanTriBV['maCD'] . "'";
        
                        $stmtCD = $this->conn->prepare($sqlQueryCD);
                        $stmtCD->execute();
                        $resultCD = $stmtCD->get_result();
                        $chuDeBV = $resultCD->fetch_assoc();
        
                        $countBVVP = "
                            SELECT COUNT(DISTINCT t.maBV) AS SoLuongBVViPham
                            FROM  " . $this->tblBVViPham . " t
                            JOIN  " . $this->tblBaiViet . " p ON t.maBV = p.maBV
                            WHERE p.maCD = '" . $quanTriBV['maCD'] . "';";
        
                        $stmtCountBVVP = $this->conn->prepare($countBVVP);
                        $stmtCountBVVP->execute();
                        $resultCountBV = $stmtCountBVVP->get_result();
                        $count = $resultCountBV->fetch_assoc();
                        $soLuongBVViPham = $count['SoLuongBVViPham'];
                        $noiDungTB = "Bạn có <strong>" . $soLuongBVViPham . "</strong> bài viết vi phạm mới cần kiểm tra trong chủ đề <strong>" . $chuDeBV['tenCD'] . "</strong>";
        
                        $taiKhoan = $quanTriBV['maQuanTri'];
                        $anhTB =  $chuDeBV['anhCD'];
                        $notifications[] = array(
                            'taiKhoan' => $taiKhoan,
                            'anhTB' => $anhTB,
                            'iconTB' => $iconTB,
                            'linkTB' => $linkTB,
                            'noiDungTB' => $noiDungTB,
                        );
                    }
                }
                foreach ($notifications as $notification) {
                    $checkDuplicateQuery = "SELECT * FROM " . $this->tblThongBao . " WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$chuDeBV[tenCD]%';";
                    $stmtDuplicate = $this->conn->prepare($checkDuplicateQuery);
                    $stmtDuplicate->execute();
                    $resultDuplicate = $stmtDuplicate->get_result();
            
                    if ($resultDuplicate->num_rows > 0) {
                        $updateQuery = "UPDATE " . $this->tblThongBao . " SET noiDungTB = '$notification[noiDungTB]', ngayDangTB = current_timestamp(), trangThaiTB = '0', trangThaiXemTB = '0' WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$chuDeBV[tenCD]%';";
                        $stmtUpdate = $this->conn->prepare($updateQuery);
            
                        if (!$stmtUpdate->execute()) {
                        }
                    } else {
                        $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`,`anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) VALUES (NULL, '$notification[taiKhoan]', '$notification[anhTB]', '$notification[iconTB]', '$notification[linkTB]', '$notification[noiDungTB]', current_timestamp(), '0', '0');";
                        $stmt = $this->conn->prepare($insertQuery);
            
                        if (!$stmt->execute()) {
                        }
                    }
                }
            }elseif($loaiTB == 'baocaothaoluan') {
                $iconTB = '<i class="fas fa-bell notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #dc3545, #dc3545); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'quantri/thaoluanbaocao.php';
        
                $notifications = array();

                $sqlQuery = "SELECT * FROM " . $this->tblQuanTriBV . ";";
                $stmtTB = $this->conn->prepare($sqlQuery);
                $stmtTB->execute();
                $resultTB = $stmtTB->get_result();
        
                while ($quanTriBV = $resultTB->fetch_assoc()) {
                    if ($quanTriBV['maCD'] == $maCD) {
                        $sqlQueryCD = "
                            SELECT *
                            FROM ".$this->tblChuDeBV."
                            WHERE maCD = '".$quanTriBV['maCD']."'";
        
                        $stmtCD = $this->conn->prepare($sqlQueryCD);
                        $stmtCD->execute();
                        $resultCD = $stmtCD->get_result();
                        $chuDeBV = $resultCD->fetch_assoc();
        
                        $countTLBVVP = "
                            SELECT COUNT(DISTINCT t.maTLBV) AS SoLuongTLBVViPham
                            FROM ".$this->tblTLBVViPham." t
                            JOIN ".$this->tblThaoLuanBV." p ON t.maTLBV = p.maTLBV
                            JOIN ".$this->tblBaiViet."  c ON p.maBV = c.maBV
                            WHERE c.maCD = '" . $quanTriBV['maCD'] . "';";
        
                        $stmtCountTLBVVP = $this->conn->prepare($countTLBVVP);
                        $stmtCountTLBVVP->execute();
                        $resultCountTLBVVP = $stmtCountTLBVVP->get_result();
                        $count = $resultCountTLBVVP->fetch_assoc();
                        $soLuongTLBVViPham = $count['SoLuongTLBVViPham'];
                        $noiDungTB = "Bạn có <strong>" . $soLuongTLBVViPham . "</strong> thảo luận vi phạm mới cần kiểm tra trong chủ đề <strong>" . $chuDeBV['tenCD'] . "</strong>";
        
                        $taiKhoan = $quanTriBV['maQuanTri'];
                        $anhTB =  $chuDeBV['anhCD'];
                        $notifications[] = array(
                            'taiKhoan' => $taiKhoan,
                            'anhTB' => $anhTB,
                            'iconTB' => $iconTB,
                            'linkTB' => $linkTB,
                            'noiDungTB' => $noiDungTB,
                        );
                    }
                }
                foreach ($notifications as $notification) {
                    $checkDuplicateQuery = "SELECT * FROM " . $this->tblThongBao . " WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$chuDeBV[tenCD]%';";
                    $stmtDuplicate = $this->conn->prepare($checkDuplicateQuery);
                    $stmtDuplicate->execute();
                    $resultDuplicate = $stmtDuplicate->get_result();
            
                    if ($resultDuplicate->num_rows > 0) {
                        $updateQuery = "UPDATE " . $this->tblThongBao . " SET noiDungTB = '$notification[noiDungTB]', ngayDangTB = current_timestamp(), trangThaiTB = '0', trangThaiXemTB = '0' WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$chuDeBV[tenCD]%';";
                        $stmtUpdate = $this->conn->prepare($updateQuery);
            
                        if (!$stmtUpdate->execute()) {
                        }
                    } else {
                        $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`,`anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) VALUES (NULL, '$notification[taiKhoan]', '$notification[anhTB]', '$notification[iconTB]', '$notification[linkTB]', '$notification[noiDungTB]', current_timestamp(), '0', '0');";
                        $stmt = $this->conn->prepare($insertQuery);
            
                        if (!$stmt->execute()) {
                        }
                    }
                }
            }else {
                $iconTB = '<i class="fas fa-users notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'diendan/chitietbaiviet.php?maBV='.$maBV;

                $sqlQueryTK = "
                    SELECT *
                    FROM " . $this->tblNguoiDung . "
                    WHERE taiKhoan = '" . $taiKhoanDangBai . "'";
        
                $stmtTK = $this->conn->prepare($sqlQueryTK);
                $stmtTK->execute();
                $resultTK = $stmtTK->get_result();
                $chiTietTK = $resultTK->fetch_assoc();
                $anhTB = $chiTietTK['anhDaiDien'];
                $notifications = array();
                $sqlQuery = "
                    SELECT *
                    FROM " . $this->tblTheoDoiChuDe . ";";
        
                $stmtTB = $this->conn->prepare($sqlQuery);
                $stmtTB->execute();
                $resultTB = $stmtTB->get_result();
        
                while ($theoDoiCD = $resultTB->fetch_assoc()) {
                    if ($theoDoiCD['maCD'] == $maCD and $theoDoiCD['taiKhoan'] != $taiKhoanDangBai) {
                        $sqlQueryCD = "
                            SELECT tenCD
                            FROM " . $this->tblChuDeBV . "
                            WHERE maCD = '" . $theoDoiCD['maCD'] . "'";
        
                        $stmtCD = $this->conn->prepare($sqlQueryCD);
                        $stmtCD->execute();
                        $resultCD = $stmtCD->get_result();
                        $chuDeBV = $resultCD->fetch_assoc();
                        $noiDungTB = "<strong>" . $taiKhoanDangBai . "</strong> đã thêm bài viết mới trong chủ đề <strong>" . $chuDeBV['tenCD'] . "</strong>";
                        $taiKhoan = $theoDoiCD['taiKhoan'];
                        $notifications[] = array(
                            'taiKhoan' => $taiKhoan,
                            'anhTB' => $anhTB,
                            'iconTB' => $iconTB,
                            'linkTB' => $linkTB,
                            'noiDungTB' => $noiDungTB,
                        );
                    }
                }

                foreach ($notifications as $notification) {
                    $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`, `anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) VALUES (NULL, '$notification[taiKhoan]', '$notification[anhTB]', '$notification[iconTB]', '$notification[linkTB]', '$notification[noiDungTB]', current_timestamp(), '0', '0');";
                    $stmt = $this->conn->prepare($insertQuery);
        
                    if (!$stmt->execute()) {
                    }
                }    
            }
        }

        public function themTBPhanHoiBV($taiKhoanDangBai, $taiKhoanPhanHoi, $loaiTB, $maCD, $maBV, $maTLBV, $taiKhoanDuocPhanHoi) {
            if($loaiTB == 'binhluan' and $taiKhoanPhanHoi != $taiKhoanDangBai) {
                $iconTB = '<i class="fas fa-comment-alt notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'diendan/chitietbaiviet.php?maBV='.$maBV.'#comment-'.$maTLBV;
                $sqlQueryCD = "
                            SELECT tenCD
                            FROM " . $this->tblChuDeBV . "
                            WHERE maCD = '" . $maCD . "'";
        
                $stmtCD = $this->conn->prepare($sqlQueryCD);
                $stmtCD->execute();
                $resultCD = $stmtCD->get_result();
                $chuDeBV = $resultCD->fetch_assoc();

                $sqlQuery = "
                SELECT COUNT(*) AS soLuongThaoLuan 
                FROM ".$this->tblThaoLuanBV."
                WHERE maBV = '".$maBV."'";
                
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->execute();
                $result = $stmt->get_result();	
                $countSLTL = $result->fetch_assoc();

                if ($countSLTL['soLuongThaoLuan'] <= 1) {
                    $noiDungTB = "<strong>".$taiKhoanPhanHoi."</strong> đã bình luận về bài viết của bạn trong chủ đề <strong>" . $chuDeBV['tenCD'] . "</strong>";
                } else {
                    $countSLTL = $countSLTL['soLuongThaoLuan'] - 1;
                    $noiDungTB = "<strong>".$taiKhoanPhanHoi." và ".$countSLTL." người khác</strong> đã bình luận về bài viết của bạn trong chủ đề <strong>" . $chuDeBV['tenCD'] . "</strong>";
                }

                $sqlQueryTK = "
                    SELECT *
                    FROM " . $this->tblNguoiDung . "
                    WHERE taiKhoan = '" . $taiKhoanPhanHoi . "'";
        
                $stmtTK = $this->conn->prepare($sqlQueryTK);
                $stmtTK->execute();
                $resultTK = $stmtTK->get_result();
                $chiTietTK = $resultTK->fetch_assoc();
                $anhTB = $chiTietTK['anhDaiDien'];
                $taiKhoan = $taiKhoanDuocPhanHoi;
                $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`, `anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) 
                            VALUES (NULL, '$taiKhoan', '$anhTB', '$iconTB', '$linkTB', '$noiDungTB', current_timestamp(), '0', '0');";
                            
                $stmt = $this->conn->prepare($insertQuery);

                if ($stmt->execute()) {
                    return true;
                }
            }
            if($loaiTB == 'phanhoi' and $taiKhoanPhanHoi != $taiKhoanDuocPhanHoi) {
                $iconTB = '<i class="fas fa-comment-alt notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #0070E1, #14ABFE); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'diendan/chitietbaiviet.php?maBV='.$maBV.'#comment-'.$maTLBV;
                $sqlQueryCD = "
                            SELECT tenCD
                            FROM " . $this->tblChuDeBV . "
                            WHERE maCD = '" . $maCD . "'";
        
                $stmtCD = $this->conn->prepare($sqlQueryCD);
                $stmtCD->execute();
                $resultCD = $stmtCD->get_result();
                $chuDeBV = $resultCD->fetch_assoc();

                $noiDungTB = "<strong>".$taiKhoanPhanHoi."</strong> đã trả lời bình luận của bạn trong chủ đề <strong>" . $chuDeBV['tenCD'] . "</strong>";

                $sqlQueryTK = "
                    SELECT *
                    FROM " . $this->tblNguoiDung . "
                    WHERE taiKhoan = '" . $taiKhoanPhanHoi . "'";
        
                $stmtTK = $this->conn->prepare($sqlQueryTK);
                $stmtTK->execute();
                $resultTK = $stmtTK->get_result();
                $chiTietTK = $resultTK->fetch_assoc();
                $anhTB = $chiTietTK['anhDaiDien'];

                $taiKhoan = $taiKhoanDuocPhanHoi;

                $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`, `anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) 
                            VALUES (NULL, '$taiKhoan', '$anhTB', '$iconTB', '$linkTB', '$noiDungTB', current_timestamp(), '0', '0');";
                            
                $stmt = $this->conn->prepare($insertQuery);

                if ($stmt->execute()) {
                    return true;
                }
            }
        }
        
        public function themTBTL($taiKhoanDangBai, $taiKhoanYeuThich, $loaiTB, $maLoaiTL, $maTL) {
            if ($loaiTB == 'admin') {
                $iconTB = '<i class="fas fa-file notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-color: #67e486; font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'quantri/tailieukiemduyet.php';
        
                $notifications = array();

                $sqlQuery = "SELECT * FROM " . $this->tblQuanTriTL . ";";
                $stmtTB = $this->conn->prepare($sqlQuery);
                $stmtTB->execute();
                $resultTB = $stmtTB->get_result();
        
                while ($quanTriTL = $resultTB->fetch_assoc()) {
                    if ($quanTriTL['maLoaiTL'] == $maLoaiTL) {
                        $sqlQueryLTL = "
                            SELECT *
                            FROM " . $this->tblLoaiTaiLieu . "
                            WHERE maLoaiTL = '" . $quanTriTL['maLoaiTL'] . "'";
        
                        $stmtLTL = $this->conn->prepare($sqlQueryLTL);
                        $stmtLTL->execute();
                        $resultLTL = $stmtLTL->get_result();
                        $loaiTaiLieu = $resultLTL->fetch_assoc();
        
                        $countTL = "
                            SELECT COUNT(*) AS soLuongTLChuaDuyet 
                            FROM " . $this->tblTaiLieu . "
                            WHERE ( trangThaiTL = 'chuaduyet' OR trangThaiTL = 'chinhsua') AND maLoaiTL = '" . $quanTriTL['maLoaiTL'] . "';";
        
                        $stmtCountTL = $this->conn->prepare($countTL);
                        $stmtCountTL->execute();
                        $resultCountTL = $stmtCountTL->get_result();
                        $count = $resultCountTL->fetch_assoc();
                        $soLuongTLChuaDuyet = $count['soLuongTLChuaDuyet'];
                        $noiDungTB = "Bạn có <strong>" . $soLuongTLChuaDuyet . "</strong> tài liệu mới cần duyệt trong chủ đề <strong>" . $loaiTaiLieu['tenLoaiTL'] . "</strong>";
        
                        $taiKhoan = $quanTriTL['maQuanTri'];
                        $anhTB = '../image/hqtcsdl.jpg';
                        $notifications[] = array(
                            'taiKhoan' => $taiKhoan,
                            'anhTB' => $anhTB,
                            'iconTB' => $iconTB,
                            'linkTB' => $linkTB,
                            'noiDungTB' => $noiDungTB,
                        );
                    }
                }
                foreach ($notifications as $notification) {
                    $checkDuplicateQuery = "SELECT * FROM " . $this->tblThongBao . " WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$loaiTaiLieu[tenLoaiTL]%';";
                    $stmtDuplicate = $this->conn->prepare($checkDuplicateQuery);
                    $stmtDuplicate->execute();
                    $resultDuplicate = $stmtDuplicate->get_result();
            
                    if ($resultDuplicate->num_rows > 0) {
                        $updateQuery = "UPDATE " . $this->tblThongBao . " SET noiDungTB = '$notification[noiDungTB]', ngayDangTB = current_timestamp(), trangThaiTB = '0', trangThaiXemTB = '0' WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$loaiTaiLieu[tenLoaiTL]%';";
                        $stmtUpdate = $this->conn->prepare($updateQuery);
            
                        if (!$stmtUpdate->execute()) {
                        }
                    } else {
                        $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`,`anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) VALUES (NULL, '$notification[taiKhoan]', '$notification[anhTB]', '$notification[iconTB]', '$notification[linkTB]', '$notification[noiDungTB]', current_timestamp(), '0', '0');";
                        $stmt = $this->conn->prepare($insertQuery);
            
                        if (!$stmt->execute()) {
                        }
                    }
                }
            }elseif($loaiTB == 'duyettailieu') {
                $iconTB = '<i class="fas fa-file notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-color: #67e486; font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'quantri/tailieukiemduyet.php';
                $linkTB = 'tailieu/chitiettailieu.php?maTL='.$maTL;
                $sqlQueryLTL = "
                            SELECT *
                            FROM " . $this->tblLoaiTaiLieu . "
                            WHERE maLoaiTL = '" . $maLoaiTL. "'";
        
                $stmtLTL = $this->conn->prepare($sqlQueryLTL);
                $stmtLTL->execute();
                $resultLTL = $stmtLTL->get_result();
                $loaiTaiLieu = $resultLTL->fetch_assoc();
                $noiDungTB = "Tài liệu của bạn đã được đăng trong chủ đề <strong>" . $loaiTaiLieu['tenLoaiTL'] . "</strong>";
                $taiKhoan = $taiKhoanDangBai;
                $anhTB = $loaiTaiLieu['anhLoaiTL'];
                $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`, `anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) 
                            VALUES (NULL, '$taiKhoan', '$anhTB', '$iconTB', '$linkTB', '$noiDungTB', current_timestamp(), '0', '0');";
                            
                $stmt = $this->conn->prepare($insertQuery);

                if ($stmt->execute()) {
                    return true;
                }
            }elseif($loaiTB == 'baocaotailieu') {
                $iconTB = '<i class="fas fa-bell notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #dc3545, #dc3545); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'quantri/tailieubaocao.php';
        
                $notifications = array();

                $sqlQuery = "SELECT * FROM " . $this->tblQuanTriTL . ";";
                $stmtTB = $this->conn->prepare($sqlQuery);
                $stmtTB->execute();
                $resultTB = $stmtTB->get_result();
        
                while ($quanTriTL = $resultTB->fetch_assoc()) {
                    if ($quanTriTL['maLoaiTL'] == $maLoaiTL) {
                        $sqlQueryLTL = "
                            SELECT *
                            FROM " . $this->tblLoaiTaiLieu . "
                            WHERE maLoaiTL = '" . $quanTriTL['maLoaiTL'] . "'";
        
                        $stmtLTL = $this->conn->prepare($sqlQueryLTL);
                        $stmtLTL->execute();
                        $resultLTL = $stmtLTL->get_result();
                        $loaiTaiLieu = $resultLTL->fetch_assoc();
        
                        $countTL = "
                            SELECT COUNT(DISTINCT t.maTL) AS SoLuongTLViPham
                            FROM  " . $this->tblTaiLieuViPham . " t
                            JOIN  " . $this->tblTaiLieu . " p ON t.maTL = p.maTL
                            WHERE p.maLoaiTL = '" . $quanTriTL['maLoaiTL'] . "';";
        
                        $stmtCountTLVP = $this->conn->prepare($countTL);
                        $stmtCountTLVP->execute();
                        $resultCountTLVP = $stmtCountTLVP->get_result();
                        $count = $resultCountTLVP->fetch_assoc();
                        $soLuongTLVP = $count['SoLuongTLViPham'];
                        $noiDungTB = "Bạn có <strong>" . $soLuongTLVP . "</strong> tài liệu vi phạm mới cần kiểm tra trong chủ đề <strong>" . $loaiTaiLieu['tenLoaiTL'] . "</strong>";
        
                        $taiKhoan = $quanTriTL['maQuanTri'];
                        $anhTB =  $loaiTaiLieu['anhLoaiTL'];
                        $notifications[] = array(
                            'taiKhoan' => $taiKhoan,
                            'anhTB' => $anhTB,
                            'iconTB' => $iconTB,
                            'linkTB' => $linkTB,
                            'noiDungTB' => $noiDungTB,
                        );
                    }
                }
                foreach ($notifications as $notification) {
                    $checkDuplicateQuery = "SELECT * FROM " . $this->tblThongBao . " WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$loaiTaiLieu[tenLoaiTL]%';";
                    $stmtDuplicate = $this->conn->prepare($checkDuplicateQuery);
                    $stmtDuplicate->execute();
                    $resultDuplicate = $stmtDuplicate->get_result();
            
                    if ($resultDuplicate->num_rows > 0) {
                        $updateQuery = "UPDATE " . $this->tblThongBao . " SET noiDungTB = '$notification[noiDungTB]', ngayDangTB = current_timestamp(), trangThaiTB = '0', trangThaiXemTB = '0' WHERE taiKhoan = '$notification[taiKhoan]' AND iconTB = '$notification[iconTB]' AND linkTB = '$notification[linkTB]' AND noiDungTB LIKE '%$loaiTaiLieu[tenLoaiTL]%';";
                        $stmtUpdate = $this->conn->prepare($updateQuery);
            
                        if (!$stmtUpdate->execute()) {
                        }
                    } else {
                        $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`,`anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) VALUES (NULL, '$notification[taiKhoan]', '$notification[anhTB]', '$notification[iconTB]', '$notification[linkTB]', '$notification[noiDungTB]', current_timestamp(), '0', '0');";
                        $stmt = $this->conn->prepare($insertQuery);
            
                        if (!$stmt->execute()) {
                        }
                    }
                }
            }elseif($loaiTB == 'yeuthichtailieu' and $taiKhoanDangBai != $taiKhoanYeuThich) {
                $iconTB = '<i class="fas fa-heart notification-reaction" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 30px; color: white; background-image: linear-gradient(45deg, #fc4c51, #fd6292); font-size: 14px; position: absolute; bottom: 16px; left: 46px !important;"></i>';
                $linkTB = 'tailieu/chitiettailieu.php?maTL='.$maTL;
                $sqlQueryLTL = "
                        SELECT *
                        FROM " . $this->tblLoaiTaiLieu . "
                        WHERE maLoaiTL = '" . $maLoaiTL. "'";
    
                $stmtLTL = $this->conn->prepare($sqlQueryLTL);
                $stmtLTL->execute();
                $resultLTL = $stmtLTL->get_result();
                $loaiTaiLieu = $resultLTL->fetch_assoc();

                $sqlQueryTK = "
                    SELECT *
                    FROM " . $this->tblNguoiDung . "
                    WHERE taiKhoan = '" . $taiKhoanYeuThich. "'";
        
                $stmtTK = $this->conn->prepare($sqlQueryTK);
                $stmtTK->execute();
                $resultTK = $stmtTK->get_result();
                $chiTietTK = $resultTK->fetch_assoc();
                $anhTB = $chiTietTK['anhDaiDien'];

                $taiKhoan = $taiKhoanDangBai;

                $countYTTL = "
                        SELECT COUNT(*) AS SoLuongYeuThicTL
                        FROM  " . $this->tblTLYeuThich . "
                        WHERE maTL = '" . $maTL . "';";
    
                $stmtCountYTTL = $this->conn->prepare($countYTTL);
                $stmtCountYTTL->execute();
                $resultCountYTTL = $stmtCountYTTL->get_result();
                $count = $resultCountYTTL->fetch_assoc();
                $soLuongYTTL = $count['SoLuongYeuThicTL'] - 1;
                
                if($soLuongYTTL > 1) {
                    $noiDungTB = "<strong>".$taiKhoanYeuThich."</strong> và <strong>".$soLuongYTTL." người khác</strong> đã yêu thích tài liệu của bạn trong loại tài liệu <strong>" . $loaiTaiLieu['tenLoaiTL'] . "</strong>";
                    $updateQuery = "UPDATE " . $this->tblThongBao . " SET noiDungTB = '$noiDungTB', ngayDangTB = current_timestamp(), trangThaiTB = '0', trangThaiXemTB = '0' WHERE taiKhoan = '$taiKhoan' AND iconTB = '$iconTB' AND linkTB = '$linkTB' AND noiDungTB LIKE '%$loaiTaiLieu[tenLoaiTL]%';";
                    $stmtUpdate = $this->conn->prepare($updateQuery);
        
                    if (!$stmtUpdate->execute()) {
                }
                }else {
                    $noiDungTB = "<strong>".$taiKhoanYeuThich."</strong> đã yêu thích tài liệu của bạn trong loại tài liệu <strong>" . $loaiTaiLieu['tenLoaiTL'] . "</strong>";
                    $insertQuery = "INSERT INTO " . $this->tblThongBao . "(`maTB`, `taiKhoan`, `anhTB`, `iconTB`, `linkTB`, `noiDungTB`, `ngayDangTB`, `trangThaiTB`, `trangThaiXemTB`) 
                            VALUES (NULL, '$taiKhoan', '$anhTB', '$iconTB', '$linkTB', '$noiDungTB', current_timestamp(), '0', '0');";
                    $stmt = $this->conn->prepare($insertQuery);
        
                    if (!$stmt->execute()) {
                    }
                }
            }
        }
    }
?>