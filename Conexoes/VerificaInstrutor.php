<?php

//VERIFICA SE O USUARIO POSSUI UMA SESSÃO;
if($_SESSION['Unidade'] == "" or $_SESSION['CodCurso'] == "" or $_SESSION['Ctr'] == "" or $_SESSION['Nivel'] == "" or $_SESSION['Nivel'] != "2")
{
	require_once("Logout.php");
}


?>