<?php 
/**
 * Tempalte::default_header->nicEdit-dhtml_goodies
 *
 * Oferece alguns scripts e estilizações padrões para facilitar uso do admin.
 *
 * traz o dhtmlgoodies_calendar como interface de calendário e o nicEdit para edição de texto[rich text editor](traduzido pt-Br)
 *
 * @author	    Rafael Benites <rbenites@gestaoativa.com.br>
 * @version     1.005, Created: 30/09/2010, LastModified: 15/01/2011
 * @package     Template
 */

?>

<!--/* template/default_header.php */-->
<!-- interface para calendario -->
	<link rel="stylesheet" href="./includes/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" type="text/css" media="screen" />
	<script type="text/javascript" src="./includes/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script> 
<!-- #interface para calendario -->
<!-- editor WYSIWYG -->
	<script type="text/javascript" src="./includes/js/nicEdit/nicEdit-pt_Br.js"></script>
	<script type="text/javascript">
	// <![CDATA[
		jQuery(function($){
			$('textarea').each( function(){
				var t = $(this);
				if( !t.hasClass('gaNoEditor') )
					new nicEditor({
						fullPanel:true,
						xhtml:true,
						onSave:function(con,id,ins){
							ins.saveContent();
							if( _valid.form() )
								ins.copyElm.form.submit();
							return false;
						}
					}).panelInstance(t.css({width:'580px'})[0]);
			});
		});
	// ]]>
	</script>
	<style type="text/css">
		.nicEdit-main p{margin-bottom:.75em}
	 </style>
<!-- fim editor WYSIWYG -->
<!--/*#template/default_header.php */-->
