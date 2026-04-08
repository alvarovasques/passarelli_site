<?php
/**
 * Core::controller
 *
 * Arquivo que recupera dados do módulo e inclui seu respectivo "controlador"
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author	    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     1.000, Created: 30/09/2010, LastModified: 05/10/2010
 * @package		Core
 */

/**
 * Valor do módulo carregado
 * @name $the_module
 * @global string $the_module
 */
	$the_module = "home";	
	if (isset($_GET['modulo']) && !empty($_GET['modulo']))
		$the_module = $_GET['modulo'];
	if (isset($_POST['modulo'])) 
		$the_module = $_POST['modulo'];
	
// verifica a presença do item
	$the_controller = sprintf('modulos/%s/controller.php', $the_module);
	// existe um controlador 
	if (!file_exists($the_controller))
	{
		$the_controller =  "modulos/error.php";
	}

/* End of File: controller.php */
/* Path: ga-admin/controller.php */