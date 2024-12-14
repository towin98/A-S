@extends('layouts.app', ['activePage' => 'ingreso', 'titlePage' => __('Nuevo Ingreso')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col">
                <div class="container">
                    @if (session('exito'))
                        <script>
                            window.alert('{{ session('exito') }}');
                            //Redigiendo a ticket/{idReferencia}' en una nueva ventana
                            window.open('/ticket/' + '{{ session('numero_referencia') }}', '_blank');
                        </script>
                    @endif
                    @if (session('validacion_datos'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('validacion_datos') }}
                        </div>
                    @endif

                    <!-- Mostrando errores de formulario -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            @if ($errors->any())
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="/ingresoL/{{ $crearId->id }}" enctype="/multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <input type="hidden" type="text" class="form-control" id="usuario_id" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" type="text" class="form-control" id="numero_referencia" name="numero_referencia" value="{{ $crearId->id }}">
                        <input type="hidden" type="number" name="numeroFilasExtintores" id="numeroFilasExtintores" value="1">

                        <div class="card">
                            <div class="card-header card-header-text card-header-warning">
                                <div class="card-text">
                                    <h4 class="card-title">{{ __('Nuevo Ingreso') }}</h4>
                                </div>
                            </div>
                            <h3 class="text-center m-0 font-weight-bold">Orden de Servicio: <u>{{ $crearId->id }}</u></h3>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-lg-2 mb-0">
                                        <label for="Fecha Ingreso">{{ __('Fecha de ingreso') }} <span style="color: red">*</span></label>
                                        <input type="date" class="form-control" id="fecha_recepcion" name="fecha_recepcion" required>
                                    </div>
                                    <div class="form-group col-lg-2 mb-0">
                                        <label for="Fecha Entrega">{{ __('Fecha de entrega') }} <span style="color: red">*</span></label>
                                        <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
                                    </div>
                                    <div class="form-group col-lg-8 mb-0">
                                        <label for="encargado" class="mb-1">{{ __('Cliente') }} <span style="color: red">*</span></label>
                                        <select class="form-control selectpicker show-tick" id="encargado" name="encargado_id" data-live-search="true" data-style="bg-white text-muted h6" title="SELECCIONE CLIENTE" required>
                                            @foreach (Encargado() as $item)
                                                <option value="{{ $item->id }}">{{ $item->numero_serial }} -
                                                    {{ $item->nombre_encargado }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header card-header-text card-header-warning">
                                <div class="card-text">
                                    <h4 class="card-title">{{ __('Ingreso de Extintores') }}</h4>
                                </div>
                            </div>
                            <div class="card-body pt-1">
                                <div class="mb-1">
                                    <small><b>1.</b> Para buscar un extintor con etiqueta en el campo N° Tiquete Anterior digitar el número y enter.</small> <br>
                                    <small><b>2.</b> Se ingresaran etiquetas apartir de la: <b class="text-danger">{{$ultimoConsecutivoDisponible}}</b> disponible.</small>
                                </div>

                                <div id="listExtintores"></div>
                                <div class="row">
                                    <div class="col-6 col-lg-12 text-right">
                                        <button type="button" id="addExtintor" onclick="addItemExtintor()" class="btn btn-success btn-sm">
                                            Nuevo Item
                                        </button>
                                    </div>
                                    <div class="form-group col-6 col-lg-12 text-right d-flex justify-content-end align-items-start">
                                        <label>Total:</label>
                                        <input type="number" id="numero_total_extintor" name="numero_total_extintor" value="1" style="width: 50px; text-align: center; margin-left: 5px; border: 0px;" readonly>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align:center; margin-top: 30px;">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <a href="{{ url('/home') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">

        $(function () {
            $('selectpicker').selectpicker();
        });
        let dataAgente = null;
        let dataActividad = null;

        document.addEventListener("DOMContentLoaded", () => {
            addItemExtintor();
        });

        function preventEnter(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                return false;
            }
            return true;
        }

        async function actividad(){
            try {
                const myHeader = new Headers({
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    'Content-Type': 'application/json'
                });

                const response = await fetch(`/consulta-actividades`, {
                    method: "GET",
                    headers: myHeader
                });

                if (!response.ok) {
                    // Si la respuesta no es ok, intenta obtener el JSON del error y lanza una excepción.
                    const errorData = await response.json();
                    throw new Error(JSON.stringify(errorData));
                }

                // Si la respuesta es ok, obtiene los datos JSON.
                const data = await response.json();
                dataActividad = data.data;
            } catch (error) {
                // Captura cualquier error y maneja el error aquí.
                const errorData = JSON.parse(error.message);
                document.getElementById("loading-overlay").style.display = "none";
            }
        }

        async function consultarAgentes() {
            try {
                const myHeader = new Headers({
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    'Content-Type': 'application/json'
                });

                const response = await fetch(`/buscar-agentes`, {
                    method: "GET",
                    headers: myHeader
                });

                if (!response.ok) {
                    // Si la respuesta no es ok, intenta obtener el JSON del error y lanza una excepción.
                    const errorData = await response.json();
                    throw new Error(JSON.stringify(errorData));
                }

                // Si la respuesta es ok, obtiene los datos JSON.
                const data = await response.json();
                const datos = data.data;
                dataAgente = datos;
            } catch (error) {
                // Captura cualquier error y maneja el error aquí.
                const errorData = JSON.parse(error.message);
                document.getElementById("loading-overlay").style.display = "none";
            }
        }

        async function cargarUnidadMedida(event) {
            try {
                const item = event.target.dataset.itemagente;

                idAgente = event.target.value;
                if (idAgente == "") {
                    addOptionsToSelect(`unidad_medida_id_${item}`, [], 'UNIDADMEDIDA');
                    return;
                }

                document.getElementById("loading-overlay").style.display = "";
                const myHeader = new Headers({
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    'Content-Type': 'application/json'
                });

                const response = await fetch(`/recarga/getUnidad/${idAgente}`, {
                    method: "GET",
                    headers: myHeader
                });

                if (!response.ok) {
                    // Si la respuesta no es ok, intenta obtener el JSON del error y lanza una excepción.
                    const errorData = await response.json();
                    throw new Error(JSON.stringify(errorData));
                }

                // Si la respuesta es ok, obtiene los datos JSON.
                const data = await response.json();
                const dataUnidadMedida = data;
                addOptionsToSelect(`unidad_medida_id_${item}`, dataUnidadMedida, 'UNIDADMEDIDA');
                document.getElementById("loading-overlay").style.display = "none";
            } catch (error) {
                // Captura cualquier error y maneja el error aquí.
                const errorData = JSON.parse(error.message);
                document.getElementById("loading-overlay").style.display = "none";
            }
        }

        async function readCodeAnterior(event, nameCampo, nameCampoReferencia) {
            if (event.key === "Enter") {
                event.preventDefault();
                if (event.target.value !== '') {

                    let itemNew = event.target.dataset.itemtiqueteanterior;
                    let nameCampoNew = nameCampo+itemNew;
                    let nameCampoReferenciaNew = nameCampoReferencia+itemNew;

                    document.getElementById("loading-overlay").style.display = "flex";
                    const etiquetaAnterior = event.target.value;
                    const myHeader = new Headers({
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        'Content-Type': 'application/json'
                    });

                    try {
                        const response = await fetch(`/recarga/buscar-etiqueta-anterior/${etiquetaAnterior}`, {
                            method: "GET",
                            headers: myHeader
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(JSON.stringify(errorData));
                        }

                        const data = await response.json();
                        const datos = data.data;
                        if (datos) {

                            let cargarDatosExtintor = true;

                            if (datos?.recarga_ingreso?.encargado_id != $('#encargado').val() && $('#encargado').val() != "") {
                                let userConfirmed = confirm(`El cliente - ${datos?.recarga_ingreso?.encargado?.numero_serial} - ${datos?.recarga_ingreso?.encargado?.nombre_encargado} - seleccionado es diferente al ya cargado. ¿Quiere cambiarlo al encontrado por el tiquete?`);
                                if (!userConfirmed) {
                                    cargarDatosExtintor = false;
                                }
                            }

                            if (cargarDatosExtintor) {

                                //Aquí cargo cliente.
                                $('#encargado').val(datos?.recarga_ingreso?.encargado_id);
                                $('#encargado').selectpicker('refresh');

                                // Asignar el valor y disparar el evento 'change' de forma asincrónica
                                await setValueAndTriggerChange(nameCampoNew, datos?.unidad_medida?.sub_categoria_id);
                                const data = [
                                    {
                                        id: datos?.unidad_medida?.id,
                                        unidad_medida: datos?.unidad_medida?.unidad_medida,
                                        cantidad_medida: datos?.unidad_medida?.cantidad_medida
                                    }
                                ];

                                await addOptionsToSelect(`unidad_medida_id_${itemNew}`, data, 'UNIDADMEDIDA');
                                $(`#${nameCampoReferenciaNew}`).val(datos?.unidad_medida?.id);

                                $(`#cantidad_medida_${itemNew}`).val("1");
                                $(`#cantidad_medida_${itemNew}`).prop('readonly', true);
                            }

                            document.getElementById("loading-overlay").style.display = "none";
                        } else {
                            alert("No se encontraron resultados.");
                            document.getElementById("loading-overlay").style.display = "none";
                        }

                    } catch (error) {
                        const errorData = JSON.parse(error.message);
                        console.error(errorData);
                        document.getElementById("loading-overlay").style.display = "none";
                    }
                }
            }
        }

        // Función auxiliar para asignar valor y disparar evento 'change'
        async function setValueAndTriggerChange(elementId, value) {
            $(`#${elementId}`).val(value);
        }

        async function addItemExtintor() {
            document.getElementById("loading-overlay").style.display = "";

            await consultarAgentes();
            await actividad();

            let item = document.getElementById("listExtintores").children.length + 1;

            // Actualizando campo oculto para tener conteo de filas creadas.
            document.getElementById("numeroFilasExtintores").value = item;

            let listExtintores = document.getElementById("listExtintores");

            // Crear un nuevo div que contendrá la nueva fila
            let newRow = document.createElement("div");
            newRow.className = "row form-row";
            newRow.id = `item_${item}`;

            // El contenido HTML de la nueva fila
            newRow.innerHTML = `
                <div class='form-group col-12 col-lg-2'>
                    <label for='nro_tiquete_anterior_${item}'>N° Tiquete Anterior</label>
                    <input type='number' class='form-control' id='nro_tiquete_anterior_${item}' name='nro_tiquete_anterior_${item}' data-itemtiqueteanterior='${item}' onkeydown='preventEnter(event)' onkeyup='readCodeAnterior(event, "agente_", "unidad_medida_id_")' title='Enter para Buscar'>
                </div>

                <div class='form-group col-12 col-lg-4'>
                    <label for='agente_${item}'>Agente</label>
                    <select name='agente_${item}' id='agente_${item}' class='form-control' data-itemagente='${item}' onchange='cargarUnidadMedida(event)' required>
                        <option value=''>[Seleccionar]</option>
                    </select>
                </div>

                <div class='form-group col-12 col-lg-2'>
                    <label for='unidad_medida_id_${item}'>Unidad de medida</label>
                    <select name='unidad_medida_id_${item}' id='unidad_medida_id_${item}' class='form-control' required>
                        <option value=''>[Seleccionar]</option>
                    </select>
                </div>

                <div class='form-group col-12 col-lg-2'>
                    <label for='actividad_id_${item}'>Actividad</label>
                    <select class='form-control' name='actividad_id_${item}' id='actividad_id_${item}' required>
                        <option value=''>[Seleccionar]</option>
                    </select>
                </div>

                <div class='form-group col-12 col-lg-1'>
                    <label for='cantidad_medida_${item}'>Cant</label>
                    <input type='number' class='form-control' id='cantidad_medida_${item}' value='1' name='cantidad_medida_${item}' onkeydown='preventEnter(event)' onchange='sumarValores()' required>
                </div>

                <div class='col-12 col-lg-1 d-flex align-items-center justify-content-end'>
                    <button type="button" onclick="removeItem(${item})" class="btn btn-danger btn-sm mt-4">X</button>
                </div>
            `;

            // Agregar la nueva fila al final del div con id="listExtintores"
            listExtintores.appendChild(newRow);
            addOptionsToSelect(`agente_${item}`, dataAgente);
            addOptionsToSelect(`actividad_id_${item}`, dataActividad, 'ACTIVIDAD');
            sumarValores();
            //Focus N° Tiquete anterior.
            document.getElementById(`nro_tiquete_anterior_${item}`).focus();

            document.getElementById("loading-overlay").style.display = "none";
            // document.getElementById("nro_total").value = item;
        }

        async function addOptionsToSelect(selectId, options, tipoCampo) {
            var $selectElement = $('#' + selectId);

            // Limpiar las opciones existentes (opcional)
            $selectElement.empty();

            // Agregar la opción por defecto
            $selectElement.append('<option value="">[Seleccionar]</option>');

            switch (tipoCampo) {
                case 'UNIDADMEDIDA':
                    options.forEach(function(option) {
                        $selectElement.append($('<option>', {
                            value: option.id,
                            text: `${option.cantidad_medida} ${option.unidad_medida}`
                        }));
                    });
                    break;

                case 'ACTIVIDAD':
                    options.forEach(function(option) {
                        $selectElement.append($('<option>', {
                            value: option.id,
                            text: option.nombre_actividad
                        }));
                    });
                    break;
                default:
                    options.forEach(function(option) {
                        $selectElement.append($('<option>', {
                            value: option.id,
                            text: `${option.nombre_subCategoria} - ${option.nombre_categoria}`
                        }));
                    });
                    break;
            }
        }

        function removeItem(item) {

            if (document.getElementById("listExtintores").children.length == 1) {
                alert("No se puede eliminar la última fila.");
                return;
            }

            document.getElementById("loading-overlay").style.display = "";
            // Remover el elemento correspondiente
            document.getElementById(`item_${item}`).remove();

            // Obtener todos los elementos restantes
            let listExtintores = document.getElementById("listExtintores").children;

            // Actualizando campo oculto para tener conteo de filas creadas.
            document.getElementById("numeroFilasExtintores").value = listExtintores.length;

            // Renumerar los IDs y names para mantener la secuencia
            for (let i = 0; i < listExtintores.length; i++) {
                let newIndex = i + 1;
                let row = listExtintores[i];
                row.id = `item_${newIndex}`;

                // Actualizar ID y name de los campos dentro de la fila

                // Actualizar el atributo for de los labels
                row.querySelector(`label[for^='nro_tiquete_anterior_']`).setAttribute('for',`nro_tiquete_anterior_${newIndex}`);
                row.querySelector(`label[for^='agente_']`).setAttribute('for', `agente_${newIndex}`);
                row.querySelector(`label[for^='unidad_medida_id_']`).setAttribute('for', `unidad_medida_id_${newIndex}`);
                row.querySelector(`label[for^='actividad_id_']`).setAttribute('for', `actividad_id_${newIndex}`);
                row.querySelector(`label[for^='cantidad_medida_']`).setAttribute('for', `cantidad_medida_${newIndex}`);

                row.querySelector(`input[name^='nro_tiquete_anterior_']`).id = `nro_tiquete_anterior_${newIndex}`;
                row.querySelector(`input[id^='nro_tiquete_anterior_']`).name = `nro_tiquete_anterior_${newIndex}`;
                row.querySelector(`[data-itemtiqueteanterior]`).setAttribute('data-itemtiqueteanterior', newIndex);

                row.querySelector(`select[name^='agente_']`).id = `agente_${newIndex}`;
                row.querySelector(`select[id^='agente_']`).name = `agente_${newIndex}`;
                row.querySelector(`[data-itemagente]`).setAttribute('data-itemagente', newIndex);

                row.querySelector(`select[name^='unidad_medida_id_']`).id = `unidad_medida_id_${newIndex}`;
                row.querySelector(`select[id^='unidad_medida_id_']`).name = `unidad_medida_id_${newIndex}`;

                row.querySelector(`select[name^='actividad_id_']`).id = `actividad_id_${newIndex}`;
                row.querySelector(`select[id^='actividad_id_']`).name = `actividad_id_${newIndex}`;

                row.querySelector(`input[name^='cantidad_medida_']`).id = `cantidad_medida_${newIndex}`;
                row.querySelector(`input[id^='cantidad_medida_']`).name = `cantidad_medida_${newIndex}`;

                // Actualizar el botón de eliminación con el nuevo índice
                row.querySelector('button').setAttribute('onclick', `removeItem(${newIndex})`);
            }

            sumarValores();
            document.getElementById("loading-overlay").style.display = "none";
        }

        function sumarValores() {

            // Obtengo todos los inputs con ID que comienzan con 'cantidad_medida_' para sumar sus valores.
            const inputs = document.querySelectorAll("#listExtintores input[id^='cantidad_medida_']");

            let total = 0;
            // Recorro todos los inputs con ID que comienzan con 'cantidad_medida_' y sumo sus valores a total.
            inputs.forEach(input => {
                let value = parseFloat(input.value) || 0;
                if (value < 1) {
                    value = 1;
                }
                input.value = value;
                total += value;
            });

            //Actizo campo de total de extintores
            document.getElementById('numero_total_extintor').value = total;
        }

    </script>
@endsection
