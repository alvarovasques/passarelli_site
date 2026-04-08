<?php
//############# Configuração ######################
 // id da pagina a ser usado
	$pagina_id 		    = 100;
 // indicação de quantidade de midias
	$pagina_midias 	    = 0;
 // nome do modulo e consequentemente da tabela que será tratado	
	$nome_modulo 	    = 'noticias';
 // Modulo view
    $siteConfig->modulo = 'noticias';
 // numero de registros por página
	$num_por_page 	    = 5;	
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
		$item = sqlFetch(sprintf('SELECT * FROM `rb_%s` WHERE `id`=%d', $nome_modulo, $_GET['detail']));
	
        if (empty($item)) {
            unset($item);
        }
        else {
            $item->imagens = getImage($item->id, $nome_modulo);
            $item->video   = getMidiaByExtensao($item->id,$nome_modulo,array('ytb'),1);
            
            $breadcrumb[$pagina->titulo] = HOME_URL . "/{$siteConfig->modulo}/";
            $breadcrumb[$item->titulo]   = 'javascript:void(0)';
        }
    }
    
	if (!isset($item)) {
        $query     = sprintf('SELECT * FROM `rb_%s`', $nome_modulo);
        $paginacao = new Paginate(num_rows($query),3,$_GET['pagina']);        
        $itens     = sqlQuery($query.sprintf(' ORDER BY created_at DESC LIMIT %d, %d',$paginacao->getInitial(),$paginacao->getNpp()));
	
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