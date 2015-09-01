<?php
/**
 * TestGuest Version1.0
* ==============================================
* Copy 2010-2012 yc60
* Web:http://www.yc60.com
* ==============================================
* Author:@author
* Date:2015年8月1日
*/
    session_start();
    define('IN_TG', true);
    //判断当前页面
    define('SCRIPT','manage_member' );
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    //判断管理员登录
    _manage_login();
    //读取会员数据并分页
    global $_pagesize,$_pagenum;
    _page("SELECT tg_id FROM tg_user",15);
    $_result = _query("SELECT tg_id,tg_username,tg_email,tg_reg_time
                         FROM tg_user
                     ORDER BY tg_reg_time DESC
                        LIMIT $_pagenum,$_pagesize
        ")
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
	require 'includes/title.inc.php';
?>
<script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>
    <?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='member'>
    <?php
        require ROOT_PATH.'includes/manage.inc.php'; 
    ?>
    <div id='member_main'>
        <h2>会员管理中心</h2>
        <form method="post" action="?action=delete">
            <table>
                <tr><th>会员ID</th><th>会员名</th><th>邮件</th><th>注册时间</th><th>操作</th></tr>
                <?php 
                    $_html = array();
                    while(!!$_rows = _fetch_array_list($_result)){
                        $_html['id'] = $_rows['tg_id'];
                        $_html['username'] = $_rows['tg_username'];
                        $_html['email'] = $_rows['tg_email'];
                        $_html['reg_time'] = $_rows['tg_reg_time'];
                        $_html = _html($_html);
                ?>
                <tr><td><?php echo $_html['id']?></td><td><?php echo $_html['username']?></td><td><?php echo $_html['email']?></td><td><?php echo $_html['reg_time']?></td><td>[<a href="?action=del&id=<?php echo $_html['id']?>">删</a>] [修]</td></tr>
                <?php 
                    }
                    _free_result($_result);
                ?>
            </table>
        </form>
        <?php _paging(2);?>
    </div>

</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>        