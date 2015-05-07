<?php
header("Content-Type: text/html; charset=gbk");
session_start();
define('IN_TG',true);
define('SCRIPT','article_modify');
require dirname(__FILE__).'/includes/common.inc.php';
if (!isset($_COOKIE['username'])) {
	_location('����ǰ�������¼','login.php');
}
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
		
		//��ʼ�޸�
		include ROOT_PATH.'includes/check.func.php';
		$_clean = array();
		$_clean['id'] = $_POST['id'];
		$_clean['type'] = $_POST['type'];
		$_clean['title'] = _check_post_title($_POST['title'],2,40);
		$_clean['content'] = _check_post_content($_POST['content'],10);
		$_clean = _mysql_string($_clean);
		
		_query("UPDATE tg_article SET 
																tg_type='{$_clean['type']}',
																tg_title='{$_clean['title']}',
																tg_content='{$_clean['content']}',
																tg_last_modify_date=NOW()
													WHERE
																tg_id='{$_clean['id']}'
		");
		if (_affected_rows() == 1) {
			_close();
			_session_destroy();
			_location('�����޸ĳɹ���','article.php?id='.$_clean['id']);
		} else {
			_close();
			_session_destroy();
			_alert_back('�����޸�ʧ�ܣ�');
		}
	} else {
		_alert_back('�Ƿ���¼��');
	}
}
//��ȡ����
if (isset($_GET['id'])) {
		if (!!$_rows = _fetch_array("SELECT 
																	tg_username,
																	tg_title,
																	tg_type,
																	tg_content
													  FROM 
																	tg_article 
													WHERE
																	tg_reid=0
															AND
																	tg_id='{$_GET['id']}'")) {
			$_html = array();
			$_html['id'] = $_GET['id'];
			$_html['username'] = $_rows['tg_username'];
			$_html['title'] = $_rows['tg_title'];
			$_html['type'] = $_rows['tg_type'];
			$_html['content'] = $_rows['tg_content'];
			$_html = _html($_html);		

			//�ж�Ȩ��
			if ($_COOKIE['username'] != $_html['username']) {
				_alert_back('��û��Ȩ���޸ģ�');
			}
			
		} else {
			_alert_back('�����ڴ����ӣ�');
		}
} else {
	_alert_back('�Ƿ�������');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>���û�����ϵͳ--�޸�����</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/post.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="post">
	<h2>�޸�����</h2>
	<form method="post" name="post" action="?action=modify">
		<input type="hidden" value="<?php echo $_html['id']?>" name="id" />
		<dl>
			<dt>�������޸���������</dt>
			<dd>
				�ࡡ���ͣ�
				<?php 
					foreach (range(1,16) as $_num) {
						if ($_num == $_html['type']) {
							echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" checked="checked" /> ';
						} else {
							echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" /> ';
						}
						echo ' <img src="images/icon'.$_num.'.gif" alt="����" /></label>';
						if ($_num == 8) {
							echo '<br />������ ����';
						}
					}
				?>
			</dd>
			<dd>�ꡡ���⣺<input type="text" name="title" value="<?php echo $_html['title']?>" class="text" /> (*���2-40λ)</dd>
			<dd id="q">������ͼ����<a href="javascript:;">Qͼϵ��[1]</a>�� <a href="javascript:;">Qͼϵ��[2]</a>�� <a href="javascript:;">Qͼϵ��[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php'?>
				<textarea name="content" rows="9"><?php echo $_html['content']?></textarea>
			</dd>
			<dd>�� ֤ �룺<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="�޸�����" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>