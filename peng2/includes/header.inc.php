<?php
if (!defined('IN_TG')) {
	exit('Access Defined!');
}
?>
<div id="header">
	<h1><a href="index.php">PHP���û�����ϵͳ</a></h1>
	<ul>
		<li><a href="index.php">��ҳ</a></li>
		<?php 
			if (isset($_COOKIE['username'])){
				echo '<li><a href="member.php">'.$_COOKIE['username'].'����������</a></li>';
				echo "\n";
			} else {	
				echo '<li><a href="register.php">ע��</a></li>';
				echo "\n";
				echo "\t\t";
				echo '<li><a href="login.php">��¼</a></li>';
				echo "\n";
			}
		?>
		<li><a href="blog.php">����</a></li>
		<li>���</li>
		<li>����</li>
		<?php 
			if (isset($_COOKIE['username'])){
				echo '<li><a href="logout.php">�˳�</a></li>';
			}
		?>
	</ul>
</div>