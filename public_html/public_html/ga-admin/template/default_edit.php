<?php
/**
 *	Template::default_edit
 *
 * Exibe Formulário padrão para cadastrar ou editar um registro qualquer.
 * Traz a conversão automática de:
 *<ul>
 *	<li>
 *		Campos de (long|tiny|)tex terão o textarea e consequentemente 
 *		o editor WYSIWYG habilitado se existirem, além da validação 
 *		do tipo "editor"</li>
 *	<li>
 *		Campos date terão a interface do dhtml_calendar disponíveis 
 *		necessário estar acessível) e validação do tipo "required" e "data"</li>
 *	<li>
 *		Campos do tipo int(1) serão tratados como "ativo" e teremos um 
 *		"select" de sim ou não implementados (sem validação)
 *	</li>
 *	<li>
 *		Os demais campos serão um input[type=text] com validação "required"
 *	</li>
 *</ul>
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.003, Created: 30/09/2010, LastModified: 23/10/2011
 * @package     Template
 */

 /**
  * Controla as informações recebidas por FORM($_POST) e/ou URL ($_GET)
  */
	include (includeFile("edit_controller")); 
	
 // define texto de exibição de acordo com a ação
	$txt = $the_module_labels["edt_txt"];
	if ($the_action == "Add")
		$txt = $the_module_labels["new_txt"];

 // caso o edit controller exista
	if (!isset($default_types))
	{
		$default_types  = get_columns( $the_table );
		// id e created_at não serão exibidos
		unset($default_types['id']);
		unset($default_types['created_at']);
	}
?>
<!--script para validação -->
<script type="text/javascript">
// <![CDATA[
	var _valid;
	jQuery(document).ready(function($){
		_valid = $('#templateform').validate();
	});
// ]]>
</script>

<!--/* <?php echo $the_module?>/default_edit.php[<?php echo $the_action;?>] */-->
<div class="span-19 append-bottom last">
	<h2><?php echo $txt;?></h2>
	<hr />
	<form action="" method="post" id="templateform">
<?php	
	foreach( $default_types as $i => $v )
	{
?>
		<div class="clear span-4 form-label">
			<label for="input_<?php echo $i; ?>">
				<?php echo ucwords (str_replace('_', ' ', $i)); ?>
			</label>
		</div>
		<div class="span-15 last">
<?php
		// caso tenhamos um campo de texto
		if (strpos( $v, 'text' ) !== FALSE)
		{
		?>
			<textarea cols="30" class="editor required" rows="5" name="input[<?php echo $i; ?>]" id="input_<?php echo $i; ?>"><?php echo _allowQuotes($the_input[$i]); ?>&nbsp;</textarea>
<?php
		}
		else if ($v == 'date')
		{
		?>
			<input type="text" class="text calendar required data" name="input[<?php echo $i; ?>]" id="input_<?php echo $i; ?>" value="<?php echo inverteData($the_input[$i], 'br'); ?>" />
			<a class="calendar" title="Alterar Data" href="javascript:;" onclick="displayCalendar(document.getElementById('input_<?php echo $i; ?>'),'dd/mm/yyyy',this)">
				<img  src="./includes/images/icons/calendar.png" alt="calendar"   /></a>
<?php
		}
		else if ($v == 'int(1)')
		{
			// função de criação deselect com opções definidas como "sim" e "não"
			cria_select ($i, array( 1, 0 ), array( 'sim', 'não' ), $the_input[$i]);
		}
		else
		{
		?>
			<input type="text" class="text required" name="input[<?php echo $i; ?>]" id="input_<?php echo $i; ?>" value="<?php echo _allowQuotes($the_input[$i]); ?>" />
<?php
		}
		?>
		</div>
<?php
	}
	if (isset($use_midia) && $use_midia)
	{
		/**
		 * Inclusão do script com a visualização de todas as mídias, bem como as operações de remoção, edição, adição
		 */
		include( "midia/midia_view.php" );
	}
	?>
		<div class="span-19 center prepend-top">
			<input type="hidden" id="input_id" name="input[id]" value="<?php echo $the_input['id']; ?>" />
			<input type="hidden" name="acao" value="<?php echo $the_action; ?>" />
			<input type="submit" class="btnSave" value="Salvar" />
		</div>
	</form>
</div>
<br class="clear" />
<?php

/* End of File: default_edit.php */
/* Path: ga-admin/templates/default_edit.php */