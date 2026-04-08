<?php
/**
 * Midia::midia_view
 *
 * Cria interface para inserção de mídias e exibe as midias já presentes
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.0, Created: 30/09/2010, LastModified: 08/11/2010
 * @package 	Midia
 * @filesource
 */
?>

<!--/* <?php echo $the_module?>/midia_view.php */-->
<div class="content-box clear">
	<div class="content-box-header">
		<h3>Mídias</h3>
	</div>
	<div class="append-half prepend-half">
		<div id="midia_show_wrapper" style="position:relative;"><?php
			/**
			 * Exibe a listagem de mídias para o lemento que incluir este arquivo
			 */
			include('midia/midia_list.php');
		?>
		</div>
<?php 
	if( is_numeric($the_input['id']) )
	{
?>
<div class="aRight clear" id="midia-controls">
	<a href="javascript:;" title="Listar Todos" onclick="RB._listMidia(<?=$the_input['id']?>,'<?=$the_module?>')">listar</a> |
	<a href="javascript:;" title="Editar Todos" onclick="RB._editMidia(<?=$the_input['id']?>,'<?=$the_module?>')">editar todos</a> |
	<a href="javascript:;" title="Apagar Todos" onclick="RB._removeMidia(<?=$the_input['id']?>,'<?=$the_module?>')">apagar todos</a>
</div>
<?php
	}
?>

<?php
	if( isset($midia_msg) && $midia_msg != "" )
	{
		echo sprintf('<div class="midia-msg appennd-bottom-half">%s</div>', $midia_msg);
	}
?> 

<?php

	if( isset($uploadInterface) )
	{
		/**
		 * Se existe uma interface de upload, usamos sua interface de addição de mídias
		 */
		include( $uploadInterface.'/add.php');
	}
	else
	{
		/**
		 * Interface de exibição padrão
		 */
		include('add.php' );
	}
?>
	</div>
</div>
<!--/* #<?php echo $the_module?>/midia_view.php */-->
