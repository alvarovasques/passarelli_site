<?php
/**
 * Template::default_edit_controller
 *
 * Arquivo que faz o controle de cadastro e edição de um item[Add, Edit]
 *
 *<b>Configurações</b>
 *<ol>
 *	<li>boolean	<b>$use_midia</b>: usar mídias;</li>
 *	<li>string	<b>$the_table</b>: a tabela a ser usada;</li>
 *	<li>string	<b>$required</b>: os campos obrigatórios separados por vírgula e entre '</li>
 *</ol>
 *
 * @link       default_controller.php
 * @author     Rafael Benites <rbenites@gestaoativa.com.br>
 * @version    1.004, Created: 30/09/2010, LastModified: 23/10/2011
 * @package    Template
 */

// define a tabela
	if (!isset($the_table))
		$the_table = sprintf('rb_%s', $the_module);
	
// definir os campos do required {todos por padrão}
	if (!isset($required))
	{
	// dados para gerar os dados
		// tipos[Field] = Type 
		$default_types  = get_columns ($the_table);
		unset($default_types['id']);
		unset($default_types['created_at']);
	// definir os campos "required"
		$required = "";
		foreach ($default_types as $f => $t)
			$required .= ", '{$f}'"
		$required = substr($required,2);
	}

// Tratar dados recebidos por post
	if (isset($_POST['input']))
	{
	// _post() aplicará alguns filtros dependendo do nome do campo
		$the_input = _post($_POST['input']);
		$break     = temVazio($the_input, $required);
		if ($break)
		{ 
			add_msg( sprintf( "O campo [%s] não pode ser vazio!", $break ), "error" );
		}
		else
		{
			$query = toQuery($the_table, $the_input);
			if (!$rs  = _query($query))
			{
				add_debug_msg (_sqlError(), sprintf("%s/edit_controller.php[%s]", $the_module, $the_action) );
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

// recupera dados vindos por get
	if (isset($_GET['id']))
	{
		$id = (int) $_GET['id'];
		$assoc = sqlQuery(sprintf("SELECT * FROM `%s` WHERE `id`=%s", $the_table, $id), 'assoc');
		if (!empty($assoc))
			$the_input = $assoc[0];
		else
			$the_action = "Add";
		
	}

// caso algum erro, form base para cadastro de um novo
	if (!is_array($the_input))
		$the_input = basic_input($the_table);

// ###########  MIDIAS ###############
	if ($use_midia)
	{
		/**
		 * Inclusão do controlador de mídias, quando estas necessárias
		 */
		include "midia/midia_control.php" ;
	}
	
// ##### 
	// campos de senha não serão exibidos
	$senhas = array ('senha', 'password', 'pass');
	foreach ($senhas as $senha)
	{
		if (isset($the_input[$senha]))
			$the_input[$senha] = '';
	}

// ####  MENSAGENS ######
	array_msg_to_html('success');
	array_msg_to_html('error');
	array_msg_to_html();

/* End of File: default_edit_controller.php */
/* Path: ga-admin/templates/default_edit_controller.php */
