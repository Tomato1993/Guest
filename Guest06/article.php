<?php
header("Content-Type: text/html; charset=gbk");
session_start();
define('IN_TG',true);
define('SCRIPT','article');
require dirname(__FILE__).'/includes/common.inc.php';	
if ($_GET['action'] == 'rearticle') {
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
			
			$_clean = array();
			$_clean['reid'] = $_POST['reid'];
			$_clean['type'] = $_POST['type'];
			$_clean['title'] = $_POST['title'];
			$_clean['content'] = $_POST['content'];
			$_clean['username'] = $_COOKIE['username'];
			$_clean = _mysql_string($_clean);
			
			_query("INSERT INTO tg_article (
																	tg_reid,
																	tg_username,
																	tg_title,
																	tg_type,
																	tg_content,
																	tg_date
																)
												 VALUES (
												 					'{$_clean['reid']}',
												 					'{$_clean['username']}',
												 					'{$_clean['title']}',
												 					'{$_clean['type']}',
												 					'{$_clean['content']}',
												 					NOW()
												 				)"
			);
			if (_affected_rows() == 1) {
				_query("UPDATE tg_article SET tg_commendcount=tg_commendcount+1 WHERE tg_reid=0 AND tg_id='{$_clean['reid']}'");
				_close();
				_session_destroy();
				_location('�����ɹ���','article.php?id='.$_clean['reid']);
			} else {
				_close();
				_session_destroy();
				_alert_back('����ʧ�ܣ�');
			}
	} else {
		_alert_back('�Ƿ���¼��');
	}
}
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,
																	tg_username,
																	tg_title,
																	tg_type,
																	tg_content,
																	tg_readcount,
																	tg_commendcount,
																	tg_last_modify_date,
																	tg_date 
													  FROM 
																	tg_article 
													WHERE
																	tg_reid=0
															AND
																	tg_id='{$_GET['id']}'")) {
	
		//�ۻ��Ķ���
		_query("UPDATE tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
	
		$_html = array();
		$_html['reid'] = $_rows['tg_id'];
		$_html['username_subject'] = $_rows['tg_username'];
		$_html['title'] = $_rows['tg_title'];
		$_html['type'] = $_rows['tg_type'];
		$_html['content'] = $_rows['tg_content'];
		$_html['readcount'] = $_rows['tg_readcount'];
		$_html['commendcount'] = $_rows['tg_commendcount'];
		$_html['last_modify_date'] = $_rows['tg_last_modify_date'];
		$_html['date'] = $_rows['tg_date'];
		
		
		
		if (!!$_rows = _fetch_array("SELECT 
																		tg_id,
																		tg_sex,
																		tg_face,
																		tg_email,
																		tg_url,
																		tg_switch,
																		tg_autograph
														  FROM 
														  				tg_user 
														WHERE 
																		tg_username='{$_html['username_subject']}'")) {
			//��ȡ�û���Ϣ
			$_html['userid'] = $_rows['tg_id'];
			$_html['sex'] = $_rows['tg_sex'];
			$_html['face'] = $_rows['tg_face'];
			$_html['email'] = $_rows['tg_email'];
			$_html['url'] = $_rows['tg_url'];
			$_html['switch'] = $_rows['tg_switch'];
			$_html['autograph'] = $_rows['tg_autograph'];
			$_html = _html($_html);
			
			
			
			global $_id;
			$_id = 'id='.$_html['reid'].'&';
			
			//���������޸�
			if ($_html['username_subject'] == $_COOKIE['username']) {
				$_html['subject_modify'] = '[<a href="article_modify.php?id='.$_html['reid'].'">�޸�</a>]';
			}
			
			//��ȡ����޸���Ϣ
			if ($_html['last_modify_date'] != '0000-00-00 00:00:00') {
				$_html['last_modify_date_string'] = '��������['.$_html['username_subject'].']��'.$_html['last_modify_date'].'�޸Ĺ���';
			}
			
			//��¥���ظ�
			if ($_COOKIE['username']) {
				$_html['re'] = '<span>[<a href="#ree" name="re" title="�ظ�1¥��'.$_html['username_subject'].'">�ظ�</a>]</span>';
			}
			
			//����ǩ��
			if ($_html['switch'] == 1) {
				$_html['autograph_html'] = '<p class="autograph">'._ubb($_html['autograph']).'</p>';
			}
			
			
			//��ȡ����
			global $_pagesize,$_pagenum,$_page;
			_page("SELECT tg_id FROM tg_article WHERE tg_reid='{$_html['reid']}'",10); 
			$_result = _query("SELECT 
												tg_username,tg_type,tg_title,tg_content,tg_date 
									FROM 
												tg_article 
									WHERE
												tg_reid='{$_html['reid']}'
							ORDER BY 
												tg_date ASC 
									 LIMIT 
												$_pagenum,$_pagesize
			");	
												
			
												
		} else {
			//����û��ѱ�ɾ��
		}
	} else {
		_alert_back('������������⣡');
	}
} else {
	_alert_back('�Ƿ�������');
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
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="article">
	<h2>��������</h2>
	
	<?php 
		if ($_page == 1) {
	?>
	<div id="subject">
		<dl>
			<dd class="user"><?php echo $_html['username_subject']?>(<?php echo $_html['sex']?>)[¥��]</dd>
			<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username_subject']?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid']?>">����Ϣ</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid']?>">��Ϊ����</a></dd>
			<dd class="guest">д����</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid']?>">�����ͻ�</a></dd>
			<dd class="email">�ʼ���<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
			<dd class="url">��ַ��<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php echo $_html['subject_modify']?> 1#</span><?php echo $_html['username_subject']?> | �����ڣ�<?php echo $_html['date']?>
			</div>
			<h3>���⣺<?php echo $_html['title']?> <img src="images/icon<?php echo $_html['type']?>.gif" alt="icon" /> <?php echo $_html['re']?></h3>
			<div class="detail">
				<?php echo _ubb($_html['content'])?>
				<?php echo $_html['autograph_html']?>
			</div>
			<div class="read">
				<p><?php echo $_html['last_modify_date_string']?></p>
				�Ķ�����(<?php echo $_html['readcount']?>) ��������(<?php echo $_html['commendcount']?>)
			</div>
		</div>
	</div>
	<?php }?>
	
	
	<p class="line"></p>
	
	<?php 
		$_i = 2;
		while (!!$_rows = _fetch_array_list($_result)) {
			$_html['username'] = $_rows['tg_username'];
			$_html['type'] = $_rows['tg_type'];
			$_html['retitle'] = $_rows['tg_title'];
			$_html['content'] = $_rows['tg_content'];
			$_html['date'] = $_rows['tg_date'];
			$_html = _html($_html);
			

			
			if (!!$_rows = _fetch_array("SELECT 
																			tg_id,
																			tg_sex,
																			tg_face,
																			tg_email,
																			tg_url,
																			tg_switch,
																			tg_autograph
															  FROM 
															  				tg_user 
															WHERE 
																			tg_username='{$_html['username']}'")) {
				//��ȡ�û���Ϣ
				$_html['userid'] = $_rows['tg_id'];
				$_html['sex'] = $_rows['tg_sex'];
				$_html['face'] = $_rows['tg_face'];
				$_html['email'] = $_rows['tg_email'];
				$_html['url'] = $_rows['tg_url'];
				$_html['switch'] = $_rows['tg_switch'];
				$_html['autograph'] = $_rows['tg_autograph'];
				$_html = _html($_html);
				
				//¥��
				if ($_page == 1 && $_i == 2) {
					if ($_html['username'] == $_html['username_subject']) {
						$_html['username_html'] = $_html['username'].'(¥��)';
					} else {
						$_html['username_html'] = $_html['username'].'(ɳ��)';
					}
				} else {
					$_html['username_html'] = $_html['username'];
				}
				
			} else {
				//����û������Ѿ���ɾ����
			}
			
			//�����ظ�
			if ($_COOKIE['username']) {
				$_html['re'] = '<span>[<a href="#ree" name="re" title="�ظ�'.($_i + (($_page-1) * $_pagesize)).'¥��'.$_html['username'].'">�ظ�</a>]</span>';
			}
	?>
	<div class="re">
		<dl>
			<dd class="user"><?php echo $_html['username_html']?>(<?php echo $_html['sex']?>)</dd>
			<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username']?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid']?>">����Ϣ</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid']?>">��Ϊ����</a></dd>
			<dd class="guest">д����</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid']?>">�����ͻ�</a></dd>
			<dd class="email">�ʼ���<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
			<dd class="url">��ַ��<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php echo $_i + (($_page-1) * $_pagesize);?>#</span><?php echo $_html['username']?> | �����ڣ�<?php echo $_html['date']?>
			</div>
			<h3>���⣺<?php echo $_html['retitle']?> <img src="images/icon<?php echo $_html['type']?>.gif" alt="icon" /> <?php echo $_html['re']?></h3>
			<div class="detail">
				<?php echo _ubb($_html['content'])?>
				<?php 
					if ($_html['switch'] == 1) {
					echo '<p class="autograph">'._ubb($_html['autograph']).'</p>';
					}
				?>
			</div>
		</div>
	</div>
	<p class="line"></p>
	<?php 
			$_i ++;		
		}
		_free_result($_result);
		_paging(1);
	?>
	
	<?php if (isset($_COOKIE['username'])) {?>
	<a name="ree"></a>
	<form method="post" action="?action=rearticle">
		<input type="hidden" name="reid" value="<?php echo $_html['reid']?>" />
		<input type="hidden" name="type" value="<?php echo $_html['type']?>" />
		<dl>
			<dd>�ꡡ���⣺<input type="text" name="title" class="text" value="RE:<?php echo $_html['title']?>" /> (*���2-40λ)</dd>
			<dd id="q">������ͼ����<a href="javascript:;">Qͼϵ��[1]</a>�� <a href="javascript:;">Qͼϵ��[2]</a>�� <a href="javascript:;">Qͼϵ��[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php'?>
				<textarea name="content" rows="9"></textarea>
			</dd>
			<dd>�� ֤ �룺<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="��������" /></dd>
		</dl>
	</form>
	<?php }?>
</div>
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
