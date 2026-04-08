<?php
    set_time_limit(0);
    
//############# Configuração ######################
 // id da pagina a ser usado
	$pagina_id 		= 105;
 // indicação de quantidade de midias
	$pagina_midias 	= 0;
 //campos obrigatórios do formulário de contato
	$required		= array('nome','email','telefone','celular','funcao_desejada','mensagem');
 // caminho para o phpmailer
	$mailer_path 	= LIB_PATH . '/class.phpmailer.php'; 
 // Sera necessário a autenticação "smtp"
	$smtp_config = array(
		"smtp" => true,
		"auth" => true,
		"host" => "localhost:25",
		"user" => "contato@passarelli.adv.br", // este sempre será o "remetente do email"
		"pass" => "bfaxB8UZ1dKH"
	);
 // Módulo view
    $siteConfig->modulo = 'carreira';
 // Tipo de arquivos permitidos(anexo)
    $ext_permitidas     = array('pdf','doc','docx');
//############# Configuração #####################
 
 // dados vindos do form
	if (isset($_POST['btnContato'])) {
		$input = trimArray($_POST['input']);
	    
        // email inválido considerado "vazio"
		if (!valida_email($input['email'])) {
			$input['email'] = '';
        }
		
        $break = temVazio ($input, $required);
		if ($break) {
			add_msg( sprintf('O campo [%s] foi preenchido incorretamente', $break), 'error' );
        }
		else {
            $anexo = $_FILES['anexo'];
            
            if (!empty($anexo['tmp_name'])) {
                $ext = substr($anexo['name'],strrpos($anexo['name'],'.') + 1);
                
                if (in_array($ext,$ext_permitidas)) {
                    // Caminho temporario(anexo)
                    $path = BASE_PATH . '/temp/' . rand(111111,99999) . '.' . $ext;
                    
                    if (move_uploaded_file($anexo['tmp_name'],$path)) {
                        /**
                         * Inclusão da classe PHPMaile para auxiliaar o envio de email
                         */
                        include_once($mailer_path);
                        
                        // definição do corpo da mensagem
                        $body  = "
                            <div style=\"width:550px;border:1px solid #EEE;background:#FFF;color:#000;margin:0 auto;font:10pt verdana,arial;padding:10px;\">
                                <h2 style=\"text-align:center;\">
                                    Contato pelo site - {$the_client}
                                </h2>
                        ";

                        // insere os campos necessários
                        foreach ($input as $i => $v) {
                            $body .= sprintf('
                                <div>
                                    <strong>%s</strong>:<br />
                                    %s
                                </div>
                            ',ucfirst($i),nl2br(stripslashes($v)));
                        }

                        $body .= "
                                <p style=\"font-size:8pt;color:#999;text-align:right\">
                                    Mensagem recebida em: {$the_day}, {$the_hour}
                                </p>
                            </div>
                        ";
                        
                        // instanciar a classe de envio
                        $mail = new PHPMailer();
                        if ($smtp_config["smtp"]) {
                            $mail->SetFrom($smtp_config['user'], $input['nome']);
                            $mail->AddReplyTo($input['email'], $input['nome']);
                            $mail->IsSMTP();
                            $mail->SMTPAuth = $smtp_config['auth'];
                            $mail->Username = $smtp_config['user'];
                            $mail->Password = $smtp_config['pass'];
                            $mail->Host     = $smtp_config['host'];
                        }
                        else {
                            $mail->SetFrom($input['email'], $input['nome']);
                        }
                        $mail->Subject	= "{$the_client} - Contato pelo Site";
                        $mail->CharSet	= 'UTF-8';
                        $mail->AltBody	= 'É necessário um visualizador de email compatível com HTML'; 
                        $mail->IsHTML(true);
                        $mail->Body     = $body;
                        $mail->WordWrap = 50;
                        $mail->AddAttachment($path,$anexo['name']);
                        
                        // adiciona os -mail que possivelmente receberão o e-mail
                        $mails = explode(";", $siteConfig->email);
                        
                        foreach ($mails as $email) {
                            $mail->AddAddress($email);
                        }
                        
                        // envia
                        if (@$mail->Send()) {
                            add_msg("Agradecemos pelo contato!", 'success');
                            $input = array();
                        }
                        else { 
                            add_msg("Erro ao enviar contato! Tente mais tarde", 'error');
                        }
                        
                        // Remove o anexo
                        unlink($path);
                    }
                    else {
                        add_msg('Ocorreu algum erro no envio do arquivo, tente novamente!','error');
                    }
                }
                else {
                    add_msg('Apenas arquivos com as seguintes extensões podem ser enviados: ' . implode(',',$ext_permitidas),'error');
                }
            }
            else {
                add_msg('O envio de um anexo é obrigatório!','error');
            }
        }
	}

 // Faz a busca pelos dados da página
	$pagina = sqlFetch(sprintf('SELECT * FROM `rb_paginas` WHERE `id` = %d', $pagina_id));
	
    if (empty($pagina)) {
		$pagina = (object)array(
			'id'          => 0,
			'titulo'      => 'Erro',
			'texto'	      => '<p>Erro inesperado ao recuperar dados. Por favor tente mais tarde!</p>',
			'keywords'    => '',
			'description' => ''
		);
	}
    
	// recupera as midias da pagina
	$pagina->midias = getMidia($pagina->id, 'paginas', $pagina_midias);
    
    // Atualiza titulo e dados de keywords e description
	if (!empty($pagina->keywords)) {
		$siteConfig->keywords = $pagina->keywords;
    }
	if (!empty($pagina->description)) {
		$siteConfig->description = $pagina->description;
	}
    $siteConfig->titulo = sprintf('%s | %s', $pagina->titulo, $siteConfig->titulo);
    
    // Breadcrumb
	$breadcrumb = array(
		'Home'          => HOME_URL,
        $pagina->titulo => 'javascript:void(0)'
    );