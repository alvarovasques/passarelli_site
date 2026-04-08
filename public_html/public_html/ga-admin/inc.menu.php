<?php
/**
 *	Core::inc.menu
 *
 * Arquivo com a definição so itens que integrarão o menu
 *
 *
 * <b>Como montar o menu</b>
 *
 *<code>
 *<?php
 *	// o indice é o nome da pasta dentro de "/modulos", "Teste" o label que será exibido
 *	
 *	// o indice será o label de hide/show o valor será um array
 *	$the_menu["Dicas"] = array(  "dicas" => "Dicas" );
 *?>
 *</code>
 *
 * @version	1.000, Created: 30/08/2010
 * @author	Rafael Benites <rbenites@gestaoativa.com.br>
 * @author	Diogo Campanha <diogo@gestaoativa.com.br>
 * @package Core
 */


/**
 *	Guarda as informações referentes ao menu esquerdo
 *
 * @global mixed $the_menu
 */
	$the_menu = array();

	$the_menu["home"] = "Página Inicial"; 

	$the_menu["Configurações"] = array(
		"configuracoes" => "Configurações",
		"usuarios"      => "Usuários"
	);
 
	$the_menu["paginas"] = "Seções do Site"; ?>
<?php $the_menu["noticias"] = "Notícias";?>
<?php $the_menu["advogados"] = "Advogados";?>
<?php $the_menu["areas-atuacao"] = "Áreas de Atuação";?>
<?php $the_menu["artigos"] = "Artigos";?>
<?php $the_menu["contato-assuntos"] = "Assuntos";?>