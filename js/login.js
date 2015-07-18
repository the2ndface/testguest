window.onload = function(){
	code();
	
	
		//登录验证
	var fm = document.getElementsByName('login')[0];
	fm.onsubmit = function (){
		//能用客户端验证的尽量用客户端验证
		//用户名验证
		if(fm.username.value.length<2||fm.username.value.length >20){
			alert('用户名不得小于两位或大于20位');
			fm.username.value = ''; //清空
			fm.username.focus();//将光标移过去
			return false;
		}
		if(/[<>\'\"\ \　]/.test(fm.username.value)){
			alert('用户名不得包含敏感字符');
			fm.username.value = ''; //清空
			fm.username.focus();//将光标移过去
			return false;
		}
		//密码验证
		if(fm.password.value.length<6){
			alert('密码不得小于6位');
			fm.password.value = ''; //清空
			fm.password.focus();//将光标移过去
			return false;
		}
		
		//验证码验证
		if(fm.code.value.length != 4){
			alert('验证码必须是4位');
			fm.code.value = ''; //
			fm.code.focus();//将光标移过去
			return false;
		}
	};
};