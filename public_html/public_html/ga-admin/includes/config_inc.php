<?php
/**
 * includes/config.php
 *
 * Arquivo que traz a definição das principais constantes e variáveis,
 * a serem utilizadas no sistema, divididas em: dados do cliente, banco de dados
 * paths, data, e caminho para imagens 
 *
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   $2011-10-22 - includes/config.php - rbenites $
 * @package   Config
 */
 
// definição dos erros
	error_reporting(E_ALL ^ E_NOTICE);

// ##### DADOS DO CLIENTE #####
	$the_client         = "Passareli";
	$the_client_session = "passareli-4fe602036e503607f7c15854a378d48f";

// ##### BANCO DE DADOS #####
/**
 * Define o servidor de conexão com o banco de dados
 */
	if (!defined("_db_server")) {
		define("_db_server", getenv('DB_HOST') ? getenv('DB_HOST') : "localhost");
    }
/**
 * Nome do banco de dados que o sistema manipulará
 */
	if (!defined("_db_base")) {
		define("_db_base", getenv('DB_NAME') ? getenv('DB_NAME') : "passarel_passare");
    }
/**
 * Identificação do usuário que fará a conexão ao banco
 */
	if (!defined("_db_user")) {
		define("_db_user", getenv('DB_USER') ? getenv('DB_USER') : "passarel_passare");
    }
/**
 * Senha do usuário para conexão
 */
	if (!defined("_db_password")) {
		define("_db_password", getenv('DB_PASS') ? getenv('DB_PASS') : "T8u0Iuo5z5mi");
    }

// ##### DATA E HORA #####
	date_default_timezone_set('America/Campo_Grande');
    $the_now  = date('Y-m-d H:i:s');
    $the_day  = date('Y-m-d');
    $the_hour = date('H:i:s');

// ##### CAMINHO LOGOS #####
	$ga_logo   = "includes/images/ga.png";
	$ga_name   = "Gestão Ativa";
	 // $the_logo = "includes/images/logo.png";

// ##### DEFINE OS PATHS #####
/**
 * Constante com o caminho absoluto(path) até a base do sistema
 * @since 2011-09-26 uso do próprio caminho do arquivo para esta definição
 */
	if (!defined('BASE_PATH')) {
		define ('BASE_PATH', dirname(dirname(dirname(__FILE__))));
    }

/**
 * Constante com o caminho absoluto(url) até a base do sistema
 */
	if (!defined("BASE_URL")) {
        define( "BASE_URL", "https://".$_SERVER['SERVER_NAME']."" );
    }
//##### DADOS DE SESSÃO ######
	session_start();
	session_name($the_client_session);

/* End of File: includes/config_inc.php */
/* Path: /ga-admin/includes/config_inc.php */