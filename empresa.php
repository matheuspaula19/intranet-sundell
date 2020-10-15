<?php
	session_start();
	include("news_bd_con.php");	
?>
<html>
	<head>
		<title>Intranet Sundell - Empresa</title>
		<link rel='shortcut icon' type='image/x-icon' href='imgs/favicon.ico' />
		<link type="text/css" rel="stylesheet" href="css/default.css">
		<!--LIGHTBOX -->
		<script src="js/jquery.min.js?ver=3.3.1" type="text/javascript"></script>
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
					<td colspan="2" style="height: 300px;width: 668px;" valign="top">
					<span class="col-title">Sobre a Empresa</span>
					<div class="widget-title">
						<div style="text-align:justify;">
							<div><a href="imgs/sundell_logo1.png" data-lightbox="example-set" data-title="Logo Sundell Development"><img src="imgs/sundell_logo1.png" border="0"></a></div>
							<p>A Sundell development fundada em 2010, tem como objetivo suprir a necessidade de empresas de pequeno e médio porte com serviços de qualidade em curto prazo.</p>
							<p>Nossa empresa surgiu em um mercado ávido por metodologias tradicionais de desenvolvimento de software, que eram baseadas em processos pesados e caras certificações, a Sundell arriscou-se em uma nova abordagem acreditando cegamente que o valor gerado para seus clientes poderia ser muito maior do que o mercado vinha oferecendo. A Sundell iniciava uma profunda mudança no modo como operava e gerava resultados para seus clientes.</p>					
							<p>Desta forma procuramos desenvolver soluções com alto nível de tecnologia, que visam aumentar a produtividade, qualidade, reduzir custo, integrar múltiplas tecnologias acelerando o processo de tomada de decisão e assessoria de nossos clientes.</p>
							<p>Estamos inovando através de projetos para algumas empresas em soluções de mobilidade voltadas a celular, hiPaq, BlackBerry, Smart Phone, iPhone, iPad e outros dispositivos com intuito de agilizar o processo das empresas com soluções corporativas para facilitar a gestão de informações e tomada de decisões dos executivos.</p>
						</div>
					</div>
					</td>
					<td style="height: 300px;width: 316px;" valign="top">
					<span class="col-title">Tempo</span>
					<div class="widget-title">
						<?php include("weather.php"); ?>
					</div>
					<br />

					<span class="col-title">Notícias</span>
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
										<span class="post_manage"><?php if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && $autor_nickname == $_SESSION['usr_login_name']){ ?><a href="admin/create.php?edit=1&id=<?=$id?>&u=<?=$autor_nickname?>" target="_blank"><b>Editar</b></a> |<?php } if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && ($autor_nickname == $_SESSION['usr_login_name'] || $_SESSION['usr_Tipo'] == 'admin') ){ ?><a href="#" onclick="delpost('<?=addslashes($titulo)?>','<?=$id?>')"> <b>Excluir</b></a><?php } ?></span>
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