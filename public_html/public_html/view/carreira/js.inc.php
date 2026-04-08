    <script src="<?=JS_URL?>/jquery.validate.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function() {
            $("#form-contato").validate({			
                rules: {				
                    "input[nome]" : "required",
                    "input[email]" : { "required" : true, "email" : true },
                    "input[telefone]" : "required",
                    "input[celular]" : "required",
                    "input[funcao_desejada]" : "required",
                    "input[mensagem]" : "required"
                },
                messages : {
                    "input[nome]" : {"required" : 'Campo Obrigatório!'},
                    "input[email]" : {"required" : 'Campo Obrigatório!',email : 'E-Mail inválido!'},
                    "input[telefone]" : {"required" : 'Campo Obrigatório!'},
                    "input[celular]" : {"required" : 'Campo Obrigatório!'},
                    "input[funcao_desejada]" : {"required" : 'Campo Obrigatório!'},
                    "input[mensagem]" : {"required" : 'Campo Obrigatório!'}
                }
            });
            
            $('.telefone').keyup(function () {
				var number   = $(this).val().replace(/[^0-9]/g,'').substring(0,11);
                var mask     = '(__) ____-____';
                var u_pos    = null;
				
				if (number.length == 11) {
                    mask = '(__) _____-____';
				}
				
				for (var i = 0; i < number.length; i++) {
                    mask = mask.replace('_',number[i]);
                }
                u_pos = mask.indexOf('_');
                
                if (u_pos > -1) {
                    mask = mask.substring(0,u_pos);
				}
                
				$(this).val(mask);
			}).attr('maxlength',15).blur(function () {
                if ($(this).val().length < 14) {
                    $(this).val('');
                }
            });
        });
      // ]]>
    </script>

