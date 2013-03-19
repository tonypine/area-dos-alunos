<?php

	/* load get variables */
	import_request_variables('g');
	$_s = (object) $_s;

	/* instantiate gzip class */
	require_once 'php/_gzip.php';
	$gzip = new gzip;
	$gzip->dir = $_s->ctr;
	$gzip->file = "cache/".$_s->ctr."/cronograma-".$_s->ctr.".gz";

	if (file_exists($gzip->file) && (int) date("d", filemtime($gzip->file)) == (int) date("d")):
		@readgzfile($gzip->file);
	else:

		$gzip->content = ''; 
		$gzip->content .= "<article class='excerpt-article'>";

			/* cURL */
			require_once 'php/_curl.php';
			$cURL = new cURL(array(
					'url' 		=> $url . "/_model-page-content.php",
					'data'		=> array( "slug" => 'cronograma' ) ));
			$gzip->content .= $cURL->exec();

			/* init aluno class */
			require_once 'php/aluno.class.php';
			$aluno = new aluno($_s->codUnidade, $_s->codCurso, $_s->ctr);
			$aluno->getAluno();
			$aluno->doQueryAulas();
			$aluno->setupCronogram(); 

			/* =========================================== */
			/* Porcentagem de faltas por módulo */
			/* =========================================== */

			$gzip->content .= "<ul>";

			foreach ($aluno->cron as $key => $m):
				
				$gzip->content .= "<li class=''>";
					$gzip->content .= "<h4>". $m->name ."</h4>";
					$gzip->content .= "<table id='listaFaltas'>";
						$gzip->content .= "<thead>";
							$gzip->content .= "<tr>";
								$gzip->content .= "<td>Data</td>";
								$gzip->content .= "<td>Descrição</td>";
							$gzip->content .= "</tr>";
						$gzip->content .= "</thead>";
						$gzip->content .= "<tbody>";

							foreach ($m->aulas as $key => $a):

								$presenca = "falta";	
								if($a->presenca)
									$presenca = "presente";
								$gzip->content .= "<tr class='".$presenca."'>";
								$gzip->content .= "<td class='data'>".$a->data."</td>";
								$gzip->content .= "<td class='desc'>".$a->descricao."</td>";
								$gzip->content .= "</tr>";
								
							endforeach;

						$gzip->content .= "</tbody>";
					$gzip->content .= "</table>";
				 $gzip->content .= "</li>";

			endforeach;

			$gzip->content .= "</ul>";
		$gzip->content .= "</article>";

		/* write gzip file */
		$gzip->write();
		echo $gzip->content;

	endif;