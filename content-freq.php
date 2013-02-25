<?php
	require_once 'php/conexao.php';
	require_once 'php/aluno.class.php';	
	$aluno = new aluno(); 
	?> 
<div id="meio">
	<h1 class="big">Frequência</h1>
	<table>
		<?php $aluno->getFreq(); ?>
			<tr>
				
			</tr>
			<?php foreach ($aluno->freq as $f): ?>
				<tr>
					<td><?php 
							$dt = preg_split("/ /", $f->data);
							echo $dt[0]; 
							?></td>
					<td><?php echo $f->modulo; ?></td>
				</tr>
		<?php endforeach; ?>
	</table>
	<h3>Lista de faltas</h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>