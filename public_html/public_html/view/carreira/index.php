<?php
    /**
     * Passarelli Advocacia *
     * @author      Rafael Benites <rbenites@gestaoativa.com.br>
     * @author      Mahmod A. Issa <muh@gestaoativa.com.br>
     */

    // Inclusão do template de cabeçalho do projeto
    include_once dirname(dirname(dirname(__FILE__))).'/template/head.inc.php';
    ?>
	<h1>
    <?php
        echo $pagina->titulo;
        ?>
    </h1>

<?php
    echo $pagina->texto;
    ?>
	<hr class="space" />
<?php 
    array_msg_to_html("error",false);
    array_msg_to_html("notice",false);
    array_msg_to_html("success",false);
    ?>

	<form action="" method="post" id="form-contato" enctype="multipart/form-data" class="frm-carreira span-13 prepend-5">
		<p>
			<label for="nome">*Nome:</label>
			<input class="span-13" type="text" id="nome" value="<?php echo $input['nome']; ?>" name="input[nome]" />
		</p>
		<p>
			<label for="mail">*E-mail:</label>
			<input class="span-13" type="text" id="mail" value="<?php echo $input['email']; ?>" name="input[email]" />
		</p>
		<p>
			<label for="fone">*Telefone:</label>
			<input class="span-13 telefone" type="text" id="fone" value="<?php echo $input['telefone']; ?>" name="input[telefone]" />
		</p>
		<p>
			<label for="cel">*Celular:</label>
			<input class="span-13 telefone" type="text" id="cel" value="<?php echo $input['celular']; ?>" name="input[celular]" />
		</p>
		<p>
			<label for="funcao">*Função Desejada:</label>
			<input class="span-13" type="text" id="funcao" value="<?php echo $input['funcao_desejada']; ?>" name="input[funcao_desejada]" />
		</p>
		<p>
			<label for="mail">*Mensagem:</label>
			<textarea class="span-13" rows="0" cols="0" name="input[mensagem]" ><?php echo $input['mensagem']; ?></textarea>
		</p>
		<p class="left anexar">
			<input type="file" name="anexo" />
		</p>
		<p class="right">
			<input type="submit" name="btnContato" value="ENVIAR"/>
		</p>
	</form>
    <div class="clear"></div>
<?php
	/**
	 * Inclusão do template de rodapé do projeto
	 */
	include_once TPL_PATH . '/footer.inc.php';