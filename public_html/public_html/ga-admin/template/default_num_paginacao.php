<?php
/**
 * Template::default_num_paginacao
 *
 * Faz paginção numérica 1 ao número máximo de páginas presentes
 *
 *<b>Configurações</b>
 *<ol>
 *	<li>integer	<b>$the_total</b> número total de registros da consulta a ser paginada;</li>
 *	<li>integer	<b>$the_page</b> número da página atual;</li>
 *	<li>string	<b>$the_search</b> dados de busca se existirem(opicional);</li>
 *	<li>integer	<b>$num_por_page</b> número de registros a serem exibidos por página;</li>
 *</ol>
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.003, Created: 30/09/2010, LastModified: 28/11/2010
 * @package     Template
 */
	$the_link = sprintf("?modulo=%s", $the_module);
	if($the_search != ""){
		$the_link .= sprintf("&amp;busca=%s", urlencode($the_search));
	}
?>

<!--/* <?php echo $the_module?>/default_num_paginacao.php[<?php echo $the_action;?>] */-->
<div class="clear num-paginacao" id="pagin_container">
<?php 
	$i = ceil($the_total/$num_por_page)-1;
	while($i>=0)
	{
		if($i == $the_page)
		{
			echo sprintf('<span class="current">%s</span>', ($i+1) );
		}
		else
		{
			echo sprintf( '<a href="%s&amp;pagina=%s#top-list" title="Ir para %s">%s</a>', $the_link, $i, ($i+1), ($i+1) );
		}
		$i--;
	}
?>
	<br class="clear" />
</div>
<!--/* #<?php echo $the_module?>/default_num_paginacao.php[<?php echo $the_action;?>] */-->
