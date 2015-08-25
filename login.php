<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:@author
 * Date:2015年7月18日
 */
    session_start();
    //防止恶意调用
    define('IN_TG', true);
    //判断当前页面
    define('SCRIPT','login' );
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    //判断登录状态
    _login_state();

    //开始处理登录状态
    if($_GET['action']=='login'){
        //为了防止恶意注册和跨站攻击
 		_check_code($_POST['code'], $_SESSION['code']);
		
 		include ROOT_PATH.'includes/login.func.php';
 		
 		//接收数据
 		$_clean = array();
 		$_clean['username'] = _check_username($_POST['username'],2,20);
 		$_clean['password'] = _check_password($_POST['password'],6);
 		$_clean['time'] = _check_time($_POST['time']);
 		
 		
 		//登录验证
 		if(!!$_rows = _fetch_array("SELECT tg_username,tg_uniqid,tg_level FROM tg_user WHERE tg_username='{$_clean['username']}' and tg_password='{$_clean['password']}' and tg_active='' LIMIT 1"))
 		{
 		    _query("UPDATE tg_user SET
 		                                 tg_last_time=NOW(),
 		                                 tg_last_ip='{$_SERVER['REMOTE_ADDR']}',
 		                                 tg_login_count=tg_login_count+1
 		                           WHERE
 		                                 tg_username='{$_rows['tg_username']}'                
 		         		        ");
 		    
 		    _close();
//  		    _session_destroy();
            if($_rows['tg_level']==1){
                $_SESSION['admin']= $_rows['tg_username'];
            }

 		    _setcookies($_rows['tg_username'], $_rows['tg_uniqid'], $_clean['time']);
 		    _location(null, 'member.php');
 		}else{
 		    _close();
//  		    _session_destroy();
 		    _location('用户名或密码错误或者帐户未激活', 'login.php');
 		}
 		    
    }
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
	require 'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
	
	<div id='login'>
	   <h2>登录</h2>
	   <form action="login.php?action=login" name="login" method="post">
			<dl>
				<dt> </dt>
				<dd>用 户 名：<input type="text" name="username" class="text"/></dd>
				<dd>密　　码：<input type="password" name="password" class="text"/></dd>
				<dd>保　　留：<input type="radio" name="time" value='0' checked="checked" />不保留
				           <input type="radio" name="time" value='1' />一天
				           <input type="radio" name="time" value='2' />一周
				           <input type="radio" name="time" value='3' />一月
				</dd>
				<dd>验 证 码：<input type="text" name="code" class="text code"/> <img src="code.php" id="code" /></dd>
				<dd><input type="submit" name="submit" class="button" value="登录"/><input type="button" name="button" id="location" class="button location" value="注册"/></dd>
			</dl>
		</form>
	
	</div>
	
	
	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>