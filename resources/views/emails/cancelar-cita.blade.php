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
                                <img
                                    src="https://res.cloudinary.com/dajh0uyig/image/upload/v1774349669/logo-sin-fondo_xb5st8.png">
                            </a>
                            <h4>
                                Hola, {{ ucfirst($cita->nombre) }}
                            </h4>
                            <p>
                                Si deseas cancelar tu cita, pulsa aqui:
                            </p>
                            <a href="{{ route('citas.cancelar', $cita->token) }}"
                                style="display:inline-block;padding:10px 20px;background:#222322;color:white;border-radius:12px;text-decoration:none;">
                                Cancelar cita
                            </a>

                            <p>Estos son los detalles de tu cita 💈</p>
                            <div style="margin-top:20px;text-align:left;">
                                <p><strong>Servicio:</strong> {{ str_replace('_', ' ', $cita->servicio) }}</p>
                                <p><strong>Profesional:</strong> {{ ucfirst($cita->peluquero) }}</p>
                                <p><strong>Día:</strong> {{ $cita->dia }}</p>
                                <p><strong>Hora:</strong> {{ $cita->hora }}</p>
                                <p><strong>Precio:</strong> {{ $cita->precio }}€</p>
                            </div>


                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>