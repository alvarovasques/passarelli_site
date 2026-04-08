<?php
/**
 * advogados::list.php
 *
 * Arquivo de exibição de todos os ítens cadastrados no módulo, com remoção e busca.
 *
 * @version   1.101, Created: 25/06/2013
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @package   Generator 2.01
 */

 /**
  * Controle das informações de listagem de advogados
  */
	include (includeFile("list_controller"));

// mensagem de busca
	$search_txt = "Digite nome para buscar";
?>

<!--/* advogados/list.php */-->
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

	if (is_array($the_result) && !empty($the_list))
	{
?>
	<table class="list_table">
		<thead>
			<tr>
				<th class="span-2">
					<?php echo $the_result[0]; ?>
				</th>
				<th class="span-14">
					<?php echo $the_result[1]; ?>
				</th>
				<th class="span-3 last">
					<?php echo $the_result[2]; ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3" id="pagination_cell">
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
					<a href="<?php echo "?modulo={$the_module}&amp;acao=Remove&amp;id={$item[0]}&amp;pagina={$the_page}#top-list"; ?>" onclick="return RB.doRemove()">
						<img src="includes/images/icons/rem.png" alt="Remover" title="Remover este item" /></a>
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
		<hr class="space" />
	</div>
</div>

<?php 

/* End of file: list.php */
/* Path: ga-admin/modulos/advogados/list.php */