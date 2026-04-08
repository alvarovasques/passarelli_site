<?php
/**
 * Template::default_list
 *
 * Arquivo que contém o template de exibição dos itens cadastrados em um módulo
 *
 * <b>Dependências</b>
 *<ul>
 *	<li><b>$the_result</b>: array com os labels a serem exibidos</li>
 *	<li><b>$the_list</b>: array de arrays com os valores a serem exibidos </li>
 *</ul>
 *<b>Observação</b>
 *<ul>
 *	<li>Ambos são arrays com índices numéricos</li>
 *	<li>Para cada $it uma posição de $the_list (<?php foreach($the_list as $it) ?>) $it[0] armazenará a chave primária dos dados exibidos</li>
 *</ul>
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.002, Created: 30/09/2010, LastModified:29/11/2010
 * @package     Template
 */
 
/**
 * Controle das ações de listagem e busca de páginas
 */
	include (includeFile("list_controller"));

?>

<!--/* <?php echo $the_module?>/default_list.php[<?php echo $the_action;?>] */-->
<div class="span-19 append-bottom last">
	<h2>Gerenciar</h2>
	<hr />

<?php
	/**
	 * Inclusão do formulário de busca
	 */
		include (includeFile("search"));
?>
	
	<h2 class="center">Resultados<a name="top-list"></a></h2>
<?php 
	if (is_array($the_result) && !empty($the_list))
	{
?>
	<div class="span-19 result-top last">		
		<div class="span-2">
			<?php echo ($the_result[0]); ?>
		</div>
<?php
		if (count($the_result) > 3)
		{
?>
		<div class="span-7">
			<?php echo ($the_result[1]); ?>
		</div>
		<div class="span-7">
			<?php echo ($the_result[2]); ?>
		</div>
		<div class="span-2 last">
			<?php echo ($the_result[3]); ?>
		</div>
<?php
		}
		else
		{
?>
		<div class="span-14">
			<?php echo ($the_result[1]); ?>
		</div>
		<div class="span-2 last">
			<?php echo ($the_result[2]); ?>
		</div>
<?php
		}
?>
	</div>
<?php
	} 
	else
	{
?>
		<div class="span-18 center error">
			<?php echo ('Nenhum registro encontrado!'); ?>
			<?php
				if( !empty($the_search) )
				{
					echo (sprintf(' Para a chave [%s]', $the_search));
				}
			?>
		</div>
<?php
	} 
	$i = $the_page * $num_por_page;
	foreach($the_list as $item)
	{
?>
	<div class="span-19 last item-<?php echo($i%2);?>">		
		<div class="span-2">
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Edit&amp;id=%s', $the_module, $item[0]); ?>" title="Editar este item">
				<?php echo ++$i; ?></a>
		</div>
<?php
		if( count($the_result) > 3 )
		{
?>
		<div class="span-7">
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Edit&amp;id=%s', $the_module, $item[0]); ?>" title="Editar este item">
				<?php echo ($item[1]); ?></a>
		</div>
		<div class="span-7">
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Edit&amp;id=%s', $the_module, $item[0]); ?>" title="Editar este item">
				<?php echo ($item[2]); ?></a>
		</div>
<?php
		}
		else
		{
?>
		<div class="span-14">
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Edit&amp;id=%s', $the_module, $item[0]); ?>" title="Editar este item">
				<?php echo ($item[1]); ?></a>
		</div>
<?php
		}
?>
		<div class="span-2 last">
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Edit&amp;id=%s', $the_module, $item[0]); ?>" title="Editar este item">
				<img src="includes/images/icons/edit.png" alt="Editar" title="Editar este item" /></a>
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Remove&amp;id=%s', $the_module, $item[0]); ?>" onclick="return RB.doRemove()">
				<img src="includes/images/icons/rem.png" alt="Remover" title="Remover este item" /></a>
		</div>
	</div>
<?php
	} //foreach
	if (!empty($the_list))
		include (includeFile("num_paginacao"));
?>
</div>
<br class="clear" />
<?php

/* End of File: default_list.php */
/* Path: ga-admin/templates/default_list.php */