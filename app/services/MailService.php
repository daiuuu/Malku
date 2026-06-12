<?php

require_once __DIR__ . '/../../vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../vendor/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../../config/mail.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    // ================= INSTANCIA PHPMAILER =================
    private function crearMailer()
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USUARIO;
        $mail->Password   = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_SEGURIDAD;
        $mail->Port       = MAIL_PORT;
        $mail->CharSet    = MAIL_CHARSET;

        $mail->setFrom(
            MAIL_FROM,
            MAIL_FROM_NAME
        );

        return $mail;
    }

    // ================= RECUPERAR CONTRASEÑA =================
    public function enviarRecuperacion(
        $emailDestino,
        $nombre,
        $token
    )
    {
        try
        {
            $enlace =
                BASE_URL .
                '/nueva-password?token=' .
                $token;

            $mail = $this->crearMailer();

            $mail->addAddress(
                $emailDestino,
                $nombre
            );

            $mail->isHTML(true);

            $mail->Subject =
                'Recuperar contraseña - Malku';

            $mail->Body = "
                <html>
                <body
                    style='
                        font-family: Arial, sans-serif;
                        background: #f5f1e8;
                        padding: 40px 20px;
                        margin: 0;
                    '
                >
                    <div
                        style='
                            background: #ffffff;
                            max-width: 560px;
                            margin: 0 auto;
                            padding: 48px 40px;
                            border: 1px solid rgba(0,0,0,0.07);
                        '
                    >

                        <p
                            style='
                                margin: 0 0 8px;
                                font-size: 11px;
                                letter-spacing: 3px;
                                text-transform: uppercase;
                                color: #79836d;
                            '
                        >
                            Malku
                        </p>

                        <h2
                            style='
                                margin: 0 0 24px;
                                font-size: 26px;
                                font-weight: 300;
                                color: #111111;
                                letter-spacing: -0.5px;
                            '
                        >
                            Recuperar contraseña
                        </h2>

                        <p
                            style='
                                margin: 0 0 16px;
                                font-size: 15px;
                                line-height: 1.8;
                                color: #555;
                            '
                        >
                            Hola {$nombre},
                        </p>

                        <p
                            style='
                                margin: 0 0 32px;
                                font-size: 15px;
                                line-height: 1.8;
                                color: #555;
                            '
                        >
                            Recibimos una solicitud para restablecer
                            la contraseña de tu cuenta. Hacé clic
                            en el botón para continuar.
                        </p>

                        <a
                            href='{$enlace}'
                            style='
                                display: inline-block;
                                padding: 14px 32px;
                                background: #79836d;
                                color: #ffffff;
                                text-decoration: none;
                                font-size: 12px;
                                letter-spacing: 2px;
                                text-transform: uppercase;
                                border-radius: 999px;
                            '
                        >
                            Restablecer contraseña
                        </a>

                        <p
                            style='
                                margin: 32px 0 0;
                                font-size: 13px;
                                line-height: 1.8;
                                color: #999;
                            '
                        >
                            Si no solicitaste este cambio, podés
                            ignorar este correo. El enlace expira
                            en 1 hora.
                        </p>

                        <hr
                            style='
                                border: none;
                                border-top: 1px solid rgba(0,0,0,0.07);
                                margin: 32px 0 24px;
                            '
                        >

                        <p
                            style='
                                margin: 0;
                                font-size: 11px;
                                color: #bbb;
                                letter-spacing: 1px;
                            '
                        >
                            © Malku — Todos los derechos reservados
                        </p>

                    </div>
                </body>
                </html>
            ";

            $mail->AltBody =
                "Recuperar contraseña - Malku\n\n" .
                "Hola {$nombre},\n\n" .
                "Hacé clic en el siguiente enlace para " .
                "restablecer tu contraseña:\n\n" .
                "{$enlace}\n\n" .
                "Si no solicitaste este cambio, ignorá este correo.";

            $mail->send();

            return [
                'success' => true
            ];
        }
        catch(Exception $e)
        {
            error_log(
                'MailService::enviarRecuperacion() - ' .
                $mail->ErrorInfo
            );

            return [
                'success' => false,
                'error'   => $mail->ErrorInfo
            ];
        }
    }

    // ================= ENVIAR CONSULTA =================
    public function enviarConsultaContacto(
        Contacto $contacto
    )
    {
        try
        {
            $destinatario = 'hola@malku.com';

            $titulo = 'Nueva consulta desde Malku';

            $contenido = "
                <html>
                <body
                    style='
                        font-family: Arial;
                        background: #f5f5f5;
                        padding: 30px;
                    '
                >

                    <div
                        style='
                            background: white;
                            padding: 30px;
                            border-radius: 10px;
                            max-width: 700px;
                            margin: auto;
                        '
                    >

                        <h2>
                            Nueva consulta recibida
                        </h2>

                        <p>
                            <strong>Nombre:</strong>
                            {$contacto->getNombre()}
                        </p>

                        <p>
                            <strong>Email:</strong>
                            {$contacto->getEmail()}
                        </p>

                        <p>
                            <strong>Asunto:</strong>
                            {$contacto->getAsunto()}
                        </p>

                        <hr>

                        <p>
                            <strong>Mensaje:</strong>
                        </p>

                        <p>
                            " . nl2br($contacto->getMensaje()) . "
                        </p>

                    </div>

                </body>
                </html>
            ";

            $headers = "MIME-Version: 1.0\r\n";

            $headers .=
                "Content-type:text/html;charset=UTF-8\r\n";

            $headers .=
                "From: {$contacto->getNombre()} <{$contacto->getEmail()}>\r\n";

            return mail(
                $destinatario,
                $titulo,
                $contenido,
                $headers
            );
        }
        catch(Exception $e)
        {
            error_log(
                'Error MailService: ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= EMAIL AUTOMÁTICO =================
    public function enviarConfirmacionUsuario(
        Contacto $contacto
    )
    {
        try
        {
            $titulo = 'Recibimos tu consulta - Malku';

            $contenido = "
                <html>

                <body
                    style='
                        font-family: Arial;
                        background: #f5f5f5;
                        padding: 30px;
                    '
                >

                    <div
                        style='
                            background: white;
                            padding: 30px;
                            border-radius: 10px;
                            max-width: 700px;
                            margin: auto;
                        '
                    >

                        <h2>
                            Hola {$contacto->getNombre()},
                        </h2>

                        <p>
                            Gracias por comunicarte con Malku.
                        </p>

                        <p>
                            Recibimos tu mensaje correctamente y
                            responderemos a la brevedad.
                        </p>

                        <br>

                        <p>
                            — Atelier Malku
                        </p>

                    </div>

                </body>

                </html>
            ";

            $headers = "MIME-Version: 1.0\r\n";

            $headers .=
                "Content-type:text/html;charset=UTF-8\r\n";

            $headers .=
                "From: Malku <hola@malku.com>\r\n";

            return mail(
                $contacto->getEmail(),
                $titulo,
                $contenido,
                $headers
            );
        }
        catch(Exception $e)
        {
            error_log(
                'Error MailService: ' .
                $e->getMessage()
            );

            return false;
        }
    }
}
