<?php
/**
 * Basic::Usuarios::edit_controller
 *
 * Arquivo que controla cadastro e edição de usuários além dealteração de senha
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.000, Created: 13/09/2010, LastModified: 13/09/2010
 * @package     Basic
 * @subpackage  Usuarios
 */

	if( !isset($the_table) )
		$the_table = 'rb_usuarios';
// requeridas
	$required = "'login','email'";
	if( $the_action != "Edit" )
	{
		$required .= ",'senha', 'resenha'";
	}
// Tratar dados recebidos por post
	if( isset($_POST['input']) )
	{
		$the_input	= _post($_POST["input"]);
		if( $the_user['tipo'] == 0 && $the_input['id'] != $the_user['id'] )
			add_msg( sprintf("Caro %s, você só pode alterar seus próprios dados", $the_user['login']) );
		else
		{
			$tst = temVazio( $the_input, $required);
// verifica se a senha informada é igual a confirmação de senha //
			if( isset($the_input['resenha']) && !$tst )
			{
				if( $the_input['resenha'] != $the_input['senha'] )
					$tst = 'resenha';
				unset( $the_input['resenha'] );
			}
			if($tst)
			{
				add_msg( sprintf('O campo[%s] deve ser preenchido corretamente!', $tst), 'error' );
			}
			else
			{
			// Verifica se não existe login já cadastrado			
				$sql = sprintf("SELECT `id` FROM `%s` WHERE `login` = '%s'", $the_table, $the_input['login']);
				$res = sqlQuery($sql);
				if( count($res)==0 || $res[0]->id == $the_input['id'] )
				{
					$sql = toQuery($the_table, $the_input);
					$rs  = _query($sql);
					add_msg('Dados de usuário cadastrados com sucesso!', 'success');
					if($the_action == 'Add')
						$the_input['id'] = _lastId();
					$the_action = "Edit";
				}
				else
				{
					add_msg( sprintf( 'O login [%s] já está sendo usado!', $the_input['login'] ) );
					$the_input['login'] = '';
				}
			}
		}
	}
	
// se o usuario é do tipo usuário ele não tem permissão de criação de novos usuarios
	if( $the_action == "Add" && $the_user['tipo'] == 0 )
	{
		add_msg( sprintf("Caro %s, você só pode alterar seus próprios dados", $the_user['login']), 'error' );
		$the_input = $the_user;
		$the_action = "Edit";
	}
	
// recupera dados
	if(isset($_GET['id']))
	{
		$id = (int) $_GET['id'];
	// usuários só vêem seus próprios dados
		if( $the_user['tipo'] == 0 && $id != $the_user['id'] )
		{
			add_msg( sprintf("Caro %s, você não pode criar novos usuários", $the_user['login']) );
			$id = $the_user['id'];
		}
		else if ( $id ==1 && $the_user['id'] > 1)
		{
			$id = 0; // invalida edição por usuário não ga_admin
		}
		$assoc = sqlQuery(sprintf("SELECT * FROM `%s` WHERE `id`=%s", $the_table, $id), 'assoc');
		if (!empty($assoc))
			$the_input = $assoc[0];
		else
			$the_action = "Add";
		
	}
	
// caso algum erro, form base para cadastro de um novo
	if( !is_array($the_input) )
		$the_input = array();

	// senha não será exibida
	if (isset($the_input['senha']))
		$the_input['senha'] = ''; 

// #### MENSAGENS ####
	array_msg_to_html('success');
	array_msg_to_html('error');
	array_msg_to_html();
?>
<!--/* #usuarios/edit_controller */-->
