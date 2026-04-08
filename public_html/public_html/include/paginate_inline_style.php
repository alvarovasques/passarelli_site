<?php
/**
 *	Paginate_inline_style
 *
 * Arquivo que possui uma paginação numérica com divisões entre elas e links de "seguinte" e "anterior"<br />
 * Mostrará de acordo com as configurações:
 *<ol>
 *	<li>[anterior] 1 [2] 3 4 5 6 7 8 9 10 [seguinte]</li>
 *	<li>[anterior] 1 2 3 [4] 5 6 7... 15 16 [seguinte]</li>
 *	<li>[anterior] 1 2 ... 20 21 [22] 23 24 ... 50 51 [seguinte] </li>
 *	<li>[anterior] 1 2 ... 13 14 [15] 16 17 [seguinte]
 *</ol>
 * São necessárias as variáveis:
 *<ul>
 *	<li><b>$the_total</b>: o número total de registros;
 *	<li><b>$num_por_pag</b>: o número de registros por páginas;
 *	<li><b>$the_pag</b>: a página corrente (<i>a primeira página é "0"</i>);
 *	<li><b>$the_link</b>: como será linkado ( usar padrão sprintf. Ex. $the_link = '?pag=%d'; ); 
 *</ul>
 *<b>Importante</b>: Essa paginação já vem estilizada 
 *
 *
 *	@version	1.1 , Created: 06/09/2010
 *	@author		Rafael Benites <rbenites@gestaoativa.com.br>
 *	@author		Diogo Campanha <diogo@gestaoativa.com.br>
 *	@package	Paginate
 *	@filesource
 */

// só exibiremos se tivermos itens suficientes
	if( $the_total > $num_por_page )
	{
		// os estilos que serão usados
		$sty = array (
			'wrap' => 'font:10px Arial,Helvetica,sans-serif;line-height:15px;', 
			'link' => 'margin:2px;padding:2px 5px;border:1px solid #999;color:#666;text-decoration:none',
			'curr' => 'margin:2px;padding:2px 5px;border:1px solid #999;color:#FFF;font-weight:bold;background:#999',
			'disa' => 'margin:2px;padding:2px 5px;border:1px solid #999;color:#999' );
			
		if( !isset($the_link) )
		{
			$the_link = '?pagina=%d';
		}

		$adjacents = 2;
		$pag_atual = $the_pag + 1; 
		// Valores iniciais
		$pag_anterior = $pag_atual - 1;	
		$pag_seguinte = $pag_atual + 1;							
		$pag_ultima = ceil($the_total/$num_por_page);		
		$pag_penultima = $pag_ultima - 1;	
?>
	<div style="<?=$sty['wrap']?>">
<?php
	// Existe anterior
	if ($pag_atual > 1)
	{ 
?>
		<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($pag_anterior-1) );?>" title="Ir para <?=$pag_anterior?>">
			Anterior</a>
<?php
	}
	else
	{ 
?>
		<span style="<?=$sty['disa']?>">Anterior</span>
<?php
	}
	// nao existem páginas suficientes para quebrar
	if( $pag_ultima < 7 + ($adjacents * 2) )
	{
		for ( $counter = 1; $counter <= $pag_ultima; $counter++ )
		{
			if ($counter == $pag_atual)
			{ 
?>
				<span style="<?=$sty['curr']?>"><?=$counter; ?></span>
<?php		}
			else
			{
?>
				<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($counter-1) );?>" title="Ir para <?=$counter?>">
					<?=$counter; ?></a>
<?php		}
		}
	}
	// algumas paginas serão escondidas
	else if( $pag_ultima > 5 + ($adjacents * 2) )
	{
		//mostra as primeiras ... duas ultimas
		if($pag_atual < 1 + ($adjacents * 2))
		{
			for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
			{
				if ($counter == $pag_atual)
				{
?>
				<span style="<?=$sty['curr']?>"><?=$counter?></span>
<?php			}
				else
				{
?>
				<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($counter-1) );?>" title="Ir para <?=$counter?>">
					<?=$counter?></a>
<?php			}
			}
?>
			...
			<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($pag_penultima-1) );?>" title="Ir para <?=$pag_penultima; ?>">
				<?=$pag_penultima; ?></a>
			<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($pag_ultima-1) );?>" title="Ir para <?=$pag_ultima; ?>">
				<?=$pag_ultima; ?></a>
<?php
		} 
		// duas primeira .. numero adjacentes de paginas à atual ... duas ultimas
		else if($pag_ultima - ($adjacents * 2) > $pag_atual && $pag_atual > ($adjacents * 2))
		{
?>
			<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, 0 );?>" title="Ir para 1">
				1</a>
			<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, 1 );?>" title="Ir para 2">
				2</a>
			...
<?php
			for ($counter = $pag_atual - $adjacents; $counter <= $pag_atual + $adjacents; $counter++)
			{
				if ($counter == $pag_atual)
				{
?>
				<span style="<?=$sty['curr']?>"><?=$counter?></span>
<?php			}
				else
				{
?>
				<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($counter-1) );?>" title="Ir para <?=$counter?>">
					<?=$counter?></a>
<?php			}	
			}?>
			...
			<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($pag_penultima-1) );?>" title="Ir para <?=$pag_penultima; ?>">
				<?=$pag_penultima; ?></a>
			<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($pag_ultima-1) );?>" title="Ir para <?=$pag_ultima; ?>">
				<?=$pag_ultima; ?></a>
<?php
		}
		// duas primeiras ... ultimas 
		else
		{
?>
			<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, 0 );?>" title="Ir para 1">
				1</a>
			<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, 1 );?>" title="Ir para 2">
				2</a>
			...
<?php
			for ($counter = $pag_ultima - (2 + ($adjacents * 2)); $counter <= $pag_ultima; $counter++)
			{
				if ($counter == $pag_atual)
				{
?>
				<span style="<?=$sty['curr']?>"><?=$counter; ?></span>
<?php			}
				else
				{
?>
				<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($counter-1) );?>" title="Ir para <?=$counter?>">
					<?=$counter?></a>
<?php			}			
			}
		}
	}
	// Existe proximo
	if( $pag_atual < $counter - 1 )
	{
?>
		<a style="<?=$sty['link']?>" href="<?=sprintf($the_link, ($pag_seguinte-1) );?>" title="Ir para <?=$pag_seguinte; ?>">
			Seguinte</a>
<?php
	}
	else
	{
?>
		<span style="<?=$sty['disa']?>">Seguinte</span>
<?php
	}
?>
	</div>
<?php
	} //total>num_por_page 
?>