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
 	define('SCRIPT','photo_detail' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	if(isset($_GET['id'])){
 	    if(!!$_rows=_fetch_array("SELECT tg_id,tg_name,tg_url,tg_content,tg_username,tg_readcount,tg_commentcount,tg_date 
 	                          FROM tg_photo 
 	                         WHERE tg_id='{$_GET['id']}'
 	                         LIMIT 1")){
 	        $_html = array();
 	        $_html['id'] = $_rows['tg_id'];
 	        $_html['name'] = $_rows['tg_name'];
 	        $_html['url'] = $_rows['tg_url'];
 	        $_html['username'] = $_rows['tg_username'];
 	        $_html['readcount'] = $_rows['tg_readcount'];
 	        $_html['commentcount'] = $_rows['tg_commentcount'];
 	        $_html['date'] = $_rows['tg_date'];
 	        $_html['content'] = $_rows['tg_content'];
 	        $_html = _html($_html);
 	        
 	        echo $_html['name'];
 	    }else{
 	        _alert_back('此图片不存在！');
 	    }
 	    
 	}else{
 	    _alert_back('非法操作！');
 	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php 
		require 'includes/title.inc.php';
	?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='photo'>
	<h2>图片详情</h2>
	<dl class="detail">
	   <dd class="name"><?php echo $_html['name']?></dd>
	   <dt><img src="<?php echo $_html['url']?>" /></dt>
	   <dd>阅（<strong><?php echo $_html['readcount']?></strong>） 评（<strong><?php echo $_html['commentcount']?></strong>） 于<?php echo $_html['date']?>上传BY：<?php echo $_html['username']?></dd>
	</dl>
    <p class="line"></p>
    <?php if(isset($_COOKIE['username'])){?>
	<form method="post" action="?action=rephoto">
	    <input type="hidden" name="reid" value="<?php echo $_html['reid']?>" />
		<dl class="rephoto">
		<dd>标　　题：<input type="text" name="title" class="text" value="RE:<?php echo $_html['title']?>" />*（必填，2-40位）</dd>
				<dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a>　<a href="javascript:;"> Q图系列[2]</a>　 <a href="javascript:;">Q图系列[3]</a></dd>
				<dd>
                    <?php include 'includes/ubb.inc.php';?>
				    <textarea name="content" rows="14"></textarea>
				</dd>
				<dd>验 证 码：<input type="text" name="code" class="text yzm"/> <img src="code.php" id="code" /> 
			    <input type="submit" name="sign" class="submit" value="发表帖子"/></dd>
		</dl>
	</form>
	<?php }?>
</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>