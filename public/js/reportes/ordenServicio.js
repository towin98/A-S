const boton_buscar_orden_servicio = document.querySelector(
    "#id_buscar_orden_servicio"
);
// Agregar listener
boton_buscar_orden_servicio.addEventListener("click", function(e) {
    e.preventDefault();

    var loadingOverlay = document.getElementById("loading-overlay");
    limpiarCampos();

    loadingOverlay.style.display = "flex";

    const id_orden = document.getElementById("id_orden_servicio").value;

    const data = { id_orden };
    const myHeader = new Headers({
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
            "content"
        ),
        'Content-Type': 'application/json'
    });

    fetch(`/reporte/orden`, {
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
            const datos = data.data;

            document.getElementById('id_fecha_recepcion').setAttribute('value', datos.fecha_recepcion);
            document.getElementById('id_fecha_entrega').setAttribute('value', datos.fecha_entrega);
            document.getElementById('id_orden').setAttribute('value', datos.id_orden);
            document.getElementById('id_cliente').setAttribute('value', datos.cliente);
            document.getElementById('id_nit').setAttribute('value', datos.nit);
            document.getElementById('id_direccion').setAttribute('value', datos.direccion);
            document.getElementById('id_contacto').setAttribute('value', datos.contacto);
            document.getElementById('id_email').setAttribute('value', datos.email);
            document.getElementById('id_total_extintores').setAttribute('value', datos.total_extintores);

            /* Llenando la tabla */
            let dataTabla = document.getElementById("tbody");
            dataTabla.innerHTML = "";

            Object.values(datos.extintores).forEach(extintor => {
                let tr = document.createElement("tr");

                Object.values(extintor).map(function(text){
                    let td = document.createElement("td")
                    td.textContent = text;
                    tr.appendChild(td)
                })
                dataTabla.appendChild(tr)
            });

            loadingOverlay.style.display = "none";
        })
        .catch(error => {
            limpiarCampos();

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

function limpiarCampos(){
    let nodeListInputReporte = document.querySelectorAll('.limpiarCampos');
    for (let i = 0; i < nodeListInputReporte.length; i++) {
        nodeListInputReporte[i].setAttribute('value', '');
    }

    let dataTabla = document.getElementById("tbody");
    dataTabla.innerHTML = "";
}


function imprimirSeccion() {
    let printContents = document.getElementById('imprimir').innerHTML;

    const style = `
    <style>
        .card-body {
            /* Estilos para el contenido principal de la tarjeta */
            padding: 1rem; /* Espaciado interno alrededor del contenido */
            border: 1px solid rgba(0, 0, 0, 0.125); /* Borde con sombra ligera */
            border-radius: 0.25rem; /* Radio del borde para esquinas redondeadas */
            padding: 0.9375rem 20px;
            position: relative;
        }

        .row {
            display: flex; /* Establece el modelo de caja como flex */
            flex-wrap: wrap; /* Permite que las columnas se envuelvan cuando no caben en la fila */
            margin-right: -15px; /* Compensación para los márgenes negativos de las columnas */
            margin-left: -15px; /* Compensación para los márgenes negativos de las columnas */
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 30.333333%;

            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 10px;
            padding-left: 10px;
        }

        .col-md-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .d-flex {
            display: flex; /* Establece el modelo de caja como flex */
        }

        .justify-content-end {
            justify-content: flex-end; /* Alinea el contenido a la derecha */
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .my-2 {
            margin-top: 0.5rem;    /* Establece el margen superior en 0.5 rem */
            margin-bottom: 0.5rem; /* Establece el margen inferior en 0.5 rem */
        }

        .card-title {
            font-weight: bold; /* Establece el grosor de la fuente en negrita */
        }

        .text-center {
            text-align: center; /* Centro el texto horizontalmente */
        }

        .font-weight-bold {
            font-weight: bold; /* Establece el grosor de la fuente en negrita */
        }

        .text-white {
            color: white; /* Establece el color del texto en blanco */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table-bordered {
            border: 1px solid #dee2e6; /* Establece un borde de 1px sólido */
            border-collapse: separate; /* Separa las celdas de la tabla */
            border-spacing: 0; /* Establece el espacio entre las celdas a 0 */
        }

        .thead-dark {
            background-color: #343a40; /* Establece un fondo oscuro para el encabezado */
            color: #fff; /* Establece el color del texto en el encabezado */
        }

        td, th {
            font-size: 1.063rem;
            border: 1px solid #ddd; /* Establece un borde de 1 píxel sólido */
            padding: 8px; /* Agrega espacio interno a las celdas */
        }

        .form-control[disabled], fieldset[disabled] .form-control, .form-group .form-control[disabled], fieldset[disabled] .form-group .form-control {
            background-color: transparent;
            cursor: not-allowed;
            border-bottom: 1px dotted #d2d2d2;
            background-repeat: no-repeat;
        }

        .bmd-form-group .form-control, .bmd-form-group label, .bmd-form-group input::placeholder {
            line-height: 1.1;
        }

        fieldset[disabled][disabled] .form-control, .form-control.disabled, .form-control:disabled, .form-control[disabled] {
            background-image: linear-gradient(to right, #d2d2d2 0%, #d2d2d2 30%, transparent 30%, transparent 100%);
            /* background-repeat: repeat-x; */
            background-size: 3px 1px;
        }

        .form-control:disabled, .form-control[readonly] {
            /* background-color: #e9ecef; */
            opacity: 1;
        }

        .form-control {
            background: no-repeat center bottom, center calc(100% - 1px);
            background-size: 0 100%, 100% 100%;
            border: 0;
            height: 36px;
            transition: background 0s ease-out;
            padding-left: 0;
            padding-right: 0;
            border-radius: 0;
            font-size: 15px;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.4375rem 0;
            /* font-size: 1rem; */
            /* line-height: 1.5; */
            color: #495057;
            /* background-color: rgba(0, 0, 0, 0); */
            /* background-clip: padding-box; */
            /* border: 1px solid #d2d2d2; */
            /* border-radius: 0; */
            box-shadow: none;
            /* transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; */
        }
    </style>`;

    printContents = style + printContents;

    w = window.open();
    w.document.write(printContents);
    w.document.close(); // necessary for IE >= 10
    w.focus(); // necessary for IE >= 10
    w.print();
    w.close();
    return true;
}
