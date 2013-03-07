	<article class="excerpt-article">
		<h1>Boletim</h1>
		<?php
		import_request_variables('g');

		$loadFile = "../../../wp-load.php";
		if (file_exists($loadFile))
		    require_once($loadFile);

		$bArgs = array(
				'post_type'		=> 'page',
				'pagename'		=> 'boletim'
			);

		$bQuery = new WP_Query( $bArgs );

		while($bQuery->have_posts()): $bQuery->the_post();
			the_content();
		endwhile;

		require_once 'php/aluno.class.php';
		$_s = (object) $_s;
		$aluno = new aluno($_s->codUnidade, $_s->codCurso, $_s->ctr);
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
		?>
	</article>