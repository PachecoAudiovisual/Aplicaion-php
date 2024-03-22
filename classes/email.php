<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Email
{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // objeto mail


        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV[ 'EMAIL_HOST' ];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV[ 'EMAIL_PORT' ];
        $mail->Username = $_ENV[ 'EMAIL_USER' ];
        $mail->Password = $_ENV[ 'EMAIL_PASSWORD' ];

        $mail->setFrom('pachecoaudiovisual@gmail.com');
        $mail->addAddress('pachecoaudiovisual@gmail.com', 'appSalo');
        $mail->Subject = 'Confirma tu cuenta';

        //HTML PARA EL MENSAJE

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";


        $contenido = "<html>";
        $contenido .= "<p><strong> HOla " . $this->nombre .  "</strong> Has creado tu cuenta en Salonapp, solo debes confirmar precionando el siguiente enlace!</p>";
        $contenido .= "<p> Preciona aquí: <a href='" . $_ENV['APLICACION_URL'] . "/confirmar-cuenta?token=" . $this->token . "'> Confirmar cuenta </a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje!</p>";
        $contenido .= "</html>";

        $mail->Body  = $contenido;

        // ENVIER

        $mail->send();
    }

    public function enviarInstrucciones()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV[ 'EMAIL_HOST' ];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV[ 'EMAIL_PORT' ];
        $mail->Username = $_ENV[ 'EMAIL_USER' ];
        $mail->Password = $_ENV[ 'EMAIL_PASSWORD' ];

        $mail->setFrom('pachecoaudiovisual@gmail.com');
        $mail->addAddress('pachecoaudiovisual@gmail.com', 'appSalo');
        $mail->Subject = 'Reestablecer password';

        //HTML PARA EL MENSAJE

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";


        $contenido = "<html>";
        $contenido .= "<p><strong> HOla " . $this->nombre .  "</strong> Haz solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo</p>";
        $contenido .= "<p> Preciona aquí: <a href='" . $_ENV['APLICACION_URL'] . "/confirmar-cuenta?token=" . $this->token . "'> Reestablecer password </a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje!</p>";
        $contenido .= "</html>";

        $mail->Body  = $contenido;

        // ENVIER

        $mail->send();
    }
}
