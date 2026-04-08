<?php
/**
 *	Template::defaut_search
 *
 * Fomulário de busca padrão[get] busca por ocorrência de string
 *
  *<b>Configurações</b>
 *<ol>
 *	<li>string	<b>$search_txt</b> o texto a ser exibido antes do formulário de busca;</li>
 *</ol>
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.002, Created: 30/09/2010, LastModified: 29/11/2010
 * @package     Template
 */
 
	if (!isset( $search_txt))
		$search_txt = "Digite a chave de busca";
?>

<!--/* defaut_search.php */-->
<script type="text/javascript">
 // <![CDATA[
	jQuery(document).ready(function($){
		$('#searchform').validate({
			rules: {busca:{required:true,busca:true}},
			messages:{busca:'!'}
		});
	});
 // ]]>
</script>
<div class="clear" id="default_search_wrapper">
	<form method="get" action="./" id="searchform">
		<div>
			<label for="search_busca"><?php echo ($search_txt); ?></label>
			<input type="text" id="search_busca" class="text round5" name="busca" value="<?php echo $the_search;?>" />
		</div>
		<div class="append-11">
			<input type="hidden" id="search_modulo" name="modulo" value="<?php echo $the_module;?>" />
			<input type="hidden" id="search_acao" name="acao" value="Find" />
			<input type="submit" class="button" value="Buscar" />
		</div>
	</form>
	<br class="clear" />
</div>
<!--/* #default_search.php */-->
