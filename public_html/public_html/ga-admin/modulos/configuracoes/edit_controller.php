<?php
/**
 *	Basic::Configuracoes::edit_controller
 *
 * Arquivo que controla a informção de edição das configurações
 *
 * @author	   Rafael Benites <rbenites@gestaoativa.com.br>
 * @version    1.000, Created: 13/09/2010, LastModified: 13/09/2010
 * @package    Basic
 * @subpackage Configuracoes
 */

 // tabela já "setada"
	if (!isset($the_table))
		$the_table = 'rb_configuracoes';

 //campos obrigatórios
	$required = "titulo, email";

 // Tratar dados recebidos por post
	if (isset($_POST['input']))
	{
		$the_input	= _post($_POST["input"]);
		$tst	= temVazio($the_input, $required);
		if (!$tst)
		{
			$sql = toQuery($the_table, $the_input);
			$rs  = _query($sql);
			add_msg('Dados salvos com sucesso', 'success');
		}
		else
		{
			add_msg( sprintf('O campo [%s] deve ser preenchido!', $tst), 'error' );
		}
	}

// recupera dados
	$the_input = sqlQuery(sprintf("SELECT * FROM `%s` LIMIT 1", $the_table), 'assoc');
	if (!empty($the_input))
		$the_input = $the_input[0];
	

// ####### MENSAGEM ######
	array_msg_to_html('success');
	array_msg_to_html('error');
	array_msg_to_html();

/* End of File: edit_controller.php */
/* Path: ga-admin/modulos/configuracoes/edit_controller.php */