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

    <form target="sendiFrame" id="formContato" class="customForm" action="<?php url(); ?>/php/sendMail.php" method="post" enctype="multipart/form-data">
        <div class="innerBorder">
        
            <input type="hidden" value="1" name="typeForm" />
            
            <p>
            <label for="nome">Nome:</label>
            <input class="cInput validate" name="nome" type="text" placeholder="" /></p>

            <p>
            <label for="email">E-Mail:</label>
            <input class="cInput validate" name="email" type="text" placeholder="email@example.com" /></p>

            <p>
            <label for="cidade">Telefone:</label>
            <input class="cInput validate" name="tel" type="text" placeholder="" /></p>

            <p>
            <label for="estado">Assunto:</label>
            <input class="cInput validate" name="assunto" type="text" placeholder="" /></p>
            
            <p id="msgContato">
            <label for="carta">Mensagem:</label>
            <textarea class="cTextArea validate" name="message" placeholder="Carta de apresentação"></textarea></p>
            
            <p id="btnEnviar">            
                <input class="cBtn" type="submit" value="enviar"/></p>
            <iframe src="<?php url(); ?>/php/sendMail.php" class="iframeForm" name="sendiFrame" scrolling="no" style='float:left; margin-top: -5px' width='269' height='44px'></iframe>   

            <p id="frmBoxMessage">
                <span id="frmMsg">
                </span>
            </p>
            
        </div>
    </form>
