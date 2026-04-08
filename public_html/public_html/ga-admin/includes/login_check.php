<?php
/**
 * Core::login_check
 *
 * Arquivo que faz verificação se usuário está logado...
 * Verifica se as informações deusuário estão setadas e o token de 
 * login corresponde ao definido em "config_inc.php"
 *
 * @since       1.001, caso o header seja desconsiderado adicionado um die como fallback
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author	    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     1.001, Created: 30/09/2010, LastModified: 17/01/2013
 * @package     Core
 */
 
 /**
  * Inclui o arquivo com as configurações básicas do sistema administrativo
  */
	require_once dirname(__FILE__) . "/admin_config.php";

// verifica a sessao do usuario
	if (!isset($_SESSION['ga_admin_logged'])) {
        $url = './login.php?msg=' . urlencode('Informe seus dados para acessar o painel administrativo!');
        if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
            $url .= '&continue=' . urlencode($_SERVER['QUERY_STRING']);
        }
   		header("Location: {$url}");
		die("Ocorreu algum erro!");
   	}
// token confere
	if ($_SESSION['ga_client_info']	!= $the_client_session) {
        $url = './login.php?msg='.urlencode('Informe seus dados para acessar o painel administrativo!!');
        if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
            $url .= '&continue=' . urlencode($_SERVER['QUERY_STRING']);
        }
   		header("Location: {$url}");       
		die("Ocorreu algum erro!!");
	}

/* End of File: /ga-admin/includes/login_check.php */