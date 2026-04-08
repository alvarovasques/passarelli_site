<?php
//############# Configuração ######################
 // id da pagina a ser usado
	$pagina_id 		= 101;
 // indicação de quantidade de midias
	$pagina_midias  = 10;
 // Módulo view
    $siteConfig->modulo = 'o-escritorio';
//############# Configuração ######################

 // Faz a busca pelos dados da página
	$pagina = sqlFetch(sprintf('SELECT * FROM `rb_paginas` WHERE `id` = %d', $pagina_id));
	
    if (empty($pagina)) {
		$pagina = (object)array(
			'id'          => 0,
			'titulo'      => 'Erro',
			'texto'	      => '<p>Erro inesperado ao recuperar dados. Por favor tente mais tarde!</p>',
			'keywords'    => '',
			'description' => ''
		);
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
    
    // Breadcrumb
	$breadcrumb = array(
		'Home'          => HOME_URL,
        $pagina->titulo => 'javascript:void(0)'
	);