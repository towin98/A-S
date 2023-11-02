@extends('layouts.app', ['activePage' => 'reportes', 'titlePage' => __('Reporte Cliente Extintor')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col">
            <div class="container">
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Buscar Cliente Extintor') }}</h4>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="encargado">{{__('Cliente')}} <span style="color: red">*</span></label>
                                <select id="encargado" name="encargado_id"
                                    class=" form-control chosen-select">
                                    <option value="">Seleccionar</option>
                                    @foreach(Encargado() as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item ->nombre_encargado }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="p-2" for="id_fecha_del">{{ __('Fecha Desde') }}</label>
                                <input type="date" class="form-control mt-4" id="id_fecha_del" name="fecha_desde" value="{{ date("Y-m-d",strtotime(date("Y-m-d")."- 1 month")) }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="p-2" for="id_fecha_hasta">{{ __('Fecha Hasta') }}</label>
                                <input type="date" class="form-control mt-4" id="id_fecha_hasta" name="fecha_hasta" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="id_buscar" class="btn btn-success">Buscar</button>
                        </div>

                        <div id="id_propietario" style="display: none"></div>
                        <div id="id_origen">REPORTE_CLIENTE_EXTINTOR</div>

                        <div class="card-body">
                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr class="text-center">
                                        <th style="padding: 0 38px 0 5px !important;">{{ __('Orden Servicio') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;">{{ __('Agente') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;">{{ __('Capacidad Producto') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;">{{ __('Total Extintores') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_reporte">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/reportes/clienteOrdenesServicio.js') }}"></script>
@endsection
@section('script')
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': { allow_single_deselect: true },
        '.chosen-select-no-single': { disable_search_threshold: 10 },
        '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
        '.chosen-select-width': { width: "95%" }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
@endsection
