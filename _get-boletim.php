<?php

	import_request_variables('g');
	$_s = (object) $_s;
	$gzfile = "cache/".$_s->ctr."/boletim-".$_s->ctr.".gz";

	if (file_exists($gzfile) && (int) date("d", filemtime($gzfile)) == (int) date("d")):
	    // echo "gzip was last modified: " . (int) date("d", filemtime($gzfile)) . "<br><br>";
		@readgzfile($gzfile);
	else:
		$loadFile = "../../../wp-load.php";
		if (file_exists($loadFile))
		    require_once($loadFile);

		$output = ''; 
		$output .= "<article class='excerpt-article'>";
			$output .= "<h1>Boletim</h1>";

			$q = new WP_Query( array(
					'post_type'		=> 'page',
					'pagename'		=> 'boletim'
				) );

			while($q->have_posts()): $q->the_post();
				$output .= "<p>";
				$output .= get_the_content();
				$output .= "</p>";
			endwhile;

			require_once 'php/aluno.class.php';
			$aluno = new aluno($_s->codUnidade, $_s->codCurso, $_s->ctr);
			$aluno->getAluno();
			$aluno->getModulos();

			/* --------------------- */
			/* Table of notes
			/* ------------------- */
			$output .= '<table id="listaNotas">';
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
				$output .= "<tr class='".$class."'>";
				$output .= "<td class='nota'>".$nota."</td><td class='modulo'>".$m->descricao."</td>";
				$output .= "</tr>";
			endforeach;
			$output .= '</table>';
		$output .= "</article>";

		if(!is_dir("cache/".$_s->ctr."/"))
			mkdir("cache/".$_s->ctr."/");

		$fp = gzopen($gzfile, 'w9');
		gzwrite($fp, $output);
		gzclose($fp);

		echo $output;

	endif;

?>