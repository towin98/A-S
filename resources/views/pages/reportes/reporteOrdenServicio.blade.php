@extends('layouts.app', ['activePage' => 'reportes', 'titlePage' => __('Reporte Orden de Servicio')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col">
                <div class="container">
                    <div class="card">

                        <div class="card-header card-header-text card-header-warning" style="color: black">
                            <div class="card-text">
                                <h4 class="card-title">{{ __('Buscar Orden de Servicio') }}</h4>
                            </div>
                            <div class="form-group">
                                <label class="px-2" for="id_orden_servicio">{{ __('Orden de Servicio') }}</label>
                                <div class="d-flex">
                                    <div class="px-2 w-100">
                                        <input type="text" placeholder="Ingrese Orden de Servicio" class="form-control"
                                            id="id_orden_servicio" name="orden_servicio" required>
                                    </div>
                                    <div class="ml-auto px-2">
                                        <button type="button" id="id_buscar_orden_servicio"
                                            class="btn btn-success mt-0">Buscar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button onclick="imprimirSeccion()" class="btn btn-success px-2 py-0">
                                    <i class="fas fa-print"></i>
                                    Imprimir
                                </button>
                            </div>

                            <div class="card mt-2" id="imprimir">

                                <div class="card-body" style="background: #ff7878; border-radius: 8px 8px 0px 0px;">
                                    <h5 class="card-title text-center font-weight-bold text-white" style="font-size: x-large; margin: 0px 0px 0px 0px; ">A & S</h5>
                                    <div class="text-center text-white">PEDIDO - RECEPCION DE EXTINTORES</div>
                                </div>

                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-4 col-12">
                                            <strong>Fecha Recepción: </strong>
                                            <input type="text" id="id_fecha_recepcion" class="form-control limpiarCampos" disabled>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <strong>Fecha Entrega: </strong>
                                            <input type="text" id="id_fecha_entrega" class="form-control limpiarCampos" disabled>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <strong># Orden: </strong>
                                            <input type="text" id="id_orden" class="form-control limpiarCampos" disabled>
                                        </div>
                                    </div>

                                    <div class="row my-2">
                                        <div class="col-md-4 col-12">
                                            <strong>Cliente: </strong>
                                            <input type="text" id="id_cliente" class="form-control limpiarCampos" disabled>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <strong>Nit: </strong>
                                            <input type="text" id="id_nit" class="form-control limpiarCampos" disabled>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <strong>Dirección: </strong>
                                            <input type="text" id="id_direccion" class="form-control limpiarCampos" disabled>
                                        </div>
                                    </div>

                                    <div class="row my-2">
                                        <div class="col-md-4 col-12">
                                            <strong>Contacto: </strong>
                                            <input type="text" id="id_contacto" class="form-control limpiarCampos" disabled>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <strong>Email: </strong>
                                            <input type="text" id="id_email" class="form-control limpiarCampos" disabled>
                                        </div>
                                    </div>
                                    <br>

                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Agente</th>
                                                <th scope="col">Capacidad del Producto</th>
                                                <th scope="col">Unidad Medida</th>
                                                <th scope="col">Total x Categoria</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-end">
                                        <strong style="padding-top: 10px;">Total Extintores: &nbsp;&nbsp;&nbsp;</strong>
                                        <input type="text" id="id_total_extintores" style="width: 100px;" class="form-control limpiarCampos" disabled>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/reportes/ordenServicio.js') }}"></script>
@endsection
