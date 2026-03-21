@extends('layouts.app')
@section('card-style', 'width:500px')
@section('content')

    <h5 class="text-light mb-4">Recomendamos hacer inicio de sesión para futuras citas, comunicaciones y
        promociones.</h5>
    <form method="POST" action="{{ route('reservar') }}">
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
                <label for="telefono" class="text-light">Teléfono (9 digitos y sin espacio)</label>
                <input id="telefono" type="text" name="telefono" class="form-control">
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
                    <option value="afeitado_de_cabeza_y_barba"
                        data-info="Afeitado a máquina más el ritual de barba con toalla caliente. 30 min - 10€">
                        Afeitado de cabeza + barba</option>
                    <option value="arreglo_de_barba"
                        data-info="Un servicio para los que su barba le importa, corte a máquina, tijeras, navaja y por supuesto toalla cálida. 15 min - 6€">
                        Arreglo de barba</option>
                    <option value="corte_y_barba"
                        data-info="El arreglo de barba en este caso se hace exclusivamente a máquina y con el marcado superior a navaja. 30 min - 13€">
                        Corte + barba</option>
                    <option value="corte_y_barba_ritual"
                        data-info="El ritual es una experiencia de relajación en la que el cliente disfrutará de un arreglo de barba clásico con toalla. 30 min - 15€">
                        Corte + barba ritual</option>
                    <option value="corte_de_pelo"
                        data-info="Desde corte clásico totalmente a tijera hasta un degradado pulido desde afeitadora, además de un asesoramiento personal. 30 min - 10€">
                        Corte de pelo</option>
                </select>

                <small class="text-danger mt-2 " id="servicio-error"></small>
                <small class="text-light mt-2 d-block" id="detalles"></small>

            </div>

            <div class="form-group mt-3">
                <label for="profesional" class="text-light">Profesional</label>
                <select class="form-control" id="profesional" name="peluquero" required>
                    <option value="" selected disabled hidden>Escoge profesional</option>
                    <option value="luis">Luis</option>
                    <option value="hugo">Hugo</option>
                </select>
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

            <button type="button" id="atras2" class="btn btn-secondary mt-4">Atrás</button>
            <button id="reservar" type="submit" class="btn btn-success mt-4">Reservar</button>
        </div>
    </form>



    <script>
        let fase1 = document.getElementById('phase1');
        let fase2 = document.getElementById('phase2');
        let fase3 = document.getElementById('phase3');
        let servicios = document.getElementById('servicio');
        let nombre = document.getElementById('nombre');
        let telefono = document.getElementById('telefono');
        let usuario = @json($usuario);
        let botonAtras1 = document.getElementById('atras1');
        let nombreError = document.getElementById('nombre-error');
        let apellidoError = document.getElementById('apellido-error');
        let telefonoError = document.getElementById('telefono-error');
        let servicioError = document.getElementById('servicio-error');
        let profesionalError = document.getElementById('profesional-error');
        let diaError = document.getElementById('dia-error');
        let horaError = document.getElementById('hora-error');
        const ahora = new Date();
        const yyyy = ahora.getFullYear();
        const mm = String(ahora.getMonth() + 1).padStart(2, '0');
        const dd = String(ahora.getDate()).padStart(2, '0');
        const fecha = `${yyyy}-${mm}-${dd}`;

        function telefonoValido(tel) {
            const regex = /^\d{9}$/;
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
                telefonoError.textContent = 'Dato faltante o formato incorrecto';
                return;
            }

            fase2.style.display = 'block'
            fase1.style.display = 'none'
        })
        document.getElementById('continuar2').addEventListener('click', function () {
            servicioError.textContent = '';
            if (servicios.value == '') {
                servicioError.textContent = 'Debes escoger un servicio';
                return;
            }if (document.getElementById('profesional').value=='') {
                profesionalError.textContent = 'Debes escoger un profesional';
                return;
                
            }
            fase3.style.display = 'block'
            fase2.style.display = 'none'

        })
        document.getElementById('reservar').addEventListener('click', function () {
            if (dia.value == '') {
                diaError.textContent = 'Dato faltante';
                return;
            }
            if (hora.value == '') {
                horaError.textContent = 'Dato faltante';
                return;
            }
        })
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
        const diasBloqueados = @json($diasBloqueados);
        const horasBloqueadas = @json($horasBloqueadas);

        flatpickr("#dia", {
            dateFormat: "Y-m-d",
            locale: "es",
            minDate: "today",
            maxDate: new Date().fp_incr(30),
            disable: [
                function (date) {
                    const yyyy = date.getFullYear();
                    const mm = String(date.getMonth() + 1).padStart(2, '0');
                    const dd = String(date.getDate()).padStart(2, '0');
                    const fechaLocal = `${yyyy}-${mm}-${dd}`;
                    const minutosAhora = ahora.getHours() * 60 + ahora.getMinutes();
                    let limite;
                    if (date.getDay() === 6) {
                        limite = 13 * 60;
                    }
                    else {
                        limite = 20 * 60 + 30;
                    }
                    const hoyFueraHorario = fechaLocal === fecha && minutosAhora > limite;
                    return date.getDay() === 0 || diasBloqueados.includes(fechaLocal) || hoyFueraHorario;
                }
            ],
            onChange: function (selectedDates, dateStr, instance) {

                generarHoras(dateStr);
            }

        });


        function esMasDe5MinMayor(horaStr) {

            const minutosAhora = ahora.getHours() * 60 + ahora.getMinutes();

            const [h, m] = horaStr.split(':');
            const minutosParametro = parseInt(h) * 60 + parseInt(m);

            return minutosParametro > minutosAhora + 5;
        }
        function generarHoras(params) {

            document.getElementById('hora').innerHTML = '';
            let horas = new Array();
            let horaParametro = new Date(params)

            if (horaParametro.getDay() == 6) {
                horas = ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00'];
            } else {
                horas = ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30'];

            }
            if (horasBloqueadas.length == 0) {
                for (let i = 0; i < horas.length; i++) {

                    if (params == fecha) {
                        if (esMasDe5MinMayor(horas[i])) {
                            let opt = document.createElement('option');
                            opt.value = horas[i];
                            opt.innerHTML = horas[i];
                            document.getElementById('hora').appendChild(opt);

                        }
                    } else {
                        let opt = document.createElement('option');
                        opt.value = horas[i];
                        opt.innerHTML = horas[i];
                        document.getElementById('hora').appendChild(opt);
                    }
                }
                return;
            }
            for (let index = 0; index < horasBloqueadas.length; index++) {
                if (horasBloqueadas[index].fecha_inicio.split('T')[0] == params) {
                    for (let secondIndex = 0; secondIndex < horas.length; secondIndex++) {
                        if (!(horas[secondIndex] >= horasBloqueadas[index].fecha_inicio.split('T')[1] && horasBloqueadas[index].fecha_fin.split('T')[1] > horas[secondIndex])) {
                            if (params == fecha) {
                                if (esMasDe5MinMayor(horas[secondIndex])) {
                                    let opt = document.createElement('option');
                                    opt.value = horas[secondIndex];
                                    opt.innerHTML = horas[secondIndex];
                                    document.getElementById('hora').appendChild(opt);

                                }
                            } else {
                                let opt = document.createElement('option');
                                opt.value = horas[secondIndex];
                                opt.innerHTML = horas[secondIndex];
                                document.getElementById('hora').appendChild(opt);

                            }
                        }

                    }
                } else {
                    for (let thirdIndex = 0; thirdIndex < horas.length; thirdIndex++) {

                        if (params == fecha) {
                            if (esMasDe5MinMayor(horas[thirdIndex])) {
                                let opt = document.createElement('option');
                                opt.value = horas[thirdIndex];
                                opt.innerHTML = horas[thirdIndex];
                                document.getElementById('hora').appendChild(opt);

                            }
                        } else {
                            let opt = document.createElement('option');
                            opt.value = horas[thirdIndex];
                            opt.innerHTML = horas[thirdIndex];
                            document.getElementById('hora').appendChild(opt);
                        }

                    }

                }

            }
        }
    </script>

@endsection