<?php
    /**
     * Passarelli Advocacia *
     * @author      Rafael Benites <rbenites@gestaoativa.com.br>
     * @author      Marcelo Meneguesso <marcelo@gestaoativa.com.br>
     * @author      Mahmod A. Issa <muh@gestaoativa.com.br>
     */

    // Inclusão do template de cabeçalho do projeto
    include_once dirname(dirname(dirname(__FILE__))).'/template/head.inc.php';
    
    if (isset($item)) {
        include dirname(__FILE__) . '/item.inc.php';
    }
    else {
        include dirname(__FILE__) . '/list.inc.php';
    }
    
	/**
	 * Inclusão do template de rodapé do projeto
	 */
	include_once TPL_PATH . '/footer.inc.php';
