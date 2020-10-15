<?php
session_start();
include("../news_bd_con.php");
$pasta = "../news_imgs/"; 
	
if((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor')){
	$titulo = $_POST["titulo"];
	$postid	=	$_POST["postid"];
	$autor = $_POST["autor"];
	$autor_nickname = $_POST["autor_nickname"];
	$corpo = $_POST["corpo"];
	$snippet = $_POST["snippet"];
	$thumbnail = $_POST["thumbnail"];
	$data   = $_POST["data"];
	
	$_con = new mysqli($host,$user,$pass,$banco);
	if(!$_con){
		echo "Não foi possível conectar-se ao servidor";
	}
	
	$_sql = "UPDATE news_tab SET titulo = '".addslashes($titulo)."', snippet = '".addslashes($snippet)."', imagem = '".$thumbnail."', noticia = '".addslashes($corpo)."', data = '".$data."', autor = '".addslashes($autor)."', autor_nickname = '".addslashes($autor_nickname)."' WHERE id =".$postid;
	$_res = $_con->query($_sql);
	$_con->close();
	if($_res === TRUE){
	echo "<script>alert(\"Postagem Atualizada com Sucesso!\"); location.href='../news.php';</script>";
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