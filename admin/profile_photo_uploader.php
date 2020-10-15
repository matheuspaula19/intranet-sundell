<?php  
	include('../includes/wideimage/WideImage.php');
	include ("../news_bd_con.php");
	
	$pasta = "profile_imgs/"; 
	
	// exclui fotos que não estão no banco antes de upar nova foto (evita lixo)
	if(is_dir($pasta))
	{
		$_con = new mysqli($host,$user,$pass,$banco);
		$diretorio = dir($pasta);
		while($arquivo = $diretorio->read())
		{
			$_sql = "SELECT foto_perfil FROM news_adm WHERE foto_perfil= '".$arquivo."'";
			$_res = $_con->query($_sql);
			$_nr = $_res->num_rows;
			if($_nr == 0 && $arquivo != 'admin_ico.png' && $arquivo != 'user_ico.png' && $arquivo != '.' && $arquivo != '..') {
				//exclui arquivo
				unlink($pasta.$arquivo);
			}
		}
		$_con->close();
		$diretorio->close();
	}
	
	/* formatos de imagem permitidos */ 
	$permitidos = array(".jpg",".jpeg",".gif",".png"); 
	if(isset($_POST) && isset($_FILES['img_input']['name'])){ 
		$nome_imagem = $_FILES['img_input']['name'];
		/*$nome_imagem =(isset($_FILES['img_input']['name'])) ? $_FILES['img_input']['name'] : '';*/	
		
		$tamanho_imagem = $_FILES['img_input']['size'];
		
		/* pega a extensão do arquivo */ 
		$ext = strtolower(strrchr($nome_imagem,".")); 
		
		/* verifica se a extensão está entre as extensões permitidas */ 
		if(in_array($ext,$permitidos)){ 
			/* converte o tamanho para KB */ 
			$tamanho = round($tamanho_imagem / 1024); 
			if($tamanho < 1024){ 
			//se imagem for até 1MB envia 
			
			$nome_atual = md5(uniqid(time())).$ext; 
			//nome que dará a imagem 
			
			$tmp = $_FILES['img_input']['tmp_name']; 
			//caminho temporário da imagem 
			
			/* se enviar a foto, insere o nome da foto no banco de dados */ 
			if(move_uploaded_file($tmp,$pasta.$nome_atual)){ 
			
			//Faz crop automatico da imagem para não ocupar muito espaço
			$arquivo = $pasta.$nome_atual;
			$image = WideImage::load($arquivo);
			$image = $image->resize(200, 100);
			$image = $image->crop('center', 'center', 100, 100);
			$image->saveToFile($arquivo);

			
			echo "
			<script type=\"text/javascript\">
			$(function() {
				$('#user_ico').attr(\"value\", '".$nome_atual."');
			});
			</script>";//seta o nome do arquivo no form principal
			echo "<img src='profile_imgs/".$nome_atual."' style=\"width:50px;border-radius:3px;\" />";
			//imprime a foto na tela 
			
			}else
			{ echo "Falha ao enviar"; } 
			}else{ 
			echo "A imagem deve ser de no máximo 1MB"; 
			} 
		}
	else{
		echo "Somente são aceitos arquivos do tipo Imagem"; } 
	}
	else{ 
		echo "Selecione uma imagem"; 
		exit; 
	} 
?>

