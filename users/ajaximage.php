<?php
session_start();
include_once '../includes/functions.php';
$path  = "../public/images/uploads/";
$users = select_data("SELECT avatar FROM users WHERE user_id=".$_SESSION['uid']);
if ($users[0]['avatar']) {
	$photo = '<img src="'.BASE_URL.'/public/images/uploads/'.$users[0]['avatar'].'" alt="user photo" />';
} else {
	$photo = '<img src="'.BASE_URL.'/public/images/uploads/profile.png" alt="user photo" />';
}

$valid_formats = array("jpg", "png", "gif", "bmp");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
	$name = $_FILES['photoimg']['name'];
	$size = $_FILES['photoimg']['size'];

	if(strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		$ext = 	strtolower($ext);
		$txt = time().substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);;
		if(in_array($ext,$valid_formats)) {
			if($size<(1024*1024)) {
				$actual_image_name = $txt.".".$ext;
				$tmp = $_FILES['photoimg']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$actual_image_name)) {
					//mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
					if (update_data('users', "`avatar`='$actual_image_name'", "user_id=".$_SESSION['uid'])) {
						$message = '<p id="photo-message" class="success">Thay đổi ảnh đại diện thành công!</p>';
						$photo   = '<img src="'.BASE_URL.'/public/images/uploads/'.$actual_image_name.'" alt="user photo" />';
					} else {
						$message = '<p id="photo-message" class="warning">Thay đổi ảnh đại điện thất bại!</p>';
					}
				} else $message = '<p id="photo-message" class="warning">Không thể upload hình, vui lòng upload lại!</p>';
			} else $message = '<p id="photo-message" class="warning">Dung lượng file lớn nhất là 1 MB!</p>';
		} else $message = '<p id="photo-message" class="warning">Không đúng định dạng (jpg, png, gif, bmp).</p>';
	} else $message = '<p id="photo-message" class="warning">Vui lòng chọn hình!</p>';
}
echo $photo;
?>
<script type="text/javascript">
	$("#message-ajax").empty().append('<?php echo $message;?>');
	setTimeout(function() {
	  $("#message-ajax p").remove();
	}, 3000);
</script>
<?php exit; ?>