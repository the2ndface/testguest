window.onload = function(){
	var type = document.getElementsByName('type');
	var pass = document.getElementById('pass');
	var fm = document.getElementsByTagName('form')[0];

	type[0].onclick = function() {
		pass.style.display='none';
	};
	type[1].onclick = function() {
		pass.style.display='block';
	};
	
	fm.onsubmit = function(){
		if (fm.name.value.length < 2 || fm.name.value.length > 40) {
			alert('标题不得小于2位或者大于40位');
			fm.name.value = ''; //清空
			fm.name.focus(); //将焦点以至表单字段
			return false;
		}
		
		if(type[1].checked){
			if (fm.password.value.length<6){
				alert('密码不得小于6位！');
				fm.password.value = ''; //清空
				fm.password.focus(); //将焦点以至表单字段
				return false;
			}
		}
		
		return true;
	};
	

};