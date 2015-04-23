//等在网页加载完毕再执行
window.onload = function () {
	code();
	var faceimg = document.getElementById('faceimg');
	faceimg.onclick = function () {
		window.open('face.php','face','width=400,height=400,top=0,left=0,scrollbars=1');
	}
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {
		if (fm.username.value.length < 2 || fm.username.value.length > 20) {
			alert('用户名不得小于2位或者大于20位');
			fm.username.value = ''; 
			fm.username.focus();
			return false;
		}
		if (/[<>\'\"\ ]/.test(fm.username.value)) {
			alert('用户名不得包含非法字符');
			fm.username.value = ''; 
			fm.username.focus();
			return false;
		}
		
		if (fm.password.value.length < 6) {
			alert('密码不得小于6位');
			fm.password.value = ''; 
			fm.password.focus(); 
			return false;
		}
		if (fm.password.value != fm.notpassword.value) {
			alert('密码和密码确认必须一致');
			fm.notpassword.value = ''; 
			fm.notpassword.focus();
			return false;
		}
		
		if (fm.question.value.length < 2 || fm.question.value.length > 20) {
			alert('密码提示不得小于2位或者大于20位');
			fm.question.value = '';
			fm.question.focus();
			return false;
		}
		if (fm.answer.value.length < 2 || fm.answer.value.length > 20) {
			alert('密码回答不得小于2位或者大于20位');
			fm.answer.value = '';
			fm.answer.focus();
			return false;
		}
		if (fm.answer.value == fm.question.value) {
			alert('密码提示和密码回答不得相等');
			fm.answer.value = '';
			fm.answer.focus();
			return false;
		}
		
		
		if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)) {
			alert('邮件格式不正确');
			fm.email.value = ''; 
			fm.email.focus();
			return false;
		}
		
		
		if (fm.qq.value != '') {
			if (!/^[1-9]{1}[\d]{4,9}$/.test(fm.qq.value)) {
				alert('QQ号码不正确');
				fm.qq.value = ''; 
				fm.qq.focus();
				return false;
			}
		}
		
		
		if (fm.url.value != '') {
			if (!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
				alert('网址不合法');
				fm.url.value = '';
				fm.url.focus(); 
				return false;
			}
		}
		
		
		if (fm.code.value.length != 4) {
			alert('验证码必须是4位');
			fm.code.value = '';
			fm.code.focus();
			return false;
		}
		
		
		return true;
	};
};









