const boton_buscar = document.querySelector(
    "#id_buscar"
);
// Agregar listener
boton_buscar.addEventListener("click", function(e) {
    e.preventDefault();
    document.getElementById('id_propietario').innerHTML = "";

    var loadingOverlay = document.getElementById("loading-overlay");
    loadingOverlay.style.display = "flex";

    const id_cliente = document.getElementById("encargado").value;
    const fecha_desde = document.getElementById("id_fecha_del").value;
    const fecha_hasta = document.getElementById("id_fecha_hasta").value;

    const data = { id_cliente, fecha_desde, fecha_hasta };
    const myHeader = new Headers({
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
            "content"
        ),
        'Content-Type': 'application/json'
    });

    fetch(`/reporte/cliente-ordenes-servicio`, {
            method  : "POST",
            body    : JSON.stringify(data),
            headers : myHeader
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                return response.json().then(errorData => {
                    // convirtiendo la respuesta a un string.
                    throw new Error(JSON.stringify(errorData));
                });
            }
        })
        .then(data => {

            document.getElementById('id_propietario').innerHTML = "&nbsp;&nbsp;"+data.propietario;

            // Obtener la instancia de DataTables
            let tabla = $('#example').DataTable();

            // Vaciar todas las filas de la tabla
            tabla.clear().draw();

            // Recorre los datos y agrega filas y celdas a la tabla
            Object.values(data.data).forEach(function(orden, index) {

                Object.values(orden).forEach(function(item, index) {
                    let fila = tabla.row.add([
                        item.orden_servicio,
                        item.agente,
                        item.capacidad_producto,
                        item.total,
                        item.color
                    ]).draw(false).node();
                    fila.style.background = item.color
                });

            });

            // Ajustar las columnas para reflejar los cambios
            tabla.columns.adjust().draw();
            loadingOverlay.style.display = "none";
        })
        .catch(error => {
            loadingOverlay.style.display = "none";
            // Convirtiendo a Object la respuesta
            const errorData = JSON.parse(error.message);

            let errores = errorData.message + ":\n\n";
            // Manejar el error de la solicitud
            for (let i = 0; i < errorData.errors.length; i++) {
                errores += (i+1)+". "+errorData.errors[i]+"\n";
            }
            alert(errores);
        });
});
