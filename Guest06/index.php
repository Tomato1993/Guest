<?php
header("Content-Type: text/html; charset=gbk");
define('IN_TG',true);
define('SCRIPT','index');
require dirname(__FILE__).'/includes/common.inc.php'; //ת����Ӳ·�����ٶȸ���
$_html = _html(_get_xml('new.xml'));
global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_article",10); 
$_result = _query("SELECT 
												tg_id,tg_title,tg_type,tg_readcount,tg_commendcount 
									FROM 
												tg_article 
									WHERE 
												tg_reid=0
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
<title>���û�����ϵͳ--��ҳ</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>

<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="list">
	<h2>�����б�</h2>
	<a href="post.php" class="post">��������</a>
	<ul class="article">
		<?php
			$_htmllist = array();
			while (!!$_rows = _fetch_array_list($_result)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['type'] = $_rows['tg_type'];
				$_htmllist['readcount'] = $_rows['tg_readcount'];
				$_htmllist['commendcount'] = $_rows['tg_commendcount'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist = _html($_htmllist);
				echo '<li class="icon'.$_htmllist['type'].'"><em>�Ķ���(<strong>'.$_htmllist['readcount'].'</strong>) ������(<strong>'.$_htmllist['commendcount'].'</strong>)</em> <a href="article.php?id='.$_htmllist['id'].'">'._title($_htmllist['title'],20).'</a></li>';
			}
			_free_result($_result);
		?>
	</ul>
	<?php _paging(2);?>
</div>

<div id="user">
	<h2>�½���Ա</h2>
	<dl>
		<dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex']?>)</dd>
		<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username']?>" /></dt>
		<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['id']?>">����Ϣ</a></dd>
		<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['id']?>">��Ϊ����</a></dd>
		<dd class="guest">д����</dd>
		<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['id']?>">�����ͻ�</a></dd>
		<dd class="email">�ʼ���<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
		<dd class="url">��ַ��<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
	</dl>
</div>

<div id="pics">
	<h2>����ͼƬ</h2>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
