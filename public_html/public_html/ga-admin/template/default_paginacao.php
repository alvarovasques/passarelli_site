<?php
/**
 *	Template::default_paginacao
 *
 * Faz paginção padrão com anterior e próximo
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
	if($the_search != "")
		$the_link .= sprintf("&amp;busca=%s", urlencode($the_search));
?>

<!--/* <?php echo $the_module?>/default_paginacao.php[<?php echo $the_action;?>] */-->
<div class="clear paginacao" id="pagin_container">
<?php 
	if($the_page > 0)
	{
		$prev = $the_link.'&amp;pagina='.($the_page-1).'#top-list';
?>	
		<a href="<?php echo $prev; ?>">
			<img src="includes/images/icons/left.png" alt="Anterior" title="Anterior" /></a>
<?php
	}
	else
	{
?> 
		<img src="includes/images/icons/left-1.png" alt="Anterior" title="Anterior" id="pagin-prev" />
<?php
	}
?>
			P&aacute;gina <?php echo ($the_page+1); ?>/ <?php echo ceil($the_total/$num_por_page) ?>
<?php
	if( ($the_page+1)*$num_por_page < $the_total )
	{
		$prox = $the_link.'&amp;pagina='.($the_page+1).'#top-list';
?>
	<a href="<?php echo $prox; ?>">
		<img src="includes/images/icons/right.png" alt="Seguinte" title="Seguinte" /></a>
<?php
	}
	else
	{
?>
		<img src="includes/images/icons/right-1.png" alt="Seguinte" title="Seguinte" id="pagin-next" />
<?php
	}
?>
</div>
<!--/* #<?php echo $the_module?>/default_paginacao.php[<?php echo $the_action;?>] */-->
