<?php
/**
 *	Template::default_paginate
 *
 * Faz paginção por números com separação entre eles, anterior e próximo < >
 *
 *<b>Configurações</b>
 *<ol>
 *	<li>integer	<b>$the_total</b> número total de registros da consulta a ser paginada;</li>
 *	<li>integer	<b>$the_page</b> número da página atual;</li>
 *	<li>string	<b>$the_search</b> dados de busca se existirem(opicional);</li>
 *	<li>integer	<b>$num_por_page</b> número de registros a serem exibidos por página;</li>
 *</ol>
 *
 * @author	    Diogo Campanha <diogo@gestaoativa.com.br>
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.003, Created: 30/09/2010, LastModified: 28/11/2010
 * @package     Template
 */
 

	$the_link = sprintf("?modulo=%s", $the_module);
	if($the_search != "")
		$the_link .= sprintf("&amp;busca=%s", urlencode($the_search));

	// verifica se esta setado a variavel de paginacao, senao coloca page
	if(!isset($indice))	
		$indice = 'pagina';
	
	$stages = 3;
	$page = $the_page+1; 
		
	// Initial page num setup
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($the_total/$num_por_page);		
	$LastPagem1 = $lastpage - 1;				
	
	$paginate = '<div class="paginate clear" id="pagin_container">';
	// Previous
	if ($page > 1){
		$paginate .= sprintf( '<a href="%s&amp;%s=%s">Anterior</a>', $the_link, $indice, ($prev-1));
	}else{
		$paginate.= '<span class="disabled">Anterior</span>';
	}
	// Pages	
	if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
	{	
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
			if ($counter == $page){
				$paginate .= sprintf( '<span class="current">%s</span>', $counter);
			}else{
				$paginate .= sprintf( '<a href="%s&amp;%s=%s">%s</a>', $the_link, $indice, ($counter-1), $counter);
			}					
		}
	}
	else if($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
	{
		// Beginning only hide later pages
		if($page < 1 + ($stages * 2))		
		{
			for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
			{
				if ($counter == $page){
					$paginate .= sprintf( '<span class="current">%s</span>', $counter);
				}else{
					$paginate .= sprintf( '<a href="%s&amp;%s=%s">%s</a>', $the_link, $indice, ($counter-1), $counter);
				}					
			}
			$paginate.= "...";
			$paginate .= sprintf( '<a href="%s&amp;%s=%s">%s</a>', $the_link, $indice, ($LastPagem1-1), $LastPagem1);
			$paginate .= sprintf( '<a href="%s&amp;%s=%s">%s</a>', $the_link, $indice, ($lastpage-1), $lastpage);
		}
		// Middle hide some front and some back
		elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
		{
			$paginate.= sprintf( '<a href="%s&amp;%s=0">1</a>', $the_link, $indice );
			$paginate.= sprintf( '<a href="%s&amp;%s=1">2</a>', $the_link, $indice );
			$paginate.= "...";
			for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
			{
				if ($counter == $page){
					$paginate .= sprintf( '<span class="current">%s</span>', $counter);
				}else{
					$paginate .= sprintf( '<a href="%s&amp;%s=%s">%s</a>', $the_link, $indice, ($counter-1), $counter);
				}					
			}
			$paginate.= "...";
			$paginate .= sprintf( '<a href="%s&amp;%s=%s">%s</a>', $the_link, $indice, ($LastPagem1-1), $LastPagem1);
			$paginate .= sprintf( '<a href="%s&amp;%s=%s">%s</a>', $the_link, $indice, ($lastpage-1), $lastpage);	
		}
		// End only hide early pages
		else
		{
			$paginate.= sprintf( '<a href="%s&amp;%s=0">1</a>', $the_link, $indice );
			$paginate.= sprintf( '<a href="%s&amp;%s=1">2</a>', $the_link, $indice );
			$paginate.= "...";
			for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$paginate .= sprintf( '<span class="current">%s</span>', $counter);
				}else{
					$paginate .= sprintf( '<a href="%s&amp;%s=%s">%s</a>', $the_link, $indice, ($counter-1), $counter);
				}
			}
		}
	}
	// Next
	if ($page < $counter - 1){
		$paginate .= sprintf( '<a href="%s&amp;%s=%s">Seguinte</a>', $the_link, $indice, ($next-1));
	}else{
		$paginate.= '<span class="disabled">Seguinte</span>';
	}		
	$paginate.= "</div>";		
	// pagination
	echo $paginate;
?>