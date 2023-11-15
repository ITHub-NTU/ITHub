<?php 
    include_once '../config/Database.php';
    include_once '../class/NguoiDung.php';
    include "auth.php";
	$database = new Database();
	$db = $database->getConnection();
    $tblNguoiDung = new NguoiDung($db);
    $directory = "uploads_chat";
    $files = glob($directory . "/*");
    $pattern = "/\bhttps?:\/\/\S+\b/";
    $yourDomain = "localhost";
    $fileNames = array();
    include_once '../fonts/emoji.php';
    foreach ($files as $file) {
        if (is_file($file)) {
            $fileNames[] = basename($file);
        }
    }
    
    if(isset($_SESSION['room']))
	{
		$room = $_SESSION['room'];
        if($room == 'quantrivien_quantrivien') {
            echo "Xin chào quản trị viên!";
        }else {
            $readSql = "SELECT * FROM `$room`";
        $readResult = $db->query($readSql);
        if(mysqli_num_rows($readResult)>0)
        {
            while($data = mysqli_fetch_assoc($readResult))
            {
                $gettaiKhoan = $data['taiKhoan'];
                $getMsg = $data['msg'];
                $getDate = substr($data['date'],0,-3);
                $getImg = $tblNguoiDung->getUserInfoByTaiKhoan($gettaiKhoan);
                $anhDaiDien = $getImg['anhDaiDien'];
                $folder = "img/";

                if (file_exists($folder . $anhDaiDien)) {
                    $folder .= $anhDaiDien;
                } else {
                    $folder .= "user.jpg";
                }
                if ($gettaiKhoan != $taiKhoan) {
                    echo "<li class='sent'>";
                    echo "<img src='$folder' alt='friend' />";
                    if (preg_match($pattern, $getMsg, $matches)) {
                        $getMsg = preg_replace_callback($pattern, function($match) use ($yourDomain) {
                            $urlToCheck = $match[0];
                            $parsedUrl = parse_url($urlToCheck);
                            if (isset($parsedUrl['host'])) {
                                $urlDomain = $parsedUrl['host'];
                                if (strpos($urlDomain, $yourDomain) === 0) {
                                    return '<a style="color:white; word-wrap: break-word;" href="' . $urlToCheck . '">' . $urlToCheck . '</a>';
                                } else {
                                    return '<a style="color:white; word-wrap: break-word;" href="' . $urlToCheck . '" target="_blank" onclick="return confirm(\'Cảnh báo! Đường dẫn này sẽ đưa bạn rời khỏi trang web của chúng tôi. Bạn có muốn truy cập đường dẫn này không?\');">' . $urlToCheck . '</a>';
                                }
                            }
                            return $urlToCheck;
                        }, $getMsg);
                        echo "<p style='word-wrap: break-word;'>" . $getMsg . "</p>";
                    }elseif (in_array($getMsg, $fileNames)) {
                        $imageInfo = getimagesize('uploads_chat/' . $getMsg);
                        if ($imageInfo && in_array($imageInfo['mime'], array('image/jpeg', 'image/png', 'image/gif'))) {
                            echo '<p style="position: relative; background: none;">';
                            echo '<a style="text-decoration: none; color: black; font-weight: bold;text-align: center; display: flex; align-items: center;margin-left:-11px" href="uploads_chat/' . $getMsg . '" download="' . $getMsg . '">';
                            echo '<img class="img_reply" style="max-width: 100%; max-height: 100%; width: auto; height: auto; border-radius: 10px;" src="uploads_chat/' . $getMsg . '" alt="' . $getMsg . '" />';
                            echo '<i class="fa fa-download" aria-hidden="true" ></i>';
                            echo '</a>';
                            echo '</p>';
                        } else {
                            $maxFileNameLength = 15;
                            $fileNameWithoutExtension = pathinfo($getMsg, PATHINFO_FILENAME);
                            $fileExtension = pathinfo($getMsg, PATHINFO_EXTENSION);
                            if (strlen($fileNameWithoutExtension) > $maxFileNameLength) {
                                $shortenedFileName = substr($fileNameWithoutExtension, 0, $maxFileNameLength) . '...';
                            } else {
                                $shortenedFileName = $fileNameWithoutExtension;
                            }
                            $finalFileName = $shortenedFileName . '.' . $fileExtension;
                            echo '<p><a style="text-decoration: none; color: black; font-weight: bold;" href="uploads_chat/' . $getMsg . '" download="' . $getMsg . '">' . $finalFileName . ' <i class="fa fa-download" aria-hidden="true"></i></a></p>';
                        }
                    } else {
                        echo "<p style='word-wrap: break-word;'>".$data['msg']."</p>";
                    }
                    echo "</li>";
                    echo "<p class='timestamp'>".$getDate."</p>";
                    
                }
                
                else
                {
                    $gettaiKhoan ="You";
                    echo "<li class='replies'>";
                    echo "<img src='$folder' alt='friend' />";
                    
                    if (preg_match($pattern, $getMsg, $matches)) {
                        $getMsg = preg_replace_callback($pattern, function($match) use ($yourDomain) {
                            $urlToCheck = $match[0];
                            $parsedUrl = parse_url($urlToCheck);
                            if (isset($parsedUrl['host'])) {
                                $urlDomain = $parsedUrl['host'];
                                if (strpos($urlDomain, $yourDomain) === 0) {
                                    return '<a style="word-wrap: break-word;" href="' . $urlToCheck . '">' . $urlToCheck . '</a>';
                                } else {
                                    return '<a style="word-wrap: break-word;" href="' . $urlToCheck . '" target="_blank" onclick="return confirm(\'Cảnh báo! Đường dẫn này sẽ đưa bạn rời khỏi trang web của chúng tôi. Bạn có muốn truy cập đường dẫn này không?\');">' . $urlToCheck . '</a>';
                                }
                            }
                            return $urlToCheck;
                        }, $getMsg);
                        echo "<p style='word-wrap: break-word;'>" . $getMsg ."</p>";
                    }elseif (in_array($getMsg, $fileNames)) {
                        $imageInfo = getimagesize('uploads_chat/' . $getMsg);
                        if ($imageInfo && in_array($imageInfo['mime'], array('image/jpeg', 'image/png', 'image/gif'))) {
                            echo '<p style="position: relative; background: none;">';
                            echo '<a style="text-decoration: none; color: black; font-weight: bold;text-align: center; display: flex; align-items: center;padding-right:9px" href="uploads_chat/' . $getMsg . '" download="' . $getMsg . '">';
                            echo '<i class="fa fa-download" aria-hidden="true" ></i>';
                            echo '<img class="img_reply" style="max-width: 100%; max-height: 100%; width: auto; height: auto; border-radius: 10px;" src="uploads_chat/' . $getMsg . '" alt="' . $getMsg . '" />';
                            echo '</a>';
                            echo '</p>';
                        } else {
                            $maxFileNameLength = 15;
                            $fileNameWithoutExtension = pathinfo($getMsg, PATHINFO_FILENAME);
                            $fileExtension = pathinfo($getMsg, PATHINFO_EXTENSION);
                            if (strlen($fileNameWithoutExtension) > $maxFileNameLength) {
                                $shortenedFileName = substr($fileNameWithoutExtension, 0, $maxFileNameLength) . '...';
                            } else {
                                $shortenedFileName = $fileNameWithoutExtension;
                            }
                            $finalFileName = $shortenedFileName . '.' . $fileExtension;
                            echo '<p><a style="text-decoration: none; color: black; font-weight: bold;" href="uploads_chat/' . $getMsg . '" download="' . $getMsg . '">' . $finalFileName . ' <i class="fa fa-download" aria-hidden="true"></i></a></p>';
                        }

                    } else {
                        echo "<p style='word-wrap: break-word;'>".$data['msg']."</p>";
                    }
                    echo "</li>";
                    echo "<p class='right-timestamp'>".$getDate."</p>";
                    
                }
                
            }
        }
        }       
    }
?>