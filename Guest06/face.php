<?php
header("Content-Type: text/html; charset=gbk");
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','face');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>���û�����ϵͳ--ͷ��ѡ��</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/opener.js"></script>
</head>
<body>

<div id="face">
	<h3>ѡ��ͷ��</h3>
	<dl>
		<?php foreach (range(1,9) as $num) {?>
		<dd><img src="face/m0<?php echo $num?>.gif" alt="face/m0<?php echo $num?>.gif" title="ͷ��<?php echo $num?>" /></dd>
		<?php }?>
		
	</dl>
	<dl>
		<?php foreach (range(10,64) as $num) {?>
		<dd><img src="face/m<?php echo $num?>.gif" alt="face/m<?php echo $num?>.gif" title="ͷ��<?php echo $num?>" /></dd>
		<?php }?>
		
	</dl>
</div>







</body>
</html>
