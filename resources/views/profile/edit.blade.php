@extends('layouts.app', ['activePage' => 'profile', 'titlePage' => __('Perfil del usuario')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="post" action="{{ route('profile.update') }}" autocomplete="off" class="form-horizontal">
          @csrf
          @method('put')
          <div class="card ">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ __('Editar mi perfil') }}</h4>
              <p class="card-category">{{ __('Información de usuario') }}</p>
            </div>
            <div class="card-body ">
              @if (session('status'))
              <div class="row">
                <div class="col-sm-12">
                  <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>{{ session('status') }}</span>
                  </div>
                </div>
              </div>
              @endif
              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Nombre:') }}</label>
                <div class="col-sm-7">
                  <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre"
                      id="input-nombre" type="text" placeholder="{{ __('Nombre') }}"
                      value="{{ old('nombre', auth()->user()->nombre) }}" required="true" aria-required="true" />
                    @if ($errors->has('nombre'))
                    <span id="nombre-error" class="error text-danger"
                      for="input-nombre">{{ $errors->first('nombre') }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Apellido:') }}</label>
                <div class="col-sm-7">
                  <div class="form-group{{ $errors->has('apellido') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('apellido') ? ' is-invalid' : '' }}" name="apellido"
                      id="input-apellido" type="text" placeholder="{{ __('Apellido') }}"
                      value="{{ old('apellido', auth()->user()->apellido) }}" required="true" aria-required="true" />
                    @if ($errors->has('apellido'))
                    <span id="nombre-error" class="error text-danger"
                      for="input-apellido">{{ $errors->first('apellido') }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Cargo:') }}</label>
                <div class="col-sm-7">
                  <div class="form-group{{ $errors->has('cargo') ? ' has-danger' : '' }}">
                    <select id="cargoN" name="cargoN" type="text" class="form-control{{ $errors->has('cargo') ? ' is-invalid' : '' }}"required disabled>
                      <option value="{{ old('cargo', auth()->user()->cargo) }}">{{ old('cargo', auth()->user()->cargo) }}</option>
                      <input class="form-control"type="hidden" name="cargo" id="cargo" value="{{ old('cargo', auth()->user()->cargo) }}" />
                    </select>
                    @if ('cargo')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('cargo') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Email:') }}</label>
                <div class="col-sm-7">
                  <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                      id="input-email" type="email" placeholder="{{ __('Email') }}"
                      value="{{ old('email', auth()->user()->email) }}" required />
                    @if ($errors->has('email'))
                    <span id="email-error" class="error text-danger"
                      for="input-email">{{ $errors->first('email') }}</span>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <form method="post" action="{{ route('profile.password') }}" class="form-horizontal">
          @csrf
          @method('put')

          <div class="card ">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ __('Cambiar contraseña') }}</h4>
              <p class="card-category">{{ __('Contraseña') }}</p>
            </div>
            <div class="card-body ">
              @if (session('status_password'))
              <div class="row">
                <div class="col-sm-12">
                  <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>{{ session('status_password') }}</span>
                  </div>
                </div>
              </div>
              @endif
              <div class="row">
                <label class="col-sm-2 col-form-label" for="input-current-password">{{ __('Contraseña actual:') }} <span style="color: red">*</span></label>
                <div class="col-sm-7">
                  <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" input
                      type="password" name="old_password" id="input-current-password"
                      placeholder="{{ __('Contraseña actual') }}" value="" required />
                    @if ($errors->has('old_password'))
                    <span id="name-error" class="error text-danger"
                      for="input-name">{{ $errors->first('old_password') }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 col-form-label" for="input-password">{{ __('Nueva contraseña:') }} <span style="color: red">*</span></label>
                <div class="col-sm-7">
                  <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                      id="input-password" type="password" placeholder="{{ __('Nueva contraseña') }}" value="" required />
                    @if ($errors->has('password'))
                    <span id="password-error" class="error text-danger"
                      for="input-password">{{ $errors->first('password') }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 col-form-label"
                  for="input-password-confirmation">{{ __('Confirme nueva contraseña:') }} <span style="color: red">*</span></label>
                <div class="col-sm-7">
                  <div class="form-group">
                    <input class="form-control" name="password_confirmation" id="input-password-confirmation"
                      type="password" placeholder="{{ __('Confirme nueva contraseña') }}" value="" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-primary">{{ __('Cambiar contraseña') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
