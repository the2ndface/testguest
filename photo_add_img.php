<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:@author
 * Date:2015年7月21日
 */
    session_start();
 	define('IN_TG', true);
 	define('SCRIPT','photo_add_img' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	//这张页面必须是会员
 	if(!isset($_COOKIE['username'])){
 	    _alert_back('非法登录！');
 	}
 	//图片信息存入表
 	if($_GET['action']=='addimg'){
 	    if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")){
            //敏感操作，检查标识符
            _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
            include 'includes/check.func.php';
            $_clean = array();
            $_clean = array();
            $_clean['name'] = _check_dir_name($_POST['name'],2,20);
            $_clean['url'] = _check_photo_url($_POST['url']);
            $_clean['content'] = $_POST['content'];
            $_clean['sid'] = $_POST['sid'];
            $_clean = _mysql_string($_clean);
            //写入数据库
            _query("INSERT INTO tg_photo (tg_name,tg_url,tg_content,tg_sid,tg_username,tg_date)
                                  VALUES ('{$_clean['name']}','{$_clean['url']}','{$_clean['content']}','{$_clean['sid']}','{$_COOKIE['username']}',NOW())
                ");
            if (_affected_rows() == 1) {
                _close();
                _location('图片添加成功！','photo_show.php?id='.$_clean['sid']);
            } else {
                _close();
                _alert_back('图片添加失败！');
            }
 	    }else{
 	        _alert_back('非法登录！');
 	    }
 	}   
 	
 	//取值
 	if(isset($_GET['id'])){
 	    if(!!$_rows=_fetch_array("SELECT tg_id,tg_dir FROM tg_dir WHERE tg_id='{$_GET['id']}'")){
 	        $_html = array();
 	        $_html['id'] = $_rows['tg_id'];
 	        $_html['dir'] = $_rows['tg_dir'];
 	        $_html = _html($_html);
 	    }else{
 	        _alert_back('此相册不存在！');
 	    }
 	}else{
 	    _alert_back('非法操作！');
 	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php 
		require 'includes/title.inc.php';
	?>
<script type="text/javascript" src="js/photo_add_img.js"></script>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='photo'>
	<h2>上传图片</h2>
    <form method="post" action="?action=addimg">
    <input type="hidden" name="sid" value="<?php echo $_html['id']?>"/>
        <dl>
            <dd>图片名称：<input type="text" name="name" class="text"/></dd>
            <dd>图片地址：<input type="text" name="url" id='url' readonly="readonly" class="text"/><a href="javascript:;" title="<?php echo $_html['dir'];?>" id="up">上传</a></dd>
            <dd>图片名称：<textarea name="content"></textarea></dd>
            <dd><input type="submit" class="submit" value="添加图片" /></dd>
        </dl>
        
    </form>

</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>