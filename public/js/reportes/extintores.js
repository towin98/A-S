const boton_buscar_etiqueta_extintor = document.querySelector(
    "#id_buscar_etiqueta_extintor"
);
// Agregar listener
boton_buscar_etiqueta_extintor.addEventListener("click", function(e) {
    e.preventDefault();
    document.getElementById('id_propietario').innerHTML = "";

    // Obtener la instancia de DataTables
    let tabla = $('#example').DataTable();

    // Vaciar todas las filas de la tabla
    tabla.clear().draw();

    let search_numero_etiqueta = document.getElementById("id_etiqueta_extintor").value;
    search_numero_etiqueta = search_numero_etiqueta.trim();

    if (search_numero_etiqueta == "") {
        alert("Debe diligenciar la etiqueta del extintor para buscar.");
        document.getElementById("id_etiqueta_extintor").value = '';
        return;
    }

    var loadingOverlay = document.getElementById("loading-overlay");
    loadingOverlay.style.display = "flex";

    fetch(`/reporte/extintor-etiqueta/${search_numero_etiqueta}`)
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error("Error en la solicitud.");
            }
        })
        .then(data => {
            let contador = 1;
            // Recorre los datos y agrega filas y celdas a la tabla
            data.data.forEach(function(item) {
                tabla.row.add([
                    contador,
                    item.nro_tiquete_anterior,
                    item.nro_tiquete_nuevo,
                    item.ingreso_recarga_id,
                    item.agente,
                    item.capacidad_producto,
                    item.unidad_medida,
                    item.nombre_actividad,

                    item.parte_1,
                    item.parte_2,
                    item.parte_3,
                    item.parte_4,
                    item.parte_5,
                    item.parte_6,
                    item.parte_7,
                    item.parte_8,
                    item.parte_9,
                    item.parte_10,
                    item.parte_11,
                    item.parte_12,
                    item.parte_13,

                    item.PI,
                    item.HI,
                    item.HE,

                    item.niple,
                    item.recipiente,
                    item.valvula,
                    item.acople_manguera,

                    item.fecha
                ]).draw(false);
                contador++;
            });

            document.getElementById('id_propietario').innerHTML = "&nbsp;&nbsp;"+data.propietario;

            // Ajustar las columnas para reflejar los cambios
            tabla.columns.adjust().draw();
            loadingOverlay.style.display = "none";
        })
        .catch(error => {
            // Manejar el error de la solicitud
            loadingOverlay.style.display = "none";
            alert(error)
        });
});
