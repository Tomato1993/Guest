<?php
header("Content-Type: text/html; charset=gbk");
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','member_message_detail');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//�ж��Ƿ��¼��
if (!isset($_COOKIE['username'])) {
	_alert_back('���ȵ�¼��');
}
//ɾ������ģ��
if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
	//������֤�����Ƿ�Ϸ�
	if (!!$_rows = _fetch_array("SELECT 
															tg_id
												FROM 
															tg_message 
											 WHERE 
															tg_id='{$_GET['id']}' 
												 LIMIT 
															1
										")) {
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
				//ɾ��������
				_query("DELETE FROM 
														tg_message 
										WHERE 
														tg_id='{$_GET['id']}' 
											LIMIT 
														1
				");
				if (_affected_rows() == 1) {
					_close();
					_location('����ɾ���ɹ�','member_message.php');
				} else {
					_close();
					_alert_back('����ɾ��ʧ��');
				}
			} else {
				_alert_back('�Ƿ���¼');
			}	
		} else {
			_alert_back('�˶��Ų����ڣ�');
		}
}
//����id
if (isset($_GET['id'])) {
	$_rows = _fetch_array("SELECT 
															tg_id,tg_state,tg_fromuser,tg_content,tg_date
												FROM 
															tg_message 
											 WHERE 
															tg_id='{$_GET['id']}' 
												 LIMIT 
															1
										");
	if ($_rows) {
		//����state״̬����Ϊ1����
		if (empty($_rows['tg_state'])) {
			_query("UPDATE 
											tg_message 
								 SET 
											tg_state=1 
							WHERE 
											tg_id='{$_GET['id']}' 
								LIMIT 
											1
		");
			if (!_affected_rows()) {
				_alert_back('�쳣��');
			}
		}
		$_html= array();
		$_html['id']= $_rows['tg_id'];
		$_html['fromuser'] = $_rows['tg_fromuser'];
		$_html['content'] = $_rows['tg_content'];
		$_html['date'] = $_rows['tg_date'];
		$_html = _html($_html);
	} else {
		_alert_back('�˶��Ų����ڣ�');
	}
} else {
	_alert_back('�Ƿ���¼');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>���û�����ϵͳ--�����б�</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/member_message_detail.js"></script>
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
		<h2>��������</h2>
		<dl>
			<dd>�� �� �ˣ�<?php echo $_html['fromuser']?></dd>
			<dd>�ڡ����ݣ�<strong><?php echo $_html['content']?></strong></dd>
			<dd>����ʱ�䣺<?php echo $_html['date']?></dd>
			<dd class="button"><input type="button"  value="�����б�" id="return" /> <input type="button" id="delete" name="<?php echo $_html['id']?>" value="ɾ������" /></dd>
		</dl>
	</div>
</div>		
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>