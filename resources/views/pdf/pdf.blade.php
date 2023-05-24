<?php
$medidaTicket = 250;
?>
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
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 2px;
        }

        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: <?php echo $medidaTicket ?>px;
            max-width: <?php echo $medidaTicket ?>px;
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
        <h1 style="font-size: 250%">A&S</h1>
        <?php echo "Nit: 901.260.922-9" ?><br/>
        <?php echo "ASESORIAS Y SUMINISTROS DEL SUR"  ?> <br/>
        <?php echo "Telefono: 3162428919 - 3162732918" ?><br/>
        <?php echo "Carrera 5 #3-153 sur interior 3 EDS Neiva gas" ?><br/>
        <br/>
        <small><strong>No. referencia: </strong></small><?php echo $ingreso->id ?><br/>
        <small><strong>Fecha Ingreso: </strong></small><?php echo $ingreso->fecha_recepcion ?><br/>
        <small><strong>Fecha Entrega: </strong></small><?php echo $ingreso->fecha_entrega ?><br/>
        <small><strong>Cliente: </strong></small><?php echo $ingreso->encargado->nombre_encargado ?><br/>

        <br/>
        <br/>
    </div>
    <div class="ticket">
        @foreach($data as $item)
            <small><strong>Numero de extintores: </strong></small><?php echo $item->numero_extintor ?><br/>
            <small><strong>Actividad: </strong></small><?php echo $item->nombre_actividad ?><br/>
            <small><strong>Unidad de Medida: </strong></small><?php echo $item->unidad_medida ?><br/>
            <small><strong>Cantidad de Medida: </strong></small><?php echo $item->cantidad_medida ?><br/>
            <?php echo "---------------------------------" ?><br/>
        @endforeach
    </div>
    <div class="ticket centrado">
        <small><strong>Colaborador: </strong></small><?php echo $ingreso->usuario->nombre . " " . $ingreso->usuario->apellido ?><br/>
    </div>
    <div class="ticket centrado" style="margin-left: 70px; margin-top:20px;">

        <?php echo  DNS1D :: getBarcodeHTML (  $ingreso->id , 'C39+' , 1.5 , 33 );?>
    </div>


</body>
</html>
