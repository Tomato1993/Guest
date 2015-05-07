<?php
header("Content-Type: text/html; charset=gbk");
session_start();

define('IN_TG',true);

define('SCRIPT','member_modify');

require dirname(__FILE__).'/includes/common.inc.php';

if ($_GET['action'] == 'modify') {
	_check_code($_POST['code'],$_SESSION['code']);
	if (!!$_rows = _fetch_array("SELECT 
																tg_uniqid 
													FROM 
																tg_user 
												 WHERE 
																tg_username='{$_COOKIE['username']}' 
													 LIMIT 
																1"
		)) {
		
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		include ROOT_PATH.'includes/check.func.php';
		$_clean = array();
		$_clean['password'] = _check_modify_password($_POST['password'],6);
		$_clean['sex'] = _check_sex($_POST['sex']);
		$_clean['face'] = _check_face($_POST['face']);
		$_clean['email'] = _check_email($_POST['email'],6,40);
		$_clean['qq'] = _check_qq($_POST['qq']);
		$_clean['url'] = _check_url($_POST['url'],40);
		$_clean['switch'] = $_POST['switch'];
		$_clean['autograph'] = _check_autograph($_POST['autograph'],200);
		
	
		if (empty($_clean['password'])) {
			_query("UPDATE tg_user SET 
																tg_sex='{$_clean['sex']}',
																tg_face='{$_clean['face']}',
																tg_email='{$_clean['email']}',
																tg_qq='{$_clean['qq']}',
																tg_url='{$_clean['url']}',
																tg_switch='{$_clean['switch']}',
																tg_autograph='{$_clean['autograph']}'
													WHERE
																tg_username='{$_COOKIE['username']}' 
																");
		} else {
			_query("UPDATE tg_user SET 
																tg_password='{$_clean['password']}',
																tg_sex='{$_clean['sex']}',
																tg_face='{$_clean['face']}',
																tg_email='{$_clean['email']}',
																tg_qq='{$_clean['qq']}',
																tg_url='{$_clean['url']}',
																tg_switch='{$_clean['switch']}',
																tg_autograph='{$_clean['autograph']}'
													WHERE
																tg_username='{$_COOKIE['username']}' 
																");
		}
	}

	if (_affected_rows() == 1) {
		_close();
		_session_destroy();
		_location('��ϲ�㣬�޸ĳɹ���','member.php');
	} else {
		_close();
		_session_destroy();
		_location('���ź���û���κ����ݱ��޸ģ�','member_modify.php');
	}
}

if (isset($_COOKIE['username'])) {

	$_rows = _fetch_array("SELECT tg_switch,tg_autograph,tg_username,tg_sex,tg_face,tg_email,tg_url,tg_qq FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
	if ($_rows) {
		$_html= array();
		$_html['username'] = $_rows['tg_username'];
		$_html['sex'] = $_rows['tg_sex'];
		$_html['face'] = $_rows['tg_face'];
		$_html['email'] = $_rows['tg_email'];
		$_html['url'] = $_rows['tg_url'];
		$_html['qq'] = $_rows['tg_qq'];
		$_html['switch'] = $_rows['tg_switch'];
		$_html['autograph'] = $_rows['tg_autograph'];
		$_html = _html($_html);
		
		
		if ($_html['sex'] == '��') {
			$_html['sex_html'] = '<input type="radio" name="sex" value="��" checked="checked" /> �� <input type="radio" name="sex" value="Ů" /> Ů';
		} elseif ($_html['sex'] == 'Ů') {
			$_html['sex_html'] = '<input type="radio" name="sex" value="��" /> �� <input type="radio" name="sex" value="Ů" checked="checked" /> Ů';
		}
		
		
		$_html['face_html'] = '<select name="face">';
		foreach (range(1,9) as $_num) {
			$_html['face_html'] .= '<option value="face/m0'.$_num.'.gif">face/m0'.$_num.'.gif</option>';
		}
		foreach (range(10,64) as $_num) {
			$_html['face_html'] .= '<option value="face/m'.$_num.'.gif">face/m'.$_num.'.gif</option>';
		}
		$_html['face_html'] .= '</select>';
		
		
		if ($_html['switch'] == 1) {
			$_html['switch_html'] = '<input type="radio" checked="checked" name="switch" value="1" /> ���� <input type="radio" name="switch" value="0" /> ����';
		} elseif ($_html['switch'] == 0) {
			$_html['switch_html'] = '<input type="radio" name="switch" value="1" /> ���� <input type="radio" name="switch" value="0" checked="checked" /> ����';
		}
		
	} else {
		_alert_back('���û�������');
	}
} else {
	_alert_back('�Ƿ���¼');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>���û�����ϵͳ--��������</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/member_modify.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="member">
<?php 
	require ROOT_PATH.'includes/member.inc.php';
?>
	<div id="member_main">
		<h2>��Ա��������</h2>
		<form method="post" action="?action=modify">
		<dl>
			<dd>�� �� ����<?php echo $_html['username']?></dd>
			<dd>�ܡ����룺<input type="password" class="text" name="password" /> (�������޸�)</dd>
			<dd>�ԡ�����<?php echo $_html['sex_html']?></dd>
			<dd>ͷ������<?php echo $_html['face_html']?></dd>
			<dd>�����ʼ���<input type="text" class="text" name="email" value="<?php echo $_html['email']?>" /></dd>
			<dd>������ҳ��<input type="text" class="text" name="url" value="<?php echo $_html['url']?>" /></dd>
			<dd>Q �� ��Q��<input type="text" class="text" name="qq" value="<?php echo $_html['qq']?>" /></dd>
			<dd>����ǩ����<?php echo $_html['switch_html']?> (����ʹ��UBB����)
					<p><textarea name="autograph"><?php echo $_html['autograph']?></textarea></p>
			</dd>
			<dd>�� ֤ �룺<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="�޸�����" /></dd>
		</dl>
		</form>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
