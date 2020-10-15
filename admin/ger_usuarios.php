<?php
include ("../news_bd_con.php"); // configs do serv. mysql
include ("seguranca.php");
protegePagina();
error_reporting(0);
?>
<html>
<head>
		<title>Intranet Sundell - Gerenciamento de Usu·rios</title>
		<link rel='shortcut icon' type='image/x-icon' href='../imgs/favicon.ico' />
		<link type="text/css" rel="stylesheet" href="../css/default.css" />
		<style type="text/css">
		#tab_usuarios {padding:0;margin:0;background:#ffffff;border:2px solid #ccc;width: 990px;}
		#tab_usuarios td{padding: 8px 4px 8px 4px;cursor:default;}
		#tab_usuarios tr{background:#ffffff;}
		#tab_usuarios tr a{color:#000000;}
		#tab_usuarios tr:hover{background:#00b5fe !important;color:#ffffff !important;}
		#tab_usuarios tr:hover a{color:#ffffff;}
		#tab_usuarios .delete_btn{padding-left: 18px;background:url(imgs/trash_ico.png) 0 no-repeat;cursor:pointer;}
		#tab_usuarios tr:hover .delete_btn{background:url(imgs/trash_ico.png) -15px no-repeat;}
		#tab_usuarios .delete_btn a{text-decoration:none;color:#000000;}
		.metrolink{text-decoration: none;padding: 5px 8px 5px 20px;color: #fff;font-size: 12px;border: 2px solid transparent;}
		.metrolink:hover{border: 2px solid rgba(0,0,0,0.2);}
		</style>
		<script type="text/javascript" src="../js/popup_warning.js"></script>
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
		<td align="right"><table id="menu"><tr><td><a href="/">P·gina Inicial</a> |</td><td><a href="../news.php">NotÌcias</a> |</td><td><a href="../empresa.php">Empresa</a></td><?php if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "admin"){echo "<td> | <a href=\"index.php\">¡Årea do Administrador</a></td>";}else{if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "editor"){echo "<td> | <a href=\"index.php\">¡Årea do Editor</a></td>";}else{echo "<td> | <a href=\"admin/index.php\">Entrar</a></td>";}}?>
		<td>
		<?php include('logoff_area.php'); ?>
		</td>
		</tr></table></td>
		</tr>
	</table>
	</div>
	<div style="width: 990px;" align="left">
		<?php
		if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin'){
		?>
		<table style="height: 45px;width: 990px;"><tr><td><p class="col-title">Gerenciar usu·rios</p></td><td></td><td align="right"><a href="adm_cadastro.php?tipo=admin" style="background:url(imgs/plus_ico.png) 2px no-repeat #2e7fdc;" class="metrolink">Adicionar Administrador</a></td><td align="right" style="width: 130px;"><a href="adm_cadastro.php?tipo=editor" style="background:url(imgs/plus_ico.png) 2px no-repeat #058e05;" class="metrolink">Adicionar Editor</a></td></tr></table>
		<?php
		}
		function formatodata($data)
		{
			return substr($data,8,2)."/".substr($data,5,2)."/".substr($data, 0, 4);
		}
		function tipo_usr($tipo){
			if($tipo == "admin"){
				return "Administrador";
			}
			else{
				return "Editor";
			}
		}
		if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin'){
			$_con = new mysqli($host,$user,$pass,$banco);
			$_sql = "SELECT nome,usuario,tipo,dt_criacao,id FROM news_adm";
			$_res = $_con->query($_sql);
			if($_res === FALSE){
				echo "Erro na consulta";
			}
			else{
				$_nr = $_res->num_rows;
				if($_nr > 0){
					echo "<table id='tab_usuarios' cellpadding='0' cellspacing='0'><tr style='background:#ffffff !important;color:#000000 !important;'><td>N∫</td><td>Nome</td><td>Nome de Usu·rio</td><td>Tipo</td><td>Data de CriaÁ„o</td></tr>";
					$pos = 1;
					while($_row=$_res->fetch_assoc()){
						$col = 1;
						$eraseok = false;
						$eraseok_byuser = false;
						echo "<tr>";
						foreach($_row as $_vlr){
						if($col == 1){
							echo "<td>$pos</td>";
						}
						if($col == 2 && $_vlr == $_SESSION['usr_login']){
							$eraseok_byuser = true;
						}
						if($col == 4){
							echo "<td style=\"width:110px;\">".formatodata($_vlr)."</td>";
						}
						else{
							if($col == 3){
								echo "<td>".tipo_usr($_vlr)."</td>";
								if($_vlr == 'admin'){
									$eraseok = false;
								}else{
									$eraseok = true;
								}
							}
							else{
								if($col == 5 && ($eraseok == true || $eraseok_byuser == true)){
									echo "<td class='delete_btn' onclick=\"popup_show('Deletar Registro','VocÍ realmente deseja deletar este usu·rio?','".$_vlr."','ger_usuarios.php?del=".$_vlr."','1');\">Apagar</td>";
								}
								else{
									if($col != 5){
										if($col == 2)
										{
											echo "<td><a href='../profile.php?p=".$_vlr."'>$_vlr</a></td>";
										}
										else{
										echo "<td>$_vlr</td>";
										}
									}
									else{
										echo "<td></td>";
									}
								}
							}
						}
						$col++;
						}
						echo "</tr>";
						$pos++;
					}
					echo "</table>";
				}
			}
			$_con->close();
		}
		else{
			echo"<table style='width:990px;height:360px;margin-top:3%;'><tr><td><h2>VocÍ n„o tem permis„o para gerenciar usu·rios.</h2></td><td style='border-left:1px solid #ddd;'><table style='margin-left: 10px;'><tr><td align=\"center\"><img src='imgs/access_denied.png' alt='Acesso Negado'></td></tr>";
			echo"<tr><td><br /><a style=\"whitespace:nowrap;text-decoration: none;font-size: 14px;white-space: nowrap;\" class=\"btn_2\" href='javascript:history.back(1)' >Voltar para a p·gina anterior</a></td></tr></table></td></tr></table>";
		}		
		?>
	</div>	
	<div style="padding:10px;">
		<span><?php echo date('Y');?> Sundell Development LTDA. Todos os Direitos Reservados</span>
	</div>	
<div id='popup_main' align='center'></div>
<?php
	if (isset( $_GET['del']) && isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin'){
		$_con = new mysqli($host,$user,$pass,$banco);
		$expulsar = false;
		$_sql = "SELECT usuario from news_adm where id=".$_GET['del'];
		$_res = $_con->query($_sql);
		$_row = $_res->fetch_assoc();
		echo $_row['usuario'];
		if($_row['usuario'] == $_SESSION['usr_login']){
			$expulsar = true;
		}

		$_sql = "DELETE from news_adm where id=".$_GET['del'];
		$_res = $_con->query($_sql);
		if($_res === FALSE){
			echo"<script>popup_show('Deletar Usu·rio','N„o foi possÌvel excluir o registro!','','ger_usuarios.php','2');</script>";
		}
		else{
			echo"<script>popup_show('Deletar Usu·rio','O usu·rio foi excluÌdo com sucesso!','','ger_usuarios.php','2');</script>";
		}
		if($expulsar == true){
			$_con->close();
			encerra_sessao();
		}
	}
?>
</body>
</html>
			