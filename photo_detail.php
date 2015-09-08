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
 	//回帖
 	if($_GET['action']=='rephoto'){
 	    _check_code($_POST['code'], $_SESSION['code']);
 	    if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
 	        _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
 	        //
 	        //接受数据
 	        $_clean = array();
 	        $_clean['sid'] = $_POST['sid'];
 	        $_clean['title'] = $_POST['title'];
 	        $_clean['content'] = $_POST['content'];
 	        $_clean['username'] = $_COOKIE['username'];
 	        $_clean = _mysql_string($_clean);
 	        //写入数据库
 	        _query("INSERT INTO tg_photo_commend (
                                         	        tg_sid,
                                         	        tg_username,
                                         	        tg_title,
                                         	        tg_content,
                                         	        tg_date
                                         	        )
                             	           VALUES (
                                         	        '{$_clean['sid']}',
                                         	        '{$_clean['username']}',
                                         	        '{$_clean['title']}',
                                         	        '{$_clean['content']}',
                                         	        NOW()
                                         	        )"
 	        );
 	        if (_affected_rows() == 1) {
 	            _query("UPDATE tg_photo SET tg_commendcount=tg_commendcount+1 WHERE tg_id='{$_clean['sid']}'");
 	            _close();
 	            _location('评论成功！','photo_detail.php?id='.$_clean['sid']);
 	        } else {
 	            _close();
 	            _alert_back('评论失败！');
 	        }
 	    
 	    }else{
 	        _alert_back('非法登录！');
 	    }
 	}
 	//读取图片
 	if(isset($_GET['id'])){
 	    if(!!$_rows=_fetch_array("SELECT tg_id,tg_name,tg_url,tg_content,tg_username,tg_readcount,tg_commendcount,tg_date 
 	                          FROM tg_photo 
 	                         WHERE tg_id='{$_GET['id']}'
 	                         LIMIT 1")){
            //累积阅读量
            _query("UPDATE tg_photo SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
 	        $_html = array();
 	        $_html['id'] = $_rows['tg_id'];
 	        $_html['name'] = $_rows['tg_name'];
 	        $_html['url'] = $_rows['tg_url'];
 	        $_html['username'] = $_rows['tg_username'];
 	        $_html['readcount'] = $_rows['tg_readcount'];
 	        $_html['commendcount'] = $_rows['tg_commendcount'];
 	        $_html['date'] = $_rows['tg_date'];
 	        $_html['content'] = $_rows['tg_content'];
 	        $_html = _html($_html);
 	        
 	        //读取评论
 	        //创建一个全局变量，做个带参的分页
 	        global $_id;
 	        $_id = 'id='.$_html['id'].'&';
 	        
 	        
 	        //读取评论
 	        global $_pagesize,$_pagenum,$_page;
 	        _page("SELECT tg_id FROM tg_photo_commend WHERE tg_sid='{$_html['id']}'",2);
 	        $_result = _query("SELECT tg_username,tg_title,tg_content,tg_date
                                 FROM tg_photo_commend
 	                            WHERE tg_sid='{$_html['id']}'
 	                         ORDER BY tg_date ASC
 	                            LIMIT $_pagenum,$_pagesize
 	                         ");

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
	   <dd>阅（<strong><?php echo $_html['readcount']?></strong>） 评（<strong><?php echo $_html['commendcount']?></strong>） 于<?php echo $_html['date']?>上传BY：<?php echo $_html['username']?></dd>
	</dl>
	
	<?php 
	   $_i=1;
	   while (!!$_rows = _fetch_array_list($_result)) {
	       $_html['username'] = $_rows['tg_username'];
	       $_html['retitle'] = $_rows['tg_title'];
	       $_html['content'] = $_rows['tg_content'];
	       $_html['date'] = $_rows['tg_date'];
	       $_html = _html($_html);
	       
	       if(!!$_rows=_fetch_array("SELECT tg_id,tg_sex,tg_face,tg_email,tg_url,tg_switch,tg_autograph
									   FROM tg_user 
									  WHERE tg_username='{$_html['username']}'")){
			  //提取用户信息
			  $_html['userid'] = $_rows['tg_id'];
			  $_html['sex'] = $_rows['tg_sex'];
			  $_html['face'] = $_rows['tg_face'];
			  $_html['email'] = $_rows['tg_email'];
			  $_html['url'] = $_rows['tg_url'];
			  $_html['switch'] = $_rows['tg_switch'];
			  $_html['autograph'] = $_rows['tg_autograph'];
			  $_html = _html($_html);
	       }else{
				//这个用户可能已经被删除了
           }
			
	       
	?>
	<p class="line"></p>
	<div class="re">
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
				<span><?php echo $_i + (($_page-1) * $_pagesize);?>#</span><?php echo $_html['username']?> | 发表于：<?php echo $_html['date']?>
			</div>
			<h3>主题：<?php echo $_html['retitle']?></h3>
			<div class="detail">
				<?php echo _ubb($_html['content'])?>
				<?php 
					if ($_html['switch'] == 1) {
					echo '<p class="autograph">'._ubb($_html['autograph']).'</p>';
					}
				?>
			</div>
		</div>
	</div>
    <?php 
        $_i++;
	    }
	    _free_result($_result);
	    _paging(1);
    ?>
    
    <?php if(isset($_COOKIE['username'])){?>
    <p class="line"></p>
	<form method="post" action="?action=rephoto">
	    <input type="hidden" name="sid" value="<?php echo $_html['id']?>" />
		<dl class="rephoto">
		<dd>标　　题：<input type="text" name="title" class="text" value="RE:<?php echo $_html['name']?>" />*（必填，2-40位）</dd>
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