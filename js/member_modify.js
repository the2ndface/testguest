window.onload = function(){
	code();
	//表单验证
	var fm = document.getElementsByName('modify')[0];
	fm.onsubmit = function (){
		//密码验证
		if(fm.password.value !=''){
			if(fm.password.value.length<6){
			alert('密码不得小于6位');
			fm.password.value = ''; //清空
			fm.password.focus();//将光标移过去
			return false;
			}
		}
		
		
				//QQ验证
		if(fm.qq.value !=''){
			if(!/^[1-9]{1}[0-9]{4,9}$/.test(fm.qq.value)){
			alert('QQ格式不正确');
			fm.qq.value = ''; //清空
			fm.qq.focus();//将光标移过去
			return false;
			}
		}
		
		//网址验证
		if(fm.url.value !='' && fm.url.value != 'http://'){
			if(!/^(https?:\/\/)?(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)){
			alert('URL格式不正确');
			fm.url.value = 'http://'; //
			fm.url.focus();//将光标移过去
			return false;
			}
		}
		
		//验证码验证
		if(fm.code.value.length != 4){
			alert('验证码必须是4位');
			fm.code.value = ''; //
			fm.code.focus();//将光标移过去
			return false;
		}
		
		return true;
	};
}