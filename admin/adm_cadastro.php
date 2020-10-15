<?php
include ("../news_bd_con.php"); // configs do serv. mysql
$admin_ok = false;
$first_adm_usr = false;

//conecta ao banco de dados
$_con = new mysqli($host,$user,$pass,$banco);

//faz consulta para verificar se ja foi cadastrado um usu·rio administrador
$_sql = "SELECT tipo FROM news_adm WHERE tipo= 'admin'";
$_res = $_con->query($_sql);
$_nr = $_res->num_rows;
$_con->close();
if($_nr == 0) {
	//senao permite que um usuario adm inicial seja cadastrado
	$admin_ok = true;
	$first_adm_usr = true;
}

//verifica se usuario logado tem direito de cadastrar novo usuario
include ("seguranca.php");
if (isset($_SESSION['usr_id']) OR isset($_SESSION['usr_nome'])) {
	if (validaUsuario($_SESSION['usr_login'], $_SESSION['usr_senha']) && ($_SESSION['usr_Tipo'] == "admin" || (isset($_GET["edit"]) == 1 && $_SESSION['usr_id'] == $_GET["id"]))) {
		$admin_ok = true;
	}
	else{
		$admin_ok = false;
	}
}

//verifica se o usuario lgoado pode editar o perfil requerido
if(isset($_GET["id"])){
	$id = $_GET["id"];
	if(isset($_GET["edit"]) == 1 && $_SESSION['usr_id'] == $_GET["id"]){
		$_con = new mysqli($host,$user,$pass,$banco);
		$id = (isset($_GET["id"])) ? $_GET["id"] : '';
		$_sql = "SELECT id, usuario, nome, dt_nasc, tipo, foto_perfil, bio FROM news_adm WHERE id=".$id."";
		$_res = $_con->query($_sql);
		$_nr = $_res->num_rows;
		if($_nr == 0) {
			$_con->close();
			echo "nao achei o id ".$id;
		}
		else{
			$query = mysql_query($_sql);
			$resultado = mysql_fetch_assoc($query);
			$nome = $resultado['nome'];
			$user_id = $resultado['usuario'];
			$dt_nasc = $resultado['dt_nasc'];
			$mysql_date = explode("-",$dt_nasc);
			$dt_nasc = $mysql_date[2].$mysql_date[1].$mysql_date[0];
			$foto_perfil = $resultado['foto_perfil'];
			$bio = $resultado['bio'];
			$tipo = $resultado['tipo'];
			$_con->close();
		}
	}
	else{
		header("Location: ../default.php");
	}
}

?>
<html>
	<head>
		<title>Intranet Sundell - ¡rea Restrita | Cadastro</title>
		<link rel='shortcut icon' type='image/x-icon' href='../imgs/favicon.ico' />
		<link type="text/css" rel="stylesheet" href="../css/default.css" />
		<script src="../js/jquery.min.js?ver=3.3.1" type="text/javascript"></script>
		<script type="text/javascript" src="../js/jquery.form.js"></script>
		<script type="text/javascript" src="../js/jquery.maskedinput.min.js"></script>
		<meta charset="ISO-8859-1">
		<script type="text/javascript">
			function ver_username(campo){
				var temp = document.getElementById(campo).value;
				if(temp.indexOf("\"") != -1 || temp.indexOf("'") != -1 || temp.indexOf("(") != -1 || temp.indexOf(")") != -1 || temp.indexOf("/") != -1 || temp.indexOf("\\") != -1 || temp.indexOf(" ") != -1 || temp.length == 0)
				{return true;}else{return false;document.getElementById('war_1').style.opacity = '0.0';}
			}
			function ver_password(campo){
				var temp = document.getElementById(campo).value;
				if(temp.indexOf(" ") != -1 || temp.length < 8)
				{return true;}else{return false;document.getElementById('war_1').style.opacity = '0.0';}
			}
			function form_submit(){
			pass_comp();
			if(ver_password('cmp_senha') == false && ver_username('cmp_usuario') == false && pass_comp() == true){
				document.form1.submit();
				}
				else{document.getElementById('war_1').style.opacity = '1.0';}
			}
			function pass_comp(){
				if(document.getElementById('cmp_senha').value == document.getElementById('cmp_senha2').value){
				return true;}else{ document.getElementById('war_2').style.opacity = '1.0';return false;}
			}
			
			jQuery(function($){ 
			   $("#cmp_dt_nasc").mask("99/99/9999"); 
			}); 
		</script>
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
		<div class="div-corpo">
			<table class="coltables">
				<tr>
					<td valign="top">
					<span class="col-title" style="font-size: 17px;">
					<?php
						if(isset($_GET["edit"]) == 1 && $_SESSION['usr_id'] == $_GET["id"]){
							echo"Editar Perfil";
						}
						else{
							if( isset( $_GET['tipo']) && $_GET['tipo'] == 'admin' && $admin_ok == true && $first_adm_usr == true){echo"Cadastro de Usu·rio Administrador";}
							else{
								if( isset( $_GET['tipo']) && $_GET['tipo'] == 'admin' && $admin_ok == true && $first_adm_usr == false){echo"Cadastro de Usu·rio Administrador";}
								else{
									if( isset( $_GET['tipo']) && $_GET['tipo'] == 'editor' && $admin_ok == true) {echo"Cadastro de Editor";}
								}
							}
						}
					?>
					</span>
					<!-- INICIO DO CONTEUDO -->
					<div class="widget-title">
			
							<div align="center">

							<!-- Suspenso com a info do usuario -->
							<div align="center" class="content">
								<table class="txt_form_padrao" style="margin-left: 10px;">
									<?php
										if(isset($_GET["id"]) && isset($_GET["edit"]) == 1 && $_SESSION['usr_id'] == $_GET["id"]){
										$edittag = "&id=".$_GET["id"];
										}
										else{
										$edittag = "";
										}
										if( isset( $_GET['tipo']) && $_GET['tipo'] == 'admin' && $admin_ok == true){ echo'<form method="post" id="form1" name="form1" action="cadastro_usuario.php?tipo=admin'.$edittag.'">';}
										else{ echo'<form method="post" id="form1" name="form1" action="cadastro_usuario.php?tipo=editor'.$edittag.'">';}
									
										if($admin_ok == true){
									?>
									<tr><td colspan="2" class="error_warning" id="war_1" style="opacity:0;">A senha e nome de usu·rrio n„o devem possuir espaÁos e os segintes caracteres n„o podem ser utilizados: &#39;, &#92;, &#47;, &#40;, &#41; e ".</td></tr>
									<tr><td colspan="2">Nome</td></tr>
									<tr><td colspan="2"><input type="text" name="nome" maxlength="50" class="campo_padrao" value="<?php echo (isset($nome)) ? $nome : ''; ?>" style="width:350px;"/></td></tr>
									<tr><td colspan="2">Data de Nascimento</td></tr>
									<tr><td colspan="2"><input type="text" name="dt_nasc" maxlength="50" id="cmp_dt_nasc" value="<?php echo (isset($dt_nasc)) ? $dt_nasc : ''; ?>" class="campo_padrao" style="width:350px;"/></td></tr>
									<tr><td colspan="2">Nome de usu·rio (apenas letras ou n˙meros)</td></tr>
									<tr><td colspan="2"><input type="text" name="usuario" maxlength="50" id="cmp_usuario" value="<?php echo (isset($user_id)) ? $user_id : ''; ?>" class="campo_padrao" onkeyup="ver_username('cmp_usuario')" style="width:350px;"/></td></tr>
									<tr><td colspan="2">Bio (no m·ximo 180 caracteres)</td></tr>
									<tr><td colspan="2"><textarea rows="15" name="cmp_bio" cols="18" class="campo_padrao"  maxlength="180" style="height: 100px;resize:none;width: 350px !important;"><?php echo (isset($bio)) ? $bio : ''; ?></textarea></td></tr>
									<tr><td colspan="2">Senha (no mÌnimo 8 caracteres)</td></tr>
									<tr><td colspan="2"><input type="password" name="senha" maxlength="50" id="cmp_senha" class="campo_padrao"  onkeyup="ver_password('cmp_senha')" style="width:350px;"/></td></tr>
									<tr><td colspan="2">Repita a senha&nbsp;<span id="war_2" style="color:#ca2900;opacity:0.00;">&nbsp;As senhas n„o correspondem!</span></td></tr>
									<tr><td colspan="2"><input type="password" name="senha2" maxlength="50" id="cmp_senha2" class="campo_padrao"  onkeyup="ver_password('cmp_senha2')" style="width:350px;"/></td></tr>
									<?php
									if(isset($_GET["edit"]) == 1 && $_SESSION['usr_id'] == $id){
										echo "<tr><td><input type=\"hidden\" id=\"user_ico\" name=\"cmp_pic\" value=\"".$_SESSION['usr_pic']."\" /></td></tr>";
									}
									else{
										if( isset( $_GET['tipo']) && $_GET['tipo'] == 'admin' && $admin_ok == true){
											echo "<tr><td><input type=\"hidden\" id=\"user_ico\" name=\"cmp_pic\" value=\"admin_ico.png\" /></td></tr>";
										}
										else{ 
											echo "<tr><td><input type=\"hidden\" id=\"user_ico\" name=\"cmp_pic\" value=\"user_ico.png\" /></td></tr>"; 
										}
									}	
									?>
									</form>
									<tr><td colspan="2">Adicionar imagem de perfil:</td></tr>
									<tr>
										<td style="min-height:63px;"><div id="img_prev"></div>
										<?php
										if(isset($_GET["edit"]) == 1 && $_SESSION['usr_id'] == $id){
											echo "<img src=\"profile_imgs/".$_SESSION['usr_pic']."\" id=\"default_user_ico\" style=\"width:50px;border-radius:3px;\" />";
										}
										else{
											if( isset( $_GET['tipo']) && $_GET['tipo'] == 'admin' && $admin_ok == true){
												echo "<img src=\"profile_imgs/admin_ico.png\" id=\"default_user_ico\" style=\"width:50px;border-radius:3px;\" />";
											}
											else{
												echo "<img src=\"profile_imgs/user_ico.png\" id=\"default_user_ico\" style=\"width:50px;border-radius:3px;\" />";
											}
										}	
										?>
										</td>
										<td>
											<script type="text/javascript"> 
											function removedefault(){
												$('#default_user_ico').remove();
											};
											$(document).ready(function(){
												$('#img_input').live('change',function(){ 
													$('#default_user_ico').remove();
												    $('#img_prev').html('<div align=\"center\" style=\"width:50px;height: 32px;padding-top: 18px;\"><img src="imgs/image_uploader.gif" alt="Enviando..."/></div>');
													$('#form_img').ajaxForm({ 
													success: function(response) {removedefault();}, target:'#img_prev'
													}).submit();
												});
											}); 
											</script>
											<form id="form_img" method="post" enctype="multipart/form-data" action="profile_photo_uploader.php"><input type="file" id="img_input" name="img_input" /></form>
										</td>
										<td align="right" style="height: 50px;"><a href="#" class="btn_2"  style="font-family: 'Trebuchet MS', Arial;font-size: 14px;text-decoration: none;" onclick="form_submit()"/><?php if(isset($_GET["edit"])){echo"Atualizar";}else{echo "Cadastrar";} ?></a></td>
									</tr>
									<?php
									}
									else{
										echo"<tr><td align=\"center\"><img src='imgs/access_denied.png' alt='Acesso Negado'></td></tr>";
										echo "<tr><td align=\"center\"><h2 style=\"font-family: 'Trebuchet MS', Arial;color: #bbb;font-size: 17px;\">Acesso Negado!</h2></td></tr>";
										echo"<tr><td><br /><a  class='btn_2' href='javascript:history.back(1)' style='white-space: nowrap;text-decoration: none;font-size: 14px;'>Voltar para a p·gina anterior</a></td></tr>";
									}
									?>
								</table>
								
								
							</div>
						</div>	
					</div>
					</td>
					<td style="width: 302px;" valign="top">
						<span class="col-title">Tempo</span>
						<div class="widget-title">
							<?php include("weather.php"); ?>
						</div>
					<br />
					<script type="text/javascript">
						function delpost(post,id){
						var del = confirm("Deseja mesmo excluir \""+post+"\"?")
							if(del){
								location.href='admin/del_create.php?id='+id;
							}
						}
					</script>
					<span class="col-title">NotÌcias</span>
					<div class="widget-title">
						<ul id="sundell_news" style="padding: 0;">
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
									<td valign="top" style="width: 61px;"><div style="background:url(../news_imgs/<?=$imagem ?>);background-size: cover;background-position: center center;width:72px;height:72px;"><a href="post.php?id=<?=$id?>"><img border="0" align="center" style="width: 100%;height: 100%;" src="../imgs/b.gif" /></a></div></td>
									<td class="news_title" valign="top" align="left">
										<a href="post.php?id=<?=$id?>" style="font-size:13px;"><?=$titulo?></a><br />
										<div style="font-size:11px;color: #bbb;line-height: 18px;">Por <a href="../profile.php?p=<?=$autor_nickname?>" style="text-decoration:none;color: #ca2900;"><?=$autor?></a></div><div style="font-size:11px;color: #bbb;line-height: 18px;"><?php echo strftime("%d  %b %Y - %Hh %M", strtotime($data) );  ?></div>
										<span class="post_manage"><?php if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && $autor_nickname == $_SESSION['usr_login_name']){ ?><a href="create.php?edit=1&id=<?=$id?>&u=<?=$autor_nickname?>" target="_blank"><b>Editar</b></a> |<?php } if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && ($autor_nickname == $_SESSION['usr_login_name'] || $_SESSION['usr_Tipo'] == 'admin') ){ ?><a href="#" onclick="delpost('<?=addslashes($titulo)?>','<?=$id?>')"> <b>Excluir</b></a><?php } ?></span>
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
	</div>	
	</body>
</html>		