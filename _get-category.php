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
	$output .= "</header>";
	$output .= $paginacao;
	$output .= "<hr>";

	/* ======================================== */
	/* The Loop */
	/* ====================================== */

	$numPosts = $q->found_posts;
	$i = 0;

	while ($q->have_posts()): $q->the_post();

		$pLink = $url."/#/post/".basename(get_permalink());

		$i++; 
		$c = get_the_category();
		$c = array_slice( $c, 0, 5 );

		$output .= "<article class='excerpt-article'>";
			$output .= "<h3><a href='". $pLink ."'>". get_the_title() ."</a></h3>";
			$output .= "<div class='excerpt-info'>";
				$output .= "<span class='date'>". get_the_date() ."</span>";
				$output .= "<span class='cat'>Categoria:";

					$iCat = 0;
					$catLength = (int) sizeof($c);
					foreach ($c as $cat) {
						$iCat++;
						$output .= "<a href='".$url."/#/".basename(get_category_link($cat->term_id ))."'>".$cat->name."<a/>";
						if($iCat < $catLength) $output .= ", ";
					}

				$output .= "</span>";
			$output .= "</div>";
			$output .= "<div class='excerpt-text'>";
				$output .= get_the_excerpt();
			$output .= "</div>";
			
			if(has_post_thumbnail()):
				$output .= "<a class='excerpt-thumb' href='". $pLink ."' title='". get_the_title() ."'>";
					$output .= get_the_post_thumbnail( $post_id = get_the_ID(), $size = 'excerpt-thumb', $attr = '' );
				$output .= "</a>";
			endif;
			
			$output .= "<a class='leiaMais' href='". $pLink ."'>continuar lendo →</a>";
		$output .= "</article>";
		if($i < $numPosts) $output .= "<hr>";

	endwhile; 

	/* append navegacao in the end of loop */
	$output .= $paginacao;

	echo $output;