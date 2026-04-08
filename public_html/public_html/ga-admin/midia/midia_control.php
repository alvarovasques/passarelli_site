<?php
/**
 * Midia::midia_control.php
 *
 * Arquivo que manipula as mídias do sistema
 *
 *<b>Informações</b>
 *<ol>
 *	<li>Arquivos que forem mandados para o servidor terão sua extensão de origem</li>
 * 	<li>Links serão separados em 'ytb', 'gmap', 'lnk', e 'emb' de acordo com a detecção do {@link midiaDetect() }</li>
 *</ol>
 *
 *<b>Para Salvar</b><br>
 * Recebe-se via "POST" os parâmetros 'midia' e 'midias' e as salva na tabela de midias;
 *<ul>
 *	<li><b>$_POST['midia']</b>: Guarda descrição e título de cada mídia enviada;</li>
 * 	<li><b>$_POST['midias']</b>: Guarda as informações dos links e embeds;</li>
 * 	<li><b>$_FILES['midias']</b>: Os arquivos postados;</li>
 *	<li><b>$_POST['interface']</b>: Paramêtro deve ser enviado quando uma interface de upload for usada;</li>
 *</ul>
 *
 *<b>Outras operações</b><br>
 * Já estão implementadas (todas via "ajax" e vem setadas em <b>$_GET['acao_midia']</b> ou <b>$_POST['acao_midia']</b>) as operações de:
 *<ul>
 *	<li><i>remove</i>
 *		<ul>
 *			<li><b>$_GET['id_midia']</b> - pode ser o id da mídia ou o código do ítem "apagar todos";</li>
 *			<li><b>$_GET['tipo']</b> - módulo ao qual a mídia está associado e o primeiro é o código do ítem (id dentro do módulo)</li>
 *		</ul></li>
 *	<li><i>destaca</i>
 *		<ul>
 *		<li><b>$_GET['id_midia']</b> - o id da mídia;</li>
 *		<li><b>$_GET['valor']</b> - destaque ou não 1 ou 0;</li>
 *		</ul></li>
 *	<li><i>ordena</i>
 *		<ul>
 *		<li><b>$_GET['id_midia']</b> - o id da mídia;</li>
 *		<li><b>$_GET['valor']</b> - destaque ou não 1 ou 0;</li>
 *		</ul></li>
 *	<li><i>update</i>
 *		<ul>
 *		<li><b>$_POST['input']</b> - novos dados das mídias (titulo,descricao, ordem, destaque, id);</li>
 *		<li><b>$_POST['oldvalue']</b> - mudou-se o título;</li>
 *		</ul></li>
 *	<li><i>listar</i>
 *		<ul>
 *		<li><b>$_GET['id_midia']</b> - o código do ítem (id dentro do módulo);</li>
 *		<li><b>$_GET['tipo']</b> - módulo ao qual a mídia está associado</li>
 *		</ul></li>
 * </ul>
 *
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     $Id: midia_control.php - rbenites - 2012-09-14 $
 * @package 	Midia
 * @filesource
 */

	if (isset($_GET['interface']) && $_GET['interface'] == 'valums-file-uploader') {
		$_POST = $_GET;
    }
	if (isset($_POST['interface']) && !empty($_POST['interface'])) {
		/**
		 * Arquivos básicos devido pois vindo por "ajax" ou "iframe"
		 */
		require_once dirname(dirname(__FILE__)) . '/includes/admin_config.php';
		if (file_exists($_POST['interface'].'/save.php')) {
			/**
			 * Pré-processamento por uma interface de upload
			 */
			include ($_POST['interface'].'/save.php');
		}
	}
	/**
	 * Funções relativas a mídia
	 */
	require_once dirname(__FILE__) . "/midia.php";
	
// define os tipos de midias que podem ser aceitas { default ( 'jpg', 'png', 'gif', 'jpeg' ) }
	if (!isset($allow_these)) {
		$allow_these = array( 'jpg', 'png', 'gif', 'jpeg','lnk','emb');
    }
	if (!is_array($allow_these)) {
		$allow_these = (array)$allow_these;
    }
// O arquivo original não será "resized" para 950 (imagem);
	if (!isset($reSize)) {
		$reSize = true;
	}
// Trata requisições ajax de ordenação, destaque e remoção de midias
	$acao = "";
	if (isset($_GET['acao_midia'])) {
		$acao = $_GET['acao_midia'];
    } else if (isset($_POST['acao_midia'])) {
		$acao = $_POST['acao_midia'];
	}
// açoes da mídia
	if (!empty($acao)) {
		$midia = trim($_GET['id_midia']);
		if (is_numeric($midia) || isset($_POST['oldvalue'])) {
			switch ($acao) {
				case 'remove':
					$_tipo = '';
					if (isset($_GET['tipo'])) {
						$_tipo = trim($_GET['tipo']);
					}
					$num = removeMidia($midia, $_tipo);
					add_midia_msg( sprintf('[%s] midia(s) removida(s)!', count($num) ), 'success' );
				break;
			
				case 'destaca':
					if (isset($_GET['valor'])) {
						$valor = trim($_GET['valor']);
					}
					$num = destacaMidia($midia,$valor);
					add_midia_msg( 'midia destacada!', 'success' );

				break;

				case 'ordena':
					if (isset($_GET['valor'])) {
						$valor = trim($_GET['valor']);
					}
					$num = ordemMidia($midia,$valor);
				break;
			
				case 'update':
					$num = updateMidia($_POST['input'], $_POST['oldvalue']);
				break;
					
				default: // listar
				if (isset($_GET['tipo'])) {
					$num = array (
						0 => array(
							'codigo' => $midia,
							'tipo'   => trim($_GET['tipo'])
							)
					);
				}
				break;
			}
			
			if (is_array($num) && count($num)) {
				$midiaView = array(
					'codigo' => $num[0]['codigo'],
					'tipo'	 => $num[0]['tipo']
				);
				array_midia_msg_to_html('success');
				/**
				 * fim do processamento "ajax" gera uma listagem
				 */
				include('midia_list.php');
			}
		} // midia "safe"
	} // ação

// salvando mídias
	if (isset($_POST['midia'])) {
//recebe os dados de descrição e titulo de cada midia "uploadeada";
		$midia = $_POST['midia'];
//recebe os prováveis links e embed's;
		$midias = array();	
		if (isset($_POST['midias'])) {
			$midias = $_POST['midias'];
        }
//Recebe os dados de cada arquivo "uploadeado";
		$files = array(
			'name' => array()
		);
		if (isset($_FILES['midias'])) {
			$files = $_FILES['midias'];
        }
		// garante quando o arquivo eh mandado como um campo normal
		if (is_array($files) && !is_array($files['name'])) {
			foreach ($files as $i => $f) {
				$files[$i] = array(
					0 => $f
				);
			}
		}

//O id a ser associado a midia;
		if (is_numeric($the_input['id'])) {
			$the_id = $the_input['id'];
			/* varremos os arquivos */
			foreach ($files['name'] as $i => $file) {
				if ($file != "" ) {
				// dados da midia
					$midiaInfo = array(	
						'extensao'	=> getExtensao($file),
						'titulo'	=> $midia['titulo'][$i],
						'ordem'		=> $midia['ordem'][$i],
						'descricao'	=> $midia['descricao'][$i],
						'tipo'		=> $the_module,
						'codigo'	=> $the_id
					);
				// informações recuperadas
					$midiaFile = array(	
						'name'		=>	$file,
						'tmp_name'	=>	$files["tmp_name"][$i],
						'type'		=>	$files["type"][$i]
					);
				// salva dados da midia
					saveMidia($midiaFile, $midiaInfo, $allow_these, $widths, $heights, $useCrop, $reSize);
				}
			}
			// varremos os links
			foreach ($midias as $i => $link) {
				if ($link != "") {
					$mDados = midiaDetect( $link );
				// dados da midia
					$midiaInfo = array(
						'extensao'	=> $mDados[0],
						'titulo'	=> $midia['titulo'][$i],
						'ordem'		=> $midia['ordem'][$i],
						'descricao'	=> $midia['descricao'][$i],
						'tipo'		=> $the_module,
						'codigo'	=> $the_id
					);
				///* dados de um link/embed 
					$midiaFile = array(
						'name'		=> $mDados[2],
						'tmp_name'	=> $mDados[1],
						'type'		=> 'lnk'
					);
				// salva dados da midia
					saveMidia ($midiaFile, $midiaInfo, $allow_these);
				}
			}
		} else  {
			// não podemos salvar imagens
			add_midia_msg('Mídias não salvas devido a erro de cadastro de um elemento');
		}
	} // post
	if (isset($_POST['interface']) && !empty($_POST['interface'])) {
		if (file_exists($_POST['interface'].'/response.php')) {
			/**
			 * Se o cadastro foi por uma interface e existe uma resposta especial para ela
			 */
			include($_POST['interface'].'/response.php');
		}
	} else 	{ // arquivos por post normal
		//adicionamos as mensagens de midia às do sitema 
		$the_array_msg['notice'] = array_merge( $the_array_msg['notice'], $the_midia_msg['notice']);
		$the_array_msg['success'] = array_merge( $the_array_msg['success'], $the_midia_msg['success']);
		$the_array_msg['error'] = array_merge( $the_array_msg['error'], $the_midia_msg['error']);
	}

/* End of File: midia_control.php */
/* Path: /ga-admin/midia/midia_control.php */ 