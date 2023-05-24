$(function fnCategoria() {
    //Cuando el combo de categoria tenga un cambio
    $("#categoria").on('change', SelectCategoriaChange);
});

function SelectCategoriaChange() {
    //para asignar el id de la categoria seleccionada
    var categoria = $(this).val();
    if(categoria==0){
        alert('Por favor seleccione una categoria')
        return;
    }
    //AJAX

    $.get('comboSubcategoria/' + categoria + '', function fnCategoria(data) {
        var html_select = '<option value="">Seleccione</option>';
        for (var i=0; i<data.length; ++i)
            html_select += '<option value="'+data[i].id+'">'+data[i].nombre_subCategoria+'</option>'
        $('#Subcategoria').html(html_select);
    });
    
}

$(function fnSubcategoria() {
    //Cuando el combo de subcategoria tenga un cambio
    $("#Subcategoria").on('change', SelectSubcategoriaChange);
});

function SelectSubcategoriaChange() {
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


