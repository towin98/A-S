@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'info', 'title' => __('información')])

@section('content')
<div class="container" style="font-size: 1.5rem" style="height: auto;">
    <div class="row align-items-center">

        <div class="col-md-9 ml-auto mr-auto mb-3 text-center">
            <h3>{{ __('Para ver su historial del extintor por favor digitar la siguiente información') }} </h3>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ url('info') }}">
                @csrf
                <div class="card card-login card-hidden mb-3">
                    <div class="card-header card-header-primary text-center">
                        <h4 class="card-title"><strong>{{ __('Consultar información') }}</strong></h4>
                        <div class="social-line">
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <select name="tipo" id="tipo" class="form-control">
                            <option>{{__('Seleccionar tipo documento')}}</option>
                            <option value="numero_serial">{{__('CC')}}</option>
                            <option value="nit">{{__('NIT')}}</option>
                        </select>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" name="numeroDocumento" class="form-control"
                                    placeholder="{{ __('Numero de documento') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" name="numeroEtiqueta" class="form-control"
                                    placeholder="{{ __('Numero de etiqueta') }}" required>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" name="numeroReferencia" class="form-control" id="referencia"
                                    placeholder="{{ __('Numero de Referencia') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Buscar') }}</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-6">
                    @if (Route::has('password.request'))
                    <a href="{{ route('login') }}" class="text-light">
                        <small>{{ __('Ingresar') }}</small>
                    </a>
                    @endif
                </div>
            </div>
            @if (session('mensaje'))
            <div class="alert alert-danger" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
