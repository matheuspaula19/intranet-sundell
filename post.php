<?php
	session_start();
	include("news_bd_con.php");
	$_con = new mysqli($host,$user,$pass,$banco);
	$_sql = "SELECT * FROM news_tab WHERE id='".$_GET["id"]."'";
	$_res = $_con->query($_sql);
	$_nr = $_res->num_rows;
	if($_nr == 0) {
		$id_exists = false;
		$_con->close();
		header("Location: default.php");
	}
	else{
		$_con->close();
		$id_exists = true;
	}
	
	if(isset($_GET["id"]) && $id_exists == true){

	$busca = mysql_query("SELECT * FROM news_tab WHERE id='".$_GET["id"]."'");
	$anu = mysql_fetch_array($busca);
	$id    = $anu["id"];
	$titulo = $anu["titulo"];
	$texto = $anu["noticia"];
	$autor  = $anu["autor"];
	$autor_nickname  = $anu["autor_nickname"];

	$post_img_url = str_replace("[img]","",$texto);
	$post_img_url = substr($post_img_url,0,strrpos($post_img_url,"[/img]"));

	//chama funÁ„o para tratar as imagens do post
	$texto = imguntagger($texto,$titulo);
	$texto = nl2br($texto);
	$texto  = str_replace("[b]","<b>",$texto);
	$texto  = str_replace("[i]","<i>",$texto);
	$texto  = str_replace("[u]","<u>",$texto);
	$texto  = str_replace("[/b]","</b>",$texto);
	$texto  = str_replace("[/i]","</i>",$texto);
	$texto  = str_replace("[/u]","</u>",$texto);
	$texto  = str_replace("[br]","<br>",$texto);
	$texto  = str_replace("]",">",$texto);
	$texto  = str_replace("[","<",$texto);

	$data  = $anu["data"];
	}
	else{
		header("Location: /");
	}
	
	function imguntagger($post,$posttitle){
		//declara a variavel com o valor inicial de imagens encontradas
		$imgs_count = substr_count($post,"[img]",0);
		//declara a variavel temp_layer para evitar warnings
		$temp_layer = "";
		
		do{
			//conta quantas imagens restam no post
			$imgs_count = substr_count($post,"[img]");
			
			//separa exatamente a url da imagem dos separadores [img]
			$cur_img_url = substr($post,strpos($post,"[img]"),strpos($post,"[/img]"));
			$cur_img_array = explode('[img]',$cur_img_url);
			$cur_img_url = $cur_img_array[1];
			$cur_img_array = explode('[/img]',$cur_img_url);
			$cur_img_url = $cur_img_array[0];
			$cur_img_url = str_replace("[","",$cur_img_url);
			
			//monta a tag html da imagem
			$novourl = "<center><a href=\"".$cur_img_url."\" data-lightbox=\"example-set\" data-title=\"".$posttitle."\"><img width=\"80%\" src=\"".$cur_img_url."\"></a></center>";
			
			//remove as tags [img] do post
			$post = str_replace("[img]".$cur_img_url."[/img]","",$post);//remove imagem ja encontrada da string 1
			
			//atualiza o layer temporario do post
			$temp_layer = $temp_layer.$novourl;
		}while($imgs_count > 1);
		
		//atualiza o post com os dados do layer e retorna os dados
		$post = $temp_layer.$post;
		return $post;
	}
?>
<html>
	<head>
		<title>Intranet Sundell - <?=$titulo?></title>
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
		<script type="text/javascript">
			function delpost(post,id){
			var del = confirm("Deseja mesmo excluir \""+post+"\"?")
				if(del){
					location.href='admin/del_create.php?id='+id;
				}
			}
		</script>
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
						<span class="col-title" style="font-size: 17px;"><?=$titulo?></span>
						<div class="widget-title" style="max-width: 652px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<?php
							
							if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin'){ ?>
							  <tr>
								<td width="100%" style="background: #fff699;border-radius: 3px;border-bottom: 2px solid rgba(0,0,0,0.2);">
								  <p align="left">
								  <font face="Arial" size="2"><b>Administrador:</b>
								  <a href="admin/create.php" target="_blank"><font color="#000000">Criar Nova Postagem</font></a>
								  <?php
								  if($autor_nickname == $_SESSION['usr_login_name']){
								  ?>
								  - <a href="admin/create.php?edit=1&id=<?=$id?>&u=<?=$autor_nickname?>" target="_blank"><font color="#000000">Editar</font></a>
								  <font color="#000000"> - </font>
								  <a href="#" onclick="delpost('<?=$titulo?>','<?=$id?>')""><font color="#000000">Excluir</font></a>
								  <?php
								  }
								  ?>
								  <font color="#000000"> - </font><a href="admin/seguranca.php?o=1"><font color="#000000">Log Out</font></a></font>
								</td>
							  </tr>

							<?php } ?>
							</table>
							
							<div id="post_body">
								<div>
									<?=$texto?>
								</div>
							</div>
							<div id="post_footer">
								<div>
									<i><?php echo "Por <a href=\"profile.php?p=".$autor_nickname."\" style=\"text-decoration:none;color: #ca2900;\">".$autor."</a> em ".date('d/m/Y ‡\s h:m',strtotime($data)) ?></i>
								</div>
							</div>

							</div>
						
					</td>
				<td style="width: 302px;" valign="top">
					<span class="col-title">Tempo</span>
					<div class="widget-title">
						<?php include("weather.php"); ?>
					</div>
					<span class="col-title">Outras NotÌcias</span>
					<div class="widget-title">
						<ul id="sundell_news" style="padding: 0;">
						<?php
						$busca = mysql_query("SELECT id,titulo,imagem,autor,data,autor_nickname FROM news_tab WHERE NOT (id = ".$id.") ORDER BY rand() LIMIT 5;");
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
										<?php
										if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && $autor_nickname == $_SESSION['usr_login_name']){ ?><div class="post_manage"><a href="admin/create.php?edit=1&id=<?=$id?>&u=<?=$autor_nickname?>" target="_blank"><b>Editar</a> | <a href="#" onclick="delpost('<?=addslashes($titulo)?>','<?=$id?>')">Excluir</b></a></div><?php } ?>
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