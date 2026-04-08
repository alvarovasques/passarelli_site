<?php
/**
 *	areas-atuacao::edit.php
 *
 * Arquivo que exibe o formulário de cadastro e edição de registros dentro do módulo
 *
 *<b>Observações</b>
 *<ol>
 *	<li>Todos os campos terão os atributos <b>id</b> como "input_<campo>" e <b>name</b> como "input[<campo>]";</li>
 *	<li><b>$required</b> guarda a lista de campos a serem validados, entre ' e separados por vírgula. ex: <code> <?php $required = "'titulo', 'data'"; ?></code>;<li>
 *</ol>
 *
 * @version   2.000, Created: 25/06/2013
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
		_valid = $('#areas-atuacao_form').validate({
			rules:{
				'input[titulo]':{required:true},
				'input[resumo]':{required:true},
				'input[texto]':{required:true,gaeditor:true},
				'input[ativo]':{required:true},
				'input[ordem]':{required:true}
			}
		});
	});
// ]]>
</script>
<!--/* areas-atuacao/edit.php */-->
<form action="" method="post" id="areas-atuacao_form">
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
					<label for="input_ativo">Ativo</label>
				</div>
				<div class="clear">
					<?php  cria_select ("ativo", array(0,1), array("Não","Sim"), $the_input["ativo"]);  ?>
				</div>

				<div class="clear">
					<label for="input_ordem">Ordem</label>
				</div>
				<div class="clear">
					<?php  cria_select_ordem( "ordem", $the_table, $the_input["ordem"] ); ?>
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
				?>			<hr class="space" />
		</div>
	</div>
	<div class="aRight clear">
		<input type="hidden" name="input[id]" value="<?php echo $the_input["id"]; ?>" />
		<input type="hidden" name="acao" value="<?php echo $the_action; ?>" />
		<input type="submit" class="button" value="Salvar" />
	</div>
</form>
<?php 
/* End of File: edit.php */
/* Path:  ga-admin/modulos/areas-atuacao/edit.php */