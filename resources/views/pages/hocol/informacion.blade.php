@extends('layouts.app', ['activePage' => 'hocol', 'titlePage' => __('Informacion de ingreso para Hocol')])

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
                            <h4 class="card-title">{{ __('Informacion completa registro') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-text card-header-primary">
                                        <div class="card-text">
                                            <h4 class="card-title">{{__('INFORMACION GENERAL')}}</h4>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body">
                                            @foreach($data as $item)
                                            <div class="row" style="font-size: 20px">
                                                <div class="col">
                                                    <p>{{__('Area')}} : {{$item['area']}}</p>
                                                </div>
                                                <div class="col">
                                                    <p>{{__('Colaborador')}} : {{$item['colaborador']['nombre']}}</p>
                                                </div>
                                                <div class="col">
                                                    <p>{{__('Tipo')}} : {{$item['tipo']}}</p>
                                                </div>
                                                <div class="col">
                                                    <p>{{__('ubicacion')}} : {{$item['ubicacion']}}</p>
                                                </div>
                                            </div>
                                            <div class="row" style="font-size: 20px">
                                                <div class="col">
                                                    <p>{{__('Unidad medida')}} :
                                                        {{$item['capacidad_extintor']['unidad_medida']}}</p>
                                                </div>
                                                <div class="col">
                                                    <p>{{__('Capacidad')}} :
                                                        {{$item['capacidad_extintor']['cantidad_medida']}}</p>
                                                </div>
                                                <div class="col">
                                                    <p>{{__('Fecha inspeccion')}} : {{$item['fecha_inspeccion']}}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-text card-header-primary">
                                        <div class="card-text">
                                            <h4 class="card-title">{{__('INFORMACIÓN GENERAL EXTINTORES PORTATILES')}}
                                                <p class="category">{{__('Aspectos inspeccionados')}}</p>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body">

                                            <div class="row" style="font-size: 20px">
                                                @foreach ($dataPortatil as $res)
                                                <div class="col-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <p>{{__('Parte')}} : {{$res['estado']}}</p>
                                                            <p>{{__('Estado')}} : {{$res['estado']}}</p>
                                                        </div>
                                                    </div>

                                                </div>

                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-text card-header-success">
                                        <div class="card-text">
                                            <h4 class="card-title">{{__('INFORMACIÓN GENERAL EXTINTORES PORTATILES')}}
                                            </h4>
                                            <p class="category">{{__('Aspectos inspeccionados')}}</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body">

                                            <div class="row" style="font-size: 20px">
                                                @foreach ($listadoCarretilla as $res)
                                                <div class="col-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <p>{{__('Parte')}} : {{$res['estado']}}</p>
                                                            <p>{{__('Estado')}} : {{$res['estado']}}</p>
                                                        </div>
                                                    </div>

                                                </div>

                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection