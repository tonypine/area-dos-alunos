<?php get_header(); ?>

	<div id="content" class="cf">
		<?php include('sidebar-nav.php'); 
			require_once 'php/conexao.php';
			require_once 'php/aluno.class.php';	
			$aluno = new aluno(); ?> 
		<div id="meio">
            <article class="excerpt-article">
            	<?php require_once 'Boletim/Mostra_Notas.php'; ?>
            </article>
		</div>
		<?php include('sidebar-right.php'); ?>
	</div>


<?php include 'footer.php'; ?>