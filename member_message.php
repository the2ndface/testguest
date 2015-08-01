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
    define('SCRIPT','member_message' );
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    //判断是否登录
    if(!isset($_COOKIE['username'])){
        _alert_back('请先登录');
    }
    //调用分页函数
    global $_pagenum,$_pagesize;
    _page('SELECT tg_id FROM tg_message',15);

    //从数据库取出短信结果集
    $_result=_query("SELECT
                            tg_id,tg_fromuser,tg_content,tg_date
                       FROM
                            tg_message
                      WHERE
                            tg_touser='{$_COOKIE['username']}'
                   ORDER BY
                            tg_date DESC
                      LIMIT
                            $_pagenum,$_pagesize
                    ");
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--会员中心</title>
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
        <h2>短信管理中心</h2>
        <table>
            <tr><th>发件人</th><th>短信内容</th><th>发信时间</th><th>操作</th></tr>
            <?php 
                while(!!$_rows=_fetch_array_list($_result)){
                    $_html = array();
                    $_html['id'] = $_rows['tg_id'];
                    $_html['fromuser'] = $_rows['tg_fromuser'];
                    $_html['content'] = $_rows['tg_content'];
                    $_html['date'] = $_rows['tg_date'];
                    $_html = _html($_html);
            ?>
            <tr><td><?php echo $_html['fromuser']?></td><td><a href="member_message_detail.php?id=<?php echo $_html['id'];?>" title="<?php echo $_html['content'];?>"><?php echo _title($_html['content'])?></a></td><td><?php echo $_html['date']?></td><td><input type="checkbox" /></td></tr>
            <?php 
                }
                _free_result($_result);
            ?>
        </table>
        <?php _paging(1);?>
    </div>

</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>        