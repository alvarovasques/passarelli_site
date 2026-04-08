<?php
/**
 * Midia::crop_controller
 *
 * Faz todo o processamento do crop
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     1.000, Created: 30/09/2010, LastModified: 05/10/2010
 * @package 	Midia
 * @filesource
 */
	// pega dados da imagem para o iframe
	if( isset($_POST["input"]) ){
		$the_input	= _post($_POST["input"]);
	}
	if (isset($_GET['id']) && is_numeric($_GET['id']))
	{
		$the_input	= ($_GET);
	}
	
	$midia = getMidia($the_input['id']);
	$midia = $midia[0];
	
	// caso nao esteja setado o thumb verifica se tem mais de um para exibir o menu de opçoes
	if (!isset($the_input['tb']) ){
		if (!file_exists(getMidiaLink($the_input['id'],'b','path'))){	
			$the_input['tb']='a';
		}else{
			$thumbs = array('a','b','c');
			foreach ($thumbs as $thumb){	
				if (file_exists(getMidiaLink($midia['id'],$thumb,'path'))){	
					$src = getMidiaLink($the_input['id'],$thumb,'path');
					$info[$thumb] = @getimagesize($src);
				}
			}				
		}
	}		
	if (isset($the_input['tb']) && file_exists(getMidiaLink($midia['id'],$the_input['tb'],'path'))){	
		$src = getMidiaLink($the_input['id'],$the_input['tb'],'path');
		$info[$the_input['tb']] = @getimagesize($src);
	}

	
	$src = getMidiaLink($the_input['id'],'','path');
	$info[0] = @getimagesize($src);
	//Pega o aspectRatio do Thumb para setar o crop
	$aspectRatio = $info[$the_input['tb']][0]."/".$info[$the_input['tb']][1];
	//bug fix
	if( $aspectRatio == '/' ){ $aspectRatio = 1; }
	
	if (isset($_POST['the_input']) && file_exists(getMidiaLink($the_input['id'],$the_input['tb'],'path')))
	{
		// Loada o arquvio padrao
		$img_r = IMG_load($src, $_needed);
		// cria o crop */
		$dest = IMG_resize($info[0][2], $img_r,$_POST['w'], $_POST['h'], $_POST['w'], $_POST['h'] , $_POST['x'], $_POST['y']);
		
		// tenta alterar a imagem 
		$infoMidia = @getimagesize(getMidiaLink($the_input['id'],$the_input['tb'],'path'));
		// resizea para deixa-lo com o tamanho do thumb 
		$dest = IMG_resize( $info[0][2], $dest, $_POST['w'], $_POST['h'],$infoMidia[0],$infoMidia[1] );	
		// sobrescreve o arquivo thumb
			IMG_flush( $info[0][2], $dest, getMidiaLink($the_input['id'],$the_input['tb'],'path') );		
	}

