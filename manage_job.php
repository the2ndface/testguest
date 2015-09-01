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
    define('SCRIPT','manage_job' );
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    //判断管理员登录
    _manage_login();
    //添加管理员
    if($_GET['action']=='add'){
        if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")){
            _uniqid($_rows[tg_uniqid], $_COOKIE['uniqid']);
            
            //添加
            $_clean = array();
            $_clean['username'] = $_POST['manage'];
            $_clean = _mysql_string($_clean);
            
            _query("UPDATE tg_user SET tg_level=1 WHERE tg_username='{$_clean['username']}' LIMIT 1");
            
            if(_affected_rows()==1){
                _close();
                _location('添加管理员成功', 'manage_job.php');
            }else{
                _close();
                _alert_back('添加失败,原因：用户不存在或为空');
            }
        }else{
            _alert_back('非法登录！');
        }
    }
    
    //辞职
    if($_GET['action']=='job' && isset($_GET['id'])){
        if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")){
            _uniqid($_rows[tg_uniqid], $_COOKIE['uniqid']);
            
            _query("UPDATE tg_user SET tg_level=0 WHERE tg_username='{$_COOKIE['username']}' AND tg_id='{$_GET['id']}'");
            if(_affected_rows()==1){
                _close();
                _session_destroy();
                _location('辞职成功', 'index.php');
            }else{
                _close();
                _alert_back('辞职失败');
            }            
        }else{
            _alert_back('非法登录');
        }
    }
    
    //读取会员数据并分页
    global $_pagesize,$_pagenum;
    _page("SELECT tg_id FROM tg_user WHERE tg_level=1",15);
    $_result = _query("SELECT tg_id,tg_username,tg_email,tg_reg_time
                         FROM tg_user
                        WHERE tg_level=1
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
                        if($_html['username']==$_COOKIE['username']){
                            $_html['job_html']='<a href=?action=job&id='.$_html['id'].'>辞职</a>';
                        }else{
                            $_html['job_html']='无权操作';
                        }
                ?>
                <tr><td><?php echo $_html['id']?></td><td><?php echo $_html['username']?></td><td><?php echo $_html['email']?></td><td><?php echo $_html['reg_time']?></td><td><?php echo $_html['job_html']?></td></tr>
                <?php 
                    }
                    _free_result($_result);
                ?>
            </table>
            <form method="post" action="?action=add">
                <input type="text" name="manage" class="text"/> <input type="submit" value="添加管理员"/>
            </form>
        <?php _paging(2);?>
    </div>

</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>        