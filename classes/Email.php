<?php

namespace Util;

use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv as Dotenv;

$dotenv = Dotenv::createImmutable('../includes/.env');
$dotenv->safeLoad();

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;        
    }

    public function enviarConfirmacion() {
        //crear el objeto de email
        $email = new PHPMailer();
        // Configurar SMTP
        $email->isSMTP();
        $email->Host = $_ENV['MAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Port = $_ENV['MAIL_PORT'];
        $email->Username = $_ENV['MAIL_USER'];
        $email->Password = $_ENV['MAIL_PASSWORD'];
        $email->SMTPSecure = 'tls';
        

        $email->setFrom('cuentas@appsalon.com');
        $email->addAddress('cuentas@appsalon.com' , 'AppSalon.com');
        $email->Subject = 'Confirma tu Cuenta';

        //set HTML
        $email->isHTML(TRUE);
        $email->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://". $_ENV['SERVER_HOST'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= "</html>";

        $email->Body = $contenido;

        //enviar el mail
        $email->send();
    }

    public function enviarInstrucciones() {
        //crear el objeto de email
        $email->isSMTP();
        $email->Host = $_ENV['MAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Username = $_ENV['MAIL_USER'];
        $email->Password = $_ENV['MAIL_PASSWORD'];
        $email->SMTPSecure = 'tls';
        $email->Port = $_ENV['MAIL_PORT'];

        $email->setFrom('cuentas@appsalon.com');
        $email->addAddress('cuentas@appsalon.com' , 'AppSalon.com');
        $email->Subject = 'Reestablece tu Password';

        //set HTML
        $email->isHTML(TRUE);
        $email->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola<strong> " . $this->nombre . "</strong> has solicitado reestablecer tu password, sigue el enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://". $_ENV['SERVER_HOST'] . "/recuperar?token=" . $this->token . "'>Reestablecer Password</a> </p>";
        $contenido .= "<p>Si no solicitaste esta recuperacion, puedes ignorar este mensaje.</p>";
        $contenido .= "</html>";

        $email->Body = $contenido;

        //enviar el mail
        $email->send();
    }
}