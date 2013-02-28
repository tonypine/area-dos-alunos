<?php

//DESTRUINDO TODAS AS SESSÕES
session_start();
$_SESSION = array();
session_destroy();

//REDIRECIONANDO PARA O LOGIN
header("Location: http://localhost/alunos");

?>