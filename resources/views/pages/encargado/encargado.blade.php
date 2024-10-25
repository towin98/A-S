@extends('layouts.app', ['activePage' => 'empresa_encargado', 'titlePage' => __('Gestión de Clientes')])

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
                    @if (session('errors'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('errors') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header card-header-text card-header-warning">
                            <div class="card-text">
                                <h4 class="card-title">{{ __('Registrar Clientes') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ url('/encargado') }}">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="nombre_encargado">{{ __('Nombre completo del Clientes:') }}
                                            <span style="color: red">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nombre_encargado" name="nombre_encargado" value="{{ old('nombre_encargado', $encargado->nombre_encargado ?? '') }}"  onkeypress="return soloLetras(event)" style="text-transform:uppercase;" required>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="numero_serial">{{ __('N° de Documento') }} <span style="color: red">*</span></label>
                                        <input type="number" class="form-control" id="numero_serial" name="numero_serial" onkeypress="return soloNum(event)" value="{{ old('numero_serial', $encargado->numero_serial ?? '') }}" required>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="email">{{ __('Email:') }} <span style="color: red">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $encargado->email ?? '') }}" required>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="direccion">{{ __('Dirección:') }} <span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $encargado->direccion ?? '') }}" required>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="numero_celular">{{ __('N° de contacto:') }} <span style="color: red">*</span></label>
                                        <input type="number" class="form-control" id="numero_celular" name="numero_celular" value="{{ old('numero_celular', $encargado->numero_celular ?? '') }}" required>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-warning">{{ __('Enviar') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function soloLetras(e) {
                  var key = e.keyCode || e.which,
                    tecla = String.fromCharCode(key).toLowerCase(),
                    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
                    especiales = [8, 37, 39, 46],
                    tecla_especial = false;

                  for (var i in especiales) {
                    if (key == especiales[i]) {
                      tecla_especial = true;
                      break;
                    }
                  }

                  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                    return false;
                  }
                }

                function soloNum(e) {
                  var key = e.keyCode || e.which,
                    tecla = String.fromCharCode(key).toLowerCase(),
                    letras = "1234567890",
                    especiales = [8, 37, 39, 46],
                    tecla_especial = false;

                  for (var i in especiales) {
                    if (key == especiales[i]) {
                      tecla_especial = true;
                      break;
                    }
                  }

                  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                    return false;
                  }
                }
            </script>

            <div class="col-md-12">
                <div class="container">
                    <div class="card">
                        <div class="card-header card-header-text card-header-warning">
                            <div class="card-text">
                                <h4 class="card-title">{{ __('Ver Clientes') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr class="text-center">
                                        <th>{{ __('Nombre encargado') }}</th>
                                        <th>{{ __('N° Contacto') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Direccion') }}</th>
                                        <th>{{ __('N° Documento') }}</th>
                                        <th>{{ __('Evento') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Encargado() as $item)
                                    <tr>
                                        <td>{{ $item->nombre_encargado }}</td>
                                        <td>{{ $item->numero_celular }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->direccion }}</td>
                                        <td>{{ $item->numero_serial }}</td>
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
                                                                <h5 class="modal-title">Editar encargado</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="/encargado/{{$item->id}}">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('PUT')}}

                                                                    <div class="form-group">
                                                                        <label for="nombre_encargado">{{ __('Nombre
                                                                            completo del encargado:') }}</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nombre_encargado" required
                                                                            name="nombre_encargado"
                                                                            value="{{$item->nombre_encargado}}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="numero_celular">{{ __('N° de
                                                                            contacto:') }}</label>
                                                                        <input type="number" class="form-control"
                                                                            id="numero_celular" required
                                                                            name="numero_celular"
                                                                            value="{{$item->numero_celular}}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email">{{ __('Email:') }}</label>
                                                                        <input type="email" class="form-control"
                                                                            id="email" required name="email"
                                                                            value="{{$item->email}}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="direccion">{{ __('Dirección:')
                                                                            }}</label>
                                                                        <input type="text" class="form-control"
                                                                            id="direccion" required name="direccion"
                                                                            value="{{$item->direccion}}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="numero_serial">{{ __('N°
                                                                            Documento:') }}</label>
                                                                        <input type="text" class="form-control"
                                                                            id="numero_serial" required
                                                                            name="numero_serial"
                                                                            value="{{$item->numero_serial}}">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-primary">{{ __('Enviar')
                                                                            }}</button>
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <form action="/encargado/{{$item->id }}" method="post">
                                                        {{ csrf_field()}}
                                                        {{ method_field('DELETE')}}
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
        </div>
    </div>
</div>

@endsection
