<?php
	session_start();
	// Nếu chưa đăng nhập thì chuyển sang trang chủ
    if(!isset($_SESSION['login'])){ 
        header('Refresh: 4; URL=Index.php');
    }  
	include 'header.php'; 
?>
    
    <?php
        // Kiểm tra tính hợp lệ dữ liệu từ form update
        if(isset($_POST['update'])){
            $posts = array('username','fullname','email');
            $preg_mail = '/^[A-z0-9]+@[A-z0-9]+([.]+[A-z0-9]+)+$/';
            $errors = array();
            foreach($posts as $value){
                // Kiểm tra rỗng
                if(empty($_POST[$value])){
				    $errors[] = '<b>'.$value.'</b> Không được rỗng';
                    
                // Kiểm tra username không được có khoảng trắng
    			}else if($value == 'username' and strstr($_POST[$value],' ')== true){
    				$errors[] = '<b>Username</b> Không được có khoảng trắng';
                
                // Kiểm tra username mới đã tồn tại trong CSDL chưa
                }else if($value == 'username' and $_POST[$value] != $_SESSION['user']){
    				$query = 'SELECT * FROM user WHERE 
                                            user_name = "'.$_POST[$value].'" 
                                            AND user_id <>"'.$_SESSION['login'].'"';
    				$result = mysql_query($query,$db) or die(mysql_error($db));
    				if(mysql_num_rows($result) >0){
    					$errors[] = '<b>User name</b> đã được đăng ký';
    				}
                    mysql_free_result($result);
                
                // Kiểm tra email có hợp quy cách
                }else if($value == 'email' and !preg_match($preg_mail,$_POST[$value])){
                    $errors[] = '<b>email</b> nhập không đúng';
                }
            }// end foreach
            
            $old_pass = trim($_POST['old_password']);
            $new_pass = trim($_POST['new_password']);
            $re_pass = trim($_POST['re_password']);
            // Nếu trường nhập password rỗng thì dữ lại password cũ
            if(empty($old_pass) or empty($new_pass) or empty($re_pass)){
                $keeppass = 'yes';
            // ngược lại kiểm tra password cũ trong CSDL
            }else{
                $query = 'SELECT * FROM user WHERE 
                                user_id = "'.$_SESSION['login'].'" 
                                AND user_pass ="'.$old_pass.'"';
                $result = mysql_query($query,$db) or die(mysql_error($db));
			     // Nếu password nhập vào đúng thì kiểm tra sự hợp lệ của password mới
			     if(mysql_num_rows($result) > 0){
			         // Kiểm tra độ dài của password
                    if(strlen($new_pass)< 6){$errors[] = '<b>Password</b> Phải từ 6 ký tự';}
				    // Kiểm tra password nhập lại
                    if($new_pass != $re_pass){$errors[] = '<b>Password nhập lại</b> không đúng';}
			     }else{
			         $errors[] = '<b>Nhập password hiện tại không đúng</b>';
			     }
            }// end check password

        }// end isset update
    ?>
    
	<div id="login">
        <?php
            // Nếu form nhập lỗi thì hiển thị lỗi
            if(isset($errors) and !empty($errors)){
                echo '<h3>Thông tin bạn nhập không hợp lệ</h3>'.
                     '<ul style="font: 13px arial,san-serif;">';
                foreach($errors as $value){
				    echo '<li style="padding: 1px 0;">'.$value.'</li>';
                }
                echo '</ul>';
            
            // Nếu không có lỗi thì cập nhật vào csdl
            }else if(isset($_POST['update'])){
                if(isset($keeppass)){
                    echo '<p>Hệ thống sẽ giữ lại password cũ</p>';
                    $query = 'UPDATE user SET 
									user_name="'.$_POST['username'].'",
									user_fullname="'.$_POST['fullname'].'",
                                    user_email="'.$_POST['email'].'",
                                    user_website="'.$_POST['website'].'"
							WHERE user_id="'.$_SESSION['login'].'"';
                }else{
                    $query = 'UPDATE user SET 
									user_name="'.$_POST['username'].'",
                                    user_pass="'.$new_pass.'",
									user_fullname="'.$_POST['fullname'].'",
                                    user_email="'.$_POST['email'].'",
                                    user_website="'.$_POST['website'].'"
							WHERE user_id="'.$_SESSION['login'].'"';
                }
                mysql_query($query,$db) or die(mysql_error($db));
                echo '<h3>Cập nhật thông tin thành công</h3>';
            }
			
			// Nếu đã đăng nhập thì lấy dữ liệu từ CSDL
			if(!isset($_SESSION['login']) and !isset($_SESSION['user'])){
				echo '<p>Chưa đăng nhập, hệ thống sẽ về trang chủ trong giây lát</p>';
			}else{
				$user_id = $_SESSION['login'];
			// Lấy thông tin từ CSDL
				$query = 'SELECT * FROM user WHERE user_id='.$user_id;
				$result = mysql_query($query, $db) or die(mysql_error($db));
				$row = mysql_fetch_array($result);
        ?>
				<h2>Infomation user</h2>
				<form action="user_manual.php" method="post">
				<ul>
					<li><label>Username(*): </label><input type="text" name="username"  value="<?php echo $row['user_name']?>" /></li>
					<li><label>Old password(*): </label><input type="password" name="old_password" /></li>
                    <li><label>New password(*): </label><input type="password" name="new_password" /></li>
					<li><label>Confirm Pass(*): </label><input type="password" name="re_password" /></li>
					<li><label>Full name(*): </label><input type="text" name="fullname" value="<?php echo $row['user_fullname'];?>"  /></li>
					<li><label>Email(*): </label><input type="text" name="email" value="<?php echo $row['user_email'];?>"/></li>
					<li><label>Website: </label><input type="text" name="website" value="<?php echo $row['user_website'];?>" /></li>
					<li><input type="submit" name="update" value="Cập nhật"  /></li>
				</ul>
				</form>
		<?php }// end session login ?>
	</div><!-- end #login -->
    
<?php include 'footer.php';?>
