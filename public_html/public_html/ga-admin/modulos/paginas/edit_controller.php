<?php
/**
 * Basic::Paginas::edit_Controller
 *
 * Arquivo que controla o cadastro e edição de páginas
 * 
 * @author	   Rafael Benites <rbenites@gestaoativa.com.br>
 * @version    1.000, Created: 13/09/2010, LastModified: 13/09/2010
 * @package    Basic
 * @subpackage Paginas
 */
 
	if (!isset($the_table))
		$the_table = 'rb_paginas';

// Campos que devem ser preenchidos
	$required = "titulo";
	
// Tratar dados recebidos por post
	if( isset($_POST['input']) )
	{
		$the_input	= _post($_POST["input"]);
		//  Caso não seja permitido adicionar novas páginas use algo do tipo
	/*
		if( empty($the_input['id']) && isset($_GET['id']) && is_numeric($_GET['id']) )
		{
			$the_input['id'] = $_GET['id'];
		}
		$tst = temVazio( $the_input, $required, true );
		// apague este abaixo
	*/
		$tst = temVazio( $the_input, $required );
		
		if( $tst )
		{		
		/*	if( $tst == 'id' ) 
				add_msg( sprintf('Ocorreu algum erro ao tentar processar seu pedido <a href="?modulo=%s">Clique aqui</a>', $the_module ), 'error', true);
			else
		*/
				add_msg( sprintf('O campo[%s] deve ser preenchido!', $tst), 'error' );
		}
		else
		{
			$sql = toQuery( $the_table, $the_input );
			$rs  = _query( $sql );
			add_msg('Dados cadastrados com sucesso!', 'success');
			if ($the_action == 'Add')
			{ 
				$the_input = array();
				// a opção de add será mantida apenas  na criação 
			}
		}
	}

// recupera dados
	if(isset($_GET['id']))
	{
		$id = (int) $_GET['id'];
		$assoc = sqlQuery(sprintf("SELECT * FROM `%s` WHERE `id`=%s", $the_table, $id), 'assoc');
		if (!empty($assoc))
			$the_input = $assoc[0];
		else
			$the_action = "Add";
	}

// ############  MIDIAS ###############
	$allow_these     = array('jpg','png','gif','jpeg','bmp', 'ytb');
	$widths          = array();
	$heights         = array();
	$useCrop         = 'true';
	$midia_msg       = "Resolução recomendada: 800x600px";
 //caso seja necessário configurações diferentes
	switch( $the_input['id'] )
	{
		case 101:
			$widths  = array(320,100);
            $heights = array(240,75);
		break;
        case 106:
			$allow_these     = array('gmap');
            $uploadInterface = 'rbMidiaPack';
		break;
		default:
		break;
	}
 // */
 
	/**
	 * Controlador das mídias
	 */
	include ("midia/midia_control.php");	
//########


// caso algum erro, form base para cadastro de um novo
	if( !is_array($the_input) )
		$the_input = array();

// mensagens
	array_msg_to_html('success');
	array_msg_to_html('error');
	array_msg_to_html();

/* End of File: edit_controller.php */