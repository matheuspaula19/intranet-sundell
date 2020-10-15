<?php
session_start();
include("../news_bd_con.php");
$pasta = "../news_imgs/"; 
	
if((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor')){
	$postid = (isset($_GET["id"])) ? $_GET["id"] : '';
	
	$_con = new mysqli($host,$user,$pass,$banco);
	$_sql = "SELECT autor_nickname FROM news_tab WHERE id='".$_GET["id"]."' AND autor_nickname='".$_SESSION['usr_login_name']."'";
	$_res = $_con->query($_sql);
	$_nr = $_res->num_rows;
	if($_nr == 1) {
		$_sql = "DELETE FROM news_tab WHERE id=".$postid;
		$_res = $_con->query($_sql);
		$_con->close();
		if($_res === TRUE){
		echo "<script>alert(\"Notícia deletada com sucesso!\"); location.href='../news.php';</script>";
		}
	}
	else{
		//permite ao usuario adminstrador remover posts de usuarios que ja nao existem mais
		//mas evita apagamentos propositais armazenando os seus dados em um log
		if((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') ){
			//recupera dos dados do autor e criacao antes de excluir o registro
			$_sql = "SELECT id, titulo, data, autor_nickname FROM news_tab WHERE id =".$postid;
			$query = mysql_query($_sql);
			$resultado = mysql_fetch_assoc($query);
			$titulo = $resultado['titulo'];
			$dt_criacao = strtotime($resultado['data']);
			$post_autor = $resultado['autor_nickname'];
			
			//deleta permanentemente o post
			$_sql = "DELETE FROM news_tab WHERE id=".$postid;
			$_res = $_con->query($_sql);
			$_con->close();
			
			//se a exclusao foi concluída com sucesso...
			if($_res === TRUE){
				//avisa o usuario de que o post foi apagado mas foi descrito no log
				echo "<script>alert(\"Aviso: A postagem foi removida por um usuário Administrador que não a criou! Os detalhes desta exclusão serão armazenados em um log - A Notícia foi deletada com sucesso.\"); location.href='../news.php';</script>";
				
				//prepara log mostrando a hora e quem excluiu a postagem
				setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
				date_default_timezone_set('America/Sao_Paulo');
				$dia = date("Y_m_d");
				$arquivo = fopen("../ger_logs/del_log/post_del_log_$dia.txt", "a+");
				$hora = date("H:i:s T");
				$acao = "A postagem \"".addslashes($titulo)."\" com o id: ".$postid.", criada pelo usuário: ".addslashes($post_autor)." em ".date('d/m/Y à\s H:i:s', $dt_criacao).", foi removida pelo usuário administrador: ".addslashes($_SESSION['usr_login_name'])." com o id: ".$_SESSION['usr_id'].".";
				fwrite($arquivo, "[$hora] - $acao \r\n");
				fclose($arquivo);
			}
		}
	}

	// exclui fotos que não estão no banco antes de upar nova foto (evita lixo)
	if(is_dir($pasta))
	{
		$_con = new mysqli($host,$user,$pass,$banco);
		$diretorio = dir($pasta);
		while($arquivo = $diretorio->read())
		{
			$_sql = "select imagem, noticia from news_tab where noticia like '%".$arquivo."%' or imagem like '%".$arquivo."%'";
			$_res = $_con->query($_sql);
			$_nr = $_res->num_rows;
			if($_nr == 0 && $arquivo != '.' && $arquivo != '..' && $arquivo != 'default_img1.png' && $arquivo != 'default_img2.png' && $arquivo != 'default_img3.png') {
				//exclui arquivo
				unlink($pasta.$arquivo);
			}
		}
		$_con->close();
		$diretorio->close();
	}
}
else
{
echo "<script>location.href='../'</script>";
}
?>