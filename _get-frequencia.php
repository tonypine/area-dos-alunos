<?php

	import_request_variables('g');
	$_s = (object) $_s;
	$gzfile = "cache/".$_s->ctr."/frequencia-".$_s->ctr.".gz";

	if (file_exists($gzfile) && (int) date("d", filemtime($gzfile)) == (int) date("d")):
		@readgzfile($gzfile);
	else:
		$loadFile = "../../../wp-load.php";
		if (file_exists($loadFile))
		    require_once($loadFile);

		$output = ''; 
		$output .= "<article class='excerpt-article'>";
			$output .= "<header>";
				$output .= "<h1>Frequência</h1>";
				$output .= "<hr class='bottomLine'>";
			$output .= "</header>";

			$q = new WP_Query( array(
					'post_type'		=> 'page',
					'pagename'		=> 'frequencia'
				) );

			while($q->have_posts()): $q->the_post();
				$output .= "<p>";
				$output .= get_the_content();
				$output .= "</p>";
			endwhile;

			require_once 'php/aluno.class.php';

			$aluno = new aluno($_s->codUnidade, $_s->codCurso, $_s->ctr);
			$aluno->getAluno();
			$aluno->doQueryAulas();
			$aluno->getFrequency();	

			/* =========================================== */
			/* Frequência no curso todo */
			/* =========================================== */

			$output .= "<div class='freqPercent'>";
				$output .= "<h4>Frequência no curso inteiro</h4>";
				$output .= "<div class='percentBar'>";

					$p = $aluno->freq->totalPorcentagem;
					$class = "bar";
					if($p < 75) $class .= " red";
					else $class .= " green";

					$output .= "<div class='".$class."' style='width: ".$p."%;'></div>";
				$output .= "</div>";
				$output .= "<p class='num'>".$aluno->freq->totalPorcentagem."%</p>";
			$output .= "</div>";
			$output .= "<table id='listaFaltas'>";
				$output .= "<thead>";
					$output .= "<tr>";
						$output .= "<td>Total de Aulas</td>";
						$output .= "<td>Total de Presenças</td>";
						$output .= "<td>Total de Faltas</td>";
					$output .= "</tr>";
				$output .= "</thead>";
				$output .= "<tbody>";
					$output .= "<tr>";
					$output .= "<td class='modulo'>".$aluno->freq->total."</td>";
					$output .= "<td class='modulo'>".$aluno->freq->totalPresencas."</td>";
					$output .= "<td class='modulo'>".$aluno->freq->totalFaltas."</td>";
					$output .= "</tr>";
				$output .= "</tbody>";
			$output .= "</table>";

			/* Se a a frequência é menor que 75%, procure a coordenação */
			if($p < 75)
				$output .= "<p class='badAlert'>Você tem apenas ".$p."% de presenças, <strong>procure a coordenação</strong> o quanto antes para marcar sua reposição.</p>";

			/* =========================================== */
			/* Porcentagem de faltas por módulo */
			/* =========================================== */
			
			$output .= "<h3>Frquência por módulo</h3>";
			$output .= "<ul>";

			foreach ($aluno->freq->modulos as $key => $m): 
				$liClass = '';
				if(!$m->iniciado):
					$liModClass = 'disabled'; 
					$naoIniciado = ' (módulo não iniciado)';
				endif;

				$output .= "<li class='".$liModClass."'>";
					$output .= "<div class='freqMiniPercent'>";
						$output .= "<h4>".$m->name . $naoIniciado."</h4>";
						$output .= "<div class='percentBar'>";

							$p = $m->porcentagem;
							$class = "bar";
							if($p < 75) $class .= " red";
							else $class .= " green";

							$output .= "<div class='".$class."' style='width: ".$p."%'></div>";
						$output .= "</div>";
						$output .= "<p class='num'>".$p."%</p>";
					$output .= "</div>";
					$output .= "<table id='listaFaltas'>";
						$output .= "<thead>";
							$output .= "<tr>";
								$output .= "<td>Total de Aulas</td>";
								$output .= "<td>Presenças</td>";
								$output .= "<td>Faltas</td>";
							$output .= "</tr>";
						$output .= "</thead>";
						$output .= "<tbody>";
							$output .= "<tr>";
							$output .= "<td class='modulo'>".$m->total."</td>";
							$output .= "<td class='modulo'>".$m->presencas."</td>";
							$output .= "<td class='modulo'>".$m->faltas."</td>";
							$output .= "</tr>";
							$output .= '</table>';
						$output .= "</tbody>";
					$output .= "</table>";
				$output .= "</li>";
			endforeach;
			
			$output .= "</ul>";
			
			/* ============================ */
			/* Lista de Faltas */
			/* ============================ */

			$output .= "<h3>Lista de faltas</h3>";
			$output .= "<table id='listaFaltas'>";
				$output .= "<thead>";
					$output .= "<tr>";
						$output .= "<td>Data da falta</td>";
						$output .= "<td>Módulo</td>";
					$output .= "</tr>";
				$output .= "</thead>";
				$output .= "<tbody>";

					/* --------------------- */
					/* loop de faltas
					/* ------------------- */
					foreach($aluno->freq->faltas as $key => $f):
						$output .= "<tr>";
						$output .= "<td class='dataFalta'>".$f->falta."</td>";
						$output .= "<td class='modulo'>".utf8_encode( formatText( $f->modulo ) )."</td>";
						$output .= "</tr>";
					endforeach;

				$output .= "</tbody>";
			$output .= "</table>";
		$output .= "</article>";

		if(!is_dir("cache/".$_s->ctr."/"))
			mkdir("cache/".$_s->ctr."/");

		$fp = gzopen($gzfile, 'w9');
		gzwrite($fp, $output);
		gzclose($fp);

		echo $output;

	endif;