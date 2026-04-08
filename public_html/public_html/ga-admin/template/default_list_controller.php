<?php
/**
 *	Template::default_list_controller
 *
 * Arquivo de controle de exibição padrão [Remove, Find, List]
 *
 *<b>Configurações</b>
 *<ul>
 *	<li><b>$num_por_page</b>: número de registros por página</li>
 *	<li><b>$the_result</b>: label dos itens a serem exibidos(array de índice numérico)</li>
 *	<li><b>$fields</b>: as colunas que serão exibidas</li>
 *</ul>
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.001, Created: 30/09/2010, LastModified: 05/10/2010
 * @package     Template
 */
 
/**
 * Dá acesso as funcionalidades de midia
 */
	require_once("midia/midia.php");
// exitencia da tabela
	if( !isset($the_table) )
		$the_table = sprintf('rb_%s', $the_module);
	

	// buscamos por um ou dois campos para exibição e busca
	if( !isset($fields) || count($fields) < 1 )
	{
	// dados referentes a tabela
		$default_types  = get_columns( $the_table );
		unset($default_types['id']);
		unset($default_types['created_at']);
	// ordena em ordem decrescente e mantem o indice
		arsort($default_types);
		$fields = array();
		foreach( $default_types as $i => $v ){
			if( strpos( $v, 'text' ) !== false ){ continue;}
			if( strpos( $v, 'int' ) !== false ){ continue;}			
			$fields[] = $i;
			if(count($fields)==2){break;}
		}
	}
// a lista dos labels e elementos a serem exibidos
	if( !isset($the_list) )
		$the_list = array();
	if( !isset($the_result) )
		$the_result = "Parece que os dados que está buscando não existe nos registros";

// ###########  BUSCA / PAGINACAO #########
	$the_page = 0;
	if(!isset($num_por_page) ){ $num_por_page = 10; }
	$the_search = "";
	$the_total = 0;
// buscas
	if( isset($_GET["busca"]) )
		$the_search = urldecode($_GET["busca"]);
	if(	isset($_POST["busca"]) )
		$the_search = trim($_POST["busca"]);
// paginação
	if( isset($_GET["pagina"]) )
		$the_page = urldecode($_GET["pagina"]);
	if(	isset($_POST["pagina"]) )
		$the_page = trim($_POST["pagina"]);
	if( $the_page > num_rows($the_table) )
		$the_page = 0;

// ###########  REMOCAO  #########
	if( isset($_GET["id"]) && $the_action == "Remove" )
	{
		$id = trim($_GET["id"]);
		if( is_numeric($id) )
		{
			$sql = sprintf("DELETE FROM `%s` WHERE `id`=%s", $the_table, $id);
			if( !$rs  = _query($sql) )
			{
				add_debug_msg( _sqlError(), $the_module."/list_controller.php" );
			}
			if (affectedRows() > 0)
			{
				add_msg( "Registro foi removido com sucesso!", "success" );
			}
			else
			{
				add_msg( "Problemas ao tentar remover registro inexistente" );
			} 
			/* o metodo so removerá midias se existirem */
			$num = removeMidia( $id, $the_module);
			if( count($num) > 0)
			{
				add_msg( sprintf( "[%s] midia(s) foi(ram) removida(s)!", count($num)), "success" );
			}
		}
		else
		{
			add_msg( "Problemas ao processar pedido!", "error" );
		}
	}

// ### RECUPERACAO DOS DADOS ###
	if( table_exists($the_table) )
	{
		if( count($fields) == 2 )
		{
			// labels para listagem
			if( !is_array($the_result) )
				$the_result = array('Ordem', ucfirst($fields[0]), ucfirst($fields[1]), 'Ações');
			// monta-se a string para busca, caso default_search.php for incluido a seguir
			$search_txt = sprintf( "Digite %s ou %s para buscar", ucfirst($fields[0]), ucfirst($fields[1]) );
			// THE query
			$sql = sprintf( "SELECT `id`,`%s`, `%s` FROM `%s` WHERE 1", $fields[0], $fields[1], $the_table );
			if($the_search != "")
				$sql .= sprintf(" AND (`%s` LIKE '%%%s%%' OR `%s` LIKE '%%%s%%')", $fields[0], $the_search, $fields[1], $the_search);
		}
		else
		{
			// labels para listagem
			if( !is_array($the_result) )
				$the_result = array('Ordem', ucfirst($fields[0]), 'Ações');
			// monta-se a string para busca, caso default_search.php for incluido a seguir
			$search_txt = sprintf( "Digite %s  para buscar", ucfirst($fields[0]) );
			// THE query
			$sql = sprintf( "SELECT `id`,`%s` FROM `%s` WHERE 1", $fields[0], $the_table );
			if($the_search != "")
				$sql .= sprintf( " AND `%s` LIKE '%%%s%%'", $fields[0], $the_search );
		}
		// total de elementos exibíveis
		$the_total = num_rows($sql);
		$sql .= sprintf(" ORDER BY id LIMIT %s, %s", $the_page * $num_por_page, $num_por_page);
		/* execução e fetch */
		$the_list = sqlQuery($sql, 'row');					
	}
	else
	{
		add_msg( "A tabela de controle do módulo está inacessível", "error" );
	}
	
// #### MENSAGENS #######
	array_msg_to_html('success');
	array_msg_to_html('error');
	array_msg_to_html();
?>
<!--/* #<?php echo $the_module?>/default_list_controller.php[<?php echo $the_action;?>] */-->
