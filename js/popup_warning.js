function popup_show(titulo,texto,id,url,tipo){
var html ='<div style="width:100%;height:100%;position:absolute;left:0;top:0;background:rgba(0,0,0,0.5);">';
html = html+'<div id="pop'+id+'" class="popup">';
html = html+'<table><tr><td style="font-size:19px;">'+titulo+'</td></tr>';
html = html+'<tr><td>'+texto+'<br /><br /></td></tr>';
if(tipo == 1){
	html = html+'<tr><td></td><td align="right" class="pop_btn" onclick="window.location.href = \''+url+'\';">Sim</td><td align="right" class="pop_btn" onclick="destroy_pop()">N&atilde;o</td></tr></table></div></div>';
}
else{
	if(tipo == 2){
		html = html+'<tr><td></td><td align="right" class="pop_btn" onclick="window.location.href = \''+url+'\';">OK</td></tr></table></div></div>';
	}
}
document.getElementById('popup_main').innerHTML = html;
}


function destroy_pop(){
document.getElementById('popup_main').innerHTML ='';
}