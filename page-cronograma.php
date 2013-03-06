<?php get_header(); ?>

	<div id="content" class="cf">
		<?php 
		if($logged):
			include('sidebar-nav.php'); ?> 
			<div id="meio">
	            <article class="excerpt-article">

	            	<?php
            		while(have_posts()): the_post();
            			echo "<h1>".get_the_title()."</h1>";
            			the_content();
            		endwhile; 

					$aluno->doQueryAulas();
					$aluno->setupCronogram(); ?>

					<!-- =========================================== -->
					<!-- Porcentagem de faltas por módulo -->
					<!-- =========================================== -->
					<?php 
					$qTest = $mysqli->query("SELECT *
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
			</div>
			<?php 
			include('sidebar-right.php'); 
		endif; ?>
	</div>
<?php include 'footer.php'; ?>