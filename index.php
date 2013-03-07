<?php get_header(); ?>

	<div id="content" class="cf">
		<?php if($_SESSION['logged']):
				include('sidebar-nav.php');
				echo "<div id='meio'><article class='excerpt-article'><h1>Loading ...</h1></article></div>";
				include('sidebar-right.php'); 
			endif; ?>
	</div>


<?php include 'footer.php'; ?>