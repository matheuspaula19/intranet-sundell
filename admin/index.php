<?php
include("seguranca.php");
protegePagina(); // Chama a função que protege a página
?>
<html>
<head>
	<title>Intranet Sundell - Área Restrita</title>
	<link rel='shortcut icon' type='image/x-icon' href='../imgs/favicon.ico' />
	<link type="text/css" rel="stylesheet" href="../css/default.css">
	<meta charset="ISO-8859-1">
	<style type="text/css">
	h2{font-family: 'Open Sans',Trebuchet MS, Arial;font-size:21px;font-weight:normal;}
	.metro{width:180px;height:80px;border:3px solid #eee;color: #fff;text-align: left;padding: 3px;}
	.metro:hover{border:3px solid rgba(0,0,0,0.4);}
	.metro a{text-decoration: none;color:#ffffff;}
	.metro span{font-family:'Open Sans', Arial, Trebuchet MS;font-size:12px; position: absolute;margin-top: 66px;margin-left: 2px;user-select:none;-moz-user-select:none;-webkit-user-select:none;}
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
				<tr><td style="width:210px;"><a href="/"><img src="../imgs/sundell.png" border="0"/></a></td>
				<td align="right"><table id="menu"><tr><td><a href="/">Página Inicial</a> |</td><td><a href="../news.php">Notícias</a> |</td><td><a href="../empresa.php">Empresa</a></td><?php if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "admin"){echo "<td> | <a href=\"index.php\">Área do Administrador</a></td>";}else{if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "editor"){echo "<td> | <a href=\"index.php\">Área do Editor</a></td>";}else{echo "<td> | <a href=\"admin/index.php\">Entrar</a></td>";}}?>
				<td>
				<?php include('logoff_area.php'); ?>
				</td>
				</tr></table></td>
				</tr>
			</table>
			</div>
			<div style="width: 990px;min-height: 400px;" align="left">
				<h2>Área do <?php if($_SESSION['usr_Tipo'] == "admin"){echo "Administrador";}else{echo "Editor";}?></h2>
				<div align="center">
					<table>
						<tr>
						<td><a href="create.php"><div class="metro" style="background:url(imgs/add_post.png) center no-repeat #2d88ef;"><span>Adicionar Post</span></div></a></td>
						<td><a href="../news.php"><div class="metro" style="background:url(imgs/all_posts.png) center no-repeat #5133ab;"><span>Todas as Postagens</span></div></a></td>
						<?php 
						if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin'){ ?>
						<td><a href="ger_usuarios.php"><div class="metro" style="background:url(imgs/user_management.png) center no-repeat #009100;"><span>Gerenciar Usuários</span></div></a></td>
						<?php }?>
						<td><a href="adm_cadastro.php?tipo=<?php echo $_SESSION['usr_Tipo']."&edit=1&id=".$_SESSION['usr_id'];?>"><div class="metro" style="background:url(imgs/user_edit.png) center no-repeat #ae193e;"><span>Editar Perfil</span></div></a></td>
						<td><a href="seguranca.php?o=1"><div class="metro" style="background:url(imgs/log_out.png) center no-repeat #d34927;"><span>Sair</span></div></a></td>
						</tr>
					</table>
				</div>
			</div>
			
	</div>		
</body>
</html>