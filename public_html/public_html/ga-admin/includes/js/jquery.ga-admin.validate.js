/**
 * jquery.ga-admin.validate vs 0.1
 *
 * Adaptação do jquery.validate plugin para atender as necessidades do sistema
 * baseado em: $ validation plug-in 1.7, Copyright (c) 2006 - 2008 Jörn Zaefferer
 *
 * @link     http://bassistance.de/jquery-plugins/jquery-plugin-validation/
 * @version  0.001, Created:16/11/2010, LastModified: 04/08/2011
 * @author   Rafael Benites <gestaoativa.com.br>
 */
(function($){
/**
 * Tradução das mensagens padrões para o português br
 * @version  0.001, 16/11/2010
 */
$.extend($.validator.messages, {
	required: "Este campo n&atilde;o pode ser vazio.",
	remote: "Por favor, corrija este campo.",
	email: "Por favor, forne&ccedil;a um email v&aacute;lido.",
	url: "Por favor, forne&ccedil;a uma link v&aacute;lido.",
	date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
	dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
	number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
	digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
	creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
	equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
	accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
	maxlength: $.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
	minlength: $.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
	rangelength: $.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
	range: $.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
	max: $.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
	min: $.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}.")
});
/**
 * Criação de um método de validação para login (Não menos que 4 caracteres e sem espaço)
 * @version  0.001, 27/11/2010
 */
$.validator.addMethod("login", function(value, element){
	return this.optional(element) || !(/\s/.test(value) || $.trim(value).length<4)
}, "Forne&ccedil;a ao menos 4 caracteres, sem espa&ccedil;o." );
/**
 * Criação de método de validação para buscas (Não menos que 3 caracteres sem espaços nas extremidades)
 * @version   0.001, 27/11/2010
 */ 
$.validator.addMethod("busca", function(value, element){
	return this.optional(element) || $.trim(value).length > 2
}, "Forne&ccedil;a ao menos 3 caracteres, sem espa&ccedil;o." );
/**
 * Criação de um metódo de validação para datas no estilo br(dd/mm/YYYY)
 * @version   0.002, 04/08/2011
 */
$.validator.addMethod("data", function(value, element) {
	return this.optional(element) || /^(?:(?:(?:0?[1-9]|1\d|2[0-8])\/(?:0?[1-9]|1[0-2]))\/(?:(?:1[6-9]|[2-9]\d)\d{2}))$|^(?:(?:(?:31\/(0?[13578]|1[02]))|(?:(?:29|30)\/(?:0?[1,3-9]|1[0-2])))\/(?:(?:1[6-9]|[2-9]\d)\d{2}))$|^(?:29\/0?2\/(?:(?:(?:1[6-9]|[2-9]\d)(?:0[48]|[2468][048]|[13579][26]))))$/.test(value);
}, "Por favor, forne&ccedil;a uma data v&aacute;lida.");
/**
 * Criação de um método de validação para textareas com editores WYSIWYG (tinyMCE e nicEdit)
 * @version   0.003, 29/11/2010
 */
$.validator.addMethod("gaeditor", function(value, element){
	// borrowed from php.js
		var _strip_tags = function(str){
				var all = '<img>',
					tag = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
					CnP = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
				return str.replace(CnP, '').replace(tag, function(a, b){
					return all.indexOf('<' + b.toLowerCase() + '>') > -1 ? a : '';
				});
			},
			_id_ = function(){
				var t = new Date().getTime(),
					e = $('#textarea'+t);
				while (e.length)
				{
					t = new Date().getTime();
					e = $('#textarea'+t);
				}
				return 'textarea'+t;
			},
			_get_ = function(el){
				var rt,
					ed = null;
				if( jQuery(el).attr('id') == '' )
					jQuery(el).attr( 'id', _id_() );
				if( typeof(nicEditors) != 'undefined' )
				{
					ed = nicEditors.findEditor( $(el).attr('id') );
					if(ed){
						ed.saveContent();
					}
				}
				if( typeof(tinyMCE) != 'undefined' ){
					ed = tinyMCE.get( $(el).attr('id') );
					if(ed){
						jQuery(el).val( ed.getContent() );
					}
				}
				rt = $(el).val();
				return _strip_tags(rt);
			},
			t;
		t = _get_($(element));
		return t.length > 0;
}, "Seu campo de texto n&atilde;o pode ser vazio" );
/**
 * Criação de um método de validação de cpf
 * @version  0.001, 16/11/2010
 */
$.validator.addMethod( "cpf", function(value, element){
	var check = function( the_val ){
			var teste = "00000000000";
			the_val=the_val.replace(/\D/g,'');
			if(the_val.length!=11){
				return false;
			}
			for(var i=0;i<10;i++)
			{
				if(the_val == teste.replace(/\d/gi, i))
				{
					return false;
				}
			}
			soma=0;
			for(var i=0;i<9;i++){
				soma+=parseInt(the_val.charAt(i))*(10-i);
			}
			resto=11-(soma%11);
			if(resto==10||resto==11){
				resto=0;
			}
			if(resto!=parseInt(the_val.charAt(9))){
				return false;
			}
			soma=0;
			for(i=0;i<10;i++){
				soma+=parseInt(the_val.charAt(i))*(11-i);
			}
			resto=11-(soma%11);
			if(resto==10||resto==11){
				resto=0;
			}
			if(resto!=parseInt(the_val.charAt(10))){
				return false;
			}
			return true;
		};
	return this.optional(element) || check(value);
}, "O CPF parece ser inv&acute;lido" );
/**
 * Criação de um método de validação para hora
 * @version   0.002, 23/09/2011
 */
$.validator.addMethod("hora", function(value, element) {
		return this.optional(element) || /^([01][0-9])|(2[0123])\:([0-5])([0-9])(\:([0-5])([0-9]))?$/.test(value);
	}, "Forne&ccedil;a um valor entre 00:00 e 23:59"
);
/**
 * Criação de método de validação para moeda(R$)
 * @version   0.001, 03/08/2011
 */ 
$.validator.addMethod("moeda", function(value, element){
// função
	var _valida_moeda = function(val){
		var F = [/^(R\$\s*)?((\d{1,3})(\.\d{3})*(\,\d{2})?)$/, /^(R\$\s*)?((\d+)(\,\d{2})?)$/];
		for(var i=0, n=F.length; i<n; i++){
			if(F[i].exec(val))
				return true;
		}
		return false;
	};
	return this.optional(element) || _valida_moeda(value)
}, "Forne&ccedil;a um valor v&aacute;lido(R$ 0.000,00)" );
/**
 * Criação de método de validação de e-mails múltiplos (separar por ponto-e-vírgula)
 * @version  0.001, 05/08/2011
 */
$.validator.addMethod("multiemail", function(value, element){
	var emails = value.split(new RegExp("\\s*;\\s*", "gi")),
		valid = true;
	if (this.optional(element)) // return true on optional element
		return valid;
	for (var i = 0, n = emails.length; i<n; i++)
	{
		value = emails[i]; 
        valid = valid && jQuery.validator.methods.email.call(this, value, element);
    } 
    return valid; 
}, "Forne&ccedil;a e-mails v&aacute;lidos. Separados por ';'");
})(jQuery);
