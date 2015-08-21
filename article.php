<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-6
 */
	//防止恶意调用
 	define('IN_TG', true);
 	//判断当前页面
 	define('SCRIPT','article' );
 	//引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	
 	//读出数据
 	if(isset($_GET['id'])){
 	    if(!!$_rows=_fetch_array("SELECT tg_id,tg_username,tg_type,tg_title,tg_content,tg_readcount,tg_commendcount,tg_date
 	                                  FROM tg_article
 	                                 WHERE tg_id='{$_GET['id']}'
 	                             ")){
 	        $_html = array();
 	        $_html['username'] = $_rows['tg_username'];
 	        $_html['title'] = $_rows['tg_title'];
 	        $_html['type'] = $_rows['tg_type'];
 	        $_html['content'] = $_rows['tg_content'];
 	        $_html['readcount'] = $_rows['tg_readcount'];
 	        $_html['commendcount'] = $_rows['tg_commendcount'];
 	        $_html['date'] = $_rows['tg_date'];
 	        
 	        //读取发帖用户信息
 	        if(!!$_rows=_fetch_array(" SELECT tg_id,tg_sex,tg_face,tg_email,tg_url
 	                                     FROM tg_user
 	                                    WHERE tg_username='{$_html['username']}'
 	                                  ")){
                  //提取用户信息
                  $_html['userid'] = $_rows['tg_id'];
                  $_html['sex'] = $_rows['tg_sex'];
                  $_html['face'] = $_rows['tg_face'];
                  $_html['email'] = $_rows['tg_email'];
                  $_html['url'] = $_rows['tg_url'];
                  $_html=_html($_html);
                  
 	        }else{
 	            //这个用户已被删除
 	        }
 	    }else{
 	        _alert_back('这个主题不存在！');
 	    }
 	}else{
 	    _alert_back('非法操作！');
 	}
 	
 	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--帖子内容</title>
<?php 
	require 'includes/title.inc.php';
?>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>

	<div id="article">
		<h2>帖子详情</h2>
		<div id="subject">
  		<dl>
			<dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex']?>)</dd>
			<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username']?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid']?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid']?>">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid']?>">给他送花</a></dd>
			<dd class="email">邮件：<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
			<dd class="url">网址：<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span>1#</span><?php echo $_html['username']?> | 发表于：<?php echo $_html['date']?>
			</div>
			<h3>主题：<?php echo $_html['title']?> <img src="images/icon<?php echo $_html['type']?>.gif" alt="icon" /></h3>
			<div class="detail">
				<?php echo $_html['content']?>
			</div>
			<div class="read">
				阅读量：(<?php echo $_html['readcount']?>) 评论量：(<?php echo $_html['commendcount']?>)
			</div>
		</div>
		</div>
		<p class="line"></p>
		1111111111
	</div>
	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
						
	?>

</body>
</html>