<?php
define('IN_TG',true);
define('SCRIPT','index');
require dirname(__FILE__).'/includes/common.inc.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title>多用户留言系统--首页</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>

<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="list">
	<h2>帖子列表</h2>
</div>

<div id="user">
	<h2>新进会员</h2>
</div>

<div id="pics">
	<h2>最新图片</h2>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
