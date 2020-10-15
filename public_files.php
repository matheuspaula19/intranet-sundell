<?php
	session_start();
	include("news_bd_con.php");	
?>
<html>
<head>
	<title>Arquivos P˙blicos</title>
	<link rel='shortcut icon' type='image/x-icon' href='imgs/favicon.ico' />
	<link type="text/css" rel="stylesheet" href="css/default.css">
	<style type="text/css">
		#preload-01 {height:0px;background: url(imgs/download_over.png) no-repeat -9999px -9999px; }
		#tab_arquivos {padding:0;margin:0;background:#ffffff;border:2px solid #ccc;width: 990px;}
		#tab_arquivos td{padding: 8px 4px 8px 4px;cursor:default;}
		#tab_arquivos tr{background:#ffffff;}
		#tab_arquivos tr a{color:#000000;}
		#tab_arquivos tr:hover{background:#00b5fe !important;color:#ffffff !important;}
		#tab_arquivos tr:hover a{color:#ffffff;}
		#tab_arquivos .delete_btn{padding-left: 18px;background:url(imgs/trash_ico.png) 0 no-repeat;cursor:pointer;}
		#tab_arquivos tr:hover .delete_btn{background:url(imgs/trash_ico.png) -15px no-repeat;}
		#tab_arquivos .delete_btn a{text-decoration:none;color:#000000;}
		
		.down_btn{background:url(imgs/download.png) no-repeat;}
		.down_btn:hover{background:url(imgs/download_over.png) no-repeat;}
	</style>
</head>
<body>
	<div align="center">
	<div id="topbar"><div style="width: 990px;color: #ffffff;font-family: 'Open Sans', 'Trebuchet MS';font-size: 12px;line-height: 30px;">
		<div style="width: 870px;float: left;text-align: left;text-transform:capitalize;"><?php setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese"); date_default_timezone_set('America/Sao_Paulo');  echo strftime("%A, %d <span style='text-transform:lowercase;'>de</span> %B <span style='text-transform:lowercase;'>de</span> %Y", strtotime( date('Y-m-d') ));  ?></div>
		<div style="float:left;">INTRANET - Ver. 2.0</div>
	</div></div>
	<div class="header">
		<table align="left" width="100%">
			<tr><td style="width:210px;"><a href="/"><img src="imgs/sundell.png" border="0"/></a></td>
			<td align="right"><table id="menu"><tr><td><a href="/">P·gina Inicial</a> |</td><td><a href="news.php">NotÌcias</a> |</td><td><a href="empresa.php">Empresa</a></td><?php if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "admin"){echo "<td> | <a href=\"admin/index.php\">¡Årea do Administrador</a></td>";}else{if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "editor"){echo "<td> | <a href=\"admin/index.php\">¡Årea do Editor</a></td>";}else{echo "<td> | <a href=\"admin/index.php\">Entrar</a></td>";}}?>
			<td>
			<?php include('logoff_area.php'); ?>
			</td>
			</tr></table></td>
			</tr>
		</table>
	</div>
	<div id="preload-01"></div>
	<table style="height: 45px;width: 990px;"><tr><td><p class="col-title">Arquivos P˙blicos</p></td></tr></table>
	<div style="width: 990px;" align="left">
<?php

//realiza o download
if(isset($_GET['dw'])){
	header("Content-type: application/force-download");
	$file=$_GET['file'];
	$local_file="public_files/".$file;
	header("Content-Disposition: attachment; filename=".$file);
	header("Content-Description: $file");
	readfile($local_file);
}

// Se o texto for maior que o limite, ele corta o texto e adiciona 3 pontinhos.
function resume( $var, $limite )
{
	if (strlen($var) > $limite)
	{
		$var = substr($var, 0, $limite);
		$var = trim($var) . "...";
	}
	return $var;
}
	
function tamanhoArquivo($arquivo){	
	$tamanho = filesize($arquivo);
	$kb = 1024;
	$mb = 1048576;
	$gb = 1073741824;
	$tb = 1099511627776;

	if($tamanho<$kb){
	echo($tamanho." bytes");
	
	}else if($tamanho>=$kb&&$tamanho<$mb){
	$kilo = number_format($tamanho/$kb,2);
	echo($kilo." KB");

	}else if($tamanho>=$mb&&$tamanho<$gb){
	
	$mega = number_format($tamanho/$mb,2);
	echo($mega." MB");
	
	}else if($tamanho>=$gb&&$tamanho<$tb){
		$giga = number_format($tamanho/$gb,2);
		echo($giga." GB");
	}
}

function downloads_dir($dir){
$dirlist = opendir($dir);
$cont = 0;

echo "<table class='tabela' id='tab_arquivos' cellpadding=\"0\" cellspacing=\"0\">";
echo "<tr style=\"background:#ffffff !important;color:#000000 !important;\"><td>Nome</td><td>Tamanho</td><td style=\"width:180px\">Data de ModificaÁ„o</td></tr>";


while ($file = readdir ($dirlist)){
$size = $dir."/".$file;
$date = filemtime ($dir."/".$file);
if ($file != '.' && $file != '..'){
///// ESCOLHENDO ICONES
$icopath = "imgs/extensions_ico/";

//----->	compactacao

if(preg_match("/.zip$/",$file)){		//ZIP
$imagem=$icopath."zip.png";
}elseif(preg_match("/.7z$/",$file)){	//7Z
$imagem=$icopath."7z.png";
}elseif(preg_match("/.ace$/",$file)){	//7Z
$imagem=$icopath."ace.png";
}elseif(preg_match("/.hqx$/",$file)){	//HQX
$imagem=$icopath."hqx.png";
}elseif(preg_match("/.gz$/",$file)){	//GZ
$imagem=$icopath."gz.png";
}elseif(preg_match("/.rar$/",$file)){	//RAR
$imagem=$icopath."rar.png";		//----->	audio
}elseif(preg_match("/.wma$/",$file)){	//WMA
$imagem=$icopath."wma.png";
}elseif(preg_match("/.aif$/",$file)){	//AIF
$imagem=$icopath."aif.png";
}elseif(preg_match("/.aiff$/",$file)){	//AIFF
$imagem=$icopath."aiff.png";
}elseif(preg_match("/.amr$/",$file)){	//AMR
$imagem=$icopath."amr.png";
}elseif(preg_match("/.m4a$/",$file)){	//M4A
$imagem=$icopath."m4a.png";
}elseif(preg_match("/.m4b$/",$file)){	//M4B
$imagem=$icopath."m4b.png";
}elseif(preg_match("/.mid$/",$file)){	//MID
$imagem=$icopath."mid.png";
}elseif(preg_match("/.mp2$/",$file)){	//MP2
$imagem=$icopath."mp2.png";
}elseif(preg_match("/.mp3$/",$file)){	//MP3
$imagem=$icopath."mp3.png";
}elseif(preg_match("/.ogg$/",$file)){	//OGG
$imagem=$icopath."ogg.png";
}elseif(preg_match("/.ram$/",$file)){	//RAM
$imagem=$icopath."ram.png";		//------>	video
}elseif(preg_match("/.3gp$/",$file)){	//3GP
$imagem=$icopath."3gp.png";
}elseif(preg_match("/.wmv$/",$file)){	//WMV
$imagem=$icopath."wmv.png";
}elseif(preg_match("/.m4v$/",$file)){	//M4V
$imagem=$icopath."m4v.png";
}elseif(preg_match("/.mp4$/",$file)){	//MP4
$imagem=$icopath."mp4.png";
}elseif(preg_match("/.mpeg$/",$file)){	//MPEG
$imagem=$icopath."mpeg.png";
}elseif(preg_match("/.mov$/",$file)){	//MOV
$imagem=$icopath."mov.png";
}elseif(preg_match("/.rm$/",$file)){	//RM
$imagem=$icopath."rm.png";
}elseif(preg_match("/.rmvb$/",$file)){	//RMVB
$imagem=$icopath."rmvb.png";
}elseif(preg_match("/.vob$/",$file)){	//VOB
$imagem=$icopath."vob.png";
}elseif(preg_match("/.divx$/",$file)){	//DIVX
$imagem=$icopath."divx.png";
}elseif(preg_match("/.flv$/",$file)){	//FLV
$imagem=$icopath."flv.png";
}elseif(preg_match("/.swf$/",$file)){	//SWF
$imagem=$icopath."swf.png";
}elseif(preg_match("/.asf$/",$file)){	//ASF
$imagem=$icopath."asf.png";
}elseif(preg_match("/.asx$/",$file)){	//ASX
$imagem=$icopath."asx.png";		//------>	imagem
}elseif(preg_match("/.jpg$/",$file)){	//JPG
$imagem=$icopath."jpg.png";
}elseif(preg_match("/.jpeg$/",$file)){	//JPEG
$imagem=$icopath."jpeg.png";
}elseif(preg_match("/.png$/",$file)){	//PNG
$imagem=$icopath."png.png";
}elseif(preg_match("/.tif$/",$file)){	//TIF
$imagem=$icopath."tif.png";
}elseif(preg_match("/.bmp$/",$file)){	//BMP
$imagem=$icopath."bmp.png";		//------>	documentos
}elseif(preg_match("/.pdf$/",$file)){	//PDF
$imagem=$icopath."pdf.png";
}elseif(preg_match("/.xls$/",$file)){	//XLS
$imagem=$icopath."xls.png";
}elseif(preg_match("/.xlsx$/",$file)){	//XLSX
$imagem=$icopath."xlsx.png";
}elseif(preg_match("/.pptx$/",$file)){	//PPTX
$imagem=$icopath."pptx.png";
}elseif(preg_match("/.doc$/",$file)){	//DOC
$imagem=$icopath."doc.png";
}elseif(preg_match("/.docx$/",$file)){	//DOCX
$imagem=$icopath."docx.png";
}elseif(preg_match("/.txt$/",$file)){	//TXT
$imagem=$icopath."txt.png";		//------>	apresentacao
}elseif(preg_match("/.pps$/",$file)){	//PPS
$imagem=$icopath."pps.png";
}elseif(preg_match("/.pptx$/",$file)){	//PPTX
$imagem=$icopath."pptx.png";	//------>	pagina web
}elseif(preg_match("/.htm$/",$file)){	//HTM
$imagem=$icopath."htm.png";
}elseif(preg_match("/.html$/",$file)){	//HTML
$imagem=$icopath."html.png";
}elseif(preg_match("/.php$/",$file)){	//PHP
$imagem=$icopath."php.png";		//------>	outros
}elseif(preg_match("/.psd$/",$file)){	//PSD
$imagem=$icopath."psd.png";
}elseif(preg_match("/.cbr$/",$file)){	//CBR
$imagem=$icopath."cbr.png";
}elseif(preg_match("/.cdl$/",$file)){	//CDL
$imagem=$icopath."cdl.png";
}elseif(preg_match("/.cdr$/",$file)){	//CDR
$imagem=$icopath."cdr.png";
}elseif(preg_match("/.chm$/",$file)){	//CHM
$imagem=$icopath."chm.png";
}elseif(preg_match("/.dat$/",$file)){	//DAT
$imagem=$icopath."dat.png";
}elseif(preg_match("/.bat$/",$file)){	//BAT
$imagem=$icopath."bat.png";
}elseif(preg_match("/.dll$/",$file)){	//DLL
$imagem=$icopath."dll.png";
}elseif(preg_match("/.dmg$/",$file)){	//DMG
$imagem=$icopath."dmg.png";
}elseif(preg_match("/.dss$/",$file)){	//DSS
$imagem=$icopath."dss.png";
}elseif(preg_match("/.dvf$/",$file)){	//DVF
$imagem=$icopath."dvf.png";
}elseif(preg_match("/.dwg$/",$file)){	//DWG
$imagem=$icopath."dwg.png";
}elseif(preg_match("/.eml$/",$file)){	//EML
$imagem=$icopath."eml.png";
}elseif(preg_match("/.eps$/",$file)){	//EPS
$imagem=$icopath."eps.png";
}elseif(preg_match("/.exe$/",$file)){	//EXE
$imagem=$icopath."exe.png";
}elseif(preg_match("/.mcd$/",$file)){	//MCD
$imagem=$icopath."mcd.png";
}elseif(preg_match("/.ifo$/",$file)){	//IFO
$imagem=$icopath."ifo.png";
}elseif(preg_match("/.indd$/",$file)){	//INDD
$imagem=$icopath."indd.png";
}elseif(preg_match("/.iso$/",$file)){	//ISO
$imagem=$icopath."iso.png";
}elseif(preg_match("/.jar$/",$file)){	//JAR
$imagem=$icopath."jar.png";
}elseif(preg_match("/.lnk$/",$file)){	//LNK
$imagem=$icopath."lnk.png";
}elseif(preg_match("/.log$/",$file)){	//LOG
$imagem=$icopath."log.png";
}elseif(preg_match("/.m4p$/",$file)){	//M4P
$imagem=$icopath."m4p.png";
}elseif(preg_match("/.msi$/",$file)){	//MSI
$imagem=$icopath."msi.png";
}elseif(preg_match("/.pst$/",$file)){	//PST
$imagem=$icopath."pst.png";
}elseif(preg_match("/.pub$/",$file)){	//PUB
$imagem=$icopath."pub.png";
}elseif(preg_match("/.qbb$/",$file)){	//QBB
$imagem=$icopath."qbb.png";
}elseif(preg_match("/.qbw$/",$file)){	//QBW
$imagem=$icopath."qbw.png";
}elseif(preg_match("/.qxd$/",$file)){	//QXD
$imagem=$icopath."qxd.png";
}elseif(preg_match("/.sea$/",$file)){	//SEA
$imagem=$icopath."sea.png";
}elseif(preg_match("/.ses$/",$file)){	//SES
$imagem=$icopath."ses.png";
}elseif(preg_match("/.sitx$/",$file)){	//SITX
$imagem=$icopath."sitx.png";
}elseif(preg_match("/.ss$/",$file)){	//SS
$imagem=$icopath."ss.png";
}elseif(preg_match("/.tmp$/",$file)){	//TMP
$imagem=$icopath."tmp.png";
}elseif(preg_match("/.ttf$/",$file)){	//TTF
$imagem=$icopath."ttf.png";
}elseif(preg_match("/.vcd$/",$file)){	//VCD
$imagem=$icopath."vcd.png";
}elseif(preg_match("/.xpi$/",$file)){	//XPI
$imagem=$icopath."xpi.png";
}else{
$imagem=$icopath."undefined.png";	//ICONE PADRAO PARA EXT. DESCONHECIDAS
}
/// FIM ESCOLHENDO ICONES


echo "<tr><td class='";
if($cont%2){echo "linha1";}else{echo "linha2";}
echo "' valign='middle'>";
echo "<div style='float:left;'><img src='".$imagem."' border='0' /></div><div style='float:left;margin-left: 8px;'><a href=\"public_files.php?file=".$file."&dw=1\" style=\"line-height: 32px;\" title=\"".$file."\">".resume($file,70)."</a></div></td>";
echo "<td>";
echo tamanhoArquivo($size);
echo "</td><td style=\"width:180px\">".date ("d/m/Y H:i",$date)."</td>";
echo "<td style=\"width:50px\"><a href=\"public_files.php?file=".$file."&dw=1\" style=\"line-height: 32px;\"><img src='imgs/b.gif' class='down_btn' style='width:32px;height:32px;' border='0' alt='Baixar' title='Baixar'/></a></td></tr>";
}
	$cont++;
}
closedir($dirlist);
}
	downloads_dir('public_files');
	//informa que a pasta esta vazia
	$scan = scandir('public_files');
	if(count($scan) <= 2){	
		echo "<tr><td colspan=\"3\"><div align=\"center\"><ul style=\"width: 210px;height: 30px;margin:0;padding:0;\"><li style=\"float:left;list-style:none;\"><img src=\"imgs/empty_dir.png\" /></li><li style=\"float:left;list-style:none;margin-left: 10px;line-height: 32px;white-space:nowrap;\">O diretÛrio est· vazio.</li></ul></div></td></tr>";
	}
echo "</table>";
?>
</div>
<div style="padding:10px;">
	<span><?php echo date('Y');?> Sundell Development LTDA. Todos os Direitos Reservados</span>
</div>
</body>
</html>