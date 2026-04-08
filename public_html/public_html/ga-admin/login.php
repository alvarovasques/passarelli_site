<?php
/**
 *	Core::login
 *
 *	Arquivo que exibe form de login para o sistema de administração
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author	    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     2.000, Created: 30/09/2010, LastModified: 17/06/2011
 * @package		Core
 */

/**
 * Arquivo de controle de login,realiza todas as operações para validar e autenticar um login
 */
	include "login_control.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Login &raquo; Painel de Administra&ccedil;&atilde;o</title>
<!--#BEGIN estilos -->
	<link rel="stylesheet" href="./includes/estilo/blueprint/screen.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="./includes/estilo/blueprint/print.css" type="text/css" media="print" />
	<!--[if lt IE 8]><link rel="stylesheet" href="./includes/estilo/blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]-->
	<link rel="stylesheet" href="./includes/estilo/admin_style3.0.css" type="text/css" media="all" />
<!--#END estilos -->
<!-- ie6 campaign -->
	<!--[if lt IE 7]><script src="http://imasters.com.br/crossbrowser/fonte.js" type="text/javascript"></script><![endif]-->
</head>
<body class="login">
	<div class="container">
		<div id="ga-login-box"><!-- login  =~ .span-13 -->
			<h2>Login de Usuário</h2>
			<div id="msg_box"><?php array_msg_to_html($msg_class); ?></div>
			<div id="ga-form-box"><!-- imagem -->
				<form method="post" action="" id="loginform">
					<p>Informe seu nome de usuário e sua senha para acessar o painel de administração</p>
					<div class="clear form-row">
						<label for="input_login" class="column">Usuário:</label>
						<input type="text" id="input_login" name="input[login]" class="ga-input-login column" />
						<br class="clear"/>
					</div>
					<div class="clear form-row">
						<label for="input_senha" class="column">Senha:</label>
						<input type="password" id="input_senha" name="input[senha]" class="ga-input-login column" />
						<br class="clear"/>
					</div>
					<div class="prepend-top-quarter aRight clear">
						<a href="./recover.php?step=1" title="Esqueceu sua Senha?">Esqueceu sua Senha?</a>
                        <?php if (isset($_GET['continue'])) { ?>
                        <input type="hidden" name="continue" value="<?php echo $_GET['continue']; ?>" />
                        <?php } ?>
						<input type="submit" class="btnSave" value="Entrar" name="btnAct" />	
					</div>
				</form>
			</div>
			<div class="clear aRight" id="login-footer">
				Todos os direitos reservados &copy; 2012 - <a href="http://www.gestaoativa.com.br" title="Gestão Ativa">Gestão Ativa</a>
			</div>
		</div><!-- #ga-login-box -->
	</div><!-- .container -->

<!--#BEGIN javascript-->
	<script type="text/javascript" src="./includes/js/jquery.js" charset="utf-8"></script>
	<script type="text/javascript" src="./includes/js/jquery.validate.js" charset="utf-8"></script>
	<script type="text/javascript" src="./includes/js/jquery.ga-admin.validate.js" charset="utf-8"></script>
<!--#END javascript -->
<!--#BEGIN inline definition -->
	<script type="text/javascript">
	// <![CDATA[
		jQuery(document).ready(function($){
			$('#loginform').validate({rules:{'input[login]':{required:true,login:true},'input[senha]':{required:true}}});
			$(".external").attr({target:"_blank"});
		});
	// ]]>
	</script>
<!--#END inline definition -->
</body>
</html>
<?php

/* End of File: login.php */
/* Path: ga-admin/login.php */