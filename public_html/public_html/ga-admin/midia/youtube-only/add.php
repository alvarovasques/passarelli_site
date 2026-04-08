<?php
/**
 * Youtube-only::add
 *
 * Exibe uma interface padrão de embed's youtube
 *
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     $Id: 2012/03/21 rbenites $
 * @package 	Midia
 */
 
?>

<!--/* youtube-only/add.php */-->
<div class="clear last hide" id="youtube-only-wrapper">
	<h2>Adicionar vídeos do Youtube</h2>
	<div class="clear">
		<label for="midias_0">
			Embed/Link Youtube
			<a href="javascript:void(0)" title="Ajuda" class="youtube-only-show-help"><img src="./midia/youtube-only/help.png" alt="Ajuda"/></a>
		</label>
	</div>
	<div class="clear">
		<input type="hidden" name="midia[titulo][0]" id="midia_titulo_0" value="Vídeo Youtube"/>
		<input type="hidden" name="midia[descricao][0]" id="midia_descricao_0" value="" />
		<textarea name="midias[0]" id="midias_0" rows="5" cols="10" class="gaNoEditor"></textarea>
	</div>
	<div id="youtube-only-overlay" class="youtube-only-help hide">&nbsp;</div>
	<div id="youtube-only-help-box" class="hide youtube-only-help">
		<div class="info">
			<h6 class="bottom">Escolha UMA das formas de adição de vídeo</h6>
			<ul>
				<li>Copie a url do vídeo, que deverá estar no formato: http://www.youtube.com/watch?v=...;</li>
				<li>Na exibição do video, clique com o botão direito do mouse em cima do mesmo e utilize a opção 'copiar código de incorporação' (ou 'Copy embed html');</li>
				<li>Na página do vídeo, clique em 'compartilhar' e depois em 'incorporar', copie o código que inicia-se em&lt;iframe ...&gt;</li>
				<li class="close">[<a href="javascript:void(0)" title="Ajuda" class="youtube-only-show-help">Fechar</a>]</li>
			</ul>
		</div>
	</div>
</div>
<hr class="space" />
<script type="text/javascript">
	jQuery(function($){
		RB._loadCss("./midia/youtube-only/youtube-only.css");
		$('.youtube-only-show-help').click(function(){
			$('.youtube-only-help').toggleClass('hide');
			return false;
		});
		$('#youtube-only-overlay').css({opacity:.5});
	});
</script>