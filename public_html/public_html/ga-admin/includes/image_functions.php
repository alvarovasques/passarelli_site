<?php
/**
 * Functions::image_functions
 *
 * Arquivo das funções de imagens
 *
 * Aqui teremos as definições de todas as funções que tratam imagens usadas no sistema administrativo
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.0, Created: 30/09/2010, LastModified: 05/10/2010
 * @package 	Functions
 * @filesource
 */

 // ########## CATEGORY: image ##########

	/**
	 * Carrega um resouce de imagem de acordo com seu tipo [gif, png, bmp e jpg]
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	$img = IMG_load( 'teste.bmp', $info ); // bmps serão convertidos para 'jpg'
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.1, Agosto de 2010
	 * @category image
	 * @param	 string $path caminho da string
	 * @param	 array &$info guardará as informações sobre a imagem[getimagesize()]
	 * @return	 resource
	 */
		function IMG_load( $path, &$info)
		{
			$info = @getimagesize($path);
			if( $info )
			{
				$info['path'] = $path;
				switch($info[2])
				{
					case 3: // png
						$src = imagecreatefrompng($path);
						imagealphablending($src, false);
						imagesavealpha($src, true);
						return $src;
					break;
					case 2: // JPE?G
						$src = imagecreatefromjpeg($path);
						return $src;
					break;
					case 1: // gif
						$src = imagecreatefromgif($path);
						return $src;
					break;
					case 6: // BMP
						$src = imagecreatefrombmp($path);
						// todos bmp's serão convertidos para jpg
						$info[2] = 2;
						return $src;
					break;
					default:
						add_debug_msg( sprintf('Provável tentativa de abrir arquivo sem suporte [%s]', $path), 'functions.php::IMG_load()');
					break;
				}
			}
			else
			{
				add_debug_msg( sprintf('Falha ao abrir arquivo [%s]', $path), 'functions.php::IMG_load()');
			}
			return null;
		}
	/**
	 * Finaliza a imagem salvando, ou na tela
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	$img = IMG_load( 'teste.bmp', $info );
	 *	$img = IMG_flush( 2, $img ); // printa na tela a imagem
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto de 2010
	 * @category image
	 * @param	 integer $type tipo da imagem [getimagesize()]
	 * @param	 resource $src imagem carregada via imageCreateFrom...[ou IMG_load()]
	 * @param	 string $path caminho para o arquivo de saida
	 * @return	 boolean
	 */
		function IMG_flush( $type, $src, $path = '' )
		{
			$ok = false;
			// forçar NULL para printar na tela
			if( empty($path) )
			{
				$path = NULL;
			}
			if( !is_resource($src) )
			{
				add_debug_msg('Segundo argumento incorreto, esperando um gd-resource', 'functions.php::IMG_flush()');
				return $ok;
			}
			switch($type)
			{
				case 3:// image PNG
					if( empty($path) )
					{
						header('Content-type: image/png');
						header("Cache-Control: must-revalidate");
						header("Expires: ".gmdate("D, d M Y H:i:s", time() + 3*24*60*60). " GMT");
					}
					imagepng($src, $path);
					$ok = true;
				break;
				case 2: // image JPG
					if( empty($path) )
					{
						header('Content-type: image/jpeg');
						header("Cache-Control: must-revalidate");
						header("Expires: ".gmdate("D, d M Y H:i:s", time() + 3*24*60*60). " GMT");
					}
					imagejpeg($src, $path, 86);
					$ok = true;
				break;
				case 1:// image GIF
					if( empty($path) )
					{
						header('Content-type: image/gif');
						header("Cache-Control: must-revalidate");
						header("Expires: ".gmdate("D, d M Y H:i:s", time() + 3*24*60*60). " GMT");
					}
					imagegif($src, $path);
					$ok = true;
				break;
			}
			@imagedestroy($src); //destruir imagem
			return $ok;
		}
	/**
	 * Faz o resize da imagem
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	$img = IMG_load('teste.bmp', $i ); // carregamos a imagem
	 * //diminuimos sua altura e largura pela metade
	 *	$img = IMG_resize($i[2], $img, $i[0], $i[1], floor($i[0]/2), floor(i[1]/2) );
	 *	$img = IMG_flush( 2, $img ); // printa na tela a imagem
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto de 2010
	 * @category image
	 * @param	 integer $type tipo da imagem [getimagesize()]
	 * @param	 resource $src imagem carregada via imageCreateFrom...[ou IMG_load()]
	 * @param	 integer $sWidth largura do source;
	 * @param	 integer $sHeight Altura do source;
	 * @param	 integer $dWidth largura do resource de saida;
	 * @param	 integer $dHeight Altura do resource de saida;
	 * @param	 integer $x_pos deslocamento em x[horizontal];
	 * @param	 integer $y_pos deslocamento em y[vertical];
	 * @return	 resource
	 */
		function IMG_resize($type, $src, $sWidth, $sHeight, $dWidth, $dHeight, $x_pos = 0, $y_pos = 0)
		{
			switch($type)
			{
				case 3: // png
					$resized = imagecreatetruecolor($dWidth, $dHeight);
					imagecolortransparent($resized);
					imagealphablending($resized, false);
					imagesavealpha($resized, true);
					imagecopyresampled($resized, $src, 0, 0, $x_pos, $y_pos, $dWidth, $dHeight, $sWidth, $sHeight);
					return $resized;
				break;
				case 2: // image JPG
					$resized = imagecreatetruecolor($dWidth, $dHeight);
					imagecopyresampled($resized, $src, 0, 0, $x_pos, $y_pos, $dWidth, $dHeight, $sWidth, $sHeight);
					return $resized;
				break;
				case 1: // image GIF
					$resized = imagecreate($dWidth, $dHeight);
					$trans = imagecolorallocate($resized, 255, 99, 140);
					imagecolortransparent($resized, $trans);
					imagecopyresampled($resized, $src, 0, 0, $x_pos, $y_pos, $dWidth, $dHeight, $sWidth, $sHeight);
					imagetruecolortopalette($resized, true, 256);
					imageinterlace($resized);
					return $resized;
				break;
			}
			return null;
		}
	/**
	 * Cria uma cópia da imagem com as configurações recebidas por parâmetro
	 *
	 *<code>
	 *<?php
	 *	createImagem( 'aviao.jpg', 'thumb.jpg', 200,300, 'TL' );
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category image
	 * @param	 string $inputFile Caminho da imagem de entrada;
	 * @param	 string $outputFile Caminho para arquivo de saída { caso ''(tela) };
	 * @param	 integer $outWidth largura para a nova imagem;
	 * @param	 integer $outHeight altura da nova imagem, caso na informada calcula-se proporcional a largura;
	 * @param	 string $crop usa funcionalidades do crop - a imagem será redimensionada e cortada{ 'C L R', 'T M B', true(CM), false, "FS"-fit space;
	 * @return	 integer
	 */
		function createImagem( $inputFile, $outputFile, $outWidth, $outHeight = '', $crop = false )
		{
			// arquivo passado foi o correto e tem uma largura
			if( file_exists($inputFile) && is_numeric($outWidth) && $outWidth > 1)
			{
				// recupera informações de tamanho [0 => width, 1 => height, 2 => tipo]
				list($width, $height, $type) = @getimagesize($inputFile);
				// todos os bmp's serão convertidos em jpg
				if( $type == 6 )
				{
					$type = 2;
				}
				// altura proporcional width/height ~= outWidth/outHeight
				if( !is_numeric($outHeight) )
				{
					$outHeight = floor( ($outWidth / $width) * $height );
					$crop = false;
				}
				// dados de crop
				$x_pos = $y_pos = 0;
				// dados de resize
				$resWidth = $outWidth;
				$resHeight = $outHeight;
				// calcular dados para resize e crop
				if( $crop )
				{
					// ajusta os dados de crop
					if( $crop === true || strlen($crop)!=2 )
					{
						$crop = 'CM';
					}
					$crop = strtoupper($crop);
					// tamanhos para resize
					$Ratio = array( 'width' => ($outWidth / $width), 'height' => ($outHeight / $height) );
					// tenta se encaixar no espaço "Fit Space"
					if( $crop == 'FS' )
					{
						$x_pos = $y_pos = 0;
						$resWidth  = ceil( $Ratio['height'] * $width  );
						$resHeight = ceil( $Ratio['width']  * $height );
						if( $outWidth > $resWidth )
						{
							$outWidth = $resWidth;
						}
						if( $outHeight > $resHeight )
						{
							$outHeight = $resHeight;
						}
						$crop = false;
					}
					else
					{
						// qual mais será afetado
						if( $Ratio['width'] > $Ratio['height'] )
						{ // crop será vertical
							$resHeight = ceil( $Ratio['width'] * $height );
							switch( $crop{1} )
							{
								case 'B': $y_pos = $resHeight - $outHeight; break;
								case 'T': $y_pos = 0; break;
								default: $y_pos = floor( ($resHeight - $outHeight) / 2); break;
							}
						}
						else if( $Ratio['height'] > $Ratio['width'] )
						{ // crop será horizontal
							$resWidth = floor($Ratio['height'] * $width);
							switch( $crop{0} )
							{
								case 'L': $x_pos = 0; break;
								case 'R': $x_pos = $resWidth - $outWidth; break;
								default:  $x_pos = floor( ($resWidth - $outWidth) / 2); break;
							}
						}
						else
						{ // entrada e saida possuem o mesmo "ratio" crop desnecessário
							$crop = false;
						}
					}
				}
				// carregar a imagem
				if( $src = IMG_load($inputFile, $_needed) )
				{
					// necessario cropar?
					if( $crop )
					{
						$resized = IMG_resize( $type, $src, $width, $height, $resWidth, $resHeight );
						// dados para crop
						$width = $outWidth;
						$height = $outHeight;
						imagedestroy($src);
						$src = $resized;
					}
					// resize final
					$tmb = IMG_resize( $type, $src, $width, $height, $outWidth, $outHeight, $x_pos, $y_pos );
					IMG_flush( $type, $tmb, $outputFile );
					@imagedestroy($src);
					@imagedestroy($tmb);
					return 1;
				}
				else
				{
					add_debug_msg( sprintf('Erro ao tentar carregar arquivo[%s]', $inputFile), 'functions.php::createImagem()' );
				}
			}
			return 0;
		}
	/**
	 * Escreve algum texto sobre uma imagem
	 *
	 *<code>
	 *<?php
	 *	$base = IMG_load('base.jpg');
	 *	$img = IMG_fromString($base, 'teste de escrita', 3, -50, -30, 'CCCCCC');
	 *	//cria e escreve uma imagem
	 *	$img = IMG_fromString(array(200,200,'FF00FF'), 'teste escrita', 3, -50, -30, 'CCCCCC');
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category image
	 * @param	 resource $img o resource de imagem ou um array( width, height, backgroundcolor )
	 * @param	 string $str texto a ser escrito;
	 * @param	 integer $fSize Tamanho0 da fonte (1..5) um resource carrefado por imageloadfont()
	 * @param	 integer $pLeft deslocamento horizontal
	 * @param	 integer $pTop deslocamento vertical
	 * @param	 integer $color cor da fonte
	 * @return	 resource
	 */
		function IMG_fromString( $img, $str, $fSize = 2, $pLeft = 0, $pTop = 0, $color = '000000' )
		{
			if( !is_numeric($pLeft) )
			{
				$pLeft = 0;
			}
			if( !is_numeric($pTop) )
			{
				$pTop = 0;
			}
		// se recebermos um array, criamos um resource
			if(!is_resource($img) )
			{
				if(is_array($img))
				{
					$img2 = imagecreatetruecolor( $img[0], $img[1] );
					$back = @imagecolorallocate( $img2, hexdec(substr($img[2],0,2)), hexdec(substr($img[2],2,2)),hexdec(substr($img[2],4,2)) );
					imagefill( $img2, 0,0,$back );
					$img = $img2;
				}
				else
				{
					add_debug_msg( 'Argumentos passados incorretamente', 'functions.php::IMG_fromString()');
					return null;
				}
			}
		// tratamos da cor
			if( strlen($color) < 6 )
			{
				$color = '000000';
			}
			$color = @imagecolorallocate( $img, hexdec(substr($color,0,2)), hexdec(substr($color,2,2)),hexdec(substr($color,4,2)) );
		// posicionamento
			if( $pLeft < 0 )
			{
				$pLeft = imagesx($img) + $pLeft;
			}
			if($pTop < 0)
			{
				$pTop = imagesy($img) + $pTop;
			}
		// escrevemos
			imagestring( $img, $fSize, $pLeft, $pTop, $str, $color );
			return $img;
		}
	/**
	 * Inverte uma imagem vertical horizontal ou ambos{vertical, horizontal, both}
	 *
	 *<code>
	 *<?php
	 *	$img = IMG_invert( 'aviao.jpg', 'vertical' );	
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category image
	 * @param	 string $path Caminho para o arquivo base
	 * @param	 string $direction direção a ser invertida
	 * @return	 resource
	 */
		function IMG_invert( $path, $direction = 'horizontal' )
		{
			$imgdest = NULL;
			// carrega o arquivo e suas info
			if( $imgsrc = IMG_load($path, $info) )
			{
				$src_w = $width  = imagesx ( $imgsrc );
				$src_h = $height = imagesy ( $imgsrc );
				$src_x = $src_y = 0;
				// acerta os dados
				switch ( $direction )
				{
					case 'vertical':
						$src_y =  $height -1;
						$src_h = -$height;
					break;
					case 'horizontal':
						$src_x =  $width -1;
						$src_w = -$width;
					break;
					case 'both':
						$src_x =  $width -1;
						$src_w = -$width;
						$src_y =  $height -1;
						$src_h = -$height;
					break;
					default:
						return $imgsrc;
					break;
				}
				$imgdest = imagecreatetruecolor($width, $height );
				if( $info[2] == 1 )// gif
				{
					$imgdest = IMG_getTransparentBase( $imgsrc, $width, $height );
				}
				else
				{			
					imagecolortransparent($imgdest);
					imagealphablending($imgdest, false);
					imagesavealpha( $imgdest, true);
				}
				@imagecopyresampled ( $imgdest, $imgsrc, 0, 0, $src_x, $src_y , $width, $height, $src_w, $src_h );
				@imagedestroy($imgsrc); //destroi arquivo base
			}
			else
			{
				add_debug_msg( 'IMG_load() retornou null', 'image_functions.php::IMG_invert()' );
			}
			return $imgdest;
		}
	/**
	 * Cria uma imagem com reflexo
	 *
	 *<code>
	 *<?php
	 *	$img = IMG_reflect( 'aviao.jpg', 40 );	
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category image
	 * @param	 string $path Caminho para o arquivo base
	 * @param	 integer $reflectPercentage altura do reflexo proporcional a altura da base
	 * @param	 integer $opacity valor de opacity 
	 * @param	 integer $space espaço entre a imagem e o reflexo
	 * @param	 integer $basePixel deslocamento do reflexo
	 * @return	 resource
	 */
		function IMG_reflect( $path, $reflectPercentage = 100, $opacity = 50, $space = 0, $basePixel = 0)
		{
			$image = NULL;
			if( !is_numeric($space) )
			{
				$space = 0;
			}
			if( !is_numeric($opacity) )
			{
				$opacity = 50;
			}
			if( $src = IMG_load( $path, $info ) )
			{
				// calcula a altura do reflexo
				if( !is_numeric($reflectPercentage) )
				{
					$reflectPercentage = 100;
				}
				if( $reflectPercentage > 1 )
				{
					$reflectPercentage /= 100;
				}
				$reflectHeight = round( $info[1] * $reflectPercentage );
				if( $reflectHeight > $info[1] )
				{
					$reflectHeight = $info[1];
				}
			// define os dados de saida altura largura e tamanho do reflexo
				if( $basePixel == 0 )
				{
					$reflectWidth  = $info[0];
					$outputWidth   = $info[0];
					$outputHeight  = $info[1]+$reflectHeight;
				}
				else
				{
					$reflectWidth  = $info[0]+$reflectHeight;;
					$outputWidth   = $info[0]+$reflectHeight;;
					$outputHeight  = $info[1]+$reflectHeight;
				}
				// cria o reflexo
				$reflect = IMG_getTransparentBase( $src, $reflectWidth, $reflectHeight );
				for( $j = 0; $j < $reflectHeight; ++$j )
				{
					$_base = 0;
					if( $basePixel > 0 )
					{
						$_base = floor($j/$basePixel);
					}
					else if( $basePixel < 0 )
					{
						$_base = floor($reflectHeight + $j/$basePixel );
					}
					imagecopy( $reflect, $src, $_base, $j, 0, $info[1]-$j -1, $info[0], 1);
				}
				$tst = IMG_getTransparentBase($reflect, $reflectWidth, $reflectHeight );
				imagecopymerge( $tst, $reflect, 0, 0, 0, 0, $reflectWidth, $reflectHeight, $opacity );		
				//cria a imagem final		
				$image = IMG_getTransparentBase($reflect, $outputWidth, $outputHeight+$space);
				$pos_x = $reflectHeight;
				if( $basePixel >= 0 )
					$pos_x = 0;
				// copia a base
				imagecopy( $image, $src, $pos_x, 0, 0, 0, $info[0],$info[1] );
				// copia o reflexo
				imagecopy( $image, $tst, 0, $info[1]+$space, 0, 0, $reflectWidth, $reflectHeight);
			}
			return $image;
		}
	/**
	 * Adiciona uma marca dágua no arquivo passado e altera-o
	 *
	 * Colocando no canto inferior direito com deslocamento de 5pixels
	 *<code>
	 *<?php
	 *	$img = IMG_addWaterMark( 'aviao.jpg', 'watermark.png', 30, 30 );	
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category image
	 * @param	 string $path Caminho para o arquivo que receberá a marca d'agua
	 * @param	 string $waterFile Caminho para o arquivo de marca d'água
	 * @param	 integer $waterWidth largura da marca d'água proporcional ao tamanho da base[0-1] ou [0-100]
	 * @param	 integer $opacity valor de opacity 
	 * @return	 boolean
	 */
		function IMG_addWaterMark( $path, $waterFile, $waterWidth = 0.1, $opacity = 100)
		{
			if( !is_numeric($waterWidth) )
			{
				$waterWidth = 10;
			}
			if( $waterWidth > 1 )
			{
				$waterWidth = $waterWidth/100;
			}
			// se ambos arquivos existirem
			if( file_exists($path) && file_exists($waterFile) )
			{
			// carrega as infos e os arquivos
				$dst = IMG_load( $path, $inputInfo );
				$src = IMG_load( $waterFile, $waterInfo );
			// acerta o tamanho do watermark
				$waterWidth = floor($waterWidth*$inputInfo[0]);
				if($waterWidth != $waterInfo[0])
				{
					// resize necessário
					$waterHeight = floor( ($waterWidth / $waterInfo[0]) * $waterInfo[1] );
					$src = IMG_resize( $waterInfo[2], $src, $waterInfo[0], $waterInfo[1], $waterWidth, $waterHeight );
				}
				else
				{
					$waterHeight = $waterInfo[1];
				}
			// acerta os paddings
				$paddingLeft = floor($inputInfo[0]-$waterWidth-5);
				$paddingTop = floor($inputInfo[1]-$waterHeight-5);
				switch( $inputInfo[2] )
				{
					case 2:
						$wtr = imagecreatetruecolor($waterWidth, $waterHeight);
						imagecopy($wtr, $dst, 0, 0, $paddingLeft, $paddingTop, $waterWidth, $waterHeight);
						imagecopy($wtr, $src, 0, 0, 0, 0, $waterWidth, $waterHeight);
						@imagedestroy( $src );
						// cria o item de retorno
						$ret = imagecreatetruecolor( $inputInfo[0], $inputInfo[1] );
					break;
					case 1:
					case 3:
						$wtr = IMG_getTransparentBase( $dst, $waterWidth, $waterHeight );
						imagecopy( $wtr, $src, 0, 0, 0, 0, $waterWidth, $waterHeight );
						@imagedestroy( $src );
						// cria o item de retorno
						$ret = IMG_getTransparentBase( $dst, $inputInfo[0], $inputInfo[1] );
						imagealphablending($ret, false);
						imagesavealpha($ret, true);
					break;
				}
				imagecopyresampled($ret, $dst, 0, 0, 0, 0, $inputInfo[0], $inputInfo[1], $inputInfo[0], $inputInfo[1]);
				@imagedestroy($dst);
				// fazer o merge
				@imagecopymerge($ret, $wtr, $paddingLeft, $paddingTop, 0, 0, $waterWidth, $waterHeight, $opacity );
				return IMG_flush( $inputInfo[2], $ret, $path );
			}
			else
			{
				add_debug_msg( sprintf( 'Falha ao abrir [%s] e/ou [%s]', $path, $waterFile), 'functions.php()::IMG_addWaterMark()' );
			}
			return false;
		}
	/**
	 * Adiciona uma marca dágua no arquivo passado e retorna-o
	 *
	 *<code>
	 *<?php
	 *	$img = IMG_addWaterMark2( 'aviao.jpg', 'watermark.png', 70, -80, -100, 30 );	
	 *?>
	 *</code>
 	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category image
	 * @param	 string $path Caminho para o arquivo que receberá a marca d'agua
	 * @param	 string $waterFile Caminho para o arquivo de marca d'água
	 * @param	 integer $waterWidth largura da marca d'água
	 * @param	 integer $paddingLeft Deslocamento horizontal  da marca d'água
	 * @param	 integer $paddingTop Deslocamento vertical da marca d'água
	 * @param	 integer $opacity valor de opacity 
	 * @return	 resource
	 */
		function IMG_addWaterMark2( $path, $waterFile, $waterWidth = '', $paddingLeft = 0, $paddingTop = 0, $opacity = 50){
			if(!is_numeric($paddingLeft))
			{
				$paddingLeft=0;
			}
			if(!is_numeric($paddingTop))
			{
				$paddingTop=0;
			}
			if(!is_numeric($opacity))
			{
				$opacity=100;
			}
			if($opacity > 0 && $opacity < 1)
			{
				$opacity *= 100;
			}
			// se ambos arquivos existirem
			if( file_exists($path) && file_exists($waterFile) )
			{
			// carrega as infos e os arquivos
				$dst = IMG_load( $path, $inputInfo );
				$src = IMG_load( $waterFile, $waterInfo );
			// acerta os paddings
				if($paddingLeft < 0 )
				{
					$paddingLeft = $inputInfo[0]+$paddingLeft;
				}
				if($paddingTop < 0 )
				{
					$paddingTop = $inputInfo[1]+$paddingTop;
				}
			// acerta o tamanho do watermark
				$waterHeight = $waterInfo[1];
				if(is_numeric($waterWidth) &&  $waterWidth != $waterInfo[0])
				{
					// resize necessário
					$waterHeight = floor( ($waterWidth / $waterInfo[0]) * $waterInfo[1] );
					$src = IMG_resize( $waterInfo[2], $src, $waterInfo[0], $waterInfo[1], $waterWidth, $waterHeight );
				}
				else
				{
					$waterWidth = $waterInfo[0];
				}
				switch( $inputInfo[2] )
				{
					case 2:
						$wtr = imagecreatetruecolor($waterWidth, $waterHeight);
						imagecopy($wtr, $dst, 0, 0, $paddingLeft, $paddingTop, $waterWidth, $waterHeight);
						imagecopy($wtr, $src, 0, 0, 0, 0, $waterWidth, $waterHeight);
						@imagedestroy( $src );
						// cria o item de retorno
						$ret = imagecreatetruecolor( $inputInfo[0], $inputInfo[1] );
					break;
					case 1:
					case 3:
						$wtr = IMG_getTransparentBase( $dst, $waterWidth, $waterHeight );
						imagecopy( $wtr, $src, 0, 0, 0, 0, $waterWidth, $waterHeight );
						@imagedestroy( $src );
						// cria o item de retorno
						$ret = IMG_getTransparentBase( $dst, $inputInfo[0], $inputInfo[1] );
						imagealphablending($ret, false);
						imagesavealpha($ret, true);
					break;
				}
				imagecopyresampled($ret, $dst, 0, 0, 0, 0, $inputInfo[0], $inputInfo[1], $inputInfo[0], $inputInfo[1]);
				@imagedestroy($dst);
				// fazer o merge
				@imagecopymerge($ret, $wtr, $paddingLeft, $paddingTop, 0, 0, $waterWidth, $waterHeight, $opacity );
				return $ret;
			} else {
				add_debug_msg( sprintf( 'Falha ao abrir [%s] e/ou [%s]', $path, $waterFile), 'functions.php()::IMG_addWaterMark()' );
			}
			return null;
		}
	/**
	 * Cria uma nova base com o fundo transparente, resolve alguns problemas com png's e gif's
	 *
	 *<code>
	 *<?php
	 *	$img = IMG_load( 'arquivo.png' );
	 *	$new = IMG_getTransparentBase( $img, 200, 200 );
	 *?>
	 *</code>
	 * @author   anonymous php.net
	 * @version  1.0, agosto 2010
	 * @category image
	 * @param	 resource $image_source imagem base
	 * @param	 integer $newWidth largura do novo resource
	 * @param	 integer $newHeight valor da altura do novo resource
	 * @return	 resource
	 */
		function IMG_getTransparentBase( $image_source, $newWidth = '', $newHeight = ''){
			if( !is_numeric($newWidth) )
			{
				$newWidth = imagesx($image_source);
			}
			if( !is_numeric($newHeight) )
			{
				$newHeight = imagesy($image_source);
			}
			/* cria o novo resource */
			$new_image = imagecreatetruecolor( $newWidth, $newHeight );
			/* Busca pelo indice transparente */
			$transparencyIndex = imagecolortransparent($image_source);
			$transparencyColor = array( 'red'=>255,'green'=>255,'blue'=>255);
			if ($transparencyIndex >= 0)
			{
				$transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);
			}	
			$transparencyIndex = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']); 
			imagefill($new_image, 0, 0, $transparencyIndex); 
			imagecolortransparent($new_image, $transparencyIndex);	
			return $new_image;
		}
	/**
	 * Função faz load de arquivos bmp e retorna um resource gd
	 *
	 *<code>
	 *<?php
	 *	$img = imagecreatefrombmp( 'arquivo.bmp' );	
	 *?>
	 *</code>
	 * @author   DHKold ( admin@dhkold.com )
	 * @version  2.0B, 15/06/2005
	 * @category image
	 * @param    string $filename caminho para imagem
	 * @return	 resource
	 */ 
		function imagecreatefrombmp($filename)
		{
		 //Ouverture du fichier en mode binaire
		   if (! $f1 = fopen($filename,"rb")) return FALSE;
		 //1 : Chargement des enttes FICHIER
		   $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
		   if ($FILE['file_type'] != 19778) return FALSE;
		 //2 : Chargement des enttes BMP
		   $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
						 '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
						 '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
		   $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
		   if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
		   $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
		   $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
		   $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
		   $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
		   $BMP['decal'] = 4-(4*$BMP['decal']);
		   if ($BMP['decal'] == 4) $BMP['decal'] = 0;
		 //3 : Chargement des couleurs de la palette
		   $PALETTE = array();
		   if ($BMP['colors'] < 16777216)
		   {
			$PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
		   }
		 //4 : Creation de l'image
		   $IMG = fread($f1,$BMP['size_bitmap']);
		   $VIDE = chr(0);
		   $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
		   $P = 0;
		   $Y = $BMP['height']-1;
		   while ($Y >= 0)
		   {
			$X=0;
			while ($X < $BMP['width'])
			{
			 if ($BMP['bits_per_pixel'] == 24)
				$COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
			 elseif ($BMP['bits_per_pixel'] == 16)
			 {  
				$COLOR = unpack("n",substr($IMG,$P,2));
				$COLOR[1] = $PALETTE[$COLOR[1]+1];
			 }
			 elseif ($BMP['bits_per_pixel'] == 8)
			 {  
				$COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
				$COLOR[1] = $PALETTE[$COLOR[1]+1];
			 }
			 elseif ($BMP['bits_per_pixel'] == 4)
			 {
				$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
				if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
				$COLOR[1] = $PALETTE[$COLOR[1]+1];
			 }
			 elseif ($BMP['bits_per_pixel'] == 1)
			 {
				$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
				if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
				elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
				elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
				elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
				elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
				elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
				elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
				elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
				$COLOR[1] = $PALETTE[$COLOR[1]+1];
			 }
			 else
				return FALSE;
			 imagesetpixel($res,$X,$Y,$COLOR[1]);
			 $X++;
			 $P += $BMP['bytes_per_pixel'];
			}
			$Y--;
			$P+=$BMP['decal'];
		   }
		 //Fermeture du fichier
		   fclose($f1);
		 return $res;
		}

/* #fim das funções */
?>