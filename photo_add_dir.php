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
 	define('SCRIPT','photo_add_dir' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php 
		require 'includes/title.inc.php';
	?>
<script type="text/javascript" src="js/photo_add_dir.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='photo'>
	<h2>添加相册目录</h2>
	<form method="post" action="?action=adddir">
	   <dl>
	       <dd>相册名称：<input type="text" name="name" class="text" /></dd>
	       <dd>相册类型：<input type="radio" name="type" value="0" checked="checked" />公开 <input type="radio" name="type" value="1" />私密</dd>
	       <dd id="pass">相册密码：<input type="password" name="password" class="text" /></dd>
	       <dd>相册描述：<textarea name="content"></textarea></dd>
	       <dd><input type="submit" value="添加相册" class="submit"/></dd>
	   </dl>
	</form>
	
</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>