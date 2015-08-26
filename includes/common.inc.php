<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-4
 */
	//防止恶意调用
	if(!defined('IN_TG')){
		exit('Access defined!');
	}
	header('Content-Type:text/html;charset=utf-8');
	
	define('ROOT_PATH',substr(dirname(__FILE__),0,-8));
	//创建一个自动转义开关的常量
	define('GPC',get_magic_quotes_gpc());
	
	//拒绝低版本访问
	if(PHP_VERSION<'4.1.0'){
		exit('PHP version is too low!');
	}
	
	//引入函数库
	require ROOT_PATH.'includes/global.func.php';
	require ROOT_PATH.'includes/mysql.func.php';
	
	//起始时间
	define('START_TMIE', _runtime());
	//$GLOBALS['start_time']=runtime();
	
	//数据库连接
	define('DB_USER', 'root');
	define('DB_PWD','wsxnm1234');
	define('DB_HOST', 'localhost');
	define('DB_NAME','testguest');
	
	//初始化数据库
	_connect();   	//连接数据库
	_select_db();	//选择数据库
	_set_names();	//设置字符集
	
    //未读信息显示
    $_message = _fetch_array("SELECT COUNT(tg_id) AS count FROM tg_message WHERE tg_state=0 AND tg_touser='{$_COOKIE['username']}'");
    if(empty($_message['count'])){
        $GLOBALS['message'] = '<strong class="noread"><a href="member_message.php">(0)</a></strong>';
    }else{
        $GLOBALS['message'] = '<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
    }
    
    //网站系统设置初始化
    if(!!$_rows=_fetch_array("SELECT    tg_webname,tg_article,tg_blog,tg_photo,tg_skin,tg_string,tg_post,tg_re,tg_code,tg_register
                                FROM    tg_system
                               WHERE    tg_id=1
                               LIMIT    1
                            ")){
   	$_system = array();
    $_system['webname']=$_rows['tg_webname'];
    $_system['article']=$_rows['tg_article'];
    $_system['blog']=$_rows['tg_blog'];
    $_system['photo']=$_rows['tg_photo'];
    $_system['skin']=$_rows['tg_skin'];
    $_system['string']=$_rows['tg_string'];
    $_system['post']=$_rows['tg_post'];
    $_system['re']=$_rows['tg_re'];
    $_system['code']=$_rows['tg_code'];
    $_system['register']=$_rows['tg_register'];
    
    }else{
        exit('系统表异常，请管理员检查！');
    }
	
	
?>
