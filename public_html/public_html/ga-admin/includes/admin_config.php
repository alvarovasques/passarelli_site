<?php
/**
 * Config::admin_config
 *
 * Inclui os arquivos necessários para o funcionamento inicial do sistema adminitrativo<br>
 *<ul>
 *	<li><b>dBub.php</b> - classe escolhida como padrão de debug</li>
 *	<li><b>config_inc.php</b> - arquivo contendo informações únicas a cada cliente</li>
 *	<li><b>conexao.php</b> - arquivo que faz a conexão com o banco de dados usando dados definidos em config_inc.php</li>
 *	<li><b>functions.php</b> -funções padrões do sistema</li>
 *	<li><b>image_funcitons.php</b> - funções para tratarem de imagens.</li>
 *</ul>
 *
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   $Id: 1.001 config::admin_config.php 2010-09-13 00:00:00 rbenites $
 * @package   Config
 */

 /**
  * Faz uso da classe dBug para todos os "debugs" dentro do admin
  */
	require_once (dirname(__FILE__) . "/dBug.php");
 /**
  * Inclui os dados fornecidos na instalação como nome de cliente, dados das bases e dados de data e hora
  */
	require_once (dirname(__FILE__) . "/config_inc.php");
 /**
  * Inclui o arquivo que fará conexão com o banco de dados
  */
	require_once (dirname(__FILE__) . "/conexao.php");
 /**
  * Inclui as funçoes gerais do sistema
  */
	require_once (dirname(__FILE__) . "/functions.php");
 /**
  * Inclui as funções de imagens do sistema
  */
	require_once (dirname(__FILE__) . "/image_functions.php");

# end of file ga-admin/includes/admin_config.php rbenites 2011-08-12