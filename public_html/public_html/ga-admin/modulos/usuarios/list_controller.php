<?php
/**
 * Basic::Usuarios::list_controller
 *
 * Faz o controle da exibição e busca
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.000, Created: 13/09/2010, LastModified: 13/09/2010
 * @package     Basic
 * @subpackage  Usuarios
 */
 
// exitencia da tabela
	if (!isset($the_table))
		$the_table = 'rb_usuarios';
		
// ###########  BUSCA / PAGINACAO #########
	$num_por_page = 15;
	$the_total    = $the_page  = 0;
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
		
// ###########  BUSCA / PAGINACAO #########
	if (isset($_GET['id']) && $the_action == 'Remove')
	{
		if ($the_user['tipo'] == 0)
			add_msg('Você não pode executar esse procedimento', 'error');
		else
		{
			$id = (int) $_GET['id'];
			$sql = sprintf("DELETE FROM `%s` WHERE `id`=%s", $the_table, $id);
			$rs  = _query($sql);
			if (_affectedRows() > 0)
				add_msg( 'Registro foi removido com sucesso!', 'success' );
			else
				add_msg( 'Problemas ao tentar remover registro inexistente' );

		}
	}
	

// ### RECUPERACAO DOS DADOS ###
	if (!isset($the_result))
		$the_result = array('#', 'Login', 'Email', 'Ações');
	$sql = sprintf("SELECT `id`,`login`, `email` FROM `%s` WHERE `id` > 1", $the_table);
	if($the_search != "")
		$sql .= sprintf(" AND (`login` LIKE '%%%s%%' OR `email` LIKE '%%%s%%')", $the_search, $the_search);
	// ### barra usuarios de acesso a outras contas
	if( $the_user['tipo'] == 0 )
	{
		$sql = sprintf("SELECT `id`,`login`, `email` FROM `%s` WHERE `id`=%s", $the_table, $the_user['id']);
		add_msg( sprintf("Caro %s, você só pode alterar seus próprios dados", $the_user['login']) );
	}
	$the_total = num_rows($sql);
// if pagina maior q ultima sempre ultima
	$ultima_pagina = ceil($the_total/$num_por_page)-1;
	if ($the_page && $the_page > $ultima_pagina)
		$the_page = $ultima_pagina;
// listagem dos elementos
	$sql .= sprintf(" ORDER BY id LIMIT %s, %s", ($the_page * $num_por_page), $num_por_page);
	$the_list = sqlQuery($sql, 'row');					

// #### MENSAGENS ####
	array_msg_to_html('success');
	array_msg_to_html('error');
	array_msg_to_html();

/* End of File: list_controller.php */
/* Path: ga-admin/modulos/usuarios/list_controller.php */