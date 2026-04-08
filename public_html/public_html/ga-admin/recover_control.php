<?php
/**
 * ga-admin/recover_control 
 *
 * Arquivo que faz o processamento para recuperação de senha
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @author      Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     1.001, Created: 30/09/2010, LastModified: 29/11/2010
 * @package     Core
 */
 
// ####################### CONFIGURAÇÕES ################################
	// configuração para smtp
	$smtp = array(
		'Port'     => 465,
		'Host'     => 'ssl://smtp.gmail.com',
		'Username' => 'producao@gestaoativa.com.br',
		'Password' => 'gaadmin1640'
	);
	// */
// ####################### CONFIGURAÇÕES ################################3


/**
 * Inclue todos os arquivos básicos necessários para o sistema administrativo
 */
	require_once "includes/admin_config.php";

/**
 * Classe usada para auxiliar o envio de email
 */
	require_once("includes/class.phpmailer.php");
 // qual tela mostrar
	$render = 'form';
 // link veio do email enviado	
	if (isset($_GET['validation_key']) && isset($_GET['user_id']))
	{
	// verificamos as informações recebidas
		$test = sqlQuery(
			sprintf( "SELECT id, login FROM rb_usuarios WHERE id='%s' AND validation_key = '%s'",
						_escape($_GET['user_id']),
						_escape($_GET['validation_key'])
			), 'assoc'
		);
	// informação existe no banco
		if (!empty($test))
		{
			$_input = $test[0];
		 // O email não mais será associado ao usuário em questão
			if (isset($_GET['steps']) && $_GET['steps']==-1)
			{
				$_input['email'] = '';
				if (_query(toQuery('rb_usuarios', $_input)))
				{
					add_msg( "Seu email foi desassociado do usuário em questão", 'success' );
					$render = 'thanks';
				}
				else
					add_msg('Erro ao processar pedido tente mais tarde', 'error');
			}
			else //recuperação de senha
			{
				$render = 'final';				
				add_msg('Digite sua nova senha','success');
			}
		}
		else
			add_msg( 'A requisição não existe e/ou é inválida', 'error' );
	}
// trata das ações via form
	if (isset($_POST['steps']))
	{
		$input = $_POST['input'];
		switch($_POST['steps'])
		{
			case 'first':
				$usuario = sqlQuery( sprintf("SELECT id,email,ultimo FROM rb_usuarios WHERE login = '%s'", _escape($input['login'])), 'assoc' );
				//para cada pedido de senha uma nova key eh gerada invalidando as anteriores
				if (count($usuario) && valida_email($usuario[0]['email']))
				{
					$render = 'second';
					$usuario = $usuario[0];
					$usuario['validation_key'] = geraHash();
					$sql = toQuery('rb_usuarios', $usuario, false);
					_query($sql);
					// enviar a mensagem
					$body  = '<div style="margin:0 auto;width:550px;background:#FFF;color:#444;border:2px dotted #00F;padding:10px;font-size:11pt;text-align:justify">';
					$body .= sprintf( '<h2>Recupera&ccedil;&atilde;o de Senha - %s</h2>', $the_client );
					$body .= '<p>A opera&ccedil;&atilde;o de recupera&ccedil;&atilde;o de senha foi requisitada junto ao painel administrativo do site';
					$body .= sprintf( '[ <strong>%s</strong> ], em %s, &agrave;s %s.</p>', $the_client, inverteData($the_day), $the_hour );
					$body .= '<p>Este email foi cadastrado no nosso sistema associado a um de nossos usu&aacute;rios, ';
					$body .= sprintf('cujo a senha pode ser recuperada clicando [<a href="%s/ga-admin/recover.php?step=3&amp;validation_key=%s&amp;user_id=%d">AQUI</a>].</p>', BASE_URL, $usuario['validation_key'], $usuario['id'] );
					$body .= '</div>';

					// intancia o Mailer
					$mail = new PHPMailer();
					$mail->CharSet = 'UTF-8';
				// config smtp
					if (isset($smtp) && is_array($smtp))
					{
						$mail->SetFrom( $smtp['Username'], 'Recuperação de Senha' );
						$mail->IsSMTP();
						$mail->SMTPAuth  = true;
						$mail->Username  = $smtp['Username'];
						$mail->Password  = $smtp['Password'];
						$mail->Host      = $smtp['Host'];
 						$mail->Port      = $smtp['Port'];
 						// $mail->SMTPDebug = 2;				
					}
					else
						$mail->SetFrom('recover@mysite.com');
					$mail->Subject    = 'Recuperação de Senha';
					$mail->AddAddress ($usuario['email']);
					$mail->IsHTML(true);
					$mail->Body     = $body;
					$mail->WordWrap = 50;
					if ($mail->Send())
						add_msg( 'Um email foi enviado para o endereço associado a este usuário!', 'success');
					else
						add_msg( 'Erro ao processar pedido tente mais tarde', 'error' );
				}
				else
					add_msg( 'Usuário e/ou email não existem', 'error' );
			break;
			case 'end':
				if ($input['senha'] == $input['resenha'])
				{
					$user = sqlQuery( 'SELECT * FROM rb_usuarios WHERE id ='.$input['id'],'assoc' );
					if (!empty($user))
					{
						unset($input['resenha']);
						$aux = array(
							'id'             => $input['id'],
							'validation_key' => '',
							'senha'          => md5($input['senha']),
							'ultimo'         => $the_now
						);
						_query(toQuery('rb_usuarios', $aux));
						//login
						$_SESSION['ga_admin_logged']	= true;
						$_SESSION['ga_admin_info']		= serialize($user[0]);
						$_SESSION['ga_client_info']		= $the_client_session;
						session_write_close();
						header("Location: ./");
						_location('index.php');
						exit(0);
					}
					else
						add_msg ('Erro ao processar pedido tente mais tarde', 'error');
				}
				else
					add_msg ('Senha não confere', 'error');
			break;
		}
	}
	// mensagem
	if ($render == 'form')
		add_msg('Informe seu login, para recuperação de sua senha' );

/* End of File: recover_control.php */
/* Path: ga-admin/recover_control.php */