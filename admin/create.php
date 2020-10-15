<?php
	include("../news_bd_con.php");//conecta ao banco
	include ("seguranca.php");// verifica se usuario est· logado
	
	////HABILITA EDI«AO////
	//verifica o usuario que deseja editar a postagem foi quem a criou
	if(isset($_GET["id"]) && isset($_GET["edit"]) && isset($_GET["u"]) && isset($_SESSION['usr_login_name'])){
		$_con = new mysqli($host,$user,$pass,$banco);
		$_sql = "SELECT autor_nickname FROM news_tab WHERE id='".$_GET["id"]."' AND autor_nickname='".$_GET["u"]."'";
		$_res = $_con->query($_sql);
		$_nr = $_res->num_rows;
		if($_nr == 1) {
			$postid	= $_GET["id"];
			$usrnick	= $_GET["u"];
			if( $_SESSION['usr_login_name'] == $usrnick){
				$editar = true;
			}
			else
			{
				$editar = false;
			}
			
			$_sql = "SELECT id, titulo, snippet, imagem, noticia, data, autor_nickname FROM news_tab WHERE id=".$postid."";
			$_res = $_con->query($_sql);
			$_nr = $_res->num_rows;
			if($_nr == 0) {
				$_con->close();
			}
			else{
				$query = mysql_query($_sql);
				$resultado = mysql_fetch_assoc($query);
				$edt_id = $resultado['id'];
				$edt_titulo = $resultado['titulo'];
				$edt_snippet = $resultado['snippet'];
				$edt_noticia = $resultado['noticia'];
				$edt_imagem = $resultado['imagem'];
				$edt_data = $resultado['data'];
				$autor = $resultado['autor_nickname'];
				$_con->close();
			}
			
		}
	}
?>
<html>
	<head>
		<title>Intranet Sundell - <?php if(isset($editar) == true){echo"Editar Postagem";}else{echo "Nova Postagem";}?></title>
		<link rel='shortcut icon' type='image/x-icon' href='../imgs/favicon.ico' />
		<link type="text/css" rel="stylesheet" href="../css/default.css">
		<script src="../js/jquery.min.js?ver=3.3.1" type="text/javascript"></script>
		<script type="text/javascript" src="../js/jquery.form.js"></script>
		<script type="text/javascript">
		function form_submit(){
			document.create.submit();
		}
		function verify(){
			var post_content = document.getElementById("post_corpo").value;
			var post_title = document.getElementById("cmp_titulo").value;
			
			if(post_content == "" && post_title == ""){
				alert("N„o foi possÌvel publicar a postagem!\n\n- Formul·rio em branco\n\n-… necess·rio preencher os campos do tÌtulo e corpo da postagem");
			}
			else{
				form_submit();
			}
		}
		</script>
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
			<div class="div-corpo">
			
			<table class="coltables">
				<tr>
					<td valign="top">
					<span class="col-title" style="font-size: 17px;"><?php if(isset($editar) == true){echo"Editar Postagem";}else{echo "Nova Postagem";}?></span>
					<!-- INICIO DO CONTEUDO -->
					<div class="widget-title">
						<?php
							if((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor')){
							?>

							<script type="text/javascript"> 
							function add_img(){
							var temp = $('#img_prev').html();
							$('#uploaded_imgs').append(temp);
							};
							$(document).ready(function(){
								$('#img_input').live('change',function(){ 
									$('#img_prev').html('<div align=\"center\" style=\"width:90px;height: 33px;padding-top: 18px;\"><img src="imgs/image_uploader.gif" alt="Enviando..."/></div>');
									$('#form_img').ajaxForm({
									success: function(response) {add_img();}, target:'#img_prev'
									}).submit();
								});
							}); 
							</script>
							<script type="text/javascript">
							function format(valor){
								document.create.corpo.value += valor+' ';
							}
							function thumb(valor){
								if(document.create.thumbnail.value == ""){
									document.create.thumbnail.value += valor;
								}
							}
							</script>
							<br />
							<table border="0" cellpadding="0" cellspacing="0" style="width: 640px;">
							<tr>
							<td valign="top">Adicionar imagens</td>
							<td>
							<form id="form_img" method="post" enctype="multipart/form-data" action="../upload.php">
								<input type="file" id="img_input" name="img_input" />
							</form>
							</td>
							</tr>
							</table>
							<table border="0" cellpadding="0" cellspacing="0" id="imgs_thumbnails" style="width: 640px;">
							<td>
							<div id="prev_img_title" style="border-bottom:2px solid #bbb;margin-top:4px;display:none;font-size: 12px;padding-bottom:2px;">Imagem Enviada</div>
							<div id="img_prev" style="height: 70px;"></div>
							<div id="add_imgs_title" style="border-bottom:2px solid #bbb;margin-top:4px;display:none;font-size: 12px;padding-bottom:2px;">Imagens Adicionadas</div>
							<ul id="uploaded_imgs" style="padding: 0;margin: 0;width: 585px;" align="center">
							<?php
							if(isset($edt_imagem) && $edt_imagem != null){
							echo "<li style=\"float:left;margin: 4px;list-style: none;\"><img src=\"../news_imgs/".$edt_imagem."\" title=\"Adicionar\" alt=\"Adicionar\" onclick=\"format(&quot;[img]news_imgs/".$edt_imagem."[/img]&quot;)\" style=\"cursor:pointer;width:90px;border-radius:3px;\"></li><div style=\"margin-top: 35px;margin-left: 4px;background: #08B80F;width: 90px;position: absolute;opacity: 0.9;color: #fff;font-size: 12px;line-height: 19px;text-align: center;\">thumbnail</div>";
							}
							
							?>
							</ul>
							</td>
							</tr>
							</table>
							<?php
							if(isset($editar) == true){
							?>
							<form method="POST" action="edit_create.php" name="create">
							<?php 
							}
							else{ ?>
							<form method="POST" action="save_create.php" name="create">
							<?php
							}
							?>
							  <table border="0" cellpadding="0" cellspacing="0" style="width: 640px;">
								<tr>
								  <td><span>TÌtulo:</span></td>
								  <td><input type="text" id="cmp_titulo" name="titulo" class="campo_padrao" size="45" style="width: 100%;" value="<?php echo (isset($edt_titulo)) ? $edt_titulo : ''; ?>"></td>
								</tr>
								<tr>
									<td>Snippet:</td>
									<td><textarea rows="15" name="snippet" cols="48" class="campo_padrao" style="width: 100%;height: 80px;resize: none;"><?php echo (isset($edt_snippet)) ? $edt_snippet : ''; ?></textarea></td>
								</tr>
								<tr>
									<td>Thumbnail:</td>
									<td>
										<input type="text" name="thumbnail" class="campo_padrao" size="45" style="width: 100%;" value="<?php echo (isset($edt_imagem)) ? $edt_imagem : ''; ?>">
									</td>
								</tr>
								<tr>
								<td><font face="Arial">Postagem:</font></td>
								 <td align="right">
									<p align="right">	
										<a href="javascript:format(&quot;[b]Texto em negrito[/b]&quot;)" style="text-decoration:none;font-family: Times new roman;padding: 0px 3px 1px 3px" class="editor_icons_bg" alt="Negrito" title="Negrito"><b>N<b></a>
										<a href="javascript:format(&quot;[i]Texto em it·lico[/i]&quot;)" class="editor_icons_bg" style="text-decoration: none;font-family:Times New Roman, Trebuchet MS;padding: 0px 5px 1px 5px;" alt="It·lico" title="It·lico"><i>I</i></a>
										<a href="javascript:format(&quot;[u]Texto sublinhado[/u]&quot;)" style="text-decoration:none;font-family: Times new roman;padding: 0px 5px 1px 5px;" class="editor_icons_bg" alt="Sublinhado" title="Sublinhado"><u>S</u></a>
										<a href="javascript:format(&quot;[br]&quot;)" style="text-decoration: none;padding: 1px 3px 0px 3px;font-family: Consolas;font-size: 14px;" class="editor_icons_bg" alt="Quebra de Par·grafo" title="Quebra de Par·grafo">&lt;br&gt;</a>
									</p>
								 </td>
								</tr>
								<tr>
								  <td colspan="2">
									<p align="center"><font face="Arial"><textarea rows="15" id="post_corpo" name="corpo" cols="48" class="campo_padrao" style="width: 100%;height: 400px;max-height: 460px !important;max-width: 632px !important;"><?php echo (isset($edt_noticia)) ? $edt_noticia : ''; ?></textarea></font></td>
								</tr>
								<?php
								if(isset($editar) == true){
								?>
								<tr><td><input type="hidden" id="postid" name="postid" value="<?=$edt_id?>" /></td></tr>
								<tr><td><input type="hidden" id="data" name="data" value="<?=$edt_data?>" /></td></tr>
								<?php
								}
								?>
								<tr><td><input type="hidden" id="autor" name="autor" value="<?=$_SESSION['usr_nome']?>" /></td></tr>
								<tr><td><input type="hidden" id="autor" name="autor_nickname" value="<?=$_SESSION['usr_login_name']?>" /></td></tr>
							  </table>
							</form>
							<table style="width: 100%;">
							<tr>
							  <td>
								<p align="center"><button onclick="verify()" class="btn_2"><?php if(isset($editar) == true){echo"Atualizar Postagem";}else{echo "Publicar Postagem";}?></button>
							  </td>
							</tr>
							</table>
							<?php
							}
							else
							{
							echo "<script>location.href='login.php'</script>";
							}
							?>
						
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
								location.href='del_create.php?id='+id;
							}
						}
					</script>
					<span class="col-title">NotÌcias</span>
					<div class="widget-title">
						<ul id="sundell_news" style="padding: 0;">
						<?php
						$busca = mysql_query("SELECT id,titulo,imagem,autor,data,autor_nickname FROM news_tab ORDER BY rand() LIMIT 5;");
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
									<td valign="top" style="width: 61px;"><div style="background:url(../news_imgs/<?=$imagem ?>);background-size: cover;background-position: center center;width:72px;height:72px;"><a href="../post.php?id=<?=$id?>"><img border="0" align="center" style="width: 100%;height: 100%;" src="../imgs/b.gif" /></a></div></td>
									<td class="news_title" valign="top" align="left">
										<a href="../post.php?id=<?=$id?>" style="font-size:13px;"><?=$titulo?></a><br />
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
	</body>
</html>	