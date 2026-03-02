@extends('layouts.app')

@section('content')
    <div class="bg-secondary d-flex justify-content-center align-items-center" style="height:85vh">
        <div class="bg-black p-5 rounded-4 " style="width:450px">

            @csrf
            <div id="phase1">
                <div class="form-group">
                    <label for="servicio" class="text-light">Servicio:</label>
                    <select class="form-control" name="servicio" id="servicio" required>
                        <option value="" selected disabled hidden>Escoge servicio</option>
                        <option value="afeitado_de_cabeza_y_barba"
                            data-info="Afeitado a máquina más el ritual de barba con toalla caliente. 30 min - 10€">Afeitado
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
                
                <button type="button" id="atras" class="btn btn-primary mt-3">Atrás</button>
                <button type="submit" class="btn btn-primary mt-3">Reservar</button>
            </div>



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
    </script>
@endsection