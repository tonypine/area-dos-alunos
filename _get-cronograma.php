	<article class="excerpt-article">
		<h1>Cronograma</h1>
		<?php
		import_request_variables('g');

		$loadFile = "../../../wp-load.php";
		if (file_exists($loadFile))
		    require_once($loadFile);

		$args = array(
				'post_type'		=> 'page',
				'pagename'		=> 'cronograma'
			);

		$q = new WP_Query( $args );

		while($q->have_posts()): $q->the_post();
			the_content();
		endwhile; 

		require_once 'php/aluno.class.php';

		$_s = (object) $_s;
		$aluno = new aluno($_s->codUnidade, $_s->codCurso, $_s->ctr);
		$aluno->getAluno();
		$aluno->doQueryAulas();
		$aluno->setupCronogram(); ?>

		<!-- =========================================== -->
		<!-- Porcentagem de faltas por módulo -->
		<!-- =========================================== -->
		<?php 
		$qTest = $aluno->mysqli->query("SELECT *
							FROM 
								TAB00208 a
							LIMIT 0,1");
		while(!$q = $qTest->fetch_object()):
			foreach ($q as $key => $v):
				echo $key." => ";
				var_dump($v);
				echo "<br>";
			endforeach;
		endwhile; ?>
		<ul>
		<?php foreach ($aluno->cron as $key => $m): ?>
			<li class="<?php echo $liModClass; ?>">
				<h4><?php echo $m->name; ?></h4>
				<table id="listaFaltas">
					<thead>
						<tr>
							<td>Data</td>
							<td>Descrição</td>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($m->aulas as $key => $a):

							$presenca = "falta";	
							if($a->presenca)
								$presenca = "presente";
							echo "<tr class='".$presenca."'>";
							echo "<td class='data'>".$a->data."</td>";
							echo "<td class='desc'>".$a->descricao."</td>";
							echo "</tr>";
							
						endforeach;
						?>
					</tbody>
				</table>
			</li>
		<?php endforeach; ?>
		</ul>
	</article>