<?php 
    class TienIch {
        function formatTimeAgo($timestamp) {
            $datetime = date('Y-m-d H:i:s');
            $now = strtotime($datetime) + 18000;
            $diff = $now - $timestamp ;
        
            if ($diff < 60) {
                return 'Vừa xong';
            }elseif ($diff < 3600) {
                return floor($diff / 60) . ' phút trước';
            } elseif ($diff < 86400) {
                return floor($diff / 3600) . ' giờ trước';
            } elseif ($diff < 604800) {
                return floor($diff / 86400) . ' ngày trước';
            } elseif ($diff < 2419200) {
                return floor($diff / 604800) . ' tuần trước';
            } elseif ($diff < 29030400) {
                return floor($diff / 2419200) . ' tháng trước';
            } else {
                return floor($diff / 29030400) . ' năm trước';
            }
        }        

        function autoIncrement($tenBang, $khoa, $maDauTien) {
            include_once '../config/Database.php';
            $database = new Database();
            $db = $database->getConnection();
            $query = "SELECT $khoa FROM $tenBang ORDER BY $khoa DESC LIMIT 1";
            $result = mysqli_query($db, $query);
        
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $currentCode = $row[$khoa];
                $lastPart = substr($currentCode, -8);
                $lastNumber = (int)$lastPart;
                $nextNumber = $lastNumber + 1;
                $nextPart = str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
                $newCode = substr_replace($currentCode, $nextPart, -8);
                return $newCode;
            } else {
                return $maDauTien;
            }
        }    
    }
?>
