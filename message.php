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
    define('IN_TG', true);
    define('SCRIPT','message' );
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    if(!isset($_COOKIE['username'])){
        _alert_close('请先登录');
    }
    if(isset($_GET['id'])){
        if(!!$_rows=_fetch_array("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1")){
            $_html = array();
            $_html['username'] = $_rows['tg_username'] ;
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
<title>多用户留言系统－－博友</title>
	<?php 
		require 'includes/title.inc.php';
	?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/message.js"></script>
</head>
<body>
    <div id="message">
        <h3>发短信</h3>
        <form>
            <dl>
                <dd><input type="text" value="TO:<?php echo $_html['username'];?>" class="text"></input></dd>
                <dd><textarea name="content"></textarea></dd>
                <dd>验 证 码：<input type="text" name="code" class="text yzm"/> <img src="code.php" id="code" /><input type="submit" name="sign" class="submit" value="发送"/></dd>
            </dl>
        </form>
        
    </div>

</body>
</html>