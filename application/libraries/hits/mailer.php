<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailer  {
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->library('hits/my_phpmailer');
        
	}
	public function enviarMail($asunto='', $cuerpo='', $data='', $destinatarios='') {
        $config = $this->ci->config->item('ext_base_smtp_config_editable');
    	$mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsHTML(true);
        $mail->IsSMTP();
        
        //$mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth   = $config['smtp_auth']; // enabled SMTP authentication
        $mail->SMTPSecure = $config['SMTPSecure'];  // prefix for secure protocol to connect to the server
        $mail->Helo       = $config['smtp_user'];
        $mail->Host       = $config['smtp_host'];      // setting GMail as our SMTP server
        $mail->Port       = $config['smtp_port'];                   // SMTP port to connect to GMail
        $mail->Username   = $config['smtp_user'];  // user email address
        $mail->Password   = $config['smtp_pass'];            // password in GMail
        $mail->SetFrom($config['smtp_user'], 'Sabandijas Rodados');
        $mail->Subject    = $asunto;
        $mail->Body       = $this->ci->load->view($cuerpo, $data, TRUE);
        foreach ($destinatarios as $destino) {
        	if($destino['email'] != '') {
        		$mail->AddAddress($destino['email'], $destino['nombre']);
        	}
        }
        if($mail->Send()) {
            $mail->ClearAddresses();
            $mail->ClearAllRecipients();
            return TRUE;
        }
        else {
            echo $mail->ErrorInfo;
            return FALSE;
        }
	}
}
?>