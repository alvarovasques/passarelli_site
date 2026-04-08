<?php	
/**
 * Midia::midia_list
 *
 * Lista todas as midias de um item, seja via includes ou ajax;
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.0, Created: 30/09/2010, LastModified: 14/09/2012
 * @package 	Midia
 * @filesource
 */

// verifica se veio de include ou não
	if (!isset($midiaView)) {
		$midiaView['codigo'] = $the_input['id'];
		$midiaView['tipo']   = $the_module;
	}

// atualiza os campos caso não estejam setados
	$campos = array("codigo","tipo");	
	foreach ($campos as $campo) {
		if (!isset($midiaView[$campo])) {
			if (isset($_GET[$campo])) {
				$midiaView[$campo] = $_GET[$campo];
			} else {
				$midiaView[$campo]=0;
            }
        }
	}
// procura midias cadastradas e as imprime
	$midias = getMidiaOrdered($midiaView['codigo'], $midiaView['tipo']);
	foreach ($midias as $midia) {
		showMidia($midia);
	}
// ie 7 issue
	if (!empty($midias)) {
		echo '<br class="clear" />';
	}

/* End of File: midia_list.php */
/* Path: /ga-admin/midia/midia_list.php */
