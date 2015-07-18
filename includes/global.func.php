<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-5
 */
	

/**
 * runtime()是用来获取执行耗时的
 * @access public 表示函数对外公开的
 * @return float 表示返回出来是浮点型数字
 * 
 */

	function _runtime(){
		$_mtime = explode(' ', microtime());
		return $_mtime[0] + $_mtime[1];
		
	}	

/**
 * _alert_back() 用来弹出错误窗口并返回
 * @access public
 * @param string $_info 表示弹窗内容
 * @return void  弹窗报错信息并返回
 */
	function _alert_back($_info){
		echo "<script type='text/javascript'>alert('".$_info."');history.back(); </script>";
		exit();
	}
	
	/**
	 * 
	 * @param unknown $_info
	 * @param unknown $_url
	 */
	function _location($_info,$_url){
		echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
		exit();
		
	}
	
	
	/**
	 * _sha1_uniqid()生成唯一标识符
	 * @return string 返回标识符
	 */
	function _sha1_uniqid(){
		return _mysql_string(sha1(uniqid(rand(),ture)));
	}
	
	
	
	function _mysql_string($_string){
		//判断是否开启了自动转义
		if(!GPC){
			return mysql_real_escape_string($_string);
		}

		return $_string;
		
	}
	
	
	
/**
 * _check_code()
 * @access public
 * @param string $_first_code
 * @param string $_end_code
 * @return void 验证码比对
 */
	function _check_code($_first_code,$_end_code){
		if($_first_code != $_end_code){
			_alert_back('验证码不正确!');
		}
	}
	
/**
 * _code()函数是验证码函数
 * @access public
 * @param int $_width 表示验证码的长度
 * @param int $_height 表示验证码的高度 
 * @param int $_rnd_code 表示验证码的位数
 * @param bool $_flag 表示验证码的边框
 * @return void 这个函数执行后产生一个验证码
 */
	function _code($_width = 75,$_height = 25,$_rnd_code = 4,$_flag=false){
		//随机码的数量
		
		
		//创建随机码，保存在Session里。
		for($i=0;$i<$_rnd_code;$i++){
			$nmsg .= dechex(mt_rand(0, 15));
		}
		
		$_SESSION['code'] = $nmsg;
		
		
		//创建一张图片
		$_img = imagecreatetruecolor($_width, $_height);
		
		//建立颜色
		$_white = imagecolorallocate($_img, 255, 255, 255);
		//填充颜色
		imagefill($_img, 0, 0, $_white);
		
		
		//创建黑色边框
		if($_flag){
		$_black = imagecolorallocate($_img, 0, 0, 0);
		imagerectangle($_img, 0, 0, $_width-1, $_height-1, $_black);
		}
		//建立随线条
		for($i=0;$i<6;$i++){
			$_rnd_color = imagecolorallocate($_img, mt_rand(0, 255),mt_rand(0, 255),mt_rand(0, 255));
			imageline($_img, mt_rand(0, $_width), mt_rand(0, $_height),mt_rand(0, $_width), mt_rand(0, $_height), $_rnd_color);
		}
		
		//建立随机雪花
		for($i=0;$i<100;$i++){
			$_rnd_color = imagecolorallocate($_img, mt_rand(200, 255),mt_rand(200, 255),mt_rand(200, 255));
			imagestring($_img, 1, mt_rand(1, $_width), mt_rand(1, $_height), '*', $_rnd_color);
		}
		
		//输出验证码
		for($i=0;$i<strlen($_SESSION['code']);$i++){
			$_rnd_color = imagecolorallocate($_img, mt_rand(0, 100),mt_rand(0, 150),mt_rand(0, 200));
			imagestring($_img, 5, $i*$_width/$_rnd_code+mt_rand(1,10), mt_rand(1,$_height/2), $_SESSION['code'][$i], $_rnd_color);
		}
		
		
		//输出图像
		header('Content-Type:image/png');
		imagepng($_img);
		
		
		
		//销毁图像资源
		imagedestroy($_img);
	}
	
	
	
	
	
	
	
	
?>