<?php
header("Content-Type: text/html; charset=gbk");
session_start();
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','friend');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//�ж��Ƿ��¼��
if (!isset($_COOKIE['username'])) {
	_alert_close('���ȵ�¼��');
}
//��Ӻ���
if ($_GET['action'] == 'add') {
	_check_code($_POST['code'],$_SESSION['code']);
	if (!!$_rows = _fetch_array("SELECT 
																tg_uniqid 
												 FROM 
																tg_user 
											   WHERE 
																tg_username='{$_COOKIE['username']}' 
												   LIMIT 
																1
	")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
	}
	include ROOT_PATH.'includes/check.func.php';
	$_clean = array();
	$_clean['touser'] = $_POST['touser'];
	$_clean['fromuser'] = $_COOKIE['username'];
	$_clean['content'] = _check_content($_POST['content']);
	$_clean = _mysql_string($_clean);
	//��������Լ�
	if ($_clean['touser'] == $_clean['fromuser']) {
		_alert_close('�벻Ҫ����Լ���');
	}
	//���ݿ���֤�����Ƿ��Ѿ����
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id 
													  FROM 
													  				tg_friend
													WHERE
																	(tg_touser='{$_clean['touser']}' AND tg_fromuser='{$_clean['fromuser']}')
															OR
																	(tg_touser='{$_clean['fromuser']}' AND tg_fromuser='{$_clean['touser']}')
														LIMIT 
																	1
	")) {
		_alert_close('�����Ѿ��Ǻ����ˣ�������δ��֤�ĺ��ѣ�������ӣ�');
	} else {
		//��Ӻ�����Ϣ
		_query("INSERT INTO tg_friend (
																tg_touser,
																tg_fromuser,
																tg_content,
																tg_date
															 )
											 VALUES (
											 					'{$_clean['touser']}',
											 					'{$_clean['fromuser']}',
											 					'{$_clean['content']}',
											 					NOW()
											 				)
		");
		if (_affected_rows() == 1) {
			_close();
			_session_destroy();
			_alert_close('������ӳɹ�����ȴ���֤��');
		} else {
			_close();
			_session_destroy();
			_alert_back('�������ʧ�ܣ�');
		}
	}
}
//��ȡ����
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_username 
													  FROM 
																	tg_user 
													WHERE 
																	tg_id='{$_GET['id']}' 
														LIMIT 
																	1
	")) {
		$_html = array();
		$_html['touser'] = $_rows['tg_username'];
		$_html = _html($_html);
	} else {
		_alert_close('�����ڴ��û���');
	}
} else {
	_alert_close('�Ƿ�������');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>���û�����ϵͳ--��Ӻ���</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/message.js"></script>
</head>
<body>


<div id="message">
	<h3>��Ӻ���</h3>
	<form method="post" action="?action=add">
	<input type="hidden" name="touser" value="<?php echo $_html['touser']?>" />
	<dl>
		<dd><input type="text" readonly="readonly" value="TO:<?php echo $_html['touser']?>" class="text" /></dd>
		<dd><textarea name="content">�ҷǳ�����㽻���ѣ�</textarea></dd>
		<dd>�� ֤ �룺<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="��Ӻ���" /></dd>
	</dl>
	</form>
</div>



</body>
</html>