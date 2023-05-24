@extends('layouts.app', ['activePage' => 'Observacion', 'titlePage' => __('Observacion de etiqueta')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-ms-12">
            <div class="container">
                @if (session('exito'))
                <div class="alert alert-success" role="alert">
                    {{ session('exito') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <li>{{ $error }}</li>
                    </div>
                    @endforeach
                </ul>
                @endif
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Ver observaciones') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('editar'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('editar') }}
                        </div>
                        @endif
                        <table class="table" id="example">
                            <thead>
                                <tr class="text-center">
                                    <th>{{ __('Numero etiqueta') }}</th>
                                    <th>{{ __('Observación') }}</th>
                                    <th>{{ __('Fecha') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Observaciones() as $item)
                                <tr class="text-center">
                                    <td>{{ $item->numero_etiqueta }}</td>
                                    <td>{{ $item->observacion }}</td>
                                    <td>{{ $item->created_at }}</td>
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
