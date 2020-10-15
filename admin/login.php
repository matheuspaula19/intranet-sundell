<?php
include ("../news_bd_con.php"); // configs do serv. mysql

//conecta ao banco de dados
$_con = new mysqli($host,$user,$pass,$banco);

//faz consulta para verificar se ja foi cadastrado um usuário administrador
$_sql = "SELECT tipo FROM news_adm WHERE tipo= 'admin'";
$_res = $_con->query($_sql);
$_nr = $_res->num_rows;
$_con->close();
if($_nr == 0) {
//caso nao redireciona para a pagina de cadastro de administrador
header("Location: adm_cadastro.php?tipo=admin");
}
?>
<html>
	<head>
		<title>Intranet Sundell - Área Restrita | Login</title>
		<link rel='shortcut icon' type='image/x-icon' href='../imgs/favicon.ico' />
		<link type="text/css" rel="stylesheet" href="../css/default.css">
		<meta charset="ISO-8859-1">
	</head>
	<body>
		<div align="center">
			<div id="topbar"><div style="width: 990px;color: #ffffff;font-family: 'Open Sans', 'Trebuchet MS';font-size: 12px;line-height: 30px;">
				<div style="width: 870px;float: left;text-align: left;text-transform:capitalize;"><?php setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese"); date_default_timezone_set('America/Sao_Paulo');  echo strftime("%A, %d <span style='text-transform:lowercase;'>de</span> %B <span style='text-transform:lowercase;'>de</span> %Y", strtotime( date('Y-m-d') ));  ?></div>
				<div style="float:left;">INTRANET - Ver. 2.0</div>
			</div></div>
			<div class="header">
			<table align="left" width="100%">
				<tr><td style="width:210px;"><a href="/"><img src="../imgs/sundell.png" border="0"/></a></td>
				<td align="right"><table id="menu"><tr><td><a href="/">Página Inicial</a> |</td><td><a href="../news.php">Notícias</a> |</td><td><a href="../empresa.php">Empresa</a></td><?php if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "admin"){echo "<td> | <a href=\"index.php\">Área do Administrador</a></td>";}else{if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "editor"){echo "<td> | <a href=\"index.php\">Área do Editor</a></td>";}else{echo "<td> | <a href=\"admin/index.php\">Entrar</a></td>";}}?>
				</tr>
				</table>
				</td>
			</tr>
		</table>
			</table>
			</div>
			<div align="center">
				<table style="width:480px;height:360px;margin-top:5%;font-family: 'Trebuchet MS', Arial;">
					<tr>
						<td style="width: 100%;">
						<h2 style="font-family: 'Trebuchet MS', Arial;color: #bbb;font-size: 17px;">Esta página é restrita!<br/><br/>Insira seus dados para efetuar login no sistema.</h2>
						</td>
						<td align="right" style="border-left:1px solid #ddd;">
							<table class="txt_form_padrao" style="margin-left: 10px;">
								<form method="post" action="valida.php">
								<tr><td colspan="2" style="font-size: 12px;">Usu&aacute;rio</td></tr>
								<tr><td colspan="2"><input type="text" name="usuario" maxlength="50" class="campo_padrao" style="width:240px;"/></td></tr>
								<tr><td colspan="2" style="font-size: 12px;">Senha</td></tr>
								<tr><td colspan="2"><input type="password" name="senha" maxlength="50" class="campo_padrao" style="width:240px;"/></td></tr>
								<tr><td align="right"><input type="submit" value="Entrar" class="btn_2" style="margin-top:7px;"/></td></tr>
								</form>
							</table>
							<?php
							if ( isset( $_GET['u']) && $_GET['u'] == '0'){echo"<div class='error_warning' style='margin-right: 32px;margin-top: 14px;'><p>Usu&aacute;rio ou senha inv&aacute;lida!</p>Tente novamente utilizando um nome de usu&aacute;rio e senha v&aacute;lidos.</div>";}
							?>
						</td>
					</tr>
					</table>
			</div>
	</body>
</html>			
