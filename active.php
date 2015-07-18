<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-31
 */
//防止恶意调用
define('IN_TG', true);
//判断当前页面
define('SCRIPT','active' );
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
if(!isset($_GET['active'])){
    _alert_back('非法操作');
}
//开始激活处理
if(isset($_GET['action']) && isset($_GET['active']) && $_GET[action]=='ok'){
    $_active = _mysql_string($_GET['active']);
    if(_fetch_array("SELECT tg_active FROM tg_user WHERE tg_active='$_active' LIMIT 1")){
        _query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
        if(_affected_rows()==1){
            _close();
            _location('帐户激活成功', 'login.php');
        }else{
            _close();
            _location('帐户激活失败，请重新注册', 'register.php');
        }
    }else{
        _alert_back('非法操作');
    }
    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--激活</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
	
	<div id="active">
		<h2>激活帐户</h2>
		<p>本页面是为了模拟您的邮件激活功能，点击以下超链接激活您的帐户</p>
		<p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active']?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>active.php?action=ok&amp;active=<?php echo $_GET['active']?></a></p>
	</div>
	
	
	
	
	
	
	
	
	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
						
	?>

</body>
</html>