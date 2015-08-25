<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-8-19
 */
    session_start();
	//防止恶意调用
 	define('IN_TG', true);
 	//判断当前页面
 	define('SCRIPT','post' );
 	//引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	//判断登录状态
 	if(!isset($_COOKIE['username'])){
 	    _location('发帖前请先登录', 'login.php');
 	}
 	//发送内容
 	if($_GET['action']=='post'){
 	    //验证码验证
 	    _check_code($_POST['code'], $_SESSION['code']);
 	    //唯一标识符验证
 	    if(!!$_rows=_fetch_array("SELECT  tg_uniqid,tg_post_time
                         	        FROM  tg_user
                         	       WHERE  tg_username='{$_COOKIE['username']}'
                         	       LIMIT  1
 	        ")
 	    ){
 	        //对比uniqid
 	        _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
 	        //验证是否在规定的时间外发帖
 	        //_time(time(),$_COOKIE['post_time'],90);
 	        _time(time(),$_rows['tg_post_time'],90);
 	        include ROOT_PATH.'includes/check.func.php';
 	        //定义数据接收数据
            $_clean = array();
            $_clean['username'] = $_COOKIE['username'];
            $_clean['type']=$_POST['type'];
            $_clean['title']=_check_post_title($_POST['title'],2,40);
            $_clean['content']=_check_post_content($_POST['content'],10);
            $_clean = _mysql_string($_clean);
            //写入数据库
            _query("
                    INSERT INTO tg_article (tg_username,tg_type,tg_title,tg_content,tg_date)
                           VALUES          ('{$_clean['username']}','{$_clean['type']}','{$_clean['title']}','{$_clean['content']}',NOW())
                
            ");
            if (_affected_rows() == 1) {
                $_clean['id'] = _insert_id();
//                setcookie('post_time',time());
                $_clean['time'] = time();
                _query("UPDATE tg_user SET tg_post_time='{$_clean['time']}' WHERE tg_username='{$_COOKIE['username']}'");
                _close();
//                 _session_destroy();
                _location('帖子发表成功！','article.php?id='.$_clean['id']);
            } else {
                _close();
//                 _session_destroy();
                _alert_back('帖子发表失败！');
            }
 	    }
 	}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--发表帖子</title>
<?php 
	require 'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/post.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>

	<div id="post">
		<h2>发表帖子</h2>
		<form action="?action=post" name="post" method="post">
			<input type="hidden" name="uniqid" value="<?php echo $_uniqid; ?>"  />
			<dl>
				<dt>请认真填写以下内容</dt>
				<dd>类　　型：
				    <?php 
				        foreach(range(1, 16) as $_num){
				            if($_num==1){
				                echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" checked="checked" name="type" value="'.$_num.'"/>';
				            }else{
				                echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'"/>';
				            }
				            echo '<img src="images/icon'.$_num.'"></label> '; 
				            if($_num==8){
				                echo '<br>　　　　　 ';
				            }
				        }
				    ?>
				</dd>
				
				<dd>标　　题：<input type="text" name="title" class="text"/>*（必填，2-40位）</dd>
				<dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a>　<a href="javascript:;"> Q图系列[2]</a>　 <a href="javascript:;">Q图系列[3]</a></dd>
				<dd>
                    <?php include 'includes/ubb.inc.php';?>
				    <textarea name="content" rows="14"></textarea>
				</dd>
				<dd>验 证 码：<input type="text" name="code" class="text yzm"/> <img src="code.php" id="code" /> <input type="submit" name="sign" class="submit" value="发表帖子"/></dd>
			</dl>
		</form>
	</div>
	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
						
	?>

</body>
</html>