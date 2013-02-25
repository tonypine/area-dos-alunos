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
		<meta charset="ISO-88859-1" />
		<meta name="viewport" content="width=device-width" />
		<title>Área dos Alunos</title>
		
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		
		<!-- GOOGLE FONT -->
		<link href='http://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:800' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" media="all" href="Sistema/Aluno2/css/style.css" />
		
		<!--[if lt IE 9]>
		<script src="js/html5.js" type="text/javascript"></script>
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
		
		<div id="mainContainer" class="cf">
			<header id="mainHeader" class="cf">
				<div id="mHeaderIn" class="cf">
					<a id="logoMicrocamp" href="#"><img src="images/logo-microcamp-sp.jpg"/></a>
					<form id="hFormLogin" method="post" action="verifica_usuario.php">
						<?php

							//IMPORTANDO A CONEXÃO COM O BANCO
							require_once("Conexoes/conexao.php");
							
							//CONSULTANDO TODAS AS UNIDADES CADASTRADAS
							$unidades = mysql_query("
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
									<?php while ($row = mysql_fetch_object($unidades)): ?>
											<option value="<?php echo $row->CodUnidade; ?>"><?php echo $row->Unidade; ?></option>
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
										<img class="loader" src="images/ajax-loader-white.gif" />
									</div>
								</div>
							</li>
						</ul>
						
	
					</form>
				</div>
			</header>