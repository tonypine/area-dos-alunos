<?php

// Data no passado
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// Sempre modificado
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");

//VERIFICA SE O USUARIO POSSUI UMA SESSÃO;
if($_SESSION['Unidade'] == "" or $_SESSION['CodCurso'] == "" or $_SESSION['Ctr'] == "" or $_SESSION['Nivel'] == "" or $_SESSION['Nivel'] != "5")
{
	require_once("Logout.php");
}

?>