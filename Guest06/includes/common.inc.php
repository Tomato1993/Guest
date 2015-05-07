<?php
header("Content-Type: text/html; charset=gbk");
if (!defined('IN_TG')) {
	exit('Access Defined!');
}



define('ROOT_PATH',substr(dirname(__FILE__),0,-8));


define('GPC',get_magic_quotes_gpc());


if (PHP_VERSION < '4.1.0') {
	exit('Version is to Low!');
}


require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';


define('START_TIME',_runtime());


define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','111111');
define('DB_NAME','testguest');


_connect();  
_select_db();   
_set_names();  


$_message = _fetch_array("SELECT 
																COUNT(tg_id) 
														AS 
																count 
													FROM 
																tg_message 
												 WHERE 
												 				tg_state=0
												 	   AND
												 	   			tg_touser='{$_COOKIE['username']}'
");
if (empty($_message['count'])) {
	$GLOBALS['message'] = '<strong class="noread"><a href="member_message.php">(0)</a></strong>';
} else {
	$GLOBALS['message'] = '<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
}











?>