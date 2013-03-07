
	<?php 

    import_request_variables('g');

    $loadFile = "../../../wp-load.php";
    if (file_exists($loadFile))
        require_once($loadFile);

    $bArgs = array(
            'post_type'     => 'post'
        );

    $bQuery = new WP_Query( $bArgs );

	$numPosts = $bQuery->found_posts;
	$i = 0;
	while ($bQuery->have_posts()): $bQuery->the_post();

		$i++; 
        $c = get_the_category();
        $c = array_slice( $c, 0, 5 );	?>

        <article class="excerpt-article">
            <h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="excerpt-info">
                <span class="date"><?php echo get_the_date(); ?></span>
                <span class="cat">Categoria:
                	<?php 
                		$iCat = 0;
                		$catLength = (int) sizeof($c);
                		foreach ($c as $cat) {
                			$iCat++;
                			echo "<a href='".get_category_link($cat->term_id )."'>".$cat->name."<a/>";
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
                <a class="excerpt-thumb" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php the_post_thumbnail( $size = 'excerpt-thumb', $attr = '' ) ?>
                </a>
            <?php endif; ?>
            <a class="leiaMais" href="{{ siteUrl }}/#/post/{{ p.slug }}">continuar lendo →</a>
        </article>
		<?php if($i < $numPosts) echo "<hr>";

	endwhile; ?>