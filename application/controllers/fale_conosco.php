<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fale_conosco extends CI_Controller {

    public function index(){
        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Fale conosco', 'link' => '');
        $data['title'] = 'Fale conosco';
        
        if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['assunto']) && isset($_POST['mensagem']) && isset($_POST['telefone']) ){
            $body = "<h2>Contato atraves do site: http://desaparecidos.ice.ufjf.br/</h2>";
            $body .= "<br /><strong>Nome: </strong>" . utf8_decode($_POST['nome']);
            $body .= "<br /><strong>E-mail: </strong>" . $_POST['email'];
            $body .= "<br /><strong>Assunto: </strong>" . utf8_decode($_POST['assunto']);
            $body .= "<br /><strong>Telefone: </strong>" . $_POST['telefone'];
            $body .= "<br /><strong>Mensagem: </strong>" . utf8_decode($_POST['mensagem']);

            require_once('library/phpmailer/class.phpmailer.php');
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            //Add SMTP User
            $mail->Username = "";
            //Add SMTP Pass
            $mail->Password = "";
            $mail->From = $_POST['email'];
            $mail->FromName = $_POST['nome'];
            //Add mail to
            $mail->AddAddress("",$_POST['nome']);
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = "Contato Desaparecidos - UFJF";
            $mail->Body = $body;
            if(!$mail->Send()){
                $data['msg']['send'] = false;
                $data['msg']['text'] = "Ocorreu um erro no envio da mensagem. Tente mais tarde.";
            }else{
                $data['msg']['send'] = true;
                $data['msg']['text'] = "Sua mensagem foi enviada com sucesso!";
            }
        }

        $this->load->view('tema/pages/fale_conosco', $data);
    }
}

/* End of file fale_conosco.php */
/* Location: ./application/controllers/fale_conosco.php */