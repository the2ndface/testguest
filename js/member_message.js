window.onload =function(){
	var fm = document.getElementsByTagName('form')[0];
	var all = document.getElementById('all');
	all.onclick = function(){
		for(var i=0;i<fm.elements.length;i++){
			if(fm.elements[i].name!='chkall'){
				fm.elements[i].checked=all.checked;
			}
		}
	};
	
	fm.onsubmit = function(){
		if(confirm()){
			return true;
		}else{
			return false;
		}
	};
};