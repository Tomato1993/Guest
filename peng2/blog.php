<?php
define('IN_TG',true);
define('SCRIPT','blog');
require dirname(__FILE__).'/includes/common.inc.php';
global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_user",10);  
$_result = _query("SELECT tg_username,tg_sex,tg_face FROM tg_user ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>���û�����ϵͳ--����</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="blog">
	<h2>�����б�</h2>
	<?php while (!!$_rows = _fetch_array_list($_result)) {?>
	<dl>
		<dd class="user"><?php echo $_rows['tg_username']?>(<?php echo $_rows['tg_sex']?>)</dd>
		<dt><img src="<?php echo $_rows['tg_face']?>" alt="����" /></dt>
		<dd class="message">����Ϣ</dd>
		<dd class="friend">��Ϊ����</dd>
		<dd class="guest">д����</dd>
		<dd class="flower">��������</dd>
	</dl>
	<?php }
		_paging(1);
	?>


</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
