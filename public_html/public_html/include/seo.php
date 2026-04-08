<?php
/**
 * SEO Plugin 0.1
 *
 * Arquivo que contém funções necessários para o funcionamento do plugin
 *
 * @author     Rafael Benites <rbenites@gestaoativa.com.br>
 * @version    $2011-08-19: seo/seo.php rbenites $
 * @since      2011-08-19 suporte para abordagens por módulo
 * @package    Plugins
 * @subpacakge URLRewrite
 * @filesource
 */
 
// ######################## CONFIGURAÇÕES ########################
/**
 * Define o uso do "rewrite" via apache
 *	(
 *	0 => a url será construida usando GET normalmente,
 *	1 => rewrite será feito pelo .htaccess
 *	)
 */
	define("seo_rewrite", 1);
/**
 * Define o nome das colunas que serão verificadas para formar-se a url
 */
	define("seo_columns", "titulo,nome");

// #### FUNÇÕES ####
/**
 * Função que faz mapeamento dos parâmetros recebidos por rewrite
 *
 * Esta função será chamada por seo_filter() para extrair dados vindos do
 * redirecionamento, e maperá a variável global $_GET de acordo com essa relação
 * Podem existir mapeamentos restritos por módulos.
 *
 * @param     integer $index índice a ser mapeado
 * @param     string|null $module o módulo que será feito a tratativa
 * @return    string
 */
	function seo_map($index, $module = null)
	{
		switch($module)
		{
			default:
				switch($index)
				{
					case 0: return "seo"; break;
					case 1: return "detail"; break;
					default:
						return "args{$index}";
					break;
				}
			break;
		}
	}

// ######################## CONFIGURAÇÕES ########################

/**
 * Função para auxiliar a criação de url amigáveis
 *
 * Recebe como primeiro parâmetro o módulo que será usado, e até dois parâmetros
 * que serão os responsáveis pela construção da url.<br>
 * <b>Importante</b>:Será necessário que estes objetos tenham um atributo "id" definido,
 * e um atributo com o nome definido na constante seo_columns.
 *
 *<code>
 *<?php
 *	// seleciona as noticias
 *	$noticias = sqlQuery("SELECT `id`, `titulo` FROM `rb_noticias` WHERE `ativo`=1");
 *	foreach ($noticias as $noticia)
 *	{
 *	?>
 *		<a href="<?php echo seo_link('noticias', $noticia); ?>" title="<?= $noticia->titulo; ?>">
 *			<?= $noticia->titulo; ?></a>
 *	<?php
 *	}
 *?>
 *</code>
 *
 * @param    string $module módulo da view para onde o link apontará
 * @param    mixed $object objeto que gera a primeira parte da url
 * @param    mixed $object2 objeto que gera a segunda parte da url
 * @return   string contendo a url que será usada
 */
	function seo_link($module, $object, $object2 = null)
	{
		if (is_array($object))
			$object = (object)$object;
		if (is_array($object2))
			$object2 = (object)$object2;
	// verificar a presença de um objeto	
		if (is_object($object))
		{
			$titulo = seo_titulo($object);
			if (is_object($object2))
			{
				$titulo2 = seo_titulo($object2);
				if (seo_rewrite)
					return  HOME_URL . "/{$module}/{$titulo}/{$object->id}/{$titulo2}/{$object2->id}/";
				return HOME_URL . "/{$module}/?seo={$titulo}&amp;item={$object->id}&amp;seo2={$titulo2}&amp;detail={$object2->id}";
			}
			if(seo_rewrite)
				return HOME_URL . "/{$module}/{$titulo}/{$object->id}/";
			return HOME_URL . "/{$module}/?seo={$titulo}&amp;detail={$object->id}";
		}
		return '#';
	}
/**
 * Função para auxiliar a criação de url amigáveis
 *
 * Recebe como primeiro parâmetro o nome do módulo ao qual a url
 * apontará, e uma lista de parâmetors que serão adicionados à url na mesma ordem
 * de entrada<br>
 * <b>Importante:</b> note que a re-escrita de url tem de estar habilitada para uso desta função
 *
 *<code>
 *<?php
 *  // construir a url (Suponha: define("HOME_URL' => 'http://localhost"); )
 *  $url = seo_create_link("noticias", "Título da Notícia", 10);
 *	// $url possui http://localhost/noticias/titulo-da-noticia/10
 *?>
 *	<a href="<?= $url; ?>" title="Saiba Mais">Saiba Mais</a> 
 *</code>
 *
 * @param   string $modulo o módulo que será usado na url
 * @param   string|integer $part,... lista de valores que formarão a url
 * @return  string contendo a url final
 */
	function seo_create_link()
	{
		$url = HOME_URL;
		$args = func_get_args();
		if (!empty($args))
		{
			$url .= "/" . array_shift($args);
			foreach ($args AS $arg)
			{
				$url .= "/" . str2link($arg);
			}
		}
		return $url;
	}

/** 
 * Função para retornar um candidato a url amigável
 *
 * Busca no objecto recebido um atributo com o nome dentre os definidos na
 * constante seo_columns, ou o texto 'seo-plugin', caso nenhum encontrado.
 * 
 * @param    mixed $object objeto do qual será extraido o texto para url
 * @return   string que será usada na url
 */
	function seo_titulo ($object)
	{
		if (is_array($object))
			$object = (object) $object;
		if (is_object($object))
		{
			foreach (explode(",", seo_columns) AS $index)
				if (isset($object->$index))
					return str2link($object->$index);
		}
		return "seo-plugin";
	}
/**
 * Função que tenta recuperar o nome do módulo no qual o script está sendo usado
 *
 * O faz através de um rastreamento pela url, baseando-se na constante HOME_URL,
 * considera-se o proximo nome após ela como sendo o módulo.
 * Será usada por seo_filter(), antes da chamada para seo_map()
 * <ul>
 *	<li><b>Importante</b><ul>	
 *	<li>A constante HOME_URL deve estar definida;</li>
 *	<li>Atente-se quando a url é feita na home, e o módulo está omitido na "url", pois, o retorno pode ser "";</li>
 *</ul</li></ul>
 *
 *<code>
 *<?php
 * // Supor: define('HOME_URL','http://localhost/view') e url atual: "http://localhost/view/teste/teste/10";
 *	echo seo_module(); // ecoa "teste"
 *?>
 *</code>
 *
 * @param     void
 * @return    string a parte da url que foi considerada sendo "o módulo"
 */
	function seo_module()
	{
	// url completa sem www
		$the_url = str_replace('www.', '', "{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}");
	// remove possivel "www" e "http"
		$no_www  = preg_replace("/http\:\/\/(www\.)?/", "", HOME_URL . "/");
	// remove a url base da url atual
		$the_url = str_replace($no_www, "", $the_url);
	// particiona em todas as "/"
		$the_url = explode("/", $the_url);
	// retorna o considerado "modulo"
		return @array_shift($the_url);
	}
/**
 * Função que extrai parâmetros pela reescrita e povoa a variável $_GET
 *
 * Esta função sempre será executada, verifica a existência dos parâmetros provenientes
 * do redirecionamento por rewrite, e faz uso da função seo_module() para tentar determinar
 * e qual módulo a url está sendo processada, e faz uso da função seo_map() para ver como as
 * variáveis recebidas devem ser mapeadas no $_GET;
  * <ul>
 *	<li><b>Importante</b><ul>	
 *	<li>O índice "seo_vars"($_GET['seo_vars']) é usado para o redirecionamento rewrite, logo não deverá ser utilizado; </li>
 *	<li> $_GET['seo_vars'] deixará de existir, após a chamada da função; </li>
 *</ul</li></ul>
 *
 * @param    void
 * @return   void
 */
	function seo_filter()
	{
		if (isset($_GET['seo_vars']))
		{
			$params = explode("/", trim($_GET['seo_vars'],"/"));
			foreach ($params as $index => $param)
			{
				$module = seo_module();
				$index  = seo_map($index, $module);
				$_GET[$index] = $param;
			}
			unset($_GET['seo_vars']);
		}
	}
// #### CHAMADA DAS FUNÇÕES ####
// função será chamada caso exista parametros para serem tratados
	seo_filter();
	
#end of file SEO/seo.php 2011-08-19 rbenites