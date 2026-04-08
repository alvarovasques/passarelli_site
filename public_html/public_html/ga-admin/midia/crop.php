<?php
/**
 * Midia::crop
 *
 * Exibe a interface para o processamento do crop
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     1.002, Created: 30/09/2010, LastModified: 29/11/2010
 * @package 	Midia
 */

 /**
  * Funções das mídias
  */
	require_once( 'midia.php' );
 /**
  * Arquivo que faz controle das informações de crop
  */
	require_once( 'crop_controller.php' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<title>.: Painel de Administra&ccedil;&atilde;o :.</title>
		<link rel="stylesheet" href="<?=BASE_URL?>/ga-admin/includes/estilo/jquery.Jcrop.css" type="text/css" />
		<style type="text/css">
			html,body{width:990px;height:97%;min-height:97%;background:#eee}
			.original{text-align:center;}
			.imgThumb{float:left;margin:10px;}
			.imgThumb a{text-decoration:none; color:#000}
			.imgThumb a:hover{text-decoration:underline}
		</style>
		<script type="text/javascript" src="<?=BASE_URL?>/ga-admin/includes/js/jquery.js" charset="utf-8"></script>
		<script type="text/javascript" src="<?=BASE_URL?>/ga-admin/includes/js/jquery.Jcrop.min.js" charset="utf-8"></script>
		<script type="text/javascript">
			<?php
			if (isset($_POST['the_input'])){ ?>
			try{ /// firebug issues
				parent.$.fancybox.close();
				alert('imagem alterada com sucesso');				
			}catch(err){}
			<?}?>

			jQuery(function($){
					$('#cropbox').Jcrop({
					aspectRatio: <?=$aspectRatio?>,
					setSelect: [0,0,<?=$info[$the_input['tb']][0]?>,<?=$info[$the_input['tb']][1]?>],
					onSelect: updateCoords
				});				
			});
			
			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};
		</script>
	</head>
	<body>
<?php
	if (!isset($the_input['tb']))
	{
	?>
		<div class="original">
				<h1><?= $midia['titulo']; ?></h1>		
			<?php					
				foreach ($thumbs as $thumb)
				{
					if (file_exists(getMidiaLink($midia['id'],$thumb,'path')))
					{
					?>
						<div class="imgThumb" style="width:<?= $info[$thumb][0]?>">
							<a href="?id=<?= ($midia['id']);?>&tb=<?= ($thumb); ?>" title="Editar <?= $thumb; ?>">
								<img class="ga-midia-image" src="<?= getMidiaLink($midia,$thumb); ?>?_=<?= rand(); ?>" alt="Selecionar Imagem" title="<?= $midia['titulo']; ?>" /></a>
							<br />
							<a href="?id=<?=($midia['id'])?>&tb=<?=($thumb)?>" title="Editar <?= $thumb; ?>">
								<?= $info[$thumb][0]; ?> x <?= $info[$thumb][1]; ?></a>								
						</div>
			<?php 	}
			   } ?>					
		</div>
<?php
	}
	else
	{
	?>
		<form action="" method="post" enctype="multipart/form-data" onsubmit="return checkCoords();">
			<div class="original">
				<h1>Alterar as dimensões da imagem</h1>		
				<!-- This is the form that our event handler fills -->
				Selecione a área desejada para aparecer no site					
				<div style="width:<?=$info[0][0]?>px;margin:0 auto;">
					<img  id="cropbox" class="ga-midia-image" src="<?= getMidiaLink($midia)?>" alt="Alterar dimensões" title="<?=$midia['titulo']?>" />
				</div>
				<span>&nbsp;</span></br>
				<input type="hidden" id="id" name="the_input[id]" value="<?=$midia['id']?>"/>
				<input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" />
				<br/>
				<input type="submit" name="btn" value="Salvar" />				
			</div>
		</form>
<?php
	}
	?>
	</body>
</html>