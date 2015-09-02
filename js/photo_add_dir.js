window.onload = function(){
	var type = document.getElementsByName('type');
	var pass = document.getElementById('pass');
	
	type[0].onclick = function() {
		pass.style.display='none';
	};
	type[1].onclick = function() {
		pass.style.display='block';
	};
};