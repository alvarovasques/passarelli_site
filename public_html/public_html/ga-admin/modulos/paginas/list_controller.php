<?php
/**
 * Basic::Paginas::list_controller
 *
 * Arquivo de controle de exibição de páginas [Remove, Alter, Find, List]
 *
 * @author	   Rafael Benites <rbenites@gestaoativa.com.br>
 * @version    1.000, Created: 13/09/2010, LastModified: 13/09/2010
 * @package    Basic
 * @subpackage Paginas
 */
 
  /**
  * Inclui funcionalidades das mídias, caso ainda não presente
  */
	require_once("midia/midia.php");
	
// exitencia da tabela
	if (!isset($the_table))
		$the_table = 'rb_paginas';

// ###########  BUSCA / PAGINACAO #########
	$num_por_page = 15;
	$the_total    = $the_page = 0;
	$the_search   = "";
// buscas
	if( isset($_GET['busca']) )
		$the_search = urldecode($_GET['busca']);
	if(	isset($_POST['busca']) )
		$the_search = trim($_POST['busca']);
// paginação
	if( isset($_GET['pagina']) )
		$the_page = (int) $_GET['pagina'];
	if(	isset($_POST['pagina']) )
		$the_page = (int) $_POST['pagina'];

	/*/ ###########  REMOCAO #########
	if( isset($_GET['id']) && $the_action == 'Remove' )
	{
		$id = trim($_GET['id']);
		if( is_numeric($id) )
		{
			$sql = sprintf("DELETE FROM `%s` WHERE `id`=%s", $the_table, $id);
			$rs = _query($sql);
			if(_affectedRows() > 0)
				add_msg( 'Registro foi removido com sucesso!', 'success' );
			else
				add_msg( 'Problemas ao tentar remover registro inexistente' );
			// o metodo so removerá midias se existirem 
			$num = removeMidia( $id, $the_module);
			if( $num > 0)
			{
				add_msg( sprintf( "[%s] midia(s) foi(ram) removida(s)!", count($num)), 'success' );
			}
		}
		else
		{
			add_msg( 'Problemas ao processar pedido!', 'error' );
		}
	}
	// */	

// buscamos dados referentes a tabela
	if (!isset($the_result))
		$the_result = array ('#', 'Título', 'Ações');
// a query
	$sql = sprintf("SELECT `id`,`titulo` FROM `%s` WHERE 1", $the_table);
// busca
	if($the_search != "")
		$sql .= sprintf(" AND `titulo` LIKE '%%%s%%'", $the_search);
// total de elementos
	$the_total = num_rows($sql);
// garantir que a pagina nao alcançará um valor maior que o devido
	$ultima_pagina = ceil($the_total/$num_por_page)-1;
	if ($the_page > $ultima_pagina)
		$the_page = $ultima_pagina;
// listagem dos elementos
	$sql .= sprintf(" ORDER BY `id` LIMIT %s, %s", $the_page * $num_por_page, $num_por_page);
	$the_list = sqlQuery($sql, 'row');
	
// mensagens 
	array_msg_to_html('success');
	array_msg_to_html('error');
	array_msg_to_html();
	
/* End of File: list_controller.php */
/* Path:  ga-admin/modulos/paginas/list_controller.php */