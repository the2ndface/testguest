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
    session_start();
	//防止恶意调用
 	define('IN_TG', true);
 	//判断当前页面
 	define('SCRIPT','article' );
 	//引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	//处理回帖
 	if($_GET['action']=='rearticle'){
 	    //验证码验证
 	    _check_code($_POST['code'], $_SESSION['code']);
 	    //唯一标识符验证
 	    if(!!$_rows=_fetch_array("SELECT   tg_uniqid
 	                                FROM   tg_user
 	                               WHERE   tg_username='{$_COOKIE['username']}'
 	                               LIMIT   1
 	        ")
 	    ){
 	        //对比uniqid
 	        _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
 	        
 	        //接收数据
 	        $_clean = array();
			$_clean['reid'] = $_POST['reid'];
			$_clean['type'] = $_POST['type'];
			$_clean['title'] = $_POST['title'];
			$_clean['content'] = $_POST['content'];
			$_clean['username'] = $_COOKIE['username'];
			
			$_clean = _mysql_string($_clean);
			
			//写入数据
			_query("INSERT INTO tg_article 
			                    (tg_reid,tg_username,tg_type,tg_title,tg_content,tg_date)
			             VALUES ('{$_clean['reid']}','{$_clean['username']}','{$_clean['type']}','{$_clean['title']}','{$_clean['content']}',NOW()) 
			    ");
 	        
			if (_affected_rows() == 1) {
			    _query("UPDATE tg_article SET tg_commendcount=tg_commendcount+1 WHERE tg_reid=0 AND tg_id='{$_clean['reid']}'");
			    _close();
			    _session_destroy();
			    _location('回帖成功！','article.php?id='.$_clean['reid']);
			} else {
			    _close();
			    _session_destroy();
			    _alert_back('回帖失败！');
			}
      
 	    }
 	}
 	//读出帖子数据
        if(isset($_GET['id'])){
 	    if(!!$_rows=_fetch_array("SELECT tg_id,tg_username,tg_type,tg_title,tg_content,tg_readcount,tg_commendcount,tg_date
 	                                FROM tg_article
 	                               WHERE tg_reid= 0 AND tg_id='{$_GET['id']}'
 	                                 
 	                             ")){
 	                             
 	        //累积阅读量
 	        _query("UPDATE tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}' ");
 	        $_html = array();
 	        $_html['reid'] = $_rows['tg_id'];
 	        $_html['username_subject'] = $_rows['tg_username'];
 	        $_html['title'] = $_rows['tg_title'];
 	        $_html['type'] = $_rows['tg_type'];
 	        $_html['content'] = $_rows['tg_content'];
 	        $_html['readcount'] = $_rows['tg_readcount'];
 	        $_html['commendcount'] = $_rows['tg_commendcount'];
 	        $_html['date'] = $_rows['tg_date'];
 	        
 	        //设置全局变量，传递帖子ID
 	        global $_id;
 	        $_id = 'id='.$_html['reid'].'&';
 	        
 	        
 	        //读取发帖用户信息
 	        if(!!$_rows=_fetch_array(" SELECT tg_id,tg_sex,tg_face,tg_email,tg_url
 	                                     FROM tg_user
 	                                    WHERE tg_username='{$_html['username_subject']}'
 	                                  ")){
                  //提取用户信息
                  $_html['userid'] = $_rows['tg_id'];
                  $_html['sex'] = $_rows['tg_sex'];
                  $_html['face'] = $_rows['tg_face'];
                  $_html['email'] = $_rows['tg_email'];
                  $_html['url'] = $_rows['tg_url'];
                  $_html=_html($_html);
            
            //读取用户回帖
            global $_pagesize,$_pagenum,$_page;
            _page("SELECT tg_id FROM tg_article WHERE tg_reid='{$_html['reid']}'",10);
            
            $_result = _query("SELECT   *
                                 FROM   tg_article
                                WHERE   tg_reid='{$_html['reid']}'
                             ORDER BY   tg_date ASC
                                LIMIT   $_pagenum,$_pagesize            
                ");
            
            
                  
                  
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
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>

	<div id="article">
		<h2>帖子详情</h2>
		<?php if($_page==1){?>
		<div id="subject">
      		<dl>
    			<dd class="user"><?php echo $_html['username_subject']?>(<?php echo $_html['sex']?>)[楼主]</dd>
    			<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username_subject']?>" /></dt>
    			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid']?>">发消息</a></dd>
    			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid']?>">加为好友</a></dd>
    			<dd class="guest">写留言</dd>
    			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid']?>">给他送花</a></dd>
    			<dd class="email">邮件：<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
    			<dd class="url">网址：<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
    		</dl>
    		<div class="content">
    			<div class="user">
    				<span>1#</span><?php echo $_html['username_subject']?> | 发表于：<?php echo $_html['date']?>
    			</div>
    			<h3>主题：<?php echo $_html['title']?> <img src="images/icon<?php echo $_html['type']?>.gif" alt="icon" /></h3>
    			<div class="detail">
    				<?php echo _ubb($_html['content'])?>
    			</div>
    			<div class="read">
    				阅读量：(<?php echo $_html['readcount']?>) 评论量：(<?php echo $_html['commendcount']?>)
    			</div>
    		</div>
		</div>
		<p class="line"></p>
        <?php }?>
		
		<?php 
		  $_i=2;
		  while(!!$_rows=_fetch_array_list($_result)){
		      $_html['username'] = $_rows['tg_username'];
		      $_html['type'] = $_rows['tg_type'];
		      $_html['retitle'] = $_rows['tg_title'];
		      $_html['content'] = $_rows['tg_content'];
		      $_html['date'] = $_rows['tg_date'];
		      
		      $_html=_html($_html);
		      
		      //读取发帖用户 信息
		      if(!!$_rows=_fetch_array("SELECT tg_id,tg_face,tg_sex,tg_url,tg_email
		                                FROM tg_user
		                               WHERE tg_username='{$_html['username']}'                  
		          ")){
	            $_html['userid'] = $_rows['tg_id'];
				$_html['sex'] = $_rows['tg_sex'];
				$_html['face'] = $_rows['tg_face'];
				$_html['email'] = $_rows['tg_email'];
				$_html['url'] = $_rows['tg_url'];
				$_html = _html($_html);
				
		      }else{
		          //这个用户可能已经被删除
		      }
		      //2楼回帖为沙发
		      if($_i==2){
		          if($_html['username']==$_html['username_subject']){
		              $_html['username_html'] = $_html['username'].'(楼主)';
		          }else{
		              $_html['username_html'] = $_html['username'].'(沙发)';
		          }
		      }
		  
		?>
		<div class="re">
		    
      		<dl>
    			<dd class="user"><?php echo $_html['username_html']?>(<?php echo $_html['sex']?>)</dd>
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
    				<span><?php echo $_i+($_page-1)*$_pagesize;?>#</span><?php echo $_html['username']?> | 发表于：<?php echo $_html['date']?>
    			</div>
    			<h3>主题：<?php echo $_html['retitle']?> <img src="images/icon<?php echo $_html['type']?>.gif" alt="icon" /></h3>
    			<div class="detail">
    				<?php echo _ubb($_html['content'])?>
    			</div>
    			
    		</div>
		</div>
		
		<p class="line"></p>
		<?php
		      $_i++;
		  }
		  _paging(1);
		?>
		<?php if(isset($_COOKIE['username'])){?>
		<form method="post" action="?action=rearticle">
		    <input type="hidden" name="reid" value="<?php echo $_html['reid']?>" />
		    <input type="hidden" name="type" value="<?php echo $_html['type']?>" />
    		<dl>
    		<dd>标　　题：<input type="text" name="title" class="text"/ value="RE:<?php echo $_html['title']?>" />*（必填，2-40位）</dd>
    				<dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a>　<a href="javascript:;"> Q图系列[2]</a>　 <a href="javascript:;">Q图系列[3]</a></dd>
    				<dd>
                        <?php include 'includes/ubb.inc.php';?>
    				    <textarea name="content" rows="14"></textarea>
    				</dd>
    				<dd>验 证 码：<input type="text" name="code" class="text yzm"/> <img src="code.php" id="code" /> <input type="submit" name="sign" class="submit" value="发表帖子"/></dd>
    		</dl>
		</form>
		<?php }?>
	</div>
	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
						
	?>

</body>
</html>