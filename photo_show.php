<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:@author
 * Date:2015年7月21日
 */
    session_start();
 	define('IN_TG', true);
 	define('SCRIPT','photo_show' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	//取值
 	if(isset($_GET['id'])){
 	    if(!!$_rows=_fetch_array("SELECT tg_id FROM tg_dir WHERE tg_id='{$_GET['id']}'")){
 	        $_html = array();
 	        $_html['id'] = $_rows['tg_id'];
 	        $_html = _html($_html);
 	    }else{
 	        _alert_back('此相册不存在！');
 	    }
 	}else{
 	    _alert_back('非法操作！');
 	}
 	
 	$_filename = 'photo/1441162655/1441593681.jpg';
 	$_percent = 0.3;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php 
		require 'includes/title.inc.php';
	?>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='photo'>
	<h2>图片展示</h2>
    <img src="thumb.php?filename=<?php echo $_filename?>&percent=<?php echo $_percent?>" />
	<p><a href="photo_add_img.php?id=<?php echo $_html['id']?>">上传图片</a></p>

</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>