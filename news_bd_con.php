<?php
/* Arquivo de configura��o do sistema */

//Dados do MySQL
$host  = "localhost";   // servidor.
$user  = "root";    // nome do usu�rio.
$pass  = "";    // senha do usu�rio.
$banco = "sundell_news";    // nome do banco de dados.
$news_adm = "news_adm";

//Pagina��o de resultados
$config_paginacao = "10"; //n�mero de not�cias por p�gina.

mysql_connect($host, $user, $pass);
mysql_select_db($banco);
?>