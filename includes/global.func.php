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
	 * _alert_close 提示信息并关闭窗口
	 * @param unknown $_info
	 */
	function _alert_close($_info){
	    echo "<script type='text/javascript'>alert('".$_info."');window.close(); </script>";
	    exit();	    
	}
	
	
/**
 * _html() 格式化HTML特殊字符。
 * @param unknown $_string
 */
	function _html($_string){
	    if(is_array($_string)){
	        foreach ($_string as $_key => $_value){
	            $_string[$_key]= _html($_value);
	        }
	    }else{
	        $_string = htmlspecialchars($_string);
	    }
	    
	    return $_string;
	}
	

	
	/*
	 * 对特殊字符进行转义
	 */
	function _mysql_string($_string){
	    //判断是否开启了自动转义
	    if(!GPC){
	        if(is_array($_string)){
	            foreach ($_string as $_key => $_value){
	                $_string[$_key]= _html($_value);
	            }
	        }else{
	            $_string = mysql_real_escape_string($_string);
	        }
	    }
	    return $_string;
	}
	
	
	/**
	 * 
	 * @param unknown $_info
	 * @param unknown $_url
	 */
	function _location($_info,$_url){
	    if(!empty($_info)){
		echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
		exit();
	    }else{
	        header('Location:'.$_url);
	    }
		
	}
	
	
	/**
	 * _sha1_uniqid()生成唯一标识符
	 * @return string 返回标识符
	 */
	function _sha1_uniqid(){
		return _mysql_string(sha1(uniqid(rand(),ture)));
	}
	
	


	/**
	 * 判断登录状态
	 */
    function _login_state(){
        if(isset($_COOKIE['username'])){
            _alert_back('登录状态下无法进行此操作');
        }
    }
	

    /**
     * 判断数据库的uniqid和cookies内的是否相同
     * @param unknown $_mysql_uniqid 数据库取出的uniqid
     * @param unknown $_cookies_uniqid COOKIE内的uniqid
     */
    function _uniqid($_mysql_uniqid,$_cookies_uniqid){
        if($_mysql_uniqid!=$_cookies_uniqid){
            _alert_back('唯一标识符异常！');
        }
    }
    
    /**
     * _title($_string) 显示内容大于14字时，进行截取，只显示前14字
     * @param unknown $_string
     * @return string
     */
    function _title($_string){
        if(mb_strlen($_string,'utf-8')>14){
            $_string=mb_substr($_string, 0,14,'utf-8').'...';
        }
        return $_string;
    }

    /**
     * 销毁session
     */
	function _session_destroy(){
	    session_destroy();
	}

	/**
	 * 销毁COOKIE
	 */
	function _unsetcookies(){
	    setcookie('username','',time()-1);
	    setcookie('uniqid','',time()-1);
	    _session_destroy();
	    _location(NULL, 'index.php');
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
     * _page()分页函数
     * @param $_sql 数据库语句，用以返回所有记录数
     * @param $_size 每页显示条数
     * @return 通过全局变量，将值传递出去
     * 
     */
	function _page($_sql,$_size){
	    //通过全局变量，将值传递出去
	    global $_page,$_pageabsolute,$_num,$_pagenum,$_pagesize;
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
	    $_num = _num_rows(_query($_sql));
	    $_pagesize = $_size;
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
	    
	}
	
	
	
    /**
     * _paging() 根据参数不同，使用不同的分页显示方式
     * @param unknown $_type  1｜2  1代表数字，2代表文本
     * @return 返回分页
     */	
	function _paging($_type){
	    //使变量可以页面调 用
	    global $_page,$_pageabsolute,$_num;
	    if($_type==1){
	        echo '<div id="page_num">';
	        echo '<ul>';
	        for($i=0;$i<$_pageabsolute;$i++){
	            if($_page==($i+1)){
	                echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
	            }else{
	                echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'" >'.($i+1).'</a></li>';
	            }
	        }
	        echo '</ul>';
	        echo '</div>';
	    }elseif($_type==2){
	        echo "<div id='page_text'>";
	        echo '<ul>';
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
	        echo '</ul>';
	        echo '</div>';
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