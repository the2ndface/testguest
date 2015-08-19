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
	   <li class="icon1"><em>阅读数(<strong>72</strong>) 评论数(<strong>2</strong>)</em> <a href="###">创意时代：解密QQ仙侠传美术创意设计</a></li>
	   <li class="icon2"><em>阅读数(<strong>194</strong>) 评论数(<strong>7</strong>)</em> <a href="###">天掉下馅饼《游戏人生》变装拿大奖</a></li>
	   <li class="icon3"><em>阅读数(<strong>39</strong>) 评论数(<strong>0</strong>)</em> <a href="###">格斗大作《街头霸王4》PC版即将公布</a></li>
	   <li class="icon4"><em>阅读数(<strong>46</strong>) 评论数(<strong>0</strong>)</em> <a href="###">暗黑魔幻《炼狱》4月19正式开放封测</a></li>
	   <li class="icon5"><em>阅读数(<strong>23</strong>) 评论数(<strong>0</strong>)</em> <a href="###">永恒之塔的日子有一种自豪叫做牺牲</a></li>
	   <li class="icon6"><em>阅读数(<strong>33</strong>) 评论数(<strong>0</strong>)</em> <a href="###">盘点多年以后你还刻骨铭心的十款游戏</a></li>
	   <li class="icon7"><em>阅读数(<strong>23</strong>) 评论数(<strong>0</strong>)</em> <a href="###">炫舞吧 内测火爆 引领休闲舞蹈网游</a></li>
	   <li class="icon8"><em>阅读数(<strong>22</strong>) 评论数(<strong>0</strong>)</em> <a href="###">姚仙亲自主刀 《仙剑5》剧透曝光?</a></li>
	   <li class="icon9"><em>阅读数(<strong>12</strong>) 评论数(<strong>1</strong>)</em> <a href="###">新概念战车网游《钢铁围攻》24日封测</a></li>
	   <li class="icon10"><em>阅读数(<strong>251</strong>) 评论数(<strong>3</strong>)</em> <a href="###">完美国际新副本即将推出 背景揭秘</a></li>
	</ul>
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