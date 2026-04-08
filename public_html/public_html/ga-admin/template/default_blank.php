<?php
/**
 * Template::default_blank
 *
 * Arquivo em branco que "printa" os dados de modulo e a ação.<br>
 * Arquivo só será usado quando ocorrer algum erro de inclusão e será retorno da função {@link includeFile()}
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.002, Created: 30/09/2010, LastModified: 23/10/2011
 * @package     Template
 */

	echo "
	<!--
		&raquo;[{$the_module}]&raquo;[{$the_action}]
	-->
	";

/* End of File: default_blank.php */
/* Path: ga-admin/templates/default_blank.php */