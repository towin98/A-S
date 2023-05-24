@extends('layouts.app', ['activePage' => 'categoria', 'titlePage' => __('Categoria')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    @if(session('editar'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('editar') }}
                    </div>
                    @endif
                    @if(session('exito'))
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
                    @endif
                    @if(session('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ session('error') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif
                @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <li>{{ $error }}</li>
                    </div>
                    @endforeach
                </ul>
                @endif
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Ver categoria') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="example">
                            <thead>
                                <tr class="text-center">
                                    <th>{{ __('Nombre categoria') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th>{{ __('Evento') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Categoria() as $item)
                                <tr class="text-center">
                                    <td>{{$item->nombre_categoria}}</td>
                                    <td>{{$item->estado}}</td>
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
                                                            <h5 class="modal-title">Editar Categoria</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="/categoria/{{$item->id}}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('PUT')}}
                                                                <div class="form-group">
                                                                    <label
                                                                        for="nombreCategoria">{{ __('Nombre categoria') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nombre_categoria" required
                                                                        name="nombre_categoria"
                                                                        value="{{$item->nombre_categoria}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="estado">{{ __('Estado') }}</label>
                                                                    <select class="form-control" name="estado"
                                                                        id="estado">
                                                                        <option value="1">{{__('Activo')}}</option>
                                                                        <option value="0">{{__('Inhabilitado')}}
                                                                        </option>
                                                                    </select>
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
                                                <form action="/categoria/{{$item->id }}" method="post">
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
        <div class="col-sm-12">
            <div class="container">
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Registrar categoria') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('/categoria')}}">
                            {{ csrf_field()}}
                            <div class="form-group">
                                <label for="nombre_categoria">{{__('Nombre categoria')}} <span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="nombre_categoria" required
                                    name="nombre_categoria" style="text-transform:uppercase;">
                            </div>
                            <button class="btn btn-warning">{{__('Enviar')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
