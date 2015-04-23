<?php
session_start();
define('IN_TG',true);
define('SCRIPT','register');
require dirname(__FILE__).'/includes/common.inc.php';
_login_state();
if (@$_GET['action'] == 'register') {
	_check_code($_POST['code'],$_SESSION['code']);
	include ROOT_PATH.'includes/register.func.php';
	$_clean = array();
	$_clean['uniqid'] = _check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
	$_clean['active'] = _sha1_uniqid();
	$_clean['username'] = _check_username($_POST['username'],2,20);
	$_clean['password'] = _check_password($_POST['password'],$_POST['notpassword'],6);
	$_clean['question'] = _check_question($_POST['question'],2,20);
	$_clean['answer'] = _check_answer($_POST['question'],$_POST['answer'],2,20);
	$_clean['sex'] = _check_sex($_POST['sex']);
	$_clean['face'] = _check_face($_POST['face']);
	$_clean['email'] = _check_email($_POST['email'],6,40);
	$_clean['qq'] = _check_qq($_POST['qq']);
	$_clean['url'] = _check_url($_POST['url'],40);
	_is_repeat(
				"SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}' LIMIT 1",
				'�Բ��𣬴��û��ѱ�ע��'
	);
	
	_query(
						"INSERT INTO tg_user (
																tg_uniqid,
																tg_active,
																tg_username,
																tg_password,
																tg_question,
																tg_answer,
																tg_sex,
																tg_face,
																tg_email,
																tg_qq,
																tg_url,
																tg_reg_time,
																tg_last_time,
																tg_last_ip
																) 
												VALUES (
																'{$_clean['uniqid']}',
																'{$_clean['active']}',
																'{$_clean['username']}',
																'{$_clean['password']}',
																'{$_clean['question']}',
																'{$_clean['answer']}',
																'{$_clean['sex']}',
																'{$_clean['face']}',
																'{$_clean['email']}',
																'{$_clean['qq']}',
																'{$_clean['url']}',
																NOW(),
																NOW(),
																'{$_SERVER["REMOTE_ADDR"]}'
																)"
	);
	if (_affected_rows() == 1) {
		_close();
		_session_destroy();
		_location('��ϲ�㣬ע��ɹ���','active.php?active='.$_clean['active']);
	} else {
		_close();
		_session_destroy();
		_location('���ź���ע��ʧ�ܣ�','register.php');
	}
} else {
	$_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title>���û�����ϵͳ--ע��</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="register">
	<h2>��Աע��</h2>
	<form method="post" name="register" action="register.php?action=register">
		<input type="hidden" name="uniqid" value="<?php echo $_uniqid ?>" />
		<dl>
			<dt>��������дһ������</dt>
			<dd>�� �� ����<input type="text" name="username" class="text" /> (*���������λ)</dd>
			<dd>�ܡ����룺<input type="password" name="password" class="text" /> (*���������λ)</dd>
			<dd>ȷ�����룺<input type="password" name="notpassword" class="text" /> (*���ͬ��)</dd>
			<dd>������ʾ��<input type="text" name="question" class="text" /> (*���������λ)</dd>
			<dd>����ش�<input type="text" name="answer" class="text" /> (*���������λ)</dd>
			<dd>�ԡ�����<input type="radio" name="sex" value="��" checked="checked" />�� <input type="radio" name="sex" value="Ů" />Ů</dd>
			<dd class="face"><input type="hidden" name="face" value="face/m01.gif" /><img src="face/m01.gif" alt="ͷ��ѡ��" id="faceimg" /></dd>
			<dd>�����ʼ���<input type="text" name="email" class="text" /> (*��������˻�)</dd>
			<dd>��Q Q ����<input type="text" name="qq" class="text" /></dd>
			<dd>��ҳ��ַ��<input type="text" name="url" class="text" value="http://" /></dd>
			<dd><input type="submit" class="submit" value="ע��" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
