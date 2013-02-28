<?php 
	
	// Aluno Class

	session_start();
	
	if($_SESSION['Unidade'] == "" or 
	$_SESSION['CodCurso'] == "" or 
	$_SESSION['Ctr'] == "" or 
	$_SESSION['Nivel'] == "" or 
	$_SESSION['Nivel'] != "1")
		require_once("Conexoes/Logout.php");
		
	require_once 'php/conexao.php';
	require_once 'php/aluno.class.php';	
	$aluno = new aluno(); 
	$aluno->getAluno(); 
	
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6">
<![endif]-->
<!--[if IE 7]>
<html id="ie7">
<![endif]-->
<!--[if IE 8]>
<html id="ie8">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html>
<!--<![endif]-->
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">      
        <meta name="viewport" content="width=device-width">
		<title>Área dos Alunos</title>
		
		<link rel="stylesheet" type="text/css" media="all" href="<?php url(); ?>/css/style.css" />
		
		<!-- IE Fix for HTML5 Tags -->
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>

	<body>

		<!-- facebook -->
		<div id="fb-root"></div>
				
		<div id="mainContainer">
			<header id="mainHeader">
				<div id="mHeaderIn">
					<a id="logoMicrocamp" href="#"><img src="<?php url(); ?>/images/logo-microcamp-sp.jpg"/></a>
					<section id="userInfo">
						<div id="userPhoto">
							<img src="<?php url(); ?>/images/userPhoto.jpg" />
						</div>
						<table id="uInfo">
							<tr>
								<td><?php echo ucwords( strtolower( $aluno->info->nome ) ); ?></td>
								<td>Curso: Informática</td>
							</tr>
							<tr>
								<td><?php echo $aluno->info->old; ?> anos</td>
								<td>Módulo: 4 Desenho Digital</td>
							</tr>
							<tr>
								<td><a href="" class="blueLink">editar perfil</a></td>
								<td>Unidade: <?php echo $aluno->info->unidade; ?></td>
							</tr>
						</table>
					</section>
					<ul id="topConfig">
						<li>
							<a id="btnConfig" href="#">Configurações</a>
						</li>
						<li>
							<a id="btnSair" href="../../Conexoes/logout.php">Sair</a>
						</li>
					</ul>
				</div>
			</header>