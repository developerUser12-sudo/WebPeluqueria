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
                <label for="telefono" class="text-light">Teléfono (+34XXXXXXXXX)</label>
                <input id="telefono" type="text" name="telefono" class="form-control" value="+34">
                <small class="text-danger mt-2 " id="telefono-error"></small>
            </div>

            <button type="button" id="continuar1" class="btn btn-primary mt-4">Continuar</button>
        </div>


        <div id="phase2" style="display:none;">
            <h5 class="text-light mb-3">Profesional</h5>



            <div class="form-group mt-3">
                <label for="profesional" class="text-light">Escoge profesional</label>

                <div class="mt-1 row ">
                    <label class="profesional col" id="profesionalLuis">
                        <input type="radio" name="peluquero" value="luis">
                        <img src="/storage/foto-luis.webp" alt="Profesional Luis">
                        <i class="fw-bold">Luis</i>
                    </label>
                    <label class="profesional col" id="profesionalHugo">
                        <input type="radio" name="peluquero" value="hugo">
                        <img src="/storage/foto-hugo.webp" alt="Profesional Hugo">
                        <i class="fw-bold">Hugo</i>
                    </label>
                </div>
                <small class="text-danger mt-2 " id="profesional-error"></small>
            </div>

            <button type="button" id="atras1" class="btn btn-secondary mt-4">Atrás</button>
            <button type="button" id="continuar2" class="btn btn-primary mt-4">Continuar</button>
        </div>


        <div id="phase3" style="display:none;">
            <h5 class="text-light mb-3">Servicio, fecha y hora</h5>

            <div class="form-group">
                <label for="dia" class="text-light">Día</label>
                <input type="text" id="dia" name="dia" class="form-control" required>
                <small class="text-danger mt-2 " id="dia-error"></small>

            </div>

            <div class="form-group mt-3">
                <label for="hora" class="text-light">Hora</label>
                <select class="form-control" name="hora" id="hora" required>
                </select>
                <small class="text-danger mt-2 " id="hora-error"></small>

            </div>
            <div class="form-group mt-3">
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
            @guest
                <div class="form-group mt-3">
                    <label for="email" class="text-light">Correo electrónico (opcional para poder cancelar tu cita
                        fácilmente)</label>
                    <input id="email" type="email" name="email" class="form-control">
                    <small class="text-danger mt-2 " id="correo-error"></small>
                </div>
            @endguest
            <input type="hidden" name="return" value="{{ request('return') }}">

            <button type="button" id="atras2" class="btn btn-secondary mt-4">Atrás</button>
            <button id="reservar" type="submit" class="btn btn-success mt-4">Reservar</button>
        </div>
    </form>
    <form action="{{ route('lista-espera') }}" method="get">
        <input type="hidden" name="dia" id="lista-dia">
        <input type="hidden" name="peluquero" id="lista-peluquero">
        <input type="hidden" name="nombre" id="lista-nombre">
        <input type="hidden" name="apellido" id="lista-apellido">
        <input type="hidden" name="telefono" id="lista-telefono">
        <button type="submit" id="lista-espera-boton" class="btn btn-info mt-3" style="display:none;" disabled>
            Lista de espera
        </button>
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
        let botonListaEspera = document.getElementById('lista-espera-boton');
        function telefonoValido(tel) {
            const regex = /^\+\d{11,15}$/;
            return regex.test(tel);
        }
        function cambiarPrecio(precio1, precio2) {
            for (let i = 0; i < servicios.length; i++) {
                if (servicios[i].value == 'corte_de_pelo') {
                    servicios[i].innerHTML = 'Corte de pelo - ' + precio1 + '€';
                }
                if (servicios[i].value == 'corte_y_barba_ritual') {
                    servicios[i].innerHTML = 'Corte + barba ritual - ' + precio2 + '€';
                }

            }
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

            if (!telefonoValido(telefono.value)) {
                telefonoError.textContent = 'Formato incorrecto';
                return;
            }

            fase2.style.display = 'block'
            fase1.style.display = 'none'
        })
        document.getElementById('continuar2').addEventListener('click', function () {
            profesionalError.textContent = '';

            const profesionalSeleccionado = document.querySelector('input[name="peluquero"]:checked');

            if (!profesionalSeleccionado) {
                profesionalError.textContent = 'Debes escoger un profesional';
                return;
            }
            fase3.style.display = 'block'
            fase2.style.display = 'none'
            botonListaEspera.style.display = 'block';
        })
        document.getElementById("form-reserva").addEventListener("submit", function (e) {
            servicioError.textContent = '';
            if (servicios.value == '') {
                servicioError.textContent = 'Debes escoger un servicio';
                return;
            }
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
            botonListaEspera.style.display = 'none';
        })

        const fp = flatpickr("#dia", {
            dateFormat: "Y-m-d",
            locale: "es",
            minDate: "today",
            maxDate: new Date().fp_incr(40),
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
                    if (esMismoDia && minutosAhora >= (20 * 60)) {
                        return true;
                    }
                    const fechaFormateada = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
                    const profesional = document.querySelector('input[name="peluquero"]:checked')?.value;
                    if (diasBloqueados[profesional]?.includes(fechaFormateada) || diasBloqueados[""]?.includes(fechaFormateada)) {
                        return true;
                    }


                }

            ],
            onChange: function (selectedDates, dateStr) {
                generarHoras(dateStr);
                document.getElementById('lista-dia').value = dateStr;
                const profesional = document.querySelector('input[name="peluquero"]:checked')?.value;

                document.getElementById('lista-nombre').value = nombre.value;
                document.getElementById('lista-apellido').value = apellido.value;
                document.getElementById('lista-telefono').value = telefono.value;

                document.getElementById('lista-peluquero').value = profesional;

            }
        });
        document.getElementById('profesionalLuis').addEventListener('change', function () {
            fp.clear();
            document.getElementById('hora').innerHTML = '';
            for (let index = 0; index < servicios.length; index++) {
                if (servicios[index].value == 'corte_de_pelo' && servicios[index].innerHTML.includes('8€')) {
                    servicios[index].innerHTML = 'Corte de pelo - 11€';
                }
                if (servicios[index].value == 'corte_y_barba_ritual' && servicios[index].innerHTML.includes('13€')) {
                    servicios[index].innerHTML = 'Corte + barba ritual - 15€';
                }


            }
        });
        document.getElementById('profesionalHugo').addEventListener('change', function () {
            fp.clear();
            document.getElementById('hora').innerHTML = '';
            for (let index = 0; index < servicios.length; index++) {
                if (servicios[index].value == 'corte_de_pelo') {
                    servicios[index].innerHTML = 'Corte de pelo - 8€';
                }
                if (servicios[index].value == 'corte_y_barba_ritual') {
                    servicios[index].innerHTML = 'Corte + barba ritual - 13€';
                }


            }
        });

        document.getElementById('hora').addEventListener('change', function () {
            const diaSeleccionado = document.getElementById('dia').value;
            const profesional = document.querySelector('input[name="peluquero"]:checked')?.value;
            servicios.value = '';
            const citasOcupadas = citas[profesional];
            const [hh, mm] = this.value.split(':');
            const hora1 = new Date();
            hora1.setHours(hh, mm, 0, 0);
            for (let x = 0; x < servicios.options.length; x++) {
                const opcion = servicios.options[x];
                opcion.disabled = false;

            }
            for (let i = 0; i < citasOcupadas.length; i++) {
                if (diaSeleccionado == citasOcupadas[i].dia) {

                    const [hh, mm] = citasOcupadas[i].hora.split(':');
                    const hora2 = new Date();
                    hora2.setHours(hh, mm, 0, 0);
                    const diferencia = (hora2 - hora1) / (1000 * 60);
                    if (diferencia == 15) {
                        for (let x = 0; x < servicios.options.length; x++) {
                            const opcion = servicios.options[x];

                            if (!opcion.dataset.info?.includes('15 min')) {
                                opcion.disabled = true;
                            }
                        }

                    }
                    if (diferencia > 0 && diferencia < 45) {
                        for (let x = 0; x < servicios.options.length; x++) {
                            const opcion = servicios.options[x];

                            if (opcion.dataset.info?.includes('45 min')) {
                                opcion.disabled = true;
                            }
                        }

                    }
                }
            }

        })
        function generarHoras(dia) {
            const profesional = document.querySelector('input[name="peluquero"]:checked')?.value;
            if (dia == '2026-09-04' || dia == '2026-09-05') {
                cambiarPrecio('15', '20');

            } else {
                if (profesional == 'luis') {
                    cambiarPrecio('11', '15');


                }
                else {
                    cambiarPrecio('8', '13');

                }
            }

            document.getElementById('reservar').disabled = false;
            const fecha = new Date(dia);
            const horaSelect = document.getElementById('hora');
            horaSelect.innerHTML = '';
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Escoge hora';
            placeholder.disabled = true;
            placeholder.selected = true;
            placeholder.hidden = true;
            horaSelect.appendChild(placeholder);
            let horas = [];
            botonListaEspera.disabled = true;

            if (fecha.getDay() === 6) {

                horas = ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30'];

            }
            else if (fecha.getDay() === 1) {
                horas = [
                    '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
                    '20:00'
                ];
            }
            else {

                horas = [
                    '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00',
                    '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
                    '20:00'
                ];

            }
            let citasOcupadas = citas[profesional];

            for (let i = 0; i < citasOcupadas.length; i++) {

                if (citasOcupadas[i].dia == dia) {
                    if (citasOcupadas[i].servicio == 'afeitado_de_cabeza_o_numero' || citasOcupadas[i].servicio == 'arreglo_de_barba') {
                        const [hh, mm] = citasOcupadas[i].hora.split(':');
                        const fecha = new Date();
                        fecha.setHours(hh, mm, 0, 0);
                        fecha.setMinutes(fecha.getMinutes() + 15);
                        const nuevaHora = String(fecha.getHours()).padStart(2, '0') + ':' + String(fecha.getMinutes()).padStart(2, '0');
                        if (!horas.includes(nuevaHora)) {
                            horas.push(nuevaHora);
                        }

                    }
                    if (citasOcupadas[i].servicio == 'corte_y_barba_ritual') {
                        const [hh, mm] = citasOcupadas[i].hora.split(':');
                        const fecha = new Date();
                        fecha.setHours(hh, mm, 0, 0);
                        fecha.setMinutes(fecha.getMinutes() + 45);
                        const nuevaHora = String(fecha.getHours()).padStart(2, '0') + ':' + String(fecha.getMinutes()).padStart(2, '0');

                        if (!horas.includes(nuevaHora)) {
                            horas.push(nuevaHora);
                        }


                    }
                    if ((citasOcupadas[i].servicio == 'corte_de_pelo' || citasOcupadas[i].servicio == 'afeitado_de_cabeza_y_barba') && (citasOcupadas[i].hora.includes(':15') || citasOcupadas[i].hora.includes(':45'))) {
                        const [hh, mm] = citasOcupadas[i].hora.split(':');
                        const fecha = new Date();
                        fecha.setHours(hh, mm, 0, 0);
                        fecha.setMinutes(fecha.getMinutes() + 30);
                        const nuevaHora = String(fecha.getHours()).padStart(2, '0') + ':' + String(fecha.getMinutes()).padStart(2, '0');
                        
                        if (!horas.includes(nuevaHora)) {
                            horas.push(nuevaHora);
                        }
                        fecha.setMinutes(fecha.getMinutes()-15);
                        const nuevaHoraComparar = String(fecha.getHours()).padStart(2, '0') + ':' + String(fecha.getMinutes()).padStart(2, '0');
                        for (let x = horas.length - 1; x >= 0; x--) {                            
                            if (horas[x] == nuevaHoraComparar) {
                                console.log(horas[x]);
                                
                                horas.splice(x, 1);
                            }

                        }


                    }

                }
            }

            horas.sort();
            if (dia == '2026-09-04') {
                const limite = new Date();
                limite.setHours(19, 0, 0, 0);
                for (let i = horas.length - 1; i >= 0; i--) {
                    const [hh, mm] = horas[i].split(':');
                    const horaComparar = new Date();
                    horaComparar.setHours(hh, mm, 0, 0);
                    if (horaComparar > limite) {
                        horas.splice(i, 1);
                    }
                }

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

            if (horasBloqueadas[profesional] != null) {
                for (let index = 0; index < horasBloqueadas[profesional].length; index++) {
                    if (horasBloqueadas[profesional][index].fecha_inicio.split('T')[0] == dia) {
                        const inicio = new Date(horasBloqueadas[profesional][index].fecha_inicio);
                        const fin = new Date(horasBloqueadas[profesional][index].fecha_fin);
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
            }

            if (horasBloqueadas[""] != null) {
                for (let index = 0; index < horasBloqueadas[""].length; index++) {
                    if (horasBloqueadas[""][index].fecha_inicio.split('T')[0] == dia) {
                        const inicio = new Date(horasBloqueadas[""][index].fecha_inicio);
                        const fin = new Date(horasBloqueadas[""][index].fecha_fin);
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
            }

            if (citas[profesional] != null) {
                const limiteTarde = new Date();
                limiteTarde.setHours(13, 0, 0, 0);
                const limiteIntermedio = new Date();
                limiteIntermedio.setHours(17, 0, 0, 0);
                const limiteNoche = new Date();
                limiteNoche.setHours(20, 0, 0, 0);
                for (let index = 0; index < citasOcupadas.length; index++) {
                    for (let index2 = 0; index2 < horas.length; index2++) {


                        if (citasOcupadas[index].hora == horas[index2] && citasOcupadas[index].dia == dia) {
                            horas.splice(index2, 1);
                            if (citasOcupadas[index].servicio == 'corte_y_barba_ritual') {
                                horas.splice(index2, 1);

                            }
                        }
                    }
                }
                for (let index = horas.length - 1; index >= 0; index--) {
                    const [hh, mm] = horas[index].split(':');
                    const fecha = new Date();
                    fecha.setHours(hh, mm, 0, 0);
                    if ((fecha > limiteTarde && fecha < limiteIntermedio) || fecha > limiteNoche) {
                        horas.splice(index, 1);
                    }

                }
            }

            if (horas.length == 0) {
                const opt = document.createElement('option');
                opt.innerHTML = 'No hay citas disponibles';
                opt.disabled = true;
                horaSelect.appendChild(opt);
                document.getElementById('reservar').disabled = true;
                botonListaEspera.disabled = false;
            }
            else {

                for (let i = 0; i < horas.length; i++) {
                    const opt = document.createElement('option');
                    opt.value = horas[i];
                    opt.innerHTML = horas[i];
                    horaSelect.appendChild(opt);
                }
            }

        }

        document.getElementById("form-reserva").addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
            }
        });
    </script>

@endsection