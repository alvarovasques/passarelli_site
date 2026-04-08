<?php
/**
 *	Midia::uploadify::response
 *
 * Exibe a resposta para uma requisição da interface de upload
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.0, Created: 30/08/2010, LastModified: 30/09/2010
 * @package     UploadInterface
 * @subpackage	uploadify
 */
 
// mostra as mensagens armazenadas
	array_midia_msg_to_html('success');
	array_midia_msg_to_html('error');
	array_midia_msg_to_html();
/**
 * Exibe todas as mídias cadastradas para o código e tipo recebidos
 */
	include("midia_list.php");
?>