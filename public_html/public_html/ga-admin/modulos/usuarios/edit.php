<?php
/**
 *	Basic::Usuarios::edit
 *
 * Exibe o formulário para cadastro e edição de um novo usuário
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.002, Created: 13/09/2010, LastModified: 27/11/2010
 * @package     Basic
 * @subpackage  Usuarios
 */
 
	/**
	*	Atualizará dados de novos usuários e já existentes
	*/
	include("edit_controller.php");
	
	$txt = $the_module_labels["edt_txt"];
	if( $the_action == "Add" )
		$txt = $the_module_labels["new_txt"];

?>
<!-- validacao do modulo -->
<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function($){
		$('#usuariosform').validate({
			rules:{
				'input[login]':{required:true,login:true},
				'input[email]':{required:true,email:true},
				'input[senha]':{required:true},
				'input[resenha]':{required:true,equalTo:'#input_senha'}
			}
		});
	});
// ]]>
</script>
<!--/* usuarios/edit.php */-->
<form action="" method="post" id="usuariosform">
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
				<label for="input_login">Login:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" name="input[login]" id="input_login" value="<?php echo $the_input['login']; ?>" />
			</div>
<?php
	if($the_action == 'Add')
	{
?>
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
<?php
	}
?>
			<div class="clear">
				<label for="input_email">Email:</label>
			</div>
			<div class="clear">
				<input type="text" class="text-input large-input" name="input[email]" id="input_email" value="<?php echo $the_input['email']; ?>" />
			</div>
			
			<div class="clear">
				<label for="input_tipo">Tipo:</label>
			</div>
			<div class="clear">
			<?php
				//somente se o usuário for admin ele poderá modificar o nível de usuário
				if( $the_user['tipo'] == 1 )
				{
					cria_select('tipo', array('0','1'), array('Usuário', 'Admin'), $the_input['tipo']);
				}
				else
				{
					cria_select('tipo', array('0'), array('Usuário'), $the_input['tipo']);
				}
			?>
			</div>
		
<?php
	// se for um usuário do tipo admin pode cancelar o acesso de qualquer usuário
	if ($the_user['tipo'] == 1)
	{
	?>
			<div class="clear">
				<label for="input_email">Ativo</label>
			</div>
			<div class="clear">
				<?php cria_select('ativo', array('0','1'), array('Não', 'Sim'), $the_input['ativo']); ?>
			</div>
<?php
	}
	?>
			<hr class="space"/>
		</div>
	</div>
	<div class="clear aRight">
		<input type="hidden" id="input_id" name="input[id]" value="<?php echo $the_input['id']; ?>" />
		<input type="hidden" name="acao" value="<?php echo $the_action; ?>" />
		<input type="submit" class="button" value="Salvar" />
	</div>
</form>
<br class="clear" />
<!--/* #usuarios/edit.php */-->
