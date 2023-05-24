@extends('layouts.app', ['activePage' => 'hocol', 'titlePage' => __('Ingresos registrados para Hocol')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col">
            <div class="container">
                @if (session('exito'))
                <div class="alert alert-success" role="alert">
                    {{ session('exito') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-success" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Ingreso Hocol') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="example">
                                <thead>
                                    <tr class="text-left">
                                        <th>{{ __('Area') }}</th>
                                        <th>{{ __('Colaborador A&S') }}</th>
                                        <th>{{ __('Num Extintor') }}</th>
                                        <th>{{ __('Tipo') }}</th>
                                        <th>{{ __('Medida') }}</th>
                                        <th>{{ __('Capacidad') }}</th>
                                        <th>{{ __('Ubicacion') }}</th>
                                        <th>{{ __('Ultima recarga') }}</th>
                                        <th>{{ __('Proxima recarga') }}</th>
                                        <th>{{ __('Hidrostatica') }}</th>
                                        <th>{{ __('Observacion') }}</th>
                                        <th>{{ __('Fecha inspeccion') }}</th>
                                        <th>{{ __('Evento') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <th>{{$item['area']}}</th>
                                        <th>{{$item['colaborador']['nombre']}}</th>
                                        <th>{{$item['NmExtintor']}}</th>
                                        <th>{{$item['tipo']}}</th>
                                        <th>{{$item['capacidad_extintor']['unidad_medida']}}</th>
                                        <th>{{$item['capacidad_extintor']['cantidad_medida']}}</th>
                                        <th>{{$item['ubicacion']}}</th>
                                        <th>{{$item['ultima_recarga']}}</th>
                                        <th>{{$item['proxima_recarga']}}</th>
                                        <th>{{$item['hidrostatica']}}</th>
                                        <th>{{$item['observacion']}}</th>
                                        <th>{{$item['fecha_inspeccion']}}</th>
                                        <th><a href="{{ url('verMas/'.$item['id']) }}"><button type="submit"
                                                    class="btn btn-warning btn-fab btn-fab-mini btn-round">
                                                    <i class="material-icons">add</i>
                                                </button></a>
                                            <a href=""><button type="submit"
                                                    class="btn btn-success btn-fab btn-fab-mini btn-round">
                                                    <i class="material-icons">print</i>
                                                </button></a></th>
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
</div>
@endsection
