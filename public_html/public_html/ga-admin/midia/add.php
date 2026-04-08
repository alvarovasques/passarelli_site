<?php
/**
 * Midia::add
 *
 * Exibe uma interface padrão de adição de midia[ um simples box com 2 campos text e um file]
 *
 *<code>
 *<?php
 * // É possível alterar os labels do template de inserção de mídia padrão
 * // através de um array associativo da seguinte forma ( no edit ou edit_controller do módulo)
 *	$midiaLabel['legend']    = 'Valor do legend do fieldset que envolve o emplate';
 *	$midiaLabel['titulo']    = 'Valor do label do Título';
 *	$midiaLabel['descricao'] = 'Valor do label de descrição';
 *	$midiaLabel['arquivo']   = 'O label do input file';
 *?>
 *</code>
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.001, Created: 30/09/2010, LastModified: 28/11/2010
 * @package 	Midia
 */
 
 // label's
	if (!isset($midiaLabel)) {
		$midiaLabel = array(
            'legend' 	=> 'Adicionar Mídia',
            'titulo'	=> 'Título',
            'descricao'	=> 'Descrição',
            'arquivo'	=> 'Arquivo'
        );
	}
?>

<!--/* midia/add.php { */-->
<div class="span-17 last">
	<h4><?php echo $midiaLabel['legend']; ?></h4>
	<div class="span-3 clear form-label">
		<label for="midia_titulo_0">
			<?php echo $midiaLabel['titulo']; ?>
		</label>
	</div>
	<div class="span-14 last">
		<input type="text" class="text" name="midia[titulo][0]" id="midia_titulo_0" />
	</div>
	<div class="span-3 clear form-label">
		<label for="midia_descricao_0">
			<?php echo $midiaLabel['descricao']; ?>
		</label>
	</div>
	<div class="span-14 last">
		<input type="text" class="text" name="midia[descricao][0]" id="midia_descricao_0" />
	</div>
	<div class="span-3 clear form-label">
		<label for="midias_0">
			<?php echo $midiaLabel['arquivo']; ?>
		</label>
	</div>
	<div class="span-14 last">
		<input type="file" class="text" name="midias[0]" id="midias_0" />
	</div>
</div>
<hr class="space" />
<script type="text/javascript">
// <![CDATA[
/* seta o form para poder usar midia */
	jQuery(function($){
		$('form').attr({enctype: 'multipart/form-data', encoding: 'multipart/form-data'});
	});
//]]>
</script>
<!--/*# }midia/add.php */-->
