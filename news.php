<?php
	session_start();
	include("news_bd_con.php");
	
	if(isset($_GET["p"])){
		$pagina = $_GET["p"];
	}
	else{
		$pagina = 1;
	}
	$busca = "SELECT * FROM news_tab order by -id";
	$total_reg = $config_paginacao; // numero de registros por p?ina
	if ($pagina=="") {
		$pagina = "1";
		$pc = "1";
	} else {
		$pc = $pagina;
	}
	$inicio = $pc - 1;
	$inicio = $inicio * $total_reg;
	$limite = mysql_query("$busca LIMIT $inicio,$total_reg");
	$todos = mysql_query("$busca");

	$tr = mysql_num_rows($todos);


?>
<html>
	<head>
		<title>Intranet Sundell - Notícias</title>
		<link rel='shortcut icon' type='image/x-icon' href='imgs/favicon.ico' />
		<link type="text/css" rel="stylesheet" href="css/default.css">
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
				<td align="right"><table id="menu"><tr><td><a href="/">Página Inicial</a> |</td><td><a href="news.php">Notícias</a> |</td><td><a href="empresa.php">Empresa</a></td><?php if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "admin"){echo "<td> | <a href=\"admin/index.php\">Área do Administrador</a></td>";}else{if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "editor"){echo "<td> | <a href=\"admin/index.php\">Área do Editor</a></td>";}else{echo "<td> | <a href=\"admin/index.php\">Entrar</a></td>";}}?>
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
					<span class="col-title" style="font-size: 17px;">Notícias</span>
					<div class="widget-title">
						<script type="text/javascript">
						function delpost(post,id){
						var del = confirm("Deseja mesmo excluir \""+post+"\"?")
							if(del){
								location.href='admin/del_create.php?id='+id;
							}
						}
						</script>
						<ul id="sundell_news" style="padding: 0;">
						<?php
						if($tr>0){
							 // verifica o numero total de registros
							$tp = $tr / $total_reg; // verifica o numeero total de paginas
						$cont = 1;//controla borda inferior do post
						while($anu = mysql_fetch_array($limite)){
							$id    = $anu["id"];
							$titulo = $anu["titulo"];
							$snippet = $anu["snippet"];
							$imagem = $anu["imagem"];
							$data  = $anu["data"];
							$autor  = $anu["autor"];
							$autor_nickname = $anu["autor_nickname"];
							if($imagem == ""){$imagem = "default_img3.png";}
							?>
							<li>
							<table>
								<tr>
									<td valign="top" style="width: 61px;"><div style="background:url(news_imgs/<?=$imagem ?>);background-size: cover;background-position: center center;width:180px;height:101px;"><a href="post.php?id=<?=$id?>"><img border="0" align="center" style="width: 100%;height: 100%;" src="imgs/b.gif" /></a></div></td>
									<td class="news_title" valign="top" align="left">
										<a href="post.php?id=<?=$id?>" style="font-size:15px;" target="_blank"><?=$titulo?></a><span class="post_manage"><?php if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && $autor_nickname == $_SESSION['usr_login_name']){ ?><span style="color:#ccc;font-size:12px;"> - </span><a href="admin/create.php?edit=1&id=<?=$id?>&u=<?=$autor_nickname?>" target="_blank"><b>Editar</b></a> |<?php }else{echo" -  ";} if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && ($autor_nickname == $_SESSION['usr_login_name'] || $_SESSION['usr_Tipo'] == 'admin') ){ ?><a href="#" onclick="delpost('<?=addslashes($titulo)?>','<?=$id?>')"> <b>Excluir</b></a><?php } ?></span>
										<br /><div style="font-size:11px;color: #666;min-height: 42px;padding: 3px;"><?=$snippet?></div>
										<div style="font-size:11px;color: #bbb;line-height: 18px;">Por <a href="profile.php?p=<?=$autor_nickname?>" style="text-decoration:none;color: #ca2900;"><?=$autor?></a></div><div style="font-size:11px;color: #bbb;line-height: 18px;"><?php echo strftime("%d  %b %Y - %Hh %M", strtotime($data) );  ?></div>	
									</td>
								</tr>
								<?php
								if($total_reg != $cont){
								?>
								<tr><td colspan="2" style="width: 640px;height: 14px;border-bottom:1px solid #eee;"></tr>
								<?php
								}
								?>
							</table>								
							</li>
						<?php
						$cont++;
						}?>
						</ul>
						<table width="100%" id="post_footer">
							<tr>
								<?php
									$anterior = $pc -1;
									$proximo = $pc +1;
									if ($pagina>1) {
										echo "<td align=\"left\"><a href='?p=$anterior'  style=\"color:#ca2900;font-size:12px;text-decoration:none;\">Página Anterior</a></td>";
									}
									else{
										echo "<td align=\"left\"><span style=\"color:#ccc;font-size:12px;\">Página Anterior</span></td>";
									}
									echo "<td align=\"center\"><span style=\"color:#999;font-size:12px;\"><b>Página $pagina de ".ceil($tp)."</b></span></td>";
									if ($pagina<$tp) {
										echo "<td align=\"right\"><a href='?p=$proximo' style=\"color:#ca2900;font-size:12px;text-decoration:none;\">Próxima página</a></td>";
									}
									else
									{
									echo "<td align=\"right\"><span style=\"color:#ccc;font-size:12px;\">Próxima página</span></td>";
									}
									}
								?>
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
					<span class="col-title">Outras Notícias - g1.com | Tecnologia</span>
					<div id="latest-news" class="widget-title" style="width: 290px;">
						<?php
						if (!$sock = @fsockopen('g1.globo.com', 80, $num, $error, 5)) {
						echo "<p>Não foi possível obter dados do servidor de notícias</p>";
						}
						else{
							$feed = file_get_contents('http://g1.globo.com/dynamo/tecnologia/rss2.xml');
							$feed = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $feed);
							$rss = new SimpleXmlElement($feed);
							$i =0;
							foreach($rss->channel->item as $entrada) {
								$i++;
								if($i <= 3){
								echo '<div><div class="news_title"><a href="' . $entrada->link . '" title="'.utf8_decode($entrada->title).'" target="_blank">' . utf8_decode($entrada->title) . '</a></div>';
								echo '<div class="news_desc">'. strip_tags(str_replace("_", "", utf8_decode($entrada->description))) .'</div></div>';
								}else{
								break;
								}
							}
						}	
						?>
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