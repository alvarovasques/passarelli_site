<?php
/**
 *	Midia::valumns-file-uploader::response
 *
 * Exibe a resposta para uma requisição da interface de upload
 *
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version		1.001, Created: 08/10/2010, Last Modified: 28/11/2010
 * @package     UploadInterface
 * @subpackage	valums-file-uploader
 */
 
// caso tenhamos inserido uma imagem por xhr temos de excluir o arquivo temporario;
	if( !empty($tmp_name) )
		@unlink($tmp_name);
// erro?
	if( count($the_midia_msg['error']) )
	{
		$msg = implode(',',$the_midia_msg['error']);
		die(
			json_encode( 
				array(	
					'error' => (html_entity_decode($msg))
				)
			)
		);
	}
// tudo certo?
	echo '{"success":"Arquivo carregado"}';
?>
