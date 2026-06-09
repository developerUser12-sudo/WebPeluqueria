@extends('layouts.app')
@section('card-style', 'width:500px')
@section('content')

    @guest
        <h5 class="text-light mb-4">Recomendamos hacer inicio de sesión para futuras citas, comunicaciones y
            promociones.</h5>
    @else
    @endguest
    <form method="POST" action="{{ route('reservar') }}" id="form-reserva">
        @csrf
        <div id="phase1">
            <h5 class="text-light mb-3">Datos personales</h5>
            <div class="form-group">
                <label for="nombre" class="text-light">Nombre</label>
                <input id="nombre" type="text" name="nombre" class="form-control">
                <small class="text-danger mt-2 " id="nombre-error"></small>
            </div>

            <div class="form-group mt-3">
                <label for="apellido" class="text-light">Apellido (opcional)</label>
                <input id="apellido" type="text" name="apellido" class="form-control">
            </div>


            <div class="form-group mt-3">
                <label for="telefono" class="text-light">Teléfono (sin espacio, prefijo obligatorio)</label>
                <input id="telefono" type="text" name="telefono" class="form-control" value="+34">
                <small class="text-danger mt-2 " id="telefono-error"></small>
            </div>

            <button type="button" id="continuar1" class="btn btn-primary mt-4">Continuar</button>
        </div>


        <div id="phase2" style="display:none;">
            <h5 class="text-light mb-3">Servicio y profesional</h5>

            <div class="form-group">
                <label for="servicio" class="text-light">Servicio</label>
                <select class="form-control" name="servicio" id="servicio" required>
                    <option value="" selected disabled hidden>Escoge servicio</option>
                    <option value="corte_de_pelo"
                        data-info="Desde corte clásico totalmente a tijera hasta un degradado pulido desde afeitadora, además de un asesoramiento personal. 30 min">
                        Corte de pelo - 11€</option>
                    <option value="corte_y_barba_ritual"
                        data-info="El ritual es una experiencia de relajación en la que el cliente disfrutará de un arreglo de barba clásico con toalla. 45 min">
                        Corte + barba ritual - 15€</option>
                    <option value="afeitado_de_cabeza_y_barba"
                        data-info="Afeitado a máquina más el ritual de barba con toalla caliente. 30 min">
                        Afeitado de cabeza + barba - 12€</option>
                    <option value="afeitado_de_cabeza_o_numero"
                        data-info="Afeitado: Rasurado al límite con las máquinas más apuradas. Un solo número: corte clásico a un solo número con máquina (rapado) y contornos marcados. 15 min cada uno">
                        Afeitado de cabeza o un solo número - 8€</option>
                    <option value="arreglo_de_barba"
                        data-info="Un servicio para los que su barba le importa, corte a máquina, tijeras, navaja y por supuesto toalla cálida. 15 min">
                        Arreglo de barba - 7€</option>
                </select>

                <small class="text-danger mt-2 " id="servicio-error"></small>
                <small class="text-light mt-2 d-block" id="detalles"></small>

            </div>

            <div class="form-group mt-3">
                <label for="profesional" class="text-light">Escoge profesional</label>

                <div class="mt-1 row ">
                    <label class="profesional col">
                        <input type="radio" name="peluquero" value="luis">
                        <img src="/storage/foto-luis.webp" alt="Luis">
                        <i class="fw-bold">Luis</i>
                    </label>
                    <label class="profesional col" id="profesional">
                        <input type="radio" name="peluquero" value="hugo">
                        <img src="/storage/foto-hugo.webp" alt="Hugo">
                        <i class="fw-bold">Hugo</i>
                    </label>
                </div>
                <small class="text-danger mt-2 " id="profesional-error"></small>
            </div>

            <button type="button" id="atras1" class="btn btn-secondary mt-4">Atrás</button>
            <button type="button" id="continuar2" class="btn btn-primary mt-4">Continuar</button>
        </div>


        <div id="phase3" style="display:none;">
            <h5 class="text-light mb-3">Fecha y hora</h5>

            <div class="form-group">
                <label for="dia" class="text-light">Día</label>
                <input type="text" id="dia" name="dia" class="form-control" required>
                <small class="text-danger mt-2 " id="dia-error"></small>

            </div>

            <div class="form-group mt-3">
                <label for="hora" class="text-light">Hora</label>
                <select class="form-control" name="hora" id="hora" required></select>
                <small class="text-danger mt-2 " id="hora-error"></small>

            </div>
            @guest
                <div class="form-group mt-3">
                    <label for="email" class="text-light">Correo electrónico (opcionalmente para poder cancelar tu cita
                        fácilmente)</label>
                    <input id="email" type="email" name="email" class="form-control">
                    <small class="text-danger mt-2 " id="correo-error"></small>
                </div>
            @endguest

            <button type="button" id="atras2" class="btn btn-secondary mt-4">Atrás</button>
            <button id="reservar" type="submit" class="btn btn-success mt-4">Reservar</button>
        </div>
    </form>



    <script>
        const fase1 = document.getElementById('phase1');
        const fase2 = document.getElementById('phase2');
        const fase3 = document.getElementById('phase3');
        const servicios = document.getElementById('servicio');
        const nombre = document.getElementById('nombre');
        const telefono = document.getElementById('telefono');
        const usuario = @json($usuario);
        const botonAtras1 = document.getElementById('atras1');
        const nombreError = document.getElementById('nombre-error');
        const apellidoError = document.getElementById('apellido-error');
        const telefonoError = document.getElementById('telefono-error');
        const servicioError = document.getElementById('servicio-error');
        const profesionalError = document.getElementById('profesional-error');
        const diaError = document.getElementById('dia-error');
        const horaError = document.getElementById('hora-error');
        const correoError = document.getElementById('correo-error');
        const diasBloqueados = @json($diasBloqueados);
        const horasBloqueadas = @json($horasBloqueadas);
        const citas = @json($citas);
        const usuarios = @json($usuarios);
        const emailInput = document.getElementById('email');
        const emailValido = true;
        const ahora = new Date();
        function telefonoValido(tel) {
            for (let index = 0; index < usuarios.length; index++) {
                if (usuarios[index].phone == tel) {

                    return false;

                }

            }
            const regex = /^\+\d{11,15}$/;
            return regex.test(tel);
        }

        if (usuario != null) {
            fase2.style.display = 'block'
            fase1.style.display = 'none'
            if (botonAtras1) {
                botonAtras1.remove();
            }
        }

        servicios.addEventListener('change', function () {
            servicioError.textContent = '';
            const texto = this.options[this.selectedIndex].dataset.info;
            document.getElementById('detalles').textContent = texto;
        })
        document.getElementById('continuar1').addEventListener('click', function () {
            nombreError.textContent = '';
            telefonoError.textContent = '';
            if (nombre.value == '') {
                nombreError.textContent = 'Dato faltante';
                return;
            }

            if (!telefonoValido(telefono.value) || telefono.value == '') {
                telefonoError.textContent = 'Formato incorrecto o teléfono ya existente';
                return;
            }

            fase2.style.display = 'block'
            fase1.style.display = 'none'
        })
        document.getElementById('continuar2').addEventListener('click', function () {
            servicioError.textContent = '';
            profesionalError.textContent = '';
            if (servicios.value == '') {
                servicioError.textContent = 'Debes escoger un servicio';
                return;
            }
            const profesionalSeleccionado = document.querySelector('input[name="peluquero"]:checked');

            if (!profesionalSeleccionado) {
                profesionalError.textContent = 'Debes escoger un profesional';
                return;
            }
            fase3.style.display = 'block'
            fase2.style.display = 'none'

        })
        document.getElementById("form-reserva").addEventListener("submit", function (e) {

            let errores = false;

            if (dia.value == '') {
                diaError.textContent = 'Dato faltante';
                errores = true;
            }

            if (hora.value == '') {
                horaError.textContent = 'Dato faltante';
                errores = true;
            }
            for (let i = 0; i < usuarios.length; i++) {
                if (usuarios[i].email == emailInput.value) {
                    correoError.textContent = 'Correo existente';
                    errores = true;

                }
            }

            if (errores) {
                e.preventDefault();
            }

        });
        if (botonAtras1) {
            botonAtras1.addEventListener('click', function () {
                fase1.style.display = 'block'
                fase2.style.display = 'none'
            })
        }
        document.getElementById('atras2').addEventListener('click', function () {

            fase2.style.display = 'block'
            fase3.style.display = 'none'

        })

        const fp = flatpickr("#dia", {
            dateFormat: "Y-m-d",
            locale: "es",
            minDate: "today",
            maxDate: new Date().fp_incr(30),
            disable: [
                function (date) {
                    const hoy = new Date();
                    const esMismoDia = date.getMonth() === hoy.getMonth() && date.getDate() === hoy.getDate();
                    const minutosAhora = hoy.getHours() * 60 + hoy.getMinutes();
                    if (date.getDay() === 0) {
                        return true;
                    }
                    if (date.getDay() === 6 && esMismoDia && minutosAhora >= 13 * 60) {
                        return true;
                    }
                    if (esMismoDia && minutosAhora >= (20 * 60 + 30)) {
                        return true;
                    }
                    const fechaFormateada = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');

                    if (diasBloqueados.includes(fechaFormateada)) {
                        return true;
                    }


                }

            ],
            onChange: function (selectedDates, dateStr) {
                generarHoras(dateStr);
            }
        });
        document.getElementById('profesional').addEventListener('change', function () {
            fp.clear();
            document.getElementById('hora').innerHTML = '';
        });

        function generarHoras(dia) {
            const fecha = new Date(dia);
            document.getElementById('hora').innerHTML = '';
            let horas = [];

            if (fecha.getDay() === 6) {

                horas = ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00'];

            } else {

                horas = [
                    '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00',
                    '13:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
                    '20:00', '20:30'
                ];

            }
            const hoy = new Date().toISOString().split('T')[0];


            if (dia === hoy) {
                for (let index = horas.length - 1; index >= 0; index--) {
                    const [hh, mm] = horas[index].split(':');
                    const horaComparar = new Date();
                    horaComparar.setHours(hh, mm, 0, 0);
                    if (horaComparar <= ahora) {
                        horas.splice(index, 1);
                    }

                }

            }
            for (let index = 0; index < horasBloqueadas.length; index++) {

                if (horasBloqueadas[index].fecha_inicio.split('T')[0] == dia) {
                    const inicio = new Date(horasBloqueadas[index].fecha_inicio);
                    const fin = new Date(horasBloqueadas[index].fecha_fin);
                    for (let index2 = horas.length - 1; index2 >= 0; index2--) {
                        const [hh, mm] = horas[index2].split(":");
                        const horaComparar = new Date(dia);
                        horaComparar.setHours(hh, mm, 0, 0);
                        if (horaComparar >= inicio && horaComparar <= fin) {
                            horas.splice(index2, 1);
                        }

                    }
                }

            }
            const profesional = document.querySelector('input[name="peluquero"]:checked')?.value;
            if (citas[profesional] != null) {
                const citasOcupadas = citas[profesional];

                for (let index = 0; index < citasOcupadas.length; index++) {
                    for (let index2 = 0; index2 < horas.length; index2++) {

                        if (citasOcupadas[index].hora == horas[index2] && citasOcupadas[index].dia == dia) {
                            horas.splice(index2, 1);
                        }
                    }
                }
            }
            for (let i = 0; i < horas.length; i++) {
                const opt = document.createElement('option');
                opt.value = horas[i];
                opt.innerHTML = horas[i];
                document.getElementById('hora').appendChild(opt);
            }
        }

        document.getElementById("form-reserva").addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
            }
        });
    </script>

@endsection