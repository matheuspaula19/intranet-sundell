<?php  
	$pasta = "news_imgs/"; 

	
	/* formatos de imagem permitidos */ 
	$permitidos = array(".jpg",".jpeg",".gif",".png"); 
	if(isset($_POST) && isset($_FILES['img_input'])){ 
		$nome_imagem = $_FILES['img_input']['name']; 
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
			
			echo "<li style=\"float:left;margin: 4px;list-style: none;\"><img src='../news_imgs/".$nome_atual."' title=\"Adicionar\" alt=\"Adicionar\" onclick=\"format(&quot;[img]news_imgs/".$nome_atual."[/img]&quot;)\" style=\"cursor:pointer;width:90px;border-radius:3px;max-height: 51px;\" /></li>";
			echo "<script>
			format('[img]news_imgs/".$nome_atual."[/img]');
			thumb('".$nome_atual."');
			$('#add_imgs_title').css('display','block');
			$('#prev_img_title').css('display','block');
			</script>";
			//imprime a imagem na tela 
			
			}
			else{
				echo "<script>$('#add_imgs_title').css('display','block');$('#prev_img_title').css('display','block');</script>";
				echo "<li style=\"float:left;margin: 4px;list-style: none;\"><div style=\"background: #029be8;color: #fff;border-radius: 3px;width:90px;height:48px;text-align: center;padding-top: 3px;font-size: 10px;\">Falha ao enviar</div></li>"; } 
			}
			else{
				echo "<script>$('#add_imgs_title').css('display','block');$('#prev_img_title').css('display','block');</script>";
				echo "<li style=\"float:left;margin: 4px;list-style: none;\"><div style=\"background: #029be8;color: #fff;border-radius: 3px;width:90px;height:48px;text-align: center;padding-top: 3px;font-size: 10px;\">A imagem<br />deve ter no<br />m&aacute;ximo 1MB!</div></li>"; 
			} 
		}
	else{
		echo "<li style=\"float:left;margin: 4px;list-style: none;\"><div style=\"background: #029be8;color: #fff;border-radius: 3px;width:90px;height:48px;text-align: center;padding-top: 3px;font-size: 10px;\">Somente s&atilde;o aceitos arquivos<br />de imagem!</div></li>"; } 
	}
	else{ 
		exit; 
	} 
?>

