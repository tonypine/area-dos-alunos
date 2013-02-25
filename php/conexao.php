<?php

//CONSULTANDO O BANCO SETCOM NA MAQUINA LOCAL DA ESCOLA
$host = "mysql.alunos.microcampsp.com.br";
$database = "portalalunos_db_pd";
$username = "portalalunosdbpd";
$password = "alunos_web!12db";

$con = mysql_connect($host, $username, $password) or die ("Não foi possivel fazer a conexão com o banco do Portal");
$db = mysql_select_db($database, $con);

header('Content-Type: text/html; charset=iso-8859-1');
mysql_query("SET NAMES 'iso-8859-1'");
header("Cache-Control: no-cache, must-revalidate"); 
header('Pragma: no-cache');

date_default_timezone_set('America/Sao_Paulo');


?>