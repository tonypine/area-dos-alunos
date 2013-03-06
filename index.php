<?php get_header(); ?>

	<div id="content" class="cf">
		<?php if($_SESSION['logged']):
				include('sidebar-nav.php');
				include('content.php');
				include('sidebar-right.php'); 
			endif; ?>
	</div>


<?php include 'footer.php'; ?>