<?php

session_start();
require_once("conexao.php");

/* Escape */

$CodUnidade = str_pad($_POST['CodUnidade'], 3, "0", STR_PAD_LEFT);
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

//$NomeUnidade = addslashes($_POST['NomeUnidade']);

$user = $mysqli->prepare("
	SELECT 
		CodUnidade, 
		Codigo, 
		SENHA, 
		NIVEL, 
		Ativo
	FROM 
		TAB_LOGIN 
	WHERE 
		CodUnidade = ? 
		AND Codigo = ? 
		AND SENHA = ?
");
$user->bind_param('sss', $CodUnidade, $usuario, $senha);
$user->execute();
$user->bind_result($codUnidade, $cod, $pass, $level, $ativo);
$user->fetch();

/* Definindo as variáveis de sessão */
$_SESSION['codUnidade'] = $codUnidade;
$_SESSION['codCurso'] = substr($usuario, 0, 3);
$_SESSION['ctr'] = substr($usuario, 3, 8);
$_SESSION['level'] = $level;
$_SESSION['logged'] = 1;

$response = (object) Array(
		'message' 	=> '',
		'login'		=> 0,
		'rows'		=> $user->num_rows
	);

/* Verificando se o retorno é uma única linha */
if($user->num_rows == "1"):
	
	if($ativo)
		$response->login = 1;

	$mysqli->query("
		INSERT 
			INTO 
				TAB_ControleAcesso (CodUnidade, Codigo, Data) 
			VALUES('".$_SESSION['codUnidade']."', '".$_SESSION['codCurso'].$_SESSION['ctr']."', '".date('Y-m-d H:i:s')."')");
	
	switch ($_SESSION['Nivel']):
		case 1:
			//header("Location: Sistema/Aluno/index.php");
			break;
		case 2:
			header("Location: Sistema/Instrutor/index.php");
			break;
		case 3:
			header("Location: Sistema/Coordenador/index.php");
			break;
		case 4:
			header("Location: Sistema/Diretor/index.php");
			break;
		case 5:
			header("Location: Sistema/Assessor/index.php");
			break;
	endswitch;
	
else:
	$response->message = "Login inválido";
endif;

echo json_encode($response);

?>
