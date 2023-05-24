@extends('layouts.app', ['activePage' => 'recargas', 'titlePage' => __('Gestion De Orden De Producción')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    @if(session('editar'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('editar') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if (session('exito'))
                    <div class="alert alert-success" role="alert">
                        {{ session('exito') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                                <h4 class="card-title">{{ __('Registrar Recarga') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ url('/recarga') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="nro_tiquete_anterior">{{ __('N° tiquete anterior:') }}</label>
                                    <input type="number" class="form-control" id="nro_tiquete_anterior" required
                                        name="nro_tiquete_anterior">
                                </div>
                                <div class="form-group">
                                    <label for="nro_tiquete_nuevo">{{ __('N° tiquete nuevo:') }}</label>
                                    <input type="number" class="form-control" id="nro_tiquete_nuevo" required
                                        name="nro_tiquete_nuevo">
                                </div>
                                <div class="form-group">
                                    <label for="nro_extintor">{{ __('N° de extintor:') }}</label>
                                    <input type="number" class="form-control" id="nro_extintor" required
                                        name="nro_extintor">
                                </div>
                                <div class="form-group">
                                    <label for="agente">{{ __('Agente:') }}</label>
                                    <input type="text" class="form-control" id="agente" required name="agente">
                                </div>
                                <div class="form-group">
                                    <label for="usuario_recarga_id">{{ __('N° de usuario:') }}</label>
                                    <input type="text" class="form-control" id="usuario_recarga_id" required
                                        name="usuario_recarga_id" value="{{ Auth::user()->id }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="ingreso_recarga_id">{{ __('N° de referencia:') }}</label>
                                    <input type="text" class="form-control" id="ingreso_recarga_id" required
                                        name="ingreso_recarga_id">
                                </div>
                                <div class="form-group">
                                    <label for="activida_recarga_id">{{ __('Seleccionar Actividad') }}</label>
                                    <select class="form-control" name="activida_recarga_id" id="activida_recarga_id">
                                        <option value="">---SELECCIONAR---</option>
                                        @foreach (Actividad() as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre_actividad }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cambio_parte_id">{{ __('Seleccionar Cambio De Parte') }}</label>
                                    <select class="form-control" name="cambio_parte_id" id="cambio_parte_id">
                                        <option value="">---SELECCIONAR---</option>
                                        @foreach (cambioParte() as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre_parte_cambio }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="prueba_id">{{ __('Seleccionar Prueba') }}</label>
                                    <select class="form-control" name="prueba_id" id="prueba_id">
                                        <option value="">---SELECCIONAR---</option>
                                        @foreach (Prueba() as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre_prueba }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fuga_id">{{ __('Seleccionar Fuga') }}</label>
                                    <select class="form-control" name="fuga_id" id="fuga_id">
                                        <option value="">---SELECCIONAR---</option>
                                        @foreach (Fuga() as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre_fuga }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="observacion">{{ __('Observación:') }}</label>
                                    <input type="text" class="form-control" id="observacion" required
                                        name="observacion">
                                </div>
                                <button class="btn btn-warning">{{ __('Enviar') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="container">
                    <div class="card">
                        <div class="card-header card-header-text card-header-warning">
                            <div class="card-text">
                                <h4 class="card-title">{{ __('Ver Recargas') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr class="text-center">
                                        <th>{{ __('Nombre empresa') }}</th>
                                        <th>{{ __('Nit') }}</th>
                                        <th>{{ __('Direccion') }}</th>
                                        <th>{{ __('Evento') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Empresa() as $item)
                                    <tr>
                                        <td>{{ $item->nombre_empresa }}</td>
                                        <td>{{ $item->nit }}</td>
                                        <td>{{ $item->direccion }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-2 mt-1">
                                                    <button type="submit"
                                                        class="btn btn-success btn-fab btn-fab-mini btn-round"
                                                        data-toggle="modal" data-target="#editar{{ $item->id }}">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                </div>
                                                <div class="modal" tabindex="-1" role="dialog"
                                                    id="editar{{ $item->id }}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Editar empresa</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="/empresa/{{$item->id}}">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('PUT')}}
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="nombre_empresa">{{ __('Nombre de la empresa:') }}</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nombre_empresa" required
                                                                            name="nombre_empresa"
                                                                            value="{{$item->nombre_empresa}}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="nit">{{ __('Nit:') }}</label>
                                                                        <input type="number" class="form-control"
                                                                            id="nit" required name="nit"
                                                                            value="{{$item->nit}}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="direccion">{{ __('Direccion:') }}</label>
                                                                        <input type="text" class="form-control"
                                                                            id="direccion" required name="direccion"
                                                                            value="{{$item->direccion}}">
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
                                                    <form action="/empresa/{{$item->id }}" method="post">
                                                        {{ csrf_field()}}
                                                        {{ method_field('DELETE')}}
                                                        <button type="submit"
                                                            class="btn btn-danger btn-fab btn-fab-mini btn-round mt-2"
                                                            style=""><i class="material-icons">close</i></button>
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
        </div>
    </div>
</div>
@endsection