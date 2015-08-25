<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:@author
 * Date:2015年7月24日
 */
    session_start();
    define('IN_TG', true);
    //判断当前页面
    define('SCRIPT','manage_set' ); 
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php';
    //判断是否是管理员登录
    _manage_login();
    
    //读取数据
    if(!!$_rows=_fetch_array("SELECT    tg_webname,tg_article,tg_blog,tg_photo,tg_skin,tg_string,tg_post,tg_re,tg_code,tg_register
                                FROM    tg_system
                               WHERE    tg_id=1
                               LIMIT    1
                            ")
    ){
        $_html = array();
        $_html['webname'] = $_rows['tg_webname'];
        $_html['article'] = $_rows['tg_article'];
        $_html['blog'] = $_rows['tg_blog'];
        $_html['photo'] = $_rows['tg_photo'];
        $_html['skin'] = $_rows['tg_skin'];
        $_html['string'] = $_rows['tg_string'];
        $_html['post'] = $_rows['tg_post'];
        $_html['re'] = $_rows['tg_re'];
        $_html['code'] = $_rows['tg_code'];
        $_html['register'] = $_rows['tg_register'];
        $_html = _html($_html);
        
    }else{
        _alert_back('系统表读取错误请联系系统管理员！');
    }
    
    //文章列表
	if ($_html['article'] == 10) {
		$_html['article_html'] = '<select name="article"><option value="10" selected="selected">每页10篇</option><option value="15">每页15篇</option></select>';
	} elseif ($_html['article'] == 15) {
		$_html['article_html'] = '<select name="article"><option value="10">每页10篇</option><option value="15" selected="selected">每页15篇</option></select>';
	}
	
	//博友
	if ($_html['blog'] == 15) {
		$_html['blog_html'] = '<select name="blog"><option value="15" selected="selected">每页15人</option><option value="20">每页20人</option></select>';
	} elseif ($_html['blog'] == 20) {
		$_html['blog_html'] = '<select name="blog"><option value="15">每页15人</option><option value="20" selected="selected">每页20人</option></select>';
	}

	//相册
	if ($_html['photo'] == 8) {
	    $_html['photo_html'] = '<select name="photo"><option value="8" selected="selected">每页8张</option><option value="12">每页12张</option></select>';
	} elseif ($_html['photo'] == 12) {
	    $_html['photo_html'] = '<select name="photo"><option value="8">每页8张</option><option value="12" selected="selected">每页12张</option></select>';
	}
	
	//皮肤
	if ($_html['skin'] == 1) {
	    $_html['skin_html'] = '<select name="skin"><option value="1" selected="selected">一号皮肤</option><option value="2">二号皮肤</option><option value="3">三号皮肤</option></select>';
	} elseif ($_html['skin'] == 2) {
	    $_html['skin_html'] = '<select name="skin"><option value="1">一号皮肤</option><option value="2" selected="selected">二号皮肤</option><option value="3">三号皮肤</option></select>';
	} elseif ($_html['skin'] == 3) {
	    $_html['skin_html'] = '<select name="skin"><option value="1">一号皮肤</option><option value="2">二号皮肤</option><option value="3" selected="selected">三号皮肤</option></select>';
	}
	
	//发帖
	if ($_html['post'] == 30) {
	    $_html['post_html'] = '<input type="radio" name="post" value="30" checked="checked" /> 30秒 <input type="radio" name="post" value="60" /> 1分钟 <input type="radio" name="post" value="180" /> 3分钟';
	} elseif ($_html['post'] == 60) {
	    $_html['post_html'] = '<input type="radio" name="post" value="30" /> 30秒 <input type="radio" name="post" value="60" checked="checked" /> 1分钟 <input type="radio" name="post" value="180" /> 3分钟';
	} elseif ($_html['post'] == 180) {
	    $_html['post_html'] = '<input type="radio" name="post" value="30" /> 30秒 <input type="radio" name="post" value="60" /> 1分钟 <input type="radio" name="post" value="180" checked="checked" /> 3分钟';
	}
	
	//回帖
	if ($_html['re'] == 15) {
	    $_html['re_html'] = '<input type="radio" name="re" value="15" checked="checked" /> 15秒 <input type="radio" name="re" value="30" /> 30秒 <input type="radio" name="re" value="45" /> 45秒';
	} elseif ($_html['re'] == 30) {
	    $_html['re_html'] = '<input type="radio" name="re" value="15" /> 15秒 <input type="radio" name="re" value="30" checked="checked" /> 30秒 <input type="radio" name="re" value="45" /> 45秒';
	} elseif ($_html['re'] == 45) {
	    $_html['re_html'] = '<input type="radio" name="re" value="15" /> 15秒 <input type="radio" name="re" value="30" /> 30秒 <input type="radio" name="re" value="45" checked="checked" /> 45秒';
	}
	
	//验证码
	if ($_html['code'] == 1) {
	    $_html['code_html'] =  '<input type="radio" name="code" value="1" checked="checked" /> 启用 <input type="radio" name="code" value="0" /> 禁用';
	} else {
	    $_html['code_html'] =  '<input type="radio" name="code" value="1" /> 启用 <input type="radio" name="code" value="0" checked="checked"  /> 禁用';
	}
	
	//放开注册
	if ($_html['register'] == 1) {
	    $_html['register_html'] =  '<input type="radio" name="register" value="1" checked="checked" /> 启用 <input type="radio" name="register" value="0" /> 禁用';
	} else {
	    $_html['register_html'] =  '<input type="radio" name="register" value="1" /> 启用 <input type="radio" name="register" value="0" checked="checked" /> 禁用';
	}


 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--管理中心</title>
<?php 
	require 'includes/title.inc.php';
?>
</head>
<body>
    <?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
<div id='member'>
    <?php
        require ROOT_PATH.'includes/manage.inc.php'; 
    ?>
    <div id='member_main'>
        <h2>后台管理中心</h2>
        <dl>
            <dd>·网 站 名 称：<input type="text" name="webname" class="text" value="<?php echo $_html['webname']?>"/></dd>
            <dd>·文章每页列表数：<?php echo $_html['article_html']?></dd>
            <dd>·博客每页列表数：<?php echo $_html['blog_html']?></dd>
            <dd>·相册每页列表数：<?php echo $_html['photo_html']?></dd>
            <dd>·站点 默认 皮肤：<?php echo $_html['skin_html']?></dd>
            <dd>·非法 字符 过滤：<input type="text" name="string" class="text" value="<?php echo $_html['string']?>"/></dd>
            <dd>·每次 发帖 限制：<?php echo $_html['post_html']?></dd>
            <dd>·每次 回帖 限制：<?php echo $_html['re_html']?></dd>
            <dd>·是否 启用 验证：<?php echo $_html['code_html']?></dd>
            <dd>·是否 开放 注册：<?php echo $_html['register_html']?></dd>
			<dd><input type="submit" value="修改系统设置" class="submit" /></dd>
        </dl>
    </div>



</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>