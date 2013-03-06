<?php 
	//session_start();
	import_request_variables('g');

	require_once 'php/aluno.class.php';
	$aluno = new aluno($Unidade, $CodCurso, $Ctr);
	$aluno->getAluno();

	// header("Cache-Control: max-age=".strtotime('-4 hours'));
	// header("Pragma: none");
 //    header("Expires: " . gmdate('D, d M Y H:i:s', strtotime('-4 hours')));
	header('Content-type: application/json');
	echo json_encode($aluno->info);
?>