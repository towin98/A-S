<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="https://image.flaticon.com/icons/png/512/2053/2053895.png">
    <title>A & S</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="container">
                        @if (session('exito'))
                        <div class="alert alert-success mt-5" role="alert">
                            {{ session('exito') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="alert alert-danger mt-5" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <script src="{{ asset('js/combo/comboDinamico.js') }}"></script>
                        <div class="card mt-5">
                            <div class="card-header card-header-text card-header-warning">
                                <div class="card-text">
                                    <h4 class="card-title">{{ __('Registrar Listado De Ingreso para') }}</h4>
                                    {{-- <h2>{{$referencia}}</h2> --}}
                                </div>
                            </div>
                            <div class="card-body">

                                <form method="POST" action="{{ url('/listadoIngreso') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="ingreso_id">{{ __('N° Referencia:') }}</label>
                                        <input type="text" class="form-control" id="ingreso_id" required value="{{$id}}"
                                            name="ingreso_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="categoria">{{ __('Seleccionar Categoria:') }}</label>
                                        <select class="form-control" name="categoria" id="categoria">
                                            <option value="">---SELECCIONAR---</option>
                                            @foreach (Categoria() as $item)
                                            <option value="{{ $item->id}}">{{ $item->nombre_categoria}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="subCategoria">{{ __('Seleccionar Subcategoria:') }}</label>
                                        <select class="form-control" name="Subcategoria" id="Subcategoria">
                                            <option value="">---SELECCIONAR---</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="unidad_medida_id">{{ __('Seleccionar Unidad De Medida:') }}</label>
                                        <select class="form-control" name="unidad_medida_id" id="unidad_medida_id">
                                            <option value="">---SELECCIONAR---</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="actividad">{{ __('Seleccionar Actividad:') }}</label>
                                        <select class="form-control" name="actividad" id="actividad">
                                            <option value="">---SELECCIONAR---</option>
                                            @foreach (Actividad() as $item)
                                            <option value="{{ $item->id}}">{{ $item->nombre_actividad}}--{{$item->abreviacion_actividad}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="numero_extintor">{{ __('Numero De Extintores:') }}</label>
                                        <input type="number" class="form-control" id="numero_extintor" required name="numero_extintor">
                                    </div>
                                    <button id="enviar" class="btn btn-warning">{{ __('Enviar') }}</button>
                                 </form>
                                 <div>
                                     <div class="row">
                                         <form method="POST" action="/totalExt/{{$id}}" style="margin-top: 40px;" enctype="/multipart/form-data">
                                            {{ csrf_field()}}
                                            {{ method_field('PUT')}}
                                            <div class="col">
                                                <h3 class="mt-2">{{__('Numero total de extintores')}} <input type="number" name="numero_total_extintor" id="numero_total_extintor" value="{{$total}}"></h3>

                                            </div>
                                         </form>

                                        <div class="col">

                                            {{-- <a href="{{ url('ticket/' . $id) }}"><button id="imprimir" class="btn btn-secondary"
                                                style="margin-left: 30%">{{ __('Imprimir') }}</button></a> --}}

                                                <a href="{{ url('listIngreso/'.$id) }}"><button id="enviar" class="btn btn-danger"
                                                        style="float: right">{{ __('Listado ingreso') }}</button></a>
                                        </div>
                                     </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
