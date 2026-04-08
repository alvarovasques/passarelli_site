<?php
/**
 *	configuracoes/edit
 *
 * Exibe o formulário para edição das configurações
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.002, Created: 13/09/2010, LastModified: 27/11/2010
 * @package     Basic
 * @subpackage  Configuracoes
 */


	/**
	*	Controla as informações das configurações
	*/
	include( "edit_controller.php" );	

	$txt = $the_module_labels["edt_txt"];
?>
<script type="text/javascript">
// <![CDATA[
	var _valid;
	jQuery(document).ready(function($){
		_valid = $('#configuracoesform').validate({
			rules:{
				'input[titulo]':{required:true},
				'input[email]':{required:true,multiemail:true},
				'input[telefone]':{required:true},
				'input[endereco]':{required:true}
			}
		});
	});
// ]]>
</script>
<!--/* configuracoes/edit.php */-->
<form action="" method="post" id="configuracoesform">
	<div class="content-box clear">
		<div class="content-box-header"><h3><?php echo $the_module_labels["edt_txt"];?></h3></div>
		<div class="prepend-half append-half clear">
			<div class="clear">
				<label for="input_titulo">T&iacute;tulo do Site:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" name="input[titulo]" id="input_titulo" value="<?php echo _allowQuotes($the_input['titulo']); ?>" />
			</div>

			<div class="clear">
				<label for="input_email">Email de Contato:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" name="input[email]" id="input_email" value="<?php echo _allowQuotes($the_input['email']); ?>" />
			</div>

			<div class="clear">
				<label for="input_telefone">Telefone(s):</label>
			</div>
			<div class="clear">
				<textarea name="input[telefone]" id="input_telefone" rows="5" cols="20" class="gaNoEditor"><?php echo _allowQuotes($the_input['telefone']); ?></textarea>
			</div>

			<div class="clear">
				<label for="input_endereco">Endereço:</label>
			</div>
			<div class="clear">
				<textarea name="input[endereco]" id="input_endereco" rows="5" cols="20" class="gaNoEditor"><?php echo _allowQuotes($the_input['endereco']); ?></textarea>
			</div>
		<?php
		// somente o usuário ga-admin terá acesso à publicação
			if ($the_user['id'] == 1)
			{
			?>
			<div class="clear">
				<label for="input_publicar">Publicar?</label>
			</div>
			<div class="clear">
				<?php cria_checkbox("publicar", 1, 0, $the_input['publicar']); ?>
			</div>
		<?php
			}
			?>
			<hr class="space"/>
		</div>
	</div>

	<div class="content-box clear">
		<div class="content-box-header clear"><h3>Otimiza&ccedil;&atilde;o/SEO</h3></div>
		<div class="prepend-half append-half" style="display:none">
			<div class="clear">
				<label for="input_description">Descri&ccedil;&atilde;o do site:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" name="input[description]" id="input_description" value="<?php echo _allowQuotes($the_input['description']); ?>" />
			</div>
				
			<div class="clear">
				<label for="input_keywords">Palavras-chave do site:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" name="input[keywords]" id="input_keywords" value="<?php echo _allowQuotes($the_input['keywords']); ?>" />
			</div>
				
			<div class="clear">
				<label for="input_analytics">Analytics:</label>
			</div>
			<div class="clear">
				<textarea class="gaNoEditor large-input" name="input[analytics]" id="input_analytics" rows="5" cols="20"><?php echo _allowQuotes($the_input['analytics']); ?></textarea>
			</div>
			<hr class="space"/>
		</div>
	</div>
	<div class="prepend-top aRight clear">
		<input type="hidden" id="input_id" name="input[id]" value="<?php echo $the_input['id']; ?>" />
		<input type="hidden" name="acao" value="<?php echo $the_action; ?>" />
		<input type="submit" class="button" value="Salvar" />
	</div>

</form>
<?php

/* End of File: edit.php */
/* Path: ga-admin/modulos/configuracoes/edit.php */