<?php
/**
 * Basic::Usuarios::controller
 *
 * Recupera a ação, monta as opções e define qual arquivo carregar
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.001, Created: 13/09/2010, LastModified: 13/09/2010
 * @package     Basic
 * @subpackage  Usuarios
 */

 /**
  * Inclui os arquivos base do sistema, se não presentes
  */
	require_once("includes/admin_config.php");

// seta os labels dentro do modulo 
	$the_module_labels = array(
		"new_txt"	=> "Novo Usuário",
		"new_alt"	=> "Adicionar novo usuário",
		"lst_txt"	=> "Listagem de usuários",
		"lst_alt"	=> "Voltar para Listagem",
		"edt_txt"	=> "Editar usuário",
		"alt_txt"	=> "Alterar Senha"
	);

// verifica a existência de alguma ação
	$the_action = "List";
	if( isset($_GET["acao"]) )
		$the_action = trim($_GET["acao"]);
	if( isset($_POST["acao"]) )
		$the_action = trim($_POST["acao"]);

// cria as opcoes
	$temNovo = true;
	$opt_novo = array( 	sprintf('?modulo=%s&amp;acao=Add', $the_module),
						$the_module_labels["new_alt"],
						$the_module_labels["new_txt"] );
	$temList = true;
	$opt_list = array(	sprintf('?modulo=%s&amp;acao=List', $the_module),
						$the_module_labels["lst_alt"],
						$the_module_labels["lst_alt"] );
	/**
	 * Montagem das opções
	 */
	// require_once('modulos/opcoes.php');
	
// carrega o corpo 
	switch($the_action)
	{
		case 'Add':
		case 'Edit':
			include("edit.php");
		break;
		case 'Alter':
			include("alter.php");
		break;
		default:
			include("list.php");
		break;
	}
?>
