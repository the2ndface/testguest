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
 	define('IN_TG', true);
 	define('SCRIPT','blog' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 //从数据库取出结果集
 $_result=_query("SELECT tg_username,tg_sex,tg_face FROM tg_user ORDER BY tg_reg_time DESC");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统－－博友</title>
	<?php 
		require 'includes/title.inc.php';
	?>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='blog'>
	<h2>博友列表</h2>
	<?php 
	   while(!!$_rows=_fetch_array_list($_result)){
	?>
	<dl>
	   <dd class='user'><?php echo $_rows['tg_username']?>(<?php echo $_rows['tg_sex']?>)</dd>
	   <dt> <img src="<?php echo $_rows['tg_face']?>" /></dt>
	   <dd class='message'>发消息</dd>
	   <dd class='frenid'>加为好友</dd>
	   <dd class='guest'>写留言</dd>
	   <dd class='flower'>给他送花</dd>
	</dl>
	<?php
	   } 
	?>	
</div>	
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>