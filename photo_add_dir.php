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
 	define('SCRIPT','photo_add_dir' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
    //管理员登录
    _manage_login();
    //添加目录
    if($_GET['action']=='adddir'){
        if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")){
            //敏感操作，检查标识符
            _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
            //接收数据
            $_clean = array();
            $_clean['name'] = $_POST['name'];
            $_clean['type'] = $_POST['type'];
            $_clean['password'] = sha1($_POST['password']);
            $_clean['content'] = $_POST['content'];
            $_clean['dir'] = time();
            $_clean = _mysql_string($_clean);
            
            //创建目录
            //先检查主目录是否存在
            if(!is_dir('photo')){
                mkdir('photo',0777);
            }
            //创建新目录
            if(!is_dir('photo/'.$_clean['dir'])){
                mkdir('photo/'.$_clean['dir'],0777);
            }
            //写入数据库
            if(empty($_clean['type'])){
                _query("INSERT INTO tg_dir (tg_name,tg_type,tg_content,tg_dir,tg_date)
                                    VALUES ('{$_clean['name']}','{$_clean['type']}','{$_clean['content']}','photo/{$_clean['dir']}',NOW())
                    ");
            }else{
                _query("INSERT INTO tg_dir (tg_name,tg_type,tg_content,tg_dir,tg_date,tg_password)
                                    VALUES ('{$_clean['name']}','{$_clean['type']}','{$_clean['content']}','photo/{$_clean['dir']}',NOW(),'{$_clean['password']}')
                ");
            }
            //目录添加成功
            if (_affected_rows() == 1) {
                _close();
                _location('目录添加成功','photo.php');
            } else {
                _close();
                _alert_back('目录添加失败！');
            }
            
            
        }else{
            _alert_back('非法登录！');
        }
    }
 	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php 
		require 'includes/title.inc.php';
	?>
<script type="text/javascript" src="js/photo_add_dir.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='photo'>
	<h2>添加相册目录</h2>
	<form method="post" action="?action=adddir">
	   <dl>
	       <dd>相册名称：<input type="text" name="name" class="text" /></dd>
	       <dd>相册类型：<input type="radio" name="type" value="0" checked="checked" />公开 <input type="radio" name="type" value="1" />私密</dd>
	       <dd id="pass">相册密码：<input type="password" name="password" class="text" /></dd>
	       <dd>相册描述：<textarea name="content"></textarea></dd>
	       <dd><input type="submit" value="添加相册" class="submit"/></dd>
	   </dl>
	</form>
	
</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>