<?php
header("Content-Type: text/html; charset=gbk");
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','member');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//�Ƿ�������¼
if (isset($_COOKIE['username'])) {
	//��ȡ����
	$_rows = _fetch_array("SELECT 
															tg_username,tg_sex,tg_face,tg_email,tg_url,tg_qq,tg_level,tg_reg_time 
												FROM 
															tg_user 
											 WHERE 
															tg_username='{$_COOKIE['username']}' 
												 LIMIT 
															1
										");
	if ($_rows) {
		$_html= array();
		$_html['username'] = $_rows['tg_username'];
		$_html['sex'] = $_rows['tg_sex'];
		$_html['face'] = $_rows['tg_face'];
		$_html['email'] = $_rows['tg_email'];
		$_html['url'] = $_rows['tg_url'];
		$_html['qq'] = $_rows['tg_qq'];
		$_html['reg_time'] = $_rows['tg_reg_time'];
		switch ($_rows['tg_level']) {
			case 0:
				$_html['level'] = '��ͨ��Ա';
				break;
			case 1:
				$_html['level'] = '����Ա';
				break;
			default:
				$_html['level'] = '����';
		}
		$_html = _html($_html);
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
		<dl>
			<dd>�� �� ����<?php echo $_html['username']?></dd>
			<dd>�ԡ�����<?php echo $_html['sex']?></dd>
			<dd>ͷ������<?php echo $_html['face']?></dd>
			<dd>�����ʼ���<?php echo $_html['email']?></dd>
			<dd>������ҳ��<?php echo $_html['url']?></dd>
			<dd>Q �� ��Q��<?php echo $_html['qq']?></dd>
			<dd>ע��ʱ�䣺<?php echo $_html['reg_time']?></dd>
			<dd>�����ݣ�<?php echo $_html['level']?></dd>
		</dl>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
