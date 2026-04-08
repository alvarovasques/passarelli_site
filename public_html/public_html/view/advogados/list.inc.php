<h1><?php echo $pagina->titulo; ?></h1>	
<?php echo $pagina->texto; ?>    
<div class="span-15">
	<h2 class="sub-titulo">Sócios</h2>
<?php foreach ($socios as $item) { ?>
	<h3 class="margin-bottom0" style="font-size: 18px; padding-bottom: 9px;">
	<a href="./item.php?id=<?php echo $item->id; ?>" class="fancybox"><?php
		echo $item->nome;
		?></a>
	</h3>
<?php } ?>
</div>
<div class="span-8 last associados">
	<h2 class="sub-titulo">Advogados Associados</h2>
<?php foreach ($associados as $item) { ?>
	<p>
		<a href="./item.php?id=<?php echo $item->id; ?>" class="fancybox"><?php
			echo '• ' . $item->nome;
		?></a>
	</p>
<?php } ?>
</div>
<div class="clear"></div>
