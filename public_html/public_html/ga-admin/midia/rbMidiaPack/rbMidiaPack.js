/**
 * Arquivo javascript base para inclusão da interface de upload rbMidiaPack
 * @version  1.103, created:30/06/2010, lastModified:29/11/2010
 * @author  Rafael Benites <rbenites@gestaoativa.com.br>
 */
(function(RB,$){
/* extende o RB */
$.extend(RB,{
	mCtr: [], 										/* controla os id's das midias */
	mImg: [], 										/* guarda as imagens preloaded's */
	uAIU: false, 									/* indica o uso de "ajax iframe upload" */
	mOk: false,										/* forms setados para mandar arquivos enctype */
	mData: { 'interface': 'rbMidiaPack' },			/* Dados para serem mandados para o iframe */	
	mLabels: [ 'Título', 'Descrição', 'Arquivo', 'Link'],	/* Guarda os labels dos arquivos */
/* Seta o uso do upload via iframe */
	useAIU: function(){
		this.uAIU = true;
	},
/* id para proxima midia */
	nextMidia: function(){						
		for( var id=0; this.mCtr[id]; ++id);
		this.mCtr[id] = true;
		return id; 
	},
/* adiciona parametro para ser mandado pelo iframe */
	addParam: function( id, val ){
		this.mData[id] = val;
	},
/* seta os labels */
	setLabels: function( uValue ){
		if( $.isArray( uValue ) ) {
			for( var i = 0, n =  uValue.length; i<n; ++i ) {
				this.mLabels[i] = uValue[i];
			}
		}
	},
/* adicionar um novo box de midia */
	addMidia:function( val ){
		if(!this.mOk && !this.uAIU){ this.set4Midia(); }
		var tmp, wr, msg, id = this.nextMidia();;
		val = this.setDefault(val, 'file');
		if( val == 'file'){
			msg =  'Envio de arquivo';
			siz = '130px';
		} else {
			msg = 'Envio de links ou embeds';
			siz = '143px';
		}
		try{
		/* box da midia */
			wr = $('<div class="span-7 light midia-box center append-bottom" id="midia_wrapper_'+id+'"></div>')
					.css({display: 'none'})
					.appendTo('#midia_wrapper');
			if( this.uAIU ){
			/* adiciona iframe e o evento "onload" */
				tmp = $( '<div class="span-7 last">')
						.appendTo( wr );
				$( '<iframe id="rb-aiu_'+id+'" name="rb-aiu_'+id+'" src="javascript:;"></iframe>')
					.css({width: '1px', height: '1px', 'float': 'left'})
					.appendTo( tmp );
			/* adiciona o form */
				wr = $('<form enctype="multipart/form-data" action="./midia/midia_control.php" method="post" onsubmit="return RB.submitThis(this)"  target="rb-aiu_'+id+'" id="form_'+id+'"></form>')
						.appendTo( wr );
			}
		/* box de informção do tipo da mídia */
			$('<div class="span-6 left" id="midia_info_'+id+'">')
				.html(this.printf('[%r] - %r', (id+1), msg) )
				.appendTo(wr);
		/* imagem para remover a midia */
			$('<div class="span-1 right last"></div>')
				.html(	this.printf( '<a href="javascript:;" onclick="RB.removeMidia(%r)"><img src="%r" alt="Remove" title="Remove" /></a>',
										id,
										this.mImg[0].src ) )
				.appendTo(wr);
			/* parte do titulo */
			$('<div class="span-2"></div>')
				.html( this.printf('%r: ', this.mLabels[0]) )
				.appendTo( wr );
			$('<div class="span-5 last"></div>')
				.html( '<input type="text" style="width: 180px" name="midia[titulo]['+id+']" id="midia_titulo_'+id+'" />')
				.appendTo( wr );
			/* parte da descrição */
			$( '<div class="span-2"></div>' )
				.html( this.printf('%r: ', this.mLabels[1]) )
				.appendTo( wr );
			$('<div class="span-5 last"></div>')
				.html( '<input type="text" style="width: 180px" name="midia[descricao]['+id+']" id="midia_descricao_'+id+'" />')
				.appendTo( wr );
			/* parte para o arquivo */
			tmp = $( '<div class="span-7 last" id="file_wrapper_'+id+'"></div>' )
					.appendTo( wr );
			$('<div class="span-2">')
				.html( this.printf('%r: ', val=='file'?this.mLabels[2]:this.mLabels[3]) )
				.appendTo( tmp );
			$('<div class="span-5 last"></div>')
				.html( '<input type="'+val+'" style="width: 180px" name="midias['+id+']" id="midias_'+id+'" />' )
				.appendTo( tmp );
			/* adicionar parametros extras e criar frame, mostrar box */
			if( this.uAIU ){
				tmp = $( '<div class="span-7 last right">' )
					.html('<input id="submit_'+id+'" disabled="disabled" type="submit" value="Enviar" />')
					.appendTo( wr );
				this.mData['myid'] = id;
				for( var i in this.mData){
					$('<input type="hidden" name="'+i.toString()+'" value="" />')
						.val(this.mData[i])
						.appendTo( tmp );
				}			
				/* somente quando algum arquivo for inserido o botao será liberado */	
				$('#midias_'+id).change(function(){
					$('#submit_'+id).attr('disabled', false);
				});
				/* jquery.validate bugfix */
				if( typeof($.fn.validate) != 'undefined' ){
					$('#form_'+id).validate();
				}
			}
			$('<br class="clear" />').appendTo( wr );
			$('#midia_wrapper_'+id).fadeIn(500);
		} catch(e){ }
	},
/* remove um box de midia */
	removeMidia: function(id){
		try{
			$('#midia_wrapper_'+id )
				.fadeOut( 500, function(){	$(this).empty().remove(); });
			this.mCtr[id] = false;
		} catch(e){} 
	},
/* atualiza o enctype dos forms para post comuns */
	set4Midia: function(){
		var frms = $('form');
		if(frms.length > 0){
			frms.attr('enctype', 'multipart/form-data');
			if($.browser.msie){
				frms.attr('encoding', 'multipart/form-data');
			}
		} else {
			frms = $( '<form enctype="multipart/form-data" action="" method="post"></form>')
				.appendTo('#midia_form_wrapper');
			frms.append( $('#midia_box') );
			$('<input type="submit" class="submit" value="Salvar" />')
				.appendTo(frms);
		}
		this.ok = true;
	},
/* submete um box de form */
	submitThis: function( form ){
		var id = $(form).attr('id').replace(/\D+/,'');
		if( $('#midias_'+id).val() == '' ){ return false; }
		form.submit();		
		$('<div class="midia-overlay">')
			.css({width: '271px', opacity: .66, background: '#000', height: '143px', position: 'relative', top: '-140px'})
			.appendTo('#midia_wrapper_'+id);
		$('<div class="content-midia">Enviando...<br /></div>')
			.css({textAlign:'center',position:'relative',top:'-230px',color:'#FFF',fontWeight:'bold'})
			.appendTo('#midia_wrapper_'+id)
			.append(this.mImg[1].cloneNode(true));
		return false;
	}
});
/* pre-loada as imagens */
var base_dir = './midia';
	RB.mImg[0] = new Image();
	RB.mImg[0].src = RB.printf('%r/rbMidiaPack/rem.png', base_dir);
	RB.mImg[1] = new Image();
	RB.mImg[1].src = RB.printf('%r/rbMidiaPack/bar.gif', base_dir);
/* carrega o css */
	RB._loadCss(RB.printf('%r/rbMidiaPack/rbMidiaPack.css', base_dir) );
})(RB,jQuery);