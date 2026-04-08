<?php
/**
 * Midia::rbMidiaPack::add
 *
 * Codificação necessária para inserir a interface de upload
 *
 * Neste arquivo temos:
 *<ol>
 *	<li>Inclusão do arquivo javascript para controle das ações(rbMidiaPack.js);</li>
 *	<li>Toda codificação htmlnecessária para a interface</li>
 *	<li>Feita a configuração da interface para dar suporte à mídia</li>
 *</ol>
 *
 *<b>Configurações extras</b>
 *<code>
 *<?php
 *	// No edit_controller.php de cada módulo você pode configurar o rbMidiaPack
 *	$useiFrame = true; // usar interface de upload por iframe
 *	 // muda os labels de exibição
 *	$useLabels = array( 'Título', 'Legenda', 'Foto', 'Links' );
 *	$midiaLabels = array( 	'legend' => 'apresentação', 
 *							'file' => 'Nome do link para adicionar arquivos',
 *							'text' => 'Nome do link para adicionar links(dados)'
 *						);
 *	$hideFile = true/false; //esconde o botao de arquivo
 *	$hideText = true/false; //sconde o botão de dados
 *?>
 *</code>
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.0, Created: 30/07/2010, LastModified: 30/09/2010
 * @package     UploadInterface
 * @subpackage	rbMidiaPack
 */
if(!isset($midiaLabels) )
{
	$midiaLabels = array( 'legend' => 'Adicionar Mídias', 'file' => 'Arquivo', 'text' => 'Links' );
}
if( !isset($hideFile) )
	$hideFile = false;
if( !isset($hideText) )
	$hideText = false;

?>
<script type="text/javascript" src="./midia/rbMidiaPack/rbMidiaPack.js" charset="utf-8"></script>

<div id="midia_form_wrapper">
<?php
	if($the_input['id'] && $useiFrame)
	{
?>
<!-- iframe upload settings { */-->
	<script type="text/javascript">
	/* <![CDATA[ */
		RB.useAIU();
		RB.addParam('id','<?=$the_input['id']?>');
		RB.addParam('modulo', '<?=$the_module;?>');
		RB.addParam('acao', '<?=$the_action;?>');
		RB.addParam('widths', '<?=json_encode($widths);?>');
		RB.addParam('heights', '<?=json_encode($heights);?>');
		RB.addParam('useCrop', '<?=json_encode($useCrop);?>');
		RB.addParam('reSize', '<?=$reSize?1:0;?>');
		RB.addParam('allow_these', '<?=json_encode($allow_these);?>');
	/* ]]> */
	</script>
<!-- } #iframe upload -->
<?php
	}
	if( isset($useLabels) && count($useLabels) )
	{
?>
	<script type="text/javascript">
	/* <![CDATA[ */
		RB.setLabels(<?=json_encode($useLabels);?>);
	/* ]]> */
	</script>
<?php
	}
?>
	<div class="span-19 last" id="midia_box">
		<div class="span-3">
			<div class="rbMidia-add">
				<div class="rbMidia-title">
					<?php echo $midiaLabels['legend']?>
				</div>
			<?php if( !$hideFile ) { ?>
				<div class="rbMidia-row">
					<a href="javascript:;" onclick="RB.addMidia('file')">
						<img src="./midia/rbMidiaPack/upl.png" alt="Adicionar Arquivos" title="Adicionar Arquivos" /></a>
					<a href="javascript:;" onclick="RB.addMidia('file')" title="Adicionar um Arquivo">
						<?php echo $midiaLabels['file']?></a>
				</div>
			<?php } ?>
			<?php if( !$hideText ) { ?>
				<div class="rbMidia-row">
					<a href="javascript:;" onclick="RB.addMidia('text')">
						<img src="midia/rbMidiaPack/text.png" alt="Adicionar Dados" title="Adicionar Dados" /></a>
					<a href="javascript:;" onclick="RB.addMidia('text')" title="Adicionar um Link, embed">
						<?php echo $midiaLabels['text']?></a>
				</div>
			<?php } ?>
				<br class="clear" 	/>
			</div>
		</div>
		<div class="span-15 last" id="midia_wrapper"></div>
	</div>
	<hr />
</div>