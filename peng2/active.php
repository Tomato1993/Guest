<?php
define('IN_TG',true);
define('SCRIPT','active');
require dirname(__FILE__).'/includes/common.inc.php';
if (!isset($_GET['active'])) {
	_alert_back('�Ƿ�����');
}
if (isset($_GET['action']) && isset($_GET['active']) && $_GET['action'] == 'ok') {
	$_active = _mysql_string($_GET['active']);
	if (_fetch_array("SELECT tg_active FROM tg_user WHERE tg_active='$_active' LIMIT 1")) {
		_query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
		if (_affected_rows() == 1) {
			_close();
			_location('�˻�����ɹ�','login.php');
		} else {
			_close();
			_location('�˻�����ʧ��','register.php');
		}
	} else {
		_alert_back('�Ƿ�����');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title>���û�����ϵͳ--����</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="active">
	<h2>�����˻�</h2>
	<p>��ҳ����Ϊ��ģ�������ʼ��Ĺ��ܣ�������³������Ӽ��������˻�</p>
	<p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active']?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>active.php?action=ok&amp;active=<?php echo $_GET['active']?></a></p>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

