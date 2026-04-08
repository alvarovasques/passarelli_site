<?php
    /**
     * Passarelli Advocacia 
     *
     * Arquivo com o template de cabeçalho padrão do projeto<br>
     * traz a inclusão dos frameworks:
     * - {@link http://blueprint.org}
     * - {@link http://jquery.com}
     *
     * @author      Rafael Benites <rbenites@gestaoativa.com.br>
     * @author      Marcelo Meneguesso <marcelo@gestaoativa.com.br>
     * @author      Mahmod A. Issa <muh@gestaoativa.com.br>
     * @package     View
     */

    /**
     * Inclusão dos arquivos com os dados iniciais do projeto
     * iniciar a conexão com banco de dados, inclusão das funções e constantes padrões
     */
    include_once dirname(dirname(__FILE__)) . '/include/config.inc.php';
       $pagina_aberta = $_SERVER['REQUEST_URI'];
	
	if(substr($pagina_aberta,0,6) == '/view/'){
		$pagina_sem_view = substr($pagina_aberta, 5);
		header("Location: ".HOME_URL."".$pagina_sem_view."", true);
	}
    if (file_exists('code.inc.php')) {
    	
        /**
         * Inclusão do arquivo de codificação padrão do módulo usando o template,
         * Traz a codificação realtiva exclusivamente ao módulo usando o template
         */
        include 'code.inc.php';	   
    }
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php if(isset($noTop)) { ?> style="min-width: 500px" <?php } ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo htmlspecialchars($siteConfig->titulo); ?></title>
		<meta name="description" content="<?php echo htmlspecialchars($siteConfig->description);?>" />
		<meta name="keywords" content="<?php echo htmlspecialchars($siteConfig->keywords);?>" />
		<meta name="author" content="Equipe Gestão Ativa: Rafael Benites, Marcelo Meneguesso Mahmod A. Issa" />
    <!-- favicon -->
        <link rel="shortcut icon" href="<?php echo BASE_URL;?>/favicon.png" type="image/png" />
    <!--  //ico 
        <link rel="shortcut icon" href="<?php echo BASE_URL;?>/favicon.ico" type="image/x-icon" />
    -->
	<!--estilos-->
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL;?>/blueprint/screen.css" media="screen, projection" />
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL;?>/blueprint/print.css" media="print" />
		<!--[if lt IE 8]><link rel="stylesheet" href="<?php echo CSS_URL;?>/blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]-->
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL;?>/style.css" charset="utf-8" media="all" />
		<link type="text/css" rel="stylesheet" href="<?php echo JS_URL;?>/fancybox/jquery.fancybox-1.3.4.css" charset="utf-8" media="all" />
	<!--javascript-->
		<script type="text/javascript" charset="utf-8" src="<?php echo JS_URL;?>/jquery.js"></script>
<?php
    // existe um arquivo com instruções de header
    if (file_exists('head.inc.php')) {
        /**
         * Inclue o arquivo com instruções de header específicas do
         * módulo usando o template, inline style's e javascript's
         */
        include_once 'head.inc.php';
    }
	?>
	</head>
	<body <?php if(isset($noTop)) { ?> style="min-width: 500px" <?php } ?>>
		<?php if(!isset($noTop)) { ?><div class="bg-meio"><!--bg meio-->
			<div class="container">
			
				<div class="aCenter header">
					<a href="<?=HOME_URL?>/home" title="HOME-Passarelli Advocacia">
						<img src="<?=IMG_URL?>/logo-escuro.png" alt="Passarelli Advocacia" />
					</a>
				</div>
				<div class="span-23 append-half prepend-half">
				<?php
                    include dirname(__FILE__) . '/breadcrumb.inc.php';
	}