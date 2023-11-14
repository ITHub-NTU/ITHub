<?php
include_once '../config/Database.php';
if (isset($_SESSION['hoatdong'])) {
    if (isset($_GET['pdf'])) {
        $pdfFilePath = $_GET['pdf'];

        // Kiểm tra xem tệp PDF tồn tại
        if (file_exists($pdfFilePath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($pdfFilePath) . '"');
            readfile($pdfFilePath);
            exit; // Kết thúc chương trình sau khi tải xong
        }
        // Tệp không tồn tại, chuyển hướng
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    // Không phải file pdf, không có tham số 'pdf'
    // Chuyển hướng về trang chính
    header('Location: index.php');
    exit;
}
else {
    header("Location: ../nguoidung/dangnhap.php"); // Chuyển người dùng về trang tải tài liệu sau khi đăng nhập thành công.
}
?>
