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
 	define('SCRIPT','upimg' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	//只有会员才能上进入
 	if(!isset($_COOKIE['username'])){
 	    _alert_back('非法登录！');
 	}
 	//上传文件
 	if($_GET['action']=='up'){
        if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")){
            //敏感操作，检查标识符
            _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
            //设置图片上传类型
            $_files = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
            
            //判断上传类型是否与数据库一致
            if(is_array($_files)){
                if(!in_array($_FILES['userfile']['type'], $_files)){
                    _alert_back('上传图片必须是jpg,png,gif中的一种！');
                }
            }
            
            //判断错误类型
            if($_FILES['userfile']['error']>0){
                switch ($_FILES['userfile']['error']){
                    case 1:
                        _alert_back('上传文件超过约定值1');
                        break;
                    case 2: 
                        _alert_back('上传文件超过约定值2');
                        break;
                    case 3: 
                        _alert_back('部分文件被上传');
                        break;
                    case 4: 
                        _alert_back('没有任何文件被上传！');
                        break;
                }
                exit;
            }
            
            //判断配置大小
            if($_FILES['userfile']['size'] > 1000000){
                _alert_back('上传文件不能超过1M');
            }
            
            //获取文件扩展名
            $_n = explode('.', $_FILES['userfile']['name']);
            $_name = $_POST['dir'].'/'.time().'.'.$_n[1];
            
            //移动文件
            if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
                if(!move_uploaded_file($_FILES['userfile']['tmp_name'], $_name)){
                    _alert_back('移动失败！');
                }else{
                    echo "<script>alert('上传成功');window.opener.document.getElementById('url').value='$_name';window.close();</script>";
                }
            }else{
                _alert_close('上传的临时文件不存在！');
            }
           
        }else{
            _alert_back('非法登录！');
        }
 	}
 	
 	//取值
 	if(!isset($_GET['dir'])){
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
</head>
<body>
<div id='upimg' style="padding:20px;">
    <form method="post" action="?action=up" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <input type="hidden" name="dir" value="<?php echo $_GET['dir']?>" />
                        选择图片：<input type="file" name="userfile"/>
        <input type="submit" value="上传"/>
    </form>
</div>
</body>
</html>