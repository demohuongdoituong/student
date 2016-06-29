<?php
    session_start();
	// Nếu chưa đăng nhập thì chuyển sang trang chủ
    if(!isset($_SESSION['login'])){
        header('Refresh: 4; URL=Index.php');
    }
    include 'header.php'; 
?>
<style type="text/css">

</style>
<div id="content">
    <div id="management">
<?php
// Phải đăng nhập thì mới được quản lý
if(isset($_SESSION['login']) and isset($_SESSION['user'])){

// Nếu chọn hành động xóa image
    if(isset($_GET['del'])){
        // Hỏi lại hành động delete
        if(!isset($_GET['do']) or $_GET['do'] != 1){
			echo '<div class="modal">';
			echo '<p>Bạn có chắc muốn xóa hình!</p>';
			echo '<p><a href="'.$_SERVER['REQUEST_URI'].'&do=1">Yes</a>'.
                     ' or <a href="personal_images.php">No</a></p>'.
				 '<p><img style="width: 50px; float: right;" src="photos/thumbs/'.$_GET['del'].'.jpg" /></p>';
			echo '</div><div id="fade"></div>';
        }else{
        // nếu đồng ý xóa thì delete
			$query = 'DELETE FROM images WHERE images_id ='.$_GET['del'];
			mysql_query($query,$db) or die(mysql_error($db));
            // Xóa hình ở thư mục lưu trữ
            $file = 'photos/'.$_GET['del'].'.jpg';
            $filethumb = 'photos/thumbs/'.$_GET['del'].'.jpg';
            if(file_exists($file)){unlink($file);}
            if(file_exists($filethumb)){unlink($filethumb);}
			echo '<h3>Đã xóa hình</h3>';
        }
   }// end delete image
   
   // Lấy thông tin image
    $query = 'SELECT I.*,T.typeimage_name 
                    FROM images I, typeimage T 
                    WHERE images_userID="'.$_SESSION['login'].'"AND I.images_typeID=T.typeimage_id';
    $result = mysql_query($query,$db) or die(mysql_error($db));
    if(mysql_num_rows($result) == 0){
        echo '<h3>Bạn chưa có hình</h3>';
    }else{
?>
    <h3>Quản lý images</h3>
   	<table cellspacing="1">
	<thead>
   	    <tr>
           	<th>Images</th>
            <th>Thể loại</th>
            <th>Tiêu đề</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
	</thead>
	<tbody>
    <?php
        while($row =mysql_fetch_array($result)){ 
            $filename = $row['images_id'];
    ?>
        <tr>
            <td><a href="photos/<?php echo $filename;?>.jpg" rel="lightbox[roadtrip]">
                <img style="width: 50px;" src="photos/thumbs/<?php echo $filename;?>.jpg" /></a>
            </td>
            <td><?php echo $row['typeimage_name'];?></td>
            <td style="max-width: 400px;"><?php echo $row['images_title'];?></td> 
            <td><?php echo $row['images_date'];?></td> 
            <td><a href="personal_images.php?del=<?php echo $row['images_id'];?>">[delete]</a></td>
        </tr>   
	<?php    
        }//end while $row
    }// end else mysql_num_rows
	?>
	</tbody>
    </table>
<?php 
}else{// Nếu chưa đăng nhập 
		echo '<p>Bạn phải đăng nhập vào tài khoản<br /> Hệ thống sẽ về trang chủ trong giây lát</p>';
	} 
?>
    </div><!-- end #management -->
</div> <!-- end #content -->
<script type="text/javascript">
// highlight table
	var manage = document.getElementById('management');
	var tr = manage.getElementsByTagName('tr');
	for(var i=0; i<tr.length; i++){
		tr[i].style.backgroundColor = (i%2 == 0)? '#F2EEDA' : '#fff';
	}
</script>
<?php include 'footer.php';?>