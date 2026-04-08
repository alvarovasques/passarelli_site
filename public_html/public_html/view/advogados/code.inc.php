<?php
//############# Configuração ######################
 // id da pagina a ser usado
	$pagina_id 		= 102;
 // indicação de quantidade de midias
	$pagina_midias 	= 0;
 // nome do modulo e consequentemente da tabela que será tratado	
	$nome_modulo 	= 'advogados';
 // Módulo view
    $siteConfig->modulo = 'advogados';
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
    
    $socios     = sqlQuery(sprintf('SELECT * FROM `rb_%s` WHERE `socio` ORDER BY `nome` ASC', $nome_modulo));
    $associados = sqlQuery(sprintf('SELECT * FROM `rb_%s` WHERE `socio` = 0 ORDER BY `nome` ASC', $nome_modulo));
   
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
    
    // Breadcrumb
	$breadcrumb = array(
		'Home'          => HOME_URL,
        $pagina->titulo => 'javascript:void(0)'
    );