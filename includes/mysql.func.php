<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-28
 */

//防止恶意调用
if(!defined('IN_TG')){
	exit('Access defined!');
}
header('Content-Type:text/html;charset=utf-8');



/**
 * _connect()连接数据库
 * @access public
 * @return 连接数据库
 */
function _connect(){
	//表示全局变量，意图是将此变量在函数外部也可以访问
	global $_conn;
	if(!$_conn = mysql_connect(DB_HOST,DB_USER,DB_PWD)){
		exit('数据库连接失败');
	}
}	

/**
 * _select_db() 选择一款数据库
 * @access public
 * @return void 选择数据库
 */
function _select_db(){
	//选择数据库
	if(!mysql_select_db(DB_NAME)){
		exit('所选的数据库不存在！');
	}
}

/**
 * _set_names() 设置字符集
 * @access public
 * @return void
 */
function _set_names(){
	if(!mysql_query('SET NAMES UTF8')){
		
		exit('字符集错误');
	}
	
}

/**
 * _query() 执行数据库语句
 * @param string $_sql
 * @return resource 返回结果集
 */

function _query($_sql){
	if(!$result = mysql_query($_sql)){
		exit('SQL执行失败');
	}
	return $result;
}

/**
 * _fetch_array() 用来返回数据库的操作结果
 * @param unknown $_sql
 * @return array  从数据库结果集中返回一行做为数组,并将指针移至下一条记录开头处:
 */
function _fetch_array($_sql){
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}

/**
 * _fetch_array_list 从数据库的结果集里返回一条数据
 * @param unknown $_result
 * @return multitype:
 */
function _fetch_array_list($_result){
    return mysql_fetch_array($_result,MYSQL_ASSOC);
}

function _num_rows($_result){
    return mysql_num_rows($_result);
}


/**
 * _affected_rows() 返回受SQL语句影响的行数
 * @return int number 
 */
function _affected_rows(){
	return mysql_affected_rows();
}

/**
 * _free_result 释放结果集
 * @param unknown $_result
 */
function _free_result($_result){
    mysql_free_result($_result);
}

/**
 * _is_repeat() 判断用户是否被注册
 * @access public
 * @param string $_sql  SELECT语句
 * @param string $_info 输出的警告信息
 * @return void
 */
function _is_repeat($_sql,$_info){
	if(_fetch_array($_sql)){
		_alert_back($_info);
	}
	
}

/**
 * 
 */
function _close(){
	if(!mysql_close()){
		exit('数据库关闭失败');
	}
}









?>