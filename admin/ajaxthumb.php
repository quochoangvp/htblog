<?php
session_start();
include_once '../includes/functions.php';
header('Content-Type: text/html; charset=utf-8');
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
	echo '<script type="text/javascript" src="'.JS_URL.'jquery.min.js"></script>';
	chmod_r('../public/images/uploads/posts/', 0777);

	$year = date('Y');
	$date = date('d');
	$imgDir = '../public/images/uploads/posts/'.$year.'/'.$date.'/';
	if (!file_exists($imgDir)) mkdir($imgDir, 0777, true);

	$path  = "../public/images/uploads/posts/".date('Y/d')."/";
	$imgUrl  = BASE_URL.'public/images/uploads/posts/'.$year.'/'.$date.'/';

	$valid_formats = array("jpg", "png", "gif", "bmp");

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
					$message = '<p id="photo-message" class="success">Upload hình thành công!</p>';
				} else $message = '<p id="photo-message" class="warning">Không thể upload hình, vui lòng upload lại!</p>';
			} else $message = '<p id="photo-message" class="warning">Dung lượng file lớn nhất là 1 MB!</p>';
		} else $message = '<p id="photo-message" class="warning">Không đúng định dạng (jpg, png, gif, bmp).</p>';
	} else $message = '<p id="photo-message" class="warning">Vui lòng chọn hình!</p>';
}
if (!$actual_image_name) $actual_image_name = 'no_thumb.jpg';
$photo = '<img src="'.$imgUrl.$actual_image_name.'" alt="user photo" />'."\n".
	'<label id="lbl_post_thumb" for="'.$year.'/'.$date.'/'.$actual_image_name.'"><input form="add_post" type="hidden" id="input_post_thumbnail" name="post_thumbnail" value="" /></label>';
echo $photo;
if (!empty($message)) { ?>
<script type="text/javascript">
	$("#thumb_link").empty().append('<a id="add" href="#" class="button">Thêm</a>');
	$("#message-ajax").empty().append('<?=$message?>');
	setTimeout(function() {
		$("#message-ajax p").remove();
	}, 3000);
</script>
<?php } exit; ?>