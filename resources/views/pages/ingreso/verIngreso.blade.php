@extends('layouts.app', ['activePage' => 'ingreso', 'titlePage' => __('Formulario de ingreso')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col">
            <div class="container">
                @if (session('exito'))
                <div class="alert alert-success" role="alert">
                    {{ session('exito') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-success" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text">
                            <h4 class="card-title">{{ __('Ver ingreso') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="example">
                            <thead>
                                <tr class="text-left">
                                    <th>{{ __('Orden Servicio') }}</th>
                                    <th>{{ __('Fecha ingreso') }}</th>
                                    <th>{{ __('Fecha entrega') }}</th>
                                    <th>{{ __('Colaborador A&S') }}</th>

                                    <th>{{ __('No extintores') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th>{{ __('Evento') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->numero_referencia }}</td>
                                    <td>{{ $item->fecha_recepcion }}</td>
                                    <td>{{ $item->fecha_entrega }}</td>
                                    <td>{{ $item->Usuario->nombre}}</td>


                                    <td>{{ $item->numero_total_extintor }}</td>
                                    <td>{{ $item->estado }}</td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-fab btn-fab-mini btn-round"
                                            data-toggle="modal" data-target="#editar{{ $item->id }}">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <a href="{{ url('ticket/'.$item->numero_referencia) }}" target="_blank"><button
                                                type="submit" class="btn btn-info btn-fab btn-fab-mini btn-round">
                                                <i class="material-icons">assignment</i>
                                            </button></a>

                                        <!-- Modal -->
                                        <div class="modal" tabindex="-1" role="dialog" id="editar{{ $item->id }}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{__('Editar ingreso')}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="/ingreso/{{$item->id}}"
                                                            style="margin-top: 40px;" enctype="/multipart/form-data">
                                                            {{ csrf_field()}}
                                                            {{ method_field('PUT')}}
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="Fecha Ingreso">{{__('Fecha de
                                                                        ingreso')}}</label>
                                                                    <input type="date" class="form-control"
                                                                        id="fecha_recepcion" name="fecha_recepcion"
                                                                        value="{{$item->fecha_recepcion}}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="Fecha Entrega">{{__('Fecha de
                                                                        entrega')}}</label>
                                                                    <input required type="date" class="form-control"
                                                                        id="fecha_entrega" name="fecha_entrega"
                                                                        value="{{$item->fecha_entrega}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="Numero Referencia">{{__('Numero de
                                                                        referencia')}}</label>
                                                                    <input disabled required type="text"
                                                                        class="form-control" id="numero_referencia"
                                                                        name="numero_referencia" value="{{$item->id}}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="Usuario">{{__('Colaborador
                                                                        A&S')}}</label>
                                                                    <input disabled required type="text"
                                                                        class="form-control" id="usuario_id"
                                                                        name="usuario_id"
                                                                        value="{{Auth::user()->nombre}} {{Auth::user()->apellido}}">
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6"
                                                                    style="margin-top: 44px">
                                                                    <label for="Numero">{{__('Numero
                                                                        exintores')}}</label>
                                                                    <input disabled required type="number"
                                                                        class="form-control"
                                                                        name="numero_total_extintor"
                                                                        id="numero_total_extintor"
                                                                        value="{{$item->numero_total_extintor}}">
                                                                </div>
                                                            </div>
                                                            <div style="text-align:center; margin-top: 30px;">
                                                                <button type="submit"
                                                                    class="btn btn-success">Guardar</button>
                                                                <a href="{{ url('/home') }}"
                                                                    class="btn btn-danger">Cancelar</a>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
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
@endsection
