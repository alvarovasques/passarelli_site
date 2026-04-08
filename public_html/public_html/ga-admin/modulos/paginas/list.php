<?php
/**
 *	Basic::Paginas::list
 * 
 * Arquivo que exibe as páginas cadastradas
 *
 * @author	   Rafael Benites <rbenites@gestaoativa.com.br>
 * @version    1.002, Created: 13/09/2010, LastModified: 27/11/2010
 * @package    Basic
 * @subpackage Paginas
 */

/**
 * Controle das ações de listagem e busca de páginas
 */
	include( includeFile("list_controller.php") );	
// texto da busca
	$search_txt = "Digite o título da página";
?>

<!--/* paginas/list.php */-->
<div class="content-box clear">
	<div class="content-box-header">
		<h3><?php echo $the_module_labels["lst_txt"]; ?></h3>
	</div>
	<div class="prepend-half append-half clear">
<?php
	/**
	  * inclusão das opções
	  */
	include (includeFile("opcoes"));

	/**
	 * Inclusão do formulário de busca
	 */
		include (includeFile("search"));

	if( is_array($the_result) && !empty($the_list))
	{
?>
	<table class="list_table">
		<thead>
			<tr>
				<th class="span-2">
					<?php echo ($the_result[0]); ?>
				</th>
				<th class="span-12">
					<?php echo ($the_result[1]); ?>
				</th>
				<th class="span-3 last">
					<?php echo ($the_result[2]); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3" id="pagination_cell" style="padding:0">
					<?php
					/**
					 * Inclusão do template de paginação para o módulo
					 */
						include (includeFile("paginate"));
					?>
				</td>
			</tr>
		</tfoot>
		<tbody>
<?php
	}
	else
	{
?>
	<div class="clear error"> 
<?php
		echo ('Nenhum registro encontrado!');
		if( !empty($the_search) )
		{
			echo (sprintf(' Para a chave [%s]', $the_search));
		}
?>
	</div>
<?php

	}
	$i = $the_page * $num_por_page;
	foreach ($the_list as $item)
	{
?>
			<tr class="item-<?php echo($i%2);?>">
				<td>
					<a href="<?php echo "?modulo={$the_module}&amp;acao=Edit&amp;id={$item[0]}"; ?>" title="Editar">
					<?php echo ++$i; ?></a>
				</td>
				<td>
					<a href="<?php echo "?modulo={$the_module}&amp;acao=Edit&amp;id={$item[0]}"; ?>" title="Editar">
					<?php echo htmlspecialchars($item[1]); ?></a>
				</td>
				<td class="last">
					<a href="<?php echo "?modulo={$the_module}&amp;acao=Edit&amp;id={$item[0]}"; ?>" title="Editar">
						<img src="includes/images/icons/edit.png" alt="Editar" title="Editar este item" /></a>
				</td>
			</tr>
<?php
	}
	if (!empty($the_list))
	{
	?>
		</tbody>
	</table>
<?php
	}
?>
		<br class="clear" />
	</div>
</div>
<?php

/* End of File: list_controller.php */
/* Path:  ga-admin/modulos/paginas/list_controller.php */