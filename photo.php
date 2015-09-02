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
	   <dt><?php echo $_html['face_html']?></dt>
	   <dd><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['name'].' '.$_html[type_html]?></a></dd>
	   <?php if(isset($_SESSION['admin']) && isset($_COOKIE['username'])){?>
	   <dd>[<a href="photo_modify_dir.php?id=<?php echo $_html['id'];?>">修改</a>] [删除]</dd>
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