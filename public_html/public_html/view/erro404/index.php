<?php
/**
 * Passarelli Advocacia *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @author      Mahmod A. Issa <muh@gestaoativa.com.br>
 */

// Inclusão do template de cabeçalho do projeto
include_once dirname(dirname(dirname(__FILE__))).'/template/head.inc.php';
?>
<ul class="breadcrumb">
	<li>
		<a href="<?=HOME_URL?>/home" title="HOME-Passarelli Advocacia">Home</a>
	</li>
</ul>

<div class="erro aCenter">
	<h1>ERRo 404</h1>
	<p>Página não encontrada | <a href="<?=HOME_URL?>/home" title="HOME-Passarelli Advocacia">Voltar para home</a> </p>
</div>

   
<?php
	/**
	 * Inclusão do template de rodapé do projeto
	 */
	include_once TPL_PATH . '/footer-home.inc.php';
