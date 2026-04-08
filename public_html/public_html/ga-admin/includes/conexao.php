<?php
/**
 * Config::conexao
 *
 * Arquivo que faz conexão e seleção do banco de dados definido em config_inc.php
 * A conexão será armazenada em $the_conection, em caso de falha ou ausência do
 * arquivo de configuração, o script encerra a execução
 *
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   $Id: 2.000 config::conexo.php 2012-06-22 rbenites $
 * @package   Config
 */

// caso o arquivo de configuração não esteja setado o script será interrompido
	if (!defined('_db_server'))
	{
		header ("Content-type: text/html; charset=UTF-8");
		die ("Um dos arquivos necessários para o correto funcionamento do sistema parece não ter sido incluso!");
	}
/**
 * Variável que recebe o resultado da última query consequentemente o ultimo valor de "affectedRows"
 * @name $the_affected_value
 * @global integer $the_affected_value
 */
	$the_affected_value = NULL;
/**
 * Variável que recebe a instancia do PDO que guarda a conexão com o banco
 * @name $the_connection
 * @global object $the_connection
 */
	try
	{
		$the_connection = new PDO (sprintf('mysql:dbname=%s;host=%s;', _db_base, _db_server), _db_user, _db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
	}
	catch (PDOException $ex)
	{
		header("Content-type: text/html; charset=UTF-8");
		die ('Falha na conexão com o banco de dados: ' . $ex->getMessage());
	}

/* End of File: conexao.php */
/* Path: /ga-admin/includes/conexao.php */