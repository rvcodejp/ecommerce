<?php

namespace Hcode;

use Rain\Tpl;

class Mailer {

	const USERNAME = "jhonjoaopaulo17@gmail.com";
	const PASSWORD = "910671jp";
	const NAME_FROM = "Hcode Store";

	private $mail;

	public function __construct ($toAddress, $toName, $subject, $tplName, $data = array())
	{

		$config = array(
					"tpl_dir"       => $_SERVER ["DOCUMENT_ROOT"]."/views/email/",
					"cache_dir"     => $_SERVER ["DOCUMENT_ROOT"]. "/views-cache/",
					"debug"         => false
				   );

	Tpl::configure( $config );

	$tpl = new Tpl;

	foreach ($data as $key => $value) {
		$tpl->assign($key, $value);
	}

	$html = $tpl->draw($tplName, true);

$this->mail = new \PHPMailer;

// Diga ao PHPMailer para usar o SMTP
$this->mail->isSMTP ();

// Ativar depuração de SMTP
// 0 = off (para uso em produção)
// 1 = mensagens do cliente
// 2 = mensagens do cliente e do servidor
$this->mail->SMTPDebug = 0;

// Solicitar saída de depuração compatível com HTML
$this->mail->Debugoutput = 'html';

// Definir o nome do host do servidor de email
$this->mail->Host = 'smtp.gmail.com';
// usar
//$this->mail->Host = gethostbyname ('smtp.gmail.com');
// se sua rede não suporta SMTP sobre IPv6

// Defina o número da porta SMTP - 587 para o TLS autenticado, também conhecido como envio SMTP RFC4409
$this->mail->Port = 587;

$this->mail->isSMTP();
$this->mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

// Definir o sistema de criptografia para usar - ssl (reprovado) ou tls
$this->mail->SMTPSecure = 'tls';

// Se deseja usar a autenticação SMTP
$this->mail->SMTPAuth = true;

// Nome de usuário para usar na autenticação SMTP - use o endereço de e-mail completo para o gmail
$this->mail->Username = Mailer::USERNAME;

// Senha para usar para autenticação SMTP
$this->mail->Password = Mailer::PASSWORD;

// Defina para quem a mensagem deve ser enviada
$this->mail->setFrom (Mailer::USERNAME, Mailer::NAME_FROM);

// Definir um endereço de resposta alternativo
//$mail-> addReplyTo ('jhonjoaopaulo17@gmail.com',' segunda recuperacao ');

// Defina para quem a mensagem será enviada
$this->mail->addAddress($toAddress, $toName);

// Definir a linha de assunto
$this->mail->Subject = $subject;

// Leia um corpo de mensagem HTML de um arquivo externo, converta imagens referenciadas em
// converte HTML em um corpo alternativo de texto simples básico
$this->mail->msgHTML($html);

// Substitua o corpo do texto simples por um criado manualmente
$this->mail->AltBody = 'Este é um corpo de mensagem de texto simples';

// Anexe um arquivo de imagem
//$this->mail-> addAttachment ('images / phpmailer_mini.png');

// envia a mensagem, verifique se há erros
}

public function send()
{

	return $this->mail->send();
}
}


?>