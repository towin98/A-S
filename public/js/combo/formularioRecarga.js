

$(function fnSubcategoria() {
    //Cuando el combo de subcategoria tenga un cambio
    $("#Subcategoria").on('change', SelectCategoriaChange);
});

function SelectCategoriaChange() {
    //para asignar el id de la categoria seleccionada
    var Subcategoria = $(this).val();
    if(Subcategoria==0){
        alert('Por favor seleccione una subcategoria')
        return;
    }
    //AJAX

    $.get('comboUnidadMedida/'+Subcategoria+'', function fnSubcategoria(dataSubcategoria) {
        var html_select = '<option value="">Seleccione</option>';
        for (var n=0; n<dataSubcategoria.length; ++n)
            html_select += '<option value="'+dataSubcategoria[n].id+'">'+dataSubcategoria[n].cantidad_medida+" "+dataSubcategoria[n].unidad_medida+'</option>'
        $('#unidad_medida_id').html(html_select);
    });
    
}


