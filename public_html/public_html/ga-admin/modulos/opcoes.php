<?php
/**
 * Core::opcoes
 *
 * Cria as opções basicas do menu superior
 *
 *<b>Como montar o menu</b>
 *
 *<code>
 *<?php
 *	// O menu e formado por duas variáveis
 *	//uma booelan para informar seu uso, e um array com as configurações
 *	// o array é array ( 0 => link, 1=> alt, 2 => label )
 *	$temNovo = $temList = $temKey = $temDes = $temExp = $temImp =
 *		true;
 *	$opt_novo = $opt_list = $opt_key = $opt_des = $opt_exp = $opt_imp =
 *		array( 'link', 'title', 'text' );
 *	include_once('modulos/opcoes');
 *?>
 *</code>
 * @version	1.000, Created: 30/08/2010
 * @author	Rafael Benites <rbenites@gestaoativa.com.br>
 * @package Core
 */

/* padrões */
	if(!isset($temNovo))
		$temNovo = false;
	if(!isset($temList))
		$temList = false;
	if(!isset($temKey))
		$temKey = false;
	if(!isset($temDes))
		$temDes = false;
	if( !isset($temExp) )
		$temExp = false;
	if( !isset($temImp) )
		$temImp = false;
?>
<!-- modulos/opcoes.php -->
	<ul class="shortcut-buttons-set"> 
<?php
	if($temNovo)
	{
	?>
			<li>
				<a href="<?php echo $opt_novo[0]?>" class="shortcut-button" title="<?php echo ($opt_novo[1])?>">
					<span><img src="./includes/images/icons/novo.png" alt="<?php echo ($opt_novo[1])?>" title="<?php echo ($opt_novo[1])?>" /><br />
					<?php echo ($opt_novo[2])?></span></a>
			</li>
<?php
	}
	if($temList)
	{
?>
		<li>
			<a href="<?php echo $opt_list[0]?>" class="shortcut-button">
				<span><img src="./includes/images/icons/list.png" alt="<?php echo ($opt_list[1])?>" title="<?php echo ($opt_list[1])?>" /><br />
				<?php echo ($opt_list[2])?></span></a>
		</li>
<?php
	} 
	if($temKey)
	{
?>
		<li>
			<a href="<?php echo $opt_key[0]?>" <?php echo $opt_key[3]?> class="shortcut-button">
				<span><img src="./includes/images/icons/chave.png" alt="<?php echo ($opt_key[1])?>" title="<?php echo ($opt_key[1])?>" /><br />
				<?php echo ($opt_key[2])?></span></a>
		</li>
<?php 
	}
	if($temDes)
	{
?>
		<li>
			<a href="<?php echo $opt_des[0]?>" class="shortcut-button">
				<span><img src="./includes/images/icons/destaque.png" alt="<?php echo ($opt_des[1])?>" title="<?php echo ($opt_des[1])?>" /><br />
				<?php echo ($opt_des[2])?></span></a>
		</li>
<?php
	}
	if($temImp)
	{
?>
		<li>
			<a href="<?php echo $opt_imp[0]?>" class="shortcut-button">
				<span><img src="./includes/images/icons/upload.png" alt="<?php echo ($opt_imp[1])?>" title="<?php echo ($opt_imp[1])?>" /><br />
				<?php echo ($opt_imp[2])?></span></a>
		</li>
<?php
	}
	if($temExp)
	{
?>
		<li>
			<a href="<?php echo $opt_exp[0]?>" class="shortcut-button">
				<span><img src="./includes/images/icons/download.png" alt="<?php echo ($opt_exp[1]); ?>" title="<?php echo ($opt_exp[1]); ?>" /><br />
			<?php echo ($opt_exp[2]); ?></span></a>
		</li>
<?php
	} 
	?>
	</ul>
<?php
/* End of File: opcoes.php */
/* Path: ga-amdin/modulos/opcoes.php */