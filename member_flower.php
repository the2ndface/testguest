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
    define('SCRIPT','member_flower' );
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    //判断是否登录
    if(!isset($_COOKIE['username'])){
        _alert_back('请先登录');
    }
    
    //批量删除花朵
    if($_GET['action']=='delete' && isset($_POST['ids'])){
        $_clean = array();
        $_clean['ids']=_mysql_string(implode(',', $_POST['ids']));
    
        //危险操作，为了防止cookies伪造，还要比对一下唯一标识符uniqid()
        if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")){
            //对比uniqid
            _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
    
            //批量删除
            _query("DELETE FROM tg_flower WHERE tg_id IN ({$_clean['ids']}) ");
    
            //判断是否成功
            if(_affected_rows()){
                _close();
                _location('花朵删除成功','member_flower.php');
            }else{
                _close();
                _alert_back('花朵删除失败！');
            }
        }else{
            _alert_back('非法登录');
        }
    
    }
    
    
    //调用分页函数
    global $_pagenum,$_pagesize;
    _page("SELECT tg_id FROM tg_flower WHERE tg_touser='{$_COOKIE['username']}' ",15);

    //从数据库取出短信结果集
    $_result=_query("SELECT tg_id,tg_touser,tg_fromuser,tg_flower,tg_content,tg_date
                       FROM tg_flower
                      WHERE tg_touser='{$_COOKIE['username']}'
                   ORDER BY tg_date DESC
                      LIMIT $_pagenum,$_pagesize
                    ");
    
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
        require ROOT_PATH.'includes/member.inc.php'; 
    ?>
    <div id='member_main'>
        <h2>花朵中心</h2>
        <form method="post" action="?action=delete">
            <table>
                <tr><th>送花人</th><th>花朵</th><th>感言</th><th>发信时间</th><th>操作</th></tr>
                <?php 
                    $_html = array();
                    while(!!$_rows=_fetch_array_list($_result)){
                        $_html['id'] = $_rows['tg_id'];
                        $_html['touser'] = $_rows['tg_touser'];
                        $_html['fromuser'] = $_rows['tg_fromuser'];
                        $_html['content'] = $_rows['tg_content'];
                        $_html['flower'] = $_rows['tg_flower'];
                        $_html['date'] = $_rows['tg_date'];
                        $_html['count'] +=$_html['flower'];
                        $_html = _html($_html);
                            
                       
                ?>
                <tr><td><?php echo $_html['fromuser']?></td><td><img src="images/x4.gif" /> x<?php echo $_html['flower'];?>朵</td><td title="<?php echo $_html['content'];?>"><?php echo _title($_html['content'],14)?></td><td><?php echo $_html['date']?></td><td><input type="checkbox" name="ids[]" value="<?php echo $_html['id']?>"/></td></tr>
                <?php 
                    }
                    _free_result($_result);
                ?>
                <tr><td colspan="5">共<?php echo $_html['count']?>朵花</td></tr>
                <tr><td colspan="5"><label for="all">全选<input type="checkbox" name="chkall" id="all" /></label><input type="submit" value="批量删除"/></td></tr>
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