<?php
    /**
     * Passarelli Advocacia    
     *
     * Arquivo com um template de menu básico
     *
     * @author      Rafael Benites <rbenites@gestaoativa.com.br>
     * @author      Marcelo Meneguesso <marcelo@gestaoativa.com.br>
     * @author      Mahmod A. Issa <muh@gestaoativa.com.br>
     * @package     View
     * @subpackage  Template
     */
     
    // "caminho" => "titulo"
	$o_menu = array(
        'home'             => '',
        'o-escritorio'     => 'O Escritorio',
        'advogados'        => 'Advogados',
        'areas-de-atuacao' => 'Áreas de Atuação',
        'artigos'          => 'Artigos',
        'noticias'         => 'Notícias & Imprensa',
        'carreira'         => 'Carreira',
        'contato'          => 'Contato',
	);
    ?>
    <ul class="span-24">
      <li >
        <p class="first">© PASSARELLI. DIREITOS RESERVADOS</p>
      </li>
    <?php
        foreach ($o_menu as $_path => $_title) {
            $_active = $_path == $siteConfig->modulo ? ' ativo' : '';
        ?>
        <li>
            <a class="<?php echo $_path . $_active;?>" href="<?php echo HOME_URL . '/' . $_path . '/'; ?>" title="<?php echo $_title; ?>">
            <?php
                echo $_title;
                ?>
            </a>
        </li>
    <?php
        }
        ?>
    </ul>