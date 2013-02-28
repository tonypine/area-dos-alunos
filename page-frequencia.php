<?php get_header(); ?>

	<div id="content" class="cf">
		<?php include('sidebar-nav.php'); 
			session_start();
			require_once 'php/conexao.php';
			require_once '/Conexoes/VerificaAlunos.php';
			require_once 'php/aluno.class.php';	
			$aluno = new aluno(); ?> 
		<div id="meio">
            <article class="excerpt-article">
				<h2>Frequência</h2>
            	<?php
            		while(have_posts()): the_post();
            			the_content();
            		endwhile; ?>
				
				<!-- =========================================== -->
				<!-- Porcentagem de faltas por módulo -->
				<!-- =========================================== -->
				<?php $aluno->getFrequency(); ?>
				<h4>Frequência por módulo</h4>
				<table id="listaFaltas">
					<thead>
						<tr>
							<td>Módulo</td>
							<td>Porcentagem</td>
							<td>Aulas</td>
						</tr>
					</thead>
					<tbody>
						<?php
							/* --------------------- */
							/* loop de faltas
							/* ------------------- */
							foreach($aluno->freq->modulos as $key => $m):
								echo "<tr>";
								echo "<td class='dataFalta'>".$m->nome."</td>";
								echo "<td class='modulo'>".$m->numAulas."</td>";
								echo "<td class='modulo'>".$m->numAulas."</td>";
								echo "</tr>";
							endforeach;
							echo '</table>'
						?>
					</tbody>
				</table>
				
				<!-- ============================ -->
				<!-- Lista de Faltas -->
				<!-- ============================ -->
				<h4>Lista de faltas</h4>
				<table id="listaFaltas">
					<thead>
						<tr>
							<td>Data da falta</td>
							<td>Módulo</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<?php
							/* --------------------- */
							/* loop de faltas
							/* ------------------- */
							foreach($aluno->freq->faltas as $key => $f):
								echo "<tr>";
								echo "<td class='dataFalta'>".$f->data."</td>";
								echo "<td class='modulo'>".$f->modulo."</td>";
								echo "</tr>";
							endforeach;
							echo '</table>'
						?>
					</tbody>
				</table>
            </article>
		</div>
		<?php include('sidebar-right.php'); ?>
	</div>


<?php include 'footer.php'; ?>