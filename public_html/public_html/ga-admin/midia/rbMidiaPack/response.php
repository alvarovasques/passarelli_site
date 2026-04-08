<?php
/**
 * Midia::rbMidiaPack::response
 *
 * Exibe a resposta para uma requisição da interface de upload
 *
 * @author      Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.001, Created: 30/07/2010, LastModified: 29/11/2010
 * @package     UploadInterface
 * @subpackage	rbMidiaPack
 */

 // resposta via iframe problemas de codificação ! :S
	header( 'Content-type: text/html; charset=UTF-8' );
	
 // se existirem erros ou mensagens de erro ou alerta
	if(count($the_midia_msg['error']) )
		_alert($the_midia_msg['error']);
	if(count($the_midia_msg['notice']) )
		_alert($the_midia_msg['notice']);
 // remove o box usado para inserir a mídia e atualiza o conteúdo do view
print '<script type="text/javascript">
			(function(RB, $){
				RB.removeMidia('.$_POST['myid'].');
				RB._listMidia('.$_POST['id'].',"'.$_POST['modulo'].'");
			})(window.parent.RB, window.parent.jQuery);
		</script>';
?>
