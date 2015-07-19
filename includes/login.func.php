<?php

//防止恶意调用
if(!defined('IN_TG')){
    exit('Access defined!');
}

//判断函数存在
if(!function_exists('_alert_back')){
    exit('函数不存在，请检查');
}

if(!function_exists('_mysql_string')){
    exit('_mysql_string函数不存在，请检查');
}


//判断用户名
/**
 * _check_username() 检测并过滤用户名
 * @Access public
 * @param sting $_string 受污染的用户名
 * @param int $_min_num	最小位数
 * @param int $_max_num	最大位数
 * @return string 过滤后的用户名
 */
function _check_username($_string,$_min_num,$_max_num){
    //去掉两边空格
    $_string = trim($_string);
    //长度小于2位或者大于20位都不可
    if(mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num){
        	
        _alert_back('用户名长度不得小于'.$_min_num.'位或者大于'.$_max_num);
    }
   
    //将用户名转义输入
    return mysql_real_escape_string($_string);

}

//生成登录cookies
/**
 * 
 * @param unknown $_username
 * @param unknown $_uniqid
 * @param unknown $_time
 */
function _setcookies($_username,$_uniqid,$_time){
    switch ($_time){
        case '0':
            setcookie('username',$_username);
            setcookie('uniqid',$_uniqid);
            break;
        case '1':
            setcookie('username',$_username,time()+86400);
            setcookie('uniqid',$_uniqid,time()+86400);
            break;
        case '2':
            setcookie('username',$_username,time()+604800);
            setcookie('uniqid',$_uniqid,time()+604800);
            break;
        case '3':
            setcookie('username',$_username,time()+2592000);
            setcookie('uniqid',$_uniqid,time()+2592000);
            break;
    }
    
}

//密码验证
/**
 * _check_password() 验证密码并返回
 * @access public
 * @param string $_first_pass 用户输入的密码
 * @param string $_end_pass  用户输入的确认密码
 * @param int $_min_num  密码最小长度
 * @param int $_max_num	 密码最大长度
 * @return string $_first_pass 反回用户密码
 */

function _check_password($_first_pass,$_min_num){
    //判断密码
    if(strlen($_first_pass) < $_min_num){
        _alert_back('密码不得小于'.$_min_num.'位');
    }
    
    //将密码返回
    return _mysql_string(sha1($_first_pass));
}


function _check_time($_string){
    $_time = array('0','1','2','3');
    if(!in_array($_string,$_time)){
        _alert_back('保留方式出错');
    }
    return _mysql_string($_string);
    
}

