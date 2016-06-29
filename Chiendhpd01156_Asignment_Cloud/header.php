<?php
    session_start();
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST,MYSQL_USER) or die('Khong ket noi duoc CSDL');
    mysql_select_db(MYSQL_DB,$db) or die(mysql_error($db));
    mysql_query("SET NAMES 'utf8'",$db); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="Author" content="Pixel-C" />
	<title>Designer Gallery</title>
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
	
	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="js/lightbox.js" type="text/javascript"></script>
</head>

<body>
<div id="wrap">
	<div id="header">
		<h1><em>Designer's Gallery</em></h1>
    <?php
        // Nếu đã đăng nhập thì hiển thị thông tin, ngược lại thông báo đăng nhập
        if(isset($_SESSION['login']) and isset($_SESSION['user'])){
    ?>
        <p class="about">
            <em>Chào bạn: </em><a href="user_manual.php"><?php echo $_SESSION['user'];?></a>
            <span><em>Đăng xuất: </em><a href="login.php?logout=yes">logout</a>
            <em>Tải ảnh: </em><a href="upload_images.php">Upload</a>
            <em>Quản lý ảnh: </em><a href="personal_images.php">My Picture</a>
    <?php
		// Nếu là admin thì cho phép liên kết tới trang admin 
		$query = 'SELECT user_id FROM user WHERE user_id="'.$_SESSION['login'].'"AND user_level=1';
		$result = mysql_query($query,$db) or die(mysql_error($db));
		if(mysql_num_rows($result) > 0){
			echo '<br /><em>Quản lý user: </em><a href="admin.php">Admin</a>';
		}
	?>        
        	</span>
        </p>
    <?php }else{ // Ngược lại nếu chưa đăng nhập?>
		<p class="about">
            <em>Đăng nhập:</em> <a href="login.php">Login</a>
            <em>Đăng ký:</em> <a href="register.php">Register</a>
		</p>
    <?php } // end else?>
	</div><!-- end #header -->
    
	<div id="navigation">
		<ul>
            <li><a class="home" href="Index.php">Home</a></li>
    <?php
        // Lấy dữ liệu cho navigation
        $query = 'SELECT * FROM typeimage';
        $result = mysql_query($query,$db) or die(mysql_error($db));
        while($row = mysql_fetch_array($result)){
            echo '<li><a href="Index.php?page='.$row['typeimage_id'].'">'.$row['typeimage_name'].'</a></li>';
        }
        mysql_free_result($result);
    ?>
		</ul>
	</div><!-- end #navigation -->
	<script type="text/javascript">
	// highlight navigation
		var url = location.href;
		var navi = document.getElementById('navigation');
		var navi_a = navi.getElementsByTagName('a');
		var current = 'home';
		for(var i=0; i<navi_a.length; i++){
			if(navi_a[i].className == 'home'){continue;}
			var aHref = navi_a[i].getAttribute('href');
			if(url.indexOf(aHref) != -1){
				navi_a[i].style.backgroundColor = '#4e7814';
				current = 'page';
			}
		}
		if(current == 'home'){navi_a[0].style.backgroundColor = '#4e7814';}
	</script>