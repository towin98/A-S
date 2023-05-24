@extends('layouts.app', ['activePage' => 'categoria', 'titlePage' => __('SubCategoria')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    @if(session('editar'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('editar') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                            <h4 class="card-title">{{ __('Ver SubCategoria') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="example">
                            <thead>
                                <tr class="text-center">
                                    <th>{{ __('Nombre SubCategoria') }}</th>
                                    <th>{{ __('Nombre Categoria') }}</th>
                                    <th>{{ __('Nombre Abreviación') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th>{{ __('Evento') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (SubCategoria() as $item)
                                <tr class="text-center">
                                    <td>{{$item->nombre_subCategoria}}</td>
                                    <td>{{$item->Categoria->nombre_categoria}}</td>
                                    <td>{{$item->abreviacion}}</td>
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
                                                            <h5 class="modal-title">Editar SubCategoria</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="/subCategoria/{{$item->id}}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('PUT')}}
                                                                <div class="form-group">
                                                                    <label
                                                                        for="nombre_categoria">{{__('Nombre SubCategoria')}}</label>
                                                                    <input value="{{$item->nombre_subCategoria}}"
                                                                        type="text" class="form-control"
                                                                        id="nombre_subCategoria" required
                                                                        name="nombre_subCategoria">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label
                                                                        for="nombre_categoria">{{__('Nombre Abreviación')}}</label>
                                                                    <input value="{{$item->abreviacion}}" type="text"
                                                                        class="form-control" id="abreviacion" required
                                                                        name="abreviacion">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label
                                                                        for="categoria_id">{{ __('Seleccionar Categoria') }}</label>
                                                                    <select class="form-control" name="categoria_id"
                                                                        id="categoria_id">
                                                                        <option value="{{$item->id}}">
                                                                            {{$item->nombre_categoria}}</option>
                                                                        @foreach (CategoriaActiva() as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->nombre_categoria }} </option>
                                                                        @endforeach
                                                                    </select>
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
                                            <div class="col-2 ml-2">
                                                <form action="/subCategoria/{{$item->id }}" method="post">
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
                            <h4 class="card-title">{{ __('Registrar SubCategoria') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('/subCategoria')}}">
                            {{ csrf_field()}}
                            <div class="form-group">
                                <label for="nombre_categoria">{{__('Nombre SubCategoria')}} <span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="nombre_subCategoria" required
                                    name="nombre_subCategoria" style="text-transform:uppercase;">
                            </div>
                            <div class="form-group">
                                <label for="nombre_categoria">{{__('Nombre Abreviación')}} <span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="abreviacion" required name="abreviacion" style="text-transform:uppercase;">
                            </div>
                            <div class="form-group">
                                <label for="categoria_id">{{ __('Seleccionar Categoria') }} <span style="color: red">*</span></label>
                                <select class="form-control" name="categoria_id" id="categoria_id">
                                    <option value="">---SELECCIONAR---</option>
                                    @foreach (CategoriaActiva() as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre_categoria }} </option>
                                    @endforeach
                                </select>
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
