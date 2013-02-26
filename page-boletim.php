<?php get_header(); ?>

	<div id="content" class="cf">
		<?php include('sidebar-nav.php'); 
			require_once 'php/conexao.php';
			require_once 'php/aluno.class.php';	
			$aluno = new aluno(); ?> 
		<div id="meio">
            <article class="excerpt-article">
            	<!-- ================================= -->
            	<!-- Mostra Notas -->
            	<!-- ================================= -->
				<h2>Boletim</h2>
            	<?php
					session_start();

					//INCLUINDO O VERIFICADOR
					require_once("/Conexoes/VerificaAlunos.php");

					$aluno->getModulos();

					?>

					<table width="200" border="0" align="center" cellpadding="5" cellspacing="0">
					<tr>

			
					<?php

					foreach ($aluno->modulos as $key => $value) {
						print "$key => $value<br>";
					}

					?>
					</tr>
					</table>
            	<!-- ================================= -->
            	<!-- # Mostra Notas -->
            	<!-- ================================= -->
            </article>
		</div>
		<?php include('sidebar-right.php'); ?>
	</div>


<?php include 'footer.php'; ?>