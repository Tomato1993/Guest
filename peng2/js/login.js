window.onload = function () {
	code();
	var fm = document.getElementsByTagName('form')[0];

	fm.onsubmit = function () {
		if (fm.username.value.length < 2 || fm.username.value.length > 20) {
			alert('�û�������С��2λ���ߴ���20λ');
			fm.username.value = ''; 
			fm.username.focus(); 
			return false;
		}
		if (/[<>\'\"\ \��]/.test(fm.username.value)) {
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
		if (fm.code.value.length != 4) {
			alert('��֤�������4λ');
			fm.code.value = '';
			fm.code.focus();
			return false;
		}
	};
};