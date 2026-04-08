<?php
/**
 * Basic::home::controller
 *
 * Não exitem ações para este módulo apenas carregamos o texto de apresentação e criamos a opção de sair do sistema
 *
 * @author	   Rafael Benites <rbenites@gestaoativa.com.br>
 * @version    1.000, Created: 13/09/2010, LastModified: 13/09/2010
 * @package    Basic
 * @subpackage Home
 */
 
	$the_action = "List";
	
// carrega o corpo
	switch($the_action)
	{
		default:
			include (includeFile('list.php'));
		break;
	}
?>