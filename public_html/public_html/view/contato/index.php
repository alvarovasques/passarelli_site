<?php
    /**
     * Passarelli Advocacia *
     * @author      Rafael Benites <rbenites@gestaoativa.com.br>
     * @author      Marcelo Meneguesso <marcelo@gestaoativa.com.br>
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
    if (!empty($pagina->midias)) {
        exibeMidia($pagina->midias[0],'',array(910,500));
    }
    ?>
	<hr class="space" />
<?php 
    array_msg_to_html("error",false);
    array_msg_to_html("notice",false);
    array_msg_to_html("success",false);
    ?>

	<form action="" method="post" id="form-contato" class="frm-carreira span-13 append-half">
		<p>
			<label for="nome">*Nome:</label>
			<input class="span-13" type="text" id="nome" name="input[nome]" value="<?php echo $input['nome']; ?>" />
		</p>
		<p>
			<label for="mail">*E-mail:</label>
			<input class="span-13" type="text" id="mail" name="input[email]" value="<?php echo $input['email']; ?>" />
		</p>
		<p>
			<label for="fone">*Telefone:</label>
			<input class="span-13 telefone" type="text" id="fone" name="input[telefone]" value="<?php echo $input['telefone']; ?>" />
		</p>
		<p class="clear assunto">
			<label for="input_assunto">*Assunto:</label>
		<?php
            cria_select_from_query('assunto','SELECT `id`,`titulo` FROM `rb_contato-assuntos` WHERE `ativo` ORDER BY `ordem` ASC',$input['assunto'],'class="selectBox"');
            ?>
		</p>
		<p>
			<label for="mail">*Mensagem:</label>
			<textarea class="span-13" rows="0" cols="0" name="input[mensagem]"><?php echo $input['mensagem']; ?></textarea>
		</p>
		<p class="right">
			<input type="submit" name="btnContato" value="ENVIAR"/>
		</p>
	</form>

	<ul class="span-9">
		<li class="endereco prepend-top">
			<h2 class=" margin-bottom0">Endereço</h2>
			<p>
            <?php
                echo nl2br($siteConfig->endereco);
                ?>
            </p>
		</li>
		<li class="telefone">
			<h2 class=" margin-bottom0">Telefone(s)</h2>
			<p>
            <?php
                echo nl2br($siteConfig->telefone);
                ?>
            </p>	
		</li>
		<li class="mail">
			<h2 class=" margin-bottom0">Email</h2>
			<p>
            <?php
                echo ($pos = strpos($siteConfig->email,';')) !== false ? substr($siteConfig->email,0,$pos) : $siteConfig->email;
                ?>
            </p>		
		</li>
	</ul>


	<div class="clear"></div>
    
<?php
	/**
	 * Inclusão do template de rodapé do projeto
	 */
	include_once TPL_PATH . '/footer.inc.php';
