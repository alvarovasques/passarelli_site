<?php 
/**
 * Core::recover
 *
 * Arquivo que exibe os dados para recadastro de senha
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @author      Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     2.000, Created: 30/09/2010, LastModified: 17/06/2011
 * @package     Core
 */

 /**
  * Controle da recuperação de senha, e todos os seus passos
  */
	require_once 'recover_control.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Recupera&ccedil;&atilde;o de Senha &raquo; Painel de Administra&ccedil;&atilde;o</title>
<!--#BEGIN estilos -->
	<link rel="stylesheet" href="./includes/estilo/blueprint/screen.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="./includes/estilo/blueprint/print.css" type="text/css" media="print" />
	<!--[if lt IE 8]><link rel="stylesheet" href="./includes/estilo/blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]-->
	<link rel="stylesheet" href="./includes/estilo/admin_style3.0.css" type="text/css" media="all" />
<!--#END estilos -->
</head>
<body class="login">
	<div class="container">
	<!-- box de login -->
		<div id="ga-login-box">
<?php
		switch ($render)
		{
			case 'final':
?>
			<h2>Recuperação de Senha - Passo Final</h2>
			<div id="msg_box">
				<?php array_msg_to_html('success'); ?>
				<?php array_msg_to_html('error'); ?>
				<?php array_msg_to_html('notice'); ?>
			</div>
			<div id="ga-form-box">
				<form method="post" action="" id="recoverform">
					<div class="clear form-row">
						<label class="column">Usuário</label>: `` <?php echo $_input['login']?> ´´
					</div>
					<div class="clear form-row">
						<label for="input_senha" class="column">Senha:</label>
						<input type="password" id="input_senha" name="input[senha]" class="ga-input-login" />
					</div>
					<div class="clear form-row">
						<label for="input_resenha"  class="column">Confirmar:</label>
						<input type="password" id="input_resenha" name="input[resenha]" class="ga-input-login" />
					</div>
					<div class="prepend-half clear aRight append-1">
						<input type="hidden" name="input[validation_key]" value="<?php echo $_GET['validation_key'];?>" />
						<input type="hidden" name="input[id]" value="<?php echo $_GET['user_id'];?>" />
						<input type="submit" class="btnSave" value="enviar" name="btnAct" />
						<input type="hidden" value="end" name="steps" />
					</div>
				</form>
<?php
			break;
			case 'second':
?>

			<h2>Recuperação de Senha - Passo 2</h2>
			<div id="msg_box">
				<?php array_msg_to_html('success'); ?>
				<?php array_msg_to_html('error'); ?>
				<?php array_msg_to_html('notice'); ?>
			</div>
			<div id="ga-form-box">
				<form method="post" action="./recover.php?step=2" id="recoverform">
					<hr class="space" />
					<p class="prepend-half">
						Você receberá um email com as instruções de recuperação de senha em breve.
					</p>
					<p class="prepend-half">
						O email será enviado para o endereço associado ao usuário informado.
					</p>
					<div class="prepend-half clear">
						<a href="./" title="&laquo; voltar">&laquo; voltar</a>
					</div>
				</form>

<?php
			break;
			case 'thanks':
?>
			<h2>Cancelamento de E-mail</h2>
			<div id="msg_box">
				<?php array_msg_to_html('success'); ?>
				<?php array_msg_to_html('error'); ?>
				<?php array_msg_to_html('notice'); ?>
			</div>
			<div id="ga-form-box">
				<form method="post" action="./recover.php?step=2" id="recoverform">
					<hr class="space" />
					<p class="prepend-half">
						Seu email foi desassociado do usuário em questão.<br />
						Desculpe-nos pelo transtorno.
					</p>
					<div class="prepend-half clear">
						<a href="./" title="&laquo; voltar">&laquo; voltar</a>
					</div>
				</form>

<?php
			break;
			default:
?>
			<h2>Recuperação de Senha - Passo 1</h2>
			<div id="msg_box">
				<?php array_msg_to_html('success'); ?>
				<?php array_msg_to_html('error'); ?>
				<?php array_msg_to_html('notice'); ?>
			</div>
			<div id="ga-form-box">
				<form method="post" action="./recover.php?step=2" id="recoverform">
					<hr class="space" />
					<div class="clear form-row">
						<label for="input_login" class="column">Usuário:</label>
						<input type="text" id="input_login" name="input[login]" class="ga-input-login column" />
						<br class="clear" />
					</div>
					<div class="prepend-top-quarter aRight clear">
						<input type="submit" class="btnSave" value="Enviar" name="btnAct" />
						<input type="hidden" value="first" name="steps" />
					</div>
					<div class="prepend-half clear">
						<a href="./" title="&laquo; voltar">&laquo; voltar</a>
					</div>
				</form>
	
<?php
			break;
		}
?>
			</div>

		</div><!-- .ga-login-box -->
	</div><!--.container-->

	<!--#BEGIN javascripts -->
	<script type="text/javascript" src="./includes/js/jquery.js" charset="utf-8"></script>
	<script type="text/javascript" src="./includes/js/jquery.validate.js" charset="utf-8"></script>
	<script type="text/javascript" src="./includes/js/jquery.ga-admin.validate.js" charset="utf-8"></script>
<!--#END javascript -->
<!--#BEGIN inline definition -->
	<script type="text/javascript">
	// <![CDATA[
		jQuery(document).ready(function($){
			$('#recoverform').validate({
				rules:{
					'input[login]':{required:true,login:true},
					'input[senha]':{required:true},
					'input[resenha]':{required:true,equalTo:'#input_senha'}
				}
			});
			$(".external").attr({target:"_blank"});
		});
	// ]]>
	</script>
<!--#END inline definition -->
</body>
</html>
<?php

/* End of File: recover.php */
/* Path: ga-admin/recover.php */