<?php
header("Content-Type: text/html; charset=gbk");
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','member_flower');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//�ж��Ƿ��¼��
if (!isset($_COOKIE['username'])) {
	_alert_back('���ȵ�¼��');
}
//��ɾ������
if ($_GET['action'] == 'delete' && isset($_POST['ids'])) {
	$_clean = array();
	$_clean['ids'] = _mysql_string(implode(',',$_POST['ids']));
	//Σ�ղ�����Ϊ�˷�ֹcookiesα�죬��Ҫ�ȶ�һ��Ψһ��ʶ��uniqid()
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
		_query("DELETE FROM 
												tg_flower 
								  WHERE 
												tg_id 
											IN 
												({$_clean['ids']})"
		);
		if (_affected_rows()) {
			_close();
			_location('����ɾ���ɹ�','member_flower.php');
		} else {
			_close();
			_alert_back('����ɾ��ʧ��');
		}
	} else {
		_alert_back('�Ƿ���¼');
	}
}
//��ҳģ��
global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_flower WHERE tg_touser='{$_COOKIE['username']}'",15);   //��һ��������ȡ���������ڶ���������ָ��ÿҳ������
$_result = _query("SELECT 
												tg_id,tg_fromuser,tg_flower,tg_content,tg_date 
									FROM 
												tg_flower 
								 WHERE 
								 				tg_touser='{$_COOKIE['username']}'
							ORDER BY 
												tg_date DESC 
									 LIMIT 
												$_pagenum,$_pagesize
							");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>���û�����ϵͳ--�����б�</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/member_message.js"></script>
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
		<h2>�����������</h2>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>�ͻ���</th><th>������Ŀ</th><th>����</th><th>ʱ��</th><th>����</th></tr>
			<?php 
				$_html = array();
				while (!!$_rows = _fetch_array_list($_result)) {
					$_html['id'] = $_rows['tg_id'];
					$_html['fromuser'] = $_rows['tg_fromuser'];
					$_html['content'] = $_rows['tg_content'];
					$_html['flower'] = $_rows['tg_flower'];
					$_html['date'] = $_rows['tg_date'];
					$_html = _html($_html);
					$_html['count'] += $_html['flower'];
			?>
			<tr><td><?php echo $_html['fromuser']?></td><td><img src="images/x4.gif" alt="����" /> x <?php echo $_html['flower']?>��</td><td><?php echo _title($_html['content'])?></td><td><?php echo $_html['date']?></td><td><input name="ids[]" value="<?php echo $_html['id']?>" type="checkbox" /></td></tr>
			<?php 
				}
				_free_result($_result);
			?>
			<tr><td colspan="5">��<strong><?php echo $_html['count']?></strong>�仨</td></tr>
			<tr><td colspan="5"><label for="all">ȫѡ <input type="checkbox" name="chkall" id="all" /></label> <input type="submit" value="��ɾ��" /></td></tr>
		</table>
		</form>
		<?php _paging(2);?>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>