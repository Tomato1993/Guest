<?php
header("Content-Type: text/html; charset=gbk");
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','q');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//��ʼ��
if (isset($_GET['num']) && isset($_GET['path'])) {
	if (!is_dir(ROOT_PATH.$_GET['path'])) {
		_alert_back('�Ƿ�����');
	}
	
} else {
	_alert_back('�Ƿ�����');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>���û�����ϵͳ--Qͼѡ��</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/qopener.js"></script>
</head>
<body>

<div id="q">
	<h3>ѡ��Qͼ</h3>
	<dl>
		<?php foreach (range(1,$_GET['num']) as $_num) {?>
		<dd><img src="<?php echo $_GET['path'].$_num?>.gif" alt="<?php echo $_GET['path'].$_num?>.gif" title="ͷ��<?php echo $_num?>" /></dd>
		<?php }?>
		
	</dl>
</div>







</body>
</html>
