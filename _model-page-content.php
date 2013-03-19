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
            'pagename'      =>  $slug
        );

    $q = new WP_Query( $args );

    /* ======================================== */
    /* The Loop */
    /* ====================================== */

    while ($q->have_posts()): $q->the_post();

        $c = get_the_category();
        $c = array_slice( $c, 0, 5 );   ?>

        <article>
            <header>
                <h2><?php the_title(); ?></h2>
                <section class="excerpt-info">
                    <span class="date"><?php echo get_the_date(); ?></span>
                    <span class="cat">Categoria:
                        <?php 
                            $iCat = 0;
                            $catLength = (int) sizeof($c);
                            foreach ($c as $cat) {
                                $iCat++;
                                echo "<a href='".$url."/#/category/".basename(get_category_link($cat->term_id ))."'>".$cat->name."<a/>";
                                if($iCat < $catLength) echo ", ";
                            } ?>
                            <!--_.each(p.cat, function (c) { i++; }}
                                <a href="{{ siteUrl }}/#/categoria/{{ c.slug }}">{{ c.cat_name }}</a>
                                {{# if(i < p.cat.length) }},
                        {{# }); }}-->
                    </span>
                </section>
                <hr class="bottomLine">
            </header>
            <section class="content">
                <?php the_content(); ?>
            </section>
        </article>

    <?php endwhile; ?>