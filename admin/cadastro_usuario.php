<?php 
//contem todas as config basicas do bd mysql
include ("../news_bd_con.php");

//verifica se usuario logado tem direito de cadastrar novo usuario
include ("seguranca.php");

//se altera pra true indica que o usuario que esta sendo cadastrado ja existe
$user_already_exists = false;

if(isset($_GET["id"])){
	$id = $_GET["id"];
	if( $_SESSION['usr_id'] == $_GET["id"]){
		$editar = true;
	}
	else
	{
		$editar = false;
	}
}
else{
		$editar = false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $editar != true) {

	//conecta ao banco de dados
	$_con = new mysqli($host,$user,$pass,$banco);
	$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
	//faz consulta para verificar se ja foi cadastrado um usu·rio com esta id
	$_sql = "SELECT usuario FROM news_adm WHERE usuario= '".$usuario."'";
	$_res = $_con->query($_sql);
	$_nr = $_res->num_rows;
	$_con->close();
	if($_nr == 0) {
		//cadastra apenas usuarios administradores
		if ( isset( $_GET['tipo']) && $_GET['tipo'] == 'admin'){
			$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
			$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
			$nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';
			$dt_nasc = (isset($_POST['dt_nasc'])) ? $_POST['dt_nasc'] : '';
			$mysql_date = explode("/",$dt_nasc);
			$dt_nasc = $mysql_date[2].'-'.$mysql_date[1].'-'.$mysql_date[0];
			$cmp_bio = (isset($_POST['cmp_bio'])) ? $_POST['cmp_bio'] : '';
			$profile_pic = (isset($_POST['cmp_pic'])) ? $_POST['cmp_pic'] : '';
			if(empty($nome)){$nome = $usuario;}
			
			//conecta ao banco de dados
			$_con = new mysqli($host,$user,$pass,$banco);
			if(!$_con){
				echo "N„o foi possÌvel conectar-se ao servidor";
			}
			$_sql = "INSERT into ".$news_adm." VALUES(null,'".$usuario."','".base64_encode($senha)."','".addslashes($nome)."','".$dt_nasc."',now(),'admin','".$profile_pic."','".$cmp_bio."')";//criptografa a senha para guardar no bd
			$_res = $_con->query($_sql);
			$_con->close();
		}
		else{
			//cadastra usuarios sem poderes administrativos
			if ( isset( $_GET['tipo']) && $_GET['tipo'] == 'editor'){
				$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
				$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
				$nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';
				$dt_nasc = (isset($_POST['dt_nasc'])) ? $_POST['dt_nasc'] : '';
				$mysql_date = explode("/",$dt_nasc);
				$dt_nasc = $mysql_date[2].'-'.$mysql_date[1].'-'.$mysql_date[0];
				$cmp_bio = (isset($_POST['cmp_bio'])) ? $_POST['cmp_bio'] : '';
				$profile_pic = (isset($_POST['cmp_pic'])) ? $_POST['cmp_pic'] : '';
				if(empty($nome)){$nome = $usuario;}
				
				//conecta ao banco de dados
				$_con = new mysqli($host,$user,$pass,$banco);
				if(!$_con){
					echo "N„o foi possÌvel conectar-se ao servidor";
				}
				$_sql = "INSERT into ".$news_adm." VALUES(null,'".$usuario."','".base64_encode($senha)."','".addslashes($nome)."','".$dt_nasc."',now(),'editor','".$profile_pic."','".$cmp_bio."')";//criptografa a senha para guardar no bd
				$_res = $_con->query($_sql);
				$_con->close();
			}

		}
	}
	else{
		$user_already_exists = true;
	}
}
else{
	if($editar == true){
		$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
		$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
		$nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';
		$dt_nasc = (isset($_POST['dt_nasc'])) ? $_POST['dt_nasc'] : '';
		$mysql_date = explode("/",$dt_nasc);
		$dt_nasc = $mysql_date[2].'-'.$mysql_date[1].'-'.$mysql_date[0];
		$cmp_bio = (isset($_POST['cmp_bio'])) ? $_POST['cmp_bio'] : '';
		$profile_pic = (isset($_POST['cmp_pic'])) ? $_POST['cmp_pic'] : '';
		if(empty($nome)){$nome = $usuario;}
		
		$_con = new mysqli($host,$user,$pass,$banco);
		if(!$_con){
			echo "N„o foi possÌvel conectar-se ao servidor";
		}
		$_sql = "UPDATE ".$news_adm." SET usuario = '".$usuario."',  senha = '".base64_encode($senha)."', nome = '".addslashes($nome)."', dt_nasc = '".$dt_nasc."', foto_perfil = '".$profile_pic."', bio = '".$cmp_bio."' WHERE id =".$id;//criptografa a senha para guardar no bd
		$_res = $_con->query($_sql);
		$_con->close();
	}
	else{
		header("Location: ../default.php");
	}
}
?>
<html>
	<head>
		<title>Intranet Sundell - ¡rea Restrita | OperaÁ„o concluÌda!</title>
		<link rel='shortcut icon' type='image/x-icon' href='../imgs/favicon.ico' />
		<link type="text/css" rel="stylesheet" href="../css/default.css" />
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
			<td align="right"><table id="menu"><tr><td><a href="../">P·gina Inicial</a> |</td><td><a href="../news.php">NotÌcias</a> |</td><td><a href="../empresa.php">Empresa</a></td><?php if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "admin"){echo "<td> | <a href=\"index.php\">¡Årea do Administrador</a></td>";}else{if(isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == "editor"){echo "<td> | <a href=\"index.php\">¡Årea do Editor</a></td>";}else{echo "<td> | <a href=\"admin/index.php\">Entrar</a></td>";}}?>
			<td>
			<?php include('logoff_area.php'); ?>
			</td>
			</tr></table></td>
			</tr>
		</table>
		</div>
		<div align="center" class="content">
		<table style="width:580px;height:360px;margin-top:8%;" class="txt_form_padrao">
			<tr>
				<?php
					if(!$user_already_exists == true && !$_res === FALSE){
				?>
				<td style="width: 100%;">
				<?php
				if($editar == true){
					echo"<h2 style=\"font-family: 'Trebuchet MS', Arial;color: #bbb;font-size: 17px;\">Perfil atualizado com sucesso!</h2>";
				}
				else{
					if( isset( $_GET['tipo']) && $_GET['tipo'] == 'admin'){echo"<h2 style=\"font-family: 'Trebuchet MS', Arial;color: #bbb;font-size: 17px;\">Seu usu·rio administrador foi criado com sucesso!</h2>";}
					else{echo"<h2 style=\"font-family: 'Trebuchet MS', Arial;color: #bbb;font-size: 17px;\">Usu·rio criado com sucesso!</h2>";}
				}
				?>
				</td>
				<td align="right" style="border-left:1px solid #ddd;">
					<table class="txt_form_padrao" style="margin-left: 10px;width: 340px;">
						<tr><td colspan="2">Nome: <b><?php echo $nome; ?></b></td></tr>
						<tr><td colspan="2">Nome de usu·rio: <b><?php echo $usuario; ?></b></td></tr>
						<tr><td colspan="2">Tipo de usu·rio: <b><?php if($_GET['tipo'] == 'editor'){echo "Editor";}else{if($_GET['tipo'] == 'admin'){echo "Administrador";}} ?></b></td></tr>
						<?php if($editar != true){ echo "<tr><td colspan=\"2\"><br /><b>ObservaÁıes:</b><ul><li>Para adicionar ou excluir usu·rios comuns (editores) È necess·rio estar logado em um usu·rio <b>administrador</b>.</li><li>Usu·rios administradores n„o podem excluir outros usu·rios com privilÈgio de administrador.</li><li>Apenas os prÛprios administradores podem excluir seus perfis do sistema.</li></ul></td></tr>";} ?>					
						<tr><td><br /><a href="ger_usuarios.php"  style="text-decoration: none;font-size: 14px;white-space: nowrap;" class="btn_2">Gerenciar Usu·rios</a></td><td><br /><a href="seguranca.php?o=1" style="text-decoration: none;font-size: 14px;white-space: nowrap;" class="btn_2">Fazer Logoff</a></td></tr>
					</table>
				</td>
			</tr>
				<?php
					}
					else{
						if($user_already_exists == true){
							echo"<tr><td>O usu·rio que vocÍ est· tentando cadastrar j· existe no sistema!<br />Tente usar outro nome de usu·rio.</td></tr><tr><td style='weight: 50px;'><a class='btn_2' style='text-decoration: none;font-size: 14px;white-space: nowrap;' href='javascript:history.back(1)' style='white-space: nowrap'>Voltar para a p·gina anterior</a></td></tr>";
						}
						else
						{
							echo"<tr><td>Ocorreu um erro no sistema e n„o foi possÌvel cadastrar o usu·rio!</td></tr>";
						}
					}
				?>
		</table>
		</div>
		
	</div>	
</body>
</html>