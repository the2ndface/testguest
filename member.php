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

//判断是否登录
    if(isset($_COOKIE['username'])){
       //获取数据
       $_rows = _fetch_array("SELECT * FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
       if(!!$_rows){
            $_html = array();
            $_html['username']= $_rows['tg_username'];
            $_html['sex']= $_rows['tg_sex'];
            $_html['face']= $_rows['tg_face'];
            $_html['email']= $_rows['tg_email'];
            $_html['url']= $_rows['tg_url'];
            $_html['qq']= $_rows['tg_qq'];
            $_html['reg_time']= $_rows['tg_reg_time'];
            switch($_rows[tg_level]){
                case 1:
                    $_html['level'] = '管理员';
                    break;
                case 0:
                    $_html['level'] = '普通会员';
                    break;
                default:
                    $_html['level'] = '未知错误';    
            }
            $_html = _html($_html);
       }else{
           _alert_back('用户不存在！');
       }
    }else{
       _alert_back('非法登录');
    }

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
            <dd>用 户 名：<?php echo $_rows['tg_username']?></dd>
            <dd>性　　别：<?php echo $_html['sex']?></dd>
            <dd>头　　像：<?php echo $_html['face']?></dd>
            <dd>电子邮件：<?php echo $_html['email']?></dd>
            <dd>主　　页：<?php echo $_html['url']?></dd>
            <dd>Q　 　   Q：<?php echo $_html['qq']?></dd>
            <dd>注册时间：<?php echo $_html['reg_time']?></dd>
            <dd>身　　份：<?php echo $_html['level']?></dd>
        </dl>
    </div>



</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>