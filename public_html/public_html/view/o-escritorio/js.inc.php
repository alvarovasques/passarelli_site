<?php
/**
 * Passarelli Advocacia
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @author      Mahmod A. Issa <muh@gestaoativa.com.br>
 * @package     o-escritorio
 */
?>

<script src="<?=JS_URL?>/jquery.infinitecarousel3.min.js"></script>
<script type="text/javascript" src="<?=JS_URL?>/easing.js"></script>
<script type="text/javascript">
		$(function(){
			$('#galeria').infiniteCarousel({
				imagePath: '<?=IMG_URL?>/',
				transitionSpeed:450,
				displayTime: 6000,
				internalThumbnails: false,
				thumbnailType: 'images',
				customClass: 'myCarousel',
				progressRingColorOpacity: '0,0,0,.9',
				progressRingBackgroundOn: false,
				easeLeft: 'easeOutExpo',
				easeRight:'easeOutQuad',
				inView: 1,
				advance: 1,
				autoPilot: true,
				prevNextInternal: false,
				autoHideCaptions: false
			});
			$('.ic_link').attr('rel', 'galeria');
			$('.ic_link').fancybox({
				titlePosition:'inside',
				transitionIn:'elastic',
				transitionOut: 'elastic',
				easingIn: 'easeOutBack',
				easingOut: 'easeInBack',
				padding	  : 0,				
			});
		});
	</script>