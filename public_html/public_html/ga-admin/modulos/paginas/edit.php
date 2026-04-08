<?php
/**
 *	Basic::Paginas::edit
 *
 * Exibe o formulário de cadastro e edição de páginas
 *
 * @author	   Rafael Benites <rbenites@gestaoativa.com.br>
 * @version    1.000, Created: 13/09/2010, LastModified: 13/09/2010
 * @package    Basic
 * @subpackage Paginas
 */
	
	/**
	*	Atualizará dados das páginas
	*/
	include("edit_controller.php");
	
	$txt = $the_module_labels["edt_txt"];
	if( $the_action == "Add" )
		$txt = $the_module_labels["new_txt"];

?>
<!--script de validação -->
<script type="text/javascript">
// <![CDATA[
	var _valid;
	jQuery(document).ready(function($){
		_valid = $('#paginasform').validate({
			rules:{
				'input[titulo]':{required:true},
				'input[texto]':{gaeditor:true}
			}
		});
	});
// ]]>
</script>
<!--/* paginas/edit.php */-->
<form action="" method="post" id="paginasform">
	<div class="content-box clear">
		<div class="content-box-header">
			<h3><?php echo ($txt);?></h3>
		</div>
		<div class="append-half prepend-half">
			<?php
			/**
			 * Inclusoa das opções
			 */
				include (includeFile('opcoes'));
			?>
			<div class="clear">
				<label for="input_titulo">T&iacute;tulo:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" name="input[titulo]" id="input_titulo" value="<?php echo _allowQuotes($the_input['titulo']); ?>" />
			</div>
		
	<?php
		if($the_input['temresumo'])
		{
	?>
			<div class="clear">
				<label for="input_resumo">Resumo:</label>
			</div>
			<div class="clear">
				<textarea name="input[resumo]" id="input_resumo" rows="5" cols="20" class="gaNoEditor"><?php echo _allowQuotes($the_input['resumo']); ?></textarea>
			</div>
	<?php
		}
		if($the_input['temtexto'])
		{
	?>
			<div class="clear">
				<label for="input_texto">Texto:</label>
			</div>
			<div class="clear">
				<textarea name="input[texto]" id="input_texto" rows="5" cols="20"><?php echo _allowQuotes($the_input['texto']); ?></textarea>
			</div>
	<?php
		}
		if($the_action == 'Add')
		{
?>
			<div class="clear">
				<label for="input_temresumo">Tem Resumo?</label>
				<?php cria_checkbox('temresumo', '1', '0', $the_input['temresumo']==1); ?>
			</div>
            <div class="clear">
				<label for="input_temtexto">Tem Texto?</label>
				<?php cria_checkbox('temtexto', '1', '0', $the_input['temtexto']==1); ?>
			</div>				
			<div class="clear">
				<label for="input_temimagem">Tem Imagem?</label>
				<?php cria_checkbox('temimagem','1', '0', $the_input['temimagem']==1); ?>
			</div>				
			<div class="clear">
				<label for="input_temmeta">Tem Metas?</label>	
				<?php cria_checkbox('temmeta','1', '0', $the_input['temmeta']==1); ?>
			</div>				
			<div class="clear">
				<label for="input_visivel">Vis&iacute;vel?</label>
				<?php cria_checkbox('visivel', '1', '0', $the_input['visivel']==1); ?>
			</div>
<?php
		} ?>
		<hr class="space"/>
		</div>
	</div>
<!-- edição -->
<?php 
	if($the_input['temimagem'])
	{
		include("midia/midia_view.php"); 
	}
	if($the_input['temmeta'])
	{
?>
	<div class="content-box clear">
		<div class="content-box-header clear"><h3>Otimiza&ccedil;&atilde;o/SEO</h3></div>
		<div class="prepend-half append-half" style="display:none">
			<div class="clear">
				<label for="input_description">Descri&ccedil;&atilde;o:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" name="input[description]" id="input_description" value="<?php echo $the_input['description']; ?>" />
			</div>
			<div class="clear">
				<label for="input_keywords">Palavras-chave:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" name="input[keywords]" id="input_keywords" value="<?php echo $the_input['keywords']; ?>" />
			</div>
			<hr class="space"/>
		</div>
	</div>
<?php
	}
?>	
		<div class="clear aRight">
			<input type="hidden" name="input[id]" value="<?php echo $the_input['id']; ?>" />
			<input type="hidden" name="acao" value="<?php echo $the_action; ?>" />
			<input type="submit" class="button" value="Salvar" />
		</div>
	</form>
	<hr class="space"/>

<!--/* #paginas/edit.php */-->
