<?php
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

header('Content-Type: text/html; charset=GBK');

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
mysql_query("set character set 'GBK'");
mysql_query("set names 'GBK'");



?>