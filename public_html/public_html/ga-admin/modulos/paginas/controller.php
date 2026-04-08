<?php
/**
 * Basic::Paginas::controller
 *
 * Recupera a ação, monta as opções e define qual arquivo carregar
 * 
 * @author	   Rafael Benites <rbenites@gestaoativa.com.br>
 * @version    1.000, Created: 13/09/2010, LastModified: 13/09/2010
 * @package    Basic
 * @subpackage Paginas
 */
 
 /**
  * Inclui os arquivos base do sistema, se não presentes
  */
	include_once ("includes/admin_config.php");

// seta os labels dentro do modulo
	$the_module_labels = array(
		"new_txt"	=> "Nova Página",
		"new_alt"	=> "Adicionar nova pagina",
		"lst_txt"	=> "Listagem de páginas",
		"lst_alt"	=> "Voltar para Listagem",
		"edt_txt"	=> "Editar Pagina"
	);

// verifica a existência de alguma ação
	$the_action = "List";
	if( isset($_GET["acao"]) && !empty($_GET["acao"]) )
		$the_action = trim($_GET["acao"]);
	if( isset($_POST["acao"]) )
		$the_action = trim($_POST["acao"]);

// cria as opcoes
	$temNovo = false;
	$opt_novo = array( 
		"?modulo={$the_module}&amp;acao=Add",
		$the_module_labels["new_alt"],
		$the_module_labels["new_txt"]
	);
	$temList = true;
	$opt_list = array(
		"?modulo={$the_module}&amp;acao=List",
		$the_module_labels["lst_alt"],
		$the_module_labels["lst_alt"]
	);
	/**
	 * Montagem das opções
	 */
	// include_once('modulos/opcoes.php'); moved to template
	
// carrega o corpo
	switch($the_action)
	{
		case 'Add':
		//	include("modulos/error.php");
		//break;
		case 'Edit':
			/**
			 * Inclusão do arquivo com o formulário de adição e edição de uma página
			 */
			include (includeFile("edit.php"));
		break;
		default:
		/**
		 * Inclusão do script dque lista epermite busca entre as páginas cadastradas
		 */
			include(includeFile("list.php"));
		break;
	}

/* End of File: controller.php */
/* Path: ga-admin/modulos/paginas/controller.php */