<?php

	import_request_variables('g');
	$_s = (object) $_s;
	$gzfile = "cache/".$_s->ctr."/cronograma-".$_s->ctr.".gz";

	if (file_exists($gzfile) && (int) date("d", filemtime($gzfile)) == (int) date("d")):
		@readgzfile($gzfile);
	else:
		$loadFile = "../../../wp-load.php";
		if (file_exists($loadFile))
		    require_once($loadFile);

		$output = ''; 
		$output .= "<article class='excerpt-article'>";
			$output .= "<header>";
				$output .= "<h1>Cronograma</h1>";
				$output .= "<hr class='bottomLine'>";
			$output .= "</header>";

			$q = new WP_Query( array(
					'post_type'		=> 'page',
					'pagename'		=> 'cronograma'
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
			$aluno->setupCronogram(); 

			/* =========================================== */
			/* Query Teste */
			/* =========================================== */

			/*$qTest = $aluno->mysqli->query("SELECT *
								FROM 
									TAB00208 a
								LIMIT 0,1");

			while(!$q = $qTest->fetch_object()):
				foreach ($q as $key => $v):
					echo $key." => ";
					var_dump($v);
					echo "<br>";
				endforeach;
			endwhile; */

			/* =========================================== */
			/* Porcentagem de faltas por módulo */
			/* =========================================== */

			$output .= "<ul>";

			foreach ($aluno->cron as $key => $m):
				
				$output .= "<li class='". $liModClass ."'>";
					$output .= "<h4>". $m->name ."</h4>";
					$output .= "<table id='listaFaltas'>";
						$output .= "<thead>";
							$output .= "<tr>";
								$output .= "<td>Data</td>";
								$output .= "<td>Descrição</td>";
							$output .= "</tr>";
						$output .= "</thead>";
						$output .= "<tbody>";

							foreach ($m->aulas as $key => $a):

								$presenca = "falta";	
								if($a->presenca)
									$presenca = "presente";
								$output .= "<tr class='".$presenca."'>";
								$output .= "<td class='data'>".$a->data."</td>";
								$output .= "<td class='desc'>".$a->descricao."</td>";
								$output .= "</tr>";
								
							endforeach;

						$output .= "</tbody>";
					$output .= "</table>";
				 $output .= "</li>";

			endforeach;

			$output .= "</ul>";
		$output .= "</article>";

		if(!is_dir("cache/".$_s->ctr."/"))
			mkdir("cache/".$_s->ctr."/");

		$fp = gzopen($gzfile, 'w9');
		gzwrite($fp, $output);
		gzclose($fp);

		echo $output;

	endif;