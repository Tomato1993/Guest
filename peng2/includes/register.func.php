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

function _check_uniqid($_first_uniqid,$_end_uniqid) {
	
	if ((strlen($_first_uniqid) != 40) || ($_first_uniqid != $_end_uniqid)) {
		_alert_back('唯一标识符异常');
	}
	
	return _mysql_string($_first_uniqid);
}

function _check_username($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('用户名长度不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	$_char_pattern = '/[<>\'\"\ ]/';
	if (preg_match($_char_pattern,$_string)) {
		_alert_back('用户名不得包含敏感字符');
	}
	$_mg[0] = '共产党';
	$_mg[1] = '民主';
	$_mg[2] = '自由';
	foreach ($_mg as $value) {
		$_mg_string .= '[' . $value . ']' . '\n';
	}
	if (in_array($_string,$_mg)) {
		_alert_back($_mg_string.'以上敏感用户名不得注册');
	}
	
	return _mysql_string($_string);
}

function _check_password($_first_pass,$_end_pass,$_min_num) {
	if (strlen($_first_pass) < $_min_num) {
		_alert_back('密码不得小于'.$_min_num.'位！');
	}
	

	if ($_first_pass != $_end_pass) {
		_alert_back('密码和确认密码不一致！');
	}
	return sha1($_first_pass);
}
	
function _check_question($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('密码提示不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	return _mysql_string($_string);
}

function _check_answer($_ques,$_answ,$_min_num,$_max_num) {
	$_answ = trim($_answ);
	if (mb_strlen($_answ,'utf-8') < $_min_num || mb_strlen($_answ,'utf-8') > $_max_num) {
		_alert_back('密码回答不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	if ($_ques == $_answ) {
		_alert_back('密码提示与回答不得相同');
	}
	
	return _mysql_string(sha1($_answ));
}

function _check_sex($_string) {
	return _mysql_string($_string);
}

function _check_face($_string) {
	return _mysql_string($_string);
}

function _check_email($_string,$_min_num,$_max_num) {

	if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)) {
		_alert_back('邮件格式不正确！');
	}
	if (strlen($_string) < $_min_num || strlen($_string) > $_max_num) {
		_alert_back('邮件长度不合法！');
	}


	
	return _mysql_string($_string);
}

function _check_qq($_string) {
	if (empty($_string)) {
		return null;
	} else {
		//123456
		if (!preg_match('/^[1-9]{1}[\d]{4,9}$/',$_string)) {
			_alert_back('QQ号码不正确！');
		}
	}
	
	return _mysql_string($_string);
}
function _check_url($_string,$_max_num) {
	if (empty($_string) || ($_string == 'http://')) {
		return null;
	} else {
		if (!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_string)) {
			_alert_back('网址不正确！');
		}
		if (strlen($_string) > $_max_num) {
			_alert_back('网址太长！');
		}
	}
	
	return _mysql_string($_string);
}






?>