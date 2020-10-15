<?php 
	session_start(); 
	include("news_bd_con.php");
?>
<html>
	<head>
		<title>Intranet Sundell - P·gina Inicial</title>
		<link rel='shortcut icon' type='image/x-icon' href='imgs/favicon.ico' />
		<link type="text/css" rel="stylesheet" href="css/default.css">
		<script src="js/jquery.min.js?ver=3.3.1" type="text/javascript"></script>
		<script src="js/bgcarousel.js" type="text/javascript">
		/***********************************************
		* Background Image Carousel- © Dynamic Drive (www.dynamicdrive.com)
		* This notice MUST stay intact for legal use
		* Visit http://www.dynamicdrive.com/ for this script and 100s more.
		***********************************************/
		</script>
		<script type="text/javascript">
		/* aciona a pesquisa ao se pressionar enter */
		function pesquisa_enter(){
			if (event.keyCode == 13){
			search_option();
			}
		}
		
		/* escolhe o tipo de pesquisa*/
		function search_option(){
			var sel = document.getElementById("search_option_form").search_option.value;
			if(sel == "bing" || sel == "google" || sel == "yahoo"){
				internet_search(sel);
			}
			else{
				if(sel == "intranet"){
					search();
				}
			}
		}
		
		/* pesquisa na internet*/
		function internet_search(site){
			var pesquisar = document.getElementById("search_box").value;
			pesquisar = pesquisar.replace(/ /gi, "+");
			if(pesquisar != "")
			{
				if(site == "google"){
					window.open("http://www.google.com.br/search?q="+pesquisar,'_blank');
				}
				else{
					if(site == "bing"){
						window.open("http://www.bing.com/search?q="+pesquisar,'_blank');
					}
					else{
						if(site == "yahoo"){
							window.open("http://br.search.yahoo.com/search;_ylt=Ajbsafe3WH0467J0426I90GU7q5_?p="+pesquisar,'_blank');
						}
					}
				}								
			}
			else{
				alert("Digite algo para poder pesquisar!");
			}
		}
		
		/* pesquisa na intranet*/
		function search(){
			var pesquisar = document.getElementById("search_box").value;
			pesquisar = pesquisar.replace("+", "%2B");
			pesquisar = pesquisar.replace(/ /gi, "%20");
			if(pesquisar != "")
			{
				window.open("search.php?q="+pesquisar,'_self');
			}
			else{
				alert("Digite algo para poder pesquisar!");
			}
		}
		</script>
		<meta charset="ISO-8859-1">
		<style type="text/css" media="all">
		/*Conserta bug do menu */
		#nav li ul {z-index: 4!important;}

		#destaques_principais{
		margin:5px 0px 10px 5px;
		width: 616px;
		-webkit-box-shadow: 0 1px 3px 0 rgba(0,0,0,.2);
		box-shadow: 0 1px 3px 0 rgba(0,0,0,.2);
		}

		div.bgcarousel{ 
		background: black url(imgs/ajax-loader.gif) center center no-repeat;
		width:647px;
		height:330px;
		}

		img.navbutton{
		top:122px !important;
		margin:5px;
		opacity:0.5;
		-moz-transition: all .3s ease-in-out;
		-ms-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		-webkit-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out;
		}

		img.navbutton:hover{ 
		margin:5px;
		opacity:0.9;
		}

		div.slide{
		background-color: black;
		background-position: center center; 
		background-repeat: no-repeat;
		background-size: cover; 
		color: black;
		}

		div.slide div.desc{ 
		position: absolute;
		color: white;
		left: 0px;
		top: 248px;
		width:600px;
		padding: 10px;
		font-family: 'Open Sans',Arial,Helvetica;
		text-shadow: 1px 1px rgba(0,0,0,.9);
		white-space:pre-wrap;
		z-index:1;
		}

		div.slide div.desc h9{
		font-size:140%;
		margin:0;
		}
		div.slide div.desc h10{
		font-size:70%;
		margin:0;
		}

		div.slide div.desc a{
		text-decoration:none;
		}

		.bloco_opacidade{
		background-color: rgba(0,0,0,0.77);
		width: 647px;
		height: 72px;
		margin: 0;
		padding: 0;
		position: absolute;
		margin-top: -74px;
		border-top: 2px solid #ca2900;
		}

		.fundo-link{
		padding: 0px !important;
		margin-left: 0px;
		position: absolute;
		left: 0;
		margin-top: -33px;
		width: 647px;
		height: 75px;
		}

		.fundo-link:hover .bloco_opacidade{
		opacity: 0.70 !important;
		-webkit-opacity: 0.70 !important;
		-moz-opacity: 0.70 !important;
		-o-opacity: 0.70 !important;
		}
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
				<td colspan="2" style="height: 300px;width: 668px;">			
					<div id="recentes_posts" class="categoria_recentes">
						<div id="destaques_principais">
							<div id="mybgcarousel" class="bgcarousel" style="margin-left:0px;margin-top:0px;"></div>
							<div class="bloco_opacidade"></div>
						</div>	
					</div>	
					<?php
					$busca = mysql_query("SELECT * FROM news_tab order by -id LIMIT 5");
					$cont = 1;
					$slidearray = "";
					while($anu = mysql_fetch_array($busca)){
						$titulo = addslashes($anu["titulo"]);
						$imagem = $anu["imagem"];
						$snippet = addslashes($anu["snippet"]);
						$id	= $anu["id"];
						if($imagem == ""){$imagem = "default_img1.png";}
						if($cont != 5){
							$slidearray = $slidearray."['news_imgs/".$imagem."', '<a href=\"post.php?id=".$id."\" style=\"color:white\"><h9>".$titulo."</h9><br /><h10>".$snippet."</h10><img src=\"imgs/b.gif\" class=\"fundo-link\" /></a>'],";
						}
						else{
							$slidearray = $slidearray."['news_imgs/".$imagem."', '<a href=\"post.php?id=".$id."\" style=\"color:white\"><h9>".$titulo."</h9><br /><h10>".$snippet."</h10><img src=\"imgs/b.gif\" class=\"fundo-link\" /></a>']";
						}
						$cont++;
					}
					echo("<script type='text/javascript'>var firstbgcarousel=new bgCarousel({wrapperid: 'mybgcarousel',imagearray: [".$slidearray."], displaymode: {type:'auto', pause:8000, cycles:10, stoponclick:false, pauseonmouseover:true},navbuttons: ['imgs/prev_ico.png', 'imgs/next_ico.png', '', ''], activeslideclass: 'selectedslide', orientation: 'h', persist: true, slideduration: 400 })</script>");
					?>
				</td>
				<td style="height: 300px;width: 316px;" valign="top">
				<span class="col-title">Pesquisar</span>
					<div class="widget-title">
						<table>
						<tr>
							<td style="font-size:12px;" colspan="2">
							<form id="search_option_form">
								<input type="radio" name="search_option" value="intranet" CHECKED>Intranet</input>
								<input type="radio" name="search_option" value="bing">Bing</input>
								<input type="radio" name="search_option" value="google">Google</input>
								<input type="radio" name="search_option" value="yahoo">Yahoo</input>
							</form>	
							</td>
						</tr>
						<tr>
						<td><input type="text" id="search_box" class="campo_padrao" placeholder="FaÁa uma busca" name="q" size="25" onkeydown="pesquisa_enter()" style="width: 210px;"></td><td><div id="input_btn" onclick="search_option()" title="Pesquisar"></div></td>
						</tr>
						</table>
					</div>
				<br />
				<span class="col-title">Tempo</span>
					<div class="widget-title">
						<?php include("weather.php"); ?>
					</div>
				</td>
				</tr>
				<tr>
					<td id="col1" class="col" valign="top">
						<span class="col-title">Mais notÌcias</span>
						<script type="text/javascript">
						function delpost(post,id){
						var del = confirm("Deseja mesmo excluir \""+post+"\"?")
							if(del){
								location.href='admin/del_create.php?id='+id;
							}
						}
						</script>
						<div class="widget-title" style="width: 300px;">
							<ul id="sundell_news" style="padding: 0;">
							<?php
							$busca = mysql_query("SELECT * FROM news_tab order by -id LIMIT 5,3");
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
											<a href="post.php?id=<?=$id?>" style="font-size:13px;" target="_blank"><?=$titulo?></a><br />
											<div style="font-size:11px;color: #bbb;line-height: 18px;">Por <a href="profile.php?p=<?=$autor_nickname?>" style="text-decoration:none;color: #ca2900;"><?=$autor?></a></div><div style="font-size:11px;color: #bbb;line-height: 18px;"><?php echo strftime("%d  %b %Y - %Hh %M", strtotime($data) );  ?></div>
											<span class="post_manage"><?php if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && $autor_nickname == $_SESSION['usr_login_name']){ ?><a href="admin/create.php?edit=1&id=<?=$id?>&u=<?=$autor_nickname?>" target="_blank"><b>Editar</b></a> |<?php } if( ((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor') ) && ($autor_nickname == $_SESSION['usr_login_name'] || $_SESSION['usr_Tipo'] == 'admin') ){ ?><a href="#" onclick="delpost('<?=addslashes($titulo)?>','<?=$id?>')"> <b>Excluir</b></a><?php } ?></span>
										</td>
									</tr>
								</table>								
								</li>
								<?php
							}
							?>
							<li><a href="news.php" style="text-decoration:none;"><div class="btn_1 btn1_am" style="text-align: center;color: #888;height: 28px">Ver todas</div></a></li>
							</ul>
						</div>
					</td>
					<td id="col2" class="col" valign="top">
					<span class="col-title">Utilidades</span>
					<div class="widget-title">
						<div align="center" width="100%">
						<a href="public_files.php" style="text-decoration:none;"><div class="btn_1 btn1_verm" style="width:280px;">Documentos P˙blicos</div></a>
						<a href="pdf/politicas_de_seguranca_sundell.pdf" style="text-decoration:none;" target="_blank"><div class="btn_1 btn1_verm" style="width:280px;">PolÌtica de SeguranÁa</div></a>
						<a href="https://svr-mail.sundell.net/owa" style="text-decoration:none;" target="_blank"><div class="btn_1 btn1_verm" style="width:280px;">Webmail</div></a>
						</div>	
					</div>
					</td>
					<td id="col3" class="col" valign="top" style="width: 316px;">
					<span class="col-title">Outras NotÌcias - g1.com | Tecnologia</span>
					<div id="latest-news" class="widget-title" style="width: 290px;">
						<?php
						if (!$sock = @fsockopen('g1.globo.com', 80, $num, $error, 5)) {
						echo "<p>N„o foi possÌvel obter dados do servidor de notÌcias</p>";
						}
						else{
							$feed = file_get_contents('http://g1.globo.com/dynamo/tecnologia/rss2.xml');
							$feed = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $feed);
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
		</div>
	</body>
</html>	