<?php    

    import_request_variables('p');

    $loadFile = "../../../wp-load.php";
    if (file_exists($loadFile))
        require_once($loadFile);

    $url = get_bloginfo('wpurl');

    /* ======================================== */
    /* query */
    /* ====================================== */

	$args = array(
            'post_type'     =>  'page',
            'pagename'      =>  $slug
        );

    $q = new WP_Query( $args );

    /* ======================================== */
    /* The Loop */
    /* ====================================== */

    while ($q->have_posts()): $q->the_post();
        require_once '_part-page-loop.php';
    endwhile; ?>