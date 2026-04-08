<?php
/**
 *	Basic::Usuarios::list
 *
 * Arquivo de exibição dos usuários cadastrados
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.002, Created: 13/09/2010, LastModified: 27/11/2010
 * @package     Basic
 * @subpackage  Usuarios
 */

 /**
  * Controla as informações recebidas e enviadas
  */
	include("list_controller.php");
// texto da busca
	$search_txt = "Digite o login ou email";
?>

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

	if( is_array($the_result) && count($the_list) > 0)
	{
?>
	<table class="list_table">
		<thead>
			<tr>
				<th class="span-2">
					<?php echo ($the_result[0]); ?>
				</th>
				<th class="span-7">
					<?php echo ($the_result[1]); ?>
				</th>
				<th class="span-7">
					<?php echo ($the_result[2]); ?>
				</th>
				<th class="span-3 last">
					<?php echo ($the_result[3]); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4" id="pagination_cell">
					<?php 	include(includeFile("paginacao")); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
<?php
	} 
	else
	{
?>
		<div class="clear center error">
			<?php
				echo ('Nenhum registro encontrado!'); 
				if( !empty($the_search) )
					echo sprintf(' Para a chave [%s]', $the_search);
			?>
		</div>
<?php
	} 
	$i = $the_page * $num_por_page;
	foreach( $the_list as $item )
	{
?>
	<tr class="item-<?php echo($i%2);?>">		
		<td>
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Edit&amp;id=%s', $the_module, $item[0]); ?>" title="editar">
				<?php echo ++$i; ?></a>
		</td>
		<td>
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Edit&amp;id=%s', $the_module, $item[0]); ?>" title="editar">
				<?php echo ($item[1]); ?></a>
		</td>
		<td>
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Edit&amp;id=%s', $the_module, $item[0]); ?>" title="editar">
				<?php echo ($item[2]); ?></a>
		</td>
		<td class="last">
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Edit&amp;id=%s', $the_module, $item[0]); ?>" title="Editar">
				<img src="includes/images/icons/edit.png" alt="Editar" title="Editar este item" /></a>
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Alter&amp;id=%s', $the_module, $item[0]); ?>" title="alterar">
				<img src="includes/images/icons/lock.png" alt="Alterar" title="Alterar senha" /></a>
			<a href="<?php echo sprintf('?modulo=%s&amp;acao=Remove&amp;id=%s', $the_module, $item[0]); ?>#top-list" onclick="return RB.doRemove()">
				<img src="includes/images/icons/rem.png" alt="Remover" title="Remover este item" /></a>
		</td>
	</tr>
<?php
	}
	if (count($the_list) > 0)
	{
	?>
		</tbody>
	</table>
<?php
	}
?>		<br class="clear" />
	</div>
</div>
<!--/* #usuarios/list.php */-->
