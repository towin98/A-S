@extends('layouts.app', ['activePage' => 'ingreso', 'titlePage' => __('Listado de ingreso')])

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
                                <h4 class="card-title">Listado de ingreso <u> <b> Orden de Servicio: </b> <strong>
                                            {{ $numeroReferencia }} </u> </strong></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold"> Cliente:
                                {{ $cliente->encargado->numero_serial . ' - ' . $cliente->encargado->nombre_encargado }}
                            </h5>
                            <table class="table" id="example">
                                <thead>
                                    <tr class="text-left">
                                        {{-- <th>{{ __('Orden') }}</th> --}}
                                        {{-- <th>{{ __('Cliente') }}</th> --}}
                                        <th>{{ __('Fecha ingreso') }}</th>
                                        <th>{{ __('SubCategoria') }}</th>
                                        <th>{{ __('Unidad medida') }}</th>
                                        <th>{{ __('Capacidad') }}</th>
                                        <th>{{ __('Actividad') }}</th>
                                        <th>{{ __('Cant.') }}</th>
                                        <th>{{ __('Evento') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listIngreso as $item)
                                        <tr>
                                            {{-- <td>{{$numeroReferencia}}</td> --}}
                                            {{-- <td>{{ $cliente->encargado->numero_serial }}</td> --}}
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->nombre_subCategoria }}</td>
                                            <td>{{ $item->unidad_medida }}</td>
                                            <td>{{ $item->cantidad_medida }}</td>
                                            <td>{{ $item->nombre_actividad }}</td>
                                            <td>{{ $item->numero_extintor }}</td>
                                            <td>
                                                <form action="/listadoIngreso/{{ $item->id }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit"
                                                        class="btn btn-danger btn-fab btn-fab-mini btn-round mt-2"
                                                        style=""><i class="material-icons">close</i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <a href="{{ url('ingresoact/' . $numeroReferencia) }}">
                                <button id="enviar" class="btn btn-success" style="float: right">{{ __('Producción') }}</button>
                            </a>
                            <a href="{{ url('ingresoL/' . $numeroReferencia) }}">
                                <button id="enviar" class="btn btn-warning" style="float: right">{{ __('Regresar') }}</button>
                            </a>
                            <a href="{{ url('ticket/' . $numeroReferencia) }}" target="_blank">
                                <button type="submit" class="btn btn-success"> {{ __('Imprimir') }}</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
