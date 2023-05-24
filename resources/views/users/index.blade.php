@extends('layouts.app', ['activePage' => 'profile', 'titlePage' => __('Usuarios registrados')])

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
                <h4 class="card-title">{{ __('Usuarios registrados') }}</h4>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-striped" id="example">
                <thead>
                  <tr class="text-center">
                    <th>{{ __('Nombre') }}</th>
                    <th>{{ __('Apellido') }}</th>
                    <th>{{ __('Cargo') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Contraseña') }}</th>
                    <th>{{ __('Evento') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (Usuario() as $item)
                  <tr>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->apellido }}</td>
                    <td>{{ $item->cargo }}</td>
                    <td>{{ $item->email }}</td>
                    <td>************</td>
                    <td>
                      <div class="row">
                        <div class="col-2 mt-1">
                          <button type="submit" class="btn btn-success btn-fab btn-fab-mini btn-round"
                            data-toggle="modal" data-target="#editar{{ $item->id }}">
                            <i class="material-icons">edit</i>
                          </button>
                        </div>
                        <div class="modal" tabindex="-1" role="dialog" id="editar{{ $item->id }}">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Editar usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="/usuario/{{$item->id}}">
                                  {{ csrf_field() }}
                                  {{ method_field('PUT')}}
                                  <div class="form-group">
                                    <label for="nombre">{{ __('Nombre:') }}</label>
                                    <input type="text" class="form-control" id="nombre" required name="nombre"
                                      value="{{$item->nombre}}">
                                  </div>
                                  <div class="form-group">
                                    <label for="apellido">{{ __('Apellido:') }}</label>
                                    <input type="text" class="form-control" id="apellido" required name="apellido"
                                      value="{{$item->apellido}}">
                                  </div>
                                  <div class="form-group">
                                    <label for="cargo">{{ __('Cargo:') }}</label>
                                    <input type="text" class="form-control" id="cargo" required name="cargo"
                                      value="{{$item->cargo}}">
                                  </div>
                                  <div class="form-group">
                                    <label for="email">{{ __('Cargo:') }}</label>
                                    <input type="text" class="form-control" id="email" required name="email"
                                      value="{{$item->email}}">
                                  </div>

                                  <div class="modal-footer">
                                    <button class="btn btn-primary">{{ __('Enviar') }}</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  </div>
                                </form>
                              </div>

                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                            <form action="/usuario/{{$item->id }}" method="post" id="formularioEliminar">
                                {{ csrf_field()}}
                            {{ method_field('DELETE')}}
                            <button type="submit" class="btn btn-danger btn-fab btn-fab-mini btn-round mt-2" style=""><i
                                class="material-icons" onclick="return confirm('Desea eliminar el registro?')">close</i></button>
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
          <a name="" id="" class="btn btn-primary" href="{{ url('registro') }}" role="button">Nuevo colaborador</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

