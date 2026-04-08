<?php 
/**
 * Template::default_header->tinyMCE-dhtml_goodies
 *
 * Oferece alguns scripts e estilizações padrões para facilitar uso do admin.
 *
 * Traz o dhtmlgoodies_calendar como interface de calendário e o tiny MCE para edição de texto[rich text editor]
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.003, Created: 30/09/2010, LastModified: 25/06/2011
 * @package     Template
 */

?>

<!--/* template/default_header.php */-->
<!-- interface para calendario -->
	<link rel="stylesheet" href="./includes/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" type="text/css" media="screen" />
	<script type="text/javascript" src="./includes/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script> 
<!-- #interface para calendario -->
<!-- editor WYSIWYG -->
	<script type="text/javascript" src="./includes/js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
		/* General options */
			mode : "textareas",
			theme : "advanced",
			relative_urls : false,
			convert_urls : false,
			plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		/* Theme options */
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
			theme_advanced_buttons2 : "cut,copy,paste,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
		/* Drop lists for link/image/media/template dialogs */
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",
			plugin_insertdate_dateFormat : "%d-%m-%Y",
		/* Atualiza o textarea a cada operação que gera um "undo" */
			onchange_callback: function(editor) {
				tinyMCE.triggerSave();
			},
			save_onsavecallback: function(ed){
				if( _valid.form() )
					$('#'+ed.id)[0].form.submit();
				return false;
			},
			width: '590px',
			template_replace_values:{username:"Some User",staffid:"991234"},
			editor_deselector : "gaNoEditor" 
		});
		jQuery(function($){
			$("input[type=submit]").click(function(){
				try{
					tinyMCE.triggerSave();
				}catch(e){}
			});
		});
	</script>
<!-- fim editor WYSIWYG -->
<!--/*#template/default_header.php */-->
