<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-9
 */
	session_start();	
	//防止恶意调用
	define('IN_TG', true);
	
	//引入公共文件
	require dirname(__FILE__).'/includes/common.inc.php';
	//生成验证码
	_code();
?>