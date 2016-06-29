<?php 
    session_start();
    // Nếu logout thì bỏ session
    if(isset($_GET['logout']) and isset($_SESSION['user'])){
		session_unset('user');
        session_unset('login');
	}
    // Nếu đã đăng nhập thì hệ thống sẽ chuyển sang index 
    if(isset($_SESSION['login'])){
        header('Refresh: 2; URL=Index.php');
    }
    
    // Nếu không có lỗi thì kiểm tra tài khoản đăng nhập
	if(isset($_POST['login']) and !empty($_POST['username']) and !empty($_POST['password'])){
	    include 'db.inc.php';
        $db = mysql_connect(MYSQL_HOST,MYSQL_USER) or die('Khong ket noi duoc CSDL');
         mysql_select_db(MYSQL_DB,$db) or die(mysql_error($db));
		$query ='SELECT user_id,user_name FROM user WHERE 
				user_name="'.$_POST['username'].'" 
				AND user_pass="'.$_POST['password'].'"';
		$result =mysql_query($query, $db) or die(mysql_error($db));
		// Nếu thành công thì tạo session và chuyển về trang chủ
		if(mysql_num_rows($result) >0){
            $row = mysql_fetch_array($result);
			$_SESSION['user']= $row['user_name'];
            $_SESSION['login']= $row['user_id'];
            header('Refresh: 2; URL=Index.php');
		}else{
			$error = '<p>Đăng nhập không thành công, kiểm tra lại thông tin đăng nhập</p>';
		}
	}// end isset login   
    include 'header.php'; 
?> 
	<div id="login">
<?php
	
?>
<?php
    if(isset($_GET['logout'])){
		echo '<h3>Bạn đã đăng xuất</h3>';
    }
    // Nếu đã đăng nhập thì không hiển thị form
    if(isset($_SESSION['login'])){
        echo '<h3>Bạn đã đăng nhập</h3> 
			 <p>Hệ thống sẽ về trang chủ trong giây lát</p>';
    }else{
        if(isset($error)){echo $error;}
?>          
		<h2>Login</h2>
		<form action="login.php" method="post">
		<ul>
			<li><label>Username: </label><input type="text" name="username"  /></li>
			<li><label>Password: </label><input type="password" name="password"  /></li>
			<li><input type="submit" name="login" value="Đăng Nhập"  /></li>
		</ul>
		</form>
  <?php }?>
	</div><!-- end #login -->
<?php include 'footer.php'; ?>
