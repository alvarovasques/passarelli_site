<?php
    /**
     * Passarelli Advocacia *
     * @author      Rafael Benites <rbenites@gestaoativa.com.br>
     * @author      Marcelo Meneguesso <marcelo@gestaoativa.com.br>
     * @author      Mahmod A. Issa <muh@gestaoativa.com.br>
     */

    // Inclusão do template de cabeçalho do projeto
    include_once dirname(dirname(dirname(__FILE__))).'/template/head-home.inc.php';
    ?>
    <h1 class="hide">Passareli Advocacia</h1>
    <div class="aCenter menu-sombra">
        <a href="<?=HOME_URL?>/home" title="HOME-Passarelli Advocacia">
            <img src="<?=IMG_URL?>/logo.png" alt="Passarelli Advocacia" />
        </a>
        <hr class="space" />
        <ul class="home-menu">
            <li class="first">
                <a href="<?=HOME_URL?>/o-escritorio/" title="O Escritório">O Escritório</a>
            </li>
            <li>
                <a href="<?=HOME_URL?>/advogados/" title="Advogados"> Advogados</a>
            </li>
            <li>
                <a href="<?=HOME_URL?>/areas-de-atuacao/" title="Áreas de Atuação">Áreas de Atuação</a>
            </li>
            <li>
                <a href="<?=HOME_URL?>/artigos/" title="Artigos">Artigos</a>
            </li>
            <li>
                <a href="<?=HOME_URL?>/noticias/" title="Noticias e Imprensa">Noticias e Imprensa</a>
            </li>
            <li>
                <a href="<?=HOME_URL?>/carreira/" title="Carreira">Carreira</a>
            </li>
            <li>
                <a href="<?=HOME_URL?>/contato/" title="Contato">Contato</a>
            </li>
        </ul>
        <div class="clear"></div>
        <hr class="space prepend-top" />
        <p class="prepend-top marrom">Seja bem vindo! Conheça nossos serviços.</p>
    </div>
<?php
	/**
	 * Inclusão do template de rodapé do projeto
	 */
	include_once TPL_PATH . '/footer-home.inc.php';