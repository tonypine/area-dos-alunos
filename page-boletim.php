<?php get_header(); ?>

	<div id="content" class="cf">
		<?php 
			include('sidebar-nav.php'); 
			require_once 'php/conexao.php';
			require_once 'php/aluno.class.php';	
			$aluno = new aluno(); ?> 
		<div id="meio">
            <article class="excerpt-article">
				<h2>Boletim</h2>
            	<?php
            		while(have_posts()): the_post();
            			the_content();
            		endwhile;

            		$aluno->getAluno();
					$aluno->getModulos();

					/* --------------------- */
					/* Table of notes
					/* ------------------- */
					echo '<table id="listaNotas">';
					foreach($aluno->modulos as $key => $m):
						if($m->nota):
							if($m->nota > 7):
								$class = 'aprovado';
							elseif($m->nota < 7):
								$class = 'reprovado';
							endif;
							$nota = $m->nota . ' Pontos';
						else:
							$class = '';
							$nota = "--";
						endif;
						echo "<tr class='".$class."'>";
						echo "<td class='nota'>".$nota."</td><td class='modulo'>".$m->descricao."</td>";
						echo "</tr>";
					endforeach;
					echo '</table>'
				?>

            </article>
		</div>
		<?php include('sidebar-right.php'); ?>
	</div>


<?php include 'footer.php'; ?>