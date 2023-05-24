@foreach ($listadoRecarga as $items)
<li>{{ $items['nro_tiquete_anterior'] }}</li>
<li>{{ $items['nro_tiquete_nuevo'] }}</li>

<li>{{ $items['recarga_usuario']['nombre'] }}</li>
@endforeach