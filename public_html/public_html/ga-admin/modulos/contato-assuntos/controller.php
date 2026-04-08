<?php
/**
 *	contato-assuntos::controller.php
 *
 *	Define-se as opções a serem exibidas, recupera-se a ação e define-se os labels das opções.
 *
 *<ol>
 *	<li>Todos os textos presentes nas opções e Texto de chamada guardados na váriável <b>$the_module_labels</b></li>
 *	<li>Recuperação da ação, povoando a variável <b>$the_action</b> - <b>$_POST</b> tem precedência ao <b>$_GET</b></li>
 *	<li>Definição de qual arquivo será incluso, de acordo com <b>$the_Action</b></li>
 *</ol>
 *
 * @version   1.010, Created: 26/06/2013
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @package   Generator 2.01
 */

/**
 * Inclui os arquivos base admin, se ainda não foram
 */
	include_once "includes/admin_config.php";

// seta os labels dentro do modulo
	$the_module_labels = array(
		"new_txt"	=> "Novo Assunto",
		"new_alt"	=> "Adicionar novo assunto",
		"lst_txt"	=> "Listagem de assuntos",
		"lst_alt"	=> "Voltar para Listagem",
		"edt_txt"	=> "Editar Assunto"
	);

// recupera as ações do módulo
	$the_action = "List";
	if (isset($_GET["acao"]) && !empty($_GET["acao"]))
		$the_action = $_GET["acao"];
	if (isset($_POST["acao"]) && !empty($_POST['acao']))
		$the_action = $_POST["acao"];

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
		$the_module_labels["lst_alt"]
	);


// carrega o corpo 
	switch($the_action)
	{
		case "Add":
		case "Edit":
			/**
			 * Inclusão do template de codificação para adição/edição
			 */
			include (includeFile("edit"));
		break;
		default:
			/**
			 * Inclue o template apdrão para a listagem
			 */
			include (includeFile("list"));
		break;
	}

/* End of File: controller.php */
/* Path: ga-admin/modulos/contato-assuntos/controller.php */