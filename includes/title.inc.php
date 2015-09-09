<?php 
/**
 * TestGuest Version1.0
 * ==============================================
 * Copy 2010-2012 yc60
 * Web:http://www.yc60.com
 * ==============================================
 * Author:Lee
 * Data:2015-1-8
 */

	if(!defined('IN_TG')){
		exit('Access defined!');
	}	
	if(!defined('SCRIPT')){
		exit('Script error!');
	}
	
	global $_system;
?>
<title><?php echo $_system['webname'] ?></title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="styles/<?php echo $_system['skin']?>/basic.css"/>
<link rel="stylesheet" type="text/css" href="styles/<?php echo $_system['skin']?>/<?php echo SCRIPT?>.css"/>
