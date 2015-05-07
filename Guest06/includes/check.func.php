<?php
header("Content-Type: text/html; charset=gbk");
//��ֹ�������
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

if (!function_exists('_alert_back')) {
	exit('_alert_back()���������ڣ�����!');
}

if (!function_exists('_mysql_string')) {
	exit('_mysql_string()���������ڣ�����!');
}

/**
 * _check_uniqid
 * @param unknown_type $_first_uniqid
 * @param unknown_type $_end_uniqid
 */

function _check_uniqid($_first_uniqid,$_end_uniqid) {
	
	if ((strlen($_first_uniqid) != 40) || ($_first_uniqid != $_end_uniqid)) {
		_alert_back('Ψһ��ʶ���쳣');
	}
	
	return _mysql_string($_first_uniqid);
}

/**
 * _check_username��ʾ��Ⲣ�����û���
 * @access public 
 * @param string $_string ����Ⱦ���û���
 * @param int $_min_num  ��Сλ��
 * @param int $_max_num ���λ��
 * @return string  ���˺���û��� 
 */
function _check_username($_string,$_min_num,$_max_num) {
	//ȥ�����ߵĿո�
	$_string = trim($_string);
	
	//����С����λ���ߴ���20λ
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('�û������Ȳ���С��'.$_min_num.'λ���ߴ���'.$_max_num.'λ');
	}
	
	//���������ַ�
	$_char_pattern = '/[<>\'\"\ ]/';
	if (preg_match($_char_pattern,$_string)) {
		_alert_back('�û������ð��������ַ�');
	}
	
	//���������û���
	$_mg[0] = '��';
	$_mg[1] = 'ɱ��';
	$_mg[2] = '����';
	//�����û�������Щ���ܹ�ע��
	foreach ($_mg as $value) {
		$_mg_string .= '[' . $value . ']' . '\n';
	}
	//������õľ���ƥ��
	if (in_array($_string,$_mg)) {
		_alert_back($_mg_string.'���������û�������ע��');
	}
	
	//���û���ת������
	return _mysql_string($_string);
}


/**
 * _check_password��֤����
 * @access public
 * @param string $_first_pass
 * @param string $_end_pass
 * @param int $_min_num
 * @return string $_first_pass ����һ�����ܺ������
 */

function _check_password($_first_pass,$_end_pass,$_min_num) {
	//�ж�����
	if (strlen($_first_pass) < $_min_num) {
		_alert_back('���벻��С��'.$_min_num.'λ��');
	}
	
	//���������ȷ�ϱ���һ��
	if ($_first_pass != $_end_pass) {
		_alert_back('�����ȷ�����벻һ�£�');
	}
	
	//�����뷵��
	return sha1($_first_pass);
}

function _check_modify_password($_string,$_min_num) {
	//�ж�����
	if (!empty($_string)) { 
		if (strlen($_string) < $_min_num) {
			_alert_back('���벻��С��'.$_min_num.'λ��');
		}
	} else {
		return null;
	}
	return sha1($_string);
}
	
/**
 * _check_question ����������ʾ
 * @access public
 * @param string $_string
 * @param int $_min_num
 * @param int $_max_num
 * @return string $_string ����������ʾ
 */

function _check_question($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	//����С��4λ���ߴ���20λ
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('������ʾ����С��'.$_min_num.'λ���ߴ���'.$_max_num.'λ');
	}
	
	//����������ʾ
	return _mysql_string($_string);
}

/**
 *_check_answer()
 *@access public 
 * @param string $_ques
 * @param string $_answ
 * @param int $_min_num
 * @param int $_max_num
 * @return $_answ
 */
function _check_answer($_ques,$_answ,$_min_num,$_max_num) {
	$_answ = trim($_answ);
	//����С��4λ���ߴ���20λ
	if (mb_strlen($_answ,'utf-8') < $_min_num || mb_strlen($_answ,'utf-8') > $_max_num) {
		_alert_back('����ش𲻵�С��'.$_min_num.'λ���ߴ���'.$_max_num.'λ');
	}
	
	//������ʾ��ش���һ��
	if ($_ques == $_answ) {
		_alert_back('������ʾ��ش𲻵���ͬ');
	}
	
	//���ܷ���
	return _mysql_string(sha1($_answ));
}

/**
 * _check_sex  �Ա�
 * @access public
 * @param string $_string
 * @return string 
 */

function _check_sex($_string) {
	return _mysql_string($_string);
}

/**
 * _check_face ͷ��
 * @access public
 * @param string $_string
 * @return string 
 */

function _check_face($_string) {
	return _mysql_string($_string);
}

/**
 * _check_email() ��������Ƿ�Ϸ�
 * @access public
 * @param string $_string �ύ�������ַ
 * @return string $_string ��֤�������
 */

function _check_email($_string,$_min_num,$_max_num) {
	//�ο�bnbbs@163.com
	//[a-zA-Z0-9_] => \w
	//[\w\-\.] 16.3.
	//\.[\w+] .com.com.com.net.cn
	//����ͦ�����Ƚ��鷳������������ˣ��ͺܼ��ˡ�
	//����������Ƚ��鷳����ֱ������

	if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)) {
		_alert_back('�ʼ���ʽ����ȷ��');
	}
	if (strlen($_string) < $_min_num || strlen($_string) > $_max_num) {
		_alert_back('�ʼ����Ȳ��Ϸ���');
	}


	
	return _mysql_string($_string);
}

/**
 * _check_qq ....
 * @access public
 * @param int $_string
 * @return int $_string  QQ����
 */

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

/**
 * _check_url ��ַ��֤
 * @access public
 * @param string $_string
 * @return string $_string ������֤�����ַ
 */

function _check_url($_string,$_max_num) {
	if (empty($_string) || ($_string == 'http://')) {
		return null;
	} else {
		//http://ww.yc60.com
		//?��ʾ0�λ���һ��
		if (!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_string)) {
			_alert_back('��ַ����ȷ��');
		}
		if (strlen($_string) > $_max_num) {
			_alert_back('��ַ̫����');
		}
	}
	
	return _mysql_string($_string);
}

function _check_content($_string) {
	if (mb_strlen($_string,'utf-8') < 10 || mb_strlen($_string,'utf-8') > 200) {
		_alert_back('�������ݲ���С��10λ���ߴ���200λ��');
	}
	return $_string;
}


function _check_post_title($_string,$_min,$_max) {
	if (mb_strlen($_string,'utf-8') < $_min || mb_strlen($_string,'utf-8') > $_max) {
		_alert_back('���ӱ������ݲ���С��'.$_min.'λ����'.$_max.'λ��');
	}
	return $_string;
}

function _check_post_content($_string,$_num) {
	if (mb_strlen($_string,'utf-8') < $_num) {
		_alert_back('�������ݲ���С��'.$_num.'λ��');
	}
	return $_string;
}

function _check_autograph($_string,$_num) {
	if (mb_strlen($_string,'utf-8') >$_num) {
		_alert_back('�������ݲ���С��'.$_num.'λ��');
	}
	return $_string;
}

?>