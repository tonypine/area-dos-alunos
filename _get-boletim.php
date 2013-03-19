<?php

	/* load get variables */
	import_request_variables('g');
	$_s = (object) $_s;

	/* instantiate gzip class */
	require_once 'php/_gzip.php';
	$gzip = new gzip;
	$gzip->dir = $_s->ctr;
	$gzip->file = "cache/".$_s->ctr."/boletim-".$_s->ctr.".gz";

	if (file_exists($gzip->file) && (int) date("d", filemtime($gzip->file)) == (int) date("d")):
		@readgzfile($gzip->file);
	else:

		$gzip->content = ''; 
		$gzip->content .= "<article class='excerpt-article'>";

			/* cURL */
			require_once 'php/_curl.php';
			$cURL = new cURL(array(
					'url' 		=> $url . "/_model-page-content.php",
					'data'		=> array( "slug" => 'boletim' ) ));
			$gzip->content .= $cURL->exec();

			/* init aluno class */
			require_once 'php/aluno.class.php';
			$aluno = new aluno($_s->codUnidade, $_s->codCurso, $_s->ctr);
			$aluno->getAluno();
			$aluno->getModulos();

			/* --------------------- */
			/* Table of notes
			/* ------------------- */
			$gzip->content .= '<table id="listaNotas">';
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
				$gzip->content .= "<tr class='".$class."'>";
				$gzip->content .= "<td class='nota'>".$nota."</td><td class='modulo'>".$m->descricao."</td>";
				$gzip->content .= "</tr>";
			endforeach;
			$gzip->content .= '</table>';
		$gzip->content .= "</article>";

		/* write gzip file */
		$gzip->write();
		echo $gzip->content;

	endif; ?>