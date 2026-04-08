<?php
/**
 * Passarelli Advocacia 
 *
 * Arquivo com os dados de configuração do projeto,
 * definições das constantes, inclusões dos arquivos básicos
 *
 * @author     Rafael Benites <rbenites@gestaoativa.com.br>
 * @package    View
 * @subpackage Config
 */

## config & midia files ###
    $config = (dirname(dirname(__FILE__))).'/ga-admin/includes/admin_config.php';
    if (file_exists($config)) {
        include_once $config;
        require_once BASE_PATH . '/ga-admin/midia/midia.php';
    } else {
        define( 'BASE_PATH', dirname(dirname(__FILE__)));
        define( 'BASE_URL', '../..');
    }
// ### PATHS ###
/**
 * Caminho absoluto(path) para a pasta de lib's e api's
 */
	define( 'LIB_PATH', BASE_PATH . '/include');
/**
 * Caminho absoluto(path) para a pasta de templates
 */
	define( 'TPL_PATH', BASE_PATH . '/template' );

// ### URL'S ###
/**
 * Caminho absoluto(url) até a pasta de view
 */
	define( 'HOME_URL', BASE_URL.'' );
/**
 * Caminho absoluto(url) até a pasta de imagens (estáticas) do view
 */
	define( 'IMG_URL', BASE_URL.'/img' );
/**
 * Caminho absoluto(url) até a pasta de javascript's do view
 */
	define( 'JS_URL', BASE_URL.'/js' );
/**
 * Caminho absoluto(url) até a pasta de estilos do view
 */
	define( 'CSS_URL', BASE_URL.'/css' );
/**
 * Inclusão das funções de seo
 */
    include_once LIB_PATH . '/seo.php';
/**
 * Paginate
 */
    include_once LIB_PATH . '/Paginate.php';
 
// ### CONFIGURAÇÕES ###
    $siteConfig = array();
    if (function_exists('sqlQuery')) {
        $siteConfig = sqlQuery('SELECT * FROM `rb_configuracoes` LIMIT 1');
    }
    if (!empty($siteConfig)) {
        $siteConfig = $siteConfig[0];
    } else {
        $siteConfig = (object)array(
            'titulo'      => 'Passarelli Advocacia',
            'description' => 'Passarelli Advocacia',
            'keywords'    => 'Passarelli Advocacia',
            'email'       => 'producao@gestaoativa.com.br',    
            'analytics'   => '',
            'id'          => 0
        );
    }

/* End of File: config.inc.php */
/* Path: /include/config.inc.php */