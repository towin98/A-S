@extends('layouts.app', ['activePage' => 'adicionales', 'titlePage' => __('Cambio de parte')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-ms-12">
            <div class="container">
                @if (session('exito'))
                {{-- <div class="alert alert-success" role="alert">
                    {{ session('exito') }}
                </div> --}}
                <script>
                    window.alert('{{ session('exito') }}');
                </script>
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
                            <h4 class="card-title">{{ __('Ver cambios de parte') }}</h4>
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
                                    <th>{{ __('Nombre cambio de la parte') }}</th>
                                    <th>{{ __('Referencia') }}</th>
                                    <th>{{ __('Evento') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (cambioParte() as $item)
                                <tr class="text-center">
                                    <td>{{ $item->nombre_parte_cambio }}</td>
                                    <td>{{ $item->referencia }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-2 mt-1">
                                                <button type="submit"
                                                    class="btn btn-success btn-fab btn-fab-mini btn-round"
                                                    data-toggle="modal" data-target="#editar{{ $item->id }}">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                            </div>
                                            <div class="modal" tabindex="-1" role="dialog" id="editar{{ $item->id }}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Editar Prueba</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="/cambio/{{ $item->id }}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('PUT') }}
                                                                <div class="form-group">
                                                                    <label
                                                                        for="nombre_parte_cambio">{{ __('Nombre cambio de la parte') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nombre_parte_cambio" required name="nombre_parte_cambio"
                                                                        value="{{ $item->nombre_parte_cambio }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label
                                                                        for="referencia">{{ __('Referencia') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        id="referencia" required
                                                                        name="referencia"
                                                                        value="{{ $item->referencia }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button
                                                                        class="btn btn-primary">{{ __('Enviar') }}</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <form action="/cambio/{{ $item->id }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit"
                                                        class="btn btn-danger btn-fab btn-fab-mini btn-round mt-2"
                                                        style=""><i class="material-icons" onclick="return confirm('Desea eliminar el registro?')">close</i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-ms-12">
            <div class="container">
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Registrar cambio de parte') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ url('/cambio') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="nombre_parte_cambio">{{ __('Nombre cambio de la parte') }} <span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="nombre_parte_cambio" required name="nombre_parte_cambio">
                            </div>
                            <div class="form-group">
                                <label for="referencia">{{ __('Referencia') }} <span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="referencia" required
                                    name="referencia">
                            </div>
                            <button class="btn btn-warning">{{ __('Enviar') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
