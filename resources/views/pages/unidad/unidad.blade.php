@extends('layouts.app', ['activePage' => 'categoria', 'titlePage' => __('Unidad y cantidad de medida')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-ms-12">
            <div class="container">
                <div class="card">
                    <div class="card-header card-header-text card-header-rose">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Registrar Unidad') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ url('/unidad') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="unidad_medida">{{ __('Nombre Unidad de medida') }} <span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="unidad_medida" required
                                    name="unidad_medida">
                            </div>
                            <div class="form-group">
                                <label for="cantidad_medida">{{ __('Cantidad') }} <span style="color: red">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="cantidad_medida" required
                                    name="cantidad_medida">
                            </div>
                            <div class="form-group">
                                <label for="categoria_id">{{ __('Seleccionar SubCategoria') }} <span style="color: red">*</span></label>
                                <select class="form-control" name="sub_categoria_id" id="sub_categoria_id">
                                    <option value="">---SELECCIONAR---</option>
                                    @foreach (SubCategoriaActiva() as $item)
                                    <option value="{{ $item->id }}">
                                        <h2>{{ $item->nombre_subCategoria }} ---> {{$item->nombre_categoria}}</h2>
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-rose">{{ __('Enviar') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                <div class="card">
                    <div class="card-header card-header-text card-header-primary">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Ver Unidad') }}</h4>
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
                                    <th>{{ __('Unidad de medida') }}</th>
                                    <th>{{ __('SubCategoria') }}</th>
                                    <th>{{ __('Cantidad') }}</th>
                                    <th>{{ __('Evento') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Unidad() as $item)
                                <tr class="text-center">
                                    <td>{{ $item->unidad_medida }}</td>
                                    <td>{{ $item->nombre_subCategoria}}</td>
                                    <td>{{ $item->cantidad_medida }}</td>

                                    <td>
                                        <button type="submit" class="btn btn-success btn-fab btn-fab-mini btn-round"
                                            data-toggle="modal" data-target="#editar{{ $item->id }}">
                                            <i class="material-icons">edit</i>
                                        </button>
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
                                                        <form method="POST" action="/unidad/{{$item->id}}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PUT')}}
                                                            <div class="form-group">
                                                                <label
                                                                    for="unidad_medida">{{__('Nombre Unidad de medida')}}</label>
                                                                <input value="{{$item->unidad_medida}}" type="text"
                                                                    class="form-control" id="unidad_medida" required
                                                                    name="unidad_medida">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="cantidad_medida">{{__('Cantidad')}}</label>
                                                                <input value="{{$item->cantidad_medida}}" type="text"
                                                                    class="form-control" id="cantidad_medida" required
                                                                    name="cantidad_medida">
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    for="sub_categoria_id">{{ __('Seleccionar Subcategoria') }}</label>
                                                                <select class="form-control" name="sub_categoria_id"
                                                                    id="sub_categoria_id">
                                                                    <option value="{{$item->id}}">
                                                                        ---{{$item->nombre_subCategoria}}---
                                                                    </option>
                                                                    @foreach (SubCategoriaActiva() as $data)
                                                                    <option value="{{ $data->id }}">
                                                                        {{ $data->nombre_subCategoria }}
                                                                        <h2>{{ $data->nombre_categoria}}</h2>
                                                                    </option>
                                                                    @endforeach
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
                                        <form action="/unidad/{{ $item->id }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit"
                                                class="btn btn-danger btn-fab btn-fab-mini btn-round mt-2" style=""><i
                                                    class="material-icons" onclick="return confirm('Desea eliminar el registro?')">close</i></button>
                                        </form>
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


