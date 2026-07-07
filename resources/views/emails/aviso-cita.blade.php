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
                                <img src="https://res.cloudinary.com/dajh0uyig/image/upload/v1774349669/logo-sin-fondo_xb5st8.png">
                            </a>

                            <p>Hay una cita disponible en la franja horaria que seleccionaste en la lista de espera. Si no quieres quedarte sin tu cita, reserva a través de nuestra web.</p>
                            <div style="margin-top:20px;text-align:left;">
                                <p><strong>Franja horaria seleccionada:</strong></p>
                                <p><strong>De:</strong> {{ $lista->hora_inicio }}</p>
                                <p><strong>A:</strong> {{ $lista->hora_fin }}</p>
                                <p><strong>Día:</strong> {{ $lista->dia }}</p>
                                
                            </div>
                            

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>