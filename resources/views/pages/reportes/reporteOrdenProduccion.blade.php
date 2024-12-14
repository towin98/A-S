@extends('layouts.app', ['activePage' => 'reportes', 'titlePage' => __('Reporte de producción por Orden')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col">
                <div class="container">
                    <div class="card">

                        <div class="card-header card-header-text card-header-warning" style="color: black">
                            <div class="card-text">
                                <h4 class="card-title">{{ __('Buscar Orden de Producción') }}</h4>
                            </div>
                            <div class="form-group">
                                <label class="px-2" for="id_orden_servicio">{{ __('Reporte de producción por Orden') }}</label>
                                <div class="d-flex">
                                    <div class="px-2 w-100">
                                        <input type="text" placeholder="Ingrese Orden de Servicio" class="form-control" id="id_orden_servicio" name="orden_servicio" required>
                                    </div>
                                    <div class="ml-auto px-2">
                                        <button type="button" id="id_buscar_orden_servicio" class="btn btn-success mt-0">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">

                            <div class="row pb-2" style="font-family: 'Roboto'">
                                <div class="col-12 text-center"><strong>ORDEN DE PRODUCCION (ENSAMBLE, MANTENIMIENTO Y/0 RECARGA)</strong></div>
                                <div class="col-12 d-flex">
                                    <strong>Orden de Servicio:</strong> <div id="orden_servicio" class="pl-1"> </div>
                                </div>
                                <div class="col-12 col-lg-6 d-flex">
                                    <strong>Fecha Recepción:</strong> <div id="fecha_recepcion" class="pl-1"></div>
                                </div>
                                <div class="col-12 col-lg-6 d-flex">
                                    <strong>Fecha Entrega:</strong> <div id="fecha_entrega" class="pl-1"></div>
                                </div>
                                <div class="col-12 col-lg-6 d-flex">
                                    <strong>Cliente:</strong><div id="id_propietario" class="pl-1"></div>
                                </div>
                                <div class="col-12 col-lg-6 d-flex">
                                    <strong>Operario que deligenció:</strong> <div id="operario" class="pl-1"></div>
                                </div>
                            </div>
                            <div id="id_origen" class="d-none">REPORTE_PRODUCCION_ORDEN</div>

                            <table class="table" id="example" style="display: block; overflow-x: auto; white-space: nowrap; width: 100%">
                                <thead>
                                    <tr class="text-left">
                                        <th style="padding: 0 38px 0 5px !important;">{{ __('#') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="N° Etiqueta Anterior">{{ __('N° E. Anterior') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="N° Etiqueta Nueva">{{ __('N° E. Nueva') }}</th>

                                        {{-- ESTAS DOS COLUMNAS SON DOS CAMPOS NUEVOS --}}
                                        <th style="padding: 0 38px 0 5px !important;" title="N° Extintor">{{ __('N° Extintor') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="N° Interno Cliente">{{ __('N° Interno Cliente') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="Fecha Hidrostatica">{{ __('Fecha Hidrostatica') }}</th>

                                        <th style="padding: 0 38px 0 5px !important;">{{ __('Agente') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="Capacidad Producto">{{ __('Capacidad P.') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="Unidad Medida">{{ __('Unidad M.') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;">{{ __('Actividad') }}</th>

                                        <th style="padding: 0 38px 0 5px !important;" title="1 - Valvula">{{ __('1') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="2 - Manometro">{{ __('2') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="3 - Tubo sifón">{{ __('3') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="4 - Bastago">{{ __('4') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="5 - Resipiente">{{ __('5') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="6 - Empaques">{{ __('6') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="7 - Manguera">{{ __('7') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="8 - Agente extintor NVO">{{ __('8') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="9 - Agente extintor RMNF">{{ __('9') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="10 - Anillo de verificación">{{ __('10') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="11 - Etiqueta genérica">{{ __('11') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="12 - Pintura">{{ __('12') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="13 - Cinturón">{{ __('13') }}</th>

                                        <th style="padding: 0 38px 0 5px !important;" title="PI - Pintura">{{ __('PI') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="HI - Hidrostatica">{{ __('HI') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="HE - Hermeticidad">{{ __('HE') }}</th>

                                        <th style="padding: 0 38px 0 5px !important;" title="A - En el niple">{{ __('A') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="B - En el recipiente">{{ __('B') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="C - En la valvula">{{ __('C') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="A M - En el Acople de la manguera">{{ __('A M') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="N/A - No Aplica">{{ __('N/A') }}</th>

                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/reportes/ordenProduccion.js') }}"></script>
@endsection
