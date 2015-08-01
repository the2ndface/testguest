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
define('SCRIPT','member_modify' ); 
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
if ($_GET['action'] == 'modify') {
    //为了防止恶意注册和跨站攻击
    _check_code($_POST['code'], $_SESSION['code']);
    //为了防止伪造COOKIES，要对比一下唯一标识符uniqid
    if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")){
        include ROOT_PATH.'includes/check.func.php';
        //对比uniqid
        _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);        
        //创建一个空数据，用来存放提交过来的合法数据
        $_clean = array();
        
        $_clean['password'] = _check_modify_password($_POST['password'],6);
        $_clean['sex'] = _check_sex($_POST['sex']);
        $_clean['face'] = _check_face($_POST['face']);
        $_clean['email'] = _check_email($_POST['email'],6,40);
        $_clean['qq']	= _check_qq($_POST['qq']);
        $_clean['url'] = _check_url($_POST['url'],40);
        
        if(empty($_clean['password'])){
            _query("UPDATE tg_user SET
                                        tg_sex='{$_clean['sex']}',
                                        tg_face='{$_clean['face']}',
                                        tg_email='{$_clean['email']}',
                                        tg_qq='{$_clean['qq']}',
                                        tg_url='{$_clean['url']}'
                                    WHERE tg_username='{$_COOKIE['username']}'
                
                ");
        }else{
            _query("UPDATE tg_user SET
                                        tg_password='{$_clean['password']}',
                                        tg_sex='{$_clean['sex']}',
                                        tg_face='{$_clean['face']}',
                                        tg_email='{$_clean['email']}',
                                        tg_qq='{$_clean['qq']}',
                                        tg_url='{$_clean['url']}'
                                        WHERE tg_username='{$_COOKIE['username']}'
            
            ");
        }
        
    	//判断是否修改成功
    	if (_affected_rows() == 1) {
    		_close();
    		_session_destroy();
    		_location('恭喜你，修改成功！','member.php');
    	} else {
    		_close();
    		_session_destroy();
    		_location('很遗憾，没有任合数据被修改！','member_modify.php');
    	}
    
    }
}
//判断是否正常登录
    if(isset($_COOKIE['username'])){
       //获取数据
       $_rows = _fetch_array("SELECT * FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
       if(!!$_rows){
            $_html = array();
            $_html['username']= $_rows['tg_username'];
            $_html['sex']= $_rows['tg_sex'];
            $_html['face']= $_rows['tg_face'];
            $_html['email']= $_rows['tg_email'];
            $_html['url']= $_rows['tg_url'];
            $_html['qq']= $_rows['tg_qq'];
            
            $_html = _html($_html);
            
            //性别选择
            if($_html['sex']=='男'){
                $_html['sex_html']='<input type="radio" name="sex" value="男" checked="checked" >男 </input>
                                    <input type="radio" name="sex" value="女" >女 </input>';
            }elseif($_html['sex']=='女'){
                $_html['sex_html']='<input type="radio" name="sex" value="男" >男</input>
                                    <input type="radio" name="sex" value="女" checked="checked" >女</input> ';
            }
            
            //头像选择
            $_html['face_html']='<select name="face">'; 
                foreach(range(1,9) as $_num){
                    $_html['face_html'].= '<option value="face/m0'.$_num.'.gif">face/m0'.$_num.'.gif</option>';
                }
                foreach(range(10,64) as $_num){
                    $_html['face_html'].= '<option value="face/m0'.$_num.'.gif">face/m0'.$_num.'.gif</option>';
                }
            $_html['face_html'].='</select>';                   
       }else{
           _alert_back('用户不存在！');
       }
    }else{
       _alert_back('非法登录');
    }

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>多用户留言系统--注册</title>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/member_modify.js"></script>
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
        require ROOT_PATH.'includes/member.inc.php'; 
    ?>
    <div id='member_main'>
        <h2>会员管理中心</h2>
        <form method="post" action="?action=modify" name='modify'>
        <dl>
            <dd>用 户 名：<?php echo $_rows['tg_username']?></dd>
            <dd>性　　别：<input type='password' class='text' name='password' value=''>（为空则不修改）</input></dd>
            <dd>性　　别：<?php echo $_html['sex_html']?></dd>
            <dd>头　　像：<?php echo $_html['face_html']?></dd>
            <dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $_html['email']?>"></input></dd>
            <dd>主　　页：<input type="text" class="text" name="url" value="<?php echo $_html['url']?>"></input></dd>
            <dd>Q　 　   Q：<input type="text" class="text" name="qq" value="<?php echo $_html['qq']?>"></input></dd>
            <dd>验 证 码：<input type="text" name="code" class="text yzm"/> <img src="code.php" id="code" /></dd>
            <dd><input type="submit" class="submit" name="submit" value="修改资料"></input></dd>           
        </dl>
        </form>
    </div>



</div>
    <?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>