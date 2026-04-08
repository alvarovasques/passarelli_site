<?php
/**
 * Midia::uploadify::add
 *
 * Codificação necessária para inserir a interface de upload
 *
 * Neste arquivo temos
 *<ol>
 *	<li>Inclusão do arquivo javascript para controle das ações(jquery.uploadify.v2.1.0.min.js);</li>
 *	<li>inclusão das dependências(swfobject.js,uploadify.css);
 *	<li>Toda codificação htmlnecessária para a interface</li>
 *	<li>Feita a configuração da interface para dar suporte à mídia</li>
 *</ol>
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.003, Created: 30/08/2010, LastModified: 16/07/2012
 * @package     UploadInterface
 * @subpackage	uploadify
 */

//devido a composição da mídia que associa a um id e um tipo é necessário que exista um id
	if( isset($the_input['id']) && is_numeric($the_input['id']) )
	{
?>
<!--/* uploadify interface */-->
	<script type="text/javascript" src="./midia/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="./midia/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
	<script type="text/javascript">
	// <![CDATA[
		/* load o css */
		RB._loadCss("<?=BASE_URL?>/ga-admin/midia/uploadify/uploadify.css");
		jQuery(document).ready(function($){
			$("#uploadify").uploadify({
				'uploader' 		: 'midia/uploadify/uploadify.swf',
				'script'		: 'midia/midia_control.php',
				'cancelImg'     : 'midia/uploadify/cancel.png',
				'queueID'       : 'fileQueue',
				'auto'          : true,
				'multi'         : true,
				'wmode'			: 'transparent',
				'fileDataName'	: 'midias',
				'buttonText'	: 'Inserir Arquivo',
				'scriptData'	: {	'interface'	: 'uploadify',
									'id'		: '<?=$the_input['id']?>',
									'modulo'	: '<?=$the_module;?>',
									'acao'		: '<?=$the_action;?>',
									'widths'	: '<?=json_encode($widths);?>',
									'heights'	: '<?=json_encode($heights);?>',
									'useCrop'	: '<?=json_encode($useCrop);?>',
									'reSize'	: '<?=$reSize?1:0;?>',
									'allow_these':'<?=json_encode($allow_these);?>'
									},
				onComplete		: function(e,q,f,r,d){ RB._updateView(r); }
			});
		});
	// ]]>
	</script>
	<div class="span-17 last inline">
		<div class="span-4">
			<input type="file" name="uploadify" id="uploadify" /><br />
			<a href="javascript:jQuery('#uploadify').uploadifyClearQueue()">Limpar fila</a>
		</div>
		<div id="fileQueue" class="span-13 last"></div>
		<hr class="space" />
	</div>	
<?php
	}
	else
	{
?>
	<hr class="space" />
	<div class="span-16 info">A ferramenta de upload de arquivos só está disponível na edição. Salve os dados para poder usá-la</div>
<?php
	}
?>
	<hr class="space"/>