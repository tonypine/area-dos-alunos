<?php 

	/* load get variables */
	import_request_variables('g');

	/* load wp environment */
	$loadFile = "../../../wp-load.php";
	if (file_exists($loadFile))
		require_once($loadFile);

	$url = get_bloginfo('wpurl');

	/* ======================================== */
	/* query */
	/* ====================================== */

	$cat = get_category_by_slug( $slug );
	$args = array(
			'post_type'     	=>  'post',
			'category_name' 	=>  $slug,
			'posts_per_page'	=> 	5,
			'paged'				=>	$p
		);

	$q = new WP_Query( $args );

	/* ======================================== */
	/* generate paginação */
	/* ====================================== */

	require_once '_model-paginacao.php';

	/* ======================================== */
	/* Header */
	/* ====================================== */

	$output .= "<header><h1>".$cat->name."</h1>";
		$output .= "<p><strong>".$cat->count."</strong> posts publicados.</p>";
		$output .= $paginacao;
		$output .= "<hr class='bottomLine'>";
	$output .= "</header>";

	/* ======================================== */
	/* The Loop */
	/* ====================================== */

	$numPosts = $q->found_posts;
	$i = 0;
    $url = get_bloginfo('wpurl');
    
    require '_model-article-loop.php';
    require '_model-paginacao.php';

	while ($q->have_posts()): $q->the_post();
        $output .= showPost();
	endwhile; 

	/* append navegacao in the end of loop */
	$output .= $paginacao;

	echo $output; ?>