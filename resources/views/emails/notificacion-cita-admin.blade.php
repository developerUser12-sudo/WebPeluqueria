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


                            <p>Se acaba de realizar una cita en LM Barber</p>
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