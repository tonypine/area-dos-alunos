
	<?php 

    import_request_variables('g');


    $loadFile = "../../../wp-load.php";
    if (file_exists($loadFile))
        require_once($loadFile);

    $url = get_bloginfo('wpurl');
    $cat = get_category_by_slug( $slug );

    echo "<header><h1>".$cat->name."</h1>";
    echo "<p><strong>".$cat->count."</strong> posts publicados.</p>";
    echo "</header>";
    echo "<hr>";

    $args = array(
            'post_type'     =>  'post',
            'category_name' =>  $slug
        );

    $q = new WP_Query( $args );

	$numPosts = $q->found_posts;
	$i = 0;
	while ($q->have_posts()): $q->the_post();

        $pLink = $url."/#/post/".basename(get_permalink());

		$i++; 
        $c = get_the_category();
        $c = array_slice( $c, 0, 5 );	?>

        <article class="excerpt-article">
            <h3><a href="<?php echo $pLink; ?>"><?php the_title(); ?></a></h3>
            <div class="excerpt-info">
                <span class="date"><?php echo get_the_date(); ?></span>
                <span class="cat">Categoria:
                	<?php 
                		$iCat = 0;
                		$catLength = (int) sizeof($c);
                		foreach ($c as $cat) {
                			$iCat++;
                			echo "<a href='".$url."/#/".basename(get_category_link($cat->term_id ))."'>".$cat->name."<a/>";
                			if($iCat < $catLength) echo ", ";
                		} ?>
                        <!--_.each(p.cat, function (c) { i++; }}
                            <a href="{{ siteUrl }}/#/categoria/{{ c.slug }}">{{ c.cat_name }}</a>
                            {{# if(i < p.cat.length) }},
                    {{# }); }}-->
                </span>
            </div>
            <div class="excerpt-text">
                <?php echo get_the_excerpt(); ?>
            </div>
            <?php if(has_post_thumbnail()): ?>
                <a class="excerpt-thumb" href="<?php echo $pLink; ?>" title="<?php the_title(); ?>">
                    <?php the_post_thumbnail( $size = 'excerpt-thumb', $attr = '' ) ?>
                </a>
            <?php endif; ?>
            <a class="leiaMais" href="<?php echo $pLink; ?>">continuar lendo →</a>
        </article>
		<?php if($i < $numPosts) echo "<hr>";

	endwhile; ?>