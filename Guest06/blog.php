<?php
header("Content-Type: text/html; charset=gbk");
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','blog');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//��ҳģ��
global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_user",15);   //��һ��������ȡ���������ڶ���������ָ��ÿҳ������

$_result = _query("SELECT 
												tg_id,tg_username,tg_sex,tg_face 
									FROM 
												tg_user 
							ORDER BY 
												tg_reg_time DESC 
									 LIMIT 
												$_pagenum,$_pagesize
							");							
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>���û�����ϵͳ--����</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="blog">
	<h2>�����б�</h2>
	<?php 
		$_html = array();
		while (!!$_rows = _fetch_array_list($_result)) {
			$_html['id'] = $_rows['tg_id'];
			$_html['username'] = $_rows['tg_username'];
			$_html['face'] = $_rows['tg_face'];
			$_html['sex'] = $_rows['tg_sex'];
			$_html = _html($_html);
	?>
	<dl>
		<dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex']?>)</dd>
		<dt><img src="<?php echo $_html['face']?>" alt="����" /></dt>
		<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['id']?>">����Ϣ</a></dd>
		<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['id']?>">��Ϊ����</a></dd>
		<dd class="guest">д����</dd>
		<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['id']?>">�����ͻ�</a></dd>
	</dl>
	<?php }
		_free_result($_result);
		//_pageing�������÷�ҳ��1|2��1��ʾ���ַ�ҳ��2��ʾ�ı���ҳ
		_paging(1);
	?>


</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
