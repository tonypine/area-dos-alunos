<?php

	/* load get variables */
	import_request_variables('g');
	$_s = (object) $_s;

	/* instantiate gzip class */
	require_once 'php/_gzip.php';
	$gzip = new gzip;
	$gzip->dir = $_s->ctr;
	$gzip->file = "cache/".$_s->ctr."/frequencia-".$_s->ctr.".gz";

	if (file_exists($gzip->file) && (int) date("d", filemtime($gzip->file)) == (int) date("d")):
		@readgzfile($gzip->file);
	else:

		$loadFile = "../../../wp-load.php";
		if (file_exists($loadFile))
		    require_once($loadFile);

		$gzip->content = ''; 
		$gzip->content .= "<article class='excerpt-article'>";

			/* cURL */
			require_once 'php/_curl.php';
			$cURL = new cURL(array(
					'url' 		=> $url . "/_model-page-content.php",
					'data'		=> array( "slug" => 'frequencia' ) ));
			$gzip->content .= $cURL->exec();

			// echo $_s->codUnidade .'-'. $_s->codCurso .'-'. $_s->ctr;

			/* init aluno class */
			require_once 'php/aluno.class.php';
			$aluno = new aluno($_s->codUnidade, $_s->codCurso, $_s->ctr);
			$aluno->getAluno();
			$aluno->doQueryAulas();
			$aluno->getFrequency();	
			
			/* =========================================== */
			/* Frequência no curso todo */
			/* =========================================== */

			$gzip->content .= "<div class='freqPercent'>";
				$gzip->content .= "<h4>Frequência no curso inteiro</h4>";
				$gzip->content .= "<div class='percentBar'>";

					$p = $aluno->freq->totalPorcentagem;
					$class = "bar";
					if($p < 75) $class .= " red";
					else $class .= " green";

					$gzip->content .= "<div class='".$class."' style='width: ".$p."%;'></div>";
				$gzip->content .= "</div>";
				$gzip->content .= "<p class='num'>".$aluno->freq->totalPorcentagem."%</p>";
			$gzip->content .= "</div>";
			$gzip->content .= "<table id='listaFaltas'>";
				$gzip->content .= "<thead>";
					$gzip->content .= "<tr>";
						$gzip->content .= "<td>Total de Aulas</td>";
						$gzip->content .= "<td>Total de Presenças</td>";
						$gzip->content .= "<td>Total de Faltas</td>";
					$gzip->content .= "</tr>";
				$gzip->content .= "</thead>";
				$gzip->content .= "<tbody>";
					$gzip->content .= "<tr>";
					$gzip->content .= "<td class='modulo'>".$aluno->freq->total."</td>";
					$gzip->content .= "<td class='modulo'>".$aluno->freq->totalPresencas."</td>";
					$gzip->content .= "<td class='modulo'>".$aluno->freq->totalFaltas."</td>";
					$gzip->content .= "</tr>";
				$gzip->content .= "</tbody>";
			$gzip->content .= "</table>";

			/* Se a a frequência é menor que 75%, procure a coordenação */
			if($p < 75)
				$gzip->content .= "<p class='badAlert'>Você tem apenas ".$p."% de presenças, <strong>procure a coordenação</strong> o quanto antes para marcar sua reposição.</p>";

			/* =========================================== */
			/* Porcentagem de faltas por módulo */
			/* =========================================== */
			
			$gzip->content .= "<h3>Frquência por módulo</h3>";
			$gzip->content .= "<ul>";

			foreach ($aluno->freq->modulos as $key => $m): 
				$liClass = '';
				if(!$m->iniciado):
					$liModClass = 'disabled'; 
					$naoIniciado = ' (módulo não iniciado)';
				endif;

				$gzip->content .= "<li class='".$liModClass."'>";
					$gzip->content .= "<div class='freqMiniPercent'>";
						$gzip->content .= "<h4>".$m->name . $naoIniciado."</h4>";
						$gzip->content .= "<div class='percentBar'>";

							$p = $m->porcentagem;
							$class = "bar";
							if($p < 75) $class .= " red";
							else $class .= " green";

							$gzip->content .= "<div class='".$class."' style='width: ".$p."%'></div>";
						$gzip->content .= "</div>";
						$gzip->content .= "<p class='num'>".$p."%</p>";
					$gzip->content .= "</div>";
					$gzip->content .= "<table id='listaFaltas'>";
						$gzip->content .= "<thead>";
							$gzip->content .= "<tr>";
								$gzip->content .= "<td>Total de Aulas</td>";
								$gzip->content .= "<td>Presenças</td>";
								$gzip->content .= "<td>Faltas</td>";
							$gzip->content .= "</tr>";
						$gzip->content .= "</thead>";
						$gzip->content .= "<tbody>";
							$gzip->content .= "<tr>";
							$gzip->content .= "<td class='modulo'>".$m->total."</td>";
							$gzip->content .= "<td class='modulo'>".$m->presencas."</td>";
							$gzip->content .= "<td class='modulo'>".$m->faltas."</td>";
							$gzip->content .= "</tr>";
							$gzip->content .= '</table>';
						$gzip->content .= "</tbody>";
					$gzip->content .= "</table>";
				$gzip->content .= "</li>";
			endforeach;
			
			$gzip->content .= "</ul>";
			
			/* ============================ */
			/* Lista de Faltas */
			/* ============================ */

			$gzip->content .= "<h3>Lista de faltas</h3>";
			$gzip->content .= "<table id='listaFaltas'>";
				$gzip->content .= "<thead>";
					$gzip->content .= "<tr>";
						$gzip->content .= "<td>Data da falta</td>";
						$gzip->content .= "<td>Módulo</td>";
					$gzip->content .= "</tr>";
				$gzip->content .= "</thead>";
				$gzip->content .= "<tbody>";

					/* --------------------- */
					/* loop de faltas
					/* ------------------- */
					foreach($aluno->freq->faltas as $key => $f):
						$gzip->content .= "<tr>";
						$gzip->content .= "<td class='dataFalta'>".$f->falta."</td>";
						$gzip->content .= "<td class='modulo'>".utf8_encode( formatText( $f->modulo ) )."</td>";
						$gzip->content .= "</tr>";
					endforeach;

				$gzip->content .= "</tbody>";
			$gzip->content .= "</table>";
		$gzip->content .= "</article>";

		/* write gzip file */
		$gzip->write();
		echo $gzip->content;

	endif;