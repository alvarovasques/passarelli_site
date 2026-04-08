<?php
/**
 * Core::logoff
 *
 * Arquivo que realiza o logoff
 *
 * Apaga os dados da sessão
 *
 * @author  Rafael Benites <rbenites@gestaoativa.com.br>
 * @author  Diogo Campanha <diogo@gestaoativa.com.br>
 * @version 1.0, Created: 30/09/2010, LastModified: 05/11/2010
 * @package Core
 */
 
// inicializa a sessao
	session_start();
// limpa os dados se houverem
	if (isset($_SESSION['ga_admin_logged'])) {
		unset($_SESSION['ga_admin_logged']);
		unset($_SESSION['ga_admin_info']);
		unset($_SESSION['ga_client_info']);
	}
	// "comita" e destroi dados a sessão
	session_write_close();	
    @session_destroy();
// reinicia a sessão e volta a pagina de login
	session_start();
	header("Location: ./login.php?msg=".urlencode('Sessão finalizada!'));
	exit;
	
/* End of File: login_control.php */
/* Path: ga-admin/login_control.php */