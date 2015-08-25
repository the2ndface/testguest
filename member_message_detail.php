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
    define('SCRIPT','member_message_detail' );
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    //判断是否登录
    if(!isset($_COOKIE['username'])){
        _alert_back('请先登录');
    }
    
    //删除单条短信
    if($_GET['action']=='delete' && isset($_GET['id'])){
        //验证短信的合法性
        if(!!$_rows=_fetch_array("SELECT 
                                      tg_id
                               FROM   
                                      tg_message
                              WHERE 
                                      tg_id='{$_GET['id']}'
                                
                            ")){
                            
            //危险操作，为了防止cookies伪造，还要比对一下唯一标识符uniqid()
            if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")){
                include ROOT_PATH.'includes/check.func.php';
                //对比uniqid
                _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
                //删除短信
                _query("DELETE FROM tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1 ");
                //验证是否删除成功
                if (_affected_rows() == 1) {
                    _close();
                    _location('短信删除成功','member_message.php');
                } else {
                    _close();
                    _alert_back('短信删除失败');
                }
            
            }
            
        }else{
            _alert_back('此短信不存在!');
        }
    }
    
    //获取短信内容
    if(isset($_GET['id'])){
        $_rows=_fetch_array("SELECT 
                                      tg_id,tg_fromuser,tg_content,tg_date,tg_state
                               FROM   
                                      tg_message
                              WHERE 
                                      tg_id='{$_GET['id']}'
                              LIMIT   1
                                
                            ");
        if($_rows){
            if(empty($_rows['tg_state'])){
                _query("UPDATE tg_message SET tg_state='1' WHERE  tg_id='{$_GET['id']}' LIMIT 1");
                if(!_affected_rows()){
                    _alert_back('数据异常');
                }
            }
            $_html = array();
            $_html['id'] = $_rows['tg_id'];
            $_html['fromuser']=$_rows['tg_fromuser'];
            $_html['content']=$_rows['tg_content'];
            $_html['date']=$_rows['tg_date'];
            $_html=_html($_html);
        }else{
            _alert_back('此短信不存在！');
        }                     
    }else{
        _alert_back('非法登录');
    }
    
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--短信</title>
<?php 
	require 'includes/title.inc.php';
?>
<script type="text/javascript" src="js/member_message_detail.js"></script>
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
        <dl>
            <dd>发 件 人：<?php echo $_html['fromuser']?></dd>
            <dd>短信内容：<strong><?php echo $_html['content']?></strong></dd>
            <dd>发送时间：<?php echo $_html['date']?></dd>
            <dd class="button" ><input type="button" value="返回列表" id="return" /><input type="button" value="删除短信"  id="delete" name="<?php echo $_html['id']?>"/></dd>
        </dl>
    
    </div>

</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>        