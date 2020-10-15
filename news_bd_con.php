<?php
/* Arquivo de configuração do sistema */

//Dados do MySQL
$host  = "localhost";   // servidor.
$user  = "root";    // nome do usuário.
$pass  = "";    // senha do usuário.
$banco = "sundell_news";    // nome do banco de dados.
$news_adm = "news_adm";

//Paginação de resultados
$config_paginacao = "10"; //número de notícias por página.

mysql_connect($host, $user, $pass);
mysql_select_db($banco);
?>