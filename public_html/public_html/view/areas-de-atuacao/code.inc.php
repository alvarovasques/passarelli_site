<?php
//############# Configuração ######################
 // id da pagina a ser usado
	$pagina_id 		    = 103;
 // indicação de quantidade de midias
	$pagina_midias 	    = 0;
 // nome do modulo e consequentemente da tabela que será tratado	
	$nome_modulo 	    = 'areas-atuacao';
 // Modulo view
    $siteConfig->modulo = 'areas-de-atuacao';
//############# Configuração ######################

    // Faz a busca pelos dados da página
	$pagina = sqlQuery( sprintf('SELECT * FROM `rb_paginas` WHERE `id` = %d LIMIT 1', $pagina_id) );
	if (!empty($pagina)) {
		$pagina = $pagina[0];
	}
    else {
		$pagina = (object)array(
			'id'          => 0,
			'titulo'      => 'Erro',
			'texto'	      => '<p>Erro inesperado ao recuperar dados. Por favor tente mais tarde!</p>',
			'keywords'    => '',
			'description' => ''
		);
	}
    
    // Breadcrumb
	$breadcrumb = array(
		'Home'     => HOME_URL
	);

    if (isset($_GET['detail']) && is_numeric($_GET['detail'])) {
		$item = sqlFetch(sprintf('SELECT * FROM `rb_%s` WHERE `id`=%d AND `ativo`', $nome_modulo, $_GET['detail']));
	
        if (empty($item)) {
            unset($item);
        }
        else {
            $breadcrumb[$pagina->titulo] = HOME_URL . "/{$siteConfig->modulo}/";
            $breadcrumb[$item->titulo]   = 'javascript:void(0)';
        }
    }
    
	if (!isset($item)) {
        $itens = sqlQuery(sprintf('SELECT * FROM `rb_%s` WHERE `ativo` ORDER BY `ordem`', $nome_modulo));
	
        $breadcrumb[$pagina->titulo] = 'javascript:void(0)';
    }
    
	// recupera as midias da pagina
	$pagina->midias = getMidia($pagina->id, 'paginas', $pagina_midias);
    
    // Atualiza titulo e dados de keywords e description
	if (!empty($pagina->keywords)) {
		$siteConfig->keywords = $pagina->keywords;
    }
	if (!empty($pagina->description)) {
		$siteConfig->description = $pagina->description;
	}
    $siteConfig->titulo = sprintf('%s | %s', $pagina->titulo, $siteConfig->titulo);