<?php
header("Content-Type: text/html; charset=gbk");
session_start();
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','post');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//��½��ſ��Է���
if (!isset($_COOKIE['username'])) {
	_location('����ǰ�������¼','login.php');
}
//������д�����ݿ�
if ($_GET['action'] == 'post') {
	_check_code($_POST['code'],$_SESSION['code']); //��֤���ж�
	if (!!$_rows = _fetch_array("SELECT 
																tg_uniqid 
													FROM 
																tg_user 
												 WHERE 
																tg_username='{$_COOKIE['username']}' 
													 LIMIT 
																1"
		)) {
		//Ϊ�˷�ֹcookiesα�죬��Ҫ�ȶ�һ��Ψһ��ʶ��uniqid()
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		include ROOT_PATH.'includes/check.func.php';
		//������������
		$_clean = array();
		$_clean['username'] = $_COOKIE['username'];
		$_clean['type'] = $_POST['type'];
		$_clean['title'] = _check_post_title($_POST['title'],2,40);
		$_clean['content'] = _check_post_content($_POST['content'],10);
		$_clean = _mysql_string($_clean);
		//д�����ݿ�
		_query("INSERT INTO tg_article (
																tg_username,
																tg_title,
																tg_type,
																tg_content,
																tg_date
															) 
											VALUES (
																'{$_clean['username']}',
																'{$_clean['title']}',
																'{$_clean['type']}',
																'{$_clean['content']}',
																NOW()
															)
		");
		if (_affected_rows() == 1) {
			$_clean['id'] = _insert_id();
			_close();
			_session_destroy();
			_location('���ӷ���ɹ���','article.php?id='.$_clean['id']);
		} else {
			_close();
			_session_destroy();
			_alert_back('���ӷ���ʧ�ܣ�');
		}
	}
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
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/post.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="post">
	<h2>��������</h2>
	<form method="post" name="post" action="?action=post">
		<dl>
			<dt>��������дһ������</dt>
			<dd>
				�ࡡ���ͣ�
				<?php 
					foreach (range(1,16) as $_num) {
						if ($_num == 1) {
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
			<dd>�ꡡ���⣺<input type="text" name="title" class="text" /> (*���2-40λ)</dd>
			<dd id="q">������ͼ����<a href="javascript:;">Qͼϵ��[1]</a>�� <a href="javascript:;">Qͼϵ��[2]</a>�� <a href="javascript:;">Qͼϵ��[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php'?>
				<textarea name="content" rows="9"></textarea>
			</dd>
			<dd>�� ֤ �룺<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="��������" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>