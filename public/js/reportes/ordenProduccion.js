const boton_buscar_orden_servicio = document.querySelector("#id_buscar_orden_servicio");

boton_buscar_orden_servicio.addEventListener("click", function(e) {
    e.preventDefault();

    // Obtener la instancia de DataTables
    let tabla = $('#example').DataTable();

    // Vaciar todas las filas de la tabla
    tabla.clear().draw();

    var loadingOverlay = document.getElementById("loading-overlay");
    loadingOverlay.style.display = "flex";

    const id_orden = document.getElementById("id_orden_servicio").value;

    const data = { id_orden };
    const myHeader = new Headers({
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
            "content"
        ),
        'Content-Type': 'application/json'
    });

    fetch(`/reporte/produccion`, {
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

            let contador = 1;
            // Recorre los datos y agrega filas y celdas a la tabla
            data.data.forEach(function(item) {
                tabla.row.add([
                    contador,
                    item.nro_tiquete_anterior,
                    item.nro_tiquete_nuevo,
                    // item.ingreso_recarga_id,

                    item.n_extintor,
                    item.n_interno_cliente,
                    item.fecha_hidrostatica,

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
                    item.na,

                    item.fecha
                ]).draw(false);
                contador++;
            });

            document.getElementById('orden_servicio').textContent = data.data_extra.id_orden;
            document.getElementById('fecha_recepcion').textContent = data.data_extra.fecha_recepcion;
            document.getElementById('fecha_entrega').textContent = data.data_extra.fecha_entrega;
            document.getElementById('id_propietario').textContent = data.data_extra.cliente;
            document.getElementById('operario').textContent = data.data_extra.operario;

            loadingOverlay.style.display = "none";
        })
        .catch(error => {
            document.getElementById('orden_servicio').textContent = '';
            document.getElementById('fecha_recepcion').textContent = '';
            document.getElementById('fecha_entrega').textContent = '';
            document.getElementById('id_propietario').textContent = '';
            document.getElementById('operario').textContent = '';

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
