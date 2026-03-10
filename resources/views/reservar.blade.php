@extends('layouts.app')

@section('content')
    <div class="bg-secondary d-flex justify-content-center align-items-center" style="height:85vh">
        <div class="bg-black p-5 rounded-4 " style="width:450px">
            <form method="POST" action="{{ route('reservar') }}">
                @csrf
                <div id="phase1">
                    <div class="form-group">
                        <label for="servicio" class="text-light">Servicio:</label>
                        <select class="form-control" name="servicio" id="servicio" required>
                            <option value="" selected disabled hidden>Escoge servicio</option>
                            <option value="afeitado_de_cabeza_y_barba"
                                data-info="Afeitado a máquina más el ritual de barba con toalla caliente. 30 min - 10€">
                                Afeitado
                                de cabeza + barba</option>
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
                        <small class="mt-3 text-light" id="detalles"></small>
                        <small id="mensajeError" class="text-danger"></small>
                    </div>
                    <div class="form-group mt-4">
                        <label for="peluquero" class="text-light">Peluquero:</label>
                        <select class="form-control" name="peluquero" id="peluquero" required>
                            <option value="luis">Luis</option>
                        </select>
                    </div>

                    <button type="button" id="continuar" class="btn btn-primary mt-3">Continuar</button>
                </div>
                <div id="phase2" style="display:none;">
                    <div class="form-group">
                        <label class="text-light" for="dia">Selecciona un día</label>
                        <input type="text" id="dia" name="dia" class="form-control" required>
                    </div>
                    <div class="form-group mt-4">
                        <label class="text-light" for="hora">Selecciona una hora</label>
                        <select class="form-control" name="hora" id="hora" required>

                        </select>
                    </div>
                    <button type="button" id="atras" class="btn btn-primary mt-3">Atrás</button>
                    <button type="submit" class="btn btn-primary mt-3">Reservar</button>
                </div>
            </form>


        </div>
    </div>
    <script>
        let fase1 = document.getElementById('phase1');
        let fase2 = document.getElementById('phase2');
        let mensajeError = document.getElementById('mensajeError');
        let servicios = document.getElementById('servicio');

        servicios.addEventListener('change', function () {
            const texto = this.options[this.selectedIndex].dataset.info;
            document.getElementById('detalles').textContent = texto;
            mensajeError.textContent = ''
        })
        document.getElementById('continuar').addEventListener('click', function () {
            if (servicios.value == '') {
                mensajeError.textContent = 'Debes seleccionar una opción'
            } else {
                fase2.style.display = 'block'
                fase1.style.display = 'none'
            }
        })
        document.getElementById('atras').addEventListener('click', function () {

            fase1.style.display = 'block'
            fase2.style.display = 'none'

        })
        const diasBloqueados = @json($diasBloqueados);
        const horasBloqueadas = @json($horasBloqueadas);

        flatpickr("#dia", {
            dateFormat: "Y-m-d",
            locale: "es",
            minDate: "today",
            disable: [
                function (date) {
                    const yyyy = date.getFullYear();
                    const mm = String(date.getMonth() + 1).padStart(2, '0');
                    const dd = String(date.getDate()).padStart(2, '0');
                    const fechaLocal = `${yyyy}-${mm}-${dd}`;

                    return date.getDay() === 0 || diasBloqueados.includes(fechaLocal);
                }
            ],
            onChange: function (selectedDates, dateStr, instance) {

                generarHoras(dateStr);
            }

        });
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
                    let opt = document.createElement('option');
                    opt.value = horas[i];
                    opt.innerHTML = horas[i];
                    document.getElementById('hora').appendChild(opt);
                }
                return;
            }
            for (let index = 0; index < horasBloqueadas.length; index++) {
                if (horasBloqueadas[index].fecha_inicio.split('T')[0] == params) {
                    document.getElementById('hora').innerHTML = '';
                    for (let secondIndex = 0; secondIndex < horas.length; secondIndex++) {
                        if (!(horas[secondIndex] >= horasBloqueadas[index].fecha_inicio.split('T')[1] && horasBloqueadas[index].fecha_fin.split('T')[1] > horas[secondIndex])) {
                            let opt = document.createElement('option');
                            opt.value = horas[secondIndex];
                            opt.innerHTML = horas[secondIndex];
                            document.getElementById('hora').appendChild(opt);
                        }

                    }

                } else {
                    document.getElementById('hora').innerHTML = '';
                    for (let thirdIndex = 0; thirdIndex < horas.length; thirdIndex++) {
                        let opt = document.createElement('option');
                        opt.value = horas[thirdIndex];
                        opt.innerHTML = horas[thirdIndex];
                        document.getElementById('hora').appendChild(opt);

                    }

                }

            }
        }
    </script>

@endsection