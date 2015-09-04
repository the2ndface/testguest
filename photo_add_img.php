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
 	define('SCRIPT','photo_add_img' );
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
<script type="text/javascript" src="js/photo_add_img.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='photo'>
	<h2>上传图片</h2>
    <form method="post" action="?action=addimg">
        <dl>
            <dd>图片名称：<input type="text" name="name" class="text"/></dd>
            <dd>图片地址：<input type="text" name="url" readonly="readonly" class="text"/><a href="javascript:;" id="up">上传</a></dd>
            <dd>图片名称：<textarea name="content"></textarea></dd>
            <dd><input type="submit" class="submit" value="添加图片" /></dd>
        </dl>
        
    </form>

</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>