<?php 
	session_start();
	// Nếu chưa đăng nhập thì chuyển sang trang chủ
    if(!isset($_SESSION['login'])){
        header('Location:Index.php');
    }
	// Nếu form nhập không hợp lệ thì chuyển về trang upload
	if(isset($_POST['upload'])){
		if(isset($_POST['titleIMG']) and empty($_POST['titleIMG'])){ 
			header('Refresh: 4; URL=upload_images.php');
			$error = '<h3 style="text-align: center; padding: 50px 0">Phải điền đầy đủ thông tin upload, hệ thống sẽ về trang upload trong giây lát</h3>';
		}else if(isset($_POST['titleIMG']) and strlen($_POST['titleIMG']) >120){
			header('Refresh: 4; URL=upload_images.php');
			$error = '<h3 style="text-align: center; padding: 50px 0">Tiêu đề chỉ được nhập tối đa 120 ký tự</h3>';
		}
	}
	include 'header.php';
?>

<div id="content" style="min-height:400px;">
<?php
// Nếu không nhập title thì thông báo lỗi
if(isset($error) and !empty($error)){
	echo $error;
}else{
// Đường dẫn tới thư mục hình ảnh (images directory)
	$dir ='photos';
	// Đướng dẫn tới thư mục hình thumnails (thumnail directory)
	$thumbdir = $dir.'/thumbs';

	// Đảm bảo chắc chắn rằng file được tải lên thành công
	if ($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK) {
		switch ($_FILES['uploadfile']['error']){
			case UPLOAD_ERR_INI_SIZE:
				die('Kích thước tập tin vươtx quá upload_max_filesize trong' .' php.ini');
			break;
			case UPLOAD_ERR_FORM_SIZE:
				die('Kích thước tập tin vượt quá MAX_FILE_SIZE qui định trong html form');
			break;
			case UPLOAD_ERR_PARTIAL:
				die('tập tin được tải lên không hoàn chỉnh.');
			break;
			case UPLOAD_ERR_NO_FILE:
				die('Không có tập tin nào được tải');
			break;
			case UPLOAD_ERR_NO_TMP_DIR:
				die('Máy chủ không nhở thư mục tạm');
			break;
			case UPLOAD_ERR_CANT_WRITE:
				die('Máy chủ không thể ghi tập tin vào đĩa');
			break;
			case UPLOAD_ERR_EXTENSION:
				die('Lỗi phần mở rộng của tập tin');
			break;
		}
	}
	// Lấy thông tin về hình ảnh được tải lên
	$images_title = $_POST['titleIMG'];
	$images_typeID = $_POST['typeIMG'];
	$images_userID = $_SESSION['login'];
	$images_date = date('Y-m-d');
	list($width, $height, $type, $attr) = getimagesize($_FILES['uploadfile']['tmp_name']);
	
	// đảm bảo chắc chắn rằng file được tải lên là định dạng ảnh được hổ trợ
	$error = 'Định dạng file bạn tải lên không được hổ trợ';
	switch ($type) {
		case IMAGETYPE_GIF:
			$image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']) or die($error);
		break;
		case IMAGETYPE_JPEG:
			$image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']) or die($error);
		break;
		case IMAGETYPE_PNG:
			$image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']) or die($error);
		break;
		default:
			die($error);
	}

	// Chèn thông tin vào bảng hình ảnh trong CSDL
	$query = 'INSERT INTO images (images_typeID, images_title, images_date,images_userID)
				VALUES
						("'.$images_typeID.'", "'.$images_title.'", "'.$images_date.'",'.$images_userID.')';
	$result = mysql_query($query, $db) or die (mysql_error($db));

	// lấy image_id được tạo tự động khi insert mẫu tin mới vào CSDL
	$last_id = mysql_insert_id();
	// Lưu hình ảnh vào thư mục trên server
	$imagename = $last_id.'.jpg';
	imagejpeg($image, $dir.'/'.$imagename,100);

	//set the dimensions for the thumbnail
	$thumb_width = 170;
	$thumb_height = 120;

	// Tạo hình thumbnail
	$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
	imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumb_width,$thumb_height,$width, $height);
	imagejpeg($thumb, $thumbdir .'/'.$last_id.'.jpg', 100);
	imagedestroy($thumb);
	imagedestroy($image);
	echo '<h3 style="text-align: center;">Upload thành công</h3>';
}// end else isset error
?>
</div><!-- end #content -->
<?php include 'footer.php';?>