<?php
header("Content-Type: text/html; charset=gbk");
session_start();
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','flower');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//�ж��Ƿ��¼��
if (!isset($_COOKIE['username'])) {
	_alert_close('���ȵ�¼��');
}
//�ͻ�
if ($_GET['action'] == 'send') {
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
		include ROOT_PATH.'includes/check.func.php';
		$_clean = array();
		$_clean['touser'] = $_POST['touser'];
		$_clean['fromuser'] = $_COOKIE['username'];
		$_clean['flower'] = $_POST['flower'];
		$_clean['content'] = _check_content($_POST['content']);
		$_clean = _mysql_string($_clean);
		//д���
		_query("INSERT INTO tg_flower (
																		tg_touser,
																		tg_fromuser,
																		tg_flower,
																		tg_content,
																		tg_date
																	)
												    	VALUES (
													 					'{$_clean['touser']}',
													 					'{$_clean['fromuser']}',
													 					'{$_clean['flower']}',
													 					'{$_clean['content']}',
													 					NOW()
													 				)
		");
		//�����ɹ�
		if (_affected_rows() == 1) {
			_close();
			_session_destroy();
			_alert_close('�ͻ��ɹ�');
		} else {
			_close();
			_session_destroy();
			_alert_back('�ͻ�ʧ��');
		}
	} else {
		_alert_close('�Ƿ���¼��');
	}
}
//��ȡ����
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1")) {
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
<title>���û�����ϵͳ--�ͻ�</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/message.js"></script>
</head>
<body>


<div id="message">
	<h3>�ͻ�</h3>
	<form method="post" action="?action=send">
	<input type="hidden" name="touser" value="<?php echo $_html['touser']?>" />
	<dl>
		<dd>
			<input type="text" readonly="readonly" value="TO:<?php echo $_html['touser']?>" class="text" />
			<select name="flower">
				<?php 
					foreach (range(1,100) as $_num) {
						echo '<option value="'.$_num.'"> x'.$_num.'��</option>';
					}
				?>
			</select>
		</dd>
		<dd><textarea name="content">�ҳ������㣬���㻨��~~~</textarea></dd>
		<dd>�� ֤ �룺<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="�ͻ�" /></dd>
	</dl>
	</form>
</div>



</body>
</html>