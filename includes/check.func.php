<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-11
 */

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
	

	/**
	 * _check_uniqid() 检测唯一标识符
	 * @param string $_first_uniqid
	 * @param string $_end_uniqid
	 * @return string $_first_uniqid
	 */
	function _check_uniqid($_first_uniqid,$_end_uniqid){
		if((strlen($_first_uniqid)<40) || ($_first_uniqid != $_end_uniqid)){
			_alert_back('唯一标识符异常');
		}
		return _mysql_string($_first_uniqid);
	}
	

	
	/**
	 * _check_username() 检测并过滤用户名
	 * @Access public
	 * @param sting $_string 受污染的用户名
	 * @param int $_min_num	最小位数
	 * @param int $_max_num	最大位数
	 * @return string 过滤后的用户名
	 */
	function _check_username($_string,$_min_num,$_max_num){
		
	    global $_system;
		//去掉两边空格
		$_string = trim($_string);
		//长度小于2位或者大于20位都不可
		if(mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num){
			
			_alert_back('用户名长度不得小于'.$_min_num.'位或者大于'.$_max_num);
		}
		//判断敏感字符
		$_char_pattern = '/[<>\'\"\ ]/';
		if(preg_match($_char_pattern,$_string)){
			_alert_back('用户名不得包含敏感字符');
		}
		//限制敏感用户名
		$_mg = explode('|', $_system['string']);
		
		//告诉用户哪些不能注册
		foreach($_mg as $value){
			$_mg_string .='['. $value. ']'.'\n';
		}
		//这里采用绝对匹配
		if(in_array($_string, $_mg)){
			_alert_back($_mg_string.'等敏感用户名不能注册');
		}
		
		//将用户名转义输入
		return mysql_real_escape_string($_string);
		
		
		
		
	}

	
	/**
	 * _check_password() 验证密码并返回
	 * @access public
	 * @param string $_first_pass 用户输入的密码
	 * @param string $_end_pass  用户输入的确认密码
	 * @param int $_min_num  密码最小长度
	 * @param int $_max_num	 密码最大长度
	 * @return string $_first_pass 反回用户密码
	 */
	
	function _check_password($_first_pass,$_end_pass,$_min_num,$_max_num){
		//判断密码
		if(strlen($_first_pass) < $_min_num){
			_alert_back('密码不得小于'.$_min_num.'位');
		}
		//确认密码一致
		if($_first_pass != $_end_pass){
			_alert_back('密码不一致请重新输入！');
		}
		//将密码返回
		return _mysql_string(sha1($_first_pass));
	}
	
	/**
	 * 修改密码时修进行密码较验
	 * @param unknown $_string
	 * @param unknown $_min_num
	 * @return Ambigous <unknown, string>
	 */
	function _check_modify_password($_string,$_min_num){
	    if(!empty($_string)){
	        //判断密码
	        if(strlen($_string) < $_min_num){
	            _alert_back('密码不得小于'.$_min_num.'位');
	        }
	    }else{
	        return null;
	    }
	    return _mysql_string(sha1($_string));
	}
	
	
	/*
	 * _check_question() 
	 * @access public
	 * @param string $_question
	 * @param int $_min_num
	 * @param int $_max_num
	 * return string $_question
	 */
	
	function _check_question($_question,$_min_num,$_max_num){
		$_question = trim($_question);
		//长度不能小于X位或大于X位
		if(mb_strlen($_question,'utf-8')<$_min_num || mb_strlen($_question,'utf-8')>$_max_num){
			_alert_back('密码提示长度不得小于'.$_min_num.'位或者大于'.$_max_num);
				
		}
		//返回密码提示
		return _mysql_string($_question);
	}
	
	/**
	* _check_answer()
	* @access public
	* @param string $_question
	* @param string $_answer
	* @param int $_min_num
	* @param int $_max_num
	* return string $_answer
	*/
	
	function _check_answer($_question,$_answer,$_min_num,$_max_num){
		$_answer = trim($_answer);
		//长度不能小于X位或大于X位
		if(mb_strlen($_answer,'utf-8')<$_min_num || mb_strlen($_answer,'utf-8')>$_max_num){
			_alert_back('密码答案长度不得小于'.$_min_num.'位或者大于'.$_max_num);
		}
		//密码提示和答案不得相同
		if($_question == $_answer){
			_alert_back('密码提示和答案不得相同');
		}
		
		//返回密码提示答案
		return _mysql_string(sha1($_answer));
	}
	
	/**
	 * _check_sex() 性别
	 * @access public
	 * @param string $_string
	 * @return string
	 */
	function _check_sex($_string){
		return _mysql_string($_string);
	}
	
	
	/**
	 * _check_face() 性别
	 * @access public
	 * @param string $_string
	 * @return string
	 */
	function _check_face($_string){
		return _mysql_string($_string);
	}
	
	/**
	 * _check_email() 检验Email合法性
	 * @access public
	 * @param int $_min_num
	 * @param int $_max_num
	 * @param string $_email 网而传入的邮箱地址
	 * @return string $_email  返回符合格式的地址
	 */
	
	function  _check_email($_email,$_min_num,$_max_num){
		
		if(!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $_email)){
				_alert_back('邮件格式不正确');
		}
		if(strlen($_email)<$_min_num || strlen($_email)>$_max_num){
				_alert_back('邮件长度不合法！');
		}
		
				
		return $_email;
	}
	
	/**
	 *  _check_qq()
	 *  @access public
	 *  @param int $_qq
	 *  @return int $_qq
	 *   
	 */
	
	function _check_qq($_qq){
		if(empty($_qq)){
			return null;
		}else{
		
			if(!preg_match('/^[1-9]{1}[0-9]{4,9}$/', $_qq)){
				_alert_back('QQ号码不正确');
			}
		}
		
		return $_qq;
	}
	
	/**
	 * _check_url()
	 * @access public
	 * @param string $_url
	 * @retun string $_url
	 * 
	 */
	
	function _check_url($_url,$_max_num){
		
		if(empty($_url) || $_url == 'http://'){
			return null;
		}else{
		
			if(!preg_match('/^(https?:\/\/)?(\w+\.)?[\w\-\.]+(\.\w+)+$/', $_url)){
				_alert_back('网址不正确');
			}
			
			if(strlen($_url)>$_max_num){
				_alert_back('URL长度不合法，本站不接受！');
			}
		}
		
				
		return $_url;
	}
	
	/**
	 * 发信内容验证
	 * @param unknown $_string
	 * @return unknown
	 */
	function _check_content($_string){
	    if(strlen($_string) < 10 ||strlen($_string) > 200 ){
	        _alert_back('发信内容不得小于10位或大于200位');
	    }
	    return $_string;
	}
	
	/**
	 * _check_post_title 检查标题长度
	 * @param string $_string 标题内容
	 * @param int $_min_num   最小长度
	 * @param int $_max_num   最大长度
	 * @return &_string 
	 */
	function _check_post_title($_string,$_min_num,$_max_num){
	    if(mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num){
	        _alert_back('标题不得小于'.$_min_num.'位或大于'.$_max_num.'位');
	    }
	    return $_string;
	}
	
	/**
	 * _check_post_content 检查帖子内容长度
	 * @param string $_string  
	 * @param int $_min_num
	 * @return string
	 */
	function _check_post_content($_string,$_min_num){
	    if(mb_strlen($_string,'utf-8') < $_min_num ){
	        _alert_back('帖子内容不得小于'.$_min_num.'位');
	    }
	    return $_string;
	}
	
	/**
	 * _check_autograph 个性签名检查
	 * @param unknown $_string
	 * @param unknown $_min_num
	 * @return unknown
	 */
	function _check_autograph($_string,$_min_num){
	    if(mb_strlen($_string,'utf-8') > $_min_num ){
	        _alert_back('帖子内容不得小于'.$_min_num.'位');
	    }
	    return $_string;
	}
	
	/**
	 * _check_dir_name() 检查目录名
	 * @param unknown $_string
	 * @param unknown $_min
	 * @param unknown $_max
	 * @return unknown
	 */
	function _check_dir_name($_string,$_min,$_max) {
	    if (mb_strlen($_string,'utf-8') < $_min || mb_strlen($_string,'utf-8') > $_max ) {
	        _alert_back('相册名不得小于'.$_min.'位或者不能大于'.$_max.'位！');
	    }
	    return $_string;
	}
	
	/**
	 * _check_dir_name() 检查密码
	 * @param unknown $_string
	 * @param unknown $_num
	 * @return string
	 */
	function _check_dir_password($_string,$_num) {
	    if (strlen($_string) < $_num) {
	        _alert_back('密码不得小于'.$_num.'位！');
	    }
	    return sha1($_string);
	}
	
	
	
	
	
	
	
?>