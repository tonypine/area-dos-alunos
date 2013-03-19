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
        <?php $u = get_bloginfo('template_url'); ?>


        <form target="sendiFrame" id="frmTrabalhe" class="customForm" action="<?php echo $u; ?>/sendMail.php" method="post" enctype="multipart/form-data">
            <div class="innerBorder">
            
                <input type="hidden" value="2" name="typeForm" />
                <iframe src="<?php echo $u; ?>/sendMail.php" class="iframeForm" name="sendiFrame" scrolling="no" height='0'></iframe>   
                
                <label for="nome">Nome completo:</label>
                <input class="cInput validate" name="nome" type="text" placeholder="" />

                <label for="email">E-Mail:</label>
                <input class="cInput validate" name="email" type="text" placeholder="email@example.com" />

                <label for="cidade">Cidade:</label>
                <input class="cInput validate" name="cidade" type="text" placeholder="" />

                <label for="estado">Estado:</label>
                <input class="cInput validate" name="estado" type="text" placeholder="" />
                
                <label for="ufile">Currículo:</label>
                <input class="customFile validate" name="ufile" type="file" />
                
                <label for="carta">Carta de apresentação:</label>
                <textarea class="cTextArea validate" name="carta" placeholder="Carta de apresentação"></textarea>
                
                <input class="cBtn" type="submit" value="enviar"/>

                <div id="frmBoxMessage">
                    <span id="frmMsg">
                        <img class="loader" src="<?php echo $u; ?>/images/ajax-loader-white.gif" />
                        Enviando...
                    </span>
                </div>
                
            </div>
        </form>

    <?php endwhile; ?>