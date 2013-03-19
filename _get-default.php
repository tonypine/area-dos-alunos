<?php 

    /* load get variables */
    import_request_variables('g');

    /* load wp environment */
    $loadFile = "../../../wp-load.php";
    if (file_exists($loadFile))
        require_once($loadFile);

    /* ======================================== */
    /* query */
    /* ====================================== */

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

    /* ======================================== */
    /* Header */
    /* ====================================== */

    $output = '';
    $output .= "<header><h1>".$cat->name."</h1>";
        // $output .= $paginacao;
        $output .= "<hr class='bottomLine'>";
    $output .= "</header>";

    /* ======================================== */
    /* The Loop */
    /* ====================================== */

    while ($q->have_posts()): $q->the_post();
        $output .= showPost();
    endwhile;
    $output .= "<hr>";
    $output .= $paginacao;

    echo $output; ?>