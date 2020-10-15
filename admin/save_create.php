<?php
session_start();
include("../news_bd_con.php");
$pasta = "../news_imgs/"; 

if(empty($_POST["corpo"]) || empty($_POST["titulo"])){
	$ready = 0;
}
else{
	$ready = 1;
}
	
if(((isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin') || (isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor')) && ($ready == 1)){
	$titulo = $_POST["titulo"];
	$autor = $_POST["autor"];
	$autor_nickname = $_POST["autor_nickname"];
	$corpo = $_POST["corpo"];
	$snippet = $_POST["snippet"];
	$thumbnail = $_POST["thumbnail"];
	$data   = date('Y-m-d H:i:s');
	$sql = "INSERT INTO news_tab (id, titulo, snippet, imagem, noticia, data, autor, autor_nickname) VALUES('','".addslashes($titulo)."','".addslashes($snippet)."','".$thumbnail."','".addslashes($corpo)."','".$data."','".addslashes($autor)."','".addslashes($autor_nickname)."')";
	$res = mysql_query($sql);
	if($res === TRUE){
		echo "<script>alert(\"Notícia inserida com sucesso!\"); location.href='../';</script>";
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