@foreach ($generarCodigo as $item)
<div>
    {{!!DNS1D::getBarcodeHTML($item->numero_tiquete, 'C128')!!}}
</div>
{{-- <div style="padding-top: 50px; width: 50px;">
{{$item->}}
</div> --}}
@endforeach