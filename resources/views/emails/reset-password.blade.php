<!DOCTYPE html>
<html>

<body style="font-family:Arial;background:#f4f4f4;padding:40px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="500" cellpadding="0" cellspacing="0"
                    style="background:black;padding:30px;border-radius:8px;color:white;">

                    <tr>
                        <td align="center">

                            <a href="{{ config('app.url') }}">
                                <img src="https://res.cloudinary.com/dajh0uyig/image/upload/v1774349669/logo-sin-fondo_xb5st8.png"
                                    alt="LM Barber" width="140">
                            </a>

                            <h2>Hola, {{ $user->name }}</h2>

                            <p>Has solicitado restablecer tu contraseña en LM Barber.</p>

                            <div style="margin-top: 30px;">
                                <a href="{{ $url }}"
                                   style="border-radius: 12px;background-color:#222322;color:white;padding:12px 20px;text-decoration:none;display:inline-block;">
                                   Restablecer contraseña
                                </a>
                            </div>

                            <p style="margin-top:30px;color:#777">
                                Si no solicitaste este cambio, ignora este correo.
                            </p>

                            <p style="margin-top:20px;color:#777">
                                Si tienes problemas para hacer clic en el botón, copia y pega la siguiente URL en tu navegador web: {{ $url }}
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>