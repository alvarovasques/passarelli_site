<?php
/**
 * Midia::valumns-file-uploader::add
 *
 * Faz o pré-processamento dos dados recebidos pela interface de upload
 *
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version		1.0, Created: 08/10/2010, Last Modified: 08/11/2010
 * @package     UploadInterface
 * @subpackage	valums-file-uploader
 */
 
/**
 * Insere se necessário as funcionalidades da mídias
 */
	require_once('midia.php');

	$the_input = array( 'id' => $_POST['id'] );
	$the_module = $_POST['modulo'];
	$the_action = $_POST['acao'];
	
	$widths = json_decode( stripslashes(urldecode($_POST['widths'])) );
	$heights = json_decode( stripslashes(urldecode($_POST['heights'])) );
	$useCrop = $_POST['useCrop'];
	$allow_these = json_decode( stripslashes(urldecode($_POST['allow_these'])) );
	$reSize = $_POST['reSize'];
	
	$_POST['midia']= array(); /* necessário */

	// quando vindo por xhr guardamos em um local temporario
	$tmp_name = '';	
	if( isset($_FILES['qqfile']) ) //veio per post normal
		$_FILES['midias'] = $_FILES['qqfile'];
	if( isset($_GET['qqfile']) ) // upload via xhr
	{
		// terminamos o nome temporario
		$tmp_name = BASE_PATH.'/public/'.$the_module.'/'.geraHash().".".getExtensao($_GET['qqfile']);
		// ex: http://github.com/valums/file-uploader/blob/master/server/php.php
		//copia-se o arquivo
		$input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        //verifica integridade??
        if ($realSize !=  (int)$_SERVER["CONTENT_LENGTH"]){
           die('{"error":"verificando tamanhos"}');
        }
        //escreve no local temporário
        $target = fopen($tmp_name, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
		// alteramos para funcionar normalmente
		$_FILES['midias']['name'] = $_GET['qqfile'];
		$_FILES['midias']['tmp_name'] = $tmp_name;
		$_FILES['midias']['type'] = getMimeType(getExtensao($_GET['qqfile']) );
	}
?>