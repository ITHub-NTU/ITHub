<?php 
   	include_once '../config/Database.php';
   	include_once '../class/NguoiDung.php';
   	include_once '../fonts/emoji.php';
	include "auth.php";
	$database = new Database();
	$db = $database->getConnection();
	$tblNguoiDung = new NguoiDung($db);

	if(!isset($_SESSION['room']) or empty($_SESSION['room']) or $_SESSION['room'] != 'quantrivien_quantrivien') {
        $room = "quantrivien_".$taiKhoan;
		$findTable = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'ithub' AND TABLE_NAME = '$room'";
        $findResult = $db->query($findTable);
        if($findResult->num_rows > 0) {
            $_SESSION['room'] = $room;
        }
		else {
			$sql = 'CREATE TABLE `ithub`.'.$room.' (
				`sn` INT(128) NOT NULL AUTO_INCREMENT,
				`taiKhoan` VARCHAR(50) NOT NULL,
				`msg` VARCHAR(255) NOT NULL,
				`date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`trangThaiTN` INT(1) NOT NULL,
				`trangThaiXemTN` INT(1) NOT NULL,
				PRIMARY KEY (`sn`),
				CONSTRAINT fk_taiKhoan_'.$room.' FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung`(`taiKhoan`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
		  	';
		  	$result = $db->query($sql);
			if($result) {
				$_SESSION['room'] = $room;
				header("Location:quantrivien.php");
			}
			else {
				$_SESSION['room'] = $room;
			}
		} 
	} 

	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$underscorePosition = strpos($id, '_');
		if ($underscorePosition !== false) {
			$start = substr($id, $underscorePosition + 1);
			$end = substr($id, 0, $underscorePosition);
			if($start !== $taiKhoan and $end !== $taiKhoan) {
				$id = $end.'_'.$taiKhoan;
				header("Location: create.php?id=$id");
			}
		}
		$findTable = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'ithub' AND TABLE_NAME = '$id' AND TABLE_NAME LIKE '%$taiKhoan%'" ;
		$findResult = $db->query($findTable);

		if (mysqli_num_rows($findResult) > 0) {
			$_SESSION['room'] = $id;
		} else {
			$sql = 'CREATE TABLE `ithub`.'.$id.' ( 
				`sn` INT(128) NOT NULL AUTO_INCREMENT , 
				`taiKhoan` VARCHAR(50) NOT NULL ,  
				`msg` VARCHAR(255) NOT NULL , 
				`date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
				`trangThaiTN` INT(1) NOT NULL,
				`trangThaiXemTN` INT(1) NOT NULL, 
				PRIMARY KEY (`sn`)), 
				CONSTRAINT fk_taiKhoan_'.$id.' FOREIGN KEY (`taiKhoan`) REFERENCES `tblnguoidung`(`taiKhoan`) 
				ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
			$result = $db->query($sql);
			if($result) {
				$_SESSION['room'] = $id;
			}
			else {
				$_SESSION['room'] = $id;
			}
		}
	}
	$room = $_SESSION['room'];
	$findRoom = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'ithub' AND TABLE_NAME = '$room'";
	$resultRoom = $db->query($findRoom);
	if($resultRoom->num_rows > 0) {
		$sqlUpdate = "UPDATE `$room` SET `trangThaiTN` = 1, `trangThaiXemTN` = 1 WHERE `taiKhoan` <> '$taiKhoan'";
		$db->query($sqlUpdate);
	}
	$getImg = $tblNguoiDung->getUserInfoByTaiKhoan($taiKhoan);
	$anhDaiDien = $getImg['anhDaiDien'];
	$folder = "../image/";

	if (file_exists($folder . $anhDaiDien)) {
		$folder .= $anhDaiDien;
	} else {
		$folder .= "user.jpg";
	}

	$tblNguoiDung->taiKhoan = $_SESSION['taiKhoan'];
	switch ($tblNguoiDung->getTrangThaiHoatDong()) {
		case 'hoatdong':
			$trangThaiCaNhan = "online";
			break;
		case 'ban':
			$trangThaiCaNhan = "busy";
			break;
		default:
			$trangThaiCaNhan = "offline";
			break;
	}

	$underscorePosition = strpos($_SESSION['room'], '_');
	if ($underscorePosition !== false) {
		$start = substr($_SESSION['room'], $underscorePosition + 1);
		$end = substr($_SESSION['room'], 0, $underscorePosition);
		if($start == $taiKhoan) {
			$finalName = $end;
		} else {
			$finalName = $start;
		}
	}

	$getImgFriend = $tblNguoiDung->getUserInfoByTaiKhoan($finalName);
	$anhDaiDienFriend = $getImgFriend['anhDaiDien'];
	$friendImg = "../image/";

	if (file_exists($friendImg . $anhDaiDienFriend)) {
		$friendImg .= $anhDaiDienFriend;
	} else {
		$friendImg .= "user.jpg";
	}

	$query_TT = "SELECT trangThai FROM tblnguoidung WHERE taiKhoan='$finalName'";
	$result_TT = $db->query($query_TT);

	if ($result_TT) {
		$row = $result_TT->fetch_assoc();
		$trangThai = $row['trangThai'];

		switch ($trangThai) {
			case 'hoatdong':
				$hoatDongBB = "online";
				break;
			case 'ban':
				$hoatDongBB = "busy";
				break;
			default:
				$hoatDongBB = "offline";
				break;
		}
	} else {
		echo"lỗi truy vấn";
	}
	$kiemTraTrangThaiChan = $tblNguoiDung->kiemTraTrangThaiChan($_SESSION['room']);
	if($kiemTraTrangThaiChan->num_rows > 0) {
		$checkcout = TRUE;
		$danhSachNguoiChan = array();
		$danhSachNguoiBiChan = array();
		while($rowTT = $kiemTraTrangThaiChan->fetch_assoc()) {
			$danhSachNguoiChan[] = $rowTT['nguoiChan'];
			$danhSachNguoiBiChan[] = $rowTT['nguoiBiChan'];
		}
	} else {
		$checkcout = FALSE;
	}

	if(isset($_POST['dangxuat'])){
		$tblNguoiDung->logOut();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    
  	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<link rel='stylesheet' href='css/hat.css'>
    <link rel="icon" href="img/n.jpg" type="image/x-icon">
    <title>Trò chuyện | ITHub</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() { 
		$(".submit").click(function() { 
			
			setTimeout(function() {
				smoothScrollToEnd();
			}, 1000);
		});

		function smoothScrollToEnd() {
			var endElement = document.getElementById("end");
			if (endElement) {
				var messagesContainer = $(".messages");
				messagesContainer.animate({
					scrollTop: endElement.offsetTop
				}, 100);
			}
		}


			var typingTimer;
			var doneTypingInterval = 500;
			var searchText = '';
			$('#searchInput').on('input', function() {
				searchText = $(this).val().trim();
				clearTimeout(typingTimer);
				if (searchText === '') {
					return;
				}

				typingTimer = setTimeout(function() {
					$.ajax({
						type: 'POST',
						url: 'hatInput.php',
						data: { searchText: searchText },
						success: function(response) {
							$('#autodata').html(response);
						}
					});
				}, doneTypingInterval);
			});

			setInterval(function() {
				if (searchText === '') {
					$.ajax({
						type: 'POST',
						url: 'hatInput.php',
						data: { searchText: searchText },
						success: function(response) {
							$('#autodata').html(response);
						}
					});
				}
			}, 500);

			setInterval(() => {
				$("#autodata2").load("hatInput2.php");
			}, 500);

			$('#formbox').on("submit", function (e) {
				e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					type: "POST",
					url: "insert.php",
					data: formData,
					processData: false,
					contentType: false,
					success: function () {
						$('#formbox').trigger('reset');
					},
					error: function () {
						alert("ERROR! Message not sent");
					}
				});
			});
		});
        
		// $(".messages").animate({ scrollTop: $(document).height() }, "fast");

		$("#profile-img").click(function() {
			$("#status-options").toggleClass("active");
		});

		$(".expand-button").click(function() {
		$("#profile").toggleClass("expanded");
			$("#contacts").toggleClass("expanded");
		});

		function goBack() {
		window.history.back();
		}

		$(document).ready(function() {
			var messagesContainer = $(".messages");
			var scrollToBottomLink = $('#scrollToBottom');

			scrollToBottom();

			messagesContainer.scroll(function() {
				var isAtBottom = messagesContainer[0].scrollHeight - messagesContainer.scrollTop() === messagesContainer.outerHeight();
				
				if (isAtBottom) {
				scrollToBottomLink.attr('href', '#start');
				scrollToBottomLink.html('<i class="fa fa-arrow-up" aria-hidden="true" title="Cuộn đến đầu trang"></i>');
				} else {
				scrollToBottomLink.attr('href', '#end');
				scrollToBottomLink.html('<i class="fa fa-arrow-down" aria-hidden="true" title="Cuộn đến cuối trang"></i>');
				}
			});
			function scrollToBottom() {
				messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
			}
		});

	</script>
</head>
<body>
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<a class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation" aria-expanded="false" style="line-height: 60px;">
					<img id="profile-img" src="<?php echo $folder?>" class="<?php echo $trangThaiCaNhan ?>" alt="" />
					<p><?php echo $_SESSION['taiKhoan'];?></p>
					<i class="fa fa-chevron-right expand-button" aria-hidden="true"></i>
    			</a>
				<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel" style="  min-width: 280px; max-width: 340px; width: 40%;">
					<div class="offcanvas-header">
						<h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
							<img id="profile-img" src="<?php echo $folder?>" class="<?php echo $trangThaiCaNhan ?>" alt="" />
							<p style="padding-top: 10px;"><?php echo $_SESSION['taiKhoan'];?></p>
						</h5>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<div class="offcanvas-body">
						<ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
							<a class="dropdown-item" href="../nguoidung/trangcanhan.php"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;Thông tin cá nhân</a>
							<a class="dropdown-item" href="danhsachchantinnnhan.php"><i class="fa fa-user-times" aria-hidden="true"></i>&nbsp;&nbsp;Tin nhắn đã chặn</a>
							<a class="dropdown-item" href="../nguoidung/changepassword.php"><i class="fa fa-unlock-alt" aria-hidden="true"></i>&nbsp;&nbsp;Đổi mật khẩu</a>
							<div class="dropdown-divider"></div>
							<form method="post">
								<button type="submit" name="dangxuat" class="dropdown-item" href="#">
								<i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;&nbsp;Đăng xuất
								</button>
                            </form>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" id="searchInput" placeholder="Tìm kiếm cuộc trò chuyện..." />
		</div>
		<div id="contacts">
			<ul id="autodata">

			</ul>
		</div>
		<div id="bottom-bar">
			<a href="themtrochuyen.php" style="text-decoration:none; color:white;" ><button id="addcontact" style="width:100%">
				<i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Thêm trò chuyện mới</span>
			</button></a>
		</div>
	</div>
	<div class="content">
		<div class="contact-profile">
			<img id="friend-img" src="<?php echo $friendImg; ?>" class="<?php echo $hoatDongBB ?>" alt="friend" />
			<p><?php
                echo $finalName;
                ?></p>
			<div class="social-media">
				<a href='../diendan/chudebaiviet.php'><i class="fa fa-home" aria-hidden="true"></i></a>
				<a href='#end' id='scrollToBottom'><i class="fa fa-arrow-down" aria-hidden="true" title="Cuộn đến cuối trang"></i></a>
				<?php if($checkcout or $finalName == 'quantrivien') {?>
				<?php } else {?>
					<a style="color:red" href='chantinnhan.php?id=<?php echo $_SESSION['room'] ?>&nguoiChan=<?php echo $_SESSION['taiKhoan']?>&nguoiBiChan=<?php echo $finalName ?>&hanhDong=chan'>
						<i class="fa fa-ban" aria-hidden="true" title="Chặn tin nhắn"></i>
					</a>
				<?php } ?>
			</div>
		</div>
		<div class="messages">
			<div id="start"></div>
			<ul id="autodata2">
				
				<small>&nbsp;</small>
			</ul>
			<div id="end" style="height:30px"></div>
		</div>
		<div class="message-input">
			<div class="wrap">
				<?php if($_SESSION['room']=='quantrivien_quantrivien') {} 
				else {
				if($checkcout) {
					if(in_array($_SESSION['taiKhoan'], $danhSachNguoiChan)) { ?>
						<div class="card text-center" style="width: 100%;">
							<p style="resize: none; width:100%; margin-top:13px">Bạn đã chặn <a><?php echo $finalName ?></a> 
								<a style="color:red" href='chantinnhan.php?id=<?php echo $_SESSION['room'] ?>&nguoiChan=<?php echo $_SESSION['taiKhoan']?>&nguoiBiChan=<?php echo $finalName ?>&hanhDong=huychan' title="Hủy chặn tin nhắn">
									<span>Bỏ chặn <i class="fa fa-ban" aria-hidden="true" ></i></span>
								</a>
							</p>
						</div>
					<?php } elseif(in_array($_SESSION['taiKhoan'], $danhSachNguoiBiChan)) { ?>
						<div class="card text-center" style="width: 100%;">
							<p style="resize: none; width:100%; margin-top:13px"><a><?php echo $finalName ?> không muốn nhận tin nhắn từ bạn</p>
						</div>
				<?php }} else { ?>
					<form action="uploadfile.php" id="formbox" autocomplete="off" method="POST" enctype="multipart/form-data" style="display:flex; flex-direction: row; height: 53px;">
					<div class="card" style="width: 100%;">
						<div class="card-header" id="filePreview" style="display:none; <?php if(!empty($hide)) {echo $hide;} ?>">
							<span class="span_file">
								<i class="fa fa-paperclip" aria-hidden="true" ></i>
								<span id="selectedFile"></span>
								<button id="removeFile" title="Xóa tệp đã chọn"><i class="fa fa-times" aria-hidden="true"></i></button>
							</span>
						</div>
						<textarea type="text" name="chat" id="chat" placeholder="Viết tin nhắn..." value="<?php if(!empty($msg)) {echo $msg;} ?>" style="resize: none; width:100%"></textarea>
					</div>

					<button class="file-label" style="padding-bottom: 19px; text-align: center; font-size:larger" title="Biểu tượng cảm xúc" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
						<i class="fa fa-smile-o" aria-hidden="true"></i>
					</button>

					<label for="fileToUpload" class="file-label" style="padding-bottom: 19px; text-align: center;" title="Chọn tệp tin" name="chontailieu">
						<i class="fa fa-file" aria-hidden="true"></i>
					</label>
					<input type="file" name="fileToUpload" id="fileToUpload" style="display: none;" />

					<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
						<div class="offcanvas-body small">
							<div class="emoji-list" style="user-select: none;">
								<?php foreach ($emojiList as $emoji) : ?>
									<span class="emoji" data-user="<?= $emoji ?>" onclick="insertEmoji('<?= $emoji ?>')" style="user-select: none; cursor: pointer; font-size: 20px;" onmouseover="this.style.backgroundColor='#f2f2f2';" onmouseout="this.style.backgroundColor='transparent';"><?= $emoji ?></span>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<button title="Gửi tin nhắn" class="submit" type="submit" name="submit" id="sendButton" style="background:#2c3e50 !important; display:none">
						<i class="fa fa-paper-plane" aria-hidden="true"></i>
					</button>

				</form>
				<?php } ?>
				<?php } ?>
				<script>
					document.getElementById('fileToUpload').addEventListener('change', function () {
						var selectedFile = document.getElementById('selectedFile');
						var filePreview = document.getElementById('filePreview');
						var chatTextarea = document.getElementById('chat');
						var removeFileButton = document.getElementById('removeFile');
						var sendButton = document.getElementById("sendButton");
						var initialText = chatTextarea.value;
						if (this.files.length > 0) {
							selectedFile.innerText = this.files[0].name;
							filePreview.style.display = 'block';
							chatTextarea.style.height = 'calc(52px - 19.86px)';
							removeFileButton.style.display = 'inline';
							removeFileButton.addEventListener('click', function (event) {
								event.preventDefault();
								document.getElementById('fileToUpload').value = '';
								selectedFile.innerText = '';
								filePreview.style.display = 'none';
								chatTextarea.style.height = '52px';
								removeFileButton.style.display = 'none';
								if(initialText != '') { 
									sendButton.style.display = 'inline';
								} else {
									sendButton.style.display = 'none';
								}
							});

							sendButton.addEventListener('click', function () {
								selectedFile.innerText = '';
								filePreview.style.display = 'none';
								chatTextarea.style.height = '52px';
								removeFileButton.style.display = 'none';
								sendButton.style.display = 'none';

								var submitEvent = new MouseEvent('click', {
									bubbles: true,
									cancelable: true,
									view: window
								});
								
								document.getElementById('formbox').dispatchEvent(submitEvent);
							});

						} else {
							selectedFile.innerText = '';
							filePreview.style.display = 'none';
							removeFileButton.style.display = 'none';
						}
					});

					document.getElementById("chat").addEventListener("input", checkInput);
					document.getElementById("fileToUpload").addEventListener("change", checkInput);

					function checkInput() {
						var chatInput = document.getElementById("chat");
						var fileInput = document.getElementById("fileToUpload");
						var sendButton = document.getElementById("sendButton");

						if (chatInput.value.trim() !== "" || fileInput.files.length > 0) {
							sendButton.style.display = "inline";
						} else {
							sendButton.style.display = "none";
						}
					}

					setInterval(checkInput, 500);

					function insertEmoji(emoji) {
						const chatInput = document.getElementById('chat');
						const cursorPosition = chatInput.selectionStart;
						const textBeforeCursor = chatInput.value.substring(0, cursorPosition);
						const textAfterCursor = chatInput.value.substring(cursorPosition);
						var sendButton = document.getElementById("sendButton");
						sendButton.style.display = "inline";
						chatInput.value = textAfterCursor + emoji + textBeforeCursor;
					}

				</script>
			</div>
		</div>
	</div>
</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>
</html>