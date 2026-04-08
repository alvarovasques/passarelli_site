<?php
/**
 *	advogados::list_controller.php
 *
 * Busca os itens cadastrados e controla remocao e paginacao[List, Remove, Find]
 *
 * @version   1.101, Created: 25/06/2013
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @package   Generator 2.01
 */

/**
 * Dá acesso as funcionalidades de mídia
 */
	require_once "midia/midia.php";

// exitencia da tabela
	if (!isset($the_table))
		$the_table = "rb_advogados";

// ##########  BUSCA / PAGINACAO ##########
	$num_por_page = 15;
	$the_total    = $the_page = 0;
	$the_search   = "";

// buscas 
	if (isset($_GET["busca"]))
		$the_search = urldecode($_GET["busca"]);
	if (isset($_POST["busca"]))
		$the_search = trim($_POST["busca"]);

// paginação
	if (isset($_GET["pagina"]))
		$the_page = (int) $_GET["pagina"];
	if (isset($_POST["pagina"]))
		$the_page = (int) $_POST["pagina"];

// ########## REMOCAO DE UM ITEM ##########
	if (isset($_GET["id"]) && $the_action == "Remove")
	{
		$id  = (int) $_GET["id"];
		$sql = sprintf("DELETE FROM `%s` WHERE `id`=%d", $the_table, $id);
		
		if (!$rs  = _query($sql))
			add_debug_msg( _sqlError(), "advogados/list_controller.php" );

		if (_affectedRows() > 0)
			add_msg( "Registro foi removido com sucesso!", "success" );
		else
			add_msg( "Problemas ao tentar remover registro inexistente" );

		// o metodo so removerá midias se existirem
		$num = removeMidia($id, $the_module);
		if (!empty($num))
			add_msg( sprintf( "[%s] midia(s) foi(ram) removida(s)!", count($num)), "success" );
	}



// ########## RECUPERACAO DOS DADOS ##########
// labels
	if (!isset($the_result))
		$the_result = array('#', 'Nome', 'Ações');
// a query
	$sql = sprintf("SELECT `id`,`nome` FROM `%s` WHERE 1", $the_table);
// busca
	if ($the_search != "")
		$sql .= sprintf(" AND `nome` LIKE '%%%s%%'", _escape($the_search) );
// total de elementos
	$the_total = num_rows($sql);
// garante que não atingiremos um valor maior que a ultima página
	$ultima_pagina = ceil($the_total/$num_por_page)-1;
	if ($the_page && $the_page > $ultima_pagina)
		$the_page = $ultima_pagina;
// lista de elementos	
	$sql .= sprintf(" ORDER BY  `id` DESC LIMIT %s, %s", $the_page * $num_por_page, $num_por_page);
	$the_list = sqlQuery($sql, "row");

// ########## MENSAGENS ########## 
	array_msg_to_html("success");
	array_msg_to_html("error");
	array_msg_to_html();
	
/* End of File: list_controller.php */
/* Path: ga-admin/modulos/advogados/list_controller.php */