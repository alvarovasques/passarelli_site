<?php
/**
 * Passarelli Advocacia 
 *
 * Arquivo com o template de rodapé do site, completa as possíveis
 * tags deixadas em aberto pelo 'template/head.inc.php'
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @author      Mahmod A. Issa <muh@gestaoativa.com.br>
 * @package     View
 * @subpackage  Template
 */
?>
	    	</div><!--#main-->
    	</div><!--fecha bg-menu-home -->
    </div><!--fecha bg-meio -->
    
<!-- JavaScript at the bottom for fast page loading -->
	<script type="text/javascript" src="<?php echo JS_URL;?>/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo JS_URL;?>/fancybox/jquery.easing-1.3.pack.js"></script>
	<script type="text/javascript" src="<?php echo JS_URL;?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript">
	// <![CDATA[
		jQuery(function($){
			$(".external").attr({target:"_blank"});
			$(".gaFancyBox").fancybox({
				titlePosition:'inside',
				transitionIn:'elastic',
				transitionOut: 'elastic',
				easingIn: 'easeOutBack',
				easingOut: 'easeInBack'
			});
		});
	// ]]>
	</script>
    <?php	// existe javascript 
		if (file_exists('js.inc.php')) {
			//Javascript especifico do modulo usando o template
			include 'js.inc.php';
		}
	?>
<!-- Analytics -->
    <?php echo $siteConfig->analytics; ?>

</body>
</html>