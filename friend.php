<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:@author
 * Date:2015年7月31日
 */
    
    session_start();
    define('IN_TG', true);
    define('SCRIPT','friend' );
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    //判断是否登录
    if(!isset($_COOKIE['username'])){
        _alert_close('请先登录');
    }
    
    //添加好友
    if($_GET['action']=='add'){
        //验证码验证
        _check_code($_POST['code'], $_SESSION['code']);
        
        //唯一标识符验证
        if(!!$_rows=_fetch_array("SELECT  tg_uniqid
                                    FROM  tg_user
                                   WHERE  tg_username='{$_COOKIE['username']}'
                                   LIMIT  1
          ")
        ){
            //对比uniqid
            _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
        }
        
        include ROOT_PATH.'includes/check.func.php';
        //定义数据接收数据
        $_clean = array();
        
        $_clean['touser']=$_POST['touser'];
        $_clean['fromuser']=$_COOKIE['username'];
        $_clean['content']=_check_content($_POST['content']);
        $_clean = _mysql_string($_clean);
    
        //不能添加自己为好友
        if($_clean['touser']==$_clean['fromuser']){
            _alert_close('不能添加自己为好友！');
        }
        
        //验证双方是否是好友
        if(!!$_rows=_fetch_array("SELECT tg_id 
                                    FROM tg_friend
                                   WHERE tg_touser='{$_clean['touser']}' AND tg_fromuser='{$_clean['fromuser']}'
                                      OR tg_touser='{$_clean['fromuser']}' AND tg_fromuser='{$_clean['touser']}'
                                   LIMIT 1
          ")){
            _alert_close('你们已经是好友了，或者是未验证的好友，无需添加！');
        }else{
        //添加好友，写入数据库
            _query("INSERT INTO tg_friend
                                (tg_touser,tg_fromuser,tg_content,tg_date)
                         VALUES ('{$_clean['touser']}','{$_clean['fromuser']}','{$_clean['content']}',NOW())
                ");
            
            if (_affected_rows()==1){
                //关闭数据库
                _close();
//                 _session_destroy();
                //跳转
                _alert_close('好友添加成功，请等待验证');
            }else{
                //关闭数据库
                _close();
//                 _session_destroy();
                _alert_back('好友添加失败');
            }
        }
    }

    
    if(isset($_GET['id'])){
        if(!!$_rows=_fetch_array("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1")){
            $_html = array();
            $_html['touser'] = $_rows['tg_username'] ;
            $_html = _html($_html);
        }else{
            _alert_close('此用户不存在！');
        }
    }else{
        _alert_close('非法操作！');
    }
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php 
		require 'includes/title.inc.php';
	?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/message.js"></script>
</head>
<body>
    <div id="friend">
        <h3>添加好友</h3>
        <form method="post" action="?action=add" name="submit">
            <input type="hidden" name="touser" value="<?php echo $_html['touser'];?>" />
            <dl>
                <dd><input type="text" readonly="readonly" value="TO:<?php echo $_html['touser'];?>" class="text"></input></dd>
                <dd><textarea name="content">你好，我非常想加你为好友！</textarea></dd>
                <dd>验 证 码：<input type="text" name="code" class="text yzm"/> <img src="code.php" id="code" /><input type="submit" name="sign" class="submit" value="发送请求"/></dd>
            </dl>
        </form>
        
    </div>

</body>
</html>