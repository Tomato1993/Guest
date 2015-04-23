<?php
header('Content-Type: text/html; charset=gbk');
session_start();
define('IN_TG',true);
define('SCRIPT','login');
require dirname(__FILE__).'/includes/common.inc.php';
_login_state();
if (@$_GET['action'] == 'login') {
	_check_code($_POST['code'],$_SESSION['code']);
	include ROOT_PATH.'includes/login.func.php';
	$_clean = array();
	$_clean['username'] = _check_username($_POST['username'],2,20);
	$_clean['password'] = _check_password($_POST['password'],6);
	$_clean['time'] = _check_time($_POST['time']);
	if (!!$_rows = _fetch_array("SELECT tg_username,tg_uniqid FROM tg_user WHERE tg_username='{$_clean['username']}' AND tg_password='{$_clean['password']}' AND tg_active='' LIMIT 1")) {
		_close();
		_session_destroy();
		_setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clean['time']);
		_location(null,'index.php');
	} else {
		_close();
		_session_destroy();
		_location('用户名密码不正确或者该账户未被激活！','login.php');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title>多用户留言系统--登录</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="login">
	<h2>登录</h2>
	<form method="post" name="login" action="login.php?action=login">
		<dl>
			<dt></dt>
			<dd>用 户 名：<input type="text" name="username" class="text" /></dd>
			<dd>密　　码：<input type="password" name="password" class="text" /></dd>
			<dd>保　　留：<input type="radio" name="time" value="0" checked="checked" /> 不保留 <input type="radio" name="time" value="1" /> 一天 <input type="radio" name="time" value="2" /> 一周 <input type="radio" name="time" value="3" /> 一月</dd>
			
			<dd><input type="submit" value="登录" class="button" /> <input type="button" value="注册" id="location" class="button location" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

