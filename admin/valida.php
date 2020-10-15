<?php
include("seguranca.php");

// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';

if (validaUsuario($usuario, $senha) == true) {
// se ok usuario logado
header("Location: index.php");
} else {
//se não volta a pagina inicial com uma variavel que indica o erro no login "u=0"
expulsaVisitante('?u=0');
}
}
?>