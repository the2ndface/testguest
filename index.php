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
    session_start();
 	define('IN_TG', true);
 	define('SCRIPT','index' );
    //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
    //	
    //读取数据
    $_html=_html(_get_xml('new.xml'));
    //调用分页函数
    global $_pagenum,$_pagesize;
    _page("SELECT tg_id FROM tg_article",10);
    //读取数据
    $_result = _query("SELECT tg_id,tg_title,tg_type,tg_readcount,tg_commendcount
                         FROM tg_article
                        WHERE tg_reid = 0
                     ORDER BY tg_date DESC
                        LIMIT $_pagenum,$_pagesize
                     ");
 	
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
	<a href="post.php" class="post">发表帖子</a>
	<ul class="aricle">
	   <?php 
	       $_htmllist = array();
           while (!!$_rows = _fetch_array_list($_result)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['type'] = $_rows['tg_type'];
				$_htmllist['readcount'] = $_rows['tg_readcount'];
				$_htmllist['commendcount'] = $_rows['tg_commendcount'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist = _html($_htmllist);
				echo '<li class="icon'.$_htmllist['type'].'"><em>阅读数(<strong>'.$_htmllist['readcount'].'</strong>) 评论数(<strong>'.$_htmllist['commendcount'].'</strong>)</em> <a href="article.php?id='.$_htmllist['id'].'">'._title($_htmllist['title'],20).'</a></li>';
		   }
		   _free_result($_result);
	   ?>
	</ul>
	<?php _paging(2);?>
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