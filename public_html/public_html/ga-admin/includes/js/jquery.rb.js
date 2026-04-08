/**
 * Conjunto de funções para facilitar o uso do sistema
 * @version  1.007, Created: 30/07/2010, LastModified: 28/11/2010
 * @author   Rafael Benites <rbenites@gestaoativa.com.br>
 */
(function(w, $){
/* evita redeclarações */
	if(typeof(w.RB)!='undefined'){
		return;
	}
/* core */
var RB={ 
/* simples quebra de linha */
	br:'\n',
/* está em debug */
	_debug:false,
/* seta um valor default, já que javascript não tem como passar parametro por default */
	setDefault:function(uValue,dValue){
		return(typeof(uValue)=='undefined')?dValue:uValue;
	},
/* um confirme alertando dos perigos de excluir algo */
	doRemove: function(){
		return confirm('Deseja realmente remover este item?\nOperação não poderá ser desfeita.');
	},
/* dispara os erros e catches do objecto RB, se debug esta true ou se o parametro 3 for true */
	thrower:function(exC,fName,fValue){
		fValue=this.setDefault(fValue,false);
		if(this._debug||fValue){
			w.alert(this.printf('Exception thrown at `%r`%rName: `%r`, description: `%r`',fName,this.br,exC.name,exC.description));
		}
		return null;
	},
/* função que simula sprintf substitui '%r' pelos parametros seguintes */
	printf:function(){
		if(arguments.length<2){
			return'';
		}
		var tValue='',	// último caracter testado;
			fValue='',	// valor formatado
			sValue=1,	// indice substitutos
			cValue;		// caracter corrente
		for(var i=0,n=arguments[0].length;i<n;++i){
			cValue=arguments[0].charAt(i);
			if(cValue==='r'&&tValue==='%'){
				if(sValue>(arguments.length-1)){
					this.thrower({name:'Error',description:this.printf('missing argument [%r]',sValue)},'RB.printf()', true);
					return'';
				}
				fValue+=arguments[sValue++];
			}else if(tValue==='%'&&cValue!=='r'){
				fValue+=tValue+cValue;
			}
			else if(cValue!=='%'){
				fValue+=cValue;
			}
			if(tValue==='%'&&cValue==='%'){
				tValue='';
			}else{
				tValue=cValue;
			}
		}
		return fValue;
	},
/* função que adiciona 0 a esquerda em numeros menores que 10 */
	_0:function(uValue){
		uValue=this.setDefault(uValue,0);
		return(uValue<10&&uValue>=0)?('0'+uValue):(uValue);
	},
/* faz com que o valo de um checkbox sempre seja mandado */
	hiddenCheckBox:function(checkboxID,hiddenID,cValue,uValue){
		try{
			$(hiddenID).val($(checkboxID).attr('checked')?cValue:uValue);
		}catch(e){
			this.thrower(e,'RB.hiddenCheckBox');
		}
	},
/* carrega um css dinamicamente */
	_loadCss: function( href ){
		$(function($){$('html head').append('<link type="text/css" rel="stylesheet" href="'+href+'" />');});
	}
};
/* cookies */
$.extend( RB,{
	/* verifica se cookie está habilitado */
		cookie: !!navigator.cookieEnabled,
	/* apaga um cookie(faz com que lele expire em um segundo  */
		eraseCookie: function( rName ){
			if(!this.cookie){
				return this.thrower( {name: 'Error', description : 'Cookie seems to be disabled'}, 'RB.eraseCookie');
			}
			this.writeCookie( rName, '', 0.0000115749 );
		},
	/* escreve um cookie */
		writeCookie: function( rName, cValue, cExpire,  pValue ){
			if(!this.cookie){
				return this.thrower( {name: 'Error', description : 'Cookie seems to be disabled'}, 'RB.eraseCookie');
			}
			var fString = rName + '=' + encodeURIComponent( cValue ) + ';',
				theDate = new Date();
			pValue = this.setDefault( pValue, '/');
			if( cExpire ){
				theDate.setTime( theDate.getTime() + cExpire * 60 * 60 * 1000 );
				fString += 'expires=' + theDate.toGMTString() + ';';
			}
			fString += 'path=' + pValue + ';'; document.cookie = fString; 
		},
	/* faz a leitura de um cookie e retorna seu valor */
		readCookie: function( rName ){
			if(!this.cookie){
				return this.thrower( {name: 'Error', description : 'Cookie seems to be disabled'}, 'RB.eraseCookie');
			}
			var rName = rName + '=',
				parts = document.cookie.split(';');
			for(var i=0, n = parts.length;i < n;i++){
				var the_val = $.trim(parts[i]);
				if (the_val.indexOf(rName) == 0){
					return decodeURIComponent( the_val.substr(rName.length, the_val.length ) );
				} 
			}
			return null;
		}
	});
/* menu */
$.extend(RB,{
/* controle do menu */
	menu: [],
/* se o menu deve ficar visivel ou escondido */
	menuDisplay: function(ind){
		this.menu[ind] = !this.menu[ind];
		try{
			$('#info_'+ind).html(this.menu[ind] ? '-':'+');
		} catch(e){}
		return this.menu[ind];
	},
/* seta um indice do menu com algum valor */
	menuSet: function(ind, val){
		this.menu[ind] = val ? true : false;
	},
/* escreve as variaveis do menu em cookies */
	menuWrite: function(){
		var valor = '', val;
		for(var i=0, n = this.menu.length; i<n; i++){
			val = (this.menu[i]? '0': '1');
			valor += this.printf("RB.menuSet(%r,%r)#", i, val); 
		}
		this.writeCookie('menudisplay', valor, 1);//escreve para uma hora
	},
/* faz a leitura dos cookies em busca de informaçõeas do menu */
	menuRead: function(){
		var val = this.readCookie('menudisplay');
		if(val){
			val = val.replace(/#/g, ';');
			eval(val);
			for(var i=0, n = this.menu.length; i<n; i++){
				this.menuDisplay(i) ? $('#menu_'+i).show() : $('#menu_'+i).hide();
			}
		}
	}
});
/* midias */
var _edit;
$.extend( RB,{
/* o botão de submit externo está escondido */
	_disabled: false,
/* habilita os botoes de submit nested-forms-issue*/
	_enable: function(){
		if( !this._disabled ){
			return false;
		}
		$('input[type=submit]').attr({disabled:false}).css({opacity:1});
		this._disabled = false;
		return true;
	},
/* faz requisição de remoção de uma midia ou o grupo */
	_removeMidia: function( id, tipo ){
		tipo = this.setDefault (tipo, '');
		if(this.doRemove()){
			this._enable(); /* nested-form-issue IE */
			$.get( 'midia/midia_control.php?acao_midia=remove&id_midia='+id+'&tipo='+tipo, RB._updateView);
		}
	},
/* faz requisição de ordenação */
	_ordemMidia: function( id, val ){
		$.get( 'midia/midia_control.php?acao_midia=ordena&id_midia='+id+'&valor='+val, RB._updateView);
	},
/* faz requisição para destaque */
	_destaqueMidia: function(id, val ){
		$.get( 'midia/midia_control.php?acao_midia=destaca&id_midia='+id+'&valor='+val, RB._updateView);
	},
/* faz a requisição para edição de uma midia ou do grupo */
	_editMidia: function(id, tipo ){
		this._addLoadingPic();
		tipo = this.setDefault (tipo, '');
	/* desabilita o envio do form ie nested-form-issue */
		if( $.browser.msie || $.browser.opera ){
			$('input[type=submit]').attr({disabled:'disabled'}).css({opacity:.2});
			RB._disabled = true;
		}
		$.get('midia/edit.php?id='+id+'&tipo='+tipo, function(data){
			RB._updateView(data);
			_edit = jQuery('#updateform').validate({
				submitHandler: function(form){
					jQuery(form).ajaxSubmit({
						beforeSubmit:function(a,b,c){
							RB._addLoadingPic();
						},
						success: function(d){
							RB._updateView(d);
							RB._enable(); /* nested-form-issue IE */
						}
					});
				}
			});
		});
	},
/* faz atualização do box de midia */
	_updateView: function(data){
		jQuery("#midia_show_wrapper").html(data).fadeIn(500);
		/* atualiza os links se ouverem */
		jQuery(".preview").fancybox({titlePosition:'inside'});
		/* e os links externos */
		jQuery(".previewfile").attr({target:'_blank'});
	},
/* faz a listagem das midias */
	_listMidia: function(id, tipo){
		this._enable(); /* nested-form-issue IE */
		this._addLoadingPic();
		$.get( 'midia/midia_control.php?acao_midia=reload&id_midia='+id+'&tipo='+tipo, RB._updateView);
	}
});
/* firulas */
var load = new Image();
	load.src = "./includes/js/images/load.gif";
$.extend( RB, {
	/* imagem de loading */
	_loadAnimation: load,
	_addLoadingPic: function(){
		$("#midia_show_wrapper")
			.append($('<div id="fake-overlay">')
							.css({width: '100%', height: ($("#midia_show_wrapper").height())+'px', position: 'absolute', top: 0, left: 0,opacity: .66, background: '#333'})
							.html('&nbsp;'))
			.append( $(this._loadAnimation).css({ position: 'absolute', top: '50%', left: '245px'}));
	},
/* efeito para esconder um elemento e depois remove-lo */
	_hideRemove: function(me){
		$(me).hide(500, function(){ $(this).empty().remove(); });
	}
});
/* escopo global */
w.RB = RB;
w._edit = _edit;
/* dispara a leitura do menu e o preview das midias(fancybox imagens) */
$(document).ready(function(){
	RB.menuRead();
	jQuery(".preview").fancybox({titlePosition:'inside'});
	jQuery(".previewfile").attr({target:'_blank'});
});
})(window,jQuery);