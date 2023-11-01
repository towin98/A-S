@extends('layouts.app', ['activePage' => 'recargas', 'titlePage' => __('Gestion De Orden De Producción')])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    @if (session('exito'))
                    <div class="alert alert-success" role="alert">
                        {{ session('exito') }}
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header card-header-text card-header-warning">
                            <div class="card-text">
                                <h4 class="card-title">{{ __('Ver Recargas') }}</h4>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th>{{ __('Orden Servicio') }}</th>
                                        <th>{{ __('Nro Extintores') }}</th>
                                        <th>{{ __('Fecha ingreso') }}</th>
                                        <th>{{ __('Capacidad') }}</th>
                                        <th>{{ __('Unidad de medida') }}</th>
                                        <th>{{ __('SubCategoria') }}</th>
                                        <th>{{ __('Categoria') }}</th>
                                        <th>{{ __('Actividad') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datos as $item)
                                    <tr>
                                        <td>{{$item->ingreso_id}}</td>
                                        <td>{{$item->numero_extintor}}</td>
                                        <td>{{$item->fecha_recepcion}}</td>
                                        <td>{{$item->cantidad_medida}}</td>
                                        <td>{{$item->unidad_medida}}</td>
                                        <td>{{$item->nombre_subCategoria}}</td>
                                        <td>{{$item->nombre_categoria}}</td>
                                        <td>{{$item->nombre_actividad}}({{$item->abreviacion_actividad}})</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Listado De extintores Recargados') }}</h4>
                        </div>
                    </div>

                    @if (session('exito_eliminar_extintor_orden'))
                        <div class="alert alert-success m-3" role="alert">
                            {{ session('exito_eliminar_extintor_orden') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('advertencia_eliminar_extintor_orden'))
                        <div class="alert alert-danger mt-3" role="alert">
                            @if (session('advertencia_eliminar_extintor_orden'))
                                {{ session('advertencia_eliminar_extintor_orden') }}
                            @endif
                        </div>
                    @endif

                    <div class="card-body table-responsive">
                        <table class="table table-striped" id="example">
                            <thead>
                                <tr>
                                    <th>{{ __('Nro Tiquete anterios') }}</th>
                                    <th>{{ __('Nro Tiquete nuevo') }}</th>
                                    <th>{{ __('Nro Extintor') }}</th>
                                    <th>{{ __('Capacidad') }}</th>
                                    <th>{{ __('Unidad de medida') }}</th>
                                    <th>{{ __('SubCategoria') }}</th>
                                    <th>{{ __('Categoria') }}</th>
                                    <th>{{ __('Actividad') }}</th>
                                    <th>{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listadoRecarga as $item)
                                <tr>
                                    <td>{{$item['nro_tiquete_anterior']}}</td>
                                    <td>{{$item['nro_tiquete_nuevo']}}</td>
                                    <td>{{$item['nro_extintor']}}</td>
                                    <td>{{$item['cantidad_medida']}}</td>
                                    <td>{{$item['unidad_medida']}}</td>
                                    <td>{{$item['nombre_subCategoria']}}</td>
                                    <td>{{$item['nombre_categoria']}}</td>
                                    <td>{{$item['nombre_actividad']}}</td>
                                    <td>
                                        <form action="/recarga/eliminar-extintor-orden/{{$item['id'] }}" method="post">
                                            {{ csrf_field()}}
                                            {{ method_field('DELETE')}}
                                            <button type="submit"
                                                    class="btn btn-danger btn-fab btn-fab-mini btn-round mt-2"
                                                    title="Eliminar Extintor">
                                                <i class="material-icons" onclick="return confirm('Desea eliminar el registro?')">close</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Ingresar recarga') }}</h4>
                        </div>
                        @if ($errors->any() || session('advertencia'))
                            <div class="alert alert-danger mt-3" role="alert">
                                @if ($errors->any())
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if (session('advertencia'))
                                    {{ session('advertencia') }}
                                @endif

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col">
                                <h3 style="color: black">{{__('Etiqueta asignar ')}} {{$primerTiquete}}</h3>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal">
                                    Observación etiqueta
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ url('/recarga') }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nro_tiquete_anterior">{{ __('N° tiquete anterior:') }}</label>
                                            <input type="text" class="form-control" id="nro_tiquete_anterior"
                                                name="nro_tiquete_anterior">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nro_tiquete_nuevo">{{ __('N° tiquete nuevo:') }}</label>
                                            <input type="text" class="form-control" id="nro_tiquete_nuevo" required
                                                value="{{$primerTiquete}}" name="nro_tiquete_nuevo">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nro_extintor">{{ __('N° de extintor:') }}</label>
                                            <input type="number" class="form-control" id="nro_extintor" required
                                                value="1" readonly name="nro_extintor">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="agente">{{ __('Agente:') }}</label>
                                            <select name="agente" id="agente" class="form-control">
                                                <option value="">---SELECCIONAR---</option>
                                                @foreach (SubCategoriaActiva() as $item)
                                                <option value="{{ $item->id}}">{{ $item->nombre_subCategoria}}
                                                    --->{{$item->nombre_categoria}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="capacidad">{{ __('Unidad de medida') }}</label>
                                            <select name="capacidad_id" id="capacidadProducto"
                                                class="form-control">
                                                <option value="">{{__('Seleccione unidad de medida')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="activida_recarga_id">{{ __('Seleccionar Actividad') }}</label>
                                            <select class="form-control" name="activida_recarga_id"
                                                id="activida_recarga_id">
                                                <option value="">---SELECCIONAR---</option>
                                                @foreach (Actividad() as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre_actividad }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nro_extintor">{{ __('N° interno cliente:') }}</label>
                                            <input type="text" class="form-control" id="cliente" required
                                                name="nro_interno_cliente" value="{{$clienteS}}" readonly>
                                        </div>
                                    </div>
                                    <div class=" col">
                                        <div class="form-group">
                                            <label for="usuario_recarga_id">{{ __('Colaborador A&S') }}</label>
                                            <p class="form-control">{{ Auth::user()->nombre}}
                                                {{ Auth::user()->apellido}}</p>
                                            <input type=" text" class="form-control" hidden id="usuario_recarga_id"
                                                required name="usuario_recarga_id" value="{{ Auth::user()->id}}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="ingreso_recarga_id">{{ __('N° de referencia:') }}</label>
                                            <input type="text" class="form-control" id="ingreso_recarga_id" required
                                                value="{{$id}}" name="ingreso_recarga_id" readonly>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-center text-warning">{{__('Cambio de partes del extintor')}}</h3>
                                <div class="form-group">

                                    <div class="row">
                                        @foreach (cambioParte() as $item)

                                        <div class="col-3">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="cambioParte[]"
                                                        value="{{$item->id}}">({{$item->id}}){{$item->nombre_parte_cambio}}
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                                <h3 class="text-center text-warning">{{__('Prueba')}}</h3>
                                <div class="form-group">
                                    @foreach (Prueba() as $item)
                                    <div class="form-check form-check-radio form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="prueba_id[]"
                                                id="prueba_id[]"
                                                value="{{$item->id}}">({{$item->abreviacion_prueba}}){{$item->nombre_prueba}}
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>

                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <h3 class="text-center text-warning">{{('Fugas')}}</h3>
                                <div class="form-group">
                                    @foreach (Fuga() as $item)
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="fuga_id"
                                                value="{{$item->id}}">({{$item->abreviacion_fuga}}){{$item->nombre_fuga}}
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="observacion">{{ __('Observación:') }}</label>
                                    <input type="text" class="form-control" id="observacion" name="observacion">
                                </div>
                                <button class="btn btn-warning">{{ __('Enviar') }}</button>

                            </form>
                                {{-- <a href="{{ url('infoRecarga/'.$id) }}">
                                    <button class="btn btn-primary">{{ __('Ver listado') }}</button></a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registro de daño de etiquete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/observacion') }}">
                    {{ csrf_field()}}
                    <div class="form-group">
                        <label for="nro_extintor">{{ __('N° referencia') }}</label>
                        <input type="number" class="form-control" id="numero" required name="numero" value="{{$id}}">
                    </div>
                    <div class="form-group">
                        <label for="nro_extintor">{{ __('N° etiqueta') }}</label>
                        <input type="number" value="{{$primerTiquete}}" class="form-control" id="numero_etiqueta"
                            required name="nro_extintor">
                    </div>

                    <div class="form-group">
                        <label for="nro_extintor">{{ __('Motivo') }}</label>
                        <textarea id="motivo" name="motivo" class="md-textarea form-control" rows="3"></textarea>
                    </div>
                    <div style="text-align:center; margin-top: 30px;">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
    $("#agente").change(function(){
      var categoria = $(this).val();
      $.get('getUnidad/'+categoria, function(data){
//esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
          var producto_select = '<option value="">Seleccione Porducto</option>'
            for (var i=0; i<data.length;i++)
              producto_select+='<option value="'+data[i].id+'">'+data[i].cantidad_medida+'</option>';

            $("#capacidadProducto").html(producto_select);

      });
    });
  });
</script>
@endsection
