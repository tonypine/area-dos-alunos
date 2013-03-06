<?php

// Destroy session
session_start();
$_SESSION = array();
session_destroy();
header("Location: http://localhost/alunos"); ?>