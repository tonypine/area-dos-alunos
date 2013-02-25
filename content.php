<?php
	require_once 'php/conexao.php';
	require_once 'php/aluno.class.php';	
	$aluno = new aluno(); ?> 
<div id="meio">
	<?php 
		$numPosts = $wp_query->found_posts;
		$i = 0;
		while (have_posts()): the_post();

			$i++; 
	        $c = get_the_category();
	        $c = array_slice( $c, 0, 5 );	?>

            <article class="excerpt-article">
                <h3><a class="titleLink" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                <div class="excerpt-info">
                    <span class="date"><?php echo get_the_date(); ?></span>
                    <span class="cat">Categoria:
                    	<?php foreach ($c as $cat) {
                    		echo "<a href='".get_category_link($cat->term_id )."'>".$cat->name."<a/>";
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
	<pre><?php //echo var_dump($aluno->info); ?></pre>
</div>