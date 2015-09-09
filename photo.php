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
 	define('SCRIPT','photo' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 	//删除目录
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
 	        //删除目录
 	        if (!!$_rows = _fetch_array("SELECT   tg_dir
 	                                       FROM   tg_dir
 	                                      WHERE   tg_id='{$_GET['id']}'
 	                                      LIMIT   1")){
                $_html = array();
                $_html['url'] = $_rows['tg_dir'];
                $_html = _html($_html);
                //3.删除磁盘的目录
                if(file_exists($_html['url'])){
                    if(_remove_Dir($_html['url'])){
                        //1.删除目录里的数据库图片
                        _query("DELETE FROM tg_photo WHERE tg_sid='{$_GET['id']}'");
                        //2.删除这个目录的数据库
                        _query("DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'");
                        _close();
                        _location('目录删除成功!','photo.php');
                    }else{
                        _close();
                        _alert_back('目录删除失败');
                    }
                }
 	        }else{
 	            _alert_back('目录不存在');
 	        }
 	        
 	        
 	    }else{
 	        _alert_back('非法登录');
 	    }
 	}
 	//调用分页函数
    global $_pagenum,$_pagesize,$_system;
    _page('SELECT tg_id FROM tg_dir',$_system['photo']);
    //从数据库取出结果集
    $_result=_query("SELECT     tg_id,tg_name,tg_type,tg_face
                       FROM     tg_dir
                   ORDER BY     tg_date DESC
                      LIMIT     $_pagenum,$_pagesize
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
	<h2>相册列表</h2>
	<?php 
	    $_html=array();
	    while(!!$_rows=_fetch_array_list($_result)){
	        $_html['id'] = $_rows['tg_id'];
			$_html['name'] = $_rows['tg_name'];
			$_html['type'] = $_rows['tg_type'];
			$_html['face'] = $_rows['tg_face'];
			$_html = _html($_html);
			
			//获取照片数
			$_html['photo'] = _fetch_array("SELECT count(*) AS count FROM tg_photo WHERE tg_sid='{$_html['id']}'");
			if($_html['type']==0){
			    $_html[type_html]='(公开)';
			}else{
			    $_html[type_html]='(私密)';
			}
			if(empty($_html['face'])){
			    $_html['face_html']='';
			}else{
			    $_html['face_html']='<img src="'.$_html['face'].'" alt="'.$_html['name'] .'">';
			}
	?>
	<dl>
	   <dt><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['face_html']?></a></dt>
	   <dd><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['name'].' ['.$_html['photo']['count'].'] '.$_html[type_html]?></a></dd>
	   <?php if(isset($_SESSION['admin']) && isset($_COOKIE['username'])){?>
	   <dd>[<a href="photo_modify_dir.php?id=<?php echo $_html['id'];?>">修改</a>] [<a href="photo.php?action=delete&id=<?php echo $_html['id']?>">删除</a>]</dd>
	   <?php }?>
	</dl>
    <?php }?>
	<?php if(isset($_SESSION['admin']) && isset($_COOKIE['username'])){?>
	<p><a href="photo_add_dir.php">添加相册</a></p>
	<?php }?>
</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>