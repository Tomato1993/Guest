//������ҳ���������ִ��
window.onload = function () {
	code();
	var faceimg = document.getElementById('faceimg');
	faceimg.onclick = function () {
		window.open('face.php','face','width=400,height=400,top=0,left=0,scrollbars=1');
	}
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {
		if (fm.username.value.length < 2 || fm.username.value.length > 20) {
			alert('�û�������С��2λ���ߴ���20λ');
			fm.username.value = ''; 
			fm.username.focus();
			return false;
		}
		if (/[<>\'\"\ ]/.test(fm.username.value)) {
			alert('�û������ð����Ƿ��ַ�');
			fm.username.value = ''; 
			fm.username.focus();
			return false;
		}
		
		if (fm.password.value.length < 6) {
			alert('���벻��С��6λ');
			fm.password.value = ''; 
			fm.password.focus(); 
			return false;
		}
		if (fm.password.value != fm.notpassword.value) {
			alert('���������ȷ�ϱ���һ��');
			fm.notpassword.value = ''; 
			fm.notpassword.focus();
			return false;
		}
		
		if (fm.question.value.length < 2 || fm.question.value.length > 20) {
			alert('������ʾ����С��2λ���ߴ���20λ');
			fm.question.value = '';
			fm.question.focus();
			return false;
		}
		if (fm.answer.value.length < 2 || fm.answer.value.length > 20) {
			alert('����ش𲻵�С��2λ���ߴ���20λ');
			fm.answer.value = '';
			fm.answer.focus();
			return false;
		}
		if (fm.answer.value == fm.question.value) {
			alert('������ʾ������ش𲻵����');
			fm.answer.value = '';
			fm.answer.focus();
			return false;
		}
		
		
		if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)) {
			alert('�ʼ���ʽ����ȷ');
			fm.email.value = ''; 
			fm.email.focus();
			return false;
		}
		
		
		if (fm.qq.value != '') {
			if (!/^[1-9]{1}[\d]{4,9}$/.test(fm.qq.value)) {
				alert('QQ���벻��ȷ');
				fm.qq.value = ''; 
				fm.qq.focus();
				return false;
			}
		}
		
		
		if (fm.url.value != '') {
			if (!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
				alert('��ַ���Ϸ�');
				fm.url.value = '';
				fm.url.focus(); 
				return false;
			}
		}
		
		
		if (fm.code.value.length != 4) {
			alert('��֤�������4λ');
			fm.code.value = '';
			fm.code.focus();
			return false;
		}
		
		
		return true;
	};
};









