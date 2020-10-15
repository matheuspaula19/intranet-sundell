<?php
//  Configurações
$_SG['conectaServidor'] = true;
$_SG['abreSessao'] = true;

$_SG['caseSensitive'] = false;

$_SG['validaSempre'] = true;// valida usuario a cada carregamento de página

include ("../news_bd_con.php"); //configs do serv. mysql

$_SG['servidor'] = $host;
$_SG['usuario'] = $user;
$_SG['senha'] = $pass;
$_SG['banco'] = $banco; 
$_SG['paginaLogin'] = 'login.php';
$_SG['tabela'] = 'news_adm';
// ==============================




//encerra sessão e faz log-out (seguranca.php?o=1)
if ( isset( $_GET['o']) && $_GET['o'] == '1'){
session_start();
$_SESSION = array();
session_destroy();
header("Location: ../default.php");
}

function encerra_sessao(){
session_start();
$_SESSION = array();
session_destroy();
header("Location: ../default.php");
}

// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
$_SG['link'] = mysql_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha']) or die("MySQL: Não foi possível conectar-se ao servidor [".$_SG['servidor']."].");
mysql_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
}


// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true) {
session_start();
}

function validaUsuario($usuario, $senha) {
global $_SG;

$cS = ($_SG['caseSensitive']) ? 'BINARY' : '';

// Usa a função addslashes para escapar as aspas
$nusuario = addslashes($usuario);
$nsenha = base64_encode(addslashes($senha));
//criptografa a senha para comparar com a salva no bd




// Monta uma consulta SQL (query) para procurar um usuário
$sql = "SELECT `id`, `usuario`, `nome`, `tipo`, `foto_perfil` FROM `".$_SG['tabela']."` WHERE ".$cS." `usuario` = '".$nusuario."' AND ".$cS." `senha` = '".$nsenha."' LIMIT 1";
$query = mysql_query($sql);
$resultado = mysql_fetch_assoc($query);

// Verifica se encontrou algum registro
if (empty($resultado)) {
// Nenhum registro == usuário inválido
return false;

} else {
// Registro encontrado == usuário valido

$_SESSION['usr_id'] = $resultado['id']; // coluna 'id do registro
$_SESSION['usr_nome'] = $resultado['nome']; // coluna 'nome' do registro
$_SESSION['usr_Tipo'] = $resultado['tipo'];
$_SESSION['usr_login_name'] = $resultado['usuario'];
$_SESSION['usr_pic'] = $resultado['foto_perfil'];

if ($_SG['validaSempre'] == true) {
$_SESSION['usr_login'] = $usuario;
$_SESSION['usr_senha'] = $senha;
}

return true;
}
}

function protegePagina() {
global $_SG;

if (!isset($_SESSION['usr_id']) OR !isset($_SESSION['usr_nome'])) {
// Não há usuário logado, manda pra página de login
expulsaVisitante('?u=1');
} else if (!isset($_SESSION['usr_id']) OR !isset($_SESSION['usr_nome'])) {
// Há usuário logado, verifica se precisa validar o login novamente
if ($_SG['validaSempre'] == true) {
// Verifica se os dados salvos na sessão batem com os dados do banco de dados
if (!validaUsuario($_SESSION['usr_login'], $_SESSION['usr_senha'])) {
// Os dados não batem, manda pra tela de login
expulsaVisitante('?u=1');
}
}
}
}

function expulsaVisitante($tipo) {
global $_SG;
// Remove as variáveis da sessão (caso elas existam)
unset($_SESSION['usr_id'], $_SESSION['usr_nome'], $_SESSION['usr_login'], $_SESSION['usr_senha'], $_SESSION['usr_Tipo'], $_SESSION['usr_login_name'], $_SESSION['usr_pic']);
// volta para o login

header("Location: ".$_SG['paginaLogin'].$tipo);

}

?>