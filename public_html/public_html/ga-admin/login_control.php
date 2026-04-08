<?php
/**
 * Core::login_control
 *
 * Arquivo para validar o login no sistema administrativo,
 * recebe os dados de login e senha, e tenta autenticar, em caso de
 * sucesso, redireciona para o index;
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author	    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     1.002, Created: 30/09/2010, LastModified: 11/08/2011
 * @package     Core
 */


/**
 * Inclue todos os arquivos básicos necessários para o sistema administrativo
 */
	require_once dirname(__FILE__) . "/includes/admin_config.php";

// tratamento das mensagens
	$msg_value = "Informe login e senha";
	$msg_class = "notice";
	if (isset($_GET['msg'])) {
		$msg_value = urldecode($_GET['msg']);
	}
    if (isset($_POST['msg'])) {
		$msg_value = trim($_POST['msg']);
	}
    
// tratamento do login
	if (isset($_POST['input'])) {
		$user = _post($_POST['input']); // md5 na
		$sql = sprintf ("SELECT * FROM `rb_usuarios` WHERE `login`='%s' AND `senha`='%s'", _escape($user['login']), $user['senha']);
		$res = sqlQuery ($sql, 'assoc');
	// existe um usuário com a combinação fornecida
		if (!empty($res) > 0) {
		// atualiza os dados do ultimo login
			$user = $res[0];
			if ($user['ativo']) {
				$user['ultimo'] = $the_now;
				$sql = toQuery('rb_usuarios', array('id'=>$user['id'],'ultimo'=>$user['ultimo'],'validation_key'=> ''));
				_query($sql);
			// não é necessário guardarmos a senha ? 
				unset($user['senha']);
			// escrita na sessão
				$_SESSION['ga_admin_logged'] = true;
				$_SESSION['ga_admin_info']	 = serialize($user);
				$_SESSION['ga_client_info']	 = $the_client_session;			
				session_write_close();			
				header("Location: ./" . (isset($_POST['continue']) ? '?' . $_POST['continue'] :''));
				die("Erro! Tente Recarregar a página!");
			} else {
				$msg_value = "Seu usuário foi desativado por um administrador!";
				$msg_class = "error";
			}
		} else {
			$msg_value = "Combinação de Usuário e Senha não encontrada";
			$msg_class = "error";
		}
	}
	add_msg($msg_value, $msg_class);

/* End of File: /ga-admin/login_control.php */