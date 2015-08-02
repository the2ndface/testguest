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

    define('IN_TG', true);
    //判断当前页面
    define('SCRIPT','member_friend' );
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    //判断是否登录
    if(!isset($_COOKIE['username'])){
        _alert_back('请先登录');
    }
    
    //调用分页函数
    global $_pagenum,$_pagesize;
    _page("SELECT tg_id FROM tg_friend WHERE tg_touser='{$_COOKIE['username']}' OR tg_fromuser='{$_COOKIE['username']}'",15);

    //从数据库取出短信结果集
    $_result=_query("SELECT tg_id,tg_touser,tg_fromuser,tg_content,tg_date,tg_state
                       FROM tg_friend
                      WHERE tg_touser='{$_COOKIE['username']}'
                         OR tg_fromuser='{$_COOKIE['username']}'
                   ORDER BY tg_date DESC
                      LIMIT $_pagenum,$_pagesize
                    ");
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--好友列表</title>
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
        <h2>好友设置中心</h2>
        <form method="post" action="?action=delete">
            <table>
                <tr><th>好友</th><th>请求内容</th><th>发信时间</th><th>状态</th><th>操作</th></tr>
                <?php 
                    while(!!$_rows=_fetch_array_list($_result)){
                        $_html = array();
                        $_html['id'] = $_rows['tg_id'];
                        $_html['touser'] = $_rows['tg_touser'];
                        $_html['fromuser'] = $_rows['tg_fromuser'];
                        $_html['content'] = $_rows['tg_content'];
                        $_html['state'] = $_rows['tg_state'];
                        $_html['date'] = $_rows['tg_date'];
                        $_html = _html($_html);
                        
                        if($_html['touser']==$_COOKIE['username']){
                            $_html['friend']=$_html['fromuser'];
                            if(empty($_html['state'])){
                                $_html['state_html']='我未验证';
                            }else{
                                $_html['state_html']='通过';
                            }
                            
                        }elseif($_html['fromuser']==$_COOKIE['username']){
                            $_html['friend']=$_html['touser'];
                            if(empty($_html['state'])){
                                $_html['state_html']='对方未验证';
                            }else{
                                $_html['state_html']='通过';
                            }
                        }
                       
                ?>
                <tr><td><?php echo $_html['friend']?></td><td title="<?php echo $_html['content'];?>"><?php echo _title($_html['content'])?></td><td><?php echo $_html['date']?></td><td><?php echo $_html['state_html']?></td><td><input type="checkbox" name="ids[]" value="<?php echo $_html['id']?>"/></td></tr>
                <?php 
                    }
                    _free_result($_result);
                ?>
                <tr><td colspan="5"><label for="all">全选<input type="checkbox" name="chkall" id="all" /></label><input type="submit" value="批量删除"/></input></td></tr>
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