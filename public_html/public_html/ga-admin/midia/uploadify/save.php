<?php
/**
 * Midia::uploadify::add
 *
 * Faz o pré-processamento dos dados recebidos pela interface de upload
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.002, Created: 30/08/2010, LastModified: 30/09/2010
 * @package     UploadInterface
 * @subpackage	uploadify
 */

// configurações para salvar
	$the_input   = array('id' => $_POST['id']);
	$the_module  = $_POST['modulo'];
	$the_action  = $_POST['acao'];

// configurações das imagens	
	$widths      = json_decode(stripslashes($_POST['widths']));
	$heights     = json_decode(stripslashes($_POST['heights']));
	$useCrop     = json_decode(stripslashes($_POST['useCrop']));
	$allow_these = json_decode(stripslashes($_POST['allow_these']));
	$reSize      = $_POST['reSize'];

//necessário para salvar
	$_POST['midia']= array(); /* necessário */
?>