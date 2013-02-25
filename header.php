<?php 
	
	// Aluno Class

	session_start();
	
	/* Se o usu�rio n�o estiver logado, ent�o ele � redirecionado
	 * para a p�gina de login */
	 
	if($_SESSION['Unidade'] == "" or 
	$_SESSION['CodCurso'] == "" or 
	$_SESSION['Ctr'] == "" or 
	$_SESSION['Nivel'] == "" or 
	$_SESSION['Nivel'] != "1")
		require_once("Logout.php");
		
	require_once 'php/conexao.php';
	require_once 'php/aluno.class.php';	
	$aluno = new aluno(); 
	
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
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />
		<title>Área dos Alunos</title>
		
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		
		<link rel="stylesheet" type="text/css" media="all" href="<?php url(); ?>/css/style.css" />
		
		<!-- IE Fix for HTML5 Tags -->
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>

	<body>
		
		<!-- facebook -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		
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
								<td><?php echo ucwords( strtolower( $aluno->info->Nome ) ); ?></td>
								<td>Curso: Informática</td>
							</tr>
							<tr>
								<td><?php echo $aluno->info->old; ?> anos</td>
								<td>Módulo: 4 Desenho Digital</td>
							</tr>
							<tr>
								<td><a href="" class="blueLink">editar perfil</a></td>
								<td>Unidade: <?php echo utf8_encode( $aluno->info->unidade ); ?></td>
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