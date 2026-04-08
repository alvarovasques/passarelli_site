<?php
/**
 * configuracoes/controller
 * 
 * Exibe uma opção simbólica, e carrega o arquivo de edição
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.000, Created: 13/09/2010, LastModified: 13/09/2010
 * @package     Basic
 * @subpackage  Configuracoes
 */

// seta os labels dentro do modulo
	$the_module_labels = array(
		"lst_txt"	=> "Gerenciar Configurações",
		"lst_alt"	=> "Listagem de Configurações",
		"edt_txt"	=> "Editar Configurações"
	);

// recupera acao
	$the_action = 'Edit';
	if( isset($_GET['acao']) )
		$the_action = $_GET['acao'];
	if( isset($_POST['acao']) )
		$the_action = $_POST['acao'];
	
// carrega o corpo
	switch($the_action)
	{
		default: 
			include("edit.php"); 
		break;
	}

/* End of File: controller.php */
/* Path: ga-admin/modulos/configuracoes/controller.php */