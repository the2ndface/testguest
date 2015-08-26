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
 	define('SCRIPT','register' );
 	//引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	
 	//判断登录状态
 	_login_state();
 	//判断是否提交了数据
 	if($_GET['action'] == 'register' ){
 		
 		
 		//为了防止恶意注册和跨站攻击
 		_check_code($_POST['code'], $_SESSION['code']);
		
 		include ROOT_PATH.'includes/check.func.php';
 		//创建一个空数据，用来存放提交过来的合法数据
 		$_clean = array();
 		//可以通过唯一标识符来防止恶意注册和跨站攻击
 		//这个存放入数据库的唯一标识符还有第二个用处，就是登录cookies验证
 		$_clean['uniqid'] = _check_uniqid($_POST['uniqid'], $_SESSION['uniqid']);
 		//active用来进行激活处理
 		$_clean['active'] = _sha1_uniqid();
 		$_clean['username'] = _check_username($_POST['username'],2,20);
 		$_clean['password'] = _check_password($_POST['password'], $_POST['notpassword'], 6, 40);
	 	$_clean['question'] = _check_question($_POST['question'], 2, 40);
 		$_clean['answer'] = _check_answer($_POST['question'], $_POST['answer'],2,40);
 		$_clean['sex'] = _check_sex($_POST['sex']);
 		$_clean['face'] = _check_face($_POST['face']);
 		$_clean['email'] = _check_email($_POST['email'],6,40);
		$_clean['qq']	= _check_qq($_POST['qq']);
		$_clean['url'] = _check_url($_POST['url'],40);
 		
 		//在新增前判断用户名是否重复
//  		$_query = _query("SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}'");
//  		if(mysql_fetch_array($_query,MYSQL_ASSOC)){
//  			_alert_back('对不起，此用户已被注册！');
//  		}
 		_is_repeat("SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}' LIMIT 1", 
 					'对不起，此用户已被注册！'			
 		);
		
		//在双引号里直接放变量是可以的，但如果是数组就必须加上花括号{} 比如{$_clean['username']}
		_query(
					"INSERT INTO tg_user (
											tg_uniqid,
											tg_active,
											tg_username,
											tg_password,
											tg_question,
											tg_answer,
											tg_sex,
											tg_face,
											tg_email,
											tg_qq,
											tg_url,
											tg_reg_time,
											tg_last_time,
											tg_last_ip
 										 )
 								  VALUES (
 								  			'{$_clean['uniqid']}',
 								  			'{$_clean['active']}',
 								  			'{$_clean['username']}',
 								  			'{$_clean['password']}',
 								  			'{$_clean['question']}',
 								  			'{$_clean['answer']}',
 								  			'{$_clean['sex']}',
 								  			'{$_clean['face']}',
 								  			'{$_clean['email']}',
 								  			'{$_clean['qq']}',
 								  			'{$_clean['url']}',
 								  			NOW(),
 								  			NOW(),
 								  			'{$_SERVER['REMOTE_ADDR']}'
 										  )"
 					);
		if (_affected_rows()==1){
			//关闭数据库
			$_clean['id'] = _insert_id();
			_close();
// 			_session_destroy();
			//跳转
			_set_xml('new.xml', $_clean);
			_location('恭喜您，注册成功，浏览器将跳转到激活页！','active.php?active='.$_clean[active]);
		}else{
			//关闭数据库
			_close();
// 			_session_destroy();
			_location('对不起，注册失败，请重新注册','register.php');
		}
		
		
 	}else{
 		$_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
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
<script type="text/javascript" src="js/register.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>

	<div id="register">
		<h2>会员注册</h2>
		<?php if(!empty($_system['register'])){?>
		<form action="register.php?action=register" name="register" method="post">
			<input type="hidden" name="uniqid" value="<?php echo $_uniqid; ?>"  />
			<dl>
				<dt>请认真填写以下内容</dt>
				<dd>用 户 名：<input type="text" name="username" class="text"/>*（必填，至少两位）</dd>
				<dd>密　　码：<input type="password" name="password" class="text"/>*（必填，至少六位）</dd>
				<dd>确认密码：<input type="password" name="notpassword" class="text"/>*（必填，至少六位）</dd>
				<dd>密码提示：<input type="text" name="question" class="text"/>*（必填，至少两位）</dd>
				<dd>密码回答：<input type="text" name="answer" class="text"/>*（必填，至少两位）</dd>
				<dd>姓　　别：<input type="radio" name="sex" value="男" checked="checked" />男
						   <input type="radio" name="sex" value="女" />女</dd>
				<dd class="face"><input type="hidden" name="face" value="face/m01.gif" /><img src="face/m01.gif" id="faceimg" /></dd>
				<dd>电子邮件：<input type="text" name="email" class="text"/>*（必填，用于激活）</dd>
				<dd>　 Q Q　：<input type="text" name="qq" class="text"/></dd>
				<dd>个人网站：<input type="text" name="url" value="http://" class="text"/></dd>
				<dd>验 证 码：<input type="text" name="code" class="text yzm"/> <img src="code.php" id="code" /></dd>
				<dd><input type="submit" name="sign" class="submit" value="注册"/></dd>
			</dl>
		</form>
		<?php }else{
		          echo '<h4 style="text-align:center; margin:20px;">此网站已关闭新用户注册！</h4>';
		}?>
	</div>
	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
						
	?>

</body>
</html>