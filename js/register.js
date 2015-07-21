window.onload = function(){
	code();
	var faceimg = document.getElementById('faceimg');
	faceimg.onclick = function (){
		window.open('face.php','face','width=400,height=400,top=0,left=0,scrollbars=1');
	}
	
	
	
	//表单验证
	var fm = document.getElementsByName('register')[0];
	fm.onsubmit = function (){
		//能用客户端验证的尽量用客户端验证
		//用户名验证
		if(fm.username.value.length<2||fm.username.value.length >20){
			alert('用户名不得小于两位或大于20位');
			fm.username.value = ''; //清空
			fm.username.focus();//将光标移过去
			return false;
		}
		if(/[<>\'\"\ ]/.test(fm.username.value)){
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
		
		if(fm.password.value != fm.notpassword.value){
			alert('两次密码必须一致');
			fm.notpassword.value = ''; //清空
			fm.notpassword.focus();//将光标移过去
			return false;
		}
		
		//密码提示、回签
		if(fm.question.value.length<2||fm.question.value.length >20){
			alert('密码提示不得小于两位或大于20位');
			fm.question.value = ''; //清空
			fm.question.focus();//将光标移过去
			return false;
		}
		
		if(fm.answer.value.length<2||fm.answer.value.length >20){
			alert('密码回签不得小于两位或大于20位');
			fm.answer.value = ''; //清空
			fm.answer.focus();//将光标移过去
			return false;
		}
		
		if(fm.answer.value == fm.question.value){
			alert('密码回答与问题不能相同');
			fm.answer.value = ''; //清空
			fm.answer.focus();//将光标移过去
			return false;
		}
		
		//邮箱验证
		if(!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)){
			alert('邮件格式不正确');
			fm.email.value = ''; //清空
			fm.email.focus();//将光标移过去
			return false;
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
};
