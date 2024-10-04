<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="icon" type="image/x-icon" href="https://image.flaticon.com/icons/png/512/2053/2053895.png"> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('A & S') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/icono.png">
    <link rel="icon" type="image/png" href="{{ asset('material') }}/img/icono.png">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"> --}}
    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('chosen/chosen.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/4.0.0/material-components-web.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.material.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!--IMPORTANDO BOOTSTRAP 4.-->
    <link rel="stylesheet" href="{{ asset('css') }}/app.css">

    {{-- Estilos para loading --}}
    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body class="{{ $class ?? '' }}" style="font-size: 1rem">
    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>
    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @include('layouts.page_templates.auth')
    @endauth
    @guest()
    @include('layouts.page_templates.guest')
    @endguest

    <!--   Core JS Files   -->
    <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE'"></script>
    <!-- Chartist JS -->
    <script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('material') }}/demo/demo.js"></script>
    <script src="{{ asset('material') }}/js/settings.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="{{ asset('chosen/chosen.jquery.js') }}"></script>
    @yield('script')
    @stack('js')

    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            var loadingOverlay = document.getElementById("loading-overlay");
            loadingOverlay.style.display = "none";
        });
        $(document).ready(function() {
            $('#example').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',

                order: [[0, "desc"]], // Aqui la columna a ordenar
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel" style="font-size:15px;"></i> ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success',

                        customize: function (xlsx) {

                            switch (document.getElementById('id_origen')?.textContent) {
                                case 'REPORTE_EXTINTOR':
                                case 'REPORTE_CLIENTE_EXTINTOR':
                                    // Obtener la hoja de trabajo activa
                                    let sheet = xlsx.xl.worksheets['sheet1.xml'];

                                    let sheetData = sheet.childNodes[0].childNodes[1];
                                    let numeroFilas = sheetData.childNodes.length;
                                    const title = "<row  r='1'>" + sheet.childNodes[0].childNodes[1].childNodes[0].innerHTML + "</row>";

                                    let contenido = "";
                                    if (document.getElementById('id_origen')?.textContent == "REPORTE_CLIENTE_EXTINTOR") {

                                        const rangeDates = "<row  r='2'>" +
                                                "<c t='inlineStr' r='A2' s='2'><is><t xml:space='preserve'>Fecha de Reporte:</t></is></c>" +
                                                "<c t='inlineStr' r='B2'      ><is><t xml:space='preserve'>"+document.getElementById("id_fecha_del").value+" Al "+document.getElementById("id_fecha_hasta").value+"</t></is></c>" +
                                        "</row>";
                                        contenido += rangeDates;
                                    }

                                    const propietario = "<row  r='3'>" +
                                                "<c t='inlineStr' r='A3' s='2'><is><t xml:space='preserve'>Propietario:</t></is></c>" +
                                                "<c t='inlineStr' r='B3'      ><is><t xml:space='preserve'>"+document.getElementById("id_propietario").textContent+"</t></is></c>" +
                                        "</row>";
                                    contenido += propietario;

                                    let contadorColocarRow = 4;

                                    for (let row = 2; row <= numeroFilas; row++) {

                                        // Agregando campo en la fila del excel
                                        let targetElement = sheet.childNodes[0].childNodes[1].childNodes[(row-1)];

                                        targetElement = filaConvertirPosicion(targetElement, contadorColocarRow);

                                        contenido += "<row r='"+contadorColocarRow+"'>" + targetElement.innerHTML + "</row>";
                                        contadorColocarRow ++;
                                    }

                                    // Sobreescribiendo data a imprimir en el excel
                                    sheet.childNodes[0].childNodes[1].innerHTML = title + contenido;
                                    break;
                            }
                        }

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> ',
                        titleAttr: 'Imprimir',
                        className: 'btn btn-info',
                        customize: function (win) {

                            switch (document.getElementById('id_origen')?.textContent) {
                                case 'REPORTE_EXTINTOR':
                                case 'REPORTE_CLIENTE_EXTINTOR':

                                    // Agregar el contenido personalizado después del título de la página
                                    let body = $(win.document.body);
                                    let title = body.find('h1'); // Cambia 'h1' al selector que corresponda al título de tu página

                                    if (document.getElementById('id_origen')?.textContent == "REPORTE_CLIENTE_EXTINTOR") {
                                        // Agrengando rango
                                        let customContent = document.createElement('div');
                                        customContent.style.textAlign    = 'left';
                                        customContent.style.marginBottom = '20px';

                                        // Crear un elemento strong para el texto "Fecha de Reporte"
                                        let strongElement = document.createElement('strong');
                                        strongElement.textContent = 'Fecha de Reporte: ';

                                        // Agregar el elemento strong al contenido personalizado
                                        customContent.appendChild(strongElement);
                                        customContent.innerHTML += document.getElementById("id_fecha_del").value+" Al "+document.getElementById("id_fecha_hasta").value;

                                        title.after(customContent);
                                    }

                                    // Crear un nuevo elemento div para el contenido personalizado
                                    let customContent = document.createElement('div');
                                    customContent.style.textAlign    = 'left';
                                    customContent.style.marginBottom = '20px';

                                    // Crear un elemento strong para el texto "Propietario"
                                    let strongElement = document.createElement('strong');
                                    strongElement.textContent = 'Propietario: ';

                                    // Agregar el elemento strong al contenido personalizado
                                    customContent.appendChild(strongElement);
                                    customContent.innerHTML += document.getElementById("id_propietario").textContent;

                                    title.after(customContent);
                                break;
                            }

                        }
                    }
                ],
                columnDefs: [{
                    targets: ['_all'],
                    className: 'mdc-data-table__cell'
                }]
            });
        });

        function filaConvertirPosicion(targetElement, spaceRowCurrent){

            const spaceEntryTitleTable = 2;

            for (let i = 0; i < targetElement.childNodes.length; i++) {
                let childNode = targetElement.childNodes[i];

                if (childNode.nodeName === "c") {
                    let valor = childNode.getAttribute("r");
                    childNode.setAttribute('r', valor.replace((spaceRowCurrent - spaceEntryTitleTable), spaceRowCurrent));
                }
            }

            return targetElement;
        }
    </script>
</body>

</html>
