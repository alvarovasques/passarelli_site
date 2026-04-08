<?php
/**
 * Midia::edit
 *
 * Provê interface para edição de uma ou mais mídias
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.004, Created: 30/09/2010, LastModified: 29/11/2010
 * @package 	Midia
 */

	/**
	 * Acesso as funções das mídias 
	 */
	require_once( 'midia.php' );

	$id = 1;
	if( isset($_GET['id']) && is_numeric($_GET['id']) )
	{
		$id = $_GET['id'];
	}
	$tipo = '';
	if( isset($_GET['tipo']) )
	{
		$tipo = $_GET['tipo'];
	}
	//recupera midias ordenadas
	$midias = getMidiaOrdered( $id, $tipo);
	// ordema maxima pra criação do select
	$maxMidiaOrdem = getMaxMidiaOrdem($id, $tipo);
	// existem midias
	if( count($midias) )
	{
		/* este form eh submetido por ajax ver (rB.src.js)javascript.js */
?>
	<form id="updateform" action="midia/midia_control.php" method="post">
		<?php
			foreach( $midias as $i => $midia )
			{
		?>
		<hr class="space clear" />
		<div class="span-18">
			<div class="span-2 center">
				<?php
					if( file_exists(getMidiaLink($midia['id'],'a','path')) )
					{
						echo '<a class="croplink" href="./midia/crop.php?id='.($midia['id']).'" title="Alterar dimensões">';
						exibeMidia( $midia, 'admin');
						echo '</a>';
					}
					else
					{
						exibeMidia( $midia, 'admin');
					}
				?>
				<input type="hidden" name="input[id][<?=$i?>]" value="<?=$midia['id']?>" />
				<input type="hidden" name="input[codigo][<?=$i?>]" value="<?=$midia['codigo']?>" />
				<input type="hidden" name="input[tipo][<?=$i?>]" value="<?=$midia['tipo']?>" />
				<input type="hidden" name="oldvalue[<?=$i?>]" value="<?=_allowQuotes($midia['titulo'])?>" />
			</div>
			<div class="span-5">
				T&iacute;tulo<br />
				<input type="text" class="text span-5 last required" name="input[titulo][<?=$i?>]" value="<?=_allowQuotes($midia['titulo'])?>" /><br />
			</div>
			<div class="span-7">
				Descri&ccedil;&atilde;o<br />
				<textarea class="span-7 last" style="height:40px" name="input[descricao][<?=$i?>]" cols="30" rows="3"><?=_allowQuotes($midia['descricao'])?></textarea>
			</div>
			<div class="span-2">
				Destaque<br />
				<?php cria_select('destaque]['.$i, array(0,1), array('não', 'sim'), $midia['destaque'] ); ?>
			</div>
			<div class="span-2 last">
				Ordem:<br />
				<?php cria_num_select('ordem]['.$i, $maxMidiaOrdem, 1, $midia['ordem']); ?>
			</div>
			<hr class="space" />
			<hr />
		</div>
		<?php
			} //foreach
		?>
		<div class="span-2 append-1 prepend-15 append-bottom last">
			<input type="hidden" value="update" name="acao_midia" />
			<input type="submit" class="btnSave"value="Atualizar" id="uptBtn" />
		</div>
		<br class="clear" />
	</form>
	<script type="text/javascript">
	 // <![CDATA[
		jQuery(function($){
			$(".croplink").fancybox({
				autoDimensions:false,
				width : 1000,
				height: 1000,
				type  : 'iframe',
				titleShow:false				
			});
		});
	//]]>
	</script>
<?php
	}
	else
	{ 
		add_midia_msg('Não existem mídias associadas a este ítem');
		array_midia_msg_to_html();
	}
?>