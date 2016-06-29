<?php include 'header.php'; ?>

	<div id="content">
		<ul class="gallery">
    <?php
    // lấy dữ liệu hình ảnh
    $page = (!isset($_GET['page']))? '"%"' : $_GET['page'];
        $query = 'SELECT * FROM images WHERE images_typeID LIKE '.$page.' ORDER BY images_date DESC';
        $result = mysql_query($query,$db) or die(mysql_error($db));
        if(mysql_num_rows($result) == 0){echo '<h3>Thể loại chưa có hình</h3>';}
        while($row = mysql_fetch_array($result)){
            $images_id = $row['images_id'];
    ?>
         <li><a href="photos/<?php echo $images_id;?>.jpg" rel="lightbox[roadtrip]">
         <em><?php echo $row['images_title'];?></em><img src="photos/thumbs/<?php echo $images_id;?>.jpg" /></a></li>   
    <?php } // end while?>
		</ul>
	</div><!-- end #content -->
    
 <?php include 'footer.php'; ?>