<?php
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

function _connect() {
	global $_conn;
	if (!$_conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD)) {
		exit('���ݿ�����ʧ��');
	}
}



function _select_db() {
	if (!mysql_select_db(DB_NAME)) {
		exit('�Ҳ���ָ�������ݿ�');
	}
}

function _set_names() {
	if (!mysql_query('SET NAMES GBK')) {
		exit('�ַ�������');
	}
}

function _query($_sql) {
	if (!$_result = mysql_query($_sql)) {
		exit('SQLִ��ʧ��');
	}
	return $_result;
}
function _fetch_array($_sql) {
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}
function _fetch_array_list($_result) {
	return mysql_fetch_array($_result,MYSQL_ASSOC);
}

function _num_rows($_result) {
	return mysql_num_rows($_result);
}

function _affected_rows() {
	return mysql_affected_rows();
}
function _is_repeat($_sql,$_info) {
	if (_fetch_array($_sql)) {
		_alert_back($_info);
	}
}


function _close() {
	if (!mysql_close()) {
		exit('�ر��쳣');
	}
}








?>