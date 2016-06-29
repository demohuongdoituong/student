<?php
    session_start();
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST,MYSQL_USER) or die('Khong ket noi duoc CSDL');
    mysql_select_db(MYSQL_DB,$db) or die(mysql_error($db));
    mysql_query("SET NAMES 'utf8'",$db);
        // Kiểm tra tính hợp lệ dữ liệu từ form register 
        if(isset($_POST['register'])){
            $posts = array('username','password','re_password','fullname','email');
            $preg_mail = '/^[A-z0-9]+@[A-z0-9]+([.]+[A-z0-9]+)+$/';
            $errors = array();
            foreach($posts as $value){
                // Kiểm tra rỗng
                if(empty($_POST[$value])){
				    $errors[] = '<i>'.$value.'</i> Không được rỗng';
                    
                // Kiểm tra username không được có khoảng trắng
    			}else if($value == 'username' and strstr($_POST[$value],' ')== true){
    				$errors[] = '<i>Username</i> Không được có khoảng trắng';
                    
                // Kiểm tra username đã tồn tại trong CSDL chưa
                }else if($value == 'username'){
    				$query = 'SELECT * FROM user WHERE user_name = "'.$_POST[$value].'"';
    				$result = mysql_query($query,$db) or die(mysql_error($db));
    				if(mysql_num_rows($result) >0){
    					$errors[] = '<i>User name</i> đã được đăng ký';
    				}
                    mysql_free_result($result);
                    
                // Kiểm tra độ dài của password
                }else if($value == 'password' and strlen($_POST[$value])< 6){
				    $errors[] = '<i>Password</i> Phải từ 6 ký tự';
                
                // Kiểm tra email có hợp quy cách
                }else if($value == 'email' and !preg_match($preg_mail,$_POST[$value])){
                    $errors[] = '<i>email</i> nhập không đúng';
                }
            }// end foreach
            
            // Kiểm tra password nhập lại
    		if(!empty($_POST['password']) and !empty($_POST['re_password'])){
    			if($_POST['password'] != $_POST['re_password']){
    				$errors[] = '<i>Password nhập lại</i> không đúng';
    			}
    		}
            
            // Nếu không có lỗi thì cập nhật vào csdl
            if(empty($errors)){
                $query = 'INSERT INTO user 
                                (user_name,user_pass,user_fullname,user_email,user_website) 
                            VALUES 
                                ("'.$_POST['username'].'",
                                "'.$_POST['password'].'",
                                "'.$_POST['fullname'].'",
                                "'.$_POST['email'].'",
                                "'.$_POST['website'].'")';
                mysql_query($query,$db) or die(mysql_error($db));
                $_SESSION['user'] = $_POST['username'];
                $_SESSION['login'] = mysql_insert_id();
            }
        }// end isset rigester
?>
<?php include 'header.php'; ?>
	<div id="login">
        <?php
            // Nếu form nhập lỗi thì hiển thị lỗi
            if(isset($errors) and !empty($errors)){
                echo '<h3>Bạn nhập lỗi form</h3>'.
                     '<ul style="font: 13px arial,san-serif;">';
                foreach($errors as $value){
				    echo '<li style="padding: 1px 0;">'.$value.'</li>';
                }
                echo '</ul>';
            }else if(isset($_POST['register'])){
                echo '<h3>Đăng ký thành công</h3>';
            }
        ?>
		<h2>Register</h2>
		<form action="register.php" method="post">
		<ul>
			<li><label>Username(*): </label><input type="text" name="username"  /></li>
			<li><label>Password(*): </label><input type="password" name="password"  /></li>
			<li><label>Confirm Pass(*): </label><input type="password" name="re_password"  /></li>
			<li><label>Full name(*): </label><input type="text" name="fullname"  /></li>
			<li><label>Email(*): </label><input type="text" name="email"  /></li>
			<li><label>Website: </label><input type="text" name="website"  /></li>
			<li><input type="submit" name="register" value="Đăng Ký"  /></li>
		</ul>
		</form>
	</div><!-- end #login -->
    
<?php include 'footer.php';?>
