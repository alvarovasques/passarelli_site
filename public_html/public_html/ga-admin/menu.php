<?php
/**
 * Core::menu
 *
 * Arquivo que constrói o menu lateral esquerdo no Painel Administrativo
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @author      Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     1.002, Created: 30/09/2010, LastModified: 05/10/2010
 * @package     Core
 */


/**
 * Arquivo que possui a definição do menu
 */
	include_once("inc.menu.php");
?>
<!--/* menu.php */-->
	<ul class="first-level">
<?php
	//percorre a lista
	$hid = 0;
	foreach ($the_menu as $mn => $texto)
	{ 
		if (is_array($texto))
		{
		?>
		<li>
			<a href="javascript:;" onclick="jQuery('#menu_<?php echo $hid; ?>').toggle(); RB.menuDisplay(<?php echo $hid; ?>);" title="Abrir opções" class="nav-top-item">
			[<span id="info_<?php echo $hid;?>">+</span>] <?php echo ($mn); ?></a>
			<ul id="menu_<?php echo $hid++; ?>" class="second-level hide">
<?php 		foreach($texto as $i => $t)
			{
			?>
				<li>
					<a href="./?modulo=<?php echo $i; ?>" title="<?php echo ($t)?>" onclick="RB.menuWrite()" class="<?php echo ($the_module==$i)?'current':''; ?>">
					<?php echo ($t); ?></a>
				</li>
<?php 		} ?>
			</ul>
		</li>
<?php	} else { ?>
			<li>
				<a href="./?modulo=<?php echo $mn; ?>" title="<?php echo ($texto); ?>" onclick="return RB.menuWrite()"  class="nav-top-item <?php echo ($the_module==$mn)?'current':''; ?>">
					<?php echo ($texto); ?></a>
			</li>
<?php	}
	} ?>
	<li class="lastli">
		<a href="./logoff.php" title="Sair" onclick="return confirm('Deseja realmente sair do sistema?');" class="nav-top-item">
			Sair do Sistema</a>
	</li>
</ul>
<script type="text/javascript">
// <![CDATA[
(function(){
	for( var i=0; i<<?php echo $hid;?>; ++i){ RB.menuSet(i, 0); }
	$('.first-level ul li a.current').parent().parent().parent().find('a:first').addClass('current');
})();
// ]]>
</script>
<?php 

/* End of File: ga-admin/menu.php */
/* Path:  ga-admin/menu.php */