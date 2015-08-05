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
 //	
    //读取数据
    $_html=_html(_get_xml('new.xml'));
    print_r($_html);
 	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统－－首页</title>
	<?php 
		require 'includes/title.inc.php';
	?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='list'>
	<h2>贴子列表</h2>
</div>

<div id='user'>
	<h2>新进用户</h2>
	<dl>
	   <dd class='user'><?php echo $_html['username']?></dd>
	   <dt><img src="<?php echo $_html['face']?>" /></dt>
	   <dd class='message'><a href="javascript:;" name="message" title="<?php echo $_html['id']?>">发消息</a></dd>
	   <dd class='frenid'><a href="javascript:;" name="friend" title="<?php echo $_html['id']?>">加为好友</a></dd>
	   <dd class='guest'>写留言</dd>
	   <dd class='flower'><a href="javascript:;" name="flower" title="<?php echo $_html['id']?>">给他送花</a></dd>
	   <dd class='email'>邮箱：<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
	   <dd class='url'>网址：<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
	</dl>
</div>

<div id='pics'>
	<h2>最新图片</h2>
</div>
	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
				
	?>

</body>
</html>