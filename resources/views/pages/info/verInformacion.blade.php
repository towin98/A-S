<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informacion general</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.material.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>

<body>
    <div class="container mt-5">
        <h3 class="text-center">{{__('Informacion general del extintor')}}</h3>

        <table id="example" class="table table-borderedss table-hover" style="width:100%">
            <thead class="thead-light">
                <tr>
                    <th># referencia</th>
                    <th>Fecha ingreso</th>
                    <th>Fecha entrega</th>
                    <th>Actividad</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sql as $item)
                <tr>
                    <td>{{$item->numero_referencia}}</td>
                    <td>{{$item->fecha_recepcion}}</td>
                    <td>{{$item->fecha_entrega}}</td>
                    <td>{{$item->nombre_actividad}}</td>
                    <td>{{$item->numero_extintor}}</td>
                    {{-- <td>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-random" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#pruebas">
                            <i class="fa fa-tripadvisor" aria-hidden="true"></i>
                        </button></td>
                </tr> --}}
                @endforeach
            </tbody>
        </table>
        <a name="" id="" class="btn btn-primary text-center" href="{{ url('/') }}" role="button"> <i
                class="fa fa-reply-all" aria-hidden="true"></i> Volver</a>
    </div>

  {{--   <!-- Modal cambio de partes -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Cambio de partes')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="example" class="table table-borderedss table-hover" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Nombre parte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listadoCambioPartes as $cambio)
                            <tr>
                                <td>{{$cambio->nombre_parte_cambio}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal pruebas -->
    <div class="modal fade" id="pruebas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Pruebas realizadas')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="example" class="table table-borderedss table-hover" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Nombre de la prueba</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listadoPruebas as $prueba)
                            <tr>
                                <td>{{$prueba->nombre_prueba}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script>
        $(document).ready(function() {
                        $('#example').DataTable( {
                        "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                        },
                        dom: 'Bfrtip',

                        buttons: [ {
                        extend:    'excelHtml5',
    				    text:      '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
    				    titleAttr: 'Exportar a Excel',
    				    className: 'btn btn-success'

                        },
                        {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                        className: 'btn btn-danger',
                        titleAttr: 'Exportar a pdf',
                        },
                        {
                        extend:    'print',
    				    text:      '<i class="fa fa-print"></i> ',
    				    titleAttr: 'Imprimir',
    				    className: 'btn btn-info'
                        } ],
                        columnDefs: [
                        {
                        targets: ['_all'],
                        className: 'mdc-data-table__cell'
                        }
                        ]
                        } );
                        } );
    </script> --}}
</body>

</html>
