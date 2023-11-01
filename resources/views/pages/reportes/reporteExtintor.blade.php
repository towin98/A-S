@extends('layouts.app', ['activePage' => 'reportes', 'titlePage' => __('Reporte Extintor')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col">
            <div class="container">
                <div class="card">

                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Buscar Extintor') }}</h4>
                        </div>
                        <div class="form-group mt-4">
                            <label class="px-2" for="id_etiqueta_extintor">{{ __('Etiqueta extintor') }}</label>
                            <div class="d-flex">
                                <div class="px-2 w-100">
                                    <input type="text" placeholder="Ingrese Etiqueta extintor" class="form-control" id="id_etiqueta_extintor" name="etiqueta_extintor" required>
                                </div>
                                <div class="ml-auto px-2">
                                    <button type="button" id="id_buscar_etiqueta_extintor" class="btn btn-success">Buscar</button>
                                </div>
                            </div>
                        </div>

                        <label class="px-2 d-flex"><b>Propietario:</b><div id="id_propietario"></div></label>
                        <div id="id_origen">REPORTE_EXTINTOR</div>

                        <div class="card-body">
                            <table class="table" id="example" style="display: block; overflow-x: auto; white-space: nowrap; width: 100%">
                                <thead>
                                    <tr class="text-left">
                                        <th style="padding: 0 38px 0 5px !important;">{{ __('#') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="N° Etiqueta Anterior">{{ __('N° E. Anterior') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;" title="N° Etiqueta Nueva">{{ __('N° E. Nueva') }}</th>
                                        <th style="padding: 0 38px 0 5px !important;">{{ __('Orden Servicio') }}</th>
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

                                        <th style="padding: 0 38px 0 5px !important;">{{ __('Fecha Recarga') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_reporte_extintor">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/reportes/extintores.js') }}"></script>
@endsection
