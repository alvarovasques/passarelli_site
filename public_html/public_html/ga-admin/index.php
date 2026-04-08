<?php 
/**
 *	Core::index
 *
 * Arquivo base para o sistema administrativo, traz a base do layout e as
 * inclusões dos scripts e estilos padrões do sistema:
 *<ul>
 *	<li>blueprint/(screen|ie|print).css {@link http://blueprintcss.org}</li>
 *	<li>jquery.js (1.4.4) {@link http://jquery.com}</li>
 *	<li>jquery.fancybox.js e jquery.fancybox.css (1.3.4) {@link http://fancybox.net}</li>
 *	<li>jquery.form.js (2.49) {@link http://malsup.com/jquery/form/}</li>
 *	<li>jquery.validate.js (1.7) {@link http://bassistance.de/jquery-plugins/jquery-plugin-validation/}</li>
 *	<li>E os arquivos desenvolvidos: jquery.ga-admin.validate.js(0.1) e jquery.rb.js(1.007)</li>
 *</ul>
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @author	    Diogo Campanha <diogo@gestaoativa.com.br>
 * @version     1.002, Created: 30/09/2010, LastModified: 18/06/2011
 * @package     Core
 */
 
/**
 * Somente com usuário logado poderemos exibir esta página
 */
	require_once "includes/login_check.php";
// dados do usuário logado
	$the_user = unserialize($_SESSION['ga_admin_info']);

/**
 * Controlador que define qual "controller" chamar
 */
	include_once "controller.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<title>.: Painel de Administra&ccedil;&atilde;o :.</title>
<!--#BEGIN estilos -->
	<link rel="stylesheet" href="./includes/estilo/blueprint/screen.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="./includes/estilo/jquery.fancybox.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="./includes/estilo/blueprint/print.css" type="text/css" media="print" />
	<!--[if lt IE 8]><link rel="stylesheet" href="./includes/estilo/blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]-->
	<link rel="stylesheet" href="./includes/estilo/admin_style3.0.css" type="text/css" media="all" />
<!--#END estilos -->

<!--#BEGIN javascripts-->
	<script type="text/javascript" src="./includes/js/jquery.js" charset="utf-8"></script>
	<script type="text/javascript" src="./includes/js/jquery.rb.js" charset="utf-8"></script>
<!--#END javascripts-->

	<?php
	/**
	 * Inclusao do template de3 cabeçalho padrão para omódulo carregado
	 */
		include (includeFile('header'));
	?>
</head>
<body class="internas">
<!-- DIV #externalBox -->
	<div class="container" id="externalBox">
		<!--DIV #menu-->
		<div id="ga-left-box">
			<div id="ga-cliente-logo">
			<?php
				if (isset($the_logo)) {
				?>
				<div class="logo">
					<a href="<?php echo BASE_URL; ?>" title="Ver o Site" class="external">
						<img src="<?php echo $the_logo; ?>" alt="<?php echo $the_client; ?>" /></a>
				</div>
			<?php
				}
				?>&nbsp;
			</div>
			<div id="menu" class="clear">
				<?php
				/**
				 * Inclusao do arquivo de menu
				 */
				 include_once ("menu.php");
				?>			
			</div><!--DIV #menu -->
		</div>
		<!--DIV #conteudo -->	
		<div id="ga-right-box">
			<div class="logout append-bottom">
				<h2 class="bottom">Bem Vindo :)</h2>
				Olá <?php echo $the_user['login']; ?> | 
				<a href="logoff.php" title="Sair" onclick="return confirm('Deseja realmente sair do sistema?');">sair</a>
			</div>
			<div id="ga-conteudo">				
				<?php
				/**
				 * Inclusao do controller designado para o módulo carregado
				 */
					include_once $the_controller;
				?>
				<br class="clear" />
			</div>
		</div><!--DIV #conteudo -->
	</div><!-- DIV #externalBox -->
	<div class="footer">
		Todos os direitos reservados &copy; 2012 - <a href="http://www.gestaoativa.com.br" title="Gestão Ativa">Gestão Ativa</a>
	</div>

<!-- scripts movidos para baixo para tentar acelerar o tempo de carregamento da página -->
	<script type="text/javascript" src="./includes/js/jquery.validate.js" charset="utf-8"></script>
	<script type="text/javascript" src="./includes/js/jquery.ga-admin.validate.js" charset="utf-8"></script>
	<script type="text/javascript" src="./includes/js/jquery.form.js" charset="utf-8"></script>
	<script type="text/javascript" src="./includes/js/jquery.fancybox.js" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8">
	// <![CDATA[
		jQuery(function($){
			$(".external").attr({target:"_blank"});		
			$(".content-box-header h3").css({ "cursor":"s-resize" }); // Give the h3 in Content Box Header a different cursor
			$(".closed-box .content-box-content").hide(); // Hide the content of the header if it has the class "closed"
			$(".closed-box .content-box-tabs").hide(); // Hide the tabs in the header if it has the class "closed"		
			$(".content-box-header h3").click(function () {
				$(this).parent().next().toggle(); // Toggle the Content Box
				$(this).parent().parent().toggleClass("closed-box"); // Toggle the class "closed-box" on the content box
				$(this).parent().find(".content-box-tabs").toggle(); // Toggle the tabs
			});			
			
		});
	// ]]>
	</script>
	<script type="text/javascript">
// left box maior que right
	var original_height = 0;
	function adjust_left_menu()
	{// menu+logo+footer
		var esq = $('#menu').height() + $('#ga-cliente-logo').height()+20;
		if (esq > original_height)
			$('#ga-right-box').css({'min-height':esq+'px'});
		else // forçar o "min"
			$('#ga-right-box').css({'min-height':original_height+'px'});
	}
	jQuery(function($){
		original_height = $('#ga-right-box').height();
		adjust_left_menu();// no ready
		$(window).load(function(){adjust_left_menu()});// no load (imagem)
		var a = $('.first-level>li>a');	
		if (a.parent().find('ul').length>0){
			a.click(function(){// abri e fechar de menus, qdo existem sub-menus
				setTimeout(function(){adjust_left_menu()}, 10)
			});
		}
	});
	</script>
<!-- fixes ie -->
	<!--[if lt IE 10]>
		<script type="text/javascript" src="includes/images/admin_style3.0/PIE.js" charset="utf-8"></script>
		<script type="text/javascript">
			jQuery(function($){
				$(".content-box,.midia-item,.shortcut-button span,.shortcut-button").each(function(){ PIE.attach(this); });
			});
		</script>
	<![endif]-->
</body>
</html>
<?php

/* End of File: index.php */
/* Path: ga-admin/index.php */