<?php
/**
 * valums-file-uploader::add
 *
 * Arquivo que provê interface de inserção de mídias usando valums-file-uploader {@link http://github.com/valums/file-uploader}
 *
 * Neste arquivo temos
 *<ol>
 *	<li>Inclusão do arquivo javascript para controle das ações(fileuploader.js);</li>
 *	<li>inclusão das dependências(fileuploader.css);
 *	<li>Toda codificação html necessária para a interface</li>
 *	<li>Feita a configuração da interface para dar suporte à mídia</li>
 *</ol>
 *
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version		1.001, Created: 08/10/2010, Last Modified: 18/07/2012
 * @package     UploadInterface
 * @subpackage	valums-file-uploader
 */
 //devido a composição da mídia que associa a um id e um tipo é necessário que exista um id
	if( isset($the_input['id']) && is_numeric($the_input['id']) )
	{
?>
<!--/* valums-file-uploader interface */-->
	<script type="text/javascript" src="./midia/valums-file-uploader/fileuploader.js"></script>
	<script type="text/javascript">
	// <![CDATA[
		/* load o css */
		RB._loadCss("./midia/valums-file-uploader/fileuploader.css");
		var upl;
		jQuery(document).ready(function($){
			upl = new qq.FileUploader({
				element: $('#file-upload')[0],
				_listElement: $('#fileQueue')[0],
				action: 'midia/midia_control.php',
				params: {	'interface'	: 'valums-file-uploader',
							'id'		: '<?=$the_input['id']?>',
							'modulo'	: '<?=$the_module;?>',
							'acao'		: '<?=$the_action;?>',
							'widths'	: '<?=json_encode($widths);?>',
							'heights'	: '<?=json_encode($heights);?>',
							'useCrop'	: '<?=json_encode($useCrop);?>',
							'reSize'	: '<?=$reSize;?>',
							'allow_these':'<?=json_encode($allow_these);?>' },
				onComplete		: function(id, fileName, responseJSON)
									{
										$('#file_'+id).fadeOut(900,function(){$(this).empty().remove()});
										RB._listMidia(<?=$the_input['id']?>,'<?=$the_module?>');
									}
			});
		});
	// ]]>
	</script>
	<div class="clear inline" id="vfu-box">
		<div class="vfu-left">
			<div id="file-upload"></div>
		</div>
		<div  class="vfu-right">
			<ul id="fileQueue"><li class="first">&nbsp;</li></ul>
		</div>
		<hr class="space" />
	</div>	
<?php
	}
	else
	{
?>
	<hr class="space" />
	<div class="info">Esta ferramenta de upload de arquivos só está disponível na edição. Salve os dados para poder usá-la.</div>
<?php
	}
?>
	<hr class="space" />