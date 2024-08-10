<div class="sidebar" data-color="orange" data-background-color="white" style="font-size: 4.5rem"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <div class="logo">
        <a href="https://creative-tim.com/" class="simple-text logo-normal">
            <img src="{{ asset('material/img/icono.png') }}" height="25px" width="25px" alt="">
            {{ __('A & S') }}
        </a>
        <h5 style="text-align: center">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h5>
    </div>

    <div class="sidebar-wrapper">
        <ul class="nav">

            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Panel administrativo') }}</p>
                </a>
            </li>
            {{-- @can('tecnico') --}}
            <li class="nav-item{{ $activePage == 'recargas' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('recarga') }}">
                    <i class="material-icons">reorder</i>
                    <p>{{ __('Recargas') }}</p>
                </a>
            </li>
            {{-- @endcan --}}

            <li class="nav-item {{ $activePage == 'hocol' ? ' active' : '' }}">
                <a class="nav-link " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">streetview</i>
                    <p>
                        {{__('Hocol')}}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ url('hocol') }}">
                        <i class="material-icons">addchart</i>
                        <p>{{ __('Nuevo ingreso') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    @can('recepcionista')
                    <a class="dropdown-item" href="{{ route('ingreso-hocol') }}">
                        <i class="material-icons">visibility</i>
                        <p>{{ __('Ver ingresos') }}</p>
                    </a>
                    @endcan

                </div>
            </li>
            <li class="nav-item {{ $activePage == 'ingreso' ? ' active' : '' }}">
                <a class="nav-link " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">pan_tool</i>
                    <p>
                        {{__('Ingreso')}}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ url('ingreso/'.Auth::user()->id) }}">
                        <i class="material-icons">addchart</i>
                        <p>{{ __('Nuevo ingreso') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('listIngreso') }}">
                        <i class="material-icons">visibility</i>
                        <p>{{ __('Ver ingresos') }}</p>
                    </a>
                </div>
            </li>

            <li class="nav-item {{ $activePage == 'reportes' ? ' active' : '' }}">
                <a class="nav-link " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">summarize</i>
                    <p>
                        {{__('Reportes')}}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ url('reporte/extintor') }}">
                        <i class="material-icons">search</i>
                        <p>{{ __('Extintor') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('reporte/cliente-extintor') }}">
                        <i class="material-icons">search</i>
                        <p>{{ __('Cliente Extintor') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('reporte/orden-servicio') }}">
                        <i class="material-icons">search</i>
                        <p>{{ __('Orden Servicio') }}</p>
                    </a>
                </div>
            </li>

            @can('recepcionista')
            <li class="nav-item {{ $activePage == 'profile' ? ' active' : '' }}">
                <a class="nav-link " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">supervisor_account</i>
                    <p>{{__('Colaborador A&S')}}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="material-icons">business</i>
                        <p>{{ __('Mi perfil') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('user.index') }}">
                        <i class="material-icons">supervisor_account</i>
                        <p>{{ __('Usuario') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('registro') }}">
                        <i class="material-icons">group_add</i>
                        <p>{{ __('Nuevo colaborador') }}</p>
                    </a>
                </div>
            </li>
            @endcan

            <li class="nav-item {{ $activePage == 'empresa_encargado' ? ' active' : '' }}">
                <a class="nav-link " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">business</i>
                    <p>
                        {{__('Clientes')}}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="dropdown-menu">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('encargado') }}">
                        <i class="material-icons">supervisor_account</i>
                        <p>{{ __('Cliente') }}</p>
                    </a>
                </div>
            </li>

            @can('recepcionista')
            <li class="nav-item dropdown {{ $activePage == 'categoria' ? ' active' : '' }}">
                <a class="nav-link " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">category</i>
                    <p>
                        {{__('Categoria')}}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('categoria') }}">
                        <i class="material-icons">category</i>
                        <p>{{ __('Categoria') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('subCategoria') }}">
                        <i class="material-icons">bubble_chart</i>
                        <p>{{ __('SubCategoria') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('unidad') }}">
                        <i class="material-icons">drag_indicator</i>
                        <p>{{ __('Unidad') }}</p>
                    </a>
                </div>
            </li>
            @endcan

            @can('recepcionista')
            <li class="nav-item dropdown {{ $activePage == 'adicionales' ? ' active' : '' }}">
                <a class="nav-link " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">construction</i>
                    <p>
                        {{__('Adicionales')}}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('actividad') }}">
                        <i class="material-icons">assignment</i>
                        <p>{{ __('Actividades') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('cambio') }}">
                        <i class="material-icons">build</i>
                        <p>{{ __('Cambio de partes') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('prueba') }}">
                        <i class="material-icons">fact_check</i>
                        <p>{{ __('Pruebas') }}</p>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('fuga') }}">
                        <i class="material-icons">new_releases</i>
                        <p>{{ __('Fugas') }}</p>
                    </a>
                </div>
            </li>
            <li class="nav-item{{ $activePage == 'Observacion' ? ' active' : '' }}">
                <a class="dropdown-item" href="{{ route('observacion') }}">
                    <i class="material-icons">new_releases</i>
                    <p>{{ __('Observaciones') }}</p>
                </a>
            </li>
            @endcan

        </ul>
    </div>
</div>
