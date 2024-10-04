<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <style>
        * {
            font-size: 12px;
            font-family: monospace;
        }

        h1 {
            font-size: 44px;
        }

        .ticket {
            margin: 2px;
        }

        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 250px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .ticket {
            margin: 0;
            padding: 0;
        }

        body {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="ticket centrado">
        <h1 style="font-size: 44px !important;">A&S</h1>
        {{ 'Nit: 901.260.922-9' }}<br />
        {{ 'ASESORIAS Y SUMINISTROS DEL SUR' }}<br />
        {{ 'Telefono: 3162428919 - 3162732918' }}<br />
        {{ 'Carrera 5 #3-153 sur interior 3 EDS Neiva gas' }}<br />
        <br />
        <small><strong>No. referencia: </strong></small>{{ $ingreso->id }}<br />
        <small><strong>Fecha Ingreso: </strong></small>{{ $ingreso->fecha_recepcion }}<br />
        <small><strong>Fecha Entrega: </strong></small>{{ $ingreso->fecha_entrega }}<br />
        <small><strong>Cliente: </strong></small>{{ $ingreso->encargado->nombre_encargado }}<br />
        <br />
        <br />
    </div>
    <div class="ticket">
        @foreach ($data as $item)
            <small><strong>Numero de extintores: </strong></small>{{ $item->cantidad }}<br />
            <small><strong>Actividad: </strong></small>{{ $item->nombre_actividad }}<br />
            <small><strong>Categoria: </strong></small> {{ $item->categoria }}<br />
            <small><strong>Cantidad de Medida: </strong></small>{{ $item->cantidad_medida }} {{ $item->unidad_medida }}<br />
            {{ '---------------------------------' }}<br />
        @endforeach
    </div>
    <div class="ticket centrado">
        <small><strong>Colaborador: </strong></small>{{ $ingreso->usuario->nombre }}
        {{ $ingreso->usuario->apellido }}<br />
    </div>
    <div class="ticket centrado" style="margin-left: 70px; margin-top:20px;">
        <?php echo  DNS1D :: getBarcodeHTML (  $ingreso->id , 'C39+' , 1.5 , 33 );?>
    </div>

</body>

</html>
