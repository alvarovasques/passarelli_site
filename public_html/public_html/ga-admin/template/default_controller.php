<?php
/**
 * Template::default_controller
 *
 * Recupera ações e define qual arquivo carregar
 *
 *<b>Como usar o template</b>
 *<ol>
 *	<li>criar uma tabela com prefixo 'rb_', exemplo: 'rb_teste' { id: integer, titulo: varchar, texto: text, info: varchar };</li>
 *	<li>criar dentro de 'ga-admin/modulos/' a pasta 'teste';</li>
 *	<li>criar a pasta ../public/teste' se for usar midia;</li>
 *	<li>criar dentro de 'ga-admin/modulos/teste' o arquivo 'controller.php' com as configurações abaixo;</li>
 *</ol>
 *<code>
 *<?php
 *	// dados configuráveis no arquivo controller.php
 *	// lembrando que todos os dados são opcionais esceto a inclusão do default_controller.php
 *	$the_module_labels = array(
 *		"new_txt"	=> "Novo Registro",
 *		"new_alt"	=> "Adicionar novo registro",
 *		"lst_txt"	=> "Gerenciar registros",
 *		"lst_alt"	=> "Listagem dos registros",
 *		"edt_txt"	=> "Editar registro"
 *	);	
 *	$use_midia = true; // usar midias
 *	$allow_these = array('jpg'); // extensões permitidas
 *	$useCrop = 'CM';
 *	$uploadInterface = 'uploadify';
 *	$widths = array( 300,640);
 *	$heights = array( "", 480);
 *	$midia_msg = "Somente arquivos '.jpg' serão permitidos. Resolução sugerida: 800x600pixels";
 *	$required = "'titulo', 'texto'";
 *	$num_por_page = 10;//numero de registros na listagem "list"
 *	include_once 'template/default_controller.php';
 *?>
 *</code>
  *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.004, Created: 30/09/2010, LastModified: 23/10/2011
 * @package     Template
 */
 
/**
  * Inclui os arquivos base do admin
  */
	require_once("includes/admin_config.php");

// verifica os labels usados no modulo
	if (!isset($the_module_labels))
	{
		$the_module_labels = array(
			"new_txt"	=> "Novo Registro",
			"new_alt"	=> "Adicionar novo registro",
			"lst_txt"	=> "Gerenciar registros",
			"lst_alt"	=> "Listagem dos registros",
			"edt_txt"	=> "Editar registro"
		);		
	}
// verifica se recebemos algum módulo
	if (!isset($the_module))
		$the_module = "home";

// verifica a existência de alguma ação
	$the_action = "List";
	if( isset($_GET["acao"]) )
		$the_action = trim($_GET["acao"]);
	if( isset($_POST["acao"]) )
		$the_action = trim($_POST["acao"]);

// cria as opções
	$temNovo  = true;
	$opt_novo = array(
		"?modulo={$the_module}&amp;acao=Add",
		$the_module_labels["new_alt"],
		$the_module_labels["new_txt"]
	);
	$temList  = true;
	$opt_list = array(
		"?modulo={$the_module}&amp;acao=List",
		$the_module_labels["lst_alt"],
		$the_module_labels["lst_txt"]
	);
	/**
	 * Montagem das opções 
	 */
	include_once "modulos/opcoes.php";

// carrega o corpo
	switch($the_action)
	{
		case "Add":
		case "Edit":
			/**
			 * Inclusao com o template de formulário para a edição e criação de registros
			 */
			include (includeFile("edit"));
		break;
		default:
			/**
			 * Inclusão do template de listagem, busca e remoção dos registros do módulo
			 */
			include( includeFile("list") );
		break;
	}

/* End of File: default_controller.php */
/* Path: ga-admin/templates/default_controller.php */