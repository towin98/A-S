@extends('layouts.app', ['activePage' => 'ingreso', 'titlePage' => __('Formulario de ingreso')])
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
                            <h4 class="card-title">{{ __('Listado del ingreso') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="example">
                            <thead>
                                <tr class="text-left">
                                    <th>{{ __('Referencia') }}</th>
                                    <th>{{ __('Fecha de ingreso') }}</th>
                                    <th>{{ __('Colaborador A&S') }}</th>
                                    <th>{{ __('Cargo') }}</th>
                                    <th>{{ __('categoría') }}</th>
                                    <th>{{ __('subcategoría') }}</th>
                                    <th>{{ __('Unidad de medida') }}</th>
                                    <th>{{ __('cantidad') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->numero_referencia }}</td>
                                    <td>{{ $item->fecha_recepcion }}</td>
                                    <td>{{ $item->fecha_entrega }}</td>
                                    <td>{{ $item->Usuario->nombre}} {{$item->Usuario->nombre}}</td>
                                    <td>{{$item->Usuario->cargo}}</td>
                                    <td>{{ $item->UnidadMedida->id }}</td>
                                    <td>{{ $item->numero_total_extintor }}</td>
                                    <td>{{ $item->estado }}</td>

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
