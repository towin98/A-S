@extends('layouts.app', ['activePage' => 'recargas', 'titlePage' => __('Gestion De Orden De Producción')])
@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- <div class="container"> -->
                    @if (session('exito'))
                        <div class="alert alert-success" role="alert">
                            {{ session('exito') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header card-header-text card-header-warning">
                            <div class="card-text">
                                <h4 class="card-title">{{ __('Ver Recargas') }}</h4>
                            </div>
                        </div>

                        <h5 class="text-center mt-2 mb-0"><b>Cliente:</b> {{ $dataCliente->numero_serial }} - {{ $dataCliente->nombre_encargado }}</h5>

                        <div class="card-body table-responsive pt-1">
                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th>{{ __('Orden Servicio') }}</th>
                                        <th>{{ __('Nro Extintores') }}</th>
                                        <th>{{ __('Fecha ingreso') }}</th>
                                        <th>{{ __('Capacidad') }}</th>
                                        <th>{{ __('Unidad de medida') }}</th>
                                        <th>{{ __('SubCategoria') }}</th>
                                        <th>{{ __('Categoria') }}</th>
                                        <th>{{ __('Actividad') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datos as $item)
                                        <tr>
                                            <td>{{ $item->ingreso_id }}</td>
                                            <td>{{ $item->numero_extintor }}</td>
                                            <td>{{ $item->fecha_recepcion }}</td>
                                            <td>{{ $item->cantidad_medida }}</td>
                                            <td>{{ $item->unidad_medida }}</td>
                                            <td>{{ $item->nombre_subCategoria }}</td>
                                            <td>{{ $item->nombre_categoria }}</td>
                                            <td>{{ $item->nombre_actividad }}({{ $item->abreviacion_actividad }})</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- </div> -->

                    <div class="card">
                        <div class="card-header card-header-text card-header-warning">
                            <div class="card-text">
                                <h4 class="card-title">{{ __('Listado De extintores Recargados') }}</h4>
                            </div>
                        </div>

                        @if (session('exito_eliminar_extintor_orden'))
                            <div class="alert alert-success m-3" role="alert">
                                {{ session('exito_eliminar_extintor_orden') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('advertencia_eliminar_extintor_orden'))
                            <div class="alert alert-danger mt-3" role="alert">
                                @if (session('advertencia_eliminar_extintor_orden'))
                                    {{ session('advertencia_eliminar_extintor_orden') }}
                                @endif
                            </div>
                        @endif

                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-12 col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <div style="width: 20px; height: 10px; background: #ff9800"></div>
                                        &nbsp;&nbsp; &nbsp; &nbsp;Indica que estos extintores faltan por ingresar actividad.
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div style="width: 20px; height: 10px;" class="bg-success"></div>
                                        &nbsp;&nbsp; &nbsp; &nbsp;Indica que estos extintores ya se les realizo ingreso de actividad.
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div style="width: 20px; height: 10px; background: #f44336"></div>
                                        &nbsp;&nbsp; &nbsp; &nbsp;Indica que la actividad del extintor esta cerrada y no se puede modificar registro.
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="d-flex justify-content-end pr-4">
                                        <button
                                            type="button"
                                            class="btn btn-danger text-capitalize"
                                            {{ ($estadoOrdenServicio->estado == 1 ? '' : 'disabled') }}
                                            onclick="closeOrden({{ $dataCliente->idOrden }})">
                                            <i class="fas fa-lock"></i>
                                            &nbsp;{{ ($estadoOrdenServicio->estado == 1 ? 'Cerrar Orden' : 'Orden Cerrada') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th>{{ __('Nro Tiquete anterios') }}</th>
                                        <th>{{ __('Nro Tiquete nuevo') }}</th>
                                        <th>{{ __('Nro Extintor') }}</th>
                                        <th>{{ __('Capacidad') }}</th>
                                        <th>{{ __('Unidad de medida') }}</th>
                                        <th>{{ __('SubCategoria') }}</th>
                                        <th>{{ __('Categoria') }}</th>
                                        <th>{{ __('Actividad') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listadoRecarga as $item)
                                        <tr>
                                            <td>{{ $item['nro_tiquete_anterior'] }}</td>
                                            <td>{{ $item['nro_tiquete_nuevo'] }}</td>
                                            <td>{{ $item['nro_extintor'] }}</td>
                                            <td>{{ $item['cantidad_medida'] }}</td>
                                            <td>{{ $item['unidad_medida'] }}</td>
                                            <td>{{ $item['nombre_subCategoria'] }}</td>
                                            <td>{{ $item['nombre_categoria'] }}</td>
                                            <td>{{ $item['nombre_actividad'] }}</td>
                                            <td>
                                                <button type="submit" class="btn {{ ($item['estado'] == 0) ? 'btn-danger' : (($item['ingreso_actividad'] == 1) ? 'btn-success' : 'btn-warning') }}
                                                    btn-fab btn-fab-mini btn-round" data-toggle="modal" onclick="abrirModalRecarga({{ $item['id'] }}, {{ $item['estado'] }})">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                                {{-- <form action="/recarga/eliminar-extintor-orden/{{ $item['id'] }}"
                                                    method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit"
                                                        class="btn btn-danger btn-fab btn-fab-mini btn-round mt-2"
                                                        title="Eliminar Extintor">
                                                        <i class="material-icons"
                                                            onclick="return confirm('Desea eliminar el registro?')">close</i>
                                                    </button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modal para editar recarga-->
    <div class="modal fade modal fade bd-example-modal-lg" id="recargaModal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="recargaModalLabel">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="recargaModalLabel">INGRESE DATOS DE LA ACTIVIDAD REALIZADA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formProduccion">
                    {{ csrf_field() }}
                    <input type="hidden" type="text" value="" name="recarga_id" id="recarga_id">
                    <div class="row">
                        <div class="col-6 col-lg-2">
                            <div class="form-group mt-0 pb-0 mb-1">
                                <label for="nro_tiquete_anterior">{{ __('N° tiquete anterior:') }}</label>
                                <input type="number" class="form-control" id="nro_tiquete_anterior" name="nro_tiquete_anterior" onkeydown="preventEnter(event)">
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="form-group mt-0 pb-0 mb-1">
                                <label for="nro_tiquete_nuevo">{{ __('N° tiquete nuevo:') }}</label>
                                <input type="number" class="form-control" id="nro_tiquete_nuevo" value="" name="nro_tiquete_nuevo" onkeydown="preventEnter(event)" required readonly>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="form-group mt-0 pb-0 mb-1">
                                <label for="ingreso_recarga_id">{{ __('Orden de Servicio:') }}</label>
                                <input type="text" class="form-control" id="ingreso_recarga_id" value="{{ $id }}" name="ingreso_recarga_id" readonly required>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="form-group mt-0 pb-0">
                                <label for="agente">{{ __('Agente:') }}</label>
                                <select name="agente" id="agente" class="form-control" readonly></select>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="form-group mt-0 pb-0">
                                <label for="capacidad_id">{{ __('Unidad de medida') }}</label>
                                <select name="capacidad_id" id="capacidad_id" class="form-control" readonly>
                                    <option value="">{{ __('[Seleccione]') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="form-group mt-0 pb-0">
                                <label for="activida_recarga_id">{{ __('Actividad') }}</label>
                                <select class="form-control" name="activida_recarga_id" id="activida_recarga_id" readonly></select>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="form-group mt-0 pb-0">
                                <label for="fecha_hidrostatica">{{ __('Fecha Hidrostática') }}</label>
                                <input type="date" class="form-control" id="fecha_hidrostatica" value="" name="fecha_hidrostatica" required>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="form-group mt-0 pb-0">
                                <label for="n_interno_cliente">{{ __('N° interno Cliente') }}</label>
                                <input type="text" class="form-control" id="n_interno_cliente" value="" name="n_interno_cliente" required>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="form-group mt-0 pb-0">
                                <label for="n_extintor">{{ __('N° del extintor') }}</label>
                                <input type="text" class="form-control" id="n_extintor" value="" name="n_extintor" required>
                            </div>
                        </div>
                    </div>

                    <ul>
                        <li class="text-danger">Fecha de ultima prueba Hidrostática realizada: <span id="fecha_hidrostatica_anterior"></span>.</li>
                    </ul>

                    <h3 class="mt-0 text-center text-warning">{{ __('Cambio de partes del extintor') }}</h3>
                    <div class="form-group mt-1 pb-0">
                        <div class="row">
                            @foreach (cambioParte() as $item)
                                <div class="col-3">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="cambioParte" name="cambioParte[]"
                                                value="{{ $item->id }}">({{ $item->id }}){{ $item->nombre_parte_cambio }}
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <h3 class="text-center text-warning mt-1">{{ __('Prueba') }}</h3>
                    <div class="form-group mt-0 pb-0">
                        @foreach (Prueba() as $item)
                            <div class="form-check form-check-radio form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="pruebas[]"
                                        id="pruebas[]"
                                        value="{{ $item->id }}">({{ $item->abreviacion_prueba }}){{ $item->nombre_prueba }}
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <h3 class="text-center text-warning mt-1">{{ 'Fugas' }}</h3>
                    <div class="form-group mt-0 pb-0">
                        @foreach (Fuga() as $item)
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="fuga_id" id="fuga_id" onclick="changeFuga(event)"
                                        value="{{ $item->id }}">({{ $item->abreviacion_fuga }}){{ $item->nombre_fuga }}
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div id="cambioExtintirNuevo" class="form-group d-none">
                        <h3 class="text-center text-warning mt-1">{{ '¿Cambio por extintor nuevo?' }}</h3>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="cambioExtintirNuevo" id="ask_nuevo_extintor_1" value="NO" required>
                                NO
                                <span class="circle">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="cambioExtintirNuevo" id="ask_nuevo_extintor_2" value="SI">SI
                                <span class="circle">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group mt-3 pb-0">
                        <label for="observacion">{{ __('Observación:') }}</label>
                        <input type="text" class="form-control" id="observacion" name="observacion" maxlength="100" placeholder="Digite...">
                    </div>
                </form>
            </div>
            <div class="modal-footer pt-0 border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn btn-danger" id="BtnGuardarCerrarOrder" onclick="guardarActividad(true)">Guardar y Cerrar Orden</button>
                <button type="submit" class="btn btn-primary" id="BtnGuardar" onclick="guardarActividad(false)">Guardar</button>
            </div>
        </div>
    </div>
    <script>

        function preventEnter(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                return false;
            }
            return true;
        }

        function abrirModalRecarga(id_recarga, estado){
            limpiarCampos(estado);
            consultandoRecarga(id_recarga);
            $('#recargaModal').modal('show');
        }

        function consultandoRecarga(id_recarga) {
            document.getElementById("loading-overlay").style.display = "flex";
            // recarga/buscar-recarga/{id_recarga}
            const myHeader = new Headers({
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    'Content-Type': 'application/json'
                });

                fetch(`/recarga_2/buscar-recarga/${id_recarga}`, {
                        method: "GET",
                        headers: myHeader
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            return response.json().then(errorData => {
                                // convirtiendo la respuesta a un string.
                                throw new Error(JSON.stringify(errorData));
                            });
                        }
                    })
                    .then(data => {
                        const datos = data.data;
                        if (datos) {
                            //CARGANDO FECHA HIDROSTRATICA ANTERIOR
                            document.getElementById('fecha_hidrostatica_anterior').textContent = datos?.fecha_hidrostatica_anterior;

                            //CARGANDO FECHA PRUEBA HIDROSTATICA ACTUAL REALIZADA
                            document.getElementById('fecha_hidrostatica').value = datos?.fecha_hidrostatica == '1900-01-01' ? '' : datos?.fecha_hidrostatica;

                            //CARGANDO NUMERO INTERNO CLIENTE: ESTE ES EL NUMERO INTERNO QUE A VECES LAS EMPRESAS TIENEN DE SUS EXTINTOR.
                            document.getElementById('n_interno_cliente').value = datos?.n_interno_cliente;

                            //CARGANDO NUMERO EXTINTOR: ESTE ES EL NUMERO QUE VA EN LA PLACA DEL EXTINTOR
                            document.getElementById('n_extintor').value = datos?.n_extintor;

                            // Aqui checked lo cambios de partes
                            data.cambiopartes.forEach(valor => {
                                const checkbox = document.querySelector(`input[name="cambioParte[]"][value="${valor.cambio_parte_id}"]`);
                                if (checkbox) {
                                    checkbox.checked = true; // Selecciona el checkbox
                                }
                            });

                            // Aqui checked el listado de pruebas
                            data.pruebas.forEach(valor => {
                                const checkbox = document.querySelector(`input[name="pruebas[]"][value="${valor.prueba_id}"]`);
                                if (checkbox) {
                                    checkbox.checked = true; // Selecciona el checkbox
                                }
                            });

                            const radioFuga = document.querySelectorAll('input[name="fuga_id"]');
                            radioFuga.forEach(radio => {
                                if (radio.value == datos?.fuga_id) {
                                    radio.checked = true; // Selecciona el radio button con el valor deseado
                                    document.getElementById('cambioExtintirNuevo').classList.remove('d-none');
                                }
                            });

                            if (datos?.nuevo_extintor != null) {
                                // Aqui checked el valor de nuevo_extintor
                                const rdCambioExtintirNuevo = document.querySelectorAll('input[name="cambioExtintirNuevo"]');
                                rdCambioExtintirNuevo.forEach(radio => {
                                    if (radio.value == datos?.nuevo_extintor) {
                                        radio.checked = true; // Selecciona el radio button con el valor deseado
                                    }
                                });
                            }

                            document.getElementById("recarga_id").value           = datos?.id;
                            document.getElementById("nro_tiquete_anterior").value = datos?.nro_tiquete_anterior;
                            document.getElementById("nro_tiquete_nuevo").value    = datos?.nro_tiquete_nuevo;
                            document.getElementById("agente").value               = datos?.sub_categoria_id;
                            document.getElementById('observacion').value          = datos?.observacion;

                            const dataOpcionAgente = [
                                {
                                    value: datos.sub_categoria_id,
                                    text: `${datos.nombre_subCategoria} - ${datos.nombre_categoria}`
                                }
                            ];

                            addOptionsToSelect(`agente`, dataOpcionAgente, 'AGENTE');
                            $(`#agente`).val(datos?.sub_categoria_id);

                            const dataOpcionUnidadMedida = [
                                    {
                                    value: datos.unidades_medida_id,
                                    text: `${datos.cantidad_medida} ${datos.unidad_medida}`
                                }
                            ];

                            addOptionsToSelect(`capacidad_id`, dataOpcionUnidadMedida, 'UNIDADMEDIDA');

                            const dataOpcionActividad = [
                                    {
                                    value: datos.activida_recarga_id,
                                    text: `${datos.nombre_actividad}`
                                }
                            ];

                            addOptionsToSelect(`activida_recarga_id`, dataOpcionActividad, 'ACTIVIDAD');

                            $(`#capacidad_id`).val(datos?.unidades_medida_id);
                            $(`#activida_recarga_id`).val(datos?.activida_recarga_id);
                        } else {
                            alert("No se encontraron resultado.");
                        }
                        document.getElementById("loading-overlay").style.display = "none";
                    })
                    .catch(error => {
                        const errorData = JSON.parse(error.message);
                        // let errores = errorData.message + ":\n\n";
                        // console.log(errorData);
                        document.getElementById("loading-overlay").style.display = "none";
                    });
        }

        async function addOptionsToSelect(selectId, options, tipoCampo) {
            var $selectElement = $('#' + selectId);

            // Limpiar las opciones existentes (opcional)
            $selectElement.empty();
            switch (tipoCampo) {
                case 'AGENTE':
                case 'UNIDADMEDIDA':
                case 'ACTIVIDAD':
                    options.forEach(function(option) {
                        $selectElement.append($('<option>', {
                            value: option.value,
                            text: `${option.text}`
                        }));
                    });
                    break;
                }
        }

        function guardarActividad(cerrarOrden = false){

            event.preventDefault();
            const form = document.getElementById('formProduccion'); // Selecciona el formulario

            if (!form.checkValidity()) { // Verifica si el formulario NO es válido
                form.reportValidity(); // Muestra los errores de validación nativos de HTML5
                return
            }

            const arrListadoCambioPartes = Array.from(document.querySelectorAll('input[name="cambioParte[]"]:checked')).map(checkbox => checkbox.value);
            if(arrListadoCambioPartes.length == 0){
                alert('Debe seleccionar al menos un cambio de parte.');
                return false;
            }
            const arrListadoPruebas = Array.from(document.querySelectorAll('input[name="pruebas[]"]:checked')).map(checkbox => checkbox.value);
            if(arrListadoPruebas.length == 0){
                alert('Debe seleccionar al menos una prueba.');
                return false;
            }

            if (document.querySelector('input[name="cambioExtintirNuevo"]:checked')?.value == 'SI') {
                if (document.getElementById('observacion').value == '') {
                    alert('Debe ingresar una observación porque se trata de un cambio por un extintor nuevo.');
                    return false;
                }
            }

            document.getElementById("loading-overlay").style.display = "";

            const myHeader = new Headers({
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    'Content-Type': 'application/json'
                });

                const data = {
                    recarga_id          : document.getElementById('recarga_id').value,
                    nro_tiquete_anterior: document.getElementById('nro_tiquete_anterior').value,
                    nro_tiquete_nuevo   : document.getElementById('nro_tiquete_nuevo').value,
                    cambioParte         : arrListadoCambioPartes,
                    pruebas             : arrListadoPruebas,
                    fuga_id             : document.querySelector('input[name="fuga_id"]:checked')?.value ?? null,
                    observacion         : document.getElementById('observacion').value,
                    nuevo_extintor      : document.querySelector('input[name="cambioExtintirNuevo"]:checked')?.value ?? 'NO',
                    fecha_hidrostatica  : document.getElementById('fecha_hidrostatica').value,
                    n_interno_cliente   : document.getElementById('n_interno_cliente').value,
                    n_extintor          : document.getElementById('n_extintor').value,
                    estado              : (cerrarOrden ? 0 : 1)
                };

                fetch(`/recarga`, {
                        method: "POST",
                        body    : JSON.stringify(data),
                        headers : myHeader
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            return response.json().then(errorData => {
                                // convirtiendo la respuesta a un string.
                                throw new Error(JSON.stringify(errorData));
                            });
                        }
                    })
                    .then(data => {
                        if (data) {
                            document.getElementById("loading-overlay").style.display = "none";
                            if (confirm(data.message) == true) {
                                location.reload();
                            }else{
                                location.reload();
                            }
                        }
                    })
                    .catch(error => {
                        const errorData = JSON.parse(error.message);
                        // let errores = errorData.message + ":\n\n";
                        // console.log(errorData);
                        alert(errorData.errors[0]);
                        document.getElementById("loading-overlay").style.display = "none";
                    });
        }

        function limpiarCampos(estadoOrden = 1) {

            document.getElementById("recarga_id").value ='';

            document.getElementById("nro_tiquete_anterior").value ='';
            document.getElementById("nro_tiquete_anterior").disabled = (estadoOrden) ? true : false;

            document.getElementById("nro_tiquete_nuevo").value ='';
            document.getElementById("agente").value ='';

            document.getElementById("fecha_hidrostatica").value ='';
            document.getElementById("fecha_hidrostatica").readOnly = (estadoOrden == 0) ? true : false;

            document.getElementById("n_interno_cliente").value ='';
            document.getElementById("n_interno_cliente").readOnly = (estadoOrden == 0) ? true : false;

            document.getElementById("n_extintor").value ='';
            document.getElementById("n_extintor").readOnly = (estadoOrden == 0) ? true : false;

            const checkboxesCambioParte = document.querySelectorAll('input[name="cambioParte[]"]');

            // Recorre cada checkbox y desmárcalo
            checkboxesCambioParte.forEach(checkbox => {
                checkbox.checked = false;
                //Estado en 0 orden cerrada, no se permite modificar informacion
                if (estadoOrden == 0) {
                    checkbox.disabled = true;
                }else{
                    checkbox.disabled = false;
                }
            });

            const checkboxesPruebas = document.querySelectorAll('input[name="pruebas[]"]');

            // Recorre cada checkbox y desmárcalo
            checkboxesPruebas.forEach(checkbox => {
                checkbox.checked = false;
                //Estado en 0 orden cerrada, no se permite modificar informacion
                if (estadoOrden == 0) {
                    checkbox.disabled = true;
                }else{
                    checkbox.disabled = false;
                }
            });

            const radiosFugas = document.querySelectorAll('input[name="fuga_id"]');
            radiosFugas.forEach(radio => {
                radio.checked = false; // Desmarca todos los radio buttons del grupo
                //Estado en 0 orden cerrada, no se permite modificar informacion
                if (estadoOrden == 0) {
                    radio.disabled = true;
                }else{
                    radio.disabled = false;
                }
            });

            const radiosExtintorNuevo = document.querySelectorAll('input[name="cambioExtintirNuevo"]');
            radiosExtintorNuevo.forEach(radio => {
                radio.checked = false; // Desmarca todos los radio buttons del grupo
                //Estado en 0 orden cerrada, no se permite modificar informacion
                if (estadoOrden == 0) {
                    radio.disabled = true;
                }else{
                    radio.disabled = false;
                }
            });

            document.getElementById('cambioExtintirNuevo').classList.add('d-none');
            document.querySelector('input[name="cambioExtintirNuevo"][value="NO"]').checked = true;

            //Estado Cero "0" cerrada orden
            if (estadoOrden == 0) {
                document.getElementById('BtnGuardarCerrarOrder').style.display = 'none';
                document.getElementById('BtnGuardar').style.display = 'none';
                document.getElementById('observacion').disabled = true;
            }else{
                document.getElementById('BtnGuardarCerrarOrder').style.display = 'block';
                document.getElementById('BtnGuardar').style.display = 'block';
                document.getElementById('observacion').disabled = false;
            }
        }

        function changeFuga(event){
            if (event.target.value != undefined) {
                document.getElementById('cambioExtintirNuevo').classList.remove('d-none');
            }
        }

        function closeOrden(idOrden){
            const myHeader = new Headers({
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    'Content-Type': 'application/json'
                });

                const data = {
                    idIngreso          : idOrden
                };

                fetch(`/recarga/cerrar-orden`, {
                        method: "POST",
                        body    : JSON.stringify(data),
                        headers : myHeader
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            return response.json().then(errorData => {
                                // convirtiendo la respuesta a un string.
                                throw new Error(JSON.stringify(errorData));
                            });
                        }
                    })
                    .then(data => {
                        if (data) {
                            document.getElementById("loading-overlay").style.display = "none";
                            if (confirm(data.message) == true) {
                                location.reload();
                            }else{
                                location.reload();
                            }
                        }
                    })
                    .catch(error => {
                        const errorData = JSON.parse(error.message);
                        // let errores = errorData.message + ":\n\n";
                        // console.log(errorData);
                        alert(errorData.errors[0]);
                        document.getElementById("loading-overlay").style.display = "none";
                    });
        }
    </script>
@endsection
