<?php
/**
 * Midia::midia.php
 *
 * Arquivo com as funções relativas à mídias em todo sistema.<br>
 * Agrupam todas as funções que são usadas no cadastro, remoção, edição ou mesmo visualização das mídias
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.016, Created: 30/09/2010, LastModified: 26/10/2011
 * @package 	Midia
 * @subpackage  Functions
 * @filesource
 */

/**
 * Tentar fazer verificação de mimetype
 * @global boolean $verify_mime
 */
	$verify_mime = true;
// html ou xhtml?
	if (!isset($use_xhtml))
	{
	 /**
	 * Printar código xhtml no view
	 * @global boolean $use_xhtml
	 */
		$use_xhtml = true;
	}

// se esse arquivo for incluso usando ajax
// pode disparar warning de permissão de leitura dependendo de quem incluir este arquivo
	if(!defined('BASE_URL'))
		require_once dirname(dirname(__FILE__)) . "/includes/admin_config.php";
/**
 * Guarda todas as mensagens da execução atual sobre midias;
 * @global mixed $the_midia_msg
 */
	$the_midia_msg = array(
		'success' => array(),
		'error'   => array(),
		'info'    => array(),
		'notice'  => array()
	);
/**
 * Adiciona uma mensagem para ser mostrada ao usuário
 *
 * uso:
 * <code>
 *<?php
 *	// adiciona uma mensagem de alerta olá
 *	add_midia_msg('olá');
 *	// adiciona uma mensagem de erro que contém html
 *	add_midia_msg('<p>Erro</p>', 'error', true );
 *  // adiciona uma mensagem de sucesso
 *	add_midia_msg('uhul, deu certo', 'success' );
 *  // similar ao primeiro exemplo
 *	add_midia_msg( 'olá', 'notice' );
 *?>
 * </code>
 *
 * @version   1.0, Created: 30/08/2010
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @param     string $the_message a mensagem a ser adicionada
 * @param     string $message_class o tipo da mensagem, baseado no blueprint css framework { (notice), error e success }
 * @param     boolean $ishtml  flag para indicar se a mensagem contém (pode conter) html. (false)
 * @return    boolean
 */
function add_midia_msg ($the_message, $message_class = 'notice', $ishtml = false)
{
	global $the_midia_msg;
	// sem mensagem nada a fazer
	if (empty($the_message))
		return false;
	
	// se não for html usamos o htmlentities para tentar evitar problemas de codificação
	if (!$ishtml)
		$the_message = _allowQuotes($the_message);
	
	switch($message_class)
	{
		case 'success':
			array_push ($the_midia_msg['success'], $the_message);
		break;
		case 'error':
			array_push( $the_midia_msg['error']  , $the_message );
		break;
		case 'info':
			array_push( $the_midia_msg['info']  , $the_message );
		break;
		default: 
			array_push( $the_midia_msg['notice'] , $the_message );
		break;
	}
}
/**
 * Exibe todas as mensagens armazenadas para a classe passada
 *
 * uso:
 * <code>
 *<?php
 *	array_midia_msg_to_html(); // exibe todas as mensagens de alerta(notice)
 *	array_midia_msg_to_html('success'); // exibe todas as mensagens de sucesso
 *	array_midia_msg_to_html('error'); // exibe todas as mensagens de erro
 *?>
 *</code>
 *
 * @version   1.01, Created: 30/08/2010, LastModified: 13/08/2011
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @param     string $class a classe da mensagem (notice)
 * @return    void
 */
function array_midia_msg_to_html( $class = 'notice')
{
	global $the_midia_msg;
	$img = '<img src="includes/images/icons/close.png" onclick="jQuery(this).parent().slideUp(\'slow\',function(){jQuery(this).remove()})" style="cursor:pointer;position:absolute;top:2px;right:2px"  alt="close" />';
	switch($class)
	{
		case 'error':
			if (!empty($the_midia_msg['error']))
				echo sprintf('<div style="position:relative" class="error clear" id="midia-error-box">%s %s</div>', implode('<br />', $the_midia_msg['error']), $img);
		break;
		case 'success':
			if (!empty($the_midia_msg['success']))
				echo sprintf('<div style="position:relative" class="success clear" id="midia-success-box">%s %s</div>', implode('<br />', $the_midia_msg['success']), $img);
		break;
		case 'info':
			if (!empty($the_midia_msg['info']))
				echo sprintf('<div style="position:relative" class="info clear" id="midia-info-box">%s %s</div>', implode('<br />', $the_midia_msg['info']), $img);
		break;
		default:
			if (!empty($the_midia_msg['notice']))
				echo sprintf('<div style="position:relative" class="notice clear" id="midia-notice-box">%s %s</div>', implode('<br />', $the_midia_msg['notice']), $img);
		break;
	}
}
/**
 * Salva os dados de uma mídia no sistema
 *
 *<b>Observações</b>
 *<ol>
 *	<li>Os índices 'codigo' e 'tipo' devem estar presentes no segundo parâmetro</li>
 *	<li>Para toda imagem com suporte, será criada uma miniatura do tipo "admin" com 50x50pixels e "cropada" no centro e meio</li>
 *	<li>Todas as imagens terão no máximo 950px de largura, se o último parâmetro true</li>
 *	<li>Além da imagem original(resized to 950px se necessário) e da 'admin', é ainda possível criar mais três(3) usando os parâmetros de widths, heights(a,b,c)</li>
 *</ol>
 * uso:
 * <code>
 *<?php
 *  // array mapeando a tabela rb_midias (required: extensao, codigo e tipo )
 *	$midia = array('titulo'=>'Mídia', 'ordem'=>10, 'tipo'=>'paginas', 'codigo'=>100, 'extensao' => 'jpg');
 * // do files é necessário
 * // ( name=> nome do arquivo base, tmp_name => caminho do arquivo, type => mimetype do arquivo )
 * // exibe um id ou 0 em erro
 *	echo saveMidia($_FILES['foto'],$midia,array('jpg','png')) ;
 *?>
 *</code>
 *
 * @version   1.1, Created: 30/08/2010, LastModified: 30/09/2010
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @param     mixed $midia dados do arquivo( $_FILES )
 * @param     mixed $midiaInfo array associativo para preencher tabela rb_midias
 * @param     mixed $allowed extensões que podem ser utilizadas
 * @param     mixed $widths configurações de largura de possíveis imagens
 * @param     mixed $heights configurações de altura de possíveis imagens
 * @param     string $useCrop configuração de crop para possíveis imagens
 * @param     boolean $reSize a mídia original não será alterada
 * @return    integer id da mídia ou 0
 */
function saveMidia($midia, $midiaInfo, $allowed, $widths = '', $heights = '', $useCrop = false, $reSize = true)
{
	$midia_id = 0; // valor de retorno
// definimos os allowed
	if( !is_array($allowed) )
		$allowed = (array)$allowed;
// verificar se ocorreu algum erro ao subir arquivo
	if (empty($midia['tmp_name']))
	{
		add_midia_msg( sprintf('Erro ao tentar salvar arquivo[%s]', $midia['name']), 'error');
		add_midia_msg( sprintf( 'Verifique se o arquivo excede %sB', ini_get('upload_max_filesize')) );
		add_midia_msg( 'Verifique se o caminho do arquivo está correto' );
		return false;
	}
// definir as dimensões em uma possivel chamada ao createImagem
// largura
	if (is_numeric($widths))
		$widths = array( 'a' => $widths);
	else if (is_array($widths))
	{
		$tot = count($widths);
		$temp = array();
		for($w = 0, $k = 'a'; $w < $tot; $w++,$k++)
			$temp[$k] = $widths[$w]; 
		$widths = $temp;
	}
	else
		$widths = array();	
// altura
	if (is_numeric($heights))
		$heights = array('a' => $heights);
	else if (is_array($heights))
	{
		$tot = count($heights);
		$temp = array();
		for ($w = 0, $k = 'a'; $w < $tot; $w++,$k++)
			$temp[$k] = $heights[$w];
		$heights = $temp;
	}
	else
		$heights = array();

// tipos de crop
	$default = "CM"; // caso nao tenha setado valor padrão é "centro" e "meio"
	if (!is_array($useCrop))
	{
		$default = $useCrop; // caso somente um valor setado ele será usado para todos
		$useCrop = array( 'a' => $useCrop );
	}
	else
	{
		$tot = count($useCrop);
		$temp = array();
		for ($w = 0, $k = 'a'; $w < $tot; $w++,$k++)
			$temp[$k] = $useCrop[$w];
		$useCrop = $temp;
	}
 // garantir que todas as midias tenham um "padrão" de crop
	foreach ($widths as $i => $w)
		$useCrop[$i] = isset($useCrop[$i])?$useCrop[$i]:$default;

// caso nao tenhamos um titulo, damos o mesmo nome que ele tinha
	if( empty($midiaInfo["titulo"]) )
		$midiaInfo["titulo"] = preg_replace( '/\.\w+$/', '', $midia['name'] );
	
// verificamos se podemos salvar a midia ou seja a extensão é permitida
	if( isset($midiaInfo['extensao']) && in_array($midiaInfo['extensao'], $allowed, true))
	{
		// alteramos a ordem da midia sempre será o máximo + 1 
		$midiaInfo['ordem'] = getMaxMidiaOrdem($midiaInfo['codigo'], $midiaInfo['tipo']) + 1;
		// converter todas as midias bmp para jpg
		if ($midiaInfo['extensao'] == 'bmp')
			$midiaInfo['extensao'] = 'jpg';
			
		// inserir na tabela de midia 
		$sql = toQuery('rb_midias', $midiaInfo);
		if (_query($sql))
		{
			$midia_id = _lastId();
			add_midia_msg( sprintf( 'Informações da mídia[%s] cadastrada', $midiaInfo['titulo']) , 'success' );
		}
		else
		{
			add_msg( 'Não foi possível salvar a mídia, erro ao guardar informações', 'error' );
			add_debug_msg( _sqlError(), 'midia.php::saveMidia()' );
			return $midia_id; // 0
		}
		
	// Salvar dados das midias do tipo lnk e emb
		if ($midia['type'] == 'lnk' || $midia['type'] == 'emb')
		{
			$sql = toQuery( 'rb_midias', array( 'id' => $midia_id, 'link' => $midia['tmp_name']) );
			if ($rs  = _query( $sql ))
				add_midia_msg( sprintf( 'Mídia do tipo [%s] cadastrada', $midiaInfo['extensao']=='lnk' ? 'Link' : 'Embed' ), 'success' );
			else
			{
				add_msg( 'Não foi possível salvar a mídia, erro ao guardar informações', 'error' );
				add_debug_msg( _sqlError(), 'midia.php::saveMidia()' );
			}
		}
		else
		{
			if ($verify_mime)
			{
				// start mimetype verification
				$mimetype = '';
				/*	Devido algumas interfaces de upload mudarem o mime type( uploadify, por exemplo)
					e alguns problemas loading magic finfo_open() seta-se o mime de acordo com a extensão passada */
				$midia['type'] = getMimeType($midiaInfo['extensao']);
				// usando getimagesize quando for imagens
				if (preg_match( '/image/', $midia['type'] ) || $midiaInfo['extensao'] == "swf")
				{
					$dados = getimagesize($midia['tmp_name']);
					if( $dados ){
						$mimetype = $dados['mime'];
						if( $dados[2] == 6 )
						{
							$mimetype = 'image/jpeg';
						}
					}
					else
					{
						$mimetype = 'dangerous/file';
					}
				}
				//  finfo_open fileinfo.dll enabled
				if (empty($mimetype) && function_exists('finfo_open'))
				{
					if ($f = @finfo_open(FILEINFO_MIME))
					{
						$mimetype = finfo_file( $f, $midia['tmp_name'] );
						$mimetype = explode( ';', $mimetype );
						$mimetype = trim($mimetype[0]);
						finfo_close($f);
					}
				}
				// usando a função mime_content_type 
				if (empty($mimetype) && function_exists('mime_content_type'))
				{
					$mimetype = @mime_content_type(realpath($midia['tmp_name']));
				}
				// todas desabilitadas ou falharam (forçamos o salvamento )
				if (empty($mimetype))
				{
					$mimetype = $midia['type'];
				}
				// a verificação se os resultados obtidos é igual ao conhecido
				if( $midia['type'] != $mimetype )
				{
					add_midia_msg( sprintf( 'O Sistema acredita que o arquivo pode ser perigoso [%s <> %s]', $midiaInfo['extensao'], $mimetype), 'error' );
					if( removeMidia( $midia_id ) )
					{ 
						add_midia_msg( 'Dados da mídia removidos devido riscos ao carregar arquivo!');
					}
					return $midia_id;
				}
				// assegurar que o type e o mimetype são o mesmo
				$midia['type'] = $mimetype;
			} // #end mimetype verification
			
			$dir  = sprintf( "%s/public/%s", BASE_PATH, $midiaInfo['tipo'] );
			$file = sprintf( "%s/%s-%s.%s", $dir, $midia_id, str2link($midiaInfo['titulo']), $midiaInfo['extensao'] );
			$files = array('admin' => sprintf("%s/%s-%s-admin.%s", $dir, $midia_id,  str2link($midiaInfo['titulo']), $midiaInfo['extensao']));
			foreach ($widths as $a => $v)
				$files[$a] = sprintf ("%s/%s-%s-%s.%s", $dir, $midia_id, str2link($midiaInfo['titulo']), $a, $midiaInfo['extensao']);

		// copia o arquivo (padrao para todos arquivos)		
			if (@copy( $midia['tmp_name'], $file))
			{
				add_midia_msg( 'Arquivo de mídia foi carregado com sucesso', 'success');
				// se for imagem criamos thumbs
				if (in_array($midiaInfo['extensao'], array('jpg','gif', 'jpeg', 'png'), true))
				{
					// geramos as copias, forçando a do admin
					$widths['admin'] = $heights['admin'] = 50;
					$useCrop['admin'] = "CM";
					$t=0;
					foreach($widths as $i => $width)
						$t += createImagem($file, $files[$i], $width, $heights[$i], $useCrop[$i]);
					
					if ($t)
						add_midia_msg("{$t} cópia(s) da imagem cadastrada(s)", 'success');
					
					// e verificamos se o arquivo original não excede 950px de largura (padrao blue print )
					$info = getimagesize($file);
					if( $info[0] > 950 && $reSize){
						$info[0] = 950;
						createImagem( $file, $file, 950 );
					}
					else if( $info[2] == 6 ) // verifica se o arquivo é bmp e convertemos para jpg
					{
						createImagem( $file, $file, $info[0] );
					}
					if( file_exists( $dir.'/watermark.png') )
					{
						//gerar watermarks
						$files[0] = $file;
						$widths[0] = $info[0];
						foreach($widths as $i => $width) 
						{
							// base que será escrita', marca dagua, porcentagem da largura que o water ocupara, transparencia
							IMG_addWaterMark($files[$i], $dir.'/watermark.png', 20, 50);
						}
					}
				}//fim copias
			}
			else
			{
				add_midia_msg( 'Falha ao tentar carregar arquivo de mídia!', 'error' );
				add_midia_msg( 'Verifique a existência da pasta ../public/'.$midiaInfo['tipo'].'/', 'error' );
				add_midia_msg( 'Verifique se tenho permissão para escrever nela', 'error' );
				if(removeMidia($midia_id ))
				{
					add_midia_msg( 'Dados da mídia removidos devido impossibilidade de carregar arquivo!');
				}
			}
		}
	}
	else
	{
		add_midia_msg( sprintf("Mídia não cadastrada pois, a extensão [%s] não é permitida!", $midiaInfo['extensao']), 'error' );
	}
	return $midia_id;
}
/**
 * Atualiza os dados da mídia e tenta renomeá-la se necessário.
 *
 * Retorna a mídia alterada
 *<code>
 *<?php
 *	//vamos recuperar  mídia de id 250 alterá-la para destaque e deixá-la de ordem 1
 *	$midia = getMidia( 250 ); // recupera a mídia 250
 *	if( count($midia) ) // se ela existe
 *	{
 *		$old = $midia[0];
 *		$midia[0]['destaque'] = 1;
 *		$midia[0]['ordem'] = 1;
 *		updateMidia($midia[0], $old);
 *	}
 *?>
 *</code>
 * @author     Rafael Benites <rbenites@gestaoativa.com.br>
 * @author     Diogo Campanha <diogo@gestaoativa.com.br>
 * @version    1.1, Created: 30/08/2010, LastModified: 30/09/2010
 * @param	   mixed $input um array com os novos dados da mídia
 * @param      mixed $oValue dados para verificarmos se o título da midia mudou, ou seja, necessário mudar o nome
 * @return	   mixed
 */
function updateMidia( $input, $oValue )
{
	$midias  = array();
	if( is_array($input) && is_array($oValue) )
	{
		foreach( $oValue as $i => $a )
		{
			$oValue[$i] = ($a);
			$t = array();
			foreach( $input as $j => $b )
			{
				$t[$j] = trim($b[$i]);
			}
			$midias[$i] = $t;			
			if( $t['titulo'] != $oValue[$i] )
			{
				$files = array( '', '-admin', '-a', '-b', '-c' );
				foreach($files as $f )
				{
					$path = getMidiaLink( $t['id'], $f, 'path');
					if( file_exists($path) )
					{
						// tentar garantir que podemos renomea-la
						$ext = getExtensao($path);
						$base = preg_replace( '/\/(\w|\-|\.)+$/', '', $path);
						$newname = sprintf( '%s/%d-%s%s.%s', $base, $t['id'], str2link($t['titulo']), $f, $ext);
						@rename( $path, $newname );
					}
				}
			}
			$the_action = 'Edit';
			set_ordem( $t, 'rb_midias', 'ordem', sprintf("tipo='%s' AND codigo=%d", $t['tipo'], $t['codigo']));
			_query( toQuery('rb_midias',$t) );
			add_midia_msg( sprintf('Dados da mídia [%s] atualizados', $t['titulo']), 'success' );
		}
	}
	return $midias;
}
/**
 * Recupera os dados das midias[id da midia ou codigo do item], tipo[modulo]
 *
 * Retorna as mídias ordenadas por destaque DESC, ordem DESC, id DESC
 *<code>
 *<?php
 *	$midias = getMidia( 101, 'paginas', 5 ); // recupera 5 mídias de uma página
 *	$midia = getMidia(250); // recupera os dados da mídia de id 250
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.0, Created: 30/08/2010
 * @param	  integer $codigo_or_id id da mídia ou o código de um elemento dentro da página
 * @param	  string $tipo tipo de midia[ modulo ]
 * @param	  integer $limit numero máximo de midias a serem recuperadas;
 * @param	  integer $inicial valor inicial para possível paginação;
 * @return	  mixed
 */
function getMidia( $codigo_or_id, $tipo = '', $limit = '', $inicial = 0 )
{
	$sql = "";
	if (is_numeric($codigo_or_id))
		$sql = sprintf("SELECT * FROM `rb_midias` WHERE `id`=%s", trim($codigo_or_id) );
	else
		return array();
	
	if (!empty($tipo))
		$sql = sprintf("SELECT * FROM `rb_midias` WHERE `codigo`='%s' AND `tipo`='%s' ORDER BY `destaque` DESC,`ordem` DESC,`id` DESC", trim($codigo_or_id), trim($tipo) );
	
	if (is_numeric($limit) && is_numeric($inicial))
		$sql .= sprintf( " LIMIT %d, %d", $inicial, $limit);

	return sqlQuery( $sql, 'assoc');
}
/**
 * Recupera os dados das mídias que pertencem a um módulo(tipo)
 *
 * Retorna as mídias ordenadas por codigo,destaque DESC, ordem DESC, id DESC
 *<code>
 *<?php
 *	// todas os pdf's e doc's dentro do módulo páginas
 *	$midias = getMidiaByTipo( 'paginas', array('pdf','doc') );
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.0, Created: 30/08/2010
 * @param	  string $tipo tipo de midia[ modulo ]
 * @param	  array $extensoes tipo de extensoes a serem recuperadas;
 * @param	  integer $limit numero máximo de midias a serem recuperadas;
 * @param	  integer $inicial valor inicial para possível paginação;
 * @return	  mixed
 */
function getMidiaByTipo( $tipo, $extensoes = array(), $limit = '', $inicial = 0 )
{
	if (!is_array($extensoes))
		$extensoes = (array)$extensoes;

	if (count($extensoes))
		$sql = sprintf( "SELECT * FROM `rb_midias` WHERE `tipo`='%s' AND ( 0 ", trim($tipo) );
	else
		$sql = sprintf( "SELECT * FROM `rb_midias` WHERE `tipo`='%s' AND ( 1 ", trim($tipo) );
	
	foreach ($extensoes as $extensao)
		$sql .= sprintf( " OR `extensao` = '%s'", strtolower($extensao) );
		
	$sql .= " ) ORDER BY `codigo`,`destaque` DESC, `ordem` DESC, `id` DESC";
	if (is_numeric($limit) && is_numeric($inicial))
		$sql .= sprintf( " LIMIT %d, %d", $inicial, $limit);
	
	return sqlQuery( $sql, 'assoc');
}
/**
 * Recupera midias associadas a um item ordenadas por uma condição recebida por parâmetro
 *
 * Retorna as mídias ordenadas pela condição que recebe(ordem DESC é a default).
 *<code>
 *<?php
 *	 // todas as mídias da página em ordem aleatória
 *	$midias = getMidiaOrdered( 101, 'paginas', 'RAND()' );
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   1.0, Created: 30/08/2010
 * @param	  integer $codigo codigo do item que possui a midia;
 * @param	  string $tipo tipo de midia[ modulo ]
 * @param	  string $condition a condição de 'order by' para recuperar a mídia
 * @return	  mixed
 */
function getMidiaOrdered( $codigo, $tipo, $condition = '`ordem` DESC' )
{
	if (is_numeric($codigo))
		$sql = sprintf( "SELECT * FROM `rb_midias` WHERE `id`=%s", trim($codigo) );
	else
		return array();
		
	if (!empty($tipo))
		$sql = sprintf( "SELECT * FROM `rb_midias` WHERE `codigo`='%s' AND `tipo`='%s'", trim($codigo), trim($tipo) );
	
	$sql .= sprintf( " ORDER BY %s", trim($condition) );
	return sqlQuery( $sql, 'assoc' );
}
/**
 * Recupera midias associadas a um item com a(s) extensão(ões) passadas
 *
 * Retorna as mídias ordenadas por destaque, ordem DESC, extensao.
 *<code>
 *<?php
 *	// todas os pdf's e doc's dentro de páginas
 *	$midias = getMidiaByExtensao( 101, 'paginas', array('pdf','doc') );
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.0, Created: 30/08/2010
 * @param	  integer $codigo codigo do item que possui a midia;
 * @param	  string $tipo tipo de midia[ modulo ]
 * @param	  array $extensoes tipo de extensoes a serem recuperadas;
 * @param	  integer $limit numero máximo de midias a serem recuperadas;
 * @param	  integer $inicial valor inicial para possível paginação;
 * @return	  mixed
 */
function getMidiaByExtensao( $codigo, $tipo , $extensoes, $limit = '', $inicial = 0 )
{
	if (!is_array($extensoes))
		$extensoes = (array)$extensoes;
	
	if (is_numeric($codigo))
		$sql = sprintf( "SELECT * FROM `rb_midias` WHERE `id`=%s", trim($codigo) );
	else
		return array();
	
	if (!empty($tipo))
		$sql = sprintf("SELECT * FROM `rb_midias` WHERE `codigo`='%s' AND `tipo`='%s' AND ( 0", trim($codigo), trim($tipo));

	foreach ($extensoes as $extensao)
		$sql .= sprintf( " OR `extensao` = '%s'", strtolower($extensao) );
	
	$sql .= " ) ORDER BY `destaque` DESC, `ordem` DESC, `extensao`, `id` DESC";
	if (is_numeric($limit) && is_numeric($inicial))
		$sql .= " LIMIT {$inicial}, {$limit}";
	
	return sqlQuery( $sql, 'assoc');
}
/**
 * Recupera todas as imagens ( png,gif,jpg e jpeg)
 *
 * Retorna as mídias ordenadas por destaque, ordem DESC, extensao.
 *<code>
 *<?php
 *	$midias = getImage( 101, 'paginas'); //todas as imagens da página de id 101
 *?>
 *</code>
 * @author    Rafael Benites <rbenites2gestaoativa.com.br>
 * @version   1.0, Created: 30/08/2010
 * @param     integer $codigo codigo do item que possui a midia;
 * @param     string $tipo tipo de midia[ modulo ]
 * @param     integer $limit numero máximo de midias a serem recuperadas;
 * @param     integer $inicial valor inicial para possível paginação;
 * @return    mixed
 */
function getImage( $codigo, $tipo, $limit = '', $inicial = 0 )
{
	return getMidiaByExtensao( $codigo, $tipo, array('jpg','gif','png','jpeg'), $limit , $inicial );
}
/**
 *  Recupera a maior ordem do conjunto de elementos
 *
 *uso:
 *<code>
 *<?php
 *	// recuperamos a maior prioridade do grupo de paginas de id 101
 *	$midias = getMaxMidiaOrdem( 101, 'paginas');
 * // maior prioridade do grupo que a mídia 250 faz parte
 *	$midias = getMaxMidiaOrdem( 250 ); 
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   1.0, Created: 30/08/2010
 * @param     integer $codigo_or_id codigo da midia ou codigo do item dentro de um modulo;
 * @param     string $tipo módulo ao qual o ítem pertence
 * @return    mixed
 */
function getMaxMidiaOrdem( $codigo_or_id, $tipo = '' )
{
	// recupera as midias
	$midias = getMidia($codigo_or_id, $tipo, 1);
	if (!empty($midias))
	{
		$max = sqlQuery( sprintf( "SELECT max(ordem) as max FROM rb_midias WHERE tipo='%s' AND codigo='%s'",
									$midias[0]['tipo'],
									$midias[0]['codigo'] ) );
		if (!empty($max))
			return $max[0]->max;
	}
	return 0;
}
/**
 *  Recupera os dados das midias e as remove retornando-as
 *
 *Os dados das mídias serão retornados, porém os arquivos serão removidos(suporte a midia c)
 *uso:
 *<code>
 *<?php
 *	// vamos apagar todas as mídias da página de id 101
 *	$midias = removeMidia( 101, 'paginas');
 *	echo count($midias). 'removidas';
 *	// remover a midia de id 250
 *	$midias = removeMidia( 250 );
 *	echo count($midias). 'removidas';
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   1.1, Created: 30/08/2010, LastModified: 30/09/2010
 * @param     integer $codigo_or_id id da mídia a ser removida, ou o código do ítem
 * @param     string $tipo módulo ao qual o ítem pertence
 * @return    mixed
 */
function removeMidia( $codigo_or_id, $tipo = '' )
{
	// recupera as midias 
	$midias = getMidia( $codigo_or_id, $tipo );
	// atualiza ordem quando estamos removendo somente um elemento
	if( empty($tipo) && count($midias) )
	{
		$upd = sqlQuery(	sprintf( "SELECT id, ordem FROM rb_midias WHERE ordem > %s AND tipo='%s' AND codigo= %s",
										$midias[0]['ordem'],
										$midias[0]['tipo'],
										$midias[0]['codigo']) );
		foreach( $upd as $up )
		{
			_query( toQuery( 'rb_midias', array( 'id' => $up->id, 'ordem' => ($up->ordem - 1) ) ) );
		}
	}
	foreach ($midias as $midia)
	{
	// tentativa de remoção dos possíveis arquivos
		@unlink (sprintf('%s/public/%s/%s-%s.%s', BASE_PATH, $midia['tipo'], $midia['id'], str2link($midia["titulo"]), $midia['extensao']));
		@unlink (sprintf('%s/public/%s/%s-%s-admin.%s', BASE_PATH, $midia['tipo'], $midia['id'], str2link($midia["titulo"]), $midia['extensao']));
		for ($i = 'a', $loop = true; $loop; $i++)
		{
			$file = sprintf( '%s/public/%s/%s-%s-%s.%s', BASE_PATH, $midia['tipo'], $midia['id'], str2link($midia["titulo"]), $i, $midia['extensao']);
			if (file_exists($file))
				@unlink ($file);
			else
				$loop = false;
		}
		// remoção na tabela
		$sql = sprintf( "DELETE FROM `rb_midias` WHERE `id`=%s ", $midia['id'] );
		_query($sql);
	}
	return $midias;
}
/**
 *  Recupera os dados das midias e as destaca retornando-as
 *
 *O valor passado será adicionado diretamente à mídia
 *uso:
 *<code>
 *<?php
 *	// Marcar como destaque as midias de ordem par e desmarcar as de ordem ímpar
 *	$midias = getMidiaOrdered( 101, 'paginas', 'ordem ASC'); // página
 *	foreach( $midias as $midia)
 *	{ 
 *		destacaMidia( $midia['id'], ($midia['ordem']%2) );
 *	}
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   1.0, Created: 30/08/2010
 * @param     integer $id id da mídia a ser alterada
 * @param     integer $valor valor da midia 1 para marcar como destaque 0 para desmarcar
 * @return    mixed
 */
function destacaMidia( $id, $valor = 1 )
{
	if( !is_numeric($valor) )
	{
		$valor = 1;
	}
	// recupera as midias
	$midias = getMidia( $id);
	if (count($midias))
	{
		_query( toQuery('rb_midias', array( 'id'=> $id, 'destaque' => $valor)) );
	}
	return $midias;
}
/**
 *  Recupera os dados das midias e aumenta e diminui a prioridade retornando-os
 *
 *O valor passado será adicionado ao atual da mídia
 *uso:
 *<code>
 *<?php
 *	// vamos inverter os dados de ordem das mídia (por exemplo midia a:3, b:2, c:1
 *	$midias = getMidiaOrdered( 101, 'paginas'); // página
 *	$val = count($midia);
 *	while( --$val > 0 )
 *	{ 
 *		ordemMidia( $midia['id'], $val*-1 );
 *	}
 *	//agora temos que c:1, b:2, a:3
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   1.0, Agosto 2010
 * @param     integer $id id da mídia a ser alterada
 * @param     integer $valor valor para ser adicionado a ordem atual
 * @return    mixed
 */
function ordemMidia( $id, $valor = 1 )
{
	if (!is_numeric($valor))
	{
		$valor = 1;
	}
	// recupera as midias
	$midias = getMidia( $id );
	if( count($midias) )
	{
		$max = getMaxMidiaOrdem( $midias[0]['codigo'], $midias[0]['tipo'] );
	// atualiza o valor das midias e chama o seta ordem
		$midias[0]['ordem']+=$valor;
	// garante o intervalo
		if( $midias[0]['ordem'] > $max )
		{
			$midias[0]['ordem'] = $max;
		}
		if( $midias[0]['ordem'] < 1 )
		{
			$midias[0]['ordem'] = 1;
		}
		set_ordem( $midias[0], 'rb_midias', 'ordem', sprintf("tipo='%s' AND codigo=%d", $midias[0]['tipo'], $midias[0]['codigo']));
		_query( toQuery( 'rb_midias', $midias[0] ) );
	}
	return $midias;
}
/**
 *  Exibe os dados das midias dentro do sistema administrativo
 *
 *	alguns tipos de midia tem ícones padrões, apenas para informar sua existência
 *uso:
 *<code>
 *<?php
 *	// recuperamos todas a midias da pagina
 *	$midias = getMidia( 101, 'paginas'); // midias da pagina sobre
 *	$string = '';
 *	foreach( $midias as $midia )
 *	{ 
 *		$string .= showMidia( $midia );
 *	}
 *	// string tem os div's formatados para o padrão do admin
 *	// com os thumbs e botoes de ação bem como os eventos javascript
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   1.003, Created: 30/08/2010, LastModified: 29/11/2010
 * @param     mixed $midia referencia para mídia array associativo ou id
 * @param     boolean $echo deve-se imprimir ou retornar os elementos(true)
 * @return    string
 */
function showMidia( $midia, $echo = true )
{
	if( is_numeric($midia) )
	{
		$midia = getMidia( $midia );
		return showMidia( $midia[0], $echo );
	}
	if( is_array($midia) )
	{
		switch($midia['extensao'])
		{
			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'gif':
				$thumb = sprintf( '<img class="ga-midia-admin-image" src="../public/%s/%s-%s-admin.%s" alt="Image" title="%s" />',
									$midia['tipo'],
									$midia['id'],
									str2link($midia['titulo']),
									$midia['extensao'],
									($midia['titulo']) );
				$lnk = sprintf( '<a href="%s" class="preview" title="Preview">', getMidiaLink($midia) ); 
				$thumb = $lnk . $thumb . '</a>';
			break;
			case 'lnk':
				$thumb = '<img class="ga-midia" src="includes/images/icons/http.png" alt="Link" title="Link">'; 
				$lnk = sprintf( '<a href="%s" class="previewfile" title="Preview">', getMidiaLink($midia) ); 
				$thumb = $lnk . $thumb . '</a>';
			break;
			case 'ytb':
				$thumb = sprintf('<img class="ga-midia" src="includes/images/icons/youtube.png" alt="Arquivo" title="%s" />', ($midia['titulo']) ); 
				$lnk = sprintf( '<a href="%s&amp;rel=0&amp;autoplay=1" class="preview iframe" title="Preview">', str_replace( 'embed/', 'v/', str_replace( 'watch?v=', 'v/', getMidiaLink($midia))) );
				$thumb = $lnk . $thumb . '</a>';
			break;
			case 'gmap':
				$thumb = sprintf('<img class="ga-midia" src="includes/images/icons/maps.png" alt="Arquivo" title="%s" />', ($midia['titulo']) ); 
				$lnk = sprintf( '<a href="%s" class="preview iframe" title="Preview">', getMidiaLink($midia) ); 
				$thumb = $lnk . $thumb . '</a>';
			break;
			case 'emb':
				$thumb = sprintf('<img class="ga-midia" src="includes/images/icons/embed.png" alt="Embed" title="%s" />', ($midia['titulo']) ); 
			break;
			case 'swf':
				$thumb = sprintf('<img class="ga-midia" src="includes/images/icons/swf.png" alt="Embed" title="%s" />', ($midia['titulo']) ); 
				$lnk = sprintf( '<a href="%s" class="preview swf" title="Preview">', getMidiaLink($midia) ); 
				$thumb = $lnk . $thumb . '</a>';
			break;
			default:
				$src = 'includes/images/icons/file.png';
				if( file_exists($esp = sprintf( '%s/ga-admin/includes/images/icons/%s.png', BASE_PATH, $midia['extensao'])) )
					$src = str_replace( BASE_PATH.'/ga-admin/', '', $esp );
				$thumb = sprintf( '<img class="ga-midia" src="%s" alt="Arquivo" title="%s" />', $src, ($midia['titulo']) ); 
				$lnk = sprintf( '<a href="%s" class="previewfile" title="Preview">', getMidiaLink($midia) ); 
				$thumb = $lnk . $thumb . '</a>';
			break;	
		}
		$maior = getMaxMidiaOrdem ($midia['id']);
	// base do corpo da midia
		$html = sprintf('<div class="span-3 midia-item" id="midia_cell_%s">', $midia['id']);
	// titulo da midia
		$html .= _resumo( $midia['titulo'], 11 );
	// wrapper para o meio do div
		$html .= '<div class="span-3 last midia-middle">';
	// Aumentar prioridade
		$left = '<img src="includes/images/icons/left-1.png" alt="&lt;" title="Aumentar Prioridade" />';
		if( $midia['ordem'] < $maior )
		{
			$left = sprintf( '<img class="midia-left" onclick="RB._ordemMidia(%s, 1)" src="includes/images/icons/left.png" alt="&lt;" title="Aumentar Prioridade" />', $midia['id'] );
		}
		$html .= $left;
	// adicionamos a midia
		$html .= $thumb;
	// diminuir prioridade
		$righ = '<img src="includes/images/icons/right-1.png" alt="&gt;" title="Diminuir Prioridade" />';
		if( $midia['ordem'] > 1 )
		{
			$righ = sprintf( '<img class="midia-right" onclick="RB._ordemMidia(%s, -1)" src="includes/images/icons/right.png" alt="&gt;" title="Diminuir Prioridade" /><br />', $midia['id'] );
		}
		$html .= $righ;
	// fim do wrapper
		$html .= '</div>';
		$html .= '<div class="span-3 last midia-bottom">';
	// destaque de midia
		$dest = sprintf('<img class="midia-star" onclick="RB._destaqueMidia(%s, 1)" src="includes/images/icons/star-1.png" alt="Marcar" title="Marcar como Destaque" />', $midia['id']);
		if( $midia['destaque'] == 1 )
		{
			$dest = sprintf('<img class="midia-unstar" onclick="RB._destaqueMidia(%s, 0)" src="includes/images/icons/star.png" alt="Desmarcar" title="Desmarcar como Destaque" />', $midia['id'] );
		}
		$html .= $dest;	
	// Edição de midia
		$edit = sprintf('<img class="midia-edit" onclick="RB._editMidia(%s)" src="includes/images/icons/edit.png" alt="Editar" title="Editar M&iacute;dia" />', $midia['id'] );
		$html .= $edit;
	// remoção da midia
		$remo = sprintf('<img class="midia-remove" onclick="RB._removeMidia(%s)" src="includes/images/icons/rem.png" alt="Remover" title="Remover M&iacute;dia" />', $midia['id'] );
		$html .= $remo;
	// fim do corpo
		$html .= '</div>';
		$html .= '</div>';
		if($echo)
		{
			echo $html;
			return '';
		}
		else
		{
			return $html;
		}
	}
	return false;
}
/**
 *  Exibe os dados das midias usado para o site<br>
 *	Faz uso de {@link gmapsEmbed()}, {@link simpleSWF()}, {@link embedYoutube()} e possivelmente {@link getMidia()}
 * 
 *uso:
 *<code>
 *<?php
 *	// recuperamos todas a midias da pagina
 *	$midias = getMidia( 101, 'paginas'); // midias da pagina sobre
 *	foreach( $midias as $midia )
 *	{
 *		//supondo que temos 'swf' e 'ytb' mandamos o terceiro parâmetro
 *		exibeMidia( $midia, 'a', array(300,200) );
 *	}
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   1.1, Created: 30/08/2010, LastModified: 30/09/2010
 * @param     mixed $midia referencia para mídia array associativo ou id
 * @param     string $which qual a mídia que deseja saber {admin, a, b, ''}
 * @param     mixed $config um array com dados de largura e altura respectivamente para usar em swf, semmidia e embed's youtube via link
 * @return    void
 */
	function exibeMidia( $midia, $which = "", $config = array() )
	{
		global $use_xhtml;
		if( !empty($which) )
			$which = '-'.trim($which, '-');
		if( is_numeric($midia) )
		{
			$midia = getMidia( $midia );
			return exibeMidia( $midia[0], $which, $config );
		}
		if( isset($midia['extensao']) )
		{
			switch( $midia['extensao'] )
			{
				case 'jpg':
				case 'jpeg':
				case 'png':
				case 'gif':
					$ext = $use_xhtml ? " /":""; 
					$url = getMidiaLink($midia, $which); 
					$inf = @getimagesize(getMidiaLink($midia,$which,'path'));
					$title = empty($midia['descricao'])?$midia['titulo']:$midia['descricao'];
					echo "<img src=\"{$url}\" alt=\"{$midia['titulo']}\" title=\"{$title}\" {$inf[3]} class=\"ga-midia-image\"{$ext}>";
				break;
				case 'ytb':
					if( $which == '-admin' )
					{
						echo '<img class="rb-midia" src="'.BASE_URL.'/ga-admin/includes/images/icons/youtube.png" alt="Youtube" title="Youtube" />'; 
					}
					else
					{
						embedYoutube( $midia, $which, $config );
					}
				break;
				case 'gmap':
					if( $which == '-admin' )
					{
						echo '<img class="rb-midia" src="'.BASE_URL.'/ga-admin/includes/images/icons/maps.png" alt="Google Maps" title="Google Maps" />'; 
					}
					else
					{
						gmapsEmbed( $midia, $which, $config );
					}
				break;
				case 'lnk':
					if( $which == '-admin' )
					{
						echo '<img class="rb-midia" src="'.BASE_URL.'/ga-admin/includes/images/icons/http.png" alt="Link" title="Link" />'; 
					}
					else
					{
						$desc = empty($midia['descricao']) ? $midia['titulo'] : $midia['descricao'];
						echo sprintf('<a id="rb-midia-%s" class="rb-midia-link" href="%s" title="%s">%s</a>', $midia["id"], $midia['link'], $midia['titulo'], $desc );
					}
				break;
				case 'swf':
					if( $which == '-admin' )
					{
						echo '<img class="rb-midia" src="'.BASE_URL.'/ga-admin/includes/images/icons/swf.png" alt="Embed" title="Embed" />'; 
					}
					else
					{
						simpleSWF( sprintf( '%s/public/%s/%s-%s.%s', BASE_URL, $midia['tipo'], $midia['id'],str2link($midia["titulo"]), $midia['extensao'] ), $config[0], $config[1] );
					}
				break;
				case 'emb':
					if( $which == '-admin' )
					{
						echo '<img class="rb-midia" src="'.BASE_URL.'/ga-admin/includes/images/icons/embed.png" alt="Embed" title="Embed" />'; 
					}
					else
					{
						echo $midia['link']; 
					}
				break;
				default:
					if( $which == '-admin' )
					{
						$src = sprintf('%s/ga-admin/includes/images/icons/file.png', BASE_URL);
						if( file_exists($esp = sprintf('%s/ga-admin/includes/images/icons/%s.png', BASE_PATH, $midia['extensao'])) )
							$src = str_replace(BASE_PATH, BASE_URL, $esp);
						echo sprintf('<img class="rb-midia" src="%s" alt="Arquivo" title="Arquivo" />', $src ); 
					}
					else
					{
						$desc = empty($midia['descricao']) ? $midia['titulo'] : $midia['descricao'];
						echo sprintf(	'<a class="ga-midia-file" href="%s/public/%s/%s-%s.%s" title="%s">%s</a>',
									BASE_URL, 
									$midia['tipo'],
									$midia['id'],
									str2link($midia["titulo"]),
									$midia['extensao'],
									($midia['titulo']),
									($desc) );
					}
				break;
			}
		}
		else
		{
			$extra = "";
			if( count($config) )
			{
				$extra = sprintf( ' width="%d" height="%d"', $config[0], $config[1] );
			}
			echo sprintf('<img src="%s/public/semmidia.png" class="ga-no-midia" alt="Sem M&iacute;dia" title="Nenhuma m&iacute;dia Cadastrada"%s%s>',BASE_URL, $extra,($use_xhtml?' /':'') );
		}
	}
/**
 *  Exibe o link absoluto(completo) para a midia
 * 
 *uso:
 *<code>
 *<?php
 *	// exibe o caminho completo para a midia de id 10(http)
 *	echo getMidiaLink(10);
 *	// é garantido que existe a mídia de tipo ='imagens' e codigo = 2
 *	$midia = getMidia( 2, 'imagens', 1); 
 *	// o path para uma midia
 *	echo getMidiaLink( $midia[0], 'admin', 'path'); 
 *	// exibe o path para a midia 10
 *	echo getMidiaLink(10, '', 'path');
 *?>
 *</code>
 *
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.2, Created: 30/08/2010, LastModified: 31/05/2011
 * @param     mixed $midia referencia para midai array associativo ou id
 * @param     string $which qual a mídia que deseja saber {admin, a, b, ''}
 * @param     string $type o tipo de link (path, url)
 * @return    string
 */
function getMidiaLink( $midia, $which = "", $type = 'url' )
{
	if (!empty($which))
		$which = '-'.trim($which, '-');
	$base_path = BASE_URL;
	if ($type == 'path' )
		$base_path = BASE_PATH;
		
	if (is_numeric($midia))
	{
		$midia = GetMidia($midia);
		return getMidiaLink( $midia[0], $which, $type );
	}
	switch ($midia['extensao'])
	{
		case 'lnk':
		case 'gmap':
			return $midia['link'];
		break;
		case 'ytb': // 'd' embed via iframe, embed via swf cc. 
			$vid_id = getYoutubeId($midia['link']);
			if ($which == '-d')
				return "http://www.youtube.com/embed/{$vid_id}";
			return "http://www.youtube.com/v/{$vid_id}";
		break;
		case 'emb':
		case '':
			return '';
		break; // somente imagens terão "miniaturas"
		case 'jpg':
		case 'jpeg':
		case 'png':
		case 'gif':
			$base_name = str2link($midia['titulo']);
			return "{$base_path}/public/{$midia['tipo']}/{$midia['id']}-{$base_name}{$which}.{$midia['extensao']}";
		break;
		default:
			$base_name = str2link($midia['titulo']);
			return "{$base_path}/public/{$midia['tipo']}/{$midia['id']}-{$base_name}.{$midia['extensao']}";
		break;
	}
}
/**
 *  Recupera o mime-type de acordo com uma extensão;
 * 
 *uso:
 *<code>
 *<?php
 *	echo getMimetype('jpg');// 'image/jpeg'
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.0, Created: 30/08/2010
 * @param     string $ext a extensão do arquivo
 * @return    string
 */
	function getMimeType($ext)
	{
		$mimes = array(
			'avi'   =>  'video/x-msvideo',
			'bmp'   =>  'image/bmp',
			'css'   =>  'text/css',
			'doc'   =>  'application/msword',
			'gif'   =>  'image/gif',
			'htm'   =>  'text/html',
			'html'  =>  'text/html',
			'jpeg'  =>  'image/jpeg',
			'jpg'   =>  'image/jpeg',
			'js'    =>  'application/x-javascript',
			'mpeg'  =>  'audio/mpeg',
			'mp3'	=>	'audio/mpeg',
			'pdf'   =>  'application/pdf',
			'php'   =>  'text/x-php',
			'png'   =>  'image/png',
			'ppt'   =>  'application/vnd.ms-office',
			'psd'   =>  'application/octet-stream',
			'rar'	=>	'application/x-rar',
			'swf'   =>  'application/x-shockwave-flash',
			'txt'   =>  'text/plain',
			'wav'   =>  'audio/x-wav',
			'wmv'	=>	'application/octet-stream',
			'xls'   =>  'application/vnd.ms-excel',
			'xml'   =>  'text/xml',
			'xsl'   =>  'text/xml',
			'zip'   =>  'application/zip',
		);
		return ( !isset($mimes[strtolower($ext)]) ) ? 'mimetype/not-allowed' : $mimes[strtolower($ext)];
	}
/**
 * Printa um código (x)thml válido para embed de swf's
 *uso:
 *<code>
 *<?php
 *	// exibir um vídeo swf
 *	$videos = getMidiaByExtensao( 2, 'videos', array('swf'), 1);
 *	foreach( $videos as $vid )
 *	{
 *		simpleSWF( getMidiaLink($vid), 480, 385);
 *	}
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.0, Created: 30/08/2010
 * @param     string $video caminho para o arquivo
 * @param     integer $width a largura do "object"
 * @param     integer $height a altura do object
 * @return    void
 */
	function simpleSWF( $video, $width = 300, $height = 200 )
	{
		global $use_xhtml;
		if( !is_numeric($width) )
		{
			$width = 300;
		}
		if( !is_numeric($height) )
		{
			$height = 200;
		}
		$extra = $use_xhtml?' /':'';
		print "<!--[if !IE]> -->
		<object type=\"application/x-shockwave-flash\"
			data=\"{$video}\" width=\"{$width}\" height=\"{$height}\">
			<!-- <![endif]-->
			<!--[if IE]>
			<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"
				codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0\"  width=\"{$width}\" height=\"{$height}\">
			<param name=\"movie\" value=\"{$video}\"{$extra}>
			<!--><!--ga-admin-vs-1.1 -->
			<param name=\"wmode\" value=\"transparent\"{$extra}>
			<param name=\"allowFullScreen\" value=\"true\"{$extra}>
		</object>
		<!-- <![endif]-->";
	}
// ##version 1.1
/**
 * Define qual mídia do tipo link estamos tratando
 *
 *uso:
 *<code>
 *<?php
 * //recuperamos os dados da mídia do tipo "link"
 *	$midia = midiaDetect( $_POST['link'] );
 *	print_r($midia); // array ( 0 => 'ytb', 1 => 'http://youtube.com/?v=*******', 'Youtube' );
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.0, Created: 30/09/2010, LastModified: 08/11/2010
 * @param     string $link o link recebido
 * @return    array na posição 0 a extensão e na posição 1 o valor a ser armazenado com "link" e 2 um título alternativo
 */
	function midiaDetect( $link )
	{
		$src = $link;
		// extrair os html se existirem
		@preg_match_all( '/src\=\"([^\"]+)\"/', stripslashes($link), $tst);
		if( count($tst[1]) )
			$src = $tst[1][0];
		// eh uma midia do youtube
		if( strpos($src, 'youtube') !== false )
		{
			return array( 'ytb', $src, 'Youtube' );
		}
		// midia do goggle maps
		else if ( strpos( $src, 'maps.google') !== false )
		{
			// deixar o link sem erros
			$src = htmlspecialchars_decode($src);
			// caso tentamos um fallback para o link
			if( strpos($src, 'output=embed') === false )
				$src .= '&output=embed';
			return array( 'gmap', htmlspecialchars($src), 'Google Map' );
		}
		//embed
		else if( strpos( $link, '<object') !== false || strpos( $link, '<emb') !== false || strpos( $link, '<iframe') !== false  )
		{
			return array( 'emb', $link, 'Embed Simples' );
		}
		// Link
		return array( 'lnk', $src, 'Link' );
	}
/**
 * Exibe um mapa do gmaps
 *
 *uso:
 *<code>
 *<?php
 *	//recuperamos os dados da midia
 *	$maps = getMidia( 105, 'paginas', 1 );
 *	if( count($maps) )
 *	{
 *		// ``embeda´´ usando jQuery
 *		gmapsEmbed( $maps[0], '', array(300,400) );
 *		// ``embeda´´ diretamente o iframe
 *		gmapsEmbed( $maps[0], '-a', array(300,400) );
 *		// devolve o link para integração com o fancyBox( .gaFancyBoxMap )
 *		gmapsEmbed( $maps[0], '-b' );
 *?>
 *</code>
 *
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.0, Created: 30/09/2010
 * @param     mixed $midia dados da mídia extraídos da tabela
 * @param     string $type o tipo de resposta
 * @param     mixed $dim largura(0) e altura(1) do embed
 * @return    void
 *
 */
	 function gmapsEmbed( $midia, $type = '', $dim = array() )
	 {
		if( empty($dim[0]) )
			$dim[0] = 300;
		if( empty($dim[1]) )
			$dim[1] = 400;
		switch( $type )
		{
			// link para fancybox
			case '-b':
			case '-c':
				$text = empty($midia['descricao']) ? $midia['titulo'] : $midia['descricao'];
				echo sprintf ('<a href="%s" title="Ver Mapa" class="gaFancyBox iframe">%s</a>', $midia['link'], $text);
			break;
			// faz embed simples printa iframe
			case '-a':
				echo sprintf( '<iframe src="%s" height="%d" width="%d" style="border:0 none"></iframe>', $midia['link'], $dim[1], $dim[0] );
			break;
			//faz inclusão usando jquery (válida mesmo no strict)
			default:
			?>
			<div id="gmaps_<?php echo $midia['id']?>"></div>
			<script type="text/javascript"> 
			// <![CDATA[
				jQuery(document).ready(function($){
					$('#gmaps_<?php echo $midia['id']?>')
						.html('<?php echo sprintf('<iframe src="%s" height="%d" width="%d" style="border:0 none"><', $midia['link'], $dim[1], $dim[0] )?>'+'/iframe>');
				});
			// ]]>
			</script>
	 <?php
			break;
		}
	}
/**
 * Recupera o id de um víde do youtube recebendo seu "embed",link ou "src" do frame
 * uso:
 *<code>
 *<?php 
 * // ecoar o id do video
 *	echo getYoutubeId('http://www.youtube.com/watch?v=nI67P9kGAMM&feature=player_embedded'); // nI67P9kGAMM
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@getsaoativa.com.br>
 * @category  Youtube
 * @version   1.0, Maio 2011
 * @param     string $link o link, embed ou src do vídeo do Youtube
 * @return    string
 * @todo      Garantir que o link é uma referência de vídeo válida do Youtube
 */
	function getYoutubeId($link)
	{
		$vid_id = '';
		if (preg_match('/v=(([^&]|$)+)/i', $link, $match))
			$vid_id = $match[1];
		else
		{
			preg_match('/(v|embed)\/(([^&|?]|$)+)/i', $link,$match);
			$vid_id = $match[2];
		}
		return $vid_id;
	}
/**
 * Exibição de dados do youtube, img, video, iframe
 *
 *uso:
 *<code>
 *<?php
 *	//recuperamos os dados da midia
 *	$video = getMidia( 102, 'paginas', 1 );
 *	if( count($video) )
 *	{
 *		// printa o código html do video( 'embeda')
 *		youtubeEmbed( $video[0], '', array(300,400) );
 *		// printa um thumb de tamanho "pequeno"
 *		youtubeEmbed( $video[0], '-a' );
 *		// printa um thumb de tamanho "grande"
 *		youtubeEmbed( $video[0], '-b' );
 *		// printa link para integração com o fancybox( ".gaFacyBoxYtb" )
 *		youtubeEmbed( $video[0], '-c' );
 *     // printa um link para usar a nova estrutura do youtube usando fancybox
 *		youtubeEmbed( $video[0], '-d');
 *	}
 *?>
 *</code>
 *
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version   1.2, Created: 30/09/2010, LastModified: 31/05/2011
 * @param     mixed $midia dados da mídia extraídos da tabela
 * @param     string $type o tipo de resposta
 * @param     mixed $dim largura(0) e altura(1) do embed
 * @return    void
 */
	function embedYoutube( $midia, $type = '' , $dim = array())
	{
		global $use_xhtml;
	// id do video
		$vid_id = getYoutubeId($midia['link']);
	// possíverl texxto usado como text do link
		$texto = empty($midia['descricao'])?$midia['titulo']:$midia['descricao'];
	// usar xhtml
		$extra = $use_xhtml ? " /":""; 
		switch ($type)
		{
			case '-d':
				echo "<a href=\"http://www.youtube.com/embed/{$vid_id}?rel=0\" class=\"gaFancyBox iframe\">{$texto}</a>";
			break;
			case '-c':
				echo "<a href=\"http://www.youtube.com/v/{$vid_id}\" class=\"gaFancyBoxYtb\">{$texto}</a>";
			break;
			case '-b':
				$rd = rand(0,100);
				echo "<img class=\"ga-admin-ytb-image\" id=\"ytb{$rd}_{$vid_id}\" src=\"http://img.youtube.com/vi/{$vid_id}/0.jpg\" alt=\"Youtube\"{$extra}>";
				//echo youtubeThumb( "http://www.youtube.com/?v={$vid_id}", 0 ); // removida
			break;
			case '-a':
				$rd = rand(0,100);
				echo "<img class=\"ga-admin-ytb-image\" id=\"ytb{$rd}_{$vid_id}\" src=\"http://img.youtube.com/vi/{$vid_id}/1.jpg\" alt=\"Youtube\"{$extra}>";
				//echo youtubeThumb( "http://www.youtube.com/?v={$vid_id}"); //removida
			break;
			default:
				simpleSWF("http://www.youtube.com/v/{$vid_id}?version=3&amp;?rel=0", $dim[0], $dim[1]);
			break;
		}
	}
/**
 * Exibe uma imagem pronta para usar o fancybox
 *
 * uso:
 *<code>
 *<?php
 *	//exibe a imagens da página 100 com o fancybox
 *	//exibe-se a imagem do tipo 'a' com link para original
 *	$imagens = getImage( 100, 'paginas');
 *	foreach( $imagens as $img ) 
 *		exibeMidiaFancy( $img, 'a' );
 * //Será atribuida a classe 'gaFancyBox' ou seja, deve se iniciar o script
 *	<script type="text/javascript" src="JS_URL/jquery....js"></script>
 *	<script type="text/javascript" src="JS_URL/fancybox....js"></script>
 *	<script type="text/javascript">
 *	// <![CDATA[
 *		jQuery(document).ready(function($){
 *		var options = {};
 *			$('.gaFancyBox').fancybox(options)
 *		});
 *	// ]]>
 *	</script>
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.0, Created: 30/09/2010
 * @param     mixed $midia referência para mídia array associativo
 * @param     string $which qual a mídia que será exibida {admin, a, b, c,''}
 * @param     string $add_rel adiciona o atributo 'rel' ao link em caso de galerias
 * @param     string $linkTo qual midia será linkada
 */
	function exibeMidiaFancy($midia, $which = 'a', $add_rel = '', $linkTo = '')
	{
		//existindo id titulo e extensao temos uma midia
		if (is_array($midia))
		{
		//mostraremos descrição ou o titulo
			$title = empty($midia['descricao']) ? $midia['titulo'] : $midia['descricao'];
		// o link para a midia apropriada
			$link = getMidiaLink($midia, $linkTo);
		// addiciona o "rel"
			if (!empty($add_rel))
				$add_rel = " rel=\"{$add_rel}\"";
		// somente algumas extensoes terão o midia fancy, outras serão ignoradas
			switch ($midia['extensao'])
			{
				case 'png':
				case 'gif':
				case 'jpg':
				case 'jpeg':
				case 'swf':
					echo "<a href=\"{$link}\" title=\"{$title}\" class=\"gaFancyBox\"{$add_rel}>";
					exibeMidia($midia, $which);
					echo "</a>";
				break;
				case 'ytb':
					$link = getYoutubeId($link);
					echo "<a href=\"http://www.youtube.com/embed/{$link}?rel=0\" title=\"{$title}\" class=\"gaFancyBox iframe\"{$add_rel}>";
					exibeMidia($midia, $which);
					echo "</a>";
				break;
				case 'txt':
					echo  "<a href=\"{$link}\" title=\"{$title}\" class=\"gaFancyBox iframe\"{$add_rel}>";
					echo $midia['titulo'];
					echo  "</a>";
				break;
				default:
					exibeMidia($midia, $which);
				break;
			}
		}
	}
/**
 * Função auxiliar para exibição de imagens
 *
 * Supri as necessidade não oferecidas por {@link exibeMidia()} como:
 * <ul>
 *	<li>Utilizar atributos no html gerado(por exemplo: 'class')</li>
 *</ul>
 *uso:
 *<code>
 *<?php
 * // atributos
 *	$atr = array('class'=> 'teste', 'onclick' => 'doIt()', 'id' => 'imagem_visivel');
 *	//busca imagens
 *	$imgs = getImage( 100, 'paginas', 1 );
 *	foreach ($imgs as $i )
 *		exibeImagem ($im, 'a', $atr);
 *?>
 *</code>
 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version   1.001, Created: 08/11/2010, LastModified: 26/10/2011
 * @param     mixed $midia referência para mídia array associativo
 * @param     string $which qual a mídia que será exibida {admin, a, b, c,''}
 * @param     mixed $attr os atributos extras a serem adicionados a imagem( qualquer atributo HTML )
 * @return    void
 */
	function exibeImagem ($midia, $which, $attr = '')
	{
		global $use_xhtml;
		$_attr = $img = '';
		if (is_array($attr))
		{
			foreach ($attr as $k => $v)
				$_attr .= sprintf (' %s="%s"', $k, $v);
		}
		else
			$_attr = $attr;
		
		if (is_array($midia))
		{
			$url = getMidiaLink( $midia, $which ); 
			$inf = @getimagesize( @getMidiaLink($midia,$which,'path') );
			if (!empty($url) && is_array($inf))
				$img = sprintf('<img src="%s" alt="%s" %s%s%s>', $url, $midia['titulo'], $inf[3], $_attr, ($use_xhtml?' /':''));
		}
		echo $img;
	}

/* End of file: midia.php */
/* Path: ga-admin/midia/midias.php */