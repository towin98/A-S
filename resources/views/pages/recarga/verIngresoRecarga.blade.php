@extends('layouts.app', ['activePage' => 'recargas', 'titlePage' => __('Gestion De Orden De Producción')])

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
                            <h4 class="card-title">{{ __('Ver  ingreso') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="example">
                            <thead>
                                <tr class="text-left">
                                    <th>{{ __('Fecha de ingreso') }}</th>
                                    <th>{{ __('Fecha de entrega') }}</th>
                                    <th>{{ __('Cliente') }}</th>
                                    <th>{{ __('Colaborador') }}</th>
                                    <th>{{ __('Orden Servicio') }}</th>
                                    <th>{{ __('No extintores') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr class="text-center">
                                    <td>{{ $item->fecha_recepcion }}</td>
                                    <td>{{ $item->fecha_entrega }}</td>
                                    <td>{{ $item->nombre_encargado }}</td>
                                    <td>{{ $item->Usuario->nombre}}</td>
                                    <td>{{ $item->numero_referencia }}</td>
                                    <td>{{ $item->numero_total_extintor }}</td>
                                    <td>{{ $item->estado }}</td>
                                    <td>
                                        <a href="{{ url('recarga/'.$item->id) }}">
                                            <button type="submit"
                                                class="btn btn-success btn-fab btn-fab-mini btn-round">
                                                <i class="material-icons">edit</i>
                                            </button>
                                        </a>

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
@endsection
