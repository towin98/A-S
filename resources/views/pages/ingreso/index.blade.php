@extends('layouts.app', ['activePage' => 'ingreso', 'titlePage' => __('Formulario de ingreso')])
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.proto.js"></script>
<script>
    $(document).ready(function () {
      $(".chosen-select").chosen();
   });

</script>
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col">
            <div class="container">
                @if (session('exito'))
               {{-- <div class="alert alert-success" role="alert">
                    {{ session('exito') }}
                </div> --}}
                <script>
                    window.alert('{{ session('exito') }}');
                </script>
                @endif
                @if (session('validacion_datos'))
                <div class="alert alert-danger" role="alert">
                    {{ session('validacion_datos') }}
                </div>
                @endif

                {{-- Mostrando errores de formulario --}}
                @if ($errors->any())
                    <div class="alert alert-danger mt-3" role="alert">
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Formulario de ingreso') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/ingresoL/{{$crearId->id}}" style="margin-top: 40px;"
                            enctype="/multipart/form-data">
                            {{ csrf_field()}}
                            {{ method_field('PUT')}}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Fecha Ingreso">{{__('Fecha de ingreso')}} <span style="color: red">*</span></label>
                                    <input type="date" class="form-control" id="fecha_recepcion" name="fecha_recepcion"
                                        value="{{$crearId->fecha_recepcion}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Fecha Entrega">{{__('Fecha de entrega')}} <span style="color: red">*</span></label>
                                    <input required type="date" class="form-control" id="fecha_entrega"
                                        name="fecha_entrega">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Numero Referencia">{{__('Numero de referencia')}} <span style="color: red">*</span></label>
                                    <input disabled required type="text" class="form-control" id="numero_referencia"
                                        name="numero_referencia" value="{{$crearId->id}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Usuario">{{__('Colaborador A&S')}} <span style="color: red">*</span></label>
                                    <input disabled required type="text" class="form-control" id="usuario_id"
                                        name="usuario_id" value="{{Auth::user()->nombre}} {{Auth::user()->apellido}}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6" style="margin-top: 44px">
                                    <label for="Numero">{{__('Numero extintores')}} <span style="color: red">*</span></label>
                                    <input required type="number" class="form-control" id="numero_total_extintor"
                                        name="numero_total_extintor" placeholder="Ej: ###">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="encargado">{{__('Cliente')}} <span style="color: red">*</span></label>
                                    <select id="encargado" name="encargado_id"
                                        class=" form-control chosen-select">
                                        <option value="">Seleccionar</option>
                                        @foreach(Encargado() as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item ->nombre_encargado }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>

                </div>
                <div style="text-align:center; margin-top: 30px;">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ url('/home') }}" class="btn btn-danger">Cancelar</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': { allow_single_deselect: true },
        '.chosen-select-no-single': { disable_search_threshold: 10 },
        '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
        '.chosen-select-width': { width: "95%" }
      }
      for (var selector in config) {
        $(selector).chosen(config[selector]);
      }
</script>
@endsection
