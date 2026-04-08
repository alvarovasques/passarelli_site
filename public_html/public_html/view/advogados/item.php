<?php
	include_once dirname(dirname(dirname(__FILE__))).'/include/config.inc.php';
	
	if(isset($_GET["id"]) && is_numeric($_GET["id"])) {
		$item = sqlFetch("SELECT * FROM rb_advogados WHERE id = {$_GET["id"]}");
		$item->midia = getMidia($item->id, 'advogados', 1); ?>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>/blueprint/screen.css"></link>
		<style type="text/css">
			.box-content{padding: 5px; border: 1px solid #D3C7B3; margin: 5px; width: 800px;}
			h2.nome-advogado{color: #55473A; font-size: 16px; font-family: "Times New Roman";}
			.box-text{margin: 10px; font-family: Tahoma; font-size: 14px;}
			#fancybox-content{height: auto; background: #DECCB1; }
		</style>
		<div class="box-content">
			<h2 class="nome-advogado">CURRICULUM</h2>
			<?php if (!empty($item->midia[0])) { ?>
			<div class="span-5">
				<?php exibeMidia($item->midia[0], 'a'); ?>
			</div>
			<?php } ?>
			<div class="box-text">
				<?php echo $item->curriculum; ?>
			</div>
		</div>
<?php
	} else {
		header("location:index.php");
	}