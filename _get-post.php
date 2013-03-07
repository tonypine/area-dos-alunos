<?php 

    import_request_variables('g');

    $loadFile = "../../../wp-load.php";
    if (file_exists($loadFile))
        require_once($loadFile);

    $args = array(
            'post_type'     =>  'post',
            'name'          =>  $slug
        );

    $q = new WP_Query( $args );

    while ($q->have_posts()): $q->the_post();

        $c = get_the_category();
        $c = array_slice( $c, 0, 5 );   ?>

        <article>
            <h2><?php the_title(); ?></h2>
            <section class="excerpt-info">
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
            </section>
            <section class="content">
                <?php the_content(); ?>
            </section>
            <section id="comments">
                <?php 
                    $comments = get_comments( array(
                        'status'    =>  'approve',
                        'post_id'   =>  get_the_ID()
                    ) );

                    //if has comments
                    echo "<hr>";
                    if(sizeof($comments) > 0):
                        echo "<h3>Comentários</h3>";
                        echo "<ul class='commentlist'>";
                        //Display the list of comments
                        wp_list_comments(array(
                            'per_page' => 10, //Allow comment pagination
                            'reverse_top_level' => false, //Show the latest comments at the top of the list
                            'type' => 'comment',
                            'callback' => 'mytheme_comment',
                            'avatar_size' => 44
                        ), $comments);
                        echo "</ul>";
                    endif;
                    setcom_comment_form(array(
                        'title_reply' => 'Deixe um comentário',
                        'title_reply_to' => 'Deixe uma resposta'
                    ), $postID);
                ?>
            </section>
        </article>

    <?php endwhile; ?>