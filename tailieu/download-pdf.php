<?php
if (isset($_GET['pdf'])) {
    $pdfFilePath = $_GET['pdf'];

    // Kiểm tra xem tệp PDF tồn tại
    if (file_exists($pdfFilePath)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($pdfFilePath) . '"');
        readfile($pdfFilePath);
    } else {
        echo 'Lỗi: Tệp PDF không tồn tại.';
    }
} else {
    echo 'Lỗi: Không tìm thấy tệp PDF để tải về.';
}
?>
