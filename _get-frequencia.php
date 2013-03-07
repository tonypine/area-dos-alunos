	<article class="excerpt-article">
		<h1>Frequência</h1>
		<?php
		import_request_variables('g');

		$loadFile = "../../../wp-load.php";
		if (file_exists($loadFile))
		    require_once($loadFile);

		$args = array(
				'post_type'		=> 'page',
				'pagename'		=> 'frequencia'
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
		$aluno->getFrequency();	?>

		<!-- =========================================== -->
		<!-- Frequência no curso todo -->
		<!-- =========================================== -->

		<div class="freqPercent">
			<h4>Frequência no curso inteiro</h4>
			<div class="percentBar">
				<?php 
				$p = $aluno->freq->totalPorcentagem;
				$class = "bar";
				if($p < 75)
					$class .= " red";
				else
					$class .= " green";
				?>
				<div class="<?php echo $class; ?>" style="width: <?php echo $p; ?>%;"></div>
			</div>
			<p class="num"><?php echo $aluno->freq->totalPorcentagem."%"; ?></p>
		</div>
		<table id="listaFaltas">
			<thead>
				<tr>
					<td>Total de Aulas</td>
					<td>Total de Presenças</td>
					<td>Total de Faltas</td>
				</tr>
			</thead>
			<tbody>
				<?php
				echo "<tr>";
				echo "<td class='modulo'>".$aluno->freq->total."</td>";
				echo "<td class='modulo'>".$aluno->freq->totalPresencas."</td>";
				echo "<td class='modulo'>".$aluno->freq->totalFaltas."</td>";
				echo "</tr>";
				echo '</table>'
				?>
			</tbody>
		</table>

		<!-- Se a a frequência é menor que 75%, procure a coordenação -->
		<?php if($p < 75)
				echo "<p class='badAlert'>Você tem apenas $p% de presenças, <strong>procure a coordenação</strong> o quanto antes para marcar sua reposição.</p>"; ?>

		<!-- =========================================== -->
		<!-- Porcentagem de faltas por módulo -->
		<!-- =========================================== -->
		
		<h3>Frquência por módulo</h3>
		<ul>
		<?php foreach ($aluno->freq->modulos as $key => $m): 
			$liClass = '';
			if(!$m->iniciado):
				$liModClass = 'disabled'; 
				$naoIniciado = ' (módulo não iniciado)';
			endif;
			?>
			<li class="<?php echo $liModClass; ?>">
				<div class="freqMiniPercent">
					<h4><?php echo $m->name . $naoIniciado; ?></h4>
					<div class="percentBar">
						<?php 
						$p = $m->porcentagem;
						$class = "bar";
						if($p < 75)
							$class .= " red";
						else
							$class .= " green";
						?>
						<div class="<?php echo $class; ?>" style="width: <?php echo $p; ?>%;"></div>
					</div>
					<p class="num"><?php echo $p."%"; ?></p>
				</div>
				<table id="listaFaltas">
					<thead>
						<tr>
							<td>Total de Aulas</td>
							<td>Presenças</td>
							<td>Faltas</td>
						</tr>
					</thead>
					<tbody>
						<?php
						echo "<tr>";
						echo "<td class='modulo'>".$m->total."</td>";
						echo "<td class='modulo'>".$m->presencas."</td>";
						echo "<td class='modulo'>".$m->faltas."</td>";
						echo "</tr>";
						echo '</table>'
						?>
					</tbody>
				</table>
			</li>
		<?php endforeach; ?>
		</ul>
		
		<!-- ============================ -->
		<!-- Lista de Faltas -->
		<!-- ============================ -->
		<h3>Lista de faltas</h3>
		<table id="listaFaltas">
			<thead>
				<tr>
					<td>Data da falta</td>
					<td>Módulo</td>
				</tr>
			</thead>
			<tbody>
				<?php
				/* --------------------- */
				/* loop de faltas
				/* ------------------- */
				foreach($aluno->freq->faltas as $key => $f):
					echo "<tr>";
					echo "<td class='dataFalta'>".$f->falta."</td>";
					echo "<td class='modulo'>".utf8_encode( formatText( $f->modulo ) )."</td>";
					echo "</tr>";
				endforeach;
				?>
			</tbody>
		</table>
	</article>