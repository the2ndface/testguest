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
 	define('IN_TG', true);
 	define('SCRIPT','blog' );
 //引入公共文件	
 	require dirname(__FILE__).'/includes/common.inc.php';
 //分页模块
 //判断是否存在$_page
 if(isset($_GET['page'])){
     $_page = $_GET['page']	;
     if(empty($_page) || $_page<0 || !is_numeric($_page)){
         $_page = 1;
     }else{
         $_page = intval($_page);
     }
 }else{
     $_page = 1;
 }

 //每页显示条数
 $_num = _num_rows(_query("SELECT tg_id FROM tg_user"));
 $_pagesize = 10;
 //获取生成页数
 if($_num==0){
     $_pageabsolute = 1;
 }else{
     $_pageabsolute = ceil($_num/$_pagesize);
 }
 
 if($_page>$_pageabsolute){
     $_page = $_pageabsolute;
 }
 //页面的起始位置
 $_pagenum = ($_page-1)*$_pagesize;
 
 //从数据库取出结果集
 $_result=_query("SELECT tg_username,tg_sex,tg_face FROM tg_user ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统－－博友</title>
	<?php 
		require 'includes/title.inc.php';
	?>
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='blog'>
	<h2>博友列表</h2>
	<?php 
	   while(!!$_rows=_fetch_array_list($_result)){
	?>
	<dl>
	   <dd class='user'><?php echo $_rows['tg_username']?>(<?php echo $_rows['tg_sex']?>)</dd>
	   <dt> <img src="<?php echo $_rows['tg_face']?>" /></dt>
	   <dd class='message'>发消息</dd>
	   <dd class='frenid'>加为好友</dd>
	   <dd class='guest'>写留言</dd>
	   <dd class='flower'>给他送花</dd>
	</dl>
	<?php
	   } 
	?>	
	
<div id='page_num'>
    <ul>
        <?php 
            for($i=0;$i<$_pageabsolute;$i++){
                if($_page==($i+1)){
                    echo '<li><a href="blog.php?page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
                }else{
                    echo '<li><a href="blog.php?page='.($i+1).'" >'.($i+1).'</a></li>';
                }
            }
        ?>
        
    </ul>
</div>
<div id='page_text'>
    <ul>
        <?php 
            echo '<li>'.$_page.'/'.$_pageabsolute.'页 | </li>';
            echo '<li>共有<strong>'.$_num.'</strong>位博友 | </li>';
            if($_page ==1){
                echo '<li>首页 | </li>';
                echo '<li>上一页 | </li>';
            }else{
                echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
                echo '<li><a href="'.SCRIPT.'.php?page='.($_page-1).'">上一页</a> | </li>';
            }
            if($page == $_pageabsolute){
                echo '<li>下一页 | </li>';
                echo '<li>尾页</li>';
            }else{
                echo '<li><a href="'.SCRIPT.'.php?page='.($_page+1).'">下一页</a> | </li>';
                echo '<li><a href="'.SCRIPT.'.php?page='.$_pageabsolute.'">尾页</a></li>';
            }
            
        ?>
    </ul>

</div>
</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
		
	?>
</body>
</html>