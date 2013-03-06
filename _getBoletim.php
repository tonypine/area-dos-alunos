	<h2>Boletim</h2>
	<?php

		$loadFile = "../../../wp-load.php";
		if (file_exists($loadFile))
		    require_once($loadFile);

		$bArgs = array(
				'post_type'		=> 'page',
				'pagename'		=> 'boletim'
			);

		$bQuery = new WP_Query( $bArgs );

		session_start();
		echo "<article class='excerpt-article'>";
			while($bQuery->have_posts()): $bQuery->the_post();
				the_content();
			endwhile;

			require_once 'php/aluno.class.php';
			$aluno = new aluno($_SESSION['codUnidade'], $_SESSION['codCurso'], $_SESSION['ctr']);
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
			echo '</table>';
		echo "</article>";
	?>