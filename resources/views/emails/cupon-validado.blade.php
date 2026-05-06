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

                            <h2>Hola, {{ $movimiento->user->name }}. Tu cupón ha sido validado</h2>
                            <p>Recuerda que tienes un máximo de 20 días para usar el cupón en la peluquería.</p>
                            

                            <h2>Tu cupón: {{ $movimiento->cupongenerado->cupon }}</h2>
                            <h3>Oferta canjeada: {{ $movimiento->cupon->titulo }}</h3>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>