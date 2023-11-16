<?php
include_once '../config/Database.php';
include_once '../class/ThongBao.php';
include_once '../class/NguoiDung.php';
include_once '../class/ChuDeBV.php';
include_once '../class/BaiViet.php';
include_once '../class/TienIch.php';
$database = new Database();
$db = $database->getConnection();
$tblThongBao = new ThongBao($db);
$tblNguoiDung = new NguoiDung($db);
$tblChuDeBV = new ChuDeBV($db);
$tblBaiViet = new BaiViet($db);
$tienIch = new TienIch();

if (isset($_POST['view'])) {
    $queryBVMN = "
    SELECT bv.*, cd.tenCD
    FROM tblbaiviet bv
    JOIN tblchudebv cd ON bv.maCD = cd.maCD
    WHERE bv.trangThaiBV = 'daduyet' or bv.trangThaiBV = 'dachinhsua'
    ORDER BY bv.ngayDuyetBV DESC LIMIT 5;";
    $resultBVMN = $db->query($queryBVMN);
    $output = '
    <div class="card mb-3">
            <h5 class="d-flex card-header" style="background-color:cadetblue">
                Bài viết mới nhất
            </h5>
            <div class="card-body" style="padding-bottom:0; font-weight:bold">';
    
    if ($resultBVMN->num_rows > 0) {
        while ($chiTietBaiViet = $resultBVMN->fetch_assoc()) {
            $thongTinNguoiDung = $tblNguoiDung->getUserInfoByTaiKhoan($chiTietBaiViet['taiKhoan']);
            $anhND = $thongTinNguoiDung['anhDaiDien'];
            $folderImg = "../image/";
            if (file_exists($folderImg . $anhND)) {
                $folderImg .= $anhND;
            } else {
                $folderImg .= "user.png";
            }

            if(!empty($chiTietBaiViet['ngayDuyetBV'])) {
				$timestamp = strtotime($chiTietBaiViet['ngayDuyetBV']);
			}else {
				$timestamp = NULL;
			}
            $output .= '
            <div class="d-flex mb-3">
                <a href="#">
                    <img style="width: 50px; height: 50px; object-fit: cover;" class="user-avatar rounded-circle" src="'.$folderImg.'" alt="User Avatar">
                </a>
                
                <div style="padding-left: 15px; line-height: 1.5">
                    <a class="text-decoration-none" href="chitietbaiviet.php?maBV='.$chiTietBaiViet['maBV'].'" style="font-size: 15px;">
                        <p style="font-size: 15px;margin-bottom:0;-webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;  white-space: normal; word-wrap: break-word"> 
                            '.$chiTietBaiViet['tenBV'].'
                        </p>
                        <small><p class="d-flex;" style="margin-bottom:0; color: #8f9193"><span>'.$chiTietBaiViet['taiKhoan'].' </span><i style="font-size:5px" class="fas fa-circle"></i><span> '.$tienIch->formatTimeAgo($timestamp).'</span></p></small>
                    </a>
                    <a class="text-decoration-none" href="danhsachbaiviet.php?maCD='.$chiTietBaiViet['maCD'].'" title="Chủ đề bài viết"><span style=" color: #8f9193; font-size: 15px;"><small>'.$chiTietBaiViet['tenCD'].'</small></span></a>
                </div>
            </div>   
            ';
            
        }
    }

    $output .= '</div> </div>';
    $danhSachQuanTriVienTrucTuyen = $tblNguoiDung->layThongTinQuanTriTrucTuyen('tblquantribv');
    if ($danhSachQuanTriVienTrucTuyen->num_rows > 0) {
        $output .= '
        <div class="card mb-3">
            <h5 class="d-flex card-header" style="background-color:cadetblue">
                Quản trị viên trực tuyến
            </h5>
            <div class="card-body" style="padding-bottom:0; font-weight:bold">';
        while ($quanTriVien = $danhSachQuanTriVienTrucTuyen->fetch_assoc()) {
            $danhSachChuDeQT = $tblNguoiDung->layChuDeQT($quanTriVien['taiKhoan']);
            $anhDaiDien = $quanTriVien['anhDaiDien'];
            $folder = "../image/".$anhDaiDien;
            $output .= '
            <div class="d-flex mb-3">
                <a>
                    <img style="width: 50px; height: 50px; object-fit: cover;border: 3px solid green;" class="user-avatar rounded-circle" src="'.$folder.'" alt="User Avatar">
                </a>
                
                <div class="row" style="padding-left: 15px; line-height: 1.5;">
                    <a style="font-size: 15px;">
                        '.$quanTriVien['taiKhoan'].'
                    </a>
                    <div class="d-flex" style="font-size: 12px;  white-space: nowrap;">
                        ['.$danhSachChuDeQT.']
                    </div>
                </div>
            </div>   
            ';
        }
    } else {
        $output .= '
        <div class="card mb-3">
            <h5 class="d-flex card-header" style="background-color:cadetblue">
                Quản trị viên trực tuyến
            </h5>
            <div class="card-body" style="padding-bottom:0; color: #8f9193;">
                <p>Không có quản trị viên hoạt động</p>
            </div>
        </div>';
    }
    $soLuongCD = ($tblChuDeBV->layDSChuDeBV()->num_rows);
    $soLuongBV = $tblBaiViet->layTongBaiViet();
    $soLuongTL = $tblBaiViet->layTongThaoLuan();
    $soLuongTV = $tblNguoiDung->layTongTaiKhoan();
    $output .= '
    </div></div>
    <div class="card mb-3">
        <h5 class="d-flex card-header" style="background-color:cadetblue">
            Thống kê diễn đàn
        </h5>
        <div class="card-body" style="padding-bottom:0; color: #8f9193;">
            <p>Chủ đề: '.$soLuongCD.' </p>
            <p>Bài viết: '.$soLuongBV.' </p>
            <p>Thảo luận: '.$soLuongTL.' </p>
            <p>Thành viên: '.$soLuongTV.' </p>
        </div>
    </div>';

    $data = array(
        'rightmenu' => $output,
    );

    echo json_encode($data);
}
?>