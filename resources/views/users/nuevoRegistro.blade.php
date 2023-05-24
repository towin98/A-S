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
                                <h4 class="card-title">{{ __('Registro de nuevo colaborador') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{url('/registro')}}">
                                {{ csrf_field()}}
                                <div class="bmd-form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">face</i>
                                            </span>
                                        </div>
                                        <input type="text" name="nombre" class="form-control"
                                            placeholder="{{ __('Nombre...') }}" value="{{ old('nombre') }}" required>
                                    </div>
                                    @if ($errors->has('nombre'))
                                    <div id="nombre-error" class="error text-danger pl-3" for="nombre"
                                        style="display: block;">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="bmd-form-group{{ $errors->has('apellido') ? ' has-danger' : '' }} mt-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">face</i>
                                            </span>
                                        </div>
                                        <input type="text" name="apellido" class="form-control"
                                            placeholder="{{ __('Apellido...') }}" value="{{ old('apellido') }}"
                                            required>
                                    </div>
                                    @if ($errors->has('apellido'))
                                    <div id="apellido-error" class="error text-danger pl-3" for="apellido"
                                        style="display: block;">
                                        <strong>{{ $errors->first('apellido') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="bmd-form-group{{ $errors->has('cargo') ? ' has-danger' : '' }} mt-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">how_to_reg</i>
                                            </span>
                                        </div>
                                        <select id="cargo" type="text"
                                            class="form-control{{ $errors->has('cargo') ? ' is-invalid' : '' }}"
                                            name="cargo" required>
                                            <option value="">Seleccione cargo</option>
                                            <option value="Administrador">{{__('Administrador')}}</option>
                                            <option value="Tecnico">{{__('Técnico')}}</option>
                                        </select>
                                        @if('cargo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cargo') }}</strong>
                                        </span>
                                        @endif

                                    </div>

                                </div>
                                <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">email</i>
                                            </span>
                                        </div>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
                                    </div>
                                    @if ($errors->has('email'))
                                    <div id="email-error" class="error text-danger pl-3" for="email"
                                        style="display: block;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="{{ __('Password...') }}" required>
                                    </div>
                                    @if ($errors->has('password'))
                                    <div id="password-error" class="error text-danger pl-3" for="password"
                                        style="display: block;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div
                                    class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" placeholder="{{ __('Confirmar Password...') }}"
                                            required>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                    <div id="password_confirmation-error" class="error text-danger pl-3"
                                        for="password_confirmation" style="display: block;">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-check mr-auto ml-3 mt-3">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="policy" name="policy"
                                            {{ old('policy', 1) ? 'checked' : '' }}>
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                        <a href="#">{{ __('Acepta politicas de seguridad') }}</a>
                                    </label>
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
