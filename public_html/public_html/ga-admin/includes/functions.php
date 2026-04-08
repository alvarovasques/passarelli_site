<?php
/**
 * Functions::functions
 *
 * Arquivo das funções básicas do sistema
 *
 * Aqui teremos as definições de todas as funções usadas no sistema administrativo
 *
 * @author		Diogo Campanha <diogo@gestaoativa.com.br>
 * @author		Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     $Id: includes/functions.php - 2012-06-26 03:00:00 rbenites $
 * @package 	Functions
 * @filesource
 */

 
 // ########## GLOBAIS ##########
	/**
	 * Define uma quebra de linha[win]
	 * @name $the_br
	 * @global string $the_br
	 */
		$the_br = "\r\n";
	/**
	 * Define uma simples tabulação[win]
	 * @name $the_tab
	 * @global string $the_tab
	 */
		$the_tab = "\t";
	/**
	 * Guardará as menssgens printáveis na execução atual
	 * deverá ser povoada usando add_msg()
	 * @name $the_array_msg
	 * @global mixed $the_array_msg
	 */
		$the_array_msg = array(
			'success' => array(),
			'error'   => array(),
			'notice'  => array(),
			'info'    => array()
		);
	/**
	 * Guarda todas mensagens de erros que devem ser avaliadas em produção[ erros de sql por exemplo ]
	 * Deve ser povoada usando add_debug_msg()
	 * name $debug_array_msg
	 * @global mixed $debug_array_msg
	 */
		$debug_array_msg = array();


 // ########## CATEGORY: UTILS ###########
    /**
     * Função que debuga uma variável utilizando a tag pre
     *
     * @param   mixed $var a variável a ser debugada
     * @param   boolean $kill matar o script após o debug
     * @return void
     */
    function pr ($var, $kill = false)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        if ($kill) {
            exit;
        }
    }

	/**
	 * Recupera o ip de quem acessa a página
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	echo get_ip(); // ecoa 127.0.0.1
	 *?>
	 *</code>
	 * @author   anonymous
	 * @version  1.0, Agosto 2010
	 * @category utils
	 * @param    void
	 * @return   string
	 */
		function get_ip()
		{
			$ip = ( isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown' );  
			$forward = ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : false );   
			return ( ($ip=='unknown' &&  $forward && $forward!='unknown' ) ? $forward : $ip); 
		}
	/**
	 * Gera uma chave única com 32 caracteres
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	geraHash(); // retorna algo similar a isso '120fae72a2c715d84ef50d836faff008';
	 *?>
	 *</code>
	 * @author   Antonio Coelho <antonio@gestaoativa.com.br>
	 * @version  1.0, Agosto 2010
	 * @category utils
	 * @param    void
	 * @return   string
	 */
		function geraHash()
		{
			$value1 = uniqid(rand());
			$value2 = uniqid(time());
			return  md5(sha1(crc32(md5(base64_decode($value1.$value2)).$value2)));
		}
	/**
	 * Deixa uma string no formato url amigável
	 *
	 * uso:
	 *<code>
	 *<?php
	 * // ecoa 'toda-acao-produz-uma-reacao'
	 *	echo str2link( 'Toda ação produz uma reação'); 
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category util
	 * @param    string $str a string a ser processada
	 * @return   string
	 */
		function str2link ($str)
		{
			return url_amigavel($str,'-');
		}
	/**
	 * Função alternativa à str2link(), com base nas ideias de {@link http://www.tabelaascii.com/}
	 * e /{@link http://snipplr.com/view.php?codeview&id=44313}
	 * produz o mesmo resultado.
	 * @author   Antonio Coelho <antonio@gestaoativa.com.br>
	 * @author   Rafael Benites <rbenites@gestaoativacom.br>
	 * @version  $Id: url_amigavel() 2011-05-27 16:00:00 antonio $
	 * @category utils
	 * @param    string $string o texto que se tornará amigável
	 * @param    string $slug o texto que separará o primeiro ou substituirá os não alfanuméricos
	 * @return   string nome 
	 * @todo     dar suporte aos caracteres usados em expressões regulares, .+()[], etc
	 */
		function url_amigavel ($string, $slug = '-')
		{
			$string = strtolower(utf8_decode($string));
		// Código ASCII das vogais
			$ascii['a'] = array_merge(range(224, 230), range(192, 198));
			$ascii['e'] = array_merge(range(232, 235), range(200, 203));
			$ascii['i'] = array_merge(range(236, 239), range(204, 207));
			$ascii['o'] = array_merge(range(242, 246), range(210, 214), array(216, 248));
			$ascii['u'] = array_merge(range(249, 252), range(217, 220));
		// Código ASCII dos outros caracteres
			$ascii['b'] = array(223);
			$ascii['c'] = array(231, 199);
			$ascii['d'] = array(208, 240);
			$ascii['n'] = array(241, 209);
			$ascii['y'] = array(253, 255, 221, 159);
			foreach ($ascii as $key=>$item) {
				$acentos = '';
				foreach ($item AS $codigo) $acentos .= chr($codigo);
				$troca[$key] = '/['.$acentos.']/i';
			}
		// troca os acentos
			$string = preg_replace(array_values($troca), array_keys($troca), $string);
		// adiciona o "slug"
			if ($slug) {
				// Troca tudo que não for letra ou número por um caractere ($slug)
				$string = preg_replace('/[^a-z0-9]/i', $slug, $string);
				// Tira os caracteres ($slug) repetidos
				$string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
				$string = trim($string, $slug);
			}
			return $string;
		}
	/**
	 * Pega somente uma parte de um texto caso este seja maior do que o desejado
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	_resumo( 'rafael benites', 2 );
	 *	// retorna 'ra...';
	 *	_resumo( 'rafael benites', 2, 'http://localhost/' );
	 *	// retorna 'ra<a href="http://localhost/" title="mais">...</a>';
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category utils
	 * @param    string $texto o texto a ser avaliado
	 * @param    integer $num número máximo de caracteres a retornados
	 * @param    string $link link para o qual os ... redirecionarão
	 * @return   string resumo com até ($num+3) caracteres
	 */
		function _resumo ($texto, $num = 150, $link = '')
		{
			if( !is_numeric($num) )
			{
				$num = 150;
			}
			$texto = utf8_decode($texto);
			if( strlen($texto) > $num)
			{
			// acabar com as entidades html
				$texto = html_entity_decode(str_replace("&nbsp;", " ", $texto));
			// garantir pelo menos uns espaço em branco entre tags e remove-as
				$texto = strip_tags(str_replace( '>', '> ', $texto ));
				if (strlen($texto) > $num)
					$texto = substr($texto, 0, $num);
			// adicionar link?
				if( !empty($link) )
					$texto .= sprintf( '<a href="%s" title="mais">...</a>', $link );				
				else
					$texto .= '...';
			}
			return utf8_encode($texto);
		}
	/**
	 * Função que devolve o "excerpt" de um texto, segue a ideia do wordpress
	 * Recebe um texto, remove qualquer html presente, e devolve o que for
	 * considerado palavras.
	 *<code>
	 *<?php 
	 *	$text = '<p>Olá mundo</p>';
	 *	$excp = _excerpt($text, 1, '[..]');
	 *  echo $excp; // "olá[..]"
	 *?>
	 *</code>
	 * @param   string $text  texto "raw" a ser processado
	 * @param   integer $num_of_words número de "palavras" a serem retornadas
	 * @param   string $read_more texto a ser adicionado caso o numero de "palavras" no $text exceda o necessário
	 * @return  string
	 * @author  Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version 1.001, Created: 06/04/2011, LastModified: 25/11/2011
	 */
		function _excerpt ($text, $num_of_words = 20, $read_more = '[..]')
		{
			if (!is_numeric($num_of_words))
				$num_of_words = 15;
			$text = preg_replace ('/<br(\s*)\/?>/', ' ', $text); 
			$parts = explode(' ', str_replace('&nbsp;', ' ', strip_tags($text)));
			if (count($parts) <= $num_of_words)
				return implode(" ", $parts);
			$j =0;
			foreach ($parts as $p)
			{
				if (!empty($p))
					$return[$j++] = $p;
				if ($j >= $num_of_words)
					break;
			}
			return implode(" ", $return).$read_more;
		}
	/**
	 * Retorna um número de strings de tabulação
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	_ident( 2 ); // equivalente a $the_tab.$the_tab
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category utils
	 * @param    integer $depth número de tabs a serem retornadas (1)
	 * @return   string
	 */
		function _ident ($depth = 1)
		{
			global $the_tab;
			$ident = '';
			for( $i=0; $i < $depth; $i++ )
				$ident .= $the_tab;
			return $ident;
		}
	/**
	 * Retorna todos os números com pelo menos 2 dígitos
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	_0( 2 ); // retorn '02'
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category utils
	 * @param    integer $num número a ser avaliado
	 * @return   string
	 */
		function _0 ($num)
		{
			return $num > 9 ? $num: '0'.$num;
		}
	/**
	 * Função que transforma um valor float em moeda(Reais).
	 * O separador de decimais será "," e serão 2 casas, e será
	 * usado o separador de milhares ".";
	 *<code>
	 *<?php
	 *	// converter o valor
	 *	echo _toMoeda("1.5698", true); // ecoa R$ 1,57
	 *	echo _toMoeda("156.98");       // ecoa 156,98
	 *	echo _toMoeda("uhul",true);    // ecoa R$ 0,00
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id:  Utils::_toMoeda() 2011-08-03 10:09:30 rbenites $
	 * @category Utils
	 * @param    float $valor valor a ser convertido para moeda
	 * @param    boolean $add_rs adicionar (R$) ao início do valor
	 * @return   string valor formatado com 2 casas decimais
	 */
		function _toMoeda($valor, $add_rs = false)
		{
			return ($add_rs ? 'R$ ':'') . number_format((float)$valor, 2, ",", ".");
		}
	/**
	 * Função que transforma uma string numérica para float.
	 *<br><b>Observaçao</b>: O separador de decimais deve ser ",", pois "." será ignorado;
	 *<code>
	 *<?php
	 *	// converter o valor
	 *	echo _toFLoat("R$ 1.123,25");// ecoa 1123.25
	 *	echo _toFLoat("1234.1234");  // ecoa 12341234
	 *	echo _toFLoat("olá");        // ecoa 0
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id:  Utils::_toMoeda() 2011-08-03 10:10:30 rbenites $
	 * @category Utils
	 * @param    string $valor valor a ser convertido para float
	 * @return   float
	 */
		function _toFloat($valor)
		{
			return (float)str_replace(",", ".", preg_replace("/[^\d|\,]*/", '', $valor));
		}
		
// ########## CATEGORY: MENSAGEM ##########


	/**
	 * Adiciona uma mensagem de erro para ser avaliada em produção.
	 * Faz uso da variável {@global $debug_array_msg}
	 *
	 * uso:
	 * <code>
	 *<?php
	 *	if (empty($the_conection))
	 *		add_debug_msg("Conexão com o banco não disponível", 'functions.php[line 336]' );
	 *?>
	 * </code>
	 *
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id: add_debug_msg() 2011-06-03 02:08:00 rbenites $
	 * @category mensagem
	 * @param    string $message a mensagem a ser adicionada
	 * @param    string $where Local onde a mensagem foi disparada
	 * @return   void
	 */
		function add_debug_msg ($message, $where)
		{
			global $debug_array_msg;
			array_push ($debug_array_msg, array($where, $message)); 
		}
	/**
	 * Mostra os erros que devem ser avaliados em tempo de produção, àqueles
	 * adicionados usando add_debug_msg().
	 * a estrutura de exibição é uma "tabela" e somente mostrará se existirem erros.
	 *
	 * uso:
	 * <code>
	 *<?php
	 *	show_debug_msg();
	 *?>
	 *</code>
	 *
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id: show_debug_msg() 2011-06-03 02:08:00 rbenites $
	 * @category mensagem
	 * @param    void
	 * @return   void
	 */
		function show_debug_msg()
		{
			global $debug_array_msg;
			if (!empty($debug_array_msg))
			{
				echo '<table><thead><tr><th>Origem</th><th>Mensagem</th></tr></thead>';
				echo '<tfoot><tr><td colspan="2">' . count($debug_array_msg).' mostradas</td></tr></tfoot>';
				echo '<tbody>';
				foreach ($debug_array_msg as $m)
					echo "<tr><td>{$m[0]}</td><td>{$m[1]}</td></tr>";
				echo '</tbody></table>';
			}
		}
	/**
	 * Adiciona uma mensagem para ser mostrada ao usuário
	 * Povoa a variável {@global $the_array_msg}
	 *
	 * uso:
	 * <code>
	 *<?php
	 *	add_msg('olá'); //adiciona uma mensagem de alerta olá
	 *	add_msg('<p>Erro</p>', 'error', true ); // adiciona uma mensagem (html) de erro
	 *	add_msg('uhul, deu certo', 'success' ); //adiciona uma mensagem de sucesso
	 *	add_msg('olá','notice' ); //similar ao primeiro exemplo
	 *?>
	 * </code>
	 *
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  1.2 $Id: add_msg() 2011-05-31 0:00:00 rbenites $
	 * @since    1.2 adicionado tipo "info" ao grupode mensagens
	 * @category mensagem
	 * @param    string $the_message a mensagem a ser adicionada
	 * @param    string $message_class o tipo da mensagem, baseado no blueprint css framework { (notice), error e success }
	 * @param    boolean $ishtml  flag para indicar se a mensagem contém (pode conter) html. (false)
	 * @return   booelan
	 */
		function add_msg ($the_message, $message_class = 'notice', $ishtml = false)
		{
			global $the_array_msg;
		// sem mensagem nada a fazer
			if( empty($the_message) )
				return false;
		// se não for html usamos o _allowQuotes() para evitar problemas de validação
			if( !$ishtml )
				$the_message = _allowQuotes($the_message);
			
			switch($message_class)
			{
				case 'success':
					array_push($the_array_msg['success'], $the_message);
				break;
				case 'error':
					array_push($the_array_msg['error']  , $the_message);
				break;
				case 'info':
					array_push($the_array_msg['info']  , $the_message);
				break;
				default: 
					array_push($the_array_msg['notice'] , $the_message);
				break;
			}
			return true;
		}
	/**
	 * Mostra todas as mensagens armazenadas para a classe passada
	 *
	 * uso:
	 * <code>
	 *<?php
	 *	array_msg_to_html(); // exibe todas as mensagens de alerta(notice)
	 *	array_msg_to_html('success'); // exibe todas as mensagens de sucesso
	 *	array_msg_to_html('error'); // exibe todas as mensagens de erro
	 *?>
	 *</code>
	 *
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  1.0, Agosto 2010
	 * @category mensagem	 
	 * @param    string $class a classe da mensagem (notice)
	 * @param    boolean $admin a mensagem deve receber a formatação para admin(true)
	 * @return   void
	 */
		function array_msg_to_html ($class = 'notice', $admin = true)
		{
			global $the_array_msg;
			$img = '<img src="includes/images/icons/close.png" onclick="jQuery(this).parent().slideUp(\'slow\',function(){jQuery(this).remove()})" style="cursor:pointer;position:absolute;top:-5px;right:-5px;padding:8px"  alt="close" />';
			switch($class)
			{
				case 'error':
					if (!empty($the_array_msg['error']))
					{
						if ($admin)
							echo sprintf('<div style="position:relative" class="error clear" id="error-box">%s %s</div>', implode('<br />', $the_array_msg['error']), $img);
						else
							echo sprintf('<div class="error clear" id="error-box">&nbsp;%s</div>', implode('<br />', $the_array_msg['error']));
					}
				break;
				case 'success':
					if (!empty($the_array_msg['success']))
					{
						if ($admin)
							echo sprintf('<div style="position:relative" class="success clear" id="success-box">%s %s</div>', implode('<br />', $the_array_msg['success']), $img);
						else
							echo sprintf('<div class="success clear" id="success-box">&nbsp;%s</div>', implode('<br />', $the_array_msg['success']));
					}
				break;
				case 'info':
					if (!empty($the_array_msg['info']))
					{
						if ($admin)
							echo sprintf('<div style="position:relative" class="info clear" id="info-box">%s %s</div>', implode('<br />', $the_array_msg['info']), $img);
						else
							echo sprintf('<div class="info clear" id="info-box">&nbsp;%s</div>', implode('<br />', $the_array_msg['info']));
					}
				break;
				default:
					if (!empty($the_array_msg['notice']))
					{
						if ($admin)
							echo sprintf('<div style="position:relative" class="notice clear" id="notice-box">%s %s</div>', implode('<br />', $the_array_msg['notice']), $img);
						else
							echo sprintf('<div class="notice clear" id="notice-box">&nbsp;%s</div>', implode('<br />', $the_array_msg['notice']));
					}
				break;
			}
		}

		
// ########## CATEGORY: DATABASE ##########	

	/**
	 * Função para executar queries.
	 *
	 * Executa qualquer tipo de query e possibilita o uso de mais de uma conexão com banco de dados
	 * Faz uso de {@global $the_connection}
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	// executa um update
	 *	$ts = _query("UPDATE `teste` SET ativo=1 WHERE id=5");
	 *?>
	 *</code>
	 * @todo     Fazer um filtro para estas queries
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  1.0, Created: 2011-06-03
	 * @category database
	 * @param    string $query a instrução a ser executada
	 * @return   integer o número de linhas afetadas pela consulta
	 */
		function _query ($query)
		{
			global $the_connection, $the_affected_value;
			$the_affected_value = $the_connection->exec ($query);
			if ($the_affected_value === false)
				add_debug_msg(_sqlError(), '_query()');
			return $the_affected_value !== false;
		}
	/**
	 * Tenta escapar os dados para evitar problemas com sql Injections, etc
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	_escape( "'ola'" ); // Deve retornar algo semelhante "\'ola\'"
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  2.0, Agosto 2010
	 * @since    2012-06-26 - utilizando-se do métod PDO::quote
	 * @param    string $string a string a ser escapada
	 * @return   string
	 */
		function _escape ($string)
		{
			global $the_connection;
			$string = stripslashes($string);
			try
			{
				return substr($the_connection->quote($string), 1, -1);
			}
			catch(PDOException $e)
			{
				return addslashes($string);
			}
		}
	/**
	 * Executa uma query( SELECT ) e retorna o fetch do resource
	 *
	 *uso:
	 *<code>
	 *<?php
	 * // retorna o resultado da consulta passada em uma array numérico
	 *	$testes = sqlQuery( 'SELECT * FROM table', 'row' );
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @category database
	 * @param	 string $query instrução de select a ser executada;
	 * @param	 string $fetch_type tipo de fetch a ser usado { object(default), array, both, assoc, row };
	 * @return   array
	 */
		function sqlQuery ($query, $fetch_type = 'object')
		{
			global $the_connection;
			$ret   = array();
			$query = trim($query);
			if (strtolower(substr($query, 0,6)) == 'select' || strtolower(substr(ltrim($query, '('), 0,6)) == 'select')
			{
				$result = $the_connection->query ($query);
				if ($result) {                    
                    switch (strtolower($fetch_type))
                    {
                        case 'assoc': $result->setFetchMode (PDO::FETCH_ASSOC); break;
                        case 'array':
                        case 'both':  $result->setFetchMode (PDO::FETCH_BOTH);  break;
                        case 'row':   $result->setFetchMode (PDO::FETCH_NUM);   break;
                        case 'object':
                        default:      $result->setFetchMode (PDO::FETCH_OBJ);	break;
                    }
                    while ($row = $result->fetch()) {
                        array_push ($ret, $row);
                    }
                }
			}
			return $ret;
		}
	/**
	 * Executa a query e já faz o fetch.
	 *
	 * <b>Observação</b>: sempre retornará somente um registro, logo, a função 
	 * força a adição do limitador na query.
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	// buscar a noticia de destaque
	 *	$noticia = sqlFetch("SELECT * FROM `rb_noticias` WHERE `destaque`=1 ORDER BY RAND()");
	 *	if ($noticia)
	 *  {
	 *		echo "
	 *			<h2>{$noticia->titulo}</h2>
	 *			{$noticia->texto}
	 *			<hr />
	 *			<p class=\"autor\">
	 *				{$noticia->autor}
	 *			</p>";
	 *	else
	 *		echo "<p> Nenhuma notícia marcada como destaque</p>";
	 *
	 *</code>
	 *
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id: database::sqlFetch() 2011-09-12 08:50 rbenites $
	 * @category database
	 * @param    string $query a query a ser executada
	 * @param	 string $fetch como será a resposta da query
	 * @return   mixed
	 */
		function sqlFetch($query, $fetch = "object")
		{
			global $the_connection;
			$object = sqlQuery("{$query} LIMIT 1", $fetch);
			if(!empty($object))
				return $object[0];
			return null;
		}
	/**
	 * Verifica se uma tabela existe na conexão atual
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	$post = table_exists('teste' ); 
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  1.0, Agosto 2010
	 * @category database
	 * @param    string $table o nome da tabela a ser avaliada
	 * @return   boolean
	 */
		function table_exists ($table)
		{
			global $the_connection;
			$result = $the_connection->query(sprintf("SHOW TABLES FROM `%s`", _db_base));
			$result->setFetchMode(PDO::FETCH_NUM);
			while ($row = $result->fetch())
				if ($row[0] == $table)
					return TRUE;
			return FALSE;
		}
	/**
	 * Verifica o número de linhas de uma consulta, de uma tabela ou mesmo de um resultado de {@link sqlQuery()}
	 *
	 *uso:
	 *<code>
	 *<?php
	 * // o numero de linahs da tabela teste, -1 em caso dela não existir
	 *	$num = num_rows('teste' ); 
	 * // retorna o numero de registros que atendem a query
	 *	$num = num_rows( 'select id from teste where detsaque=1' ); 
	 * // retorna 0
	 *	$num = num_rows( array() ); 
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  1.300, Agosto 2010, LastModified: 19/07/2012
	 * @category database
	 * @param    string $from o que deve ser avaliado
	 * @return   integer, -1 se a tabela não existir
	 */
		function num_rows ($from)
		{
			global $the_connection;
			if (is_array($from))
				return count($from);

			if (preg_match( '/\s/', $from))
			{
				try
				{
					$res = $the_connection->prepare($from);
					$res->execute();
					return $res->rowCount();
				}
				catch(PDOException $e)
				{
					return 0;
				}
				
			}
			if (table_exists($from))
			{
				$res = sqlQuery("SELECT count(id) AS num FROM `{$from}`");
				return $res[0]->num;
			}
			return -1;
		}
	/**
	 * Devolve um array mapeado com as colunas de uma tabela, com valores default ou '';
	 *
	 *uso:
	 *<code>
	 *<?php
	 * // retorna algo do tipo array( 'titulo' => '', id=>'', ativo => 0 );
	 *	$input = basic_input('teste');
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  1.0, Agosto 2010
	 * @category database
	 * @param    string $table nome da tabela em questão
	 * @return   mixed
	 */
		function basic_input ($table)
		{
			global $the_connection;
			$the_input = array();
			$sql = sprintf("SHOW COLUMNS FROM `%s`", $table);
			$rs = $the_connection->query($sql);
			$rs->setFetchMode (PDO::FETCH_ASSOC);
			while ($arr = $rs->fetch())
				$the_input[$arr['Field']] = $arr['Default'] != NULL ? $arr['Default'] : '';
			return $the_input;
		}
	/**
	 * Devolve um array mapeado com as colunas de uma tabela e com seu tipo como valor
	 *
	 *uso:
	 *<code>
	 *<?php
	 * // array( 'titulo' => 'varchar(200)', 'destaque' => 'int(1)', 'id' = 'int(11)' );
	 *	$input = get_columns('teste');
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  1.0, Agosto 2010
	 * @category database
	 * @param    string $table nome da tabela em questão
	 * @return   mixed
	 */
		function get_columns ($table)
		{
			global $the_connection;
			$the_input = array();
			$sql = sprintf("SHOW COLUMNS FROM `%s`", $table);
			$rs = $the_connection->query($sql);
			$rs->setFetchMode (PDO::FETCH_ASSOC);
			while ($arr = $rs->fetch())
				$the_input[$arr['Field']] = $arr['Type'];
			
			return $the_input;
		}
	/**
	 * Transforma um array numa query SQL (insert/update)
	 *
	 *<b>Observações</b>
	 *<ol>
	 *	<li>note que é necessário que os indices do array sejam as colunas da tabela, </li>
	 *	<li>Se existir o indice[id] setado com um valor numérico, considera-se um update, um insert cc.}</li>
	 *</ol>
	 *<code>
	 *<?php
	 *	$teste = array( "titulo" => "teste", "id" => 1 );
	 *	$sql = toQuery("rb_teste", $teste); 
	 * // "UPDATE `rb_teste` SET `titulo` = 'teste' WHERE `id`=1"
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbnenites@gestaoativa.com.br>
	 * @author   Diogo Campanha <diogo@gestaoativa.com.br>
	 * @version  $2011-09-12: database::toQeury() rbenites $
	 * @since    2011-09-12: possibilidade de forçar inserção	 
 	 * @category database
	 * @param	 string $table a tabela onde será executada a query
	 * @param	 mixed  $elems o array a ser usada na construção da query
	 * @param    boolean $forceInsert força a criação de query de inserção
	 * @return   string a query
	 */
		function toQuery ($table, $elems, $forceInsert = false)
		{
			if (!is_array ($elems))
				$elem = array( $elems => $elems );
		// se ja existir um 'id' numerico então tentaremos um update
			if (is_numeric($elems['id']) && !$forceInsert)
			{
				$sql = sprintf("UPDATE `%s` SET %%s WHERE `id`=%s", $table, $elems['id']);
				unset($elems['id']);
				$part = "";
				foreach($elems as $column => $value )
				{		
					$part .= sprintf( ",`%s` = '%s'", $column, _escape($value) );		
				}
				return sprintf($sql, substr($part, 1));
			}
			else	// não deixar o usar o id 
				if (!$forceInsert)
					unset($elems['id']);
			
			// insert cc
			$sql = sprintf("INSERT INTO `%s` ( %%s ) VALUES ( %%s )", $table);
			$part1 = $part2 = "";
			foreach( $elems as $column => $value )
			{
				$part1 .= sprintf(',`%s` ', $column);
				$part2 .= sprintf( ",'%s' ",_escape($value) );
			}
		// cada parte tem uma virgula a mais do que deveria
			return sprintf($sql, substr($part1, 1), substr($part2, 1));
		}
	/**
	 * Função para criação da query de select
	 *
	 *<code>
	 *<?php
	 *	// recuperar dados de uma notícia vindas por GET
	 *	if (isset($_GET['noticia']))
	 *	{
	 *		$query = toSelect("rb_noticias", $_GET['noticia']);
	 *		$noticia = sqlQuery($query);
	 *	}
	 *?>
	 *</code>
	 *
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id: database::toSelect() 2011-08-11 08:50 rbenites $
	 * @category database
	 * @param    string $table a tabela na qual a query será gerada
	 * @param    mixed $where condições que deverão ser satisfeitas
	 * @param    mixed $fields os campos que devem ser retornados
	 * @param    boolean $like consulta será com like ou equal(=)
	 * @return   string query formada com os dados recebidos na entrada
	 */
		function toSelect($table, $where, $fields = '*', $like = false)
		{
		// condições a serem atendidas
			if (!is_array($where)) // id sempre será numérico!?
				$where = array('id' => (int)$where);
		// campos que serão retornados	
			if (is_array($fields))
				$fields = "`" . implode("`, `", $fields) . "`";			
		// montagem da query
			$query = "";
			foreach ($where as $col => $val)
			{
				$val = _escape($val);
				$query .= ($like) ?" AND `{$col}` LIKE '%{$val}%'" : " AND `{$col}`='{$val}'";
			}
			return "SELECT {$fields} FROM `{$table}` WHERE ". substr($query, 5);
		}
	/**
	 * Cria um select baseado no número de elementos dentro da tabela informada
	 *
	 *<b>observações</b>
	 *<ol>
	 *	<li>Se for uma ação de add, é o número de lementos +1, número de elementos cc</li>
	 *	<li>podemos usar uma "query" ao invés da tabela</li>
	 *</ol>
	 *<code>
	 *<?php
	 *	cria_select_ordem( 'ordem', 'rb_teste', 1 )
	 *	cria_select_ordem( 'ordem', 'select id FROM rb_teste WHERE ativo = 1', 2 );
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @author   Diogo Campanha <diogo@gestaoativa.com.br>
	 * @version  1.0, Agosto 2010
	 * @category database
	 * @param	 string $name nome que o selecte receberá  <select name="input[$name]" id="input_$name">
	 * @param	 string $table a tabela ou a query
	 * @param	 array $cValue valor selecionado
	 * @return   void	 
	 */
		function cria_select_ordem ($name, $table , $cValue = '')
		{
			global $the_action;
			$num = num_rows($table);
			$num += ($the_action == "Add") ? 1 : 0;
			if (empty($cValue))
				$cValue = $num;
			$arr = array();
			for ($i=1; $i<=$num;$i++)
				$arr[] = $i;
			cria_select($name, $arr, $arr, $cValue);
		}
	/**
	 * Atualiza os dados dos itens para que o valor deste item seja único
	 *
	 *<b>observações</b>
	 *<ol>
	 *	<li>Se existirem valores maiores ou iguais a $input[$column], eles serão incrementados de um</li>
	 *	<li>se valores não numéricos forem supridos, eles serão o max()+1 ou 1</li>
	 *</ol>
	 *<code>
	 *<?php
	 *	set_ordem( $input, 'rb_teste', 'ordem', 'destaque=1');
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @author   Diogo Campanha
	 * @version  $Id: 2011-11-25 rbenites $
	 * @param    mixed $input dados recebidos que serão tratados ou o id do individuo
	 * @param    string $table a tabela a ser trabalhada
	 * @param    string $column a coluna que controla a ordem
	 * @param    string condição"WHERE" se for necessário agrupar os elementos
	 * @return   void
	 * @category database
	 */
		function set_ordem ($input, $table, $column, $group = '1')
		{
			global $the_action;
			if (is_numeric($input)) { // id do elemento
				$tst = sqlQuery(sprintf("SELECT `id`, `%s` FROM `%s` WHERE `id`=%s", $column, $table, $input), 'assoc');
				if (!empty($tst)) {
					$input = $tst[0];
				} else {
					return -1;
                }
			}
			if (!is_numeric($input[$column]) || !isset($input[$column])) {
			// se nao tiver um valor atribuimos o maximo
				$max = sqlFetch("SELECT COUNT(`{$column}`)+1 AS `novo` FROM `{$table}` WHERE {$group}");
				$input[$column] = $max ? $max->novo : 1;
			}
			$return = $input[$column];
			// busca por algum elemento com esse dado de ordem
			$elem = sqlQuery (sprintf( "SELECT * FROM `%s` WHERE `%s`='%s' AND %s", $table, $column, $input[$column], $group), 'assoc');
			// existe algum elemento com essa ordem 
			if (!empty($elem)) {
				$elem = $elem[0];
				// caso o elemento não seja ele mesmo
				if ($elem['id'] != $input['id'] || $the_action == 'Remove' ) {
					// Quando a acao é remover somente diminuimos em um cada elemento maior que eu, ou seja colocamos ele em ultimo
					if ($the_action == 'Remove') {
						$input[$column] = num_rows($table) + 1;
					}
					if ($input['id'] != '') {
						$atual = sqlQuery( sprintf( "SELECT `%s` FROM `%s` WHERE `id`=%s", $column, $table, $input['id']),'row' );
						$atual = $atual[0][0];
					} else {
						$atual = num_rows($table) + 1;
						if( $group != '1') {
							$atual = num_rows(sprintf('SELECT * FROM `%s`WHERE %s', $table, $group)) + 1;
						}
					}
					// vamos aumentar a ordem
					if ($input[$column] > $atual) {
						$sql = sprintf( "SELECT `id`, `%s` FROM `%s` WHERE `%s`> %s AND `%s`<= %s AND %s", $column, $table, $column, $atual, $column, $input[$column], $group );
						$increment = -1;
					} else { //diminuir
						$sql = sprintf( "SELECT `id`, `%s` FROM `%s` WHERE `%s`< %s AND `%s`>= %s AND %s", $column, $table, $column, $atual, $column, $input[$column], $group );
						$increment = 1;
					}
					// atualizamos os elementos
					$elems = sqlQuery( $sql, 'assoc' );	
					foreach ($elems as $elem) {
						$sql = toQuery( $table, array( 'id' => $elem['id'], $column => $elem[$column] + $increment ) );
						_query($sql);
					}
				} // else apenas atualizacao e minha prioridade não mudou
			} // else o espaço ta vazio td certo =P
			return $return;
		}
	/**
	 * Função que aplica a função trim a todos elementos de um array e trata os inputs diferentes
	 *
	 *<b>Observações</b>
	 *<ol>
	 *	<li>campos de nome 'senha', 'resenha' e 'password' serão hasheados com md5</li>
	 *	<li>campos de nome 'data', 'quando', 'data_inicial' e 'data_final' serão convertidos para 'yyyy-mm-dd'</li>
	 *	<li>campos de nome 'hora', 'hora_inicial' e 'hora_final' serão verificados por {@link ajustaHora()}</li>
	 *</ol>
	 *uso:
	 *<code>
	 *<?php
	 *	$inputs = array( 'data' => '11/10/2001', 'senha' => 'teste' );
	 *	$test = _post( $inputs ); // $test recebe algo similar a 
	 *	// array( 'data' => '2001-10-11', 'senha' => '698dc19d489c4e4db73e28a713eab07b')
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @author   Diogo Nascimento <diogo@gestaoativa.com.br>
	 * @version  $Id: _post() 2010-09-09 10:00:00 rbenites $
	 * @category database
	 * @param    array $inputs elemento a ser "trimmed"
	 * @return   array
	 */
		function _post ($inputs)
		{
			$datas  = array('data','quando','data_inicial','data_final');
			$horas  = array('hora','hora_inicial','hora_final');
			$senhas = array('senha','password','resenha');
			if (!is_array($inputs))
				$inputs = (array)$inputs;
			foreach ($inputs as $i => $input)
			{
				if(in_array($i, $senhas, true))
					$inputs[$i] = md5($input);
				else if(in_array($i, $datas, true))
					$inputs[$i] = inverteData($input, 'sql');
				else if(in_array($i, $horas, true))
				{
					$inputs = ajustaHora($inputs, $i);
					$inputs[$i] = formataHora($inputs[$i]);
				}
				if(!is_array($inputs[$i]) && !is_object($inputs[$i]))
					$inputs[$i] = trim($inputs[$i]);
			}
			return $inputs;
		}
	/**
	  * Recupera o último id inserido na conexão ativa, se existir;
	  *
	  *<code>
	  *<?php
	  *	// executar
	  *		$query = "INSERT INTO `teste` (`titulo`, `data`) VALUE ('teste', '2011-09-09')";
	  *		if (_query($query)) // executa query
	  *			echo _lastId(); // echoa o "id" que a última inserção resultou
	  *?>
	  *</code>
	  *
	  * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	  * @version  $Id: database::_lastId() 2011-08-11 08:50 rbenites $
	  * @category database
	  * @param    void
	  * @return   integer último valor inserido, 0 se nenhuma operação de "insert" executada, -1 caso de erro
	  */
		function _lastId()
		{
			global $the_connection;
			if (is_object($the_connection))
				return $the_connection->lastInsertId();
			return -1;
		}
	 /**
	  * Recupera o número de registros afetados pela última query, na conexão ativa se existir
	  *
	  *<code>
	  *<?php
	  *	// query
	  *		$query = "DELETE FROM `teste` WHERE `categoria`=3";
	  *		if (_query($query)) // executa query
	  *			echo _affectedRows(); // echoa o numero de linhas afetadas pela query anterior
	  *?>
	  *</code>
	  *
	  * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	  * @version  $Id: database::_affectedRows() 2011-08-11 08:50 rbenites $
	  * @category database
	  * @param    void
	  * @return   integer número alterado, 0 se nenhuma linha afetada pela última query, -1 caso de erro
	  */
		function _affectedRows()
		{
			global $the_affected_value;
			return $the_affected_value;
		}
	/**
	 * Função que mapeia o último erro de sql
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id: database::_sqlError() 2011-09-09 10:27:00 rbenites $
	 * @category database
	 * @return   mensagem de erro
	 */
		function _sqlError ()
		{
			global $the_connection;
			$err = $the_connection->errorInfo();
			return isset($err[2])?$err[2]:"";
		}

 // ########## CATEGORY: HTML ##########
	/**
	 * Ecoa um comando de 'window.location' em javascript
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	_location('home.php'); // direciona o documento para home 
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $2011-10-22- _location() 21:15:00 rbenites $
	 * @category html
	 * @param    string $url o endereço que será usando para o direcionamento
	 * @return   void;
	 */
		function _location ($url)
		{
			echo "
			<script type=\"text/javascript\">
			// <![CDATA[
				window.location.href='{$url}';
			// ]]>
			</script>
			";
		}
 	/**
	 * Ecoa um simples 'window.alert' com o valor passado
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	_alert( 'olá' ); // printa um script para "alertar" 'olá'
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id: _alert() 2011-06-04 21:30:00 rbenites $
	 * @param    string $text valor a ser "alertado"
	 * @return   void
	 */
		function _alert ($text)
		{
			if (is_array($text))
				$text = implode( ", ", $text);
			$text = _escape(utf8_encode(html_entity_decode($text)));
			echo "
				<script type=\"text/javascript\">
				// <![CDATA[
					alert('{$text}');
				// ]]>
				</script>
			";
		}
	/**
	 * Cria um select com name = input[$param1] e id= input_$param1
	 *
	 * uso:
	 *<code>
	 *<?php
	 *  //ecoa um select com três options e largura 150
	 *	cria_select( 'teste', array(1,2,3), array('yes', 'no', 'maybe'), 3, 'width="150"' );
	  // ecoa um select
	 *	cria_select( 'ativo', array(0,1), array('não','sim'), $the_input['ativo'] );
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @author   Diogo Campanha <diogo@gestaoativa.com.br>
	 * @version  $Id: cria_select() 2011-06-04 22:52:25 rbenites $
	 * @category html
	 * @param    string $field o usado para criação do name e id do select
	 * @param    mixed $vals contém os value's dos option's  que formarão o select
	 * @param    mixed $txts contém os text's dos option's e serão associados na mesma ordem que $vals
	 * @param    string $selected valor que será selecionado por padrão (deverá estar dentre os $vals)
	 * @param    string $attr atributos html para serem adicionados ao select
	 * @return   void	
	 */
		function cria_select ($field, $vals, $txts, $selected = '', $attr = '')
		{
			if (!empty($attr))
				$attr = ' '.trim($attr);			
			echo "<select name=\"input[{$field}]\" id=\"input_{$field}\"{$attr}>";
			if (!is_array($vals))
				$vals = (array)$vals;			
			if (!is_array($txts))
				$txts = (array)$txts;			
			foreach ($vals as $ind => $val)
			{
				$sel = ($val == $selected) ? ' selected="selected"' : ''; 
				echo "<option value=\"{$val}\"{$sel}>{$txts[$ind]}</option>";
			}
			echo "</select>";
		}
	/**
	 * Cria um select com name = input[$param1] e id= input_$param1 de valores numéricos<br>
	 * <b>Nota</b>: será possível apenas criação de selects "crescentes", ou seja, $end >= $start 
	 * uso:
	 *<code>
	 *<?php
	 *	// cria um select de 0 a 10
	 *		cria_num_select('teste', 10);
	 *	// cria um select de 40 até 50 com valor 43 selecionado
	 *	// e adiciona a função doSomething() no evento onChange
	 *		cria_num_select('teste', 50, 40, 43,'onchange="doSomething(this)"');
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @author   Diogo Campanha <diogo@gestaoativa.com.br>
	 * @version  $Id: cria_num_select() 2010-08-31 15:00:00 diogo, rbenites $
	 * @category html
	 * @todo     Possibilidade de select decrescente.
	 * @param    string $campo o usado para criação do name e id do select
	 * @param    integer $end valor numérico máximo do select, (inclusive)
	 * @param    integer $start valor numérico inicial (0)
	 * @param    string $sel valor inicialmente selecionado
	 * @param    string $atr atributos html para serem adicionados ao select
	 * @return   void
	 */
		function cria_num_select ($campo, $end, $start = 0, $sel = '', $atr =  '')
		{
			$var = array();
			for ($i = $start; $i <= $end; $i++)
				$var[] = _0($i);
			
			cria_select ($campo, $var, $var, $sel, $atr);
		}
	/**
	 * Gera um select com o resultado de uma query (SELECT)
	 * 
	 * <b>Nota</b>: Necessário que a query selecione pelo menos 2 colunas, a primeira será o ``value´´ e a segunda o ``text´´ dos options
	 *<code>
	 *<?php
	 * // ecoa um select que terá rb_teste.codigo como value e rb_teste.data como text e
	 *	cria_select_from_query('teste', 'SELECT `codigo`, `data` FROM `rb_teste` ORDER BY data');
	 *?>
	 *</code>
	 * @author   Rafael Benites <renites@gestaoativa.com.br>
	 * @author   Diogo Campanha <diogo@gestaoativa.com.br>
	 * @version  $Id: cria_select_from_query() 2011-06-04 22:48:00 rbenites $
	 * @category html
	 * @param	 string $name o nome do campo que deve ser mandado para "post"(input[name]);
	 * @param	 string $query a query que será executada para formação do select
	 * @param	 string $selected o valor inicialmente setado
	 * @param    mixed $attrs os possiveis atributos para o select gerado
	 * @return 	 void
	 */
		function cria_select_from_query ($name, $query, $selected = '', $attrs = '')
		{
			$rows = sqlQuery($query, 'row');
			$vals = array("");
			$texts = array("-- selecione --");
			foreach ($rows as $row)
			{
				$vals[] = $row[0];
				$texts[] = $row[1];
			}
			cria_select ($name, $vals, $texts, $selected, $attrs);
		}
	/**
	 * Gera um select com o campo ``id´´ da tabela ($table) como value dos options e
	 * o campo passado($field) como ``text´´. Faz uso de cria_select_from_query()<br>
	 * <b>Nota</b>: Necessário a existência do campo ``id´´ em `$table` para funcionamento.
	 * uso:
	 *<code>
	 *<?php
	 * // cria um select de páginas, usando titulo como texto
	 *		cria_select_from_table('pagina','rb_paginas','titulo');
	 * // cria um select de categorias, começando sempre com a categoria ``teste´´ selecionada
	 * // supondo que o ``id´´ da categoria ``teste´´ é a 2
	 *		cria_select_from_table('categoria','rb_categorias','titulo', 2);
	 * // Cria um select de páginas, com a página de ``id´´ 100  sempre selecionada
	 * // e ainda somente as págians que podem possuir imagens.
	 *		cria_select_from_table('pagina','rb_paginas','titulo',100,'temimagem=1');
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @author   Diogo Campanha <diogo@gestaoativa.com.br>
	 * @version  $Id: cria_select_from_table() 2011-06-04 23:05:55 rbenites $
	 * @category html
	 * @param    string $name o usado para criação do name e id do select(input[$name])
	 * @param    string $table qual tabela será usada na consulta
	 * @param    string $field qual coluna será o text dos options
	 * @param    string $selected valor que será selecionado por padrão
	 * @param    string $group uma condição "WHERE" caso for necessário agrupar os registros da tabela
	 * @param    string $attr atributos html para serem adicionados ao select
	 * @return   void
	 */
		function cria_select_from_table ($name, $table, $field, $selected = '', $group = '1', $attr = '')
		{
			if(empty($group))
				$group = 1;
			$_sql = "SELECT `id`, `{$field}` FROM `{$table}` WHERE {$group} ORDER BY `{$field}`, `id`";
			cria_select_from_query($name,$_sql,$selected,$attr);
		}
    /**
	 * Cria um select com name = $name e id= str2link($name,'_')
	 *
	 * uso:
	 *<code>
	 *<?php
	 *  //ecoa um select com três options e largura 150
	 *	cria_select_ext('contato[teste]', array(1,2,3), array('yes', 'no', 'maybe'), 3, 'width="150"');
	 * // ecoa um select#contato_teste[name=contato[teste]]
	 *	cria_select_ext('ativo', array(0,1), array('não','sim'), $the_input['ativo']);
     * // select#ativo[name=ativo] 
	 *?>
	 *</code>
	 * 
	 *
	 * @category html
	 * @param    string $name o usado para criação do name e id do select
	 * @param    mixed $values contém os value's dos option's  que formarão o select
	 * @param    mixed $texts contém os text's dos option's e serão associados na mesma ordem que $vals
	 * @param    string $selected valor que será selecionado por padrão (deverá estar dentre os $vals)
	 * @param    string $attributes atributos html para serem adicionados ao select
	 * @return   void	
	 */
        function cria_select_ext($name, $values, $texts, $selected = '', $attributes = "")
        {
            $select_id = url_amigavel($name, '_');
            echo "<select name=\"{$name}\" id=\"{$select_id}\"{$attributes}>";
            foreach ($values as $ind => $val)
            {
                $select = $val == $selected ? " selected=\"selected\"":"";
                echo "<option value=\"{$val}\"{$select}>{$texts[$ind]}</option>";
            }
            echo "</select>";
        }
    /**
     * Gera um select com o resultado de uma query (SELECT). Com name = $name e id= str2link($name,'_')
     * 
     * <b>Nota</b>: Necessário que a query selecione pelo menos 2 colunas, a primeira será o ``value´´ e a segunda o ``text´´ dos options
     *<code>
     *<?php
     * // ecoa um select que terá rb_teste.codigo como value e rb_teste.data como text e
     *	cria_select_from_query('teste', 'SELECT `codigo`, `data` FROM `rb_teste` ORDER BY data');
     * // select#teste[name=teste]
     *?>
     *</code>
     *
     * @param	 string $name o nome do campo que deve ser mandado para "post"(input[name]);
     * @param	 string $query a query que será executada para formação do select
     * @param	 string $selected o valor inicialmente setado
     * @param    mixed $attrs os possiveis atributos para o select gerado
     * @return 	 void
     */
        function cria_select_from_query_ext($name, $query, $selected = "", $attributes = "")
        {
            $select_id = url_amigavel($name, '_');
            echo "<select name=\"{$name}\" id=\"{$select_id}\"{$attributes}>";
            $options = sqlQuery($query, "row");
            echo "<option value=\"\"> -- selecione -- </option>";
            foreach ($options as $opt)
            {
                $select = $opt[0] == $selected ? " selected=\"selected\"":"";
                echo "<option value=\"{$opt[0]}\"{$select}>{$opt[1]}</option>";
            }
            echo "</select>";
        }
	/**
	 * Gera um select com o campo ``id´´ da tabela ($table) como value dos options e
	 * o campo passado($field) como ``text´´. Faz uso de cria_select_from_query()<br>
     * Com name = $name e id= str2link($name,'_')
	 * <b>Nota</b>: Necessário a existência do campo ``id´´ em `$table` para funcionamento.
	 * uso:
	 *<code>
	 *<?php
	 * // cria um select de páginas, usando titulo como texto
	 *		cria_select_from_table('pagina','rb_paginas','titulo');
	 * // cria um select de categorias, começando sempre com a categoria ``teste´´ selecionada
	 * // supondo que o ``id´´ da categoria ``teste´´ é a 2
	 *		cria_select_from_table('categoria','rb_categorias','titulo', 2);
	 * // Cria um select de páginas, com a página de ``id´´ 100  sempre selecionada
	 * // e ainda somente as págians que podem possuir imagens.
	 *		cria_select_from_table('pagina','rb_paginas','titulo',100,'temimagem=1');
	 *?>
	 *</code>
	 *
	 * @param    string $name o usado para criação do name e id do select(input[$name])
	 * @param    string $table qual tabela será usada na consulta
	 * @param    string $field qual coluna será o text dos options
	 * @param    string $selected valor que será selecionado por padrão
	 * @param    string $group uma condição "WHERE" caso for necessário agrupar os registros da tabela
	 * @param    string $attributes atributos html para serem adicionados ao select
	 * @return   void
	 */
        function cria_select_from_table_ext($name, $table, $field, $selected = '', $group = '', $attributes = '')
        {
            if(empty($group))
                $group = 1;
            $_sql = "SELECT `id`, `{$field}` FROM `{$table}` WHERE {$group} ORDER BY `{$field}`, `id`";
            cria_select_from_query_ext ($name, $_sql, $selected, $attributes);
        }

	/**
	 * Cria um select com name = input[$param1] para hora e  e id= input_$param1 de valores numéricos
	 *
	 * Importante dizer que serão dois select's um com name input[$param1][0] para hora e input[$param1][1] para minuto
	 *
	 * uso:
	 *<code>
	 *<?php
	 * // cria um select de horas cm 10:30 selecionado
	 *	cria_select_hora( 'teste', '10:30' ); 
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @author   Diogo Campanha <diogo@gestaoativa.com.br>
	 * @version  $Id: cria_select_hora() 2011-06-04 23:20:00 rbenites $
	 * @category html
	 * @param    string $name o usado para criação do name e id do select
	 * @param    string $hora valor da hora para iniciar os select's
	 * @return   void
	 */
		function cria_select_hora ($name, $hora='12:00')
		{
			global $the_hour;
			if (empty($hora))
				$hora = $the_hour;
			$hora = explode( ':', $hora );
			echo "<select name=\"input[{$name}][0]\" id=\"input_hora_{$name}\">";
			for($i=0; $i<= 23; $i++)
				echo sprintf('<option value="%s"%s>%s</option>',  _0($i),($i==$hora[0]? 'selected="selected"':''), _0($i));
			
			echo "</select>&nbsp;";
			echo "<select name=\"input[{$name}][1]\" id=\"input_minuto_{$name}\">";
			for($i=0; $i<= 59; $i++)
				echo sprintf('<option value="%s"%s>%s</option>', _0($i),($i==$hora[1]? 'selected="selected"':''), _0($i));
			echo "</select>";
		}
	/**
	 * Cria um "checkbox" que sempre mandará dados ao servidor,
	 * e será "checked" e "unchecked" de acordo com o valor inicial.
	 *uso:
	 *<code>
	 * // criar um checkbox
	 *	cria_checkbox("teste",1,0,1); // sempre checkado por ``default´´
	 *</code>
	 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version   $Id: cria_checkbox() 2011-09-12 13:16:00 rbenites $
	 * @category  html
	 * @param     string $field será usado para compor name e id do campo enviado (input[field] e input_field
	 * @param     string $checkedV valor a ser enviado quando o checkbox "checked"
	 * @param     string $uncheckedV valor a se enviado quando checkbox "unchecked"
	 * @param     string $val o valor inicialmente "checked"
	 * @return    void;
	 */
		function cria_checkbox ($field, $checkedV = 1, $uncheckedV = 0, $val = 0)
		{
			global $use_xhtml; // é explicitamente definido pelo "midia/midia.php"
			$extra   = isset($use_xhtml)?($use_xhtml?' /':''):' /';
			$checked = "";
			if ($val == $checkedV)
				$checked = ' checked="checked"';
			else
				$val = $uncheckedV;
			echo "<input type=\"hidden\" name=\"input[{$field}]\" id=\"hidden_{$field}\" value=\"{$val}\"{$extra}>
				<input id=\"input_{$field}\" type=\"checkbox\"{$checked}{$extra}>
				<script type=\"text/javascript\">
				// <![CDATA[
					jQuery(function(){
						$('#input_{$field}').change(function(){
							$('#hidden_{$field}').val(this.checked?'{$checkedV}':'{$uncheckedV}');
						});
					});
				// ]]>
				</script>";
		}
	/**
	 * Função para criar um campo de resumo no admin com contador,
	 * cria um textarea sem editor e um span que abriga o número de caacteres do primeiro.
	 * recebendo um terceiro parâmetro numérico trava a quantidade de caracteres;<br>
	 * <b>Nota</b>: Se for necessário estilizar os elementos as classes .resumoText e .resumoCounter
	 * são adicionadas ao textarea e ao span respectivamente.
	 *uso:
	 *<code>
	 *<?php
	 *  // criar um campo de resumo
	 * 		cria_resumo('resumo',$the_input['resumo']);
	 * // cria um campo de resumo que não pode ultrapassar de 100(cem) caracteres
	 *		cria_resumo('resumo',$the_input['resumo'],100);
	 * ?>
	 *</code>
	 * 
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id: cria_resumo() 2011-06-05 03:00:00 rbenites $
	 * @category html
	 * @param    string $name o nome que será usado no textarea(input[$name])
	 * @param    string $val o valor inicial do textarea
	 * @param    string/integer $limit caso seja necessário limitar o número de caracteres do textarea
	 * @return   void
	 */
		function cria_resumo ($name, $val = '',$limit = '')
		{
			// backspace, tab, del, home, end, left, up, right, down arrow
			$eventsList = array(
				'keydown' => "function(event){
								var v = $(this).val().length;
								if (v >= {$limit} && \$.inArray(event.keyCode,[8,9,46,35,36,37,38,39,40])==-1)
									return false;
								\$('#counter_{$name}').html(v);
							}",
				'keyup'   => "function(event){
								\$('#counter_{$name}').html($(this).val().length);
							}",
				'blur'    => "function(event){
								\$('#counter_{$name}').html($(this).val().length);
							}"
			);
			if (!is_numeric($limit))
				unset($eventsList['keydown']);
			else
				$val = substr($val,0, $limit);	
			$val = _allowQuotes($val);
			echo "
				<textarea rows=\"10\" cols=\"100\" class=\"gaNoEditor resumoText\" id=\"input_{$name}\" name=\"input[${name}]\">{$val}</textarea>
				<span id=\"counter_{$name}\" class=\"resumoCounter\"></span>
				<script type=\"text/javascript\">
				// <![CDATA[
					jQuery(function($){
						$('#counter_{$name}').html($('#input_{$name}').val().length);
						$('#input_{$name}')";
			foreach($eventsList as $evt => $fn)
			echo "
							.{$evt}({$fn})";
			echo "
					});
				// ]]>
				</script>
			";
		}

// ########## CATEGORY: VALIDATION #########

	/**
	 * Função para permitir uso de quotes(") em input's ou para aplicar entidades html as string's(utf8)
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	_allowQuotes( 'olá"'); // retorna 'olá&quot;'
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.1, Agosto 2010, LastModified:10/03/2011
	 * @category validation
	 * @param    string $value valor a ser "entitizado"
	 * @return   string
	 */
		function _allowQuotes ($value)
		{
			return htmlspecialchars($value);
		}
	/**
	 * Função que aplica a função trim a todos elementos de um array
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	$test = trimArray( $inputs ); // $test recebe $inputs "trimmed"
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  1.0, Agosto 2010
	 * @category validation
	 * @param    array $inputs elemento a ser "trimmed"
	 * @return   array elemente "trimmed"
	 */
		function trimArray ($inputs)
		{
			if (!is_array($inputs))
				$inputs = (array)$inputs;
				
			foreach ($inputs as $i => $input)
			{
				if (!is_array($input) && !is_object($input))
					$inputs[$i] = trim($input);
			}
			return $inputs;
		}
	/**
	 * Função que verifica se uma certa entrada tem elementos vazios
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	$post = array('nome'=>'','email'=>'teste@teste.com');
	 *	echo temVazio($post); // ecoa '0'
	 *	echo temVazio($post,"nome,email"); // ecoa nome
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @author   Diogo Campanha <diogo@gestaoativa.com.br>
	 * @version  1.0, Agosto 2010
	 * @category validation
	 * @param    mixed $input um array que será avaliado
	 * @param    mixed $required indices obrigatorios
	 * @param    boolean $add_id o índice id pode ser vazio
	 * @return   boolean
	 */
		function temVazio ($input, $required, $add_id = false)
		{
			if (!is_array($input))
				$input = (array)$input;
				
			if (!is_array($required))
				$required = explode(',',$required);

		// em caso de novo id's sempre serão vazios
			if ($add_id)
				$required[] = 'id';

			foreach ($input as $i => $inpt)
			{
				if (trim($inpt) == '' && in_array($i, $required, true))
					return $i;
			}
			return false;
		}
	/**
	 * Verifica se um email passado é válido (user@servidor);
	 *
	 * A verificação é se o email se encontra em uma formatação válida, não se de fato existe;
	 *uso:
	 *<code>
	 *<?php
	 *	$post = valida_email('teste@teste.com' ); // 1
	 *	$post = valida_email('teste@teste' ); // 0
	 *?>
	 *</code>
	 * @author   anonymous
	 * @version  1.0, Agosto 2010
	 * @category validation
	 * @param    string $email o email a ser avaliado
	 * @return   boolean
	 */
		function valida_email ($email)
		{
			return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email);
		}
	/**
	 * Verifica se um data é valida(dd-mm-yyyy), usando o checkdate
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	$post = valida_data('10-10-2010' ); // 1
	 *	$post = valida_data('29-02-2010' ); // 0
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  1.1, 21/06/2011
	 * @category validation
	 * @param    string $data a data a ser avaliada
	 * @return   boolean
	 */
		function valida_data ($data)
		{
			if (preg_match ('/\d{2}[-\/]\d{2}[\/-]\d{4}/', $data))
			{
				$data = explode('-', str_replace('/', '-', $data));
				return checkdate ($data[1],$data[0],$data[2]);
			}
			return false;
		}
	/**
	 * verifica a existência de http na frrente de algum link
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	_http( 'localhost' ); // retorna 'http://localhost';
	 *	_http( 'http://localhost' ); // retorna 'http://localhost';
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category validation
	 * @param    string $link link que será verificado
	 * @return   string
	 */
		function _http ($link)
		{
			if (substr( $link, 0, 4 ) != 'http')
				$link = "http://{$link}";
			return str_replace('&', '&amp;', $link);
		}
	/**
	 * Função que valida se um valor de moeda está correto. (Reais)
	 *<code>
	 *<?php
	 *	// converter o valor
	 *	if(valida_moeda("1.233.365")):   // avalia como verdadeiro
	 *	if(valida_moeda("1.233.65")):    // avalia como falso
	 *	if(valida_moeda("R$ 1.123,25")): // avalia como verdadeiro
	 *	if(valida_moeda("R$ 1,123.25")): // avalia como falso
	 *?>
	 *</code>
	 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version  $Id:  validation::valida_moeda() 2011-08-03 10:10:30 rbenites $
	 * @category Validation
	 * @param    string $valor valor a ser validado
	 * @return   boolean
	 */
		function valida_moeda($valor)
		{
			// testar
			$formats = array(
				'/^(R\$\s*)?((\d{1,3})(\.\d{3})*(\,\d{2})?)$/', //formatado 9{1,3}(.999)*(,99)?
				'/^(R\$\s*)?((\d+)(\,\d{2})?)$/'// formato 9*(,99)?
			);
			foreach ($formats as $format)
			{
				if (preg_match($format, $valor))
					return true;
			}
			return false;
		}
		
// ########## CATEGORY: DATE ##########

	/**
	 * Recebe uma data e devolve o inverso, ou no formato passado
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	echo inverteData( '2000-02-02' ); //retorna algo do tipo 02-02-2000
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category date
	 * @param    string $data  um valor de data válido
	 * @param    string $padrao formato a ser utilizado{ '', br, sql }
	 * @return   string
	 */
		function inverteData ($data, $padrao ='')
		{
			if( empty($data) )
				return ($padrao == 'sql')?'0000-00-00':'';
			
			$data = explode(' ', $data);
			$con = $padrao == 'br' ? '/' : '-';
			$data = explode ('-', str_replace('/', '-', $data[0]));
			foreach($data as $i => $v)
				$data[$i] = (strlen($v) < 2 ) ? "0{$v}" : $v;
			
			if ($padrao != '')
			{
				if (valida_data(implode( '-', $data)))
				{
					if ($padrao == 'br')
						return implode($con, $data);
				}
				else
				{
					if( $padrao != 'br' )
						return implode($con, $data); 
				}
			}
			return $data[2].$con.$data[1].$con.$data[0];
		}
	/**
	 * Retorna uma data por extenso no padrão br
	 *
	 *uso:
	 *<code>
	 *<?php
	 *  // retorna algo do '01 de Agosto de 2010'
	 *	$dat = data2str( $the_date );
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category date
	 * @param    string $data data a ser escrita
	 * @return   string
	 */
		function data2str ($data)
		{
			if (empty($data))
				return '';
			
			$data = inverteData($data, 'br');
			$data = explode( '/', $data );
			return sprintf( '%s de %s de %s', $data[0], nomeMes($data[1]), $data[2] );
		}
	/**
	 * Devolve uma hora formatada
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	formataHora( $the_now, 'h:i'); //retorna algo do tipo 1:10
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category date
	 * @param    string $hora  um valor de hora valido
	 * @param    string $formato formato a ser utilizado (h,i,s, letras maiúscula terão um 0 para valores < 10)
	 * @return   string
	 */
		function formataHora ($hora, $formato = 'h:i:s')
		{
			global $the_hour;
			if (empty($hora))
				$hora = $the_hour;

			$hora = explode( ':', $hora );
			if (count($hora) == 2)
				$hora[2] = '01';
			$r = '';
			$i = 0;
			while(  $i < strlen($formato) )
			{
				switch( $formato{$i} )
				{
					case 'h': $r .= $hora[0];  break;
					case 'H': $r .= _0($hora[0]);  break;
					case 'i': $r .= $hora[1]; break;
					case 'I': $r .= _0($hora[1]); break;
					case 's': $r .= $hora[2]; break;
					case 'S': $r .= _0($hora[2]); break;
					case '%': $r .= $formato{++$i}; break;
					default:  $r .= $formato{$i}; break;
				}
				$i++;
			}
			return $r;
		}
	/**
	 * Ajusta a hora em um array associativo
	 *
	 * juntando de um array com ':'
	 *
	 *uso:
	 *<code>
	 *<?php
	 * // o campo hora deve ser uma hora em array
	 *	$input = ajustaHora($_POST['input'], 'hora'); 
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @author   Diogo Campanha
	 * @version  1.0, Agosto 2010
	 * @category date
	 * @param    mixed $the_input array associativo que contém o campo de hora
	 * @param    string $name nome do campo de hora
	 * @return   mixed
	 */
		function ajustaHora ($the_input, $name = 'hora')
		{
			if( isset($the_input[$name]) && is_array($the_input[$name]) )
				$the_input[$name] = implode(':', $the_input[$name]);
			
			return $the_input;
		}
	/**
	 * Retorna o nome do mês por extenso
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	echo nomeMes( '01' ); //  ecoa 'Janeiro'
	 *?>
	 *</code>
	 * @author Diogo Campanha
	 * @version 1.0, Agosto 2010
	 * @category date
	 * @param integer $mes valor numérico correspondente ao mês( 1-12)
	 * @return string
	 */
		function nomeMes ($mes)
		{
			$mes = (int)$mes;
			switch($mes)
			{
				case 1: return "Janeiro"; break;
				case 2: return "Fevereiro"; break;
				case 3: return "Março"; break;
				case 4: return "Abril"; break;
				case 5: return "Maio"; break;
				case 6: return "Junho"; break;
				case 7: return "Julho"; break;
				case 8: return "Agosto"; break;
				case 9: return "Setembro"; break;
				case 10: return "Outubro"; break;
				case 11: return "Novembro"; break;
				case 12: return "Dezembro"; break;
				default: return $mes; break;
			}
		}
	/**
	 * Retorna o nome do dia por extenso
	 *
	 *uso:
	 *<code>
	 *<?php
	 *	echo nomeDiaSemana( '01' ); // ecoa : 'Segunda-feira'
	 *?>
	 *</code>
	 * @author Diogo Campanha
	 * @version 1.0, Agosto 2010
	 * @category date
	 * @param integer $dia valor numérico para o dia { 0-Domingo .. 6-Sábado }
	 * @return string
	 */
		function nomeDiaSemana ($dia)
		{
			$dia = (int)$dia;
			if ($dia == 0) return "Domingo";
			else if ($dia == 1) return "Segunda-feira";
			else if ($dia == 2) return "Terça-feira";
			else if ($dia == 3) return "Quarta-feira";
			else if ($dia == 4) return "Quinta-feira";
			else if ($dia == 5) return "Sexta-feira";
			else if ($dia == 6) return "Sábado";
			else return "";
		}
	/**
	 * Adiciona	um intervalo de tempo a uma base;
	 *
	 *<code>
	 *<?php
	 *	// adicionar um mês e 5 dias a data atual
	 *	$um_mes = _sumDate( array('months' => 1, 'days' => 5) );
	 * // adicionar 10 dias à Primeiro de Agosto de 2011
	 *	$dez_dias = _sumDate(10, "2011-08-01")
	 *?>
	 *</code>
	 *
	 * @author    Rafael Benites <rbenites@gestaoativa.com.br>
	 * @version   $Id: date::_sumDate() 2011-08-11 08:50 rbenites $
	 * @category  date
	 * @param     mixed $feed intervalo em dias a ser adicionada, ou um array asssociativo com as partes a serem adicionadas
	 * @param     string $base base a ser usada, será avaliado por strtotime(). Default: $the_now
	 * @return    resultado da operação no padrão Ano-mês-dia Hora:minutos:segundo (YYYY-mm-dd hh:ii:ss)
	 */
		function _sumDate($feed, $base = null)
		{
			global $the_now;
			$base_add = array('years' => 0,'months' => 0,'days' => 0,'minutes' => 0,'seconds' => 0,'hours' => 0);
			if (is_array($feed))
				$base_add = array_merge($base_add,$feed);
			else
				$base_add['days'] += (int)$feed;
			$base_time = strtotime(empty($base)? $the_now: $base);
			return date("Y-m-d H:i:s", 
				mktime(
					date("H", $base_time)+$base_add['hours'],
					date("i", $base_time)+$base_add['minutes'],
					date("s", $base_time)+$base_add['seconds'],
					date("m", $base_time)+$base_add['months'],
					date("d", $base_time)+$base_add['days'],
					date("Y", $base_time)+$base_add['years']
				)
			);
		}

// ######### CATEGORY: FILES ##########


	/**
	 * Lista todos os diretórios dentro de um diretório
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	list_dirs( './' );
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category files
	 * @param    string $base_dir o diretorio em questão (./)
	 * @return   mixed 
	 */
		function list_dirs ($base_dir = './')
		{
			$dirs = array();
			$exclude = array( '.', '..');
			if( empty($base_dir) )
			{
				$base_dir = '.';
			}
			$base_dir = (string)$base_dir;
			if( $base_dir{strlen($base_dir)-1 } !== '/' )
			{
				$base_dir .= '/';
			}
			if( is_dir($base_dir) )
			{
				if( $dh = @opendir($base_dir) )
				{
					while ( ($file = readdir($dh)) !== false )
					{
						if( is_dir($base_dir . $file) && !in_array( $file, $exclude, true ) )
						{
							array_push( $dirs,$file );
						}
					}
					closedir($dh);
				}
			}
			return $dirs;
		}
	/**
	 * Retorna o caminho para um arquivo o que melhor se adaptar (dentro de um modulo, em modulos, ou template )
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	include includeFile( 'edit' ); // inclui o arquivo edit.php 
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category files
	 * @param    string $file o arquivo que se deseja incluir (.php é opcional)
	 * @return   string
	 */
		function includeFile ($file)
		{
			global $the_module;	
			if (strpos($file, '.php') === false)
				$file = "{$file}.php";
			$nfile = $file;
			if (file_exists($nfile))
				return( $nfile );
			
			else if( file_exists($nfile = sprintf('modulos/%s/%s', $the_module, $file)) )
			{
				return( $nfile );
			}
			else if( file_exists($nfile = sprintf('modulos/%s', $file)) )
			{
				return( $nfile );
			}
			else if( file_exists( $nfile = sprintf('%s/%s', $the_module, $file)) )
			{
				return( $nfile );
			}
			else if( file_exists($nfile = sprintf('template/default_%s', $file)) )
			{
				return( $nfile ); 
			}
			else
			{
				// arquivos de erros e blank
				if( file_exists('template/default_blank.php') )
				{
					return 'template/default_blank.php';
				}
				else if( file_exists('modulos/error.php') )
				{
					return 'modulos/error.php';
				}
				else if( file_exists('../../template/default_blank.php') )
				{
					return '../../template/default_blank.php';
				}
				else if( file_exists( '../modulos/error.php') )
				{
					return '../modulos/error.php';
				}
			}
		}
	/**
	 * Lista todos os arquivos dentro de um diretório
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	get_files( './', false );
	 *?>
	 *</code>
	 * @author   Rafael Benites
	 * @version  1.0, Agosto 2010
	 * @category files
	 * @param    string $the_dir o diretorio em questão (./)
	 * @param    boolean $deep se é necessário vasculhar as pastas internas ao diretorio pai (false)
	 * @return   mixed 
	 */
		function get_files ($the_dir = './', $deep = false)
		{
			$dirs = array();
			$files = array();
			$exclude = array( '.', '..');
			array_push( $dirs, $the_dir );
			while( $base_dir = array_pop($dirs) )
			{
				if($base_dir{strlen($base_dir)-1 } !== '/' )
					$base_dir .= '/'; 
				if ($dh = @opendir($base_dir))
				{
					while (($file = readdir($dh)) !== false)
					{
						if( is_dir( $base_dir . $file ) && $deep && !in_array( $file, $exclude, true ) )
						{
							array_push( $dirs, $base_dir . $file );
						}
						if( is_file($base_dir . $file) )
						{
							array_push( $files, $base_dir . $file );
						}
					}
					closedir($dh);
				}
			}
			return $files;
		}
	/**
	 * Função que recupera a extensão de um arquivo pelo nome (lowercase)
	 *
	 * uso:
	 *<code>
	 *<?php
	 *	echo getExtensao( 'teste/teste.TST' ); // ecoa 'tst'
	 *?>
	 *</code>
	 *
	 * @author   Diogo Nascimento
	 * @version  1.0, Agosto de 2010
	 * @category files
	 * @param	 string $file o nome do arquivo em questão
	 * @return   string
	 */
		function getExtensao ($file)
		{
			$ext	= explode( ".", $file);
			$num	= count($ext);
			return  strtolower($ext[$num-1]);
		}

/* End of File: functions.php */
/* Path: ga-admin/includes/functions.php */