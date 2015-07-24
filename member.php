<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:@author
 * Date:2015年7月24日
 */

define('IN_TG', true);
//判断当前页面
define('SCRIPT','member' ); 
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--注册</title>
<?php 
	require 'includes/title.inc.php';
?>
</head>
<body>
    <?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='member'>
    <?php
        require ROOT_PATH.'includes/member.inc.php'; 
    ?>
    <div id='member_main'>
        <h2>会员管理中心</h2>
        <dl>
            <dd>用户名</dd>
            <dd>性别</dd>
            <dd>头像</dd>
            <dd>电子邮件</dd>
            <dd>主页</dd>
            <dd>QQ</dd>
            <dd>注册时间</dd>
            <dd>身份</dd>
        </dl>
    </div>



</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>