<?php

//CONSULTANDO O BANCO SETCOM NA MAQUINA LOCAL DA ESCOLA
/* mysql.alunos.microcampsp.com.br */
// $host = "p:64.90.52.220";
$host = "p:64.90.52.220";
$database = "portalalunos_db_pd";
$username = "portalalunosdbpd";
$password = "alunos_web!12db";

$mysqli = new mysqli($host, $username, $password, $database) or die ("NПлкo foi possivel fazer a conexПлкo com o banco do Portal");

?>