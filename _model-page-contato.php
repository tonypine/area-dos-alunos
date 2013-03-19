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
    /* Page Loop */
    /* ====================================== */

    while ($q->have_posts()): $q->the_post(); 
        require_once '_part-page-loop.php';
    endwhile;

    /* ======================================== */
    /* Formulário de Contato */
    /* ====================================== */ ?>

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
