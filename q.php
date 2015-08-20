<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-8
 */
	define('IN_TG', true);
	define('SCRIPT','q' );
	//引入公共文件
	require dirname(__FILE__).'/includes/common.inc.php';
	if(isset($_GET['num'])&&isset($_GET['path'])){
	    if(!is_dir(ROOT_PATH.$_GET['path'])){
	        _alert_back('非法操作');
	    }
	    
	}else{
	    _alert_back('非法操作');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--Q图选择</title>
<?php 
	require 'includes/title.inc.php';
?>
<script type="text/javascript" src="js/qopener.js"></script>
</head>
<body>
<div id="q">
	<h3>请选择Q图</h3>
	<dl>
		<?php foreach(range(1,$_GET['num']) as $_num){?>
		<dd><img src="<?php echo $_GET['path'].$_num?>.gif" alt="<?php echo $_GET['path'].$_num?>.gif" title="Q图<?php echo $_num?>" /></dd>
		<?php }?>
	</dl>

</div>

</body>
</html>