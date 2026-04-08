<?php
/**
 *	noticias::edit.php
 *
 * Arquivo que exibe o formulário de cadastro e edição de registros dentro do módulo
 *
 *<b>Observações</b>
 *<ol>
 *	<li>Todos os campos terão os atributos <b>id</b> como "input_<campo>" e <b>name</b> como "input[<campo>]";</li>
 *	<li><b>$required</b> guarda a lista de campos a serem validados, entre ' e separados por vírgula. ex: <code> <?php $required = "'titulo', 'data'"; ?></code>;<li>
 *</ol>
 *
 * @version   2.000, Created: 19/06/2013
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @package   Generator 2.01
 */

 /**
  * Controle das informações de cadastro e edição de {$label}
  */
	include (includeFile("edit_controller"));
 // define texto de exibição de acordo com a ação
	$txt = $the_module_labels["edt_txt"];
	if ($the_action == "Add")
		$txt = $the_module_labels["new_txt"];
?>
<!--/* script de validação */-->
<script type="text/javascript">
// <![CDATA[
	var _valid;
	jQuery(document).ready(function($){
		_valid = $('#noticias_form').validate({
			rules:{
				'input[titulo]':{required:true},
				'input[resumo]':{required:true},
				'input[texto]':{required:true,gaeditor:true},
				'input[data]':{required:true,data:true},
				'input[autor]':{required:true}
			}
		});
	});
// ]]>
</script>
<!--/* noticias/edit.php */-->
<form action="" method="post" id="noticias_form">
	<div class="content-box clear">
		<div class="content-box-header">
			<h3><?php echo ($txt);?></h3>
		</div>
		<div class="append-half prepend-half">
<?php
	/**
	  * inclusão das opções
	  */
	include (includeFile("opcoes")); ?>

				<div class="clear">
					<label for="input_titulo">Título</label>
				</div>
				<div class="clear">
					<input type="text" class="text-input large-input" name="input[titulo]" id="input_titulo" value="<?php echo _allowQuotes($the_input["titulo"]); ?>" />
				</div>

				<div class="clear">
					<label for="input_resumo">Resumo</label>
				</div>
				<div class="clear">
					<textarea cols="100" rows="10" name="input[resumo]" id="input_resumo" class="gaNoEditor"><?php echo _allowQuotes($the_input["resumo"]); ?></textarea>
				</div>

				<div class="clear">
					<label for="input_texto">Texto</label>
				</div>
				<div class="clear">
					<textarea cols="100" rows="10" name="input[texto]" id="input_texto"><?php echo _allowQuotes($the_input["texto"]); ?></textarea>
				</div>

				<div class="clear">
					<label for="input_data">Data</label>
				</div>
				<div class="clear">
					<?php
						if (empty($the_input["data"]))
							$the_input["data"] = $the_day;
					?>
					<input type="text" class="text calendar" name="input[data]" id="input_data" value="<?php echo inverteData($the_input["data"],"br" ); ?>" />
					&nbsp;
					<a href="javascript:void(0)" class="iconset calendar" title="Alterar Data" onclick="displayCalendar($('#input_data')[0],'dd/mm/yyyy',this)">
						<img src="./includes/images/icons/calendar.png" alt="Calendar" class="calendar" /></a>
				</div>

				<div class="clear">
					<label for="input_autor">Autor</label>
				</div>
				<div class="clear">
					<input type="text" class="text-input large-input" name="input[autor]" id="input_autor" value="<?php echo _allowQuotes($the_input["autor"]); ?>" />
				</div>
			<?php
				if (is_numeric($the_input['id']))
				{
				?>
				<hr class="space" />
				<div class="clear" style="line-height:16px">
					<a href="<?php echo sprintf('?modulo=%s&amp;acao=Remove&amp;id=%s', $the_module, $the_input['id']); ?>#top-list" onclick="return RB.doRemove()">
						<img style="vertical-align:middle" src="includes/images/icons/rem.png" alt="Remover" title="Remover este registro" /> Remover este registro</a>
				</div>
			<?php
				}
				?>					
						<hr class="space" />
					</div>
				</div>
				<?php
					/**
					 * Inclue o arquivo que exibirá todas as mídias do módulo, bem como opçoes de adição, edição.
					 */
					 include_once "midia/midia_view.php";
				?>

	<div class="aRight clear">
		<input type="hidden" name="input[id]" value="<?php echo $the_input["id"]; ?>" />
		<input type="hidden" name="acao" value="<?php echo $the_action; ?>" />
		<input type="submit" class="button" value="Salvar" />
	</div>
</form>
<?php 
/* End of File: edit.php */
/* Path:  ga-admin/modulos/noticias/edit.php */