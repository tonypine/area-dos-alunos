<?php get_header(); ?>

	<div id="content" class="cf">
		<?php 
			include('sidebar-nav.php'); 
			require_once 'php/conexao.php';
			require_once 'php/aluno.class.php';	
			$aluno = new aluno(); ?> 
		<div id="meio">
            <article class="excerpt-article">
				<h2>Frequência</h2>
            	<?php
            		while(have_posts()): the_post();
            			the_content();
            		endwhile; 

					$aluno->getAluno();
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
				
				<ul>
				<?php foreach ($aluno->freq->modulos as $key => $m): 
					$liClass = '';
					if(!$m->iniciado) $liModClass = 'disabled'; ?>
					<li class="<?php echo $liModClass; ?>">
						<div class="freqMiniPercent">
							<h4><?php echo $m->name; ?></h4>
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
									<td>Iniciado</td>
								</tr>
							</thead>
							<tbody>
								<?php
								echo "<tr>";
								echo "<td class='modulo'>".$m->total."</td>";
								echo "<td class='modulo'>".$m->presencas."</td>";
								echo "<td class='modulo'>".$m->faltas."</td>";
								echo "<td class='modulo'>".$m->iniciado."</td>";
								echo "</tr>";
								echo '</table>'
								?>
							</tbody>
						</table>
					</li>
				<?php endforeach; ?>
				</ul>

				<!-- =========================================== -->
				<!-- Frequência por módulo -->
				<!-- =========================================== -->

				<h3>Frequência por módulo</h3>
				<table id="listaFaltas">
					<thead>
						<tr>
							<td>Módulo</td>
							<td>Total</td>
							<td>Presenças</td>
							<td>Faltas</td>
							<td>Porcentagem</td>
						</tr>
					</thead>
					<tbody>
						<?php
						/* --------------------- */
						/* loop de faltas
						/* ------------------- */

						// echo "<tr><td>";
						// dump($aluno->freq->modulos);
						// echo "</td></tr>";

						foreach($aluno->freq->modulos as $key => $m):
							echo "<tr>";
							echo "<td class='dataFalta'>".$m->name."</td>";
							echo "<td class='modulo'>".$m->total."</td>";
							echo "<td class='modulo'>".$m->presencas."</td>";
							echo "<td class='modulo'>".$m->faltas."</td>";
							echo "<td class='modulo'>".$m->porcentagem."%</td>";
							echo "</tr>";
						endforeach;
						?>
					</tbody>
				</table>
				
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
		</div>
		<?php include('sidebar-right.php'); ?>
	</div>


<?php include 'footer.php'; ?>