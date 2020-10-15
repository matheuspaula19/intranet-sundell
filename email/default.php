<?php
	if(isset($_POST["confirm"]))
	{
		session_start();
	}
	if(!empty($_POST["form_pronto"]) == 1)
	{
		$email = "contato2@matheusproducoes.hol.es";
		$destino = "matheusademir@hotmail.com";
		$descricao = $_POST["description"];
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: $email \r\n";
		
		$mensagem = "
		<style type='text/css' media='all'>
			body{font-family: 'Open Sans',Arial,Helvetica;font-size:14px;}
			p{font-family: 'Open Sans',Arial,Helvetica;}
			.descricao{height:140px;padding: 6px;border-radius: 4px;box-shadow: inset 0px 1px 2px rgba(0,0,0,0.3);-webkit-box-shadow: inset 0px 1px 2px rgba(0,0,0,0.3);border: 1px solid #ddd;}		
		</style>";
		
		$assunto = $_POST["assunto"];
		$nome = $_POST["nome"];
		$usremail = $_POST["email"];
		$mensagem .= "
		<div align='center' style='width: 100%;height: 100%;padding: 10px;'>
		<div align='left' style='width:500px;top:10px;background-color:#fff;box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset 0 -1px 0 rgba(0,0,0,.07);border: 1px solid #d8d8d8;border-bottom-width: 2px;border-radius: 3px;'>
		<div style='border-top: 5px solid #ca2900;'></div>
		<table style='padding: 4px;'><tr><td valign='middle'><img src='http://3.bp.blogspot.com/-jKHsopRvZDs/UmdULwnGqPI/AAAAAAAAE9w/aPXO_sC_4Ac/s1600/mts_logo.png'></td><td valign='middle'><p style='font-size:20px;padding:4px;'>Mensagem do Internauta</p></td></tr></table>
		<div style='padding: 8px;'><b>Nome:</b> ".$nome."<br/><b>Email:</b> ".$usremail."<br/><b>Assunto:</b> ".$assunto."<br/><br/><b>Mensagem:</b></div>
		<div class='descricao' style='margin: 8px;'>".$descricao."</div>
		</div>
		</div>";
	
		
		$enviando = mail($destino, $assunto, $mensagem, $headers);
		if($enviando) 
		{
			echo "<div align='center'><div id='overlay_msg_div'><div id='overlay_content'><table><tr><td><img src='success_alert.png'></td><td style='color: #00A200;'>Seu pedido foi enviado com sucesso!</td></tr></table><p style='font-size: 13px;'>Seu pedido foi enviado, entraremos em contato em breve através do email informado.</p><center><button type='button' class='btn_style' onclick='javascript: sendmsgclose();'>OK</button></center></div></div></div>";
		}
		else{
			echo "<div align='center'><div id='overlay_msg_div'><div id='overlay_content'><table><tr><td><img src='error_alert.png'></td><td style='color:#ca2900;'>Notificação/Pedido n&#227;o enviado!</td></tr></table><p style='font-size: 13px;'>Houve um erro no envio da notificação/pedido, tente novamente mais tarde!</p><center><button type='button' class='btn_style' onclick='javascript: sendmsgclose();'>OK</button></center></div></div></div>";
		}
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
	<head>
	<title>Reportar erros</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<script src="../js/jquery.min.js"></script>
	<link href="../css/default.css" rel="stylesheet" type="text/css">
	<style type="text/css" media="all">
	#contato_table, #enviar_table{font-family:'Open Sans', 'Trebuchet MS', Arial;font-size:12px;}
	.campo_padrao{
		outline:none;
		cursor: text;
		display: inline-block;
		height: 25px;
		padding: 4px;
		border: 1px solid #ddd;
		background: #fff;
		box-shadow: inset 0 2px 4px rgba(0,0,0,.1);
		color: #999;
		font: 500 15px/1em 'Raleway',helvetica,arial,sans-serif;
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
	}
	.campo_padrao{
		-webkit-transition: all 0.2s ease-in-out;
		-moz-transition: all 0.2s ease-in-out;
		-o-transition: all 0.2s ease-in-out;
		-ms-transition: all 0.2s ease-in-out;
		transition: all 0.2s ease-in-out;
	}
	.campo_padrao:focus,.campo_padrao:hover {border-color: #999;}
	.btn_style{
		outline:none;
		cursor:pointer;
		color:#777;
		background-color: rgb(240, 240, 240);
		border: 1px solid #ccc;
		padding: 4px 8px 4px 8px;
		-webkit-box-shadow: 0 1px 3px 0 rgba(0,0,0,.2);
		box-shadow: 0 1px 3px 0 rgba(0,0,0,.2);
	}
	.btn_style:hover{
		border: 1px solid #bbb;
		color:#555;
		-webkit-box-shadow: 0 1px 3px 0 rgba(0,0,0,.3);
		box-shadow: 0 1px 3px 0 rgba(0,0,0,.3);
	}
	.btn_style:active{
		border: 1px solid #aaa;
	}
	#overlay_msg_div{
	font-family:'Open Sans', 'Trebuchet MS', Arial;
	font-size: 13px;
	position: absolute;
	background: url('transp.png');
	width: 100%;
	height: 100%;
	top: 0px;
	z-index: 9999;
	left: 0px;
	}
	#overlay_content{
	border-radius: 4px;
	margin-top: 50px;
	width: 300px;
	background: #fff;
	margin-left: 10px;
	-webkit-box-shadow: 0px 0px 4px 0 rgba(0,0,0,.2);
	box-shadow: 0px 0px 4px 0 rgba(0,0,0,.2);
	padding: 10px;
	}
	</style>
	<script type="text/javascript">
	function toUpper(lstr)
	{
		var str=lstr.value;
		lstr.value=str.toUpperCase();
		$("#captcha_input").css("border", "1px solid #ccc");
	}
	function tudo_ok()
	{
		if(verificaemail() == true && verificamsg() == true && verificanome() == true && verificaassunto() == true)
		{
			document.contato.submit();
		}
		else
		{
			verificaemail2();
			verificaemail();
			verificaassunto();
			verificanome();
			verificamsg();
			$("#overlay_msg_div").css("display", "block");
		}
	}
	function formerro()
	{
		$("#overlay_msg_div").css("display", "block");
	}
	function sendmsgclose()
	{
		$("#overlay_msg_div").css("display", "none");
		window.open('http://contato.matheusproducoes.hol.es/','_self');
	}
	function fechaerro()
	{
		$("#overlay_msg_div").css("display", "none");
	}
	function textboxbackup()
	{
		document.getElementById('tbx2').value = document.getElementById('tbx1').value;
	}
	function nomebackup()
	{
		document.getElementById('nome2').value = document.getElementById('nome').value;
	}
	function emailbackup()
	{
		document.getElementById('email2').value = document.getElementById('email').value;
	}
	function assuntobackup()
	{
		document.getElementById('assunto2').value = document.getElementById('assunto').value;
	}

	function atualizadados()
	{
		emailbackup();textboxbackup();assuntobackup();nomebackup();
	}
	function verificaemail()
	{
		campo_email = document.getElementById('email').value;
		if(campo_email.length <= 0)
		{
			$("#email").css("border", "1px solid #ca2900");
			return false;
		}
		else
		{
			return true;
		}
	}
	function verificanome()
	{
		campo_nome = document.getElementById('nome').value;
		if(campo_nome.length <= 0)
		{
			$("#nome").css("border", "1px solid #ca2900");
			return false;
		}
		else
		{
			$("#nome").css("border", "1px solid #ddd");
			return true;
		}
	}
	function verificaassunto()
	{
		campo_assunto = document.getElementById('assunto').value;
		if(campo_assunto.length <= 0)
		{
			$("#assunto").css("border", "1px solid #ca2900");
			return false;
		}
		else
		{
			$("#assunto").css("border", "1px solid #ddd");
			return true;
		}
	}
	function verificamsg()
	{
		campo_msg = document.getElementById('tbx1').value;
		if(campo_msg.length <= 0)
		{
			$("#tbx1").css("border", "1px solid #ca2900");
			return false;
		}
		else
		{
			$("#tbx1").css("border", "1px solid #ddd");
			return true;
		}
	}
	function verificaemail2()
	{
		var campo_email2 = document.getElementById('email').value;
		if( (campo_email2.length<8 || substr_count(campo_email2,'@') != 1 || substr_count(campo_email2, '.') == 0) && (campo_email2.length != 0) )
			{
				input = document.getElementById('email').focus();
				input = document.getElementById('email').select();
				$("#email").css("border", "1px solid #ca2900");
				return false;
			}
			else
			{
				$("#email").css("border", "1px solid #ddd");
				return true;
			}
	}
	
	function substr_count (haystack, needle, offset, length) {
	  var cnt = 0;

	  haystack += '';
	  needle += '';
	  if (isNaN(offset)) {
		offset = 0;
	  }
	  if (isNaN(length)) {
		length = 0;
	  }
	  if (needle.length == 0) {
		return false;
	  }
	  offset--;

	  while ((offset = haystack.indexOf(needle, offset + 1)) != -1) {
		if (length > 0 && (offset + needle.length) > length) {
		  return false;
		}
		cnt++;
	  }
	  return cnt;
	}
	</script>
	</head>
	
	<body style="margin: 10px !important;padding: initial !important;background: #fff; font-family: 'Open Sans',Tahoma, 'Trebuchet MS', Arial;font-size: 11px;">
	<div align='center'>
		<div id='overlay_msg_div' style="display:none;">
			<div id='overlay_content'>
				<table>
					<tr>
						<td>
							<img src='error_alert.png'>
						</td>
						<td style='color:#ca2900;'>Erro(s) no formulário!</td>
					</tr>
				</table>
				<p style='font-size: 13px;'>Alguns campos no formulário estão incompletos ou incorretos, verifique se você os preencheu corretamente.</p>
				<center><button type='button' class='btn_style' onclick='javascript: fechaerro();'>OK</button></center>
			</div>
		</div>
	</div>	
	
	<form action="" name="contato" method="post">
		<input type="hidden" value="1" name="form_pronto"/>
	<table id="contato_table" width="100%">
	<tr>
	<td>Seu Nome</td>
	</tr>
	<tr>
		<td>
			<input type="text" class="campo_padrao" name="nome" id="nome" style="width: 100%;" <?php if(!empty($_POST["nomebackup"])){echo "value='".$_POST["nomebackup"]."'";} ?> onblur="nomebackup()" onkeydown="javascript: nomebackup()" onkeyup="verificanome();"/>
		</td>
	</tr>
	<tr>
	<td>Seu E-mail</td>
	</tr>
	<tr>
		<td>
			<input type="text" class="campo_padrao" name="email" id="email" style="width: 100%;" <?php if(!empty($_POST["emailbackup"])){echo "value='".$_POST["emailbackup"]."'";} ?> onblur="emailbackup()" onkeydown="javascript: emailbackup()" onfocusout="javascript: verificaemail2()"/>
		</td>
	</tr>
	<tr>
	<td>Assunto</td>
	</tr>
	<tr>
		<td>
			<input type="text" class="campo_padrao" name="assunto" id="assunto" style="width: 100%;" <?php if(!empty($_POST["assuntobackup"])){echo "value='".$_POST["assuntobackup"]."'";} ?> onblur="assuntobackup()" onkeydown="javascript: assuntobackup()" onkeyup="verificaassunto();"/>
		</td>
	</tr>
	<tr>
	<td>Mensagem</td>
	</tr>
	<tr>
		<td colspan="3">
			<textarea name="description" class="campo_padrao" MAXLENGTH="660" onkeyup="javascript: textboxbackup();verificamsg();" id="tbx1" style="width: 100%;height: 90px;max-height: 120px !important;"><?php if(!empty($_POST["descbackup"])){echo $_POST["descbackup"];}?></textarea>
		</td>
	</tr>
	</table>
	</form>
	<form action="default.php" name="captcha" method="post">
		<input name="descbackup" id="tbx2" type="hidden"/>
		<input name="nomebackup" id="nome2" type="hidden"/>
		<input name="emailbackup" id="email2" type="hidden"/>
		<input name="assuntobackup" id="assunto2" type="hidden"/>

		<table width="100%" id="enviar_table">
			<tr>
				<td style="width: 130px;" rowspan="2"><img  src="captcha_small/captcha.php?l=100&a=30&tf=15&ql=5"></td>
				<td style="font-size:13px;font-size:10px;" colspan="2">*Digite o código da imagem ao lado no campo abaixo:</td>
			</tr>
			<tr>			
				<td style="width: 93px;"><input type="text" id="captcha_input" class="campo_padrao" onkeyup="toUpper(this)" name="palavra" style="width:90px;" MAXLENGTH="5" /></td>
				<td><input type="submit" name="confirm" value="Enviar" class='btn_style'/></td>	
			</tr>
		</table>
	</form>
	<?php
		if(isset($_POST["confirm"]))
		{	
			if ($_POST["palavra"] == $_SESSION["palavra"]){
				echo "<script>tudo_ok();</script>";
				session_destroy();
			}else{
				echo "<script>document.getElementById('captcha_input').style.border = '1px solid #ca2900';</script>";
				echo "<script>atualizadados();formerro();</script>";
				echo "<script>verificaemail2();verificaemail();verificaassunto();verificanome();verificamsg();</script>";
				session_destroy();
			}
		}
	?>
	</body>
</html>