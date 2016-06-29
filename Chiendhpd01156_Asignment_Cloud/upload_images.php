<?php 
	session_start();
	// Nếu chưa đăng nhập thì chuyển sang trang chủ
    if(!isset($_SESSION['login'])){
        header('Refresh: 4; URL=Index.php');
    }
	include 'header.php';	
?>
<style type="text/css"> 
	#login input[type=file]{width: 200px; clear:both;}
	#login label.upload{clear: both; width: 200px;}
</style>
	<div id="content">
    <div id="login">
<?php
	// Nếu đã đăng nhập thì hiển thị form upload
    if(isset($_SESSION['login'])){
?>
    	<h2>Upload Images</h2>
    	<form action="upload_process.php" method="post" enctype="multipart/form-data">
        	<ul>
            	<li>
                <label class="upload">Upload images: </label>
                <input type="hidden" name="MAX_FILE_SIZE" value="2024000" /><!-- ~ 2MB -->
                <input type="file" name="uploadfile" />
                </li>
                <li><label class="upload">Tiêu đề hình ảnh(*)</label><input type="text" name="titleIMG" /></li>
                <li>
                	<label>Thể loại hình</label>
                    <select name="typeIMG">
            	<?php
					$query = 'SELECT * FROM typeimage';
					$result = mysql_query($query,$db) or die(mysql_error($db));
					while($row = mysql_fetch_array($result)){
						echo '<option value="'.$row['typeimage_id'].'">'.$row['typeimage_name'].'</option>';
					}
				?>
                    </select>
                </li>
                <li style="padding: 0">Kích thước file không lớn quá 2MB</li>
                <li style="padding: 0">Chỉ hổ trợ định dạng ảnh (GIF, JPG/JPEG and PNG)</li>
				<li style="padding: 0">Tiêu đề không vượt quá 120 ký tự</li>
                <li><input type="submit" name="upload" value="Upload" /></li>
            </ul>
        </form>
<?php 
	}else{
		echo '<p style="font-size: 15px;color:#4B7E1E;">Bạn chưa đăng nhập<br /> 
        Hệ thống sẽ về trang chủ trong giây lát</p>';
	}
 ?>
    </div><!-- end #login -->
    </div><!-- end #content -->
<?php include 'footer.php';?>
