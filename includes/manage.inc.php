<?php
//防止恶意调用
if(!defined('IN_TG')){
    exit('Access defined!');
}
?>

   <div id='member_side'>
        <h2>管理导航</h2>
        <dl>
            <dt>系统管理</dt>
            <dd><a href="manage.php">系统信息</a></dd>
            <dd><a href="manage_modify.php">修改资料</a></dd>
        </dl>

    </div>