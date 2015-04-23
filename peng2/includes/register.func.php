<?php
header('Content-Type: text/html; charset=gbk');
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

if (!function_exists('_alert_back')) {
	exit('_alert_back()���������ڣ�����!');
}

if (!function_exists('_mysql_string')) {
	exit('_mysql_string()���������ڣ�����!');
}

function _check_uniqid($_first_uniqid,$_end_uniqid) {
	
	if ((strlen($_first_uniqid) != 40) || ($_first_uniqid != $_end_uniqid)) {
		_alert_back('Ψһ��ʶ���쳣');
	}
	
	return _mysql_string($_first_uniqid);
}

function _check_username($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('�û������Ȳ���С��'.$_min_num.'λ���ߴ���'.$_max_num.'λ');
	}
	
	$_char_pattern = '/[<>\'\"\ ]/';
	if (preg_match($_char_pattern,$_string)) {
		_alert_back('�û������ð��������ַ�');
	}
	$_mg[0] = '������';
	$_mg[1] = '����';
	$_mg[2] = '����';
	foreach ($_mg as $value) {
		$_mg_string .= '[' . $value . ']' . '\n';
	}
	if (in_array($_string,$_mg)) {
		_alert_back($_mg_string.'���������û�������ע��');
	}
	
	return _mysql_string($_string);
}

function _check_password($_first_pass,$_end_pass,$_min_num) {
	if (strlen($_first_pass) < $_min_num) {
		_alert_back('���벻��С��'.$_min_num.'λ��');
	}
	

	if ($_first_pass != $_end_pass) {
		_alert_back('�����ȷ�����벻һ�£�');
	}
	return sha1($_first_pass);
}
	
function _check_question($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('������ʾ����С��'.$_min_num.'λ���ߴ���'.$_max_num.'λ');
	}
	return _mysql_string($_string);
}

function _check_answer($_ques,$_answ,$_min_num,$_max_num) {
	$_answ = trim($_answ);
	if (mb_strlen($_answ,'utf-8') < $_min_num || mb_strlen($_answ,'utf-8') > $_max_num) {
		_alert_back('����ش𲻵�С��'.$_min_num.'λ���ߴ���'.$_max_num.'λ');
	}
	
	if ($_ques == $_answ) {
		_alert_back('������ʾ��ش𲻵���ͬ');
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
		_alert_back('�ʼ���ʽ����ȷ��');
	}
	if (strlen($_string) < $_min_num || strlen($_string) > $_max_num) {
		_alert_back('�ʼ����Ȳ��Ϸ���');
	}


	
	return _mysql_string($_string);
}

function _check_qq($_string) {
	if (empty($_string)) {
		return null;
	} else {
		//123456
		if (!preg_match('/^[1-9]{1}[\d]{4,9}$/',$_string)) {
			_alert_back('QQ���벻��ȷ��');
		}
	}
	
	return _mysql_string($_string);
}
function _check_url($_string,$_max_num) {
	if (empty($_string) || ($_string == 'http://')) {
		return null;
	} else {
		if (!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_string)) {
			_alert_back('��ַ����ȷ��');
		}
		if (strlen($_string) > $_max_num) {
			_alert_back('��ַ̫����');
		}
	}
	
	return _mysql_string($_string);
}






?>