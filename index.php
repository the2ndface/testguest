<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-4
 */
 	define('IN_TG', true);
 	define('SCRIPT','index' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统－－首页</title>
	<?php 
		require 'includes/title.inc.php';
	?>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='list'>
	<h2>贴子列表</h2>
</div>

<div id='user'>
	<h2>用户列表</h2>
</div>

<div id='pics'>
	<h2>最新图片</h2>
</div>
	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
				
	?>



</body>
</html>