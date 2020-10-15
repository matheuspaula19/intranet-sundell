<?php
	session_start();

	if(isset($_GET["p"])){
		$perfil = $_GET["p"];
	}
	else{
		$perfil = '';
	}
	include("news_bd_con.php");
	$_con = new mysqli($host,$user,$pass,$banco);
	
	//verifica se h· usuarios com o id informado
	$_sql = "SELECT id, usuario, nome, tipo, foto_perfil, bio FROM news_adm WHERE usuario= '".$perfil."'";
	$_res = $_con->query($_sql);
	$_nr = $_res->num_rows;

if($_nr == 0) {
	header("Location: default.php");
	$_con->close();
}
else{
	$query = mysql_query($_sql);
	$resultado = mysql_fetch_assoc($query);
	$id = $resultado['id'];
	$nome = $resultado['nome'];
	$foto_perfil = $resultado['foto_perfil'];
	$bio = $resultado['bio'];
	$tipo = $resultado['tipo'];
	$_con->close();
}

?>
<html>
	<head>
		<title>Intranet Sundell - <?=$nome?></title>
		<link rel='shortcut icon' type='image/x-icon' href='imgs/favicon.ico' />
		<link type="text/css" rel="stylesheet" href="css/default.css">
		<script src="js/jquery.min.js?ver=3.3.1" type="text/javascript"></script>
		<!--LIGHTBOX -->
		<script src="js/lightbox.js"></script>
		<link rel="stylesheet" href="css/lightbox.css">
		<!--FIM LIGHTBOX -->
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
				<tr><td style="width:210px;"><a href="/"><img src="imgs/sundell.png" border="0"/></a></td>
				<td align="right"><table id="menu"><tr><td><a href="/">P·gina Inicial</a> |</td><td><a href="news.php">NotÌcias</a> |</td><td><a href="empresa.php">Empresa</a></td><?php if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "admin"){echo "<td> | <a href=\"admin/index.php\">¡Årea do Administrador</a></td>";}else{if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "editor"){echo "<td> | <a href=\"admin/index.php\">¡Årea do Editor</a></td>";}else{echo "<td> | <a href=\"admin/index.php\">Entrar</a></td>";}}?>
				<td>
				<?php include('logoff_area.php'); ?>
				</td>
				</tr></table></td>
				</tr>
			</table>
			</div>
			<div class="div-corpo">
			
			<table class="coltables">
				<tr>
					<td valign="top">
					<span class="col-title" style="font-size: 17px;">Perfil</span>
					<div class="widget-title">
						<table>
							<tr>
								<td rowspan="3"><a href="admin/profile_imgs/<?=$foto_perfil?>" data-lightbox="example-set" data-title="<?=$nome?>" ><img src="admin/profile_imgs/<?=$foto_perfil?>" style="border-radius: 4px;-moz-box-shadow: 0 0 20px rgba(0, 0, 0, .2);-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, .2);-goog-ms-box-shadow: 0 0 20px rgba(0, 0, 0, .2);box-shadow: 0 0 20px rgba(0, 0, 0, .2);"></a></td><td style="padding: 0px;height: 10px;"><?=$nome?><?php $usr_logado = (isset($_SESSION['usr_id'])) ? $_SESSION['usr_id'] : ''; if($usr_logado == $id){echo "&nbsp;-&nbsp;<a href='admin/adm_cadastro.php?tipo=".$tipo."&edit=1&id=".$id."' style='text-decoration: none;color: #ca2900;'>[Editar Perfil]</a>";} ?></td>
							</tr>
							<tr>
								<td style="padding: 0px;height: 10px;" colspan="3"><span style="font-size:11px;color: #bbb;line-height: 18px;"><?php if($tipo == 'admin'){echo "Editor | Administrator";}else{echo "Editor";};?></span></td>
							</tr>
							<tr>
								<td colspan="3"><span style="font-size:13px;color: #666;line-height: 18px;"><?=$bio?></span></td>
							</tr>
						</table>
					</div>
					
					</td>
				<td style="width: 302px;" valign="top">
					<span class="col-title">Tempo</span>
					<div class="widget-title">
						<?php include("weather.php"); ?>
					</div>
					<br />
					<span class="col-title">NotÌcias</span>
					<div class="widget-title">
						<ul id="sundell_news" style="padding: 0;">
						<script type="text/javascript">
						function delpost(post,id){
						var del = confirm("Deseja mesmo excluir \""+post+"\"?")
							if(del){
								location.href='admin/del_create.php?id='+id;
							}
						}
						</script>
						<?php
						$busca = mysql_query("SELECT id,titulo,imagem,autor,data,autor_nickname FROM news_tab   ORDER BY rand() LIMIT 5;");
						while($anu = mysql_fetch_array($busca)){
							$id    = $anu["id"];
							$titulo = $anu["titulo"];
							$imagem = $anu["imagem"];
							$data  = $anu["data"];
							$autor  = $anu["autor"];
							$autor_nickname  = $anu["autor_nickname"];
							if($imagem == ""){$imagem = "default_img2.png";}
							?>
							<li>
							<table>
								<tr>
									<td valign="top" style="width: 61px;"><div style="background:url(news_imgs/<?=$imagem ?>);background-size: cover;background-position: center center;width:72px;height:72px;"><a href="post.php?id=<?=$id?>"><img border="0" align="center" style="width: 100%;height: 100%;" src="imgs/b.gif" /></a></div></td>
									<td class="news_title" valign="top" align="left">
										<a href="post.php?id=<?=$id?>" style="font-size:13px;"><?=$titulo?></a><br />
										<div style="font-size:11px;color: #bbb;line-height: 18px;">Por <a href="profile.php?p=<?=$autor_nickname?>" style="text-decoration:none;color: #ca2900;"><?=$autor?></a></div><div style="font-size:11px;color: #bbb;line-height: 18px;"><?php echo strftime("%d  %b %Y - %Hh %M", strtotime($data) );  ?></div>
										<span class="post_manage"><?php if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && $autor_nickname == $_SESSION['usr_login_name']){ ?><a href="create.php?edit=1&id=<?=$id?>&u=<?=$autor_nickname?>" target="_blank"><b>Editar</b></a> |<?php } if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && ($autor_nickname == $_SESSION['usr_login_name'] || $_SESSION['usr_Tipo'] == 'admin') ){ ?><a href="#" onclick="delpost('<?=$titulo?>','<?=$id?>')"> <b>Excluir</b></a><?php } ?></span>
									</td>
								</tr>
							</table>								
							</li>
							<?php
						}
						?>
						</ul>
					</div>
				</td>
				</tr>
			</table>
			<div id="footer">
				<span><?php echo date('Y');?> Sundell Development LTDA. Todos os Direitos Reservados</span>
			</div>	
		</div>
	</body>
</html>	