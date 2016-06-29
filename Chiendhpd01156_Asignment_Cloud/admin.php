<?php
    session_start();
	// Nếu chưa đăng nhập thì chuyển sang trang chủ
    if(!isset($_SESSION['login'])){
        header('Refresh: 4; URL=Index.php');
    }  
    include 'header.php';
?>
    <div id="content">
    <div id="management">
    <?php
// Phải đăng nhập với quyền admin thì mới được quản lý user
if(isset($_SESSION['login'])){
$query = 'SELECT user_id FROM user WHERE user_id="'.$_SESSION['login'].'"AND user_level=1';
$result = mysql_query($query,$db) or die(mysql_error($db));
if(mysql_num_rows($result) > 0){

		// Nếu chọn hành động delete acount
		if($_GET['action'] == 'delA'){
			// Hỏi lại hành động delete
			if(!isset($_GET['do']) or $_GET['do'] != 1){
				echo '<div class="modal">';
				echo '<p>Bạn có chắc muốn xóa account <b>'.$_GET['user'].'</b></p>';
				echo '<p><a href="'.$_SERVER['REQUEST_URI'].'&do=1">Yes</a>'.
                     ' or <a href="admin.php">No</a></p>';
				echo '</div><div id="fade"></div>';
			}else{
			// nếu đồng ý xóa thì delete
				$query = 'DELETE FROM user WHERE user_id ='.$_GET['id'];
				mysql_query($query,$db) or die(mysql_error($db));
				echo '<h3>Đã xóa <b>'.$_GET['user'].'</b></h3>';
			}
		// Nếu chọn hành động delete images
		}else if($_GET['action'] == 'delI'){
			// Hỏi lại hành động delete
			if(!isset($_GET['do']) or $_GET['do'] != 1){
				echo '<div class="modal">';
				echo '<p>Bạn có chắc muốn xóa tất cả hình của <b>'.$_GET['user'].'</b></p>';
				echo '<p><a href="'.$_SERVER['REQUEST_URI'].'&do=1">Yes</a>'.
                     ' or <a href="admin.php">No</a></p>';
				echo '</div><div id="fade"></div>';
			}else{
			 // nếu đồng ý xóa thì delete
                // Xóa hình ở thư mục lưu trữ
                $query = 'SELECT images_id FROM images WHERE images_userID ='.$_GET['id'];
    			$result = mysql_query($query,$db) or die(mysql_error($db));
                while($row = mysql_fetch_array($result)){
                    $file = 'photos/'.$row['images_id'].'.jpg';
                    $filethumb = 'photos/thumbs/'.$row['images_id'].'.jpg';
                    if(file_exists($file)){unlink($file);}
                    if(file_exists($filethumb)){unlink($filethumb);}
                }
                
                // Xóa thông tin trong CSDL
				$query = 'DELETE FROM images WHERE images_userID ='.$_GET['id'];
				mysql_query($query,$db) or die(mysql_error($db));
                echo '<h3>Đã xóa tất cả hình của <b>'.$_GET['user'].'</b></h3>';
			} // end delete images
		}// end GET action
    ?>
        <h3>Quản lý user</h3>
    	<table cellspacing="1">
		<thead>
        	<tr>
            	<th>User name</th>
                <th>Full name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Level</th>
                <th>Action</th>
            </tr>
		</thead>
		<tbody>
            <?php
    		// Xuất thông tin user từ CSDL
    		$query = 'SELECT * FROM user';
    		$result = mysql_query($query,$db) or die(mysql_error($db));
    		while($row = mysql_fetch_array($result)){
    		  $level = ($row['user_level'] == 1)? 'Admin' : 'User';
    			echo '<tr>';
        			echo '<td>'.$row['user_name'].'</td>';
        			echo '<td>'.$row['user_fullname'].'</td>';
        			echo '<td>'.$row['user_email'].'</td>';
                    echo '<td>'.$row['user_website'].'</td>';
                    echo '<td>'.$level.'</td>';
        			echo '<td><a href="admin.php?action=delA&id='.$row['user_id'].'&user='.$row['user_name'].'">[Delete account]</a> ';
        			echo '<a href="admin.php?action=delI&id='.$row['user_id'].'&user='.$row['user_name'].'">[Delete all images]</a></td>';
    			echo '</tr>';
    		}// end while $row
    		?>
		</tbody>
        </table>
<?php 
    }else{
        echo '<h3>Bạn phải đăng nhập với quyền admin</h3>';
    }// end mysql_num_rows($result)
    
}else{
        echo '<h3>Bạn phải đăng nhập với quyền admin</h3>'.
             '<p>Hệ thống sẽ chuyển về trang chủ trong giây lát</p>';
} // end isset adim 

?>
    </div><!-- end #management -->
    </div><!-- end #content -->
<script type="text/javascript">
// highlight table
	var manage = document.getElementById('management');
	var tr = manage.getElementsByTagName('tr');
	for(var i=0; i<tr.length; i++){
		tr[i].style.backgroundColor = (i%2 == 0)? '#F2EEDA' : '#fff';
	}
</script>
<?php include 'footer.php';?>