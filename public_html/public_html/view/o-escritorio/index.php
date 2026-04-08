<?php
    /**
     * Passarelli Advocacia *
     * @author      Rafael Benites <rbenites@gestaoativa.com.br>
     * @author      Marcelo Meneguesso <marcelo@gestaoativa.com.br>
     * @author      Mahmod A. Issa <muh@gestaoativa.com.br>
     */

    // Inclusão do template de cabeçalho do projeto
    include_once dirname(dirname(dirname(__FILE__))).'/template/head.inc.php';
    ?>
	<h1>
    <?php
        echo $pagina->titulo;
        ?>
    </h1>

    <div class="left<?php echo !empty($pagina->midias) ? ' escritorio' : ''; ?> aJustify append-half">
    <?php
        echo $pagina->texto;
        ?>
    </div>
<?php
    if (!empty($pagina->midias)) {
    ?>
    <div class="span-8 last">
		<ul id="galeria">
		<?php
            foreach ($pagina->midias as $m) {
            ?>
			<li>
            <?php
                exibeMidiaFancy($m,'a','galeria');
                ?>
			</li>
		<?php
            }
            ?>
		</ul>
    </div>
<?php
    }
    ?>
    <div class="clear"></div>
<?php
	/**
	 * Inclusão do template de rodapé do projeto
	 */
	include_once TPL_PATH . '/footer.inc.php';