<?php

	session_start();
	
	global $logged, $aluno, $session, $mysqli;

	if($_SESSION['Unidade'] == "" or 
	$_SESSION['CodCurso'] == "" or 
	$_SESSION['Ctr'] == "" or 
	$_SESSION['Nivel'] == "" or 
	$_SESSION['Nivel'] != "1"):
		$logged = 0;
	else:
		$logged = 1;

		/* instanciate the SESSION for be accessible on all requires */
		$session = $_SESSION;
		require_once 'php/conexao.php';
		require_once 'php/aluno.class.php';	
		$aluno = new aluno(); 
		$aluno->getAluno(); 
	endif;
	?>
<!DOCTYPE html>
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
		
		<link rel="stylesheet" type="text/css" media"all" href="<?php url(); ?>/css/style.css?v=1" />
		
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

					<?php 
					/* ================================= */
					/* if logged in */
					/* =============================== */
					if($logged): ?>

						<!-- ============================= -->
						<!-- Normal header -->
						<!-- ============================= -->
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
								<a id="btnSair" href="<?php url(); ?>/php/logout.php">Sair</a>
							</li>
						</ul>
					<?php else: ?>
						
						<!-- ============================= -->
						<!-- Login form -->
						<!-- ============================= -->
						<form id="hFormLogin" method="post" action="<?php url(); ?>/php/login.php">
							<?php

								//IMPORTANDO A CONEXÃO COM O BANCO
								require_once("php/conexao.php");
								
								//CONSULTANDO TODAS AS UNIDADES CADASTRADAS
								$unidades = $mysqli->query("
								select * 
								from TAB_Unidades 
								order by case when Unidade = 'Assessoria Holding' then 1
								else Unidade 
								end asc
								");
							
							?>
							<ul>
								<li class="hide">
									<label>Unidade</label>
									<select id="selUnidades" name="CodUnidade">
										<?php while ($row = mysqli_fetch_object($unidades)): ?>
												<option value="<?php echo $row->CodUnidade; ?>"><?php echo utf8_encode( $row->Unidade ); ?></option>
										<?php endwhile; ?>
									</select>
								</li>
								<li class="hide">
									<label>Usuário</label>
									<input id="inpUser" type="text" value="" placeholder="Código do usuário" name="usuario" />
								</li>
								<li class="hide">
									<label>Senha</label>
									<input id="inpPass" type="password" value="" name="senha" />
								</li>
								<li>
									<input class="formButton" type="submit" value="Login" />
									<div class="popup">
										<div>
											<span class="arrowTop"></span>
											<span class="msgErro"></span>
											<span class="msg">Entrando ...</span>
											<img class="loader" src="<?php url(); ?>/images/ajax-loader-white.gif" />
										</div>
									</div>
								</li>
							</ul>
						</form>
					<?php endif; ?>
				</div>
			</header>