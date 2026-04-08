<?php
/**
 * Basic::Usuarios::alter
 *
 * Exibe formulário para troca de senha de um usuáio
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.002, Created: 13/09/2010, LastModified: 27/11/2010
 * @package     Basic
 * @subpackage  Usuarios
 */

	/**
	*	Salvará os dados de nova senha, e verifica a existência do usuário
	*/
	include( includeFile("edit_controller") );

	if (isset($the_input['id']) && is_numeric($the_input['id']))
	{
?>
<!-- validacao do modulo -->
<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function($){
		$('#alterform').validate({
			rules:{
				'input[login]':{required:true,login:true},
				'input[senha]':{required:true},
				'input[resenha]':{required:true,equalTo:'#input_senha'}
			}
		});
	});
// ]]>
</script>
<!--/* usuarios/alter.php */-->
<form action="" method="post" id="alterform">
	<div class="content-box clear">
		<div class="content-box-header">
			<h3><?php echo ($the_module_labels["alt_txt"]);?></h3>
		</div>
		<div class="append-half prepend-half">
			<?php
				/**
				 * Inclusão das opções
				 */
				include includeFile('opcoes');  ?>
		
			<div class="clear">
				<label for="input_login">Login:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" readonly="readonly" name="input[login]" id="input_login" value="<?php echo $the_input['login']; ?>" />
			</div>
			<div class="clear">
				<label for="input_senha">Senha:</label>
			</div>
			<div class="clear">
				<input type="password" class="text-input large-input" name="input[senha]" id="input_senha" value="<?php echo $the_input['senha']; ?>" />
			</div>
			
			<div class="clear">
				<label for="input_resenha">Re-senha:</label>
			</div>
			<div class="clear">
				<input type="password" class="text-input large-input" name="input[resenha]" id="input_resenha" value="" />
			</div>
			<hr class="space"/>
		</div>		
	</div>
	<div class="clear aRight">
		<input type="hidden" id="input_id" name="input[id]" value="<?php echo $the_input['id']; ?>" />
		<input type="hidden" name="acao" value="<?php echo $the_action; ?>" />
		<input type="submit" class="button" value="Salvar" onclick="return RB.validateForm('input_', ['senha', 'login', 'resenha'], true )" />
	</div>
</form>
<br class="clear" />
<!--/* #usuarios/alter.php */-->

<?php
	}
	else
	{
		$the_action = "Add";
		/**
		 * Em caso de erro exibimos o form para adição de usuário
		 */
		include('edit.php'); 
	}
