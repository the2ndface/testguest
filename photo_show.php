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
 	define('SCRIPT','photo_show' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	//删除照片
 	if($_GET['action']=='delete' && isset($_GET['id'])){
 	    //唯一标识符验证
 	    if(!!$_rows=_fetch_array("SELECT   tg_uniqid,tg_article_time
 	        FROM   tg_user
 	        WHERE   tg_username='{$_COOKIE['username']}'
 	        LIMIT   1
 	        ")
 	    ){
 	        //对比uniqid
 	        _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
 	        //取得照片的发布者
 	        if(!!$_rows=_fetch_array("SELECT tg_username,tg_sid,tg_url,tg_id
 	                                    FROM tg_photo
 	                                   WHERE tg_id='{$_GET['id']}'
 	                                   LIMIT 1"
 	        )){
 	            $_html = array();
 	            $_html['id'] = $_rows['tg_id'];
 	            $_html['sid'] = $_rows['tg_sid'];
 	            $_html['username'] = $_rows['tg_username'];
 	            $_html['url'] = $_rows['tg_url'];
 	            $_html = _html($_html);
 	            //判断删除图片的身份是否合法
 	            if ($_html['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])) {
 	                //首先删除图片的数据库信息
 	                _query("DELETE FROM tg_photo WHERE tg_id='{$_html['id']}'");
 	                if (_affected_rows() == 1) {
 	                    _close();
 	                    //判断文件是否存在
 	                    if(file_exists($_html['url'])){
 	                        unlink($_html['url']);
 	                    }else{
 	                        _alert_back('此图片不存在');
 	                    }
 	                    _location('图片删除成功', 'photo_show.php?id='.$_html['sid']);
 	                    
 	                }else{
 	                    _close();
 	                    _alert_back('删除失败');
 	                }
 	            }else{
 	                _alert_back('非法操作');
 	            }
 	        }else{
 	            _alert_back('此图片不存在');
 	        }
 	    }else{
 	        _alert_back('非法登录');
 	    }
 	}
 	//取值
 	if(isset($_GET['id'])){
 	    if(!!$_rows=_fetch_array("SELECT tg_id,tg_name,tg_type FROM tg_dir WHERE tg_id='{$_GET['id']}'")){
 	        $_dirhtml = array();
 	        $_dirhtml['name'] = $_rows['tg_name'];
 	        $_dirhtml['id'] = $_rows['tg_id'];
 	        $_dirhtml['type'] = $_rows['tg_type'];
 	        $_dirhtml = _html($_dirhtml);
 	        
 	        if(!empty($_POST['password'])){
 	            if(!!$_rows=_fetch_array("SELECT tg_id FROM tg_dir WHERE tg_password='".sha1($_POST['password'])."' LIMIT 1")){
 	                setcookie('photo'.$_dirhtml['id'],$_dirhtml['name']);
 	                _location(null, 'photo_show.php?id='.$_dirhtml['id']);
 	            }else{
 	                _alert_back('相册密码不正确！');
 	            }
 	        }
 	    }else{
 	        _alert_back('此相册不存在！');
 	    }
 	}else{
 	    _alert_back('非法操作！');
 	}
 	

 	$_percent = 0.3;
 	
 	//读取图片表
 	//分页
 	global $_pagesize,$_pagenum,$_system,$_id;
 	$_id = 'id='.$_dirhtml['id'].'&';
 	_page("SELECT tg_id FROM tg_photo WHERE tg_sid='{$_dirhtml['id']}'",$_system['photo']);
 	
    //读取表
    $_result = _query("SELECT tg_id,tg_name,tg_url,tg_username,tg_readcount,tg_commendcount 
                               FROM tg_photo 
                              WHERE tg_sid='{$_dirhtml['id']}'
                           ORDER BY tg_date DESC
                              LIMIT $_pagenum,$_pagesize
                            ");
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
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='photo'>
	<h2><?php echo $_dirhtml['name']?></h2>
	<?php 
	   if(empty($_dirhtml['type']) || $_COOKIE['photo'.$_dirhtml['id']]==$_dirhtml['name'] || isset($_SESSION['admin'])){
    	   $_html = array();
    	   while (!!$_rows = _fetch_array_list($_result)){
    	       $_html['id'] = $_rows['tg_id'];
    	       $_html['username'] = $_rows['tg_username'];
    	       $_html['name'] = $_rows['tg_name'];
    	       $_html['url'] = $_rows['tg_url'];
    	       $_html['readcount'] = $_rows['tg_readcount'];
    	       $_html['commendcount'] = $_rows['tg_commendcount'];
    	       $_html = _html($_html);
	?>
        	<dl>
        	   <dt><a href="photo_detail.php?id=<?php echo $_html['id']?>"><img src="thumb.php?filename=<?php echo $_html['url']?>&percent=<?php echo $_percent?>" /></a></dt>
        	   <dd>名称：<a href="photo_detail.php?id=<?php echo $_html['id']?>"><?php echo $_html['name']?></a></dd>
        	   <dd>阅（<strong><?php echo $_html['readcount']?></strong>） 评（<strong><?php echo $_html['commendcount']?></strong>） 上传人：<?php echo $_html['username']?></dd>
        	   <?php if($_html['username']==$_COOKIE['username'] || isset($_SESSION['admin'])){?>
        	   <dd>[<a href="photo_show.php?action=delete&id=<?php echo $_html['id']?>">删除</a>]</dd>
        	   <?php }?>
        	</dl>
	        <?php
            }
            _free_result($_result);
            _paging(1);
            ?>
    	<p><a href="photo_add_img.php?id=<?php echo $_dirhtml['id']?>">上传图片</a></p>
    <?php
	   }else{
	?>       
	       <form method="post" action="photo_show.php?id=<?php echo $_dirhtml['id']?>">
	       <p>请输入密码：<input type="password" name="password"/><input type="submit" value="确认" /></p>
	       </form>
    <?php }?>
    
</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>