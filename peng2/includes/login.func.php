<?php
header('Content-Type: text/html; charset=gbk');
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

if (!function_exists('_alert_back')) {
	exit('_alert_back()函数不存在，请检查!');
}

if (!function_exists('_mysql_string')) {
	exit('_mysql_string()函数不存在，请检查!');
}


function _setcookies($_username,$_uniqid,$_time) {
	switch ($_time) {
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

function _check_username($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('用户名长度不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	$_char_pattern = '/[<>\'\"\ \　]/';
	if (preg_match($_char_pattern,$_string)) {
		_alert_back('用户名不得包含敏感字符');
	}
	return _mysql_string($_string);
}



function _check_password($_string,$_min_num) {
	if (strlen($_string) < $_min_num) {
		_alert_back('密码不得小于'.$_min_num.'位！');
	}
	return sha1($_string);
}


function _check_time($_string) {
	$_time = array('0','1','2','3');
	if (!in_array($_string,$_time)) {
		_alert_back('保留方式出错！');
	}
	return _mysql_string($_string);
}

?>