<?php

class MailService
{
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