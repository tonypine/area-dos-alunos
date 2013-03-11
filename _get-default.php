
	<?php 

    import_request_variables('g');

    $loadFile = "../../../wp-load.php";
    if (file_exists($loadFile))
        require_once($loadFile);

    $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => 5,
            'paged'             => $p
        );

    $q = new WP_Query( $args );

	$numPosts = $q->found_posts;
    $url = get_bloginfo('wpurl');
    
    require '_model-article-loop.php';
    require '_model-paginacao.php';

    $output = '';
    $output .= $paginacao;
    $output .= "<hr>";
    while ($q->have_posts()): $q->the_post();
        $output .= showPost();
    endwhile;
    $output .= "<hr>";
    $output .= $paginacao;

    echo $output;
    ?>