<?php
function _runtime() {
	$_mtime = explode(' ',microtime());
	return $_mtime[1] + $_mtime[0];
}

function _alert_back($_info) {
	echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
	exit();
}

function _location($_info,$_url) {
	if (!empty($_info)) {
		echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
		exit();
	} else {
		header('Location:'.$_url);
	}
}


function _login_state() {
	if (isset($_COOKIE['username'])) {
		_alert_back('��¼״̬�޷����б�������');
	}
}


function _page($_sql,$_size) {
	global $_page,$_pagesize,$_pagenum,$_pageabsolute,$_num;
	if (isset($_GET['page'])) {
		$_page = $_GET['page'];
		if (empty($_page) || $_page < 0 || !is_numeric($_page)) {
			$_page = 1;
		} else {
			$_page = intval($_page);
		}
	} else {
		$_page = 1;
	}
	$_pagesize = $_size;
	$_num = _num_rows(_query($_sql));
	if ($_num == 0) {
		$_pageabsolute = 1;
	} else {
		$_pageabsolute = ceil($_num / $_pagesize);
	}
	if ($_page > $_pageabsolute) {
		$_page = $_pageabsolute;
	}
	$_pagenum = ($_page - 1) * $_pagesize;
}

function _paging($_type) {
	global $_page,$_pageabsolute,$_num;
	if ($_type == 1) {
		echo '<div id="page_num">';
		echo '<ul>';
				for ($i=0;$i<$_pageabsolute;$i++) {
						if ($_page == ($i+1)) {
							echo '<li><a href="blog.php?page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
						} else {
							echo '<li><a href="blog.php?page='.($i+1).'">'.($i+1).'</a></li>';
						}
				}
		echo '</ul>';
		echo '</div>';
	} elseif ($_type == 2) {
		echo '<div id="page_text">';
		echo '<ul>';
		echo '<li>'.$_page.'/'.$_pageabsolute.'ҳ | </li>';
		echo '<li>����<strong>'.$_num.'</strong>����Ա | </li>';
				if ($_page == 1) {
					echo '<li>��ҳ | </li>';
					echo '<li>��һҳ | </li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php">��ҳ</a> | </li>';
					echo '<li><a href="'.SCRIPT.'.php?page='.($_page-1).'">��һҳ</a> | </li>';
				}
				if ($_page == $_pageabsolute) {
					echo '<li>��һҳ | </li>';
					echo '<li>βҳ</li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php?page='.($_page+1).'">��һҳ</a> | </li>';
					echo '<li><a href="'.SCRIPT.'.php?page='.$_pageabsolute.'">βҳ</a></li>';
				}
		echo '</ul>';
		echo '</div>';
	}
}



function _session_destroy() {
	session_destroy();
}


function _unsetcookies() {
	setcookie('username','',time()-1);
	setcookie('uniqid','',time()-1);
	_session_destroy();
	_location(null,'index.php');
}


function _sha1_uniqid() {
	return _mysql_string(sha1(uniqid(rand(),true)));
}

function _mysql_string($_string) {
	if (!GPC) {
		return mysql_real_escape_string($_string);
	} 
	return $_string;
}


function _check_code($_first_code,$_end_code) {
	if ($_first_code != $_end_code) {
		_alert_back('��֤�벻��ȷ!');
	}
}

function _code($_width = 75,$_height = 25,$_rnd_code = 4,$_flag = false) {
	
	
	for ($i=0;$i<$_rnd_code;$i++) {
		$_nmsg .= dechex(mt_rand(0,15));
	}
	
	$_SESSION['code'] = $_nmsg;
	
	$_img = imagecreatetruecolor($_width,$_height);
	$_white = imagecolorallocate($_img,255,255,255);
	

	imagefill($_img,0,0,$_white);
	
	if ($_flag) {
	
		$_black = imagecolorallocate($_img,0,0,0);
		imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);
	}
	
	
	for ($i=0;$i<6;$i++) {
		$_rnd_color = imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
		imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
	}
	
	
	for ($i=0;$i<100;$i++) {
		$_rnd_color = imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
		imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),'*',$_rnd_color);
	}
	
	
	for ($i=0;$i<strlen($_SESSION['code']);$i++) {
		$_rnd_color = imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
		imagestring($_img,5,$i*$_width/$_rnd_code+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
	}
	

	header('Content-Type: image/png');
	imagepng($_img);
	

	imagedestroy($_img);
}


?>