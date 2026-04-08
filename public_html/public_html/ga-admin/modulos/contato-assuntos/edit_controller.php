<?php
/**
 *	contato-assuntos::edit_controller.php
 *
 * Salva os dados vindos do formulário de cadastro e edição, exibe interface de inserção de mídias se existir
 *
 * Recebe e trata os dados recebidos por <b>$_POST["input"]</b> e <b>$_GET["id"]</b>
 *
 * @version   1.002, Created: 26/06/2013
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @package   Generator 2.01
 */

// exitencia da tabela
	if (!isset($the_table))
		$the_table = "rb_contato-assuntos";

// dados iniciais
	$the_input = array();

// Campos que devem ser preenchidos, validação no servidor (apenas vazio)
	$required = "titulo,email,ordem,ativo,";

// recupera e salva dados do POST (Edit, Add)
	if (isset($_POST["input"]))
	{
		$the_input	= _post($_POST["input"]);
		$break	    = temVazio($the_input, $required);
		if ($break) 
			add_msg( sprintf( "O campo [%s] não foi preenchido corretamente!", $break ), "error" );
		else
		{
			
				$the_input["ordem"] = set_ordem ($the_input, $the_table, "ordem");
			
			$sql = toQuery ($the_table, $the_input);
			if (!$rs  = _query($sql))
			{
				add_debug_msg( _sqlError(), sprintf("contato-assuntos/edit_controller.php[%s]", $the_action) );
				add_msg( "Erro ao salvar dados, tente novamente mais tarde!", "error" );
			}
			else 
			{ 
				add_msg( "Dados foram armazenados corretamente!", "success"); 
				if ($the_action == "Add") 
				{
					$the_action      = "Edit"; 
					$the_input["id"] = _lastId(); 
				}
			}
		}
 	}

// recupera dados do identificador vindo por GET (Edit)
	if (isset($_GET["id"]))
	{
		$id = (int) $_GET["id"];
		$the_input = sqlFetch("SELECT * FROM `{$the_table}` WHERE `id` = {$id}", "assoc");
		if (!$the_input) // se não conseguir a recuperação do item, passa a ser adição
			$the_action = "Add";
	}



// ########## MENSAGENS ##########
	array_msg_to_html('success');
	array_msg_to_html('error');
	array_msg_to_html();

/* End of File: edit_controller.php */
/* Path: ga-admin/modulos/contato-assuntos/edit_controller.php */